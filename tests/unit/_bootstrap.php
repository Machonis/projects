<?php
$path = __DIR__. '../../Tasks';
var_dump($path);
\Codeception\Util\Autoload::addNamespace('', $path);
\Codeception\Util\Autoload::addNamespace('Class', __DIR__);