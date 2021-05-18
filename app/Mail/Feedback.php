<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Feedback extends Mailable
{
    use Queueable, SerializesModels;

    protected $nama = null;
    protected $email = null;
    protected $pesan = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nama, $email, $pesan)
    {
        $this->nama = $nama;
        $this->email = $email;
        $this->pesan = $pesan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.feedback')
            ->with([
                'nama' => $this->nama,
                'email' => $this->email,
                'pesan' => $this->pesan
            ]);
    }
}
