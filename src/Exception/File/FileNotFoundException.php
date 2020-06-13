<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Exception\File;

/**
 * Class FileNotFoundException
 */
class FileNotFoundException extends \InvalidArgumentException
{
    protected $message = 'file.file_not_found';
}
