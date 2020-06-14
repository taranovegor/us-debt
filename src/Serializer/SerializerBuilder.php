<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Serializer;

use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\SerializerBuilder as BaseSerializerBuilder;
use JMS\Serializer\SerializerInterface;

/**
 * Class SerializerBuilder
 */
class SerializerBuilder
{
    private BaseSerializerBuilder $serializerBuilder;

    private array $subscribingHandlers = [];

    /**
     * SerializerBuilder constructor.
     *
     * @param BaseSerializerBuilder $serializerBuilder
     */
    public function __construct(BaseSerializerBuilder $serializerBuilder)
    {
        $this->serializerBuilder = $serializerBuilder;
    }

    /**
     * @param SubscribingHandlerInterface $handler
     *
     * @return void
     */
    public function addSubscribingHandler(SubscribingHandlerInterface $handler): void
    {
        $this->subscribingHandlers[] = $handler;
    }

    /**
     * @return SerializerBuilder
     */
    public static function create(): SerializerBuilder
    {
        return new static(BaseSerializerBuilder::create());
    }

    /**
     * @return SerializerInterface
     */
    public function build(): SerializerInterface
    {
        foreach ($this->subscribingHandlers as $handler) {
            $this->serializerBuilder->configureHandlers(
                fn(HandlerRegistry $r) => $r->registerSubscribingHandler($handler)
            );
        }

        return $this->serializerBuilder->build();
    }
}
