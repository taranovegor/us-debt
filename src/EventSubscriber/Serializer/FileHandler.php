<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\EventSubscriber\Serializer;

use App\ValueObject\File;
use App\ValueObject\Image;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigatorInterface;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;

/**
 * Class FileHandler
 */
class FileHandler implements SubscribingHandlerInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigatorInterface::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => File::class,
                'method' => 'serializeFileToJson',
            ],
            [
                'direction' => GraphNavigatorInterface::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => Image::class,
                'method' => 'serializeFileToJson',
            ],
        ];
    }

    /**
     * @param JsonSerializationVisitor $visitor
     * @param File                     $file
     * @param array                    $type
     * @param Context                  $context
     *
     * @return string
     */
    public function serializeFileToJson(JsonSerializationVisitor $visitor, File $file, array $type, Context $context): string
    {
        return $file->getPathname();
    }
}
