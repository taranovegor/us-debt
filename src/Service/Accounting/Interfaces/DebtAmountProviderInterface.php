<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Service\Accounting\Interfaces;

use App\ValueObject\Money;

/**
 * Interface DebtAmountProviderInterface
 */
interface DebtAmountProviderInterface
{
    /**
     * @return Money
     */
    public function provide(): Money;
}
