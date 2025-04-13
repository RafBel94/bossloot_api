<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\BrandRequest;
use App\Http\Controllers\API\BaseController;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BrandController extends BaseController
{
    public function index()
    {
        $brands = Brand::all();

        return $this->sendResponse($brands, 'Brands retrieved successfully.');
    }

    public function store(BrandRequest $request)
    {
        DB::beginTransaction();

        try {
            $imageUrl = 'https://res.cloudinary.com/dlmbw4who/image/upload/v1744482271/brand-placeholder_loirll.png';
            if ($request->hasFile('image')) {
                $imageUrl = Cloudinary::upload(
                    $request->file('image')->getRealPath(),
                    [
                        'folder' => 'bossloot/brand-images',
                    ]
                )->getSecurePath();
            }

            $brand = new Brand($request->all());
            $brand->image = $imageUrl;
            $brand->save();

            DB::commit();

            return $this->sendResponse($brand, 'Brand created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Brand creation failed: ' . $e->getMessage());
            return $this->sendError('Brand creation failed: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        if ($id == 1) {
            return $this->sendError("It's not possible to show the default brand", [], 403);
        }

        $brand = Brand::find($id);

        if ($brand == null) {
            return $this->sendError('Brand not found.');
        }

        return $this->sendResponse($brand, 'Brand retrieved successfully.');
    }

    public function update(BrandRequest $request, $id)
    {
        $brand = Brand::find($id);

        if ($brand == null) {
            return $this->sendError('Brand not found.');
        }

        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $this->deleteOldImage($brand->image);

                $brand->image = Cloudinary::upload(
                    $request->file('image')->getRealPath(),
                    [
                        'folder' => 'bossloot/brand-images',
                    ]
                )->getSecurePath();
            }

            $brand->fill($request->except('image'));
            $brand->save();

            DB::commit();
            return $this->sendResponse($brand, 'Brand updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Brand update failed: ' . $e->getMessage());
            return $this->sendError('Brand update failed: ' . $e->getMessage());
        }
    }

    /**
     * Delete the old brand image from Cloudinary.
     */
    protected function deleteOldImage(?string $url): void
    {
        // Dont delete the default image
        $defaultImage = 'https://res.cloudinary.com/dlmbw4who/image/upload/v1744482271/brand-placeholder_loirll.png';

        if (empty($url) || $url === $defaultImage) {
            return;
        }

        try {
            $publicId = $this->extractPublicIdFromUrl($url);

            if ($publicId) {
                Cloudinary::destroy($publicId);
            }
        } catch (\Exception $e) {
            \Log::error("Error deleting old brand picture: " . $e->getMessage());
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

    public function destroy($id)
    {
        if ($id == 1) {
            return $this->sendError("It's not possible to delete the default brand", [], 403);
        }

        $brand = Brand::find($id);

        if ($brand == null) {
            return $this->sendError('Brand not found.');
        }

        $brand->delete();

        return $this->sendResponse([], 'Brand deleted successfully.');
    }
}
