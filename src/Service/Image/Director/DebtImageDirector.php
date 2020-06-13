<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Service\Image\Director;

use App\Service\Image\Builder\Interfaces\DebtImageBuilderInterface;
use App\ValueObject\Image;

/**
 * Class DebtImageDirector
 */
class DebtImageDirector
{
    /**
     * @var DebtImageBuilderInterface
     */
    private DebtImageBuilderInterface $builder;

    /**
     * DebtImageDirector constructor.
     *
     * @param DebtImageBuilderInterface $builder
     */
    public function __construct(DebtImageBuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return Image
     */
    public function create(): Image
    {
        return $this->builder
            ->buildBackgroundLayer()
            ->buildDebtAmountLayer()
            ->getImage()
        ;
    }
}
