<?php

namespace App\Livewire;

use Auth;
use DB;
use Livewire\Attributes\On;
use App\Models\Transaction;
use Livewire\Component;

class Profile extends Component
{
    public $balance = 0;

    public function render()
    {
        return view('livewire.dashboard.profile-stats');
    }
}
