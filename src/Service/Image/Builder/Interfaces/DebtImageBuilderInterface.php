<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Service\Image\Builder\Interfaces;

use App\ValueObject\Image;

/**
 * Interface DebtImageBuilderInterface
 */
interface DebtImageBuilderInterface
{
    /**
     * @return $this
     */
    public function buildBackgroundLayer(): self;

    /**
     * @return $this
     */
    public function buildDebtAmountLayer(): self;

    /**
     * @return Image
     */
    public function getImage(): Image;
}
