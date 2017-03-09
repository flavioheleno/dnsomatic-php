<?php

require_once __DIR__ . '/../vendor/autoload.php';

use dnsomatic\Factory;

$updater = Factory::createUpdater('username', 'password');
$updater
    ->setHostname('sub.example.com')
    ->setMyip('192.168.0.10');
var_dump($updater->exec());
