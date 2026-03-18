<?php

namespace Tests\Unit;

use NsuSoft\Captcha\CapWidget;
use Tests\Support\UnitTester;
use yii\base\InvalidArgumentException;

class CapWidgetTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testInit()
    {
        $widget = new CapWidget([
            'endpoint' => 'http://localhost:3000/',
        ]);

        $this->assertEquals('http://localhost:3000', $widget->endpoint);
    }

    public function testEndpointIsNull()
    {
        $this->expectException(InvalidArgumentException::class);

        CapWidget::widget();
    }
}
