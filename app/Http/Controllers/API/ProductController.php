<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SimpleProductResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\RamSpec;
use App\Models\GpuSpec;
use App\Models\CpuSpec;
use App\Models\CoolerSpec;
use App\Models\CaseSpec;
use App\Models\PsuSpec;
use App\Models\MouseSpec;
use App\Models\DisplaySpec;
use App\Models\StorageSpec;
use App\Models\KeyboardSpec;
use App\Models\MotherboardSpec;

class ProductController extends BaseController
{

    private const CATEGORY_TO_SPEC_MAP = [
        1 => 'ramSpec',
        2 => 'gpuSpec',
        3 => 'cpuSpec',
        4 => 'motherboardSpec',
        5 => 'storageSpec',
        6 => 'psuSpec',
        7 => 'caseSpec',
        8 => 'coolerSpec',
        9 => 'displaySpec',
        10 => 'keyboardSpec',
        11 => 'mouseSpec'
    ];

    private const SPEC_FIELDS_MAP = [
        1 => ['speed', 'latency', 'memory', 'memory_type'],
        2 => ['memory', 'memory_type', 'core_clock', 'boost_clock', 'consumption', 'length'],
        3 => ['socket', 'core_count', 'thread_count', 'base_clock', 'boost_clock', 'consumption', 'integrated_graphics'],
        4 => ['socket', 'chipset', 'form_factor', 'memory_max', 'memory_slots', 'memory_type', 'memory_speed', 'sata_ports', 'm_2_slots', 'pcie_slots', 'usb_ports', 'lan', 'audio', 'wifi', 'bluetooth'],
        5 => ['type', 'capacity', 'rpm', 'read_speed', 'write_speed'],
        6 => ['efficiency_rating', 'wattage', 'modular', 'fanless'],
        7 => ['case_type', 'form_factor_support', 'tempered_glass', 'expansion_slots', 'max_gpu_length', 'max_cpu_cooler_height', 'radiator_support', 'extra_fans_connectors', 'width', 'height', 'depth', 'weight'],
        8 => ['type', 'fan_rpm', 'consumption', 'socket_support', 'width', 'height'],
        9 => ['resolution', 'refresh_rate', 'response_time', 'panel_type', 'aspect_ratio', 'curved', 'brightness', 'contrast_ratio', 'sync_type', 'hdmi_ports', 'display_ports', 'inches', 'weight'],
        10 => ['type', 'switch_type', 'width', 'height', 'weight'],
        11 => ['dpi', 'sensor', 'buttons', 'bluetooth', 'weight'],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'brand'])->get();

        return $this->sendResponse(SimpleProductResource::collection($products), 'Products retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateProductRequest $request)
    {
        DB::beginTransaction();

        try {
            $imageUrl = 'https://res.cloudinary.com/dlmbw4who/image/upload/v1743097241/product-placeholder_jcgqx4.png';
            if ($request->hasFile('image')) {
                $imageUrl = Cloudinary::upload(
                    $request->file('image')->getRealPath(),
                    [
                        'folder' => 'bossloot/product-images',
                    ]
                )->getSecurePath();
            }

            // Create the product
            $product = new Product([
                'name' => $request->name,
                'description' => $request->description,
                'model' => $request->model,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'on_offer' => $request->on_offer,
                'discount' => $request->discount,
                'featured' => $request->featured,
                'image' => $imageUrl,
                'points' => $request->points,
            ]);

            // Attach the category and brand to the product
            $categoryId = $request->category_id;
            $brandId = $request->brand_id;

            $product->category()->associate($categoryId);
            $product->brand()->associate($brandId);
            $product->save();

            // Get the spec method name based on the category ID
            $specMethod = self::CATEGORY_TO_SPEC_MAP[$product->category_id] ?? null;

            // Check if the spec method exists and is callable
            if ($specMethod && method_exists($product, $specMethod)) {
                // Get only fillable fields from related model (getRelated() returns the related model)
                // $product->{$specMethod}() calls the function using the value saved in the $specMethod variable
                $specData = $request->only(
                    $product->{$specMethod}()->getRelated()->getFillable()
                );

                // Create related record with automatic FK assignment
                $product->{$specMethod}()->create($specData);
            } else {
                DB::rollBack();
                return $this->sendError('Invalid category or missing specs.');
            }

            DB::commit();

            return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating product: ' . $e->getMessage());
            return $this->sendError('Failed to create product.', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['category', 'brand'])->find($id);

        if ($product == null) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    /**
     * Show products that are either featured or added in the last 7 days.
     */
    public function showFeatured()
    {
        $products = Product::with(['category', 'brand'])
            ->where(function ($query) {
                $query->where('featured', 1)
                    ->orWhere('created_at', '>=', now()->subDays(7));
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->sendResponse(SimpleProductResource::collection($products), 'Latest products retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::find($id);

        if ($product == null) {
            return $this->sendError('Product not found.');
        }

        DB::beginTransaction();

        try {
            $this->updateProductGeneralSpecs($request, $product);
            $this->updateProductTechnicalSpecs($request, $product);

            DB::commit();
            return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Failed to update product.', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the general specifications of the product.
     */
    private function updateProductGeneralSpecs(UpdateProductRequest $request, Product $product)
    {
        // Update the product image if a new one is provided
        if ($request->hasFile('image')) {
            $this->deleteOldProductPicture($product->image);

            $product->image = Cloudinary::upload(
                $request->file('image')->getRealPath(),
                [
                    'folder' => 'bossloot/product-images',
                ]
            )->getSecurePath();
        }

        $product->fill($request->only([
            'name',
            'description',
            'model',
            'price',
            'quantity',
            'on_offer',
            'discount',
            'featured',
            'points'
        ]));

        if ($request->has('category_id')) {
            $product->category()->associate($request->category_id);
        }
        if ($request->has('brand_id')) {
            $product->brand()->associate($request->brand_id);
        }

        $product->save();
    }

    /**
     * Delete the old product image from Cloudinary.
     */
    protected function deleteOldProductPicture(?string $url): void
    {
        // Dont delete the default image
        $defaultImage = 'https://res.cloudinary.com/dlmbw4who/image/upload/v1743097241/product-placeholder_jcgqx4.png';

        if (empty($url) || $url === $defaultImage) {
            return;
        }

        try {
            $publicId = $this->extractPublicIdFromUrl($url);

            if ($publicId) {
                Cloudinary::destroy($publicId);
            }
        } catch (\Exception $e) {
            \Log::error("Error deleting old product picture: " . $e->getMessage());
        }
    }

    /**
     * Extract public ID from Cloudinary URL.
     */
    protected function extractPublicIdFromUrl(string $url): ?string
    {
        $pattern = '/upload\/(?:v\d+\/)?([^\.]+)/';
        preg_match($pattern, $url, $matches);

        return $matches[1] ?? null;
    }

    private function updateProductTechnicalSpecs(UpdateProductRequest $request, Product $product)
    {

        $specMethod = self::CATEGORY_TO_SPEC_MAP[$product->category_id] ?? null;

        if (!$specMethod || !method_exists($product, $specMethod)) {
            throw new \Exception('Invalid product category');
        }

        $specModel = $product->{$specMethod}()->firstOrNew();

        $this->updateSpecificSpecs($product->category_id, $request, $specModel);
    }

    private function updateSpecificSpecs(int $categoryId, UpdateProductRequest $request, $specModel)
    {
        $fieldsToUpdate = self::SPEC_FIELDS_MAP[$categoryId] ?? null;

        if ($fieldsToUpdate) {
            $data = $request->only($fieldsToUpdate);

            $specModel->fill($data);
            $specModel->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if ($product == null) {
            return $this->sendError('Product not found.');
        }

        $product->delete();
        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
