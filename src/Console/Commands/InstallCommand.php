<?php

namespace KozhinhikkodanDev\ArtisanPlayground\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'artisan-playground:install {--force : Force the installation}';

    /**
     * The console command description.
     */
    protected $description = 'Install Artisan Playground package with permissions and roles';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Installing Artisan Playground...');

        // Create permissions
        $this->createPermissions();

        // Create roles
        $this->createRoles();

        // Publish assets
        $this->publishAssets();

        $this->info('Artisan Playground installed successfully!');
        $this->info('You can now access it at: ' . url('/artisan-playground'));

        return self::SUCCESS;
    }

    /**
     * Create permissions for Artisan Playground.
     */
    protected function createPermissions(): void
    {
        $permissions = [
            'artisan-playground.view',
            'artisan-playground.execute',
            'artisan-playground.execute-dangerous',
            'artisan-playground.delete',
            'artisan-playground.restore',
            'artisan-playground.force-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
            $this->line("Created permission: {$permission}");
        }
    }

    /**
     * Create roles for Artisan Playground.
     */
    protected function createRoles(): void
    {
        // Super Admin role
        $superAdmin = Role::firstOrCreate(['name' => 'artisan-playground-super-admin']);
        $superAdmin->givePermissionTo(Permission::all());
        $this->line('Created role: artisan-playground-super-admin');

        // Admin role
        $admin = Role::firstOrCreate(['name' => 'artisan-playground-admin']);
        $admin->givePermissionTo([
            'artisan-playground.view',
            'artisan-playground.execute',
            'artisan-playground.execute-dangerous',
            'artisan-playground.delete',
        ]);
        $this->line('Created role: artisan-playground-admin');

        // User role
        $user = Role::firstOrCreate(['name' => 'artisan-playground-user']);
        $user->givePermissionTo([
            'artisan-playground.view',
            'artisan-playground.execute',
        ]);
        $this->line('Created role: artisan-playground-user');
    }

    /**
     * Publish package assets.
     */
    protected function publishAssets(): void
    {
        $this->call('vendor:publish', [
            '--tag' => 'artisan-playground',
            '--force' => $this->option('force'),
        ]);
    }
}