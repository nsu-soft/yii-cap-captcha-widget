<?php

namespace app\controllers;

use app\forms\TestForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class TestController extends Controller
{
    /**
     * @return Response|string
     */
    public function actionIndex(): Response|string
    {
        return $this->render('index', [
            'model' => new TestForm(),
        ]);
    }
}