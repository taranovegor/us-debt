<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\ValueObject;

use Decimal\Decimal;

/**
 * Class Money
 */
class Money
{
    /**
     * @var Decimal
     */
    private Decimal $price;

    /**
     * Money constructor.
     *
     * @param float|null $amount
     */
    public function __construct(float $amount = null)
    {
        $decimal = new Decimal(bcdiv(bcmul($amount ?? 0, 100, 2), 100, 2));
        $this->price = $decimal->round(2, Decimal::ROUND_DOWN);
    }

    /**
     * @param float $amount
     *
     * @return static
     */
    public static function createFromBanknotes(float $amount): self
    {
        return new static($amount);
    }

    /**
     * @param int $amount
     *
     * @return static
     */
    public static function createFromCoins(int $amount): self
    {
        return new static($amount / 100);
    }

    /**
     * @return int
     */
    public function toCoins(): int
    {
        return (clone $this->price)->mul(100)->toInt();
    }

    /**
     * @return float
     */
    public function toBanknotes(): float
    {
        return $this->price->toFloat();
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->price->toString();
    }
}
