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
    const INSIDE_LINK_ACTION_NONE = 'none';
    const INSIDE_LINK_ACTION_RESIZE = 'resize';
    const INSIDE_LINK_ACTION_ALL = 'all';
    
    /** @var string */
    private $resizeType;
    
    /** @var float[] */
    private $scales;
    
    /** @var string[] */
    private $includeClasses;
    
    /** @var string[] */
    private $excludeClasses;
    
    private $insideLinkAction;

    public function __construct(
        string $resizeType = 'Stretch',
        array $scales = [1],
        array $includeClasses = [],
        array $excludeClasses = [],
        string $insideLinkAction = self::INSIDE_LINK_ACTION_RESIZE
    ) {
        $this->resizeType = $resizeType;
        $this->scales = $scales;
        $this->includeClasses = $includeClasses;
        $this->excludeClasses = $excludeClasses;
        $this->insideLinkAction = $insideLinkAction;
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
    
    public function insideLinkAction(): string
    {
        return $this->insideLinkAction;
    }
}
