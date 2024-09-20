<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

use App\Mail\SendEmail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $toEmail;
    public $message;
    public $subject;

    /**
     * Create a new job instance.
     *
     * @param string $toEmail
     * @param string $message
     * @param string $subject
     */
    public function __construct($toEmail, $message, $subject)
    {
        $this->toEmail = $toEmail;
        $this->message = $message;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Mail::to($toEmail)->send(new SendEmail());
        Mail::to($this->toEmail)->send(new SendEmail($this->message, $this->subject));
    }
}
