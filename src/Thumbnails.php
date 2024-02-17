<?php
/**
 * PHP Library for replacing images in html to thumbnails.
 *
 * @package Mavik\Thumbnails
 * @author Vitalii Marenkov <admin@mavik.com.ua>
 * @copyright 2023 Vitalii Marenkov
 * @license MIT; see LICENSE
 */
namespace Mavik\Thumbnails;

class Thumbnails
{
    /**@var Configuration */
    private $configuration;

    /** @var ImageProcessor */
    private $imageProcessor;
    
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $imageFactory = new ImageFactory(
            $configuration->server()->baseUrl(),
            $configuration->server()->webRootDir()
        );
        $this->imageProcessor = new ImageProcessor($imageFactory);
    }

    /**
     * Replace images in html to thumbnails.
     * 
     * @throws Exception
     */
    public function process(string $html, $params): string
    {
        $document = new HtmlDocument($html);
        foreach ($document->findImages() as $image) {
            $this->imageProcessor->replaceToThumbnail($image, $params);
        }
        return (string)$document;
    }
}
