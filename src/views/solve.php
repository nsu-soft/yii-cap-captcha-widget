<?php

use NsuSoft\Captcha\Assets\CapWidgetAsset;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var array $options */

CapWidgetAsset::register($this);
?>
<?= Html::tag('cap-widget', '', $options) ?>