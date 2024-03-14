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

namespace Mavik\Thumbnails\Html;

class Image
{
    /** @var \DOMElement */
    private $domElement;
    
    /** @var int */
    private $width;

    /** @var int */
    private $height;
    
    /** @var bool */
    private $isSizeInStyle;

    /** @var bool */
    private $isSizeInPixels;
    
    public function __construct(\DOMElement $domElement)
    {
        $this->domElement = $domElement;
        $this->initSize();
    }
    
    public function getSrc(): string
    {
        return $this->domElement->getAttribute('src');
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }
    
    public function isSizeInPixels(): bool
    {
        return $this->isSizeInPixels;
    }

    public function isSizeInStyle(): bool
    {
        return $this->isSizeInStyle;
    }

    public function getAttribute(string $name): string
    {
        return $this->domElement->getAttribute($name);
    }
    
    public function hasAttribute(string $name): bool
    {
        return $this->domElement->hasAttribute($name);
    }


    private function initSize(): void
    {
        $this->isSizeInPixels = false;
        
        if ($this->domElement->hasAttribute('style')) {
            $style = $this->domElement->getAttribute('style');
            list($widthInStyle, $widthUnitInStyle) = $this->intValueFromStyle('width', $style);
            list($heightInStyle, $heightUnitInStyle) = $this->intValueFromStyle('height', $style);
            if (isset($widthInStyle) && $widthUnitInStyle || isset($heightInStyle) && $heightUnitInStyle) {
                $this->isSizeInPixels =
                    (!isset($widthInStyle) || $widthUnitInStyle == 'px')
                    && (!isset($heightInStyle) || $heightUnitInStyle = 'px')
                ;
                $this->width = $widthInStyle;
                $this->height = $heightInStyle;
                return;
            }
        }
        
        list($this->width, $widthUnit) = $this->intValueFromAttribute('width');
        list($this->height, $heightUnit) = $this->intValueFromAttribute('height');
        $this->isSizeInPixels =
            (!isset($widthUnit) || $widthUnit == 'px')
            && (!isset($heightUnit) || $heightUnit == 'px')
        ;        
    }
    
    /**
     * @return array [<value>, <unit>]
     */
    private function intValueFromAttribute(string $name): array
    {
        $attribute = $this->hasAttribute($name) ? $this->getAttribute($name) : null;
        if (preg_match("/(\d*[\.\,]?\d*)\s*(.*)/i", $attribute, $matches)) {
            $value = (int)round($matches[1]);
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
    
    /**
     * @return array [<value>, <unit>]
     */
    private function intValueFromStyle(string $property, string $style): array
    {
        if (preg_match("/(?<!\-)\b{$property}\s*:\s*(\d*[\.\,]?\d*)\s*([\w\%]+)/si", $style, $matches)) {
            $value = (int)round($matches[1]);
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
