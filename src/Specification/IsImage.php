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

class IsImage extends Specification
{
    public function __invoke(\DOMElement $element): bool
    {
        return
            isset($element->tagName)
            && $element->tagName == 'img'
            && !empty($element->getAttribute('src'))
        ;
    }

}
