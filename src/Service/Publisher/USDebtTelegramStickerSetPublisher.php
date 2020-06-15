<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Service\Publisher;

use App\Service\Common\UnicodeConverter;
use App\Service\Image\ImageResizer;
use App\Service\Image\Resizer\TelegramStickerResizer;
use App\Service\Publisher\Interfaces\DebtImagePublisher;
use App\ValueObject\Image;
use Symfony\Component\Filesystem\Filesystem;
use TuriBot\Client;

/**
 * Class USDebtTelegramStickerSetPublisher
 */
class USDebtTelegramStickerSetPublisher implements DebtImagePublisher
{
    private Client $client;

    private UnicodeConverter $unicodeConverter;

    private Filesystem $fs;

    private TelegramStickerResizer $stickerResizer;

    private int $userId;

    private string $setName;

    private string $setTitle;

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
     * @param string                 $setTitle
     * @param string                 $emojis
     */
    public function __construct(Client $client, UnicodeConverter $unicodeConverter, Filesystem $fs, TelegramStickerResizer $stickerResizer, int $userId, string $setName, string $setTitle, string $emojis)
    {
        $this->client = $client;
        $this->unicodeConverter = $unicodeConverter;
        $this->fs = $fs;
        $this->stickerResizer = $stickerResizer;
        $this->userId = $userId;
        $this->setName = $setName;
        $this->setTitle = $setTitle;
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
        $pathname = $this->fs->tempnam('/tmp', 'us_debt_telegram_sticker_set_');

        $this->client->createNewStickerSet(
            $this->userId,
            $this->setName,
            $this->unicodeConverter->unicodeString($this->setTitle),
            new \CURLFile($image->copy(dirname($pathname), basename($pathname))->getPathname()),
            null,
            $this->unicodeConverter->unicodeToSymbol($this->emojis)
        );
    }
}
