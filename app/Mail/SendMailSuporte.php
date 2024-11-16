<?php

namespace App\Mail;

use App\Helpers\SettingHelpers;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailSuporte extends Mailable
{
    use Queueable, SerializesModels;

    public $notify_text, $notify_subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notify_text, $notify_subject)
    {
        $this->notify_text = $notify_text;
        $this->notify_subject = $notify_subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $setting = SettingHelpers::getList();
        $from = $setting['setting_email_email_email'] ?? 'suporte@cleverweb.com.br';

        return $this->from($from)
            ->subject($this->notify_subject)
            ->view('emails.notify')
            ->with([                        
                'notify_text' => $this->notify_text
            ]);
            //->html($this->notify_text);
    }
}