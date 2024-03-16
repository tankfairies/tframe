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
 * Array Handler
 *
 * configuration manager class.
 *
 */
class ConfigHandler
{

    /**
     * @var array
     */
    private array $configurations = [];

    /**
     * @var array
     */
    private array $mergedConfiguration = [];

    /**
     * @var int
     */
    private int $configCount = 0;

    /**
     * @var int
     */
    private int $mergedCount = 0;

    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * Add a configuration
     *
     * @param $config
     * @return $this
     * @throws ConfigException
     */
    public function addConfiguration($config): self
    {
        if (!is_array($config)) {
            throw new ConfigException('config must be an array');
        }

        $this->configurations[] = $config;

        $this->configCount = count($this->configurations);
        return $this;
    }

    /**
     * Returns the merged configuration
     *
     * @param string $section
     * @return mixed
     * @throws ConfigException
     */
    public function getConfig(string $section = '')
    {
        if ($this->configCount == 0) {
            throw new ConfigException('no configs set');
        }

        if ($this->mergedCount != $this->configCount) {
            $result = array();
            foreach ($this->configurations as $config) {
                if (count($result) == 0) {
                    $result = $config;
                } else {
                    $result = $this->mergeArray($result, $config);
                }
            }
            $this->mergedConfiguration = $result;

            $this->mergedCount = count($this->configurations);
        }

        if ($section == '') {
            $array = $this->mergedConfiguration;
        } elseif (isset($this->mergedConfiguration[$section])) {
            $array = $this->mergedConfiguration[$section];
        } else {
            throw new ConfigException('unknown section ' .$section);
        }

        return $array;
    }

    /**
     * Merges configuration array
     *
     * @param $first
     * @param $second
     * @return array
     */
    private function mergeArray($first, $second): array
    {
        $inter = array_intersect_assoc(array_keys($first), array_keys($second));

        foreach ($inter as $key) {
            if (is_array($first[$key]) && is_array($second[$key])) {
                $first[$key] = $this->mergeArray($first[$key], $second[$key]);
            } elseif (is_array($first[$key])) {
                $first[$key][] = $second[$key];
            } elseif (is_array($second[$key])) {
                $second[$key][] = $first[$key];
                $first[$key] = $second[$key];
            } else {
                $first[$key] = $second[$key];
            }
            unset($second[$key]);
        }

        return array_merge($first, $second);
    }
}
