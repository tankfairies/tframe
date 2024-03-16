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

/**
 * Class Controller
 * @package Model
 */
class Controller
{
    /**
     * @var string
     */
    private string $layout = "master";

    /**
     * Renders the page view
     *
     * @param string $filename
     * @param array $params
     */
    public function render(string $filename, array $params = [])
    {
        extract($params);

        ob_start();
        require_once(
            __DIR__
            ."/../view/"
            .str_replace(['Tankfairies', 'Controller', '\\'], '', get_class($this))
            .'/' . $filename . '.php'
        );
        $page = ob_get_clean();

        require_once("../view/{$this->layout}.php");
    }
}
