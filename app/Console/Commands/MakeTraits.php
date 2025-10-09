<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class MakeTraits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:traits {name : Name of the Traits CLass}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new traits class';

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
        $path = app_path("Traits/{$name}.php");

        if ($this->files->exists($path)) 
        {
            $this->error("Traits {$name} already exists!");
            return SymfonyCommand::FAILURE;
        }

        $this->makeDirectory($path);

        $stub = $this->getStub($name);
        $this->files->put($path, $stub);

        $this->info("Traits {$name} created successfully!");
        return SymfonyCommand::SUCCESS;
    }

    /**
     * Get the traits class stub.
     */
    protected function getStub(string $name): string
    {
        return <<<EOT
<?php

namespace App\Traits;

class {$name}
{
    // Add your traits methods here
}
EOT;
    }

    /**
     * Create the directory for the traits if it doesn't exist.
     */
    protected function makeDirectory(string $path): void
    {
        $directory = dirname($path);

        if (!$this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }
    }
}
