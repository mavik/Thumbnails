<?php
declare(strict_types=1);

/*
 *  PHP Library for Image processing and creating thumbnails
 *  
 *  @package Mavik\Image
 *  @author Vitalii Marenkov <admin@mavik.com.ua>
 *  @copyright 2021 Vitalii Marenkov
 *  @license MIT; see LICENSE
 */
namespace Mavik\Thumbnails\Configuration;

class Server
{
    /** @var string */
    private $baseUrl;
    
    /** @var string */
    private $webRootDir;
    
    /** @var array */
    private $graphicLibraryPriority;

    public function __construct(
        string $baseUrl,
        string $webRootDir,
        array $graphicLibraryPriority = null
    ) {
        $this->baseUrl = $baseUrl;
        $this->webRootDir = $webRootDir;
        $this->graphicLibraryPriority = $graphicLibraryPriority;
    }
    
    public function baseUrl(): string
    {
        return $this->baseUrl;
    }

    public function webRootDir(): string
    {
        return $this->webRootDir;
    }
    
    public function graphicLibraryPriority(): array
    {
        return $this->graphicLibraryPriority;
    }
}
