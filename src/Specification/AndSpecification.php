<?php
declare(strict_types=1);

/*
 *  PHP Library for Image processing and creating thumbnails
 *  
 *  @package Mavik\Thumbnails
 *  @author Vitalii Marenkov <admin@mavik.com.ua>
 *  @copyright 2024 Vitalii Marenkov
 *  @license MIT; see LICENSE
 */
namespace Mavik\Thumbnails\Specification;

class AndSpecification extends Specification
{
    private $specification1;
    private $specification2;

    public function __construct(Specification $specification1, Specification $specification2, Configuration $configuration)
    {
        parent::__construct($configuration);
        $this->specification1 = $specification1;
        $this->specification2 = $specification2;
    }

    public function __invoke(\DOMElement $element): bool
    {
        return $this->specification1->__invoke($element) && $this->specification2->__invoke($element);
    }
}