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
namespace Mavik\Thumbnails;

use Mavik\Thumbnails\Configuration\Server;
use Mavik\Thumbnails\Configuration\Thumbnails;

class Configuration
{
    /** @var Server */
    private $server;

    /** @var Thumbnails */
    private $thumbnails;
    
    public function __construct(
        Server $server,
        Thumbnails $thumbnails
    ) {
        $this->thumbnails = $thumbnails;
    }
    
    public function server(): Server
    {
        return $this->server;
    }

    public function thumbnails(): Thumbnails
    {
        return $this->thumbnails;
    }
}
