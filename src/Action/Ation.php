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

namespace Mavik\Thumbnails\Action;

use Mavik\Thumbnails\Specification\Specification;
use Mavik\Thumbnails\JsAndCss;

abstract class Ation
{
    /**
     * Change $element
     * and return JavaScripts and CSS that must be added to HTML document
     */
    abstract public function __invoke(\DOMElement $element): JsAndCss;
}
