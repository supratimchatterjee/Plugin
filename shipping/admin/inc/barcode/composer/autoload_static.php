<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9b3d151591fe7ce7e06fbb034dee35fa
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Picqer\\Barcode\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Picqer\\Barcode\\' => 
        array (
            0 => __DIR__ . '/..' . '/picqer/php-barcode-generator/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9b3d151591fe7ce7e06fbb034dee35fa::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9b3d151591fe7ce7e06fbb034dee35fa::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}