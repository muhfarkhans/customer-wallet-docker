<?php

namespace App\Livewire\Transaction;

use App\Jobs\SendToPaymentGateway;
use Auth;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Str;

class Deposit extends Component
{
    #[Validate('required|gt:0')]
    public $amount;

    public function store()
    {
        $this->validate();

        $order_id = Str::uuid();
        $transaction = Transaction::create([
            'order_id' => $order_id,
            'user_id' => Auth::user()->id,
            'amount' => $this->amount,
            'type' => 'deposit',
            'status' => 'pending',
        ]);

        dispatch(new SendToPaymentGateway($transaction, Auth::user()));

        $this->dispatch('close');
        $this->dispatch('refresh-5');
        $this->dispatch('refresh-table');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.transaction.deposit');
    }
}
