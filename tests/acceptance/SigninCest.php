<?php


class SigninCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->fillField('#1', '123');
        $I->fillField('#2', '123');
        $I->click("GO");
        $I->see('XDEBUG_SESSION');
    }
}
