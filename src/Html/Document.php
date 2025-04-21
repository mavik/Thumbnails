<?php
declare(strict_types=1);

/**
 * PHP Library for replacing images in html to thumbnails.
 *
 * @package Mavik\Thumbnails
 * @author Vitalii Marenkov <admin@mavik.com.ua>
 * @copyright 2023 Vitalii Marenkov
 * @license GNU General Public License version 2 or later; see LICENSE
 */

namespace Mavik\Thumbnails\Html;

use Masterminds\HTML5;

class Document
{
    /** 
     * @var HTML5
     */
    private $parser;
    
    /** @var \DOMDocument */
    private $dom;
    
    /** @var bool */
    private $isFragment = false;

    /** @var \DOMXPath */
    private $xpath;

    public static function create(string $htmlDocument): self
    {
        return new self($htmlDocument);
    }

    public static function createFragment(string $htmlFragment): self
    {
        return new self($htmlFragment, true);
    }


    /**
     * @throws \InvalidArgumentException
     * @throws Exception
     */
    private function __construct(string $html, bool $isFragment = false)
    {
        if ($isFragment) {
            $this->isFragment = true;
            $html = "<!DOCTYPE html><html><body>{$html}</body></html>";
        }
        if (PHP_VERSION_ID >= 84000) {
            // Since PHP 8.4 HTML5 is supported natively
            $this->dom = new \DOMDocument();
            $this->dom->loadHTML($html);
        } else {
            $this->parser = new HTML5(['disable_html_ns' => true]);
            $this->dom = $this->parser->loadHTML($html);
        }
        $this->xpath = new \DOMXPath($this->dom);
    }

    /**
     * 
     * @return \Generator<Image>
     */
    public function findImages(): \Generator
    {
        foreach ($this->xpath->query('//img') as $imageElement) {
            yield new Image($imageElement);
        }
    }
    
    /**
     * @throws Exception
     */
    public function __toString(): string
    {
        if ($this->isFragment) {
            $body = $this->dom->saveHTML(
                $this->dom->getElementsByTagName('body')->item(0)
            );
            $result = preg_replace(['#^<body>#i', '#</body>$#i'], ['', ''], $body);
        } else {
            $result = $this->dom->saveHTML();
        }
        if ($result === false) {
            throw new \Exception('Cannot convert DOMDocument to string');
        }
        return $result;        
    }
}
