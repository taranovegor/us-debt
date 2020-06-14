<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Service\Telegram\Traits;

use App\DTO\Telegram\Interfaces\MethodDTOInterface;
use App\DTO\Telegram\Interfaces\UploadableMethodDTOInterface;
use JMS\Serializer\ArrayTransformerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

/**
 * Trait Http
 */
trait Http
{
    protected string $baseUrl;

    protected string $apiToken;

    protected HttpClientInterface $httpClient;

    protected ArrayTransformerInterface $arrayTransformer;

    /**
     * @param string             $endpoint
     * @param MethodDTOInterface $method
     *
     * @return ResponseInterface
     *
     * @throws TransportExceptionInterface
     */
    public function post(string $endpoint, MethodDTOInterface $method): object
    {
        $body = $this->buildBody($method);
        if ($this->isMultipart($method)) {
            $body = new FormDataPart($body);
        }

        $response = $this->httpClient->request('POST', $this->completeUrl($endpoint), [
            'body' => $body,
        ]);

        if (200 !== $response->getStatusCode()) {

        }
    }

    /**
     * @param string $endpoint
     *
     * @return string
     */
    protected function completeUrl(string $endpoint): string
    {
        $charList = " \t\n\r\0\x0B\\/";

        return rtrim($this->baseUrl, $charList).'/bot'.$this->apiToken.'/'.ltrim($endpoint, $charList);
    }

    /**
     * @param MethodDTOInterface $method
     *
     * @return bool
     */
    protected function isMultipart(MethodDTOInterface $method): bool
    {
        return $method instanceof UploadableMethodDTOInterface;
    }

    /**
     * @param MethodDTOInterface $method
     *
     * @return array
     */
    protected function buildBody(MethodDTOInterface $method): array
    {
        $array = $this->arrayTransformer->toArray($method);

        if ($method instanceof UploadableMethodDTOInterface) {
            foreach ($method->getUploadableProperty() as $property) {
                if (null === $array[$property]) {
                    continue;
                }

                $array[$property] = DataPart::fromPath($array[$property]);
            }
        }

        return $array;
    }
}
