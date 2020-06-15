<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Command\Publisher;

use App\Command\Traits\CommandInformationTrait;
use App\Service\Image\Builder\USDebtImageBuilder;
use App\Service\Image\Director\DebtImageDirector;
use App\Service\Publisher\USDebtTelegramStickerPublisher;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * Class PublishUSDebtTelegramStickerCommand
 */
class PublishUSDebtTelegramStickerCommand extends Command
{
    use CommandInformationTrait;

    public const STOPWATCH_EVENT_NAME = 'publisher.publish_us_debt_telegram_sticker_command';

    private USDebtImageBuilder $imageBuilder;

    private USDebtTelegramStickerPublisher $stickerPublisher;

    private Stopwatch $stopwatch;

    /**
     * PublishUsDebtTelegramStickerCommand constructor.
     *
     * @param USDebtImageBuilder             $imageBuilder
     * @param USDebtTelegramStickerPublisher $imagePublisher
     * @param Stopwatch                      $stopwatch
     */
    public function __construct(USDebtImageBuilder $imageBuilder, USDebtTelegramStickerPublisher $imagePublisher, Stopwatch $stopwatch)
    {
        parent::__construct();
        $this->imageBuilder = $imageBuilder;
        $this->stickerPublisher = $imagePublisher;
        $this->stopwatch = $stopwatch;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setName('app:publisher:publish_us_debt_telegram_sticker')
            ->setDescription('Update US Debt telegram sticker')
        ;
    }

    /**
     * @inheritDoc
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->stopwatch->start(self::STOPWATCH_EVENT_NAME);
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getCommandInfo($this->getName()));

        try {
            $this->stickerPublisher->publish((new DebtImageDirector($this->imageBuilder))->create());
        } catch (\Throwable $e) {
            $output->writeln('<error>An error occurred during execution</error>');
            throw new RuntimeException($e->getMessage());
        }

        $output->writeln($this->getExecutionInfo($this->stopwatch->getEvent(self::STOPWATCH_EVENT_NAME)));

        return 0;
    }
}
