<?php

namespace App\Livewire;

use App\Traits\MediaBrowser;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MediaBrowserModal extends Component
{
    use MediaBrowser;

    public bool $multiple = false;

    public string $statePath = '';

    public function mount(bool $multiple = false, string $statePath = ''): void
    {
        $this->multiple = $multiple;
        $this->statePath = $statePath;
    }

    public function render(): View
    {
        return view('livewire.media-browser-modal');
    }
}
