<?php
/**
 * @group tadas
 */

$I = new AcceptanceTester($scenario);
$I->wantTo('see www.agilefuel.com ');
$I->amOnUrl('https://www.google.com.ua');
$I->seeElement('input[class="gsfi"]');
$I->fillField('input[id="lst-ib"]', 'Agile Fuel');
$I->pressKey('input[id="lst-ib"]', WebDriverKeys::ENTER);

for ($i = 1; $i <= 5; $i++ ) {
    $aLinks=$I->grabMultiple("#rso > div > div > div:nth-child({$i})");
    foreach ($aLinks as $value) {
        if (stripos($value, 'www.agilefuel.com/')) {
            throw new Exception('YES');
        }
    }
}
