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
namespace Mavik\Thumbnails;

use Mavik\Image\ImageFactory;
use Mavik\Image\Configuration as ImageConfiguration;
use Mavik\Thumbnails\Html\Document;
use Mavik\Thumbnails\Html\Image;
use Mavik\Thumbnails\Specification\Image\ReplaceToThumbnail as ReplaceToThumbnailSpecification;
use Mavik\Thumbnails\Specification\Image\UseDefaultSize as UseDefaultSizeSpecification;

class Thumbnails
{   
    /** @var \SplObjectStorage */
    private $actions;
    
    public function __construct(Configuration $configuration)
    {
        $this->actions = new \SplObjectStorage();
        $this->addActionDefaultSize($configuration);
        $this->addActionPopUp('GLightbox');
        $this->addActionReplaceToThumbnail($configuration);        
    }

    private function addActionDefaultSize(Configuration $configuration): void
    {
        $action = new Action\UseDefaultSize($configuration);
        $this->actions[$action] = new UseDefaultSizeSpecification($configuration);
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

    private function addActionPopUp(string $library): void
    {
        $actionClass = '\\Mavik\\Thumbnails\\Action\\PopUp\\' . $library;
        $action = new $actionClass();
        $this->actions[$action] = new Specification\Image\AddPopUp();
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
