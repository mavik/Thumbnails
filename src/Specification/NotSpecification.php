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

class NotSpecification extends Specification
{
    private $specification;

    public function __construct(Specification $specification, Configuration $configuration)
    {
        parent::__construct($configuration);
        $this->specification = $specification;
    }

    public function __invoke(\DOMElement $element): bool
    {
        return !$this->specification->__invoke($element);
    }
}