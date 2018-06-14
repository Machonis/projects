<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('want to welcome page  ');
$I->amOnPage('index5.php');
$I->see('Welcome');