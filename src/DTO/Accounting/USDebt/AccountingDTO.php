<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\DTO\Accounting\USDebt;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class AccountingDTO
 */
class AccountingDTO
{
    /**
     * @var DebtDataDTO[]
     *
     * @Serializer\Type("array<App\DTO\Accounting\USDebt\DebtDataDTO>")
     * @Serializer\SerializedName("data")
     */
    public array $data = [];
}
