<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Service\Image\Resizer;

use App\Service\Image\ImageResizer;
use App\ValueObject\Image;

/**
 * Class TelegramStickerResizer
 */
class TelegramStickerResizer
{
    private ImageResizer $resizer;

    /**
     * TelegramStickerImageResizer constructor.
     *
     * @param ImageResizer $resizer
     */
    public function __construct(ImageResizer $resizer)
    {
        $this->resizer = $resizer;
    }

    /**
     * @param Image $image
     *
     * @return Image
     *
     * @throws \ImagickException
     */
    public function resize(Image $image): Image
    {
        return $this->resizer->resize($image, 512);
    }
}
