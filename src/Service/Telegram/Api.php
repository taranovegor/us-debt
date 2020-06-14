<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Service\Telegram;

use App\Service\Telegram\Traits\Http;
use App\Service\Telegram\Traits\Methods;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class Api
 */
class Api
{
    use Http,
        Methods\Stickers;

    /**
     * Api constructor.
     *
     * @param string              $apiToken
     * @param HttpClientInterface $httpClient
     */
    public function __construct(string $apiToken, HttpClientInterface $httpClient)
    {
        $this->apiToken = $apiToken;
        $this->httpClient = $httpClient;
    }
}
