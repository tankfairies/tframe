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

use Tankfairies\Model\ConfigManager\ConfigException;
use Tankfairies\Model\ConfigManager\ConfigManager;
use SQLite3;

/**
 * Class DBConn
 * @package Model\Service
 */
class DBConn extends SQLite3
{
    /**
     * DBConn constructor.
     * @throws ConfigException
     */
    public function __construct()
    {
        $config = ConfigManager::getConfiguration();
        $this->open('../storage/'.$config->getConfig('cacheDB'));
    }
}
