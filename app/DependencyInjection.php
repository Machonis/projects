<?php

namespace projects\app;

class DependencyInjection
{

    private $object;

    public function __construct(InterfaceTadas $object)
    {
        $this->object = $object;
    }

}


