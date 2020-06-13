<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Exception\Http;

/**
 * Class InvalidResponseHttpStatusCodeException
 */
class InvalidResponseHttpStatusCodeException extends \RuntimeException
{
    protected $message = 'http.invalid_response_http_status_code';
}
