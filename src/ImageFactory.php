<?php

namespace Mavik\Thumbnails;

use Mavik\Image\ImageWithThumbnails;
use Mavik\Image\Configuration as ImageConfiguration;

class ImageFactory
{
    public function __construct($baseUrl, $webRootDir)
    {
        $imageConfiguration = new ImageConfiguration(
            $baseUrl,
            $webRootDir
        );
        ImageWithThumbnails::configure($imageConfiguration);
    }

    public function create(
        string $src,
        int $thumbnailWidth,
        int $thumbnailHeight,
        string $resizeType,
        array $thumbnailScails
    ): ImageWithThumbnails {
        $thumbnailSize = new ImageSize($thumbnailWidth, $thumbnailHeight);
        return ImageWithThumbnails::create($src, $thumbnailSize, $resizeType, $thumbnailScails);
    }
}
