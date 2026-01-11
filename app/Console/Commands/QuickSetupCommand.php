<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class QuickSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:quick';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quick setup for first-time installation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Laravel 12 Stisla Quick Setup');
        $this->newLine();

        // Step 1: Check environment file
        $this->info('Step 1: Checking environment file...');
        if (!file_exists(base_path('.env'))) {
            $this->warn('.env file not found. Creating from .env.example...');
            copy(base_path('.env.example'), base_path('.env'));
            $this->info('✓ .env file created');
        } else {
            $this->info('✓ .env file exists');
        }
        $this->newLine();

        // Step 2: Generate app key
        $this->info('Step 2: Generating application key...');
        if (empty(config('app.key'))) {
            Artisan::call('key:generate');
            $this->info('✓ Application key generated');
        } else {
            $this->info('✓ Application key already exists');
        }
        $this->newLine();

        // Step 3: Storage link
        $this->info('Step 3: Creating storage link...');
        if (!file_exists(public_path('storage'))) {
            Artisan::call('storage:link');
            $this->info('✓ Storage link created');
        } else {
            $this->info('✓ Storage link already exists');
        }
        $this->newLine();

        // Step 4: Clear caches
        $this->info('Step 4: Clearing application cache...');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        $this->info('✓ All caches cleared');
        $this->newLine();

        // Step 5: Database setup prompt
        $this->info('Step 5: Database setup');
        if ($this->confirm('Would you like to run migrations?', true)) {
            $this->info('Running migrations...');
            Artisan::call('migrate', ['--force' => true]);
            $this->info('✓ Migrations completed');

            if ($this->confirm('Would you like to seed default settings?', true)) {
                $this->info('Seeding settings...');
                Artisan::call('db:seed', ['--class' => 'SettingSeeder', '--force' => true]);
                $this->info('✓ Settings seeded');
            }
        }
        $this->newLine();

        // Step 6: File permissions
        $this->info('Step 6: Checking file permissions...');
        $storagePath = storage_path();
        $bootstrapCachePath = base_path('bootstrap/cache');
        
        if (is_writable($storagePath) && is_writable($bootstrapCachePath)) {
            $this->info('✓ Storage and cache directories are writable');
        } else {
            $this->warn('⚠ Some directories may not be writable. Run:');
            $this->warn('  chmod -R 775 storage bootstrap/cache');
        }
        $this->newLine();

        // Summary
        $this->info('✨ Setup completed!');
        $this->newLine();
        $this->info('Next steps:');
        $this->line('  1. Configure your .env file with database credentials');
        $this->line('  2. Run: npm install && npm run dev (for frontend assets)');
        $this->line('  3. Run: php artisan serve (to start development server)');
        $this->line('  4. Visit: http://localhost:8000');
        $this->newLine();
        $this->info('Happy coding! 💻✨');

        return Command::SUCCESS;
    }
}
