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
use Mavik\Image\Configuration as ImageConfiguration;

class Thumbnails
{
    /**@var Configuration */
    private $configuration;

    /** @var ImageProcessor */
    private $imageProcessor;
    
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $serverConfiguration = $configuration->server();
        $imageConfiguration = new ImageConfiguration(
            $serverConfiguration->baseUrl(),
            $serverConfiguration->webRootDir(),
            $serverConfiguration->graphicLibraryPriority()
        );
        $imageFactory = new ImageFactory($imageConfiguration);
        $this->imageProcessor = new ImageProcessor($imageFactory);
    }

    /**
     * Replace images in html to thumbnails.
     * 
     * @throws Exception
     */
    public function __invoke(string $html): string
    {
        $document = new HtmlDocument($html);
        foreach ($document->findImages() as $imageTag) {
            if ($this->isImageToReplace($imageTag)) {
                $this->imageProcessor->replaceToThumbnail($imageTag, $this->configuration->base());
            }
        }
        return (string)$document;
    }
    
    private function isImageToReplace(\DOMElement $imageTag): bool
    {
        return true;
    }
}
