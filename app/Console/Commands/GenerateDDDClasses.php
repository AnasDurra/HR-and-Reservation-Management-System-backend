<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateDDDClasses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ddd:generate-ddd-classes {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelName = $this->argument('model');

        $interfaceContent = $this->generateInterfaceContent($modelName);
        $this->generateClass('Domain/Repositories', "{$modelName}RepositoryInterface", $interfaceContent);

        $implementationContent = $this->generateImplementationContent($modelName);
        $this->generateClass('Infrastructure/Persistence/Eloquent', "Eloquent{$modelName}Repository", $implementationContent);

        $serviceContent = $this->generateServiceContent($modelName);
        $this->generateClass('Domain/Services', "{$modelName}Service", $serviceContent);

        $resourceContent = $this->generateResourceContent($modelName);
        $this->generateClass('Application/Http/Resources', "{$modelName}Resource", $resourceContent);

        $controllerContent = $this->generateControllerContent($modelName);
        $this->generateClass('Application/Http/Controllers', "{$modelName}Controller", $controllerContent);
    }
    public function generateInterfaceContent(string $modelName): string
    {
        $modelClass = "App\\Domain\\Models\\{$modelName}";

        $interfaceContent = "<?php

namespace App\Domain\Repositories;

use {$modelClass};

interface {$modelName}RepositoryInterface
{
    public function getList(): array;

    public function getById(int \$id): ?{$modelName};

    public function create(array \$data): {$modelName};

    public function update(int \$id, array \$data): {$modelName};

    public function delete(\$id): {$modelName};
}";

        return $interfaceContent;
    }

    protected function generateImplementationContent(string $modelName): string
    {
        $modelClass = "App\\Domain\\Models\\{$modelName}";

        $implementationContent = "<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\\{$modelName}RepositoryInterface;
use {$modelClass};

class Eloquent{$modelName}Repository implements {$modelName}RepositoryInterface
{
    public function getList(): array
    {
        // TODO: Implement the logic to retrieve a list of {$modelName}s
    }

    public function getById(int \$id): ?{$modelName}
    {
        // TODO: Implement the logic to retrieve a {$modelName} by ID
    }

    public function create(array \$data): {$modelName}
    {
        // TODO: Implement the logic to create a {$modelName}
    }

    public function update(int \$id, array \$data): {$modelName}
    {
        // TODO: Implement the logic to update a {$modelName}
    }

    public function delete(\$id): {$modelName}
    {
        // TODO: Implement the logic to delete a {$modelName}
    }
}";

        return $implementationContent;
    }

    protected function generateServiceContent(string $modelName): string
    {
        $modelClass = "App\\Domain\\Models\\{$modelName}";
        $repositoryInterface = "{$modelName}RepositoryInterface";

        $serviceContent = "<?php

namespace App\Domain\Services;

use App\Domain\Repositories\\{$repositoryInterface};
use {$modelClass};

class {$modelName}Service
{
    /** @var {$repositoryInterface} */
    private \${$modelName}Repository;

    public function __construct({$repositoryInterface} \${$modelName}Repository)
    {
        \$this->{$modelName}Repository = \${$modelName}Repository;
    }

    public function getList(): array
    {
        return \$this->{$modelName}Repository->getList();
    }

    public function getById(int \$id): ?{$modelName}
    {
        return \$this->{$modelName}Repository->getById(\$id);
    }

    public function create(array \$data): {$modelName}
    {
        return \$this->{$modelName}Repository->create(\$data);
    }

    public function update(int \$id, array \$data): {$modelName}
    {
        return \$this->{$modelName}Repository->update(\$id, \$data);
    }

    public function delete(\$id): {$modelName}
    {
        return \$this->{$modelName}Repository->delete(\$id);
    }
}";

        return $serviceContent;
    }

    protected function generateResourceContent(string $modelName): string
    {
        $resourceContent = "<?php

namespace App\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\Models\\{$modelName};

class {$modelName}Resource extends JsonResource
{
    public function toArray(Request \$request): array
    {
        return parent::toArray(\$request);
    }
}";

        return $resourceContent;
    }


    protected function generateControllerContent(string $modelName): string
    {
        $resourceClass = "{$modelName}Resource";
        $serviceClass = "{$modelName}Service";

        $controllerContent = "<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Resources\\{$resourceClass};
use App\Domain\Services\\{$serviceClass};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class {$modelName}Controller extends Controller
{
    private \${$serviceClass};

    public function __construct({$serviceClass} \${$serviceClass})
    {
        \$this->{$serviceClass} = \${$serviceClass};
    }

    public function index(): JsonResponse
    {
        \$items = \$this->{$serviceClass}->getList();
        return {$resourceClass}::collection(\$items);
    }

    public function show(int \$id): JsonResponse
    {
        \$item = \$this->{$serviceClass}->getById(\$id);
        return new {$resourceClass}(\$item);
    }

    public function store(): JsonResponse
    {
        \$item = \$this->{$serviceClass}->create(request()->all());
        return new {$resourceClass}(\$item);
    }

    public function update(int \$id): JsonResponse
    {
        \$item = \$this->{$serviceClass}->update(\$id, request()->all());
        return new {$resourceClass}(\$item);
    }

    public function destroy(int \$id): JsonResponse
    {
        \$item = \$this->{$serviceClass}->delete(\$id);
        return new {$resourceClass}(\$item);
    }
}";

        return $controllerContent;
    }



    protected function generateClass(string $directory, string $className, string $content)
    {
        $path = app_path($directory . '/' . $className . '.php');
        file_put_contents($path, $content);
    }

}

