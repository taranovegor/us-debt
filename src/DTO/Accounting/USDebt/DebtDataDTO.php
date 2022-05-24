<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\DTO\Accounting\USDebt;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class DebtDataDTO
 *
 * @link https://fiscaldata.treasury.gov/datasets/debt-to-the-penny/debt-to-the-penny
 */
class DebtDataDTO
{
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("tot_pub_debt_out_amt")
     */
    public string $totalPublicDebtOutstanding;
}
