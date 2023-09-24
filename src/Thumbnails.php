<?php
/**
 * PHP Library for replacing images in html to thumbnails.
 *
 * @package Mavik\Image
 * @author Vitalii Marenkov <admin@mavik.com.ua>
 * @copyright 2023 Vitalii Marenkov
 * @license MIT; see LICENSE
 */
namespace Mavik\Thumbnails;

class Thumbnails
{    
    private $imageProcessor;
    
    public function __construct()
    {
        $this->imageProcessor = new ImageProcessor();
    }

    /**
     * Replace images in html to thumbnails.
     * 
     * @throws Exception
     */
    public function process(string $html): string
    {
        $document = $this->parseHtml($html);
        foreach ($this->findImages($document) as $image) {
            $this->imageProcessor->process($image);
        }
        return $this->toString($document);
    }

    /**
     * @throws Exception
     */
    private function parseHtml(string $html): \DOMDocument
    {
        $document = new \DOMDocument('1.0', 'UTF-8');
        if ($document->loadHTML($html, LIBXML_HTML_NOIMPLIED|LIBXML_HTML_NODEFDTD)) {
            return $document;
        }
        throw new Exception('Cannot load argument as HTML');
    }
    
    private function findImages(\DOMDocument $document): \DOMNodeList
    {
        $xpath = new \DOMXPath($document);
        return $xpath->query('//img');        
    }

    /**
     * @throws Exception
     */
    private function toString(\DOMDocument $document): string
    {
        $result = $document->saveHTML();
        if ($result === false) {
            throw new Exception('Cannot save result as HTML');
        }
        return $result;        
    }
}
