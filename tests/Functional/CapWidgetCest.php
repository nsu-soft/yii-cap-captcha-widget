<?php

declare(strict_types=1);

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Yii;

final class CapWidgetCest
{
    public function _before(FunctionalTester $I): void
    {
    }

    public function widgetInForm(FunctionalTester $I): void
    {
        $I->amOnPage('index-test.php?r=test/form');

        $I->seeElement('cap-widget', [
            'data-cap-api-endpoint' => Yii::$app->captcha->getEndpoint(),
            'data-cap-hidden-field-name' => 'cap-token',
            'data-cap-troubleshooting-url' => 'https://capjs.js.org/guide/troubleshooting/instrumentation.html',
            'data-cap-i18n-error-aria-label' => "An error occurred, please try again",
            'data-cap-i18n-error-label' => "Error",
            'data-cap-i18n-initial-state' => "Verify you're human",
            'data-cap-i18n-solved-label' => "You're a human",
            'data-cap-i18n-troubleshooting-label' => "Troubleshoot",
            'data-cap-i18n-verified-aria-label' => "We have verified you're a human, you may now continue",
            'data-cap-i18n-verify-aria-label' => "Click to verify you're a human",
            'data-cap-i18n-verifying-aria-label' => "Verifying you're a human, please wait",
            'data-cap-i18n-verifying-label' => "Verifying...",
            'data-cap-i18n-wasm-disabled' => "Enable WASM for significantly faster solving",
        ]);

        $I->dontSeeElement('cap-widget', [
            'data-cap-disable-haptics' => '',
        ]);

        $I->dontSeeElement('cap-widget', [
            'data-cap-worker-count' => '',
        ]);

        $I->seeInSource(':root');
        $I->seeInSource('--cap-background: #fdfdfd;');
        $I->seeInSource('--cap-border-color: #cccccc8f;');
        $I->seeInSource('--cap-border-radius');
        $I->seeInSource('--cap-checkbox-background');
        $I->seeInSource('--cap-checkbox-border');
        $I->seeInSource('--cap-checkbox-border-radius');
        $I->seeInSource('--cap-checkbox-margin');
        $I->seeInSource('--cap-checkbox-size');
        $I->seeInSource('--cap-checkmark');
        $I->seeInSource('--cap-color');
        $I->seeInSource('--cap-error-cross');
        $I->seeInSource('--cap-font');
        $I->seeInSource('--cap-gap');
        $I->seeInSource('--cap-spinner-background-color');
        $I->seeInSource('--cap-spinner-color');
        $I->seeInSource('--cap-spinner-thickness');
        $I->seeInSource('--cap-widget-height');
        $I->seeInSource('--cap-widget-padding');
        $I->seeInSource('--cap-widget-width');
    }
}
