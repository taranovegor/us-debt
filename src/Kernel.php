<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App;

use App\DependencyInjection\Console\ContainerCommandLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Dotenv\Dotenv;

/**
 * Class Kernel
 */
class Kernel
{
    public const VERSION = '1.0.0';

    private string $app;

    private string $env;

    private string $appPath;

    private ?Container $container = null;

    /**
     * Kernel constructor.
     *
     * @param string $app
     * @param string $appPath
     */
    public function __construct(string $app, string $appPath)
    {
        $this->app = $app;
        $this->appPath = $appPath;
    }

    /**
     * @return string
     */
    public function getApp(): string
    {
        return $this->app;
    }

    /**
     * @return string
     */
    public function getAppPath(): string
    {
        return $this->appPath;
    }

    /**
     * @return string
     */
    public function getEnv(): string
    {
        return $this->env;
    }

    /**
     * @return string
     */
    public function getConfigPath(): string
    {
        return $this->getAppPath().'/config';
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function run()
    {
        return $this->__call('run', func_get_args());
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->getApplication(), $name], $arguments);
    }

    /**
     * @return Container
     *
     * @throws \Exception
     */
    protected function getContainer(): Container
    {
        if (false === $this->hasBooted()) {
            $this->buildContainer();
        }

        return $this->container;
    }

    /**
     * @return bool
     */
    protected function hasBooted(): bool
    {
        return $this->container instanceof Container;
    }

    /**
     * @return void
     */
    protected function loadEnvironment(): void
    {
        (new Dotenv())->loadEnv($this->getAppPath().'/.env');
        $this->env = $_ENV['APP_ENV'];
    }

    /**
     * @return void
     *
     * @throws \Exception
     */
    protected function buildContainer(): void
    {
        if ($this->hasBooted()) {
            return;
        }

        $this->container = new ContainerBuilder();
        $loader = new YamlFileLoader($this->container, new FileLocator($this->getConfigPath()));
        $loader->load('services.yml');
        $this->container->compile(true);
    }

    /**
     * @return object
     *
     * @throws \Exception
     */
    protected function getApplication(): object
    {
        return $this->getContainer()->get(sprintf('app.%s', $this->getApp()));
    }
}
