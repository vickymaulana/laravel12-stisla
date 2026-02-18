<?php

namespace Tests\Feature\FileManager;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FileOwnershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_access_another_users_file(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $file = File::create([
            'user_id' => $owner->id,
            'name' => 'example.pdf',
            'original_name' => 'example.pdf',
            'path' => 'uploads/example.pdf',
            'mime_type' => 'application/pdf',
            'size' => 1200,
            'extension' => 'pdf',
            'folder' => '/',
            'is_public' => false,
        ]);

        $response = $this->actingAs($otherUser)->get(route('file-manager.download', $file->id));

        $response->assertNotFound();
    }
}
