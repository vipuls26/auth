<?php

namespace App\Jobs;

use App\Mail\AdminMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendData implements ShouldQueue
{
    use Queueable;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle($data): void
    {
        try {
            Mail::to('vipuls@patoliyainfotech.com')
                ->queue((new AdminMail($data))->onQueue('low'));
        } catch (Exception $e) {
            Log::error('Mail job failed: ' . $e->getMessage());
        }
    }
}
