<?php

namespace App\Livewire\Transaction;

use App\Jobs\SendToPaymentGateway;
use Auth;
use App\Livewire\Transaction\Balance;
use App\Models\Transaction;
use Livewire\Component;
use Illuminate\Support\Str;

class Withdrawl extends Component
{
    public $amount;

    public function __construct()
    {
        $_balance = new Balance();
        $this->balance = $_balance->getBalance();
    }

    protected $listeners = [
        'set-balance' => 'setBalance'
    ];

    public function setBalance($value)
    {
        $this->balance = $value;
    }

    public function rules()
    {
        return [
            'amount' => 'required|lt:' . $this->balance + 1,
        ];
    }

    public function store()
    {
        $this->validate();

        $order_id = Str::uuid();
        $transaction = Transaction::create([
            'order_id' => $order_id,
            'user_id' => Auth::user()->id,
            'amount' => $this->amount,
            'type' => 'withdrawl',
            'status' => 'success',
        ]);

        dispatch(new SendToPaymentGateway($transaction, Auth::user()));

        $this->dispatch('close');
        $this->dispatch('refresh-5');
        $this->dispatch('refresh-table');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.transaction.withdrawl');
    }
}
