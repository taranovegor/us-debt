<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Exception\Image\Builder;

/**
 * Class WrongSequenceOfConstructionStepsException
 */
class WrongSequenceOfConstructionStepsException extends \LogicException
{
    protected $message = 'image.builder.wrong_sequence_of_construction_steps';
}
