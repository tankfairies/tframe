<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/tframe
 */

namespace Tankfairies\Tframe\Model;

/**
 * Class Dispatcher
 * @package Model
 */
class Dispatcher
{
    /**
     * @var
     */
    private $controller;

    /**
     * @var
     */
    private $action;

    /**
     * @var array
     */
    private $params = [];

    /**
     *
     */
    public function dispatch()
    {
        $this->parse($_SERVER["REQUEST_URI"]);

        call_user_func_array(
            [
                $this->loadController(),
                $this->action
            ],
            $this->params
        );
    }

    /**
     * @return mixed
     */
    public function loadController()
    {
        $name = "Tankfairies\\Controller\\{$this->controller}Controller";

        $controller = new $name();
        return $controller;
    }

    /**
     * @param $url
     */
    public function parse($url)
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
}