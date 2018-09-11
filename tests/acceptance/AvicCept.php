<?php

class AvicCept
{
    public function tryToTest(AcceptanceTester $I)
    {
        $I->wantTo('Avic shop');
        $I->amOnPage('/computers/');
        $I->click('#Моноблоки a');
        $I->see('Профиль пользователя');
    }
}