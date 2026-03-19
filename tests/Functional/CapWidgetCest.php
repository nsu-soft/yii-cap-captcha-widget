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

    public function widgetIsShowing(FunctionalTester $I): void
    {
        $I->amOnPage('index-test.php?r=test/form');
        $I->seeElement('cap-widget', [
            'data-cap-api-endpoint' => Yii::$app->captcha->getEndpoint(),
        ]);
    }
}
