<?php


namespace Documentor\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VersionCommand extends Command
{
    public function configure()
    {
        $this->setName('version:info')
            ->setDescription('Show application version');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $composerFile = __DIR__ . '/../../composer.json';
        if (!file_exists($composerFile)) {
            $output->writeln('<error>composer.json file not found</error>');
            exit();
        }
        $jsonData = file_get_contents($composerFile);
        $data = json_decode($jsonData, true);
        if (!isset($data['version'])) {
            $output->writeln('Version information not found');
            exit(0);
        }
        $output->writeln('Application version '. $data['version']);
        exit(0);
    }
}