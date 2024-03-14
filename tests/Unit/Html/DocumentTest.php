<?php
/**
 * PHP Library for replacing images in html to thumbnails.
 *
 * @package Mavik\Thumbnails
 * @author Vitalii Marenkov <admin@mavik.com.ua>
 * @copyright 2023 Vitalii Marenkov
 * @license MIT; see LICENSE
 */

namespace Mavik\Thumbnails\Html;

use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{    
    /**
     * @covers HtmlDocument::findImages
     * @dataProvider htmls
     */
    public function testFindImages(string $html, array $images)
    {
        $document = Document::createFragment($html);        
        foreach ($document->findImages() as $index => $image) {
            $this->assertInstanceOf(Image::class, $image);
            $this->assertEquals($images[$index]['src'], $image->getSrc());
            $this->assertEquals($images[$index]['width'], $image->getWidth());
            $this->assertEquals($images[$index]['heigth'], $image->getHeight());
            $this->assertEquals($images[$index]['inPixels'], $image->isInPixels());
            $this->assertEquals($images[$index]['inStyle'], $image->inStyle());
        }
    }
    
    public function htmls(): array
    {
        return [
            0 => [
                'START adsf <img src="test0" width="10" height="20"> fg sdg
                asfsf asf <div> <img width="20px" height="30 px" src="test1" />
                <p>adssdf sadf <img width="20px" height="30 px" src="test2" style="width: 40px; height: 50 px" />
                <style>font-size: 12px</style>
                <script>alert("TEST")</script>
                FINISH',
                [
                    'src' => 'test0',
                    'width' => 10,
                    'height'=> 20,
                    'inPixels' => true,
                    'inStyle' => false,
                ], [
                    'src' => 'test1',
                    'width' => 20,
                    'height'=> 30,
                    'inPixels' => true,
                    'inStyle' => false,
                ], [
                    'src' => 'test2',
                    'width' => 40,
                    'height'=> 50,
                    'inPixels' => true,
                    'inStyle' => true,
                ]
            ],
        ];
    }
}