<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Exception\Publisher;

/**
 * Class PublishingException
 */
class PublishingException extends \RuntimeException
{
    protected $message = 'publisher.publishing';
}
