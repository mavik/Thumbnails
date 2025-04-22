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

class Image
{
    /** @var \DOMElement */
    private $domElement;
    
    /** @var float */
    private $width;
    
    /** @var string */
    private $widthUnit;

    /** @var float */
    private $height;

    /** @var string */
    private $heightUnit;

    /** @var bool */
    private $isSizeChanged = true;
    
    /** @var bool */
    private $isWidthInStyle = false;

    /** @var bool */
    private $isHeightInStyle = false;
    
    /** @var bool */
    private $isSizeInPixels = false;

    public function __construct(\DOMElement $domElement)
    {
        $this->domElement = $domElement;
    }
    
    public function getSrc(): string
    {
        return $this->domElement->getAttribute('src');
    }

    public function getWidth(): float
    {
        $this->initSize();
        return $this->width;
    }
    
    public function getWidthUnit(): string
    {
        $this->initSize();
        return $this->widthUnit;
    }

    public function getHeight(): float
    {
        $this->initSize();
        return $this->height;
    }
    
    public function getHeightUnit(): string
    {
        $this->initSize();
        return $this->heightUnit;
    }
    
    public function isSizeInPixels(): bool
    {
        $this->initSize();
        return $this->isSizeInPixels;
    }
    
    public function isWidthInStyle(): bool
    {
        $this->initSize();
        return $this->isWidthInStyle;
    }
    
    public function isHeightInStyle(): bool
    {
        $this->initSize();
        return $this->isHeightInStyle;
    }

    public function getAttribute(string $name): string
    {
        return $this->domElement->getAttribute($name);
    }
    
    public function hasAttribute(string $name): bool
    {
        return $this->domElement->hasAttribute($name);
    }

    public function getParentNode(): \DOMNode
    {
        return $this->domElement->parentNode;
    }

    public function setSrcset(array $srcset): void
    {
        $this->domElement->setAttribute('srcset', implode(', ', $srcset));
    }

    public function setSrc(string $src): void
    {
        $this->domElement->setAttribute('src', $src);
        $this->isSizeChanged = true;
    }

    public function setWidth(float $width): void
    {
        $this->domElement->setAttribute('width', (string)$width);
        $this->isSizeChanged = true;
    }

    public function setHeight(float $height): void
    {
        $this->domElement->setAttribute('height', (string)$height);
        $this->isSizeChanged = true;
    }

    private function initSize(): void
    { 
        if (!$this->isSizeChanged) {
            return;
        }

        $this->isSizeInPixels = true;
        
        list($this->width, $this->widthUnit) = $this->numberValueFromAttribute('width');        
        list($this->height, $this->heightUnit) = $this->numberValueFromAttribute('height');
        
        if ($this->domElement->hasAttribute('style')) {
            $style = $this->domElement->getAttribute('style');
            list($widthInStyle, $widthUnitInStyle) = $this->numberValueFromStyle('width', $style);
            if ($widthInStyle && isset($widthUnitInStyle)) {
                $this->isWidthInStyle = true;
                $this->width = $widthInStyle;
                $this->widthUnit = $widthUnitInStyle;
            }
            list($heightInStyle, $heightUnitInStyle) = $this->numberValueFromStyle('height', $style);
            if (isset($heightInStyle) && isset($heightUnitInStyle)) {
                $this->isHeightInStyle = true;
                $this->height = $heightInStyle;
                $this->heightUnit = $heightUnitInStyle;
            }
        }
        
        $this->isSizeInPixels =
            (!isset($this->width) || $this->widthUnit == 'px')
            && (!isset($this->height) || $this->heightUnit == 'px')
        ;

        $this->isSizeChanged = false;
    }
    
    /**
     * @return array [?float <value>, ?string <unit>]
     */
    private function numberValueFromAttribute(string $name): array
    {
        if (!$this->hasAttribute($name)) {
            return [null, null];
        }
        $attribute = $this->getAttribute($name);
        $numberReg = '\d+|\d*\.\d+';
        if (preg_match("/($numberReg)\s*(.*)/i", $attribute, $matches)) {
            $value = (float)$matches[1];
            $unit = strtolower(trim($matches[2])) ?: 'px';
        } else {
            $value = null;
            $unit = null;
        }
        return [
            $value,
            $unit,
        ];
    }
    
    /**
     * @return array [?float <value>, ?string <unit>]
     */
    private function numberValueFromStyle(string $property, string $style): array
    {
        $numberReg = '\d+|\d*\.\d+';
        if (preg_match("/\b{$property}\s*:\s*($numberReg)\s*([a-zA-Z\%]+)/si", $style, $matches)) {
            $value = (float)$matches[1];
            $unit = strtolower(trim($matches[2]));            
        } else {
            $value = null;
            $unit = null;
        }        
        return [
            $value,
            $unit,
        ];
    }
}
