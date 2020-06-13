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
 */
class DebtDataDTO
{
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("data_date")
     */
    public string $dataDate;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("debt_held_public_amt")
     */
    public string $debtHeldByThePublic;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("intragov_hold_amt")
     */
    public string $intragovernmentalHoldings;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("tot_pub_debt_out_amt")
     */
    public string $totalPublicDebtOutstanding;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("reporting_calendar_year")
     */
    public string $calendarYear;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("reporting_calendar_month")
     */
    public string $calendarMonthNumber;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("reporting_calendar_day")
     */
    public string $calendarDayNumber;
}
