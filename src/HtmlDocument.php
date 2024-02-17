<?php
/**
 * PHP Library for replacing images in html to thumbnails.
 *
 * @package Mavik\Thumbnails
 * @author Vitalii Marenkov <admin@mavik.com.ua>
 * @copyright 2023 Vitalii Marenkov
 * @license MIT; see LICENSE
 */

namespace Mavik\Thumbnails;

class HtmlDocument
{
    /** @var \DOMDocument */
    private $dom;
    
    /** @var \DOMXPath */
    private $xpath;

    /**
     * @param string $html
     * @throws \InvalidArgumentException
     * @throws Exception
     */
    public function __construct(string $html)
    {
        $this->dom = $this->parseHtml($html);
        $this->xpath = new \DOMXPath($this->dom);
    }

    public function findImages(): \DOMNodeList
    {        
        return $this->xpath->query('//img');          
    }
    
    /**
     * @throws \InvalidArgumentException
     */
    private function parseHtml(string $html): \DOMDocument
    {
        $document = new \DOMDocument('1.0', 'UTF-8');
        if ($document->loadHTML($html, LIBXML_HTML_NOIMPLIED|LIBXML_HTML_NODEFDTD)) {
            return $document;
        }
        throw new \InvalidArgumentException('Cannot load argument as HTML');
    }
    
    /**
     * @throws Exception
     */
    public function __toString(): string
    {
        $result = $this->dom->saveHTML();
        if ($result === false) {
            throw new Exception('Cannot convert DOMDocument to string');
        }
        return $result;        
    }
}
