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

use Tankfairies\Model\Cache\Cache;
use Tankfairies\Model\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $this->render("index", ['indexdata' => 'example param']);
    }

    public function cache()
    {
        $cache = new Cache();

        $cacheData = $cache->check('some_data');

        if (empty($cacheData)) {
            $cacheData = 'no data';
        }

        $cache->upsert('some_data', "data stored for 5 seconds", 5);

        $this->render("cache", ['cacheData' => $cacheData??'']);
    }

    public function info()
    {
        ob_start();
        phpinfo();
        $phpinfo = ob_get_contents();
        ob_end_clean();
        $phpinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $phpinfo);

        $this->render("info", ['phpinfo' => $phpinfo??'']);
    }
}
