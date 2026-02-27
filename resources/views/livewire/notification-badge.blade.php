<span wire:poll.30s="refreshCount">
    @if ($count > 0)
        <span class="badge badge-danger">{{ $count }}</span>
    @endif
</span>
