<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationBadge extends Component
{
    public int $count = 0;

    public function mount(): void
    {
        $this->refreshCount();
    }

    public function refreshCount(): void
    {
        $this->count = Auth::user()?->unreadNotifications()->count() ?? 0;
    }

    public function render()
    {
        return view('livewire.notification-badge');
    }
}
