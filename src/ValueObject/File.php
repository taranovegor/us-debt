<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\ValueObject;

use App\Exception\File\FileNotFoundException;
use App\Exception\File\FileException;

/**
 * Class Image
 */
class File extends \SplFileInfo
{
    /**
     * File constructor.
     *
     * @param string $filepath
     * @param bool   $checkPath
     *
     * @throws FileNotFoundException
     */
    public function __construct(string $filepath, bool $checkPath = true)
    {
        if ($checkPath && false === is_file($filepath)) {
            throw new FileNotFoundException();
        }

        parent::__construct($filepath);
    }

    /**
     * @param string      $directory
     * @param string|null $name
     *
     * @return self
     *
     * @throws FileException
     */
    public function copy(string $directory, string $name = null): self
    {
        $target = $this->getTargetFile($directory, $name);

        set_error_handler(function ($type, $msg) use (&$error) {
            $error = $msg;
        });
        $copied = copy($this->getPathname(), $target);
        restore_error_handler();
        if (!$copied) {
            throw new FileException(sprintf('Could not copy the file "%s" to "%s" (%s).', $this->getPathname(), $target, strip_tags($error)));
        }

        @chmod($target, 0666 & ~umask());

        return $target;
    }

    /**
     * @param string      $directory
     * @param string|null $name
     *
     * @return self
     *
     * @throws FileException
     */
    protected function getTargetFile(string $directory, string $name = null): self
    {
        if (!is_dir($directory)) {
            if (false === @mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new FileException(sprintf('Unable to create the "%s" directory.', $directory));
            }
        } elseif (!is_writable($directory)) {
            throw new FileException(sprintf('Unable to write in the "%s" directory.', $directory));
        }

        $target = rtrim($directory, '/\\').\DIRECTORY_SEPARATOR.(null === $name ? $this->getBasename() : $this->getName($name));

        return new static($target, false);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function getName(string $name): string
    {
        $originalName = str_replace('\\', '/', $name);
        $pos = strrpos($originalName, '/');
        $originalName = false === $pos ? $originalName : substr($originalName, $pos + 1);

        return $originalName;
    }
}
