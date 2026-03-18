<?php

declare(strict_types=1);

namespace Tests\Functional\Assets;

use Tests\Support\FunctionalTester;

final class CapWidgetAssetCest
{
    public function _before(FunctionalTester $I): void
    {
    }

    public function assetIsRegistered(FunctionalTester $I): void
    {
        $I->amOnPage('index-test.php?r=test/index');
        $I->seeInSource('cap.min.js');
    }
}
