<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfaf1917dae06bcef15ce70eaf7e32690
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfaf1917dae06bcef15ce70eaf7e32690::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfaf1917dae06bcef15ce70eaf7e32690::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfaf1917dae06bcef15ce70eaf7e32690::$classMap;

        }, null, ClassLoader::class);
    }
}
