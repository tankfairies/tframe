<?php

namespace Tankfairies\Tframe;

use ComposerScriptEvent;

class Installer
{

    public static function postPackageInstall(Event $event)
    {
        echo "running posrt install\n";
        $installedPackage = $event->getComposer()->getPackage();
        
        mkdir('testpath');
    }
}
