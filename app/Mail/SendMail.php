<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $validated;

    protected $fillable = [
      'name', 'email', 'job_title', 'subject', 'phone', 'message'
    ];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($validated)
    {
      $this->validated = $validated;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('layouts.contact_mail_template')->with(['validated' => $this->validated]);
    }
}

?>
