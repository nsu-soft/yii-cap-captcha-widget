<?php

declare(strict_types=1);

namespace Tests\Functional\Assets;

use Tests\Support\FunctionalTester;

final class SolveAssetCest
{
    public function _before(FunctionalTester $I): void
    {
    }

    public function assetIsRegistered(FunctionalTester $I): void
    {
        $I->amOnPage('index-test.php?r=test/solve');

        $I->seeInSource('cap.widget.solve.js');
        $I->seeInSource('CapWidgetSolve.addHandler({');
        
        $I->dontSeeElement('.form-group');
        $I->dontSeeInSource('CapWidgetForm.create');
        $I->dontSeeInSource('jquery.js');
    }
}
