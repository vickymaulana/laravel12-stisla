<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuperadminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_superadmin_cannot_access_superadmin_routes(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('settings.index'));

        $response->assertForbidden();
    }
}
