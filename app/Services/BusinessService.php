<?php

namespace App\Services;

use App\Models\Business;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class BusinessService
{
    public function __construct(
        private readonly FileUploadService $fileUploadService
    ) {
    }

    /**
     * @throws Throwable
     */
    public function update(
        Business $business,
        array $data,
        ?UploadedFile $logo = null,
        ?UploadedFile $banner = null
    ): Business {
        $oldLogo = $business->logo_path;
        $oldBanner = $business->banner_path;

        $newLogo = null;
        $newBanner = null;

        try {
            if ($logo !== null) {
                $newLogo = $this->fileUploadService->storeImage(
                    $logo,
                    'businesses/logos'
                );

                $data['logo_path'] = $newLogo;
            }

            if ($banner !== null) {
                $newBanner = $this->fileUploadService->storeImage(
                    $banner,
                    'businesses/banners'
                );

                $data['banner_path'] = $newBanner;
            }

            if ($business->name !== $data['name']) {
                $data['slug'] = $this->generateUniqueSlug(
                    $data['name'],
                    $business
                );
            }

            $business = DB::transaction(
                function () use ($business, $data): Business {
                    $business->update($data);

                    return $business->refresh();
                }
            );
        } catch (Throwable $exception) {
            $this->fileUploadService->delete($newLogo);
            $this->fileUploadService->delete($newBanner);

            throw $exception;
        }

        if ($newLogo !== null) {
            $this->fileUploadService->delete($oldLogo);
        }

        if ($newBanner !== null) {
            $this->fileUploadService->delete($oldBanner);
        }

        return $business;
    }

    private function generateUniqueSlug(
        string $name,
        Business $ignoreBusiness
    ): string {
        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'negocio';
        }

        $slug = $baseSlug;
        $counter = 2;

        while (
            Business::query()
                ->whereKeyNot($ignoreBusiness->getKey())
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}