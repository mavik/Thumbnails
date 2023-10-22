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

use PHPUnit\Framework\TestCase;

class HtmlDocumentTest extends TestCase
{       
    /**
     * @covers HtmlDocument::findImages
     * @dataProvider htmls
     */
    public function testFindImages(string $html, array $src)
    {
        $document = new HtmlDocument($html);
        foreach ($document->findImages() as $index => $image) {
            $this->assertInstanceOf(\DOMElement::class, $image);
            $this->assertEquals('img', $image->nodeName);
            $this->assertEquals($src[$index], $image->getAttribute('src'));            
        }
    }
    
    public function htmls(): array
    {
        return [
            0 => [
                'dfadsf <p>adsf <img src="test0" width="10" height="20"> fg sdg
                asfsf asf <div> <img width="10" height="20" src="test1" />',
                ['test0', 'test1']
            ],
        ];
    }
}