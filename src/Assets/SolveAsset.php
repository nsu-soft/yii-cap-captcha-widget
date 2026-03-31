<?php

namespace NsuSoft\Captcha\Assets;

use yii\web\AssetBundle;

class SolveAsset extends AssetBundle
{
    /**
     * @inheritDoc
     */
    public $sourcePath = __DIR__ . '/Source/Solve';

    /**
     * @inheritDoc
     */
    public $js = [
        'Js/cap.widget.solve.js',
    ];

    /**
     * @inheritDoc
     */
    public $depends = [
        CapWidgetAsset::class,
    ];
}