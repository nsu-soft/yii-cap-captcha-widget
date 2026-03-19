<?php

use NsuSoft\Captcha\Assets\CapWidgetAsset;
use yii\web\View;

/** @var View $this */
/** @var string $endpoint */
/** @var string $id */

CapWidgetAsset::register($this);
?>
<cap-widget id="<?= $id ?>" data-cap-api-endpoint="<?= $endpoint ?>"></cap-widget>