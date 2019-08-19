<?php

namespace Tankfairies\Tframe;

class Installer
{

    public static function postCreateProjectCmd()
    {
        mkdir('testpath');
    }
}
