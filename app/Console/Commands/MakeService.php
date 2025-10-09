<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : Name of the Service CLass}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new service class';

    public function __construct(protected Filesystem $files)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Services/{$name}.php");

        if ($this->files->exists($path)) 
        {
            $this->error("Service {$name} already exists!");
            return SymfonyCommand::FAILURE;
        }

        $this->makeDirectory($path);

        $stub = $this->getStub($name);
        $this->files->put($path, $stub);

        $this->info("Service {$name} created successfully!");
        return SymfonyCommand::SUCCESS;
    }

    /**
     * Get the service class stub.
     */
    protected function getStub(string $name): string
    {
        return <<<EOT
<?php

namespace App\Services;

class {$name}
{
    // Add your service methods here
}
EOT;
    }

    /**
     * Create the directory for the service if it doesn't exist.
     */
    protected function makeDirectory(string $path): void
    {
        $directory = dirname($path);

        if (!$this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }
    }
}
