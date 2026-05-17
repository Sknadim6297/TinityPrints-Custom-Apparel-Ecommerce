<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageOptimizer
{
    public const VARIANT_THUMB = 'thumb';

    public const VARIANT_CARD = 'card';

    public const VARIANT_LARGE = 'large';

    public const VARIANT_FULL = 'full';

  /** @var array<string, int> */
    private const WIDTHS = [
        self::VARIANT_THUMB => 150,
        self::VARIANT_CARD => 520,
        self::VARIANT_LARGE => 960,
        self::VARIANT_FULL => 0,
    ];

    public static function url(?string $path, string $variant = self::VARIANT_CARD): string
    {
        if (empty($path)) {
            return '';
        }

        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        if ($variant === self::VARIANT_FULL || ! self::canOptimize()) {
            return Storage::url($path);
        }

        $maxWidth = self::WIDTHS[$variant] ?? self::WIDTHS[self::VARIANT_CARD];
        $cachedPath = self::cachedPath($path, $maxWidth);

        if ($cachedPath === null) {
            return Storage::url($path);
        }

        return Storage::url($cachedPath);
    }

    public static function warmVariants(?string $path): void
    {
        if (empty($path) || ! self::canOptimize()) {
            return;
        }

        foreach ([self::VARIANT_THUMB, self::VARIANT_CARD, self::VARIANT_LARGE] as $variant) {
            self::url($path, $variant);
        }
    }

    private static function canOptimize(): bool
    {
        return extension_loaded('gd') && function_exists('imagecreatetruecolor');
    }

    private static function cachedPath(string $sourcePath, int $maxWidth): ?string
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($sourcePath)) {
            return null;
        }

        $extension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
        $cacheExtension = in_array($extension, ['png', 'gif', 'webp'], true) ? $extension : 'jpg';
        $cachePath = 'cache/images/'.$maxWidth.'/'.md5($sourcePath).'.'.$cacheExtension;

        if ($disk->exists($cachePath)) {
            return $cachePath;
        }

        $sourceFullPath = $disk->path($sourcePath);
        $cacheFullPath = $disk->path($cachePath);
        $cacheDir = dirname($cacheFullPath);

        if (! is_dir($cacheDir) && ! mkdir($cacheDir, 0755, true) && ! is_dir($cacheDir)) {
            return null;
        }

        if (! self::resizeToFile($sourceFullPath, $cacheFullPath, $maxWidth, $cacheExtension)) {
            return null;
        }

        return $cachePath;
    }

    private static function resizeToFile(string $source, string $destination, int $maxWidth, string $extension): bool
    {
        $info = @getimagesize($source);

        if ($info === false) {
            return false;
        }

        [$width, $height, $type] = $info;

        if ($width <= 0 || $height <= 0) {
            return false;
        }

        if ($width <= $maxWidth) {
            return copy($source, $destination);
        }

        $newWidth = $maxWidth;
        $newHeight = (int) round($height * ($newWidth / $width));

        $sourceImage = self::createImageFromType($source, $type);

        if (! $sourceImage) {
            return false;
        }

        $targetImage = imagecreatetruecolor($newWidth, $newHeight);

        if (in_array($extension, ['png', 'gif'], true)) {
            imagealphablending($targetImage, false);
            imagesavealpha($targetImage, true);
            $transparent = imagecolorallocatealpha($targetImage, 0, 0, 0, 127);
            imagefilledrectangle($targetImage, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled(
            $targetImage,
            $sourceImage,
            0,
            0,
            0,
            0,
            $newWidth,
            $newHeight,
            $width,
            $height
        );

        $saved = self::saveImage($targetImage, $destination, $extension);

        imagedestroy($sourceImage);
        imagedestroy($targetImage);

        return $saved;
    }

    /**
     * @return resource|\GdImage|false|null
     */
    private static function createImageFromType(string $path, int $type)
    {
        return match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($path),
            IMAGETYPE_PNG => @imagecreatefrompng($path),
            IMAGETYPE_GIF => @imagecreatefromgif($path),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            default => false,
        };
    }

    /**
     * @param resource|\GdImage $image
     */
    private static function saveImage($image, string $destination, string $extension): bool
    {
        return match ($extension) {
            'png' => imagepng($image, $destination, 6),
            'gif' => imagegif($image, $destination),
            'webp' => function_exists('imagewebp') ? imagewebp($image, $destination, 82) : false,
            default => imagejpeg($image, $destination, 82),
        };
    }
}
