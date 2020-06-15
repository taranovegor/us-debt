<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Service\Publisher\Interfaces;

use App\ValueObject\Image;

/**
 * Interface DebtImagePublisher
 */
interface DebtImagePublisher
{
    /**
     * @param Image $image
     */
    public function publish(Image $image): void;
}
