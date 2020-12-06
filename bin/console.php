#!/usr/bin/env php

<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Documentor\Command\VersionCommand;
use Documentor\Command\FileInfoCommand;
use Documentor\Service\FileInfoService;
use Documentor\Service\TwigRender;

$application = new Application();
$application->setName('Hillel Documentor');

$fileInfoService = new FileInfoService();
$twigRender = new TwigRender(
    __DIR__ . '/../templates',
    __DIR__ . '/../reports/'
);

$application->addCommands(
    [
        new FileInfoCommand($fileInfoService, $twigRender),
        new VersionCommand()
    ]
);
$application->run();