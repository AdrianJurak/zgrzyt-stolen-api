<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Gość (niezalogowany użytkownik) nie może pobrać listy użytkowników.
     */
    public function test_guest_cannot_get_users_list(): void
    {
        $response = $this->getJson('/api/users');

        $response->assertUnauthorized();
    }

    /**
     * Test: Zwykły użytkownik ('user') nie ma dostępu do endpointów zarządzania użytkownikami.
     */
    public function test_regular_user_is_forbidden_from_accessing_user_management(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/users');
        $response->assertForbidden();
    }

    /**
     * Test: Użytkownik IT ('it') może pobrać listę wszystkich użytkowników.
     */
    public function test_it_user_can_get_all_users(): void
    {
        $itUser = User::factory()->create(['role' => 'it']);
        User::factory()->count(5)->create();

        Sanctum::actingAs($itUser);

        $response = $this->getJson('/api/users');

        $response->assertOk();
        $response->assertJsonCount(6); // 5 + 1 (użytkownik IT)
    }

    /**
     * Test: Administrator ('admin') może pobrać listę wszystkich użytkowników.
     */
    public function test_admin_user_can_get_all_users(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->count(3)->create();

        Sanctum::actingAs($admin);

        $response = $this->getJson('/api/users');

        $response->assertOk();
        $response->assertJsonCount(4); // 3 + 1 (admin)
    }

    /**
     * Test: Administrator może utworzyć nowego użytkownika.
     */
    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($admin);

        $userData = [
            'name' => 'Test User',
            'login' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'role' => 'user',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Test User', 'email' => 'test@example.com']);

        $this->assertDatabaseHas('users', [
            'login' => 'testuser',
            'email' => 'test@example.com',
        ]);

        $createdUser = User::where('login', 'testuser')->first();
        $this->assertTrue(Hash::check('password123', $createdUser->password));
        $this->assertFalse($createdUser->active);
    }

    /**
     * Test: Użytkownik IT ('it') może aktywować innego użytkownika.
     */
    public function test_it_user_can_activate_user(): void
    {
        $itUser = User::factory()->create(['role' => 'it']);
        $userToActivate = User::factory()->create(['active' => false]);

        Sanctum::actingAs($itUser);

        $response = $this->postJson("/api/users/{$userToActivate->id}/activate");

        $response->assertOk()
                 ->assertJsonPath('user.active', true);

        $this->assertDatabaseHas('users', [
            'id' => $userToActivate->id,
            'active' => true,
        ]);
    }

    /**
     * Test: Administrator ('admin') może odbanować użytkownika.
     */
    public function test_admin_can_unban_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'password' => bcrypt('password')]);
        $bannedUser = User::factory()->create(['banned_at' => now()]);

        Sanctum::actingAs($admin);

        $response = $this->postJson("/api/users/{$bannedUser->id}/unban", [
            'password' => 'password',
        ]);

        $response->assertOk()
                 ->assertJsonPath('user.banned_at', null);

        $this->assertNull($bannedUser->fresh()->banned_at);
    }
}