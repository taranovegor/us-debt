<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Service\Image;

use App\ValueObject\Image;

/**
 * Class ImageResizer
 */
class ImageResizer
{
    /**
     * @param Image $image
     *
     * @return Image
     */
    public function resize(Image $image): Image
    {
        return $image;
    }
}
