<?php
declare(strict_types=1);

/*
 *  PHP Library for Image processing and creating thumbnails
 *  
 *  @package Mavik\Thumbnails
 *  @author Vitalii Marenkov <admin@mavik.com.ua>
 *  @copyright 2024 Vitalii Marenkov
 *  @license GNU General Public License version 2 or later; see LICENSE
 */

namespace Mavik\Thumbnails\Html;

use DOMNode;

class ImageWithLink extends Image
{
    /** @var \DOMElement */
    private $linkDomElement;

    public function __construct(\DOMElement $domElement)
    {
        parent::__construct($domElement);
        $this->linkDomElement = new \DOMElement('a');
        $this->linkDomElement->setAttribute('href', $this->getSrc());
        $this->linkDomElement->setAttribute('class', 'mavik-thumbnails-link');
        $parentNode = $this->domElement->parentNode;
        if ($parentNode) {
            $parentNode->replaceChild($this->linkDomElement, $this->domElement);
        }
        $this->linkDomElement->appendChild($this->domElement);
    }

    public static function createFromImage(Image $image): self
    {
        return new self($image->domElement);
    }

    public function getParentNode(): DOMNode
    {
        return $this->linkDomElement->parentNode;
    }
}