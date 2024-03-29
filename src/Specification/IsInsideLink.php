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

class IsInsideLink
{
    public function __invoke(\DOMElement $imageTag): bool
    {
        $parentNode = $imageTag;
        while ($parentNode = $parentNode->parentNode) {
            if (
                isset($parentNode->tagName)
                && $parentNode->tagName == 'a'
                && $parentNode->hasAttribute('href')
            ) {
                return true;
            }
        }
        return false;
    }
}
