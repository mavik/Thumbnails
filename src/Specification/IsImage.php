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

class IsImage
{
    public function __invoke(\DOMElement $tag): bool
    {
        return
            isset($tag->tagName)
            && $tag->tagName == 'img'
            && !empty($tag->getAttribute('src'))
        ;
    }

}
