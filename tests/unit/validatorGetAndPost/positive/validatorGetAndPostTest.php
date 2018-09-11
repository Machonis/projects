<?php

use projects\app\validatorGetAndPost;

class validatorGetAndPostTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $validator = new validatorGetAndPost(['request' => '1', 'request2' => '2'] , ['name' => 'Tadas']);

        $param = $validator->getParam('request');
        $this -> assertEquals('1', $param);

        $this -> assertInternalType('array', $validator -> getParams() );

    }
}