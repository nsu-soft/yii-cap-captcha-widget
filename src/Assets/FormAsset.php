<?php

namespace NsuSoft\Captcha\Assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class FormAsset extends AssetBundle
{
    /**
     * @inheritDoc
     */
    public $sourcePath = __DIR__ . '/Source/Form';

    /**
     * @inheritDoc
     */
    public $js = [
        'Js/cap.widget.form.js',
    ];

    /**
     * @inheritDoc
     */
    public $depends = [
        JqueryAsset::class,
    ];
}