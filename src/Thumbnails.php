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
            $serverConfiguration->graphicLibraryPriority()
        );
        $imageFactory = new ImageFactory($imageConfiguration);                
        $action = new Action\ReplaceToThumbnail($imageFactory, $configuration->base());
        $this->actions[$action] = new Specification\ApplyReplaceToThumbnail($configuration);
    }

    /**
     * Replace images in html to thumbnails.
     * 
     * @throws Exception
     */
    public function __invoke(string $html): Result
    {
        $jsAndCss = new JsAndCss();
        $document = Document::createFragment($html);
        foreach ($document->findImages() as $imageTag) {
            $jsAndCss->merge($this->doActions($imageTag));
        }
        return new Result((string)$document, $jsAndCss);
    }
    
    private function doActions(\DOMElement $imgTag): JsAndCss
    {
        $jsAndCss = new JsAndCss();
        foreach ($this->actions as $action => $specification) {
            if ($specification($imgTag)) {
                $jsAndCss->merge($action($imgTag));
            }
        }
        return $jsAndCss;
    }
}
