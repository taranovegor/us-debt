<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\DTO\Telegram\Method;

use App\DTO\Telegram\Interfaces\UploadableMethodDTOInterface;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class CreateNewStickerSetDTO
 */
class CreateNewStickerSet implements UploadableMethodDTOInterface
{
    /**
     * @Serializer\Type("int")
     * @Serializer\SerializedName("user_id")
     */
    public ?int $userId = null;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("name")
     */
    public ?string $name = null;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("title")
     */
    public ?string $title = null;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("png_sticker")
     */
    public ?string $pngSticker = null;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("emojis")
     */
    public ?string $emojis = null;

    /**
     * @inheritDoc
     */
    public function getUploadableProperty(): array
    {
        return [
            'png_sticker',
        ];
    }
}
