<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/tframe
 */

require_once('../model/Autoloader.php');

spl_autoload_register('\Tankfairies\Model\Autoloader::autoload');
$dispatch = new \Tankfairies\Model\Dispatcher();
$dispatch->dispatch();
