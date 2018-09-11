<?php

namespace projects\app;

class getNames {

    private $name;
    private $bool;

    public function setName($name)
    {
        if ($name != null) {
            $this->name = $name;
            $this->bool = true;
        } else {
            $this->bool = false;
        }
    }

    public function getName()
    {
        return $this->bool;
    }
}