<?php

namespace App\Http\Livewire;

use App\Models\Poll as polling;
use App\Models\Option;
use Livewire\Component;

class Polls extends Component
{
    protected $listeners = [
        'pollCreated' => 'render'
    ];

    public function render()
    {
        $polls = polling::with('options.votes')
            ->latest()->get();

        return view('livewire.polls', ['polls' => $polls]);
    }

    public function vote(Option $option)
    {
        $option->votes()->create();
    }
}