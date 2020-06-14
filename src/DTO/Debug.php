<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\DTO;

use App\ValueObject\File;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class Debug
 */
class Debug
{
    /**
     * @var File|null
     *
     * @Serializer\Type("App\ValueObject\File")
     * @Serializer\SerializedName("file")
     */
    public ?File $file = null;
}
