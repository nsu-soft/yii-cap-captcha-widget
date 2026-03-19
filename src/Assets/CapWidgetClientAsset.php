<?php

namespace NsuSoft\Captcha\Assets;

use yii\web\AssetBundle;

class CapWidgetClientAsset extends AssetBundle
{
    /**
     * @inheritDoc
     */
    public $sourcePath = __DIR__ . '/Source/Js';

    /**
     * @inheritDoc
     */
    public $js = [
        'cap.widget.client.js',
    ];

    /**
     * @inheritDoc
     */
    public $depends = [
        CapWidgetAsset::class,
    ];
}