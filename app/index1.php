<?php

namespace projects\app;

require_once __DIR__ . '/../vendor/autoload.php';

$object = new DepClass('Hell is hell');
$object1 = new DependencyInjection($object);

var_dump($object1);