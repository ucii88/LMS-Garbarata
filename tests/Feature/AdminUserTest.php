<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_user_that_can_login(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'email' => 'contoh@lms.com',
            'password' => 'password',
            'role' => 'peserta',
        ]);

        $response
            ->assertRedirect(route('dashboard', absolute: false))
            ->assertSessionHas('success', 'Berhasil menambahkan akun contoh@lms.com, sebagai peserta.');

        $createdUser = User::where('email', 'contoh@lms.com')->first();

        $this->assertNotNull($createdUser);
        $this->assertSame('peserta', $createdUser->role);
        $this->assertSame('Contoh', $createdUser->name);
        $this->assertTrue(Hash::check('password', $createdUser->password));

        auth()->logout();

        $this->post('/login', [
            'email' => 'contoh@lms.com',
            'password' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticatedAs($createdUser);
    }

    public function test_admin_gets_failed_flash_message_when_user_creation_is_invalid(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->create([
            'email' => 'contoh@lms.com',
            'role' => 'instruktur',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'email' => 'contoh@lms.com',
            'password' => 'password',
            'role' => 'instruktur',
        ]);

        $response
            ->assertRedirect(route('dashboard', absolute: false))
            ->assertSessionHasErrors('email')
            ->assertSessionHas('error', 'Gagal menambahkan akun contoh@lms.com, sebagai instruktur.');
    }
}
