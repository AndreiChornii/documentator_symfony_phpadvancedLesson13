<?php


namespace Documentor\Service;


interface InfoServiceInterface
{
    public function setFilename(string $string);
    public function isDryRun(bool $dryRun);
    public function getInfo(): array;
}