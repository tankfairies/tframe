<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/tframe
 */

namespace Tankfairies\Controller;

use Tankfairies\Model\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $this->render("index");
    }

    public function info()
    {
        phpinfo();
    }
}
