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
    
    /** @var float */
    private $width;
    
    /** @var string */
    private $widthUnit;

    /** @var float */
    private $height;

    /** @var string */
    private $heightUnit;
    
    /** @var bool */
    private $isWidthInStyle = false;

    /** @var bool */
    private $isHeightInStyle = false;
    
    /** @var bool */
    private $isSizeInPixels = false;

    public function __construct(\DOMElement $domElement)
    {
        $this->domElement = $domElement;
        $this->initSize();
    }
    
    public function getSrc(): string
    {
        return $this->domElement->getAttribute('src');
    }

    public function getWidth(): float
    {
        return $this->width;
    }
    
    public function getWidthUnit(): string
    {
        return $this->widthUnit;
    }

    public function getHeight(): float
    {
        return $this->height;
    }
    
    public function getHeightUnit(): string
    {
        return $this->heightUnit;
    }
    
    public function isSizeInPixels()
    {
        return $this->isSizeInPixels;
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
    }
    
    /**
     * @return array [?float <value>, ?string <unit>]
     */
    private function numberValueFromAttribute(string $name): array
    {
        $attribute = $this->hasAttribute($name) ? $this->getAttribute($name) : null;
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
