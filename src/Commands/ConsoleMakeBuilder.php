<?php

namespace Devbaze\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ConsoleMakeBuilder extends Command
{
    protected $name = 'make:builder';
    protected $description = 'Make a Flexible Component Blade Template';
    protected $type = 'Console command';

    protected $template_options = [
        'default',
        'hero',
    ];

    protected function getArguments()
    {
        return [
            [ 'name', InputArgument::REQUIRED, 'The name of the class' ],
            [ 'template', InputArgument::OPTIONAL, 'The name of the template', 'default' ],
        ];
    }

    protected function getOptions()
    {
        return [
            [ 'scripts', 'Y', InputOption::VALUE_NONE, 'Add Create Scripts' ],
        ];
    }

    public function handle()
    {
        $name = $this->argument('name');
        $template = $this->argument('template');
        if (!in_array($template, $this->template_options)) {
            return $this->error($template . " is not a valid Template");
        }

        $this->call('make:builder-controller', [ 'name' => $name, 'template' => $template ]);
        $this->call('make:builder-style', [ 'name' => $name, 'template' => $template ]);
        $this->call('make:builder-template', [ 'name' => $name, 'template' => $template ]);
        if ($this->option('scripts')) {
            $this->call('make:builder-script', [ 'name' => $name, 'template' => $template ]);
        }
        return $this->info($name . " finished!");
    }
}
