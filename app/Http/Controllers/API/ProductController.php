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

            // Crear el producto
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'model' => $request->model,
                'brand' => $request->brand,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'on_offer' => $request->on_offer,
                'discount' => $request->discount,
                'featured' => $request->featured,
                'image' => $imageUrl,
                'points' => $request->points,
            ]);

            // Dynamically build relation method name (e.g. 'ram' becomes 'ramSpec')
            $specMethod = $product->category . 'Spec';

            if (method_exists($product, $specMethod)) {
                // Get only fillable fields from related model (getRelated() returns the related model)
                // $product->{$specMethod}() calls the function using the value saved in the $specMethod variable
                $specData = $request->only(
                    $product->{$specMethod}()->getRelated()->getFillable()
                );

                // Create related record with automatic FK assignment
                $product->{$specMethod}()->create($specData);
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
            $this->updateProductTechnicalSpecs($request, $id);

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

        $product->name = $request->name;
        $product->description = $request->description;
        $product->category = $request->category;
        $product->model = $request->model;
        $product->brand = $request->brand;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->on_offer = $request->on_offer;
        $product->discount = $request->discount;
        $product->featured = $request->featured;
        $product->points = $request->points;
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

    private function updateProductTechnicalSpecs(UpdateProductRequest $request, int $id)
    {
        $productSpecsModel = $this->getProductSpecsEntity($request->category, $id);


        if ($productSpecsModel) {
            $this->updateSpecificSpecs($request, $productSpecsModel);
        } else {
            return $this->sendError('Invalid category.');
        }
    }

    private function getProductSpecsEntity(string $category, int $id)
    {
        return match ($category) {
            'ram' => RamSpec::where('product_id', $id)->first(),
            'gpu' => GpuSpec::where('product_id', $id)->first(),
            'cpu' => CpuSpec::where('product_id', $id)->first(),
            'motherboard' => MotherboardSpec::where('product_id', $id)->first(),
            'storage' => StorageSpec::where('product_id', $id)->first(),
            'psu' => PsuSpec::where('product_id', $id)->first(),
            'case' => CaseSpec::where('product_id', $id)->first(),
            'cooler' => CoolerSpec::where('product_id', $id)->first(),
            'display' => DisplaySpec::where('product_id', $id)->first(),
            'keyboard' => KeyboardSpec::where('product_id', $id)->first(),
            'mouse' => MouseSpec::where('product_id', $id)->first(),
            default => null,
        };
    }

    private function updateSpecificSpecs(UpdateProductRequest $request, $productSpecsModel)
    {
        // Map the fields to be updated based on the category
        $fieldsMap = [
            'ram' => ['speed', 'latency', 'memory', 'memory_type'],
            'gpu' => ['memory', 'memory_type', 'core_clock', 'boost_clock', 'consumption', 'length'],
            'cpu' => ['socket', 'core_count', 'thread_count', 'base_clock', 'boost_clock', 'consumption', 'integrated_graphics'],
            'motherboard' => ['socket','chipset','form_factor','memory_max','memory_slots','memory_type','memory_speed','sata_ports','m_2_slots','pcie_slots','usb_ports','lan','audio','wifi','bluetooth'],
            'storage' => ['type', 'capacity', 'rpm', 'read_speed', 'write_speed'],
            'psu' => ['efficiency_rating', 'wattage', 'modular', 'fanless'],
            'case' => ['case_type','form_factor_support','tempered_glass','expansion_slots','max_gpu_length','max_cpu_cooler_height','radiator_support','extra_fans_connectors','width','height','depth','weight'],
            'cooler' => ['type', 'fan_rpm', 'consumption', 'socket_support', 'width', 'height'],
            'display' => ['resolution','refresh_rate','response_time','panel_type','aspect_ratio','curved','brightness','contrast_ratio','sync_type','hdmi_ports','display_ports','inches','weight'],
            'keyboard' => ['type', 'switch_type', 'width', 'height', 'weight'],
            'mouse' => ['dpi', 'sensor', 'buttons', 'bluetooth', 'weight'],
        ];

        $category = $request->category;

        // Check if the category exists in the fields map
        if (isset($fieldsMap[$category])) {
            // Update the fields based on the request
            foreach ($fieldsMap[$category] as $field) {
                if ($request->has($field)) {
                    $productSpecsModel->$field = $request->$field;
                }
            }

            // Save the updated model
            $productSpecsModel->save();
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
