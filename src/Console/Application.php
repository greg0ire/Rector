<?php declare(strict_types=1);

namespace Rector\Console;

use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

final class Application extends SymfonyApplication
{
    /**
     * @var string
     */
    private const NAME = 'Rector';

    public function __construct()
    {
        parent::__construct(self::NAME);
    }

    /**
     * This method override adds option to load custom config via --config in any command.
     * And --level option as well.
     */
    protected function getDefaultInputDefinition(): InputDefinition
    {
        return new InputDefinition([
            new InputArgument('command', InputArgument::REQUIRED, 'The command to execute'),
            new InputOption(
                '--config',
                null,
                InputOption::VALUE_REQUIRED,
                'Path to config file.',
                getcwd() . '/rector.yml'
            ),
            new InputOption(
                '--level',
                null,
                InputOption::VALUE_REQUIRED,
                'Finds config by shortcut name.'
            ),
            new InputOption('--help', '-h', InputOption::VALUE_NONE, 'Display this help message'),
            new InputOption('--ansi', '', InputOption::VALUE_NONE, 'Force ANSI output'),
            new InputOption('--no-ansi', '', InputOption::VALUE_NONE, 'Disable ANSI output'),
        ]);
    }
}
