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

/**
 * Description of creationThumbnails
 *
 * @author mavik
 */
class Thumbnails
{
    /** @var string */
    private $resizeType;
    
    /** @var array */
    private $scales;
    
    public function __construct(
        string $resizeType = 'Stretch',
        array $scales = [1]
    ) {
        $this->resizeType = $resizeType;
        $this->scales = $scales;
    }

    public function resizeType(): string
    {
        return $this->resizeType;
    }

    public function scales(): array
    {
        return $this->scales;
    }
}
