<?php

namespace Tests\Feature\Notifications;

use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_unread_count_and_recent_endpoints_return_expected_data(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $user->notify(new GeneralNotification('Welcome', 'Hello user'));
        $user->notify(new GeneralNotification('Reminder', 'Complete your profile'));

        $countResponse = $this->get(route('notifications.unread-count'));
        $countResponse->assertOk()->assertJson(['count' => 2]);

        $recentResponse = $this->get(route('notifications.recent'));
        $recentResponse->assertOk()->assertJsonCount(2);
    }
}
