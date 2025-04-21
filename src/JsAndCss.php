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
namespace Mavik\Thumbnails;

class JsAndCss
{
    private $js = [];
    private $css = [];
    
    public function addJs(string $js): void
    {
        $this->js[$js] = true;
    }
    
    public function addCss(string $css): void
    {
        $this->css[$css] = true;
    }
    
    /** @return string[] */
    public function js(): array
    {
        return array_keys($this->js);
    }

    /** @return string[] */
    public function css(): array
    {
        return array_keys($this->css);
    }
    
    public function merge(self $jsAndCss): void
    {
        $this->js = array_merge($this->js, $jsAndCss->js);
        $this->css = array_merge($this->css, $jsAndCss->css);
    }
}
