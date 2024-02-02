<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class SendToPaymentGateway implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    public $user;
    /**
     * Create a new job instance.
     */
    public function __construct($data, $user)
    {
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [new WithoutOverlapping($this->user->id)];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::withToken(base64_encode($this->user->name))->post('webserver/api/transaction', [
            'order_id' => $this->data->order_id,
            'amount' => $this->data->amount,
            'timestamp' => $this->data->created_at,
        ]);

        try {
            if (!$response->failed()) {
                $res = $response->object();
                $order_id = $res->order_id;
                $status = ($res->status == 0 ? 'success' : 'failed');

                Transaction::where('order_id', $order_id)->update([
                    'status' => $status,
                ]);
            }
        } catch (\Throwable $th) {
            throw new \Exception(json_encode($th), 1);
        }

    }
}
