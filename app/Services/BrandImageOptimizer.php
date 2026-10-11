<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class BrandImageOptimizer
{
    /**
     * Return an absolute path to a cached, downscaled copy of the given public-disk
     * image, generating it on first use. Ideal for embedding brand images in emails
     * without shipping the full-size upload.
     *
     * Falls back to the original path when the source cannot be processed.
     */
    public static function forEmail(string $relativePath, int $size = 128): ?string
    {
        $disk = Storage::disk('public');
        $source = $disk->path($relativePath);

        if (! is_file($source)) {
            return null;
        }

        if (! function_exists('imagecreatefromstring') || ! function_exists('imagepng')) {
            return $source;
        }

        $info = @getimagesize($source);

        if ($info === false) {
            return $source;
        }

        // Already small enough — reuse the original instead of duplicating it.
        if ($info[0] <= $size && $info[1] <= $size) {
            return $source;
        }

        $targetRelative = 'favicon/optimized/'.sha1($relativePath.'|'.filemtime($source).'|'.$size).'.png';
        $target = $disk->path($targetRelative);

        if (is_file($target)) {
            return $target;
        }

        $contents = @file_get_contents($source);

        if ($contents === false) {
            return $source;
        }

        $image = @imagecreatefromstring($contents);

        if ($image === false) {
            return $source;
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $ratio = min($size / $width, $size / $height);
        $newWidth = max(1, (int) round($width * $ratio));
        $newHeight = max(1, (int) round($height * $ratio));

        $canvas = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefilledrectangle($canvas, 0, 0, $newWidth, $newHeight, $transparent);
        imagecopyresampled($canvas, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $directory = dirname($target);

        if (! is_dir($directory)) {
            @mkdir($directory, 0775, true);
        }

        imagepng($canvas, $target, 9);

        imagedestroy($canvas);
        imagedestroy($image);

        return is_file($target) ? $target : $source;
    }
}
