<?php
declare(strict_types=1);

/**
 * PHP Library for replacing images in html to thumbnails.
 *
 * @package Mavik\Thumbnails
 * @author Vitalii Marenkov <admin@mavik.com.ua>
 * @copyright 2023 Vitalii Marenkov
 * @license GNU General Public License version 2 or later; see LICENSE
 */

namespace Mavik\Thumbnails\Action;

use Mavik\Image\ImageFactory;
use Mavik\Image\ImageImmutable;
use Mavik\Image\ImageWithThumbnails;
use Mavik\Thumbnails\Configuration;
use Mavik\Thumbnails\Html\Image;
use Mavik\Thumbnails\JsAndCss;

class ReplaceToThumbnail implements ActionInterface
{
    /** @var ImageFactory */
    private $imageFactory;
    
    /** @var Configuration */
    private $configuration;

    public function __construct(ImageFactory $imageFactory, Configuration $configuration)
    {
        $this->imageFactory = $imageFactory;
        $this->configuration = $configuration;
    }

    public function __invoke(Image $imageTag, JsAndCss $jsAndCss): void
    {
        
        $imageWithThumbnails = $this->crateImageWithThumbnails(
            $imageTag,
            $this->configuration->base()->resizeType(),
            $this->configuration->base()->scales()
        );
        $srcset = $this->createScrset($imageWithThumbnails->getThumbnails());
        if(!empty($srcset)) {
            $imageTag->setSrcset($srcset);
        }        
        $defaultThumbnail = $this->selectDefaultThumbnail($imageWithThumbnails);
        $imageTag->setSrc($defaultThumbnail->getUrl());
        $imageTag->setWidth($defaultThumbnail->getWidth());
        $imageTag->setHeight($defaultThumbnail->getHeight());
    }
    
    private function crateImageWithThumbnails(
        Image $imageTag,
        string $resizeType,
        array $thumbnailScails
    ): ImageWithThumbnails {
        $src = $imageTag->getSrc();
        $width = (int)$imageTag->getWidth();
        $height = (int)$imageTag->getHeight();
        return $this->imageFactory->createImageWithThumbnails(
            $src,
            $width,
            $height,
            $resizeType,
            $this->configuration->server()->thumbnailsDir(),
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
        foreach ($thumbnails as $scale => $thumbnail) {
            $srcset[] = $thumbnail->getUrl() . " {$scale}x";
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
