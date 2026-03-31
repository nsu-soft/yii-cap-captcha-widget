<?php

declare(strict_types=1);

namespace Tests\Functional\Assets;

use Tests\Support\FunctionalTester;

final class FormAssetCest
{
    public function _before(FunctionalTester $I): void
    {
    }

    public function assetIsRegistered(FunctionalTester $I): void
    {
        $I->amOnPage('index-test.php?r=test/form');
        $I->seeInSource('cap.widget.form.js');
        $I->seeInSource('jquery.js');
        $I->seeInSource("CapWidgetForm.create('");
        $I->dontSeeInSource('CapWidgetSolve.addHandler');
    }
}
