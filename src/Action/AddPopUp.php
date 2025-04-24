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

use Mavik\Thumbnails\Html\Image;
use Mavik\Thumbnails\JsAndCss;

class AddPopUp implements ActionInterface
{
    private ActionInterface $library;

    public function __construct(string $library)
    {
        $this->library = new PopUp\GLightbox();
    }

    /**
     * Change $image and add JS and CSS to $jsAndCss.
     */
    public function __invoke(Image $image, JsAndCss $jsAndCss): void
    {
        $this->library->__invoke($image, $jsAndCss);
    }
}