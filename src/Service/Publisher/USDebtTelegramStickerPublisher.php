<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Service\Publisher;

use App\Exception\Publisher\PublishingException;
use App\Service\Common\UnicodeConverter;
use App\Service\Image\ImageResizer;
use App\Service\Image\Resizer\TelegramStickerResizer;
use App\Service\Publisher\Interfaces\DebtImagePublisher;
use App\ValueObject\Image;
use Symfony\Component\Filesystem\Filesystem;
use TuriBot\Client;

/**
 * Class USDebtTelegramStickerPublisher
 */
class USDebtTelegramStickerPublisher implements DebtImagePublisher
{
    private Client $client;

    private UnicodeConverter $unicodeConverter;

    private Filesystem $fs;

    private TelegramStickerResizer $stickerResizer;

    private int $userId;

    private string $setName;

    private string $emojis;

    /**
     * TelegramStickerUSDebtImagePublisher constructor.
     *
     * @param Client                 $client
     * @param UnicodeConverter       $unicodeConverter
     * @param Filesystem             $fs
     * @param TelegramStickerResizer $stickerResizer
     * @param int                    $userId
     * @param string                 $setName
     * @param string                 $emojis
     */
    public function __construct(Client $client, UnicodeConverter $unicodeConverter, Filesystem $fs, TelegramStickerResizer $stickerResizer, int $userId, string $setName, string $emojis)
    {
        $this->client = $client;
        $this->unicodeConverter = $unicodeConverter;
        $this->fs = $fs;
        $this->stickerResizer = $stickerResizer;
        $this->userId = $userId;
        $this->setName = $setName;
        $this->emojis = $emojis;
    }

    /**
     * @param Image $image
     *
     * @throws \ImagickException
     */
    public function publish(Image $image): void
    {
        $image = $this->stickerResizer->resize($image);
        $pathname = $this->fs->tempnam('/tmp', 'us_debt_telegram_sticker_');

        $stickers = $this->client->getStickerSet($this->setName)->result->stickers;

        $result = $this->client->addStickerToSet(
            $this->userId,
            $this->setName,
            new \CURLFile($image->copy(dirname($pathname), basename($pathname))->getPathname()),
            null,
            $this->unicodeConverter->unicodeToSymbol($this->emojis)
        );

        if (true !== $result->ok) {
            throw new PublishingException('Image upload error');
        }

        foreach ($stickers as $sticker) {
            $this->client->deleteStickerFromSet($sticker->file_id);
        }
    }
}
