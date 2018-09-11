<?php

namespace projects\tests\unit\validatorGetAndPost\positive;


class getParams extends \Codeception\Test\Unit
{
    protected $tester;

    public function testGetParamType()
    {
        $validator = new validatorGetAndPost(['request' => '1', 'request2' => '2'] , ['name' => 'Tadas']);

        $param = $validator->getParam('request');
        $this -> assertEquals('1', $param);

        $this -> assertInternalType('array', $validator -> getParams() );

    }
}