<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Service\Accounting;

use App\DTO\Accounting\USDebt\AccountingDTO;
use App\Exception\Http\InvalidResponseHttpStatusCodeException;
use App\Service\Accounting\Interfaces\DebtAmountProviderInterface;
use App\ValueObject\Money;
use JMS\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class USDebtAmountProvider
 */
class USDebtAmountProvider implements DebtAmountProviderInterface
{
    private HttpClientInterface $httpClient;

    private string $url;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * USDebtAmountProvider constructor.
     *
     * @param HttpClientInterface $httpClient
     * @param string              $url
     * @param SerializerInterface $serializer
     */
    public function __construct(HttpClientInterface $httpClient, string $url, SerializerInterface $serializer)
    {
        $this->httpClient = $httpClient;
        $this->url = $url;
        $this->serializer = $serializer;
    }

    /**
     * @return Money
     *
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function provide(): Money
    {
        $response = $this->httpClient->request('GET', $this->url);
        if (200 !== $response->getStatusCode()) {
            throw new InvalidResponseHttpStatusCodeException();
        }

        /** @var AccountingDTO $accounting */
        $accounting = $this->serializer->deserialize($response->getContent(), AccountingDTO::class, 'json');

        return Money::createFromBanknotes($accounting->data[0]->totalPublicDebtOutstanding);
    }
}
