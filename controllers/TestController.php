<?php

namespace app\controllers;

use app\forms\TestForm;
use yii\web\Controller;

class TestController extends Controller
{
    /**
     * @return string
     */
    public function actionForm(): string
    {
        return $this->render('form', [
            'model' => new TestForm(),
        ]);
    }

    /**
     * @return string
     */
    public function actionSolve(): string
    {
        return $this->render('solve');
    }
}