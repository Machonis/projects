<?php
/**
 * Created by PhpStorm.
 * @group rallyware
 */
$I = new AcceptanceTester($scenario);
$I->wantTo('test login form ');
$I->amOnUrl('http://localhost:8080');
$I->seeCurrentUrlEquals('/login');
$I->click('Register');
$I->see('Register with your social account');
$I->click('sign up');


/*$I = new AcceptanceTester($scenario);
$I->wantTo('test login form ');
$I->amOnUrl('http://localhost:8080');
$I->seeCurrentUrlEquals('/login');
$I->fillField('_username', 'dev@rallyware.com');
$I->fillField('_password', 'dev@rallyware.com');
$I->click('Sign in');
$I->see('Katie Admin');*/