<?php

namespace Morshadun\RepositoryPattern\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class DesignPatternCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =  'morshadun:controller {name : The Name of the controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a Controller with Service Repository & Transformer';
    /**
     *  The type of class being generated
     * @var string
     */
    protected $type = 'Service Repository Pattern';

    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws FileNotFoundException
     */
    public function handle()
    {

        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);


        // First we will check to see if the class already exists. If it does, we don't want
        // to create the class and overwrite the user's code. So, we will bail out so the
        // code is untouched. Otherwise, we will continue generating this class' files.
        if ((! $this->hasOption('force') ||
                ! $this->option('force')) &&
            $this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($name)));
        $repository = $this->confirm('Do You want to create repository?', true);
        if ($repository)
        {
            $repositoryName = $this->qualifyRepositoryClass(Str::replaceFirst('Controller', 'Repository', $this->getNameInput()));
            $repositoryPath = $this->getPath($repositoryName);
            $this->makeDirectory($repositoryPath);
            $this->files->put($repositoryPath, $this->sortImports($this->buildRepositoryClass($repositoryName)));
            $this->info($repositoryName . ' created successfully.');
        }
        $services = $this->confirm('Do You want to create services?', true);
        if ($services)
        {
            $servicesName = $this->qualifyServicesClass(Str::replaceFirst('Controller', 'Services', $this->getNameInput()));
            $servicesPath = $this->getPath($servicesName);
            $this->makeDirectory($servicesPath);
            $this->files->put($servicesPath, $this->sortImports($this->buildServicesClass($servicesName)));
            $this->info($servicesName . ' created successfully.');
        }
        $transformers = $this->confirm('Do You want to create transformers?', true);
        if ($transformers)
        {
            $transformersName = $this->qualifyTransformersClass(Str::replaceFirst('Controller', 'Transformer', $this->getNameInput()));
            $transformersPath = $this->getPath($transformersName);
            $this->makeDirectory($transformersPath);
            $this->files->put($transformersPath, $this->sortImports($this->buildTransformersClass($transformersName)));
            $this->info($transformersName . ' created successfully.');
        }

        $this->info($this->type.' created successfully.');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        // TODO: Implement getStub() method.
        return __DIR__.'/Stubs/controller.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }

    /**
     * @param $rootNamespace
     * @return string
     */
    protected function getRepositoryNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories';
    }

    /**
     * @param $rootNamespace
     * @return string
     */
    protected function getServicesNamespace($rootNamespace)
    {
        return $rootNamespace.'\Services';
    }

    /**
     * @param $rootNamespace
     * @return string
     */
    protected function getTransformersNamespace($rootNamespace)
    {
        return $rootNamespace.'\Transformers';
    }

    /**
     * @param $name
     * @return string
     * @throws FileNotFoundException
     */
    protected function buildRepositoryClass($name)
    {
        $stub = $this->files->get($this->getRepositoryStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * @param $name
     * @return string
     * @throws FileNotFoundException
     */
    private function buildServicesClass($name)
    {
        $stub = $this->files->get($this->getServicesStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * @param $name
     * @return string
     * @throws FileNotFoundException
     */
    protected function buildTransformersClass($name)
    {
        $stub = $this->files->get($this->getTransformerStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }


    protected function getOptions()
    {
        return [
            ['repository', 'r', InputOption::VALUE_NONE, 'Generate a repository class'],
            ['service', 's', InputOption::VALUE_NONE, 'Generate a service class for repository'],
            ['transformer', 't', InputOption::VALUE_OPTIONAL, 'Generate a transformer class for controller'],
        ];
    }

    /**
     * @return string
     */
    private function getRepositoryStub()
    {
        return __DIR__.'/Stubs/controller.repository.stub';
    }

    /**
     * @return string
     */
    private function getServicesStub()
    {
        return __DIR__.'/Stubs/controller.service.stub';
    }

    /**
     * @return string
     */
    private function getTransformerStub()
    {
        return __DIR__.'/Stubs/controller.transformer.stub';
    }

    /**
     * @param $name
     * @return string
     */
    protected function qualifyRepositoryClass($name)
    {
        $name = ltrim($name, '\\/');

        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        $name = str_replace('/', '\\', $name);

        return $this->qualifyClass(
            $this->getRepositoryNamespace(trim($rootNamespace, '\\')).'\\'.$name
        );
    }

    /**
     * @param $name
     * @return string
     */
    private function qualifyServicesClass($name)
    {
        $name = ltrim($name, '\\/');

        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        $name = str_replace('/', '\\', $name);

        return $this->qualifyClass(
            $this->getServicesNamespace(trim($rootNamespace, '\\')).'\\'.$name
        );
    }

    /**
     * @param $name
     * @return string
     */
    private function qualifyTransformersClass($name)
    {
        $name = ltrim($name, '\\/');

        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        $name = str_replace('/', '\\', $name);

        return $this->qualifyClass(
            $this->getTransformersNamespace(trim($rootNamespace, '\\')).'\\'.$name
        );
    }





}
