<?php
/**
 * @group
 */

$I = new AcceptanceTester($scenario);
$I->wantTo('see www.agilefuel.com ');
$I->amOnUrl('https://www.google.com.ua');
$I -> seeElement('input[class="gsfi"]');
$I->fillField('input[id="lst-ib"]', 'Agile Fuel');
$I->pressKey('input[id="lst-ib"]',WebDriverKeys::ENTER);
$fullText=$I->grabPageSource();

$marker='<div class="g"';
$markerLen=strlen($marker)+1;
$markerPosition=strpos($fullText,'<div class="g"');

$bool=false;

for ($i = 1; $i < 5; $i++ )
{
    $markerPosition=$markerPosition+$markerLen;
    $fullText = substr($fullText, $markerPosition);
    $markerPosition=strpos($fullText,'<div class="g"');
    $partOfText = substr($fullText, 0, $markerPosition);
    file_put_contents("$i.txt", $partOfText);
    if (strripos($partOfText, 'www.agilefuel.com')) {
        file_put_contents("num.txt", "Найдено в блоке №{$i}");
        $I->see('www.agilefuel.com');
    }
}



