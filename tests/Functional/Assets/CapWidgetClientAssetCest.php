<?php

declare(strict_types=1);

namespace Tests\Functional\Assets;

use Tests\Support\FunctionalTester;

final class CapWidgetClientAssetCest
{
    public function _before(FunctionalTester $I): void
    {
    }

    public function assetIsRegistered(FunctionalTester $I): void
    {
        $I->amOnPage('index-test.php?r=test/solve');
        $I->seeInSource('cap.widget.client.js');
        $I->seeInSource('CapWidgetClient.addHandler');
        $I->dontSeeInSource('jquery.js');
    }

    public function assetIsNotRegistered(FunctionalTester $I): void
    {
        $I->amOnPage('index-test.php?r=test/form');
        $I->dontSeeInSource('cap.widget.client.js');
        $I->dontSeeInSource('CapWidgetClient.addHandler');
    }
}
