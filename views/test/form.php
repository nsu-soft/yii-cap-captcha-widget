<?php

use app\forms\TestForm;
use NsuSoft\Captcha\CapWidget;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var TestForm $model */
?>
<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'text')->textInput() ?>

<?= CapWidget::widget([
    'endpoint' => Yii::$app->captcha->getEndpoint(),
    'cssVars' => [
        '--cap-border-color' => '#cccccc8f',
    ],
]) ?>

<?= Html::submitButton() ?>

<?php ActiveForm::end() ?>
