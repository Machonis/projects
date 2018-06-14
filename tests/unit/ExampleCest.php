<?php
require_once (__DIR__ .'/TestClass.php');

class ExampleCest
{
    
    public function _before()
    {
        $var = ValidatorGetAndPost::class;
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature(UnitTester $I)
    {
        $param = 'Tadas';
        $var = new TestClass();
        
        
        $I->assertEquals($param, $var->test($param));
    }
}