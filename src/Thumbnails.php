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
use Mavik\Thumbnails\Html\Document;
use Mavik\Thumbnails\Html\Image;
use Mavik\Thumbnails\Specification\Image\ReplaceToThumbnail as ReplaceToThumbnailSpecification;

class Thumbnails
{   
    /** @var \SplObjectStorage */
    private $actions;
    
    public function __construct(Configuration $configuration)
    {
        $this->actions = new \SplObjectStorage();
        $this->addActionReplaceToThumbnail($configuration);   
    }
    
    private function addActionReplaceToThumbnail(Configuration $configuration): void
    {
        $serverConfiguration = $configuration->server();
        $imageConfiguration = new ImageConfiguration(
            $serverConfiguration->baseUrl(),
            $serverConfiguration->webRootDir(),
            $serverConfiguration->thumbnailsDir(),
            $serverConfiguration->graphicLibraryPriority()
        );
        $imageFactory = new ImageFactory($imageConfiguration);                
        $action = new Action\ReplaceToThumbnail($imageFactory, $configuration);
        $this->actions[$action] = new ReplaceToThumbnailSpecification($configuration);
    }

    /**
     * Replace images in html to thumbnails.
     * 
     * @throws Exception
     */
    public function __invoke(string $html): Result
    {
        $document = Document::createFragment($html);
        $jsAndCss = new JsAndCss();
        foreach ($document->findImages() as $imageTag) {
            $this->doActions($imageTag, $jsAndCss);
        }
        return new Result((string)$document, $jsAndCss);
    }
    
    private function doActions(Image $imgTag, JsAndCss $jsAndCss): void
    {
        while ($this->actions->valid()) {
            $specification = $this->actions->getInfo();
            if ($specification->isSatisfiedBy($imgTag)) {
                $action = $this->actions->current();
                $action($imgTag, $jsAndCss);
            }
            $this->actions->next();
        }
    }
}
