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

use Mavik\Thumbnails\Html\Image as HtmlImage;

class IsInsidePicture extends Image
{
    protected function isSatisfiedByImage(HtmlImage $image): bool
    {
        $parentNode = $image->getDomElement()->parentNode;
        return 
            $parentNode instanceof \DOMElement
            && $parentNode->tagName === 'picture'
        ;
    }
}
