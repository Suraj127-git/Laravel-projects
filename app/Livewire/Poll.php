<?php

namespace App\Livewire;

use App\Models\Option;
use Livewire\Component;

class Poll extends Component
{
    protected $listeners = [
        'pollCreated' => 'render'
    ];

    public function render()
    {
        $poll_data = \App\Models\Poll::with('options.votes')
            ->latest()->get();

        return view('livewire.poll', ['poll_data' => $poll_data]);
    }

    public function vote(Option $option)
    {
        $option->votes()->create();
    }
}