<?php

namespace NsuSoft\Captcha\Assets;

use yii\web\AssetBundle;

class CapWidgetAsset extends AssetBundle
{
    /**
     * @inheritDoc
     */
    public $sourcePath = '@npm/cap.js--widget';

    /**
     * @inheritDoc
     */
    public $js = [
        'cap.min.js',
    ];
}