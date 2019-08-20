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
 * Class Controller
 * @package Model
 */
class Controller
{
    /**
     * @var string
     */
    private $layout = "master";

    /**
     * Renders the page view
     *
     * @param $filename
     * @param array $params
     */
    function render($filename, $params=[])
    {
        extract($params);

        ob_start();
        require_once(__DIR__ . "/../view/" . $filename . '.php');
        $page = ob_get_clean();

        require_once("../view/{$this->layout}.php");
    }
}