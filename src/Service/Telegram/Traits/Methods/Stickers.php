<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Service\Telegram\Traits\Methods;

use App\DTO\Telegram\Method\CreateNewStickerSet;

/**
 * Trait Stickers
 */
trait Stickers
{
    /**
     * @param CreateNewStickerSet $method
     *
     * @return void
     */
    public function createNewStickerSet(CreateNewStickerSet $method): void
    {
        $this->post('createNewStickerSet', $method);
    }
}
