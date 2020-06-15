<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Service\Common;

/**
 * Class UnicodeConverter
 */
class UnicodeConverter
{
    /**
     * @param string $unicode
     *
     * @return string
     */
    public function unicodeToSymbol(string $unicode): string
    {
        return iconv('UTF-16BE', 'UTF-8', hex2bin(str_replace('\\u', '', $unicode)));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function unicodeString(string $string): string
    {
        return preg_replace_callback('/(\\\\u[0-9a-fA-F]{4}){2,}/ui', function($match) {
            return $this->unicodeToSymbol($match[0]);
        }, $string);
    }
}
