<?php


namespace Documentor\Command;


use Documentor\Service\InfoServiceInterface;
use Documentor\Service\RenderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FileInfoCommand extends Command
{
    /** @var bool */
    private $dryRun = false;

    /** @var InfoServiceInterface */
    private $infoService;

    private $render;

    public function __construct(InfoServiceInterface $infoService, RenderInterface $render)
    {
        $this->infoService = $infoService;
        $this->render = $render;
        parent::__construct('doc:report');
    }

    public function configure()
    {
        $this->setDescription('Read source file and prepare report')
            ->addArgument('filename', InputArgument::REQUIRED, 'Source file name')
            ->addOption('dry-run');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');
        $output->writeln('Filename: '. $filename);

        if ($input->getOption('dry-run')) {
            $output->writeln('Dry run checked');
            $this->dryRun = true;
        }

        $this->infoService->setFilename($filename);
        $this->infoService->isDryRun($this->dryRun);

        $info = $this->infoService->getInfo();
        var_dump($info);
        $this->render->render($info);
        exit(0);
    }
}