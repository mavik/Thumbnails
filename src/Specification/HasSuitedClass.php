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

class HasSuitedClass extends AbstractSpecification
{
    public function __invoke(\DOMElement $imageTag): bool
    {
        $classAtr = $imageTag->getAttribute('class');
        preg_match_all('/(\w+)/', $classAtr, $matches, PREG_PATTERN_ORDER);
        $classes = $matches[1];
        $includeClasses = $this->configuration->base()->includeClasses();
        $excludeClasses = $this->configuration->base()->excludeClasses();
        return
            (empty($includeClasses) || !empty(array_intersect($classes, $includeClasses)))
            && (empty($excludeClasses) || empty(array_intersect($classes, $excludeClasses)))
        ;
    }
}
