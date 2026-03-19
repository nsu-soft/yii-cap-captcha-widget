<?php

use NsuSoft\Captcha\CapWidget;
use yii\web\View;

/** @var View $this */
?>
<?= CapWidget::widget([
    'endpoint' => Yii::$app->captcha->getEndpoint(),
    'onSolve' => 'function (e) {}',
]) ?>
