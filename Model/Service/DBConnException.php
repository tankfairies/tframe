<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/tframe
 */

namespace Tankfairies\Model\Service;

use Exception;
/**
 * ConfigManager Exception.
 *
 * Extends the base exceptions class.
 */
class DBConnException extends Exception
{

    /**
     * Redefine the exception so message isn't optional.
     *
     * @param string $message
     * @param integer $code
     * @param Exception $previous
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
}
