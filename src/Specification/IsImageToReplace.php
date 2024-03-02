<?php
declare(strict_types=1);

/*
 *  PHP Library for Image processing and creating thumbnails
 *  
 *  @package Mavik\Image
 *  @author Vitalii Marenkov <admin@mavik.com.ua>
 *  @copyright 2021 Vitalii Marenkov
 *  @license MIT; see LICENSE
 */
namespace Mavik\Thumbnails\Specification;

use Mavik\Thumbnails\Configuration;

/**
 * Description of IsImageToReplace
 *
 * @author mavik
 */
class IsImageToReplace
{
    public function __invoke(\DOMElement $imageTag, Configuration $confuguration): bool
    {
        $classAtr = $imageTag->getAttribute('class');
        preg_match_all('/(\w+)/', $classAtr, $matches, PREG_PATTERN_ORDER);
        $classes = $matches[1];
        $includeClasses = $confuguration->base()->includeClasses();
        $excludeClasses = $confuguration->base()->excludeClasses();
        return
            (empty($includeClasses) || !empty(array_intersect($classes, $includeClasses)))
            && (empty($excludeClasses) || empty(array_intersect($classes, $excludeClasses)))
        ;
    }
}