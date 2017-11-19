<?php

include_once 'Library/Classes/Application.php';
include_once 'Library/Classes/Autoloader.php';

$application = new Application();

$application->getAutoloader()->addDirectories([
    __DIR__ . '/Library/Classes',
    __DIR__ . '/Library/Plugins',
    __DIR__ . '/Controllers',
]);

$application->getBootstrap()->bootstrap();
$application->run();