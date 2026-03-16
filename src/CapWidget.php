<?php

namespace NsuSoft\Captcha;

use yii\base\Widget;

class CapWidget extends Widget
{
    /**
     * @inheritDoc
     */
    public function run(): string
    {
        return $this->render('index', [
            
        ]);
    }
}