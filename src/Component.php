<?php

declare(strict_types=1);

namespace Keboola\ProcessorIconv;

use Exception;
use Keboola\Component\BaseComponent;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class Component extends BaseComponent
{
    protected function run(): void
    {
        /** @var Config $config */
        $config = $this->getConfig();
        $finder = new Finder();
        $finder->in($this->getDataDir() . '/in/tables')->files();
        $this->processDir($finder, 'tables', $config);
        $finder = new Finder();
        $finder->in($this->getDataDir() . '/in/files')->files();
        $this->processDir($finder, 'files', $config);
    }

    private function processDir(Finder $finder, string $dir, Config $config): void
    {
        $fs = new Filesystem();
        foreach ($finder as $inFile) {
            if ($inFile->getExtension() === 'manifest') {
                // copy manifest without modification
                $fs->copy($inFile->getPathname(), $this->getDataDir() . "/out/$dir/" . $inFile->getFilename());
            } else {
                $destinationDir = $this->getDataDir() . "/out/$dir/" . $inFile->getRelativePath();
                $fs->mkdir($destinationDir);
                $destinationFile = $destinationDir . '/' . $inFile->getFilename();
                $this->processFile($inFile, $destinationFile, $config);
            }
        }
    }

    private function processFile(SplFileInfo $inFile, string $destinationFileName, Config $config): void
    {
        $source = fopen($inFile->getPathname(), 'r');
        $destination = fopen($destinationFileName, 'a');
        if ($source === false) {
            throw new Exception(sprintf('Failed to open source file: "%s"', $inFile->getPathname()));
        }
        if ($destination === false) {
            throw new Exception(sprintf('Failed to open destination file: "%s"', $destinationFileName));
        }
        while ($buff = fgets($source)) {
            $buff = str_replace("\0", '', $buff);
            fputs($destination, $buff);
        }
    }

    protected function getConfigClass(): string
    {
        return Config::class;
    }

    protected function getConfigDefinitionClass(): string
    {
        return ConfigDefinition::class;
    }
}
