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
     * @param Image    $image
     *
     * @param int      $width
     * @param int|null $height
     *
     * @return Image
     *
     * @throws \ImagickException
     */
    public function resize(Image $image, int $width, int $height = null): Image
    {
        $resized = new \Imagick($image->getPathname());
        $resized->resizeImage(
            $width,
            $height ?? (int) $resized->getImageHeight() / ($resized->getImageWidth() / $width),
            \Imagick::FILTER_CATROM,
            1,
            true
        );
        $resized->writeImage($image->getPathname());

        return $image;
    }
}
