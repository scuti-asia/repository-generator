<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RepositoryGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repository:generator {name : Class (singular) for example User}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Repository operations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        $this->controller($name);
        $this->model($name);
        $this->request($name);

        $this->baseFolderRepositories();
        $this->baseRepositoryInterface();
        $this->baseEloquentRepository();

        $this->folderRepositories($name);
        $this->repositoryInterface($name);
        $this->eloquentRepository($name);

        File::append(
            base_path('routes/api.php'),
            'Route::resource(\'' . str_plural(strtolower($name)) . "', '{$name}Controller');"
        );
    }

    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    protected function model($name)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Model')
        );

        if(!file_exists($path = app_path('/Models'))) {
            mkdir($path, 0777, true);
        }

        file_put_contents(app_path("/Models/{$name}.php"), $modelTemplate);
    }

    protected function controller($name)
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                strtolower(str_plural($name)),
                strtolower($name)
            ],
            $this->getStub('Controller')
        );

        file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerTemplate);
    }

    protected function request($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );

        if(!file_exists($path = app_path('/Http/Requests'))) {
            mkdir($path, 0777, true);
        }

        file_put_contents(app_path("/Http/Requests/{$name}Request.php"), $requestTemplate);
    }

    protected function baseFolderRepositories()
    {
        if(!file_exists($path = app_path('/Repositories'))) {
            mkdir($path, 0777, true);
        }
    }

    protected function baseRepositoryInterface()
    {
        if(!file_exists(app_path('/Repositories/RepositoryInterface.php'))) {
            file_put_contents(
                app_path("/Repositories/RepositoryInterface.php"),
                $this->getStub('BaseRepositoryInterface')
            );
        }
    }

    protected function baseEloquentRepository()
    {
        if(!file_exists(app_path('/Repositories/EloquentRepository.php'))) {
            file_put_contents(
                app_path("/Repositories/EloquentRepository.php"),
                $this->getStub("BaseEloquentRepository")
            );
        }
    }

    protected function folderRepositories($name)
    {
        if(!file_exists($path = app_path("/Repositories/{$name}Repository"))) {
            mkdir($path, 0777, true);
        }
    }    

    protected function repositoryInterface($name)
    {
        $repositoryInterfaceTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('RepositoryInterface')
        );

        if(!file_exists($path = app_path('/Repositories/{$name}RepositoryInterface.php'))) {
            file_put_contents(
                app_path("/Repositories/{$name}Repository/{$name}RepositoryInterface.php"),
                $repositoryInterfaceTemplate
            );
        }
    }

    protected function eloquentRepository($name)
    {
        $eloquentRepositoryTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('EloquentRepository')
        );

        if(!file_exists($path = app_path('/Repositories/{$name}EloquentRepository.php'))) {
            file_put_contents(
                app_path("/Repositories/{$name}Repository/{$name}EloquentRepository.php"),
                $eloquentRepositoryTemplate
            );
        }
    }
}