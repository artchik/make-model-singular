<?php

namespace Artchik\MakeModelSingular\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;


class ModelSingularMakeCommand extends ModelMakeCommand
{

    protected $name = 'make:model-singular';
    protected $table = null;
    protected $cdir = null;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->option('table')) {
            $this->table = $this->option('table');
        }

        if ($this->option('cdir')) {
            $this->cdir = $this->option('cdir');
        }

        parent::handle();
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
            ->replaceTable($stub, $this->table ?? Str::snake(class_basename($name)))
            ->replaceClass($stub, $name);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('pivot')) {
            return parent::getStub();
        }

        return __DIR__ . '/stubs/model.stub';
    }

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createMigration()
    {
        $table = $this->table ?? Str::snake(class_basename($this->argument('name')));

        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);

    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceTable(&$stub, $name)
    {
        $stub = str_replace(
            '{{ table_name }}',
            $name,
            $stub
        );

        return $this;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        $options = parent::getOptions();
        array_push($options, ['table', null, InputOption::VALUE_OPTIONAL, 'Use a custom table name']);
        array_push($options, ['cdir', null, InputOption::VALUE_OPTIONAL, 'Use a sub-directory for the controller']);
        return $options;
    }


    public function call($command, array $arguments = [])
    {
        if ($command == 'make:controller' && $this->cdir) {
            $arguments['name'] = $this->cdir . '\\' . $arguments['name'];
        }
        parent::call($command, $arguments);
    }
}
