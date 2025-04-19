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
        $specification = new HasSuitedClass($configuration);
        $insideLinkAction = $configuration->base()->insideLinkAction();
        if (
            $insideLinkAction != Configuration\Base::INSIDE_LINK_ACTION_ALL
            && $insideLinkAction != Configuration\Base::INSIDE_LINK_ACTION_RESIZE
        ) {
            $isInsideLink = new IsInsideLink($configuration);
            $isNotInsideLink = $isInsideLink->not();
            $specification = $specification->and($isNotInsideLink);
        }
        parent::__construct($specification);
    }
}
