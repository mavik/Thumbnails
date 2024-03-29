<?php
declare(strict_types=1);

/**
 * PHP Library for replacing images in html to thumbnails.
 *
 * @package Mavik\Thumbnails
 * @author Vitalii Marenkov <admin@mavik.com.ua>
 * @copyright 2023 Vitalii Marenkov
 * @license MIT; see LICENSE
 */

namespace Mavik\Thumbnails;

use Mavik\Image\ImageFactory;
use Mavik\Image\ImageImmutable;
use Mavik\Image\ImageWithThumbnails;
use Mavik\Thumbnails\Configuration\Base as ConfigurationThumbnails;

class ImageProcessor
{
    /** @var ImageFactory */
    private $imageFactory;

    public function __construct(ImageFactory $imageFactory)
    {
        $this->imageFactory = $imageFactory;
    }

    public function replaceToThumbnail(
        \DOMElement $imageTag,
        ConfigurationThumbnails $configurationThumbnails
    ): void {
        $imageWithThumbnails = $this->crateImageWithThumbnails(
            $imageTag,
            $configurationThumbnails->resizeType(),
            $configurationThumbnails->scales()
        );
        $srcset = $this->createScrset($imageWithThumbnails->getThumbnails());
        if(!empty($srcset)) {
            $imageTag->setAttribute('srcset', implode(', ', $srcset));
            $imageTag->setAttribute('sizes', $imageWithThumbnails->getWidth().'px');
        }        
        $defaultThumbnail = $this->selectDefaultThumbnail($imageWithThumbnails);
        $imageTag->setAttribute('src', $defaultThumbnail->getUrl());
        $imageTag->setAttribute('width', (string)$defaultThumbnail->getWidth());
        $imageTag->setAttribute('height', (string)$defaultThumbnail->getHeight());        
    }

    private function crateImageWithThumbnails(
        \DOMElement $imageTag,
        string $resizeType,
        array $thumbnailScails
    ): ImageWithThumbnails {
        $src = $imageTag->getAttribute('src');
        $width = (int)$imageTag->getAttribute('width');
        $height = (int)$imageTag->getAttribute('height');
        return $this->imageFactory->createImageWithThumbnails(
            $src,
            $width,
            $height,
            $resizeType,
            $thumbnailScails
        );
    }
    
    /**
     * @param ImageImmutable[] $thumbnails
     * @return string[]
     */
    private function createScrset(array $thumbnails): array
    {
        $srcset = [];
        foreach ($thumbnails as $thumbnail) {
            $srcset[] = $thumbnail->getUrl() . ' ' . $thumbnail->getWidth() . 'w';
        }
        return $srcset;
    }
    
    private function selectDefaultThumbnail(ImageWithThumbnails $imageWithThumbnails): ImageImmutable
    {
        $thumbnails = $imageWithThumbnails->getThumbnails();
        if (isset($thumbnails[1])) {
            return $thumbnails[1];
        } elseif ($currentThumbnail = current($thumbnails)) {
            return $currentThumbnail;
        } else {
            return $imageWithThumbnails;
        }
    }
}
