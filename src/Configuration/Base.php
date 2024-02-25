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

class Base
{
    /** @var string */
    private $resizeType;
    
    /** @var float[] */
    private $scales;
    
    /** @var string[] */
    private $includeClasses;
    
    /** @var string[] */
    private $excludeClasses;

    public function __construct(
        string $resizeType = 'Stretch',
        array $scales = [1],
        array $includeClasses = [],
        array $excludeClasses = []
    ) {
        $this->resizeType = $resizeType;
        $this->scales = $scales;
        $this->includeClasses = $includeClasses;
        $this->excludeClasses = $excludeClasses;
    }

    public function resizeType(): string
    {
        return $this->resizeType;
    }

    /** @return float[] */
    public function scales(): array
    {
        return $this->scales;
    }
    
    /** @return string[] */
    public function includeClasses(): array
    {
        return $this->includeClasses;
    }

    /** @return string[] */
    public function excludeClasses(): array
    {
        return $this->excludeClasses;
    }
}
