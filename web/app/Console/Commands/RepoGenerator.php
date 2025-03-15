<?php


namespace App\Console\Commands;


use Illuminate\Console\Command;


class RepoGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo
{name : Class (singular) for example User}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Repositories Folders and files.';


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


        $this->model($name);
        $this->request($name);
        $this->repository($name);
        $this->interface($name);
        $this->transformable($name);
        $this->exceptions($name);
        $this->info('Repository generated for "' . $name . '"');
    }


    protected function model($name)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Model')
        );
        if (!file_exists($path = app_path("Models/{$name}")))
            mkdir($path, 0777, true);
        file_put_contents(app_path("Models/{$name}/{$name}.php"), $modelTemplate);
    }


    protected function request($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );
        if (!file_exists($path = app_path("Models/{$name}/Requests")))
            mkdir($path, 0777, true);
        file_put_contents(app_path("Models/{$name}/Requests/{$name}CreateRequest.php"), $requestTemplate);
    }


    protected function repository($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Repository')
        );
        if (!file_exists($path = app_path("Models/{$name}/Repositories")))
            mkdir($path, 0777, true);
        file_put_contents(app_path("Models/{$name}/Repositories/{$name}Repository.php"), $requestTemplate);
    }


    protected function interface($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Interface')
        );
        if (!file_exists($path = app_path("Models/{$name}/Repositories/Interfaces")))
            mkdir($path, 0777, true);
        file_put_contents(app_path("Models/{$name}/Repositories/Interfaces/{$name}RepositoryInterface.php"), $requestTemplate);
    }


    protected function transformable($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Transformable')
        );
        if (!file_exists($path = app_path("Models/{$name}/Transformations")))
            mkdir($path, 0777, true);
        file_put_contents(app_path("Models/{$name}/Transformations/{$name}Transformable.php"), $requestTemplate);
    }


    protected function exceptions($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Exceptions')
        );
        if (!file_exists($path = app_path("Models/{$name}/Exceptions")))
            mkdir($path, 0777, true);
        file_put_contents(app_path("Models/{$name}/Exceptions/Create{$name}ErrorException.php"), $requestTemplate);
    }


    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }
}
