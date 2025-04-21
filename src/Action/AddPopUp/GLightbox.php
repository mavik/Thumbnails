<?php
declare(strict_types=1);

/**
 * PHP Library for replacing images in html to thumbnails.
 *
 * @package Mavik\Thumbnails
 * @author Vitalii Marenkov <admin@mavik.com.ua>
 * @copyright 2023 Vitalii Marenkov
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Mavik\Thumbnails\Action;

use Mavik\Thumbnails\ActionInterface;
use Mavik\Thumbnails\Html\Image;
use Mavik\Thumbnails\JsAndCss;

class AddPopUp implements ActionInterface
{
    /**
     * Change $image and add JS and CSS to $jsAndCss.
     */
    public function __invoke(Image $image, JsAndCss $jsAndCss): void{
        $jsAndCss->addJs('glightbox/js/glightbox.min.js');
        $jsAndCss->addCss('glightbox/css/glightbox.min.css');
    }
}