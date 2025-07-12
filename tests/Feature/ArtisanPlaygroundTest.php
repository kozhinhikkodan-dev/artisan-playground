<?php

namespace KozhinhikkodanDev\ArtisanPlayground\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ArtisanPlaygroundTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Create permissions
        Permission::create(['name' => 'artisan-playground.view']);
        Permission::create(['name' => 'artisan-playground.execute']);
        Permission::create(['name' => 'artisan-playground.execute-dangerous']);
    }

    /** @test */
    public function it_redirects_unauthenticated_users_to_login()
    {
        $response = $this->get('/artisan-playground');

        $response->assertRedirect('/artisan-playground/login');
    }

    /** @test */
    public function it_allows_authenticated_users_with_permission_to_access_dashboard()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('artisan-playground.view');

        $response = $this->actingAs($user)
            ->get('/artisan-playground');

        $response->assertStatus(200);
        $response->assertSee('Artisan Playground');
    }

    /** @test */
    public function it_denies_access_to_users_without_permission()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/artisan-playground');

        $response->assertStatus(403);
    }

    /** @test */
    public function it_can_execute_safe_commands()
    {
        $user = User::factory()->create();
        $user->givePermissionTo(['artisan-playground.view', 'artisan-playground.execute']);

        $response = $this->actingAs($user)
            ->postJson('/artisan-playground/execute', [
                'command' => 'list',
                'arguments' => [],
                'options' => []
            ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    /** @test */
    public function it_denies_execution_of_dangerous_commands_without_permission()
    {
        $user = User::factory()->create();
        $user->givePermissionTo(['artisan-playground.view', 'artisan-playground.execute']);

        $response = $this->actingAs($user)
            ->postJson('/artisan-playground/execute', [
                'command' => 'migrate:fresh',
                'arguments' => [],
                'options' => []
            ]);

        $response->assertStatus(403);
        $response->assertJson(['success' => false]);
    }

    /** @test */
    public function it_allows_execution_of_dangerous_commands_with_permission()
    {
        $user = User::factory()->create();
        $user->givePermissionTo([
            'artisan-playground.view',
            'artisan-playground.execute',
            'artisan-playground.execute-dangerous'
        ]);

        $response = $this->actingAs($user)
            ->postJson('/artisan-playground/execute', [
                'command' => 'migrate:fresh',
                'arguments' => [],
                'options' => []
            ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_shows_command_history()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('artisan-playground.view');

        $response = $this->actingAs($user)
            ->get('/artisan-playground/history');

        $response->assertStatus(200);
        $response->assertSee('Command History');
    }

    /** @test */
    public function it_validates_command_execution_input()
    {
        $user = User::factory()->create();
        $user->givePermissionTo(['artisan-playground.view', 'artisan-playground.execute']);

        $response = $this->actingAs($user)
            ->postJson('/artisan-playground/execute', [
                'arguments' => 'invalid',
                'options' => 'invalid'
            ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_handles_custom_authentication()
    {
        config(['artisan-playground.auth.custom_credentials.enabled' => true]);
        config(['artisan-playground.auth.custom_credentials.username' => 'admin']);
        config(['artisan-playground.auth.custom_credentials.password' => 'password']);

        $response = $this->post('/artisan-playground/login', [
            'username' => 'admin',
            'password' => 'password'
        ]);

        $response->assertRedirect('/artisan-playground');
    }

    /** @test */
    public function it_denies_invalid_custom_credentials()
    {
        config(['artisan-playground.auth.custom_credentials.enabled' => true]);
        config(['artisan-playground.auth.custom_credentials.username' => 'admin']);
        config(['artisan-playground.auth.custom_credentials.password' => 'password']);

        $response = $this->post('/artisan-playground/login', [
            'username' => 'admin',
            'password' => 'wrong'
        ]);

        $response->assertSessionHasErrors('username');
    }

    /** @test */
    public function it_enforces_ip_restrictions()
    {
        config(['artisan-playground.access_control.allowed_ips' => ['127.0.0.1']]);

        $user = User::factory()->create();
        $user->givePermissionTo('artisan-playground.view');

        // Mock different IP
        $this->withHeaders(['X-Forwarded-For' => '192.168.1.1']);

        $response = $this->actingAs($user)
            ->get('/artisan-playground');

        $response->assertStatus(403);
    }

    /** @test */
    public function it_allows_access_from_whitelisted_ips()
    {
        config(['artisan-playground.access_control.allowed_ips' => ['127.0.0.1']]);

        $user = User::factory()->create();
        $user->givePermissionTo('artisan-playground.view');

        $response = $this->actingAs($user)
            ->get('/artisan-playground');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_saves_command_execution_to_database()
    {
        $user = User::factory()->create();
        $user->givePermissionTo(['artisan-playground.view', 'artisan-playground.execute']);

        config(['artisan-playground.execution.save_history' => true]);

        $this->actingAs($user)
            ->postJson('/artisan-playground/execute', [
                'command' => 'list',
                'arguments' => [],
                'options' => []
            ]);

        $this->assertDatabaseHas('artisan_commands', [
            'command_name' => 'list',
            'executed_by' => $user->id,
        ]);
    }

    /** @test */
    public function it_marks_dangerous_commands_correctly()
    {
        $user = User::factory()->create();
        $user->givePermissionTo([
            'artisan-playground.view',
            'artisan-playground.execute',
            'artisan-playground.execute-dangerous'
        ]);

        config(['artisan-playground.execution.save_history' => true]);

        $this->actingAs($user)
            ->postJson('/artisan-playground/execute', [
                'command' => 'migrate:fresh',
                'arguments' => [],
                'options' => []
            ]);

        $this->assertDatabaseHas('artisan_commands', [
            'command_name' => 'migrate:fresh',
            'is_dangerous' => true,
        ]);
    }
}