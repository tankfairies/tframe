<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/tframe
 */

namespace Tankfairies\Model\ConfigManager;

/**
 * config Manager
 *
 * configuration manager class.
 */
class ConfigManager
{
    /**
     * Adds the Global configuration and applies the dev configuration over the top
     *
     * @var string
     */
    public static $handler = '';

    /**
     * Gets and adds the configurations
     *
     * @throws ConfigException
     */
    public static function configuration(): void
    {
        self::$handler = new ConfigHandler();

        //add master config
        self::$handler->addConfiguration(require_once(__DIR__.'/../../Config/global.php'));

        //add developer config
        if (file_exists("Configs/dev.php")) {
            self::$handler->addConfiguration(require_once(__DIR__.'/../../Config/dev.php'));
        }
    }

    /**
     * Retrieves the config
     *
     * @return ConfigHandler
     * @throws ConfigException
     */
    public static function getConfiguration()
    {
        if (empty(self::$handler)) {
            self::configuration();
        }
        return self::$handler;
    }
}
