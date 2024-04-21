<?php
declare(strict_types=1);

/*
 *  PHP Library for Image processing and creating thumbnails
 *  
 *  @package Mavik\Thumbnails
 *  @author Vitalii Marenkov <admin@mavik.com.ua>
 *  @copyright 2024 Vitalii Marenkov
 *  @license MIT; see LICENSE
 */
namespace Mavik\Thumbnails\Specification;

use Mavik\Thumbnails\Configuration;

class ApplyReplaceToThumbnail extends Specification
{
    /** @var Specification */
    private $isImage;
    
    /** @var HasSuitedClass */
    private $hasSuitedClass;
        
    /** @var IsInsideLink */
    private $isInsideLink;   

    public function __construct(Configuration $configuration)
    {
        parent::__construct($configuration);
        $this->isImage = new IsImage($configuration);
        $this->hasSuitedClass = new HasSuitedClass($configuration);
        $this->isInsideLink = new IsInsideLink($configuration);
    }
    
    public function __invoke(\DOMElement $element): bool
    {
        return
            $this->isImage($element)
            && $this->hasSuitedClass($element)
            && (                
                $this->configuration->base()->insideLinkAction() == Configuration\Base::INSIDE_LINK_ACTION_ALL
                || $this->configuration->base()->insideLinkAction() == Configuration\Base::INSIDE_LINK_ACTION_RESIZE
                || !$this->isInsideLink($element)
            )
        ;
    }

}
