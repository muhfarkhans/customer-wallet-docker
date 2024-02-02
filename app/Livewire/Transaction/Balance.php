<?php

namespace App\Livewire\Transaction;

use Auth;
use DB;
use Livewire\Attributes\On;
use App\Models\Transaction;
use Livewire\Component;

class Balance extends Component
{
    public $balance = 0;

    #[On('refresh-all')]
    public function refreshAll(): void
    {
        $this->balance = $this->getBalance();
        $this->dispatch('refresh-table');
    }

    #[On('refresh-balance')]
    public function refreshBalance(): void
    {
        $this->balance = $this->getBalance();
    }

    public function __construct()
    {
        $this->balance = $this->getBalance();
    }

    public function getBalance($userid = 0)
    {
        $userid = Auth::user()->id;
        $withdrawl = DB::select('select sum(amount) as amount from transactions where user_id = ? and type = \'withdrawl\' and status = \'success\'', [$userid]);
        $deposit = DB::select('select sum(amount) as amount from transactions where user_id = ? and type = \'deposit\' and status = \'success\'', [$userid]);

        return $deposit[0]->amount - $withdrawl[0]->amount;
    }

    public function render()
    {
        return view('livewire.transaction.balance');
    }
}
