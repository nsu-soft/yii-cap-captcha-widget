<?php

use NsuSoft\Captcha\Assets\CapWidgetAsset;
use yii\web\View;

/** @var View $this */
/** @var string $endpoint */

CapWidgetAsset::register($this);

?>
<cap-widget data-cap-api-endpoint="<?= $endpoint ?>"></cap-widget>