<?php

namespace Tests\Unit;

use NsuSoft\Captcha\CapWidget;
use Tests\Support\UnitTester;
use yii\base\InvalidArgumentException;
use yii\helpers\Html;

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
        ]);

        $this->assertIsString($result);
        $this->assertStringContainsString('cap-widget', $result);
        $this->assertStringContainsString('data-cap-api-endpoint', $result);
        $this->assertStringContainsString('data-cap-hidden-field-name', $result);
        $this->assertStringContainsString('data-cap-troubleshooting-url', $result);
        $this->assertStringContainsString('data-cap-i18n-error-aria-label', $result);
        $this->assertStringContainsString('data-cap-i18n-error-label', $result);
        $this->assertStringContainsString('data-cap-i18n-initial-state', $result);
        $this->assertStringContainsString('data-cap-i18n-solved-label', $result);
        $this->assertStringContainsString('data-cap-i18n-troubleshooting-label', $result);
        $this->assertStringContainsString('data-cap-i18n-verified-aria-label', $result);
        $this->assertStringContainsString('data-cap-i18n-verify-aria-label', $result);
        $this->assertStringContainsString('data-cap-i18n-verifying-aria-label', $result);
        $this->assertStringContainsString('data-cap-i18n-verifying-label', $result);
        $this->assertStringContainsString('data-cap-i18n-wasm-disabled', $result);

        $this->assertStringNotContainsString('data-cap-disable-haptics', $result);
        $this->assertStringNotContainsString('data-cap-worker-count', $result);
    }

    public function testRunWithOptions()
    {
        $result = CapWidget::widget([
            'endpoint' => self::ENDPOINT,
            'disableHaptics' => true,
            'workerCount' => 8,
        ]);

        $this->assertStringContainsString('data-cap-disable-haptics', $result);
        $this->assertStringContainsString('data-cap-worker-count', $result);
    }

    public function testRunEnglish()
    {
        $result = CapWidget::widget([
            'endpoint' => self::ENDPOINT,
            'language' => 'en-US',
        ]);

        $this->assertStringContainsString(Html::encode("Verify you're human"), $result);
    }

    public function testRunRussian()
    {
        $result = CapWidget::widget([
            'endpoint' => self::ENDPOINT,
            'language' => 'ru-RU',
        ]);

        $this->assertStringContainsString(Html::encode('Подтвердите, что вы человек'), $result);
    }
}
