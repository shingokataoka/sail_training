<?php

namespace App\Providers;

use InterventionImage;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public static function upload($imageFile, $folder)
    {
        $filename = uniqid(rand(). '_');
        $extension = $imageFile->extension();
        $filenameToStore = "{$filename}.{$extension}";
        $path = "public/{$folder}/{$filenameToStore}";

        $resizeImage = InterventionImage::make($imageFile)->fit(1920,1080,)->encode();
        Storage::put($path, $resizeImage);

        return $filenameToStore;
    }
}
