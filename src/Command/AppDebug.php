<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Command;


use App\DTO\Debug;
use App\ValueObject\File;
use App\ValueObject\Image;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AppDebug
 */
class AppDebug extends Command
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        parent::__construct('app:debug');
        $this->serializer = $serializer;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = new Image('/home/rat/file.png', false);
        $debug = (new Debug());
        $debug->file = $file;

        var_dump($this->serializer->serialize($debug, 'json'));

        return 1;
    }
}
