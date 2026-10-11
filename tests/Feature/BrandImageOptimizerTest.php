<?php

namespace Tests\Feature;

use App\Services\BrandImageOptimizer;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BrandImageOptimizerTest extends TestCase
{
    public function test_it_downscales_a_large_image_for_email(): void
    {
        Storage::fake('public');

        $image = imagecreatetruecolor(1254, 1254);
        imagefilledrectangle($image, 0, 0, 1254, 1254, imagecolorallocate($image, 20, 40, 80));
        ob_start();
        imagepng($image);
        $bytes = (string) ob_get_clean();
        imagedestroy($image);

        Storage::disk('public')->put('favicon/logo.png', $bytes);

        $path = BrandImageOptimizer::forEmail('favicon/logo.png');

        $this->assertNotNull($path);
        $this->assertFileExists($path);

        $info = getimagesize($path);
        $this->assertLessThanOrEqual(128, max($info[0], $info[1]));
        $this->assertStringContainsString('favicon/optimized', str_replace('\\', '/', $path));
    }

    public function test_it_returns_null_when_the_image_is_missing(): void
    {
        Storage::fake('public');

        $this->assertNull(BrandImageOptimizer::forEmail('favicon/missing.png'));
    }

    public function test_it_reuses_the_original_when_already_small(): void
    {
        Storage::fake('public');

        $image = imagecreatetruecolor(64, 64);
        ob_start();
        imagepng($image);
        $bytes = (string) ob_get_clean();
        imagedestroy($image);

        Storage::disk('public')->put('favicon/small.png', $bytes);

        $path = BrandImageOptimizer::forEmail('favicon/small.png');

        $this->assertSame(Storage::disk('public')->path('favicon/small.png'), $path);
    }
}
