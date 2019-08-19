<?php

namespace Tankfairies\Tframe;

use ComposerScriptEvent;

class Installer
{

    public static function postPackageInstall(Event $event)
    {
        $installedPackage = $event->getComposer()->getPackage();
        
        mkdir('testpath');
    }
}
