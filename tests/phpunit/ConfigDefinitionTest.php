<?php

declare(strict_types=1);

namespace Keboola\ProcessorIconv\Tests;

use Keboola\ProcessorIconv\ConfigDefinition;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigDefinitionTest extends TestCase
{
    public function testPass(): void
    {
        $sourceConfig = [
            'parameters' => [],
        ];
        $targetConfig = [
            'parameters' => [],
        ];
        $processor = new Processor();
        $cfgDefinition = new ConfigDefinition();
        $processedConfig = $processor->processConfiguration($cfgDefinition, [$sourceConfig]);
        self::assertEquals($targetConfig, $processedConfig);
    }
}
