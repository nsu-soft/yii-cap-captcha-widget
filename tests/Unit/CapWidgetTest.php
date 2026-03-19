<?php

namespace Tests\Unit;

use NsuSoft\Captcha\CapWidget;
use Tests\Support\UnitTester;
use yii\base\InvalidArgumentException;

class CapWidgetTest extends \Codeception\Test\Unit
{
    const ENDPOINT = 'http://localhost:3000';
    const ON_SOLVE = 'function (e) {}';

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testInitOnlyEndpoint()
    {
        $widget = new CapWidget([
            'endpoint' => 'http://localhost:3000/',
        ]);

        $this->assertEquals('http://localhost:3000', $widget->endpoint);
        $this->assertNull($widget->onSolve);
    }

    public function testInitWithOnSolve()
    {
        $widget = new CapWidget([
            'endpoint' => self::ENDPOINT,
            'onSolve' => self::ON_SOLVE,
        ]);

        $this->assertEquals(self::ON_SOLVE, $widget->onSolve);
    }

    public function testEndpointIsNull()
    {
        $this->expectException(InvalidArgumentException::class);

        CapWidget::widget();
    }

    public function testRun()
    {
        $result = CapWidget::widget([
            'endpoint' => self::ENDPOINT,
            'onSolve' => self::ON_SOLVE,
        ]);

        $this->assertIsString($result);
        $this->assertStringContainsString('cap-widget', $result);
    }
}
