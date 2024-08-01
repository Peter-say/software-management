<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class HotelSoftwareMakeModel extends Command
{
    protected $signature = 'hotelsoftware:make-model {name}';
    protected $description = 'Create a new model and migration for Hotel Software';

    public function handle()
    {
        $name = $this->argument('name');
        $modelPath = app_path("HotelSoftware/{$name}.php");
        $migrationPath = database_path('migrations');
        
        // Ensure the directories exist
        if (!file_exists($migrationPath)) {
            mkdir($migrationPath, 0777, true);
        }

        // Generate the model
        $this->call('make:model', [
            'name' => "HotelSoftware/{$name}"
        ]);

        // Generate the migration with the table name
        $table = Str::snake(Str::pluralStudly(class_basename($name)));
        $timestamp = date('Y_m_d_His');
        $migrationName = "{$timestamp}_create_{$table}_table.php";
        $migrationFullPath = "{$migrationPath}/{$migrationName}";
        
        Artisan::call('make:migration', [
            'name' => "create_{$table}_table",
            '--path' => 'database/migrations'
        ]);

        $this->info("Model created at {$modelPath}");
        $this->info("Migration created at {$migrationFullPath}");
    }
}
