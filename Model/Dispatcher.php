<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/tframe
 */

namespace Tankfairies\Model;

use Exception;

/**
 * Class Dispatcher
 * @package Model
 */
class Dispatcher
{
    /**
     * @var string
     */
    private string $controller;

    /**
     * @var string
     */
    private string $action;

    /**
     * @var array
     */
    private array $params = [];

    /**
     * Calls the controller and associated action
     */
    public function dispatch(): void
    {
        try {
            $this->parse($_SERVER["REQUEST_URI"]);

            if (!method_exists($this->getClass(), $this->action)) {
                throw new Exception("Controller or action ({$this->getClass()} {$this->action}) doesn't exist");
            }

            call_user_func_array(
                [
                    $this->loadController(),
                    $this->action
                ],
                $this->params
            );
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * Loads the controller defined from the url
     *
     * @return object
     */
    public function loadController(): object
    {
        return new ($this->getClass());
    }

    /**
     * Converts the url into controller, action and parameters
     *
     * @param $url
     */
    public function parse($url): void
    {
        $url = trim($url);
        if ($url == '/') {
            $this->controller = 'Index';
            $this->action = 'index';
        } else {
            $splitUrl = explode('/', $url);
            $this->controller = $splitUrl[1];
            if (!isset($splitUrl[2]) || $splitUrl[2] == '') {
                $this->action = 'index';
            } else {
                $this->action = $splitUrl[2];
            }
            $this->params = array_slice($splitUrl, 3);
        }
    }

    private function getClass(): string
    {
        return "Tankfairies\\Controller\\{$this->controller}Controller";
    }
}
