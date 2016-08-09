<?php

namespace Bludata\Lumen\Providers;

class RegisterSymfonyConstraintsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $path = base_path().'/vendor/symfony/validator/Constraints';

        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                $pathFile = $path.'/'.$file;

                if (pathinfo($pathFile)['extension'] == 'php') {
                    \Doctrine\Common\Annotations\AnnotationRegistry::registerFile($pathFile);
                }
            }

            closedir($handle);
        }
    }
}
