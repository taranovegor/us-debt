<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Command\Traits;

use Symfony\Component\Stopwatch\StopwatchEvent;

/**
 * Class CommandInformationTrait
 */
trait CommandInformationTrait
{
    /**
     * @param string $name
     *
     * @return string
     */
    public function getCommandInfo(string $name): string
    {
        return sprintf('<info>Command %s started at %s</info>', $name, (new \DateTime())->format('c'));
    }

    /**
     * @param StopwatchEvent $event
     *
     * @return string
     */
    public function getExecutionInfo(StopwatchEvent $event): string
    {
        $event = (clone $event)->stop();

        return sprintf(
            '<info>Execution time: %.3F seconds, Memory usage: %.0F MB</info>',
            $event->getDuration() / 1000,
            $event->getMemory() / 1000000
        );
    }
}
