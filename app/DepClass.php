<?php

namespace projects\app;

class DepClass implements InterfaceTadas
{
    private $hell;

    public function __construct($hell)
    {
        $this -> Hell($hell);
    }

    public function Hell($hell)
    {
        $this -> hell = $hell;
    }
}