<?php

require_once __DIR__ . '/../vendor/autoload.php';

use dnsomatic\Factory;

$checker = Factory::createChecker();
var_dump($checker->exec());
