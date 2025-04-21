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

 namespace Mavik\Thumbnails\Specification\Image;

use Mavik\Thumbnails\Specification\CompositeSpecification;
use Mavik\Thumbnails\Configuration;

class ReplaceToThumbnail extends CompositeSpecification
{   
    public function __construct(Configuration $configuration)
    {
        $hasSuitedClass = new HasSuitedClass($configuration);
        $isInsidePicture = new IsInsidePicture();
        $isNotInsidePicture = $isInsidePicture->not();
        if ($configuration->base()->insideLinkAction() == Configuration\Base::INSIDE_LINK_ACTION_NONE) {
            $isInsideLink = new IsInsideLink($configuration);
            $isNotInsideLink = $isInsideLink->not();
            $specification = $hasSuitedClass->and($isNotInsideLink)->and($isNotInsidePicture);
        } else {
            $specification = $hasSuitedClass->and($isNotInsidePicture);
        }
        parent::__construct($specification);
    }
}
