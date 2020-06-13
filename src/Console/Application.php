<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Console;

use App\Kernel;
use Symfony\Component\Console\Application as BaseApplication;

/**
 * Class Application
 */
class Application extends BaseApplication
{
    /**
     * Application constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct($name, Kernel::VERSION);
    }
}
