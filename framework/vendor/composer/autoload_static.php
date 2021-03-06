<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8ec404552f2e8448b9aaa90196183b65
{
    public static $files = array (
        '2cffec82183ee1cea088009cef9a6fc3' => __DIR__ . '/..' . '/ezyang/htmlpurifier/library/HTMLPurifier.composer.php',
    );

    public static $prefixLengthsPsr4 = array (
        'y' => 
        array (
            'yii\\composer\\' => 13,
            'yii\\' => 4,
            'yidas\\yii2BowerAsset\\' => 21,
        ),
        'r' => 
        array (
            'rbtphp\\ffmpeg\\' => 14,
        ),
        'c' => 
        array (
            'cebe\\markdown\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'yii\\composer\\' => 
        array (
            0 => __DIR__ . '/..' . '/yiisoft/yii2-composer',
        ),
        'yii\\' => 
        array (
            0 => __DIR__ . '/..' . '/yiisoft/yii2',
        ),
        'yidas\\yii2BowerAsset\\' => 
        array (
            0 => __DIR__ . '/..' . '/yidas/yii2-bower-asset',
        ),
        'rbtphp\\ffmpeg\\' => 
        array (
            0 => __DIR__ . '/..' . '/elisevgeniy/yii2-ffmpeg',
        ),
        'cebe\\markdown\\' => 
        array (
            0 => __DIR__ . '/..' . '/cebe/markdown',
        ),
    );

    public static $prefixesPsr0 = array (
        'H' => 
        array (
            'HTMLPurifier' => 
            array (
                0 => __DIR__ . '/..' . '/ezyang/htmlpurifier/library',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8ec404552f2e8448b9aaa90196183b65::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8ec404552f2e8448b9aaa90196183b65::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit8ec404552f2e8448b9aaa90196183b65::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
