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
    public function __invoke(\DOMElement $imgTag): bool
    {
        return
            isset($imgTag->tagName)
            && $imgTag->tagName == 'a'
        ;
    }

}
