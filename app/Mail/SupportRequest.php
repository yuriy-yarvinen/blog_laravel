<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

	public $request;
	
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$subject = "Request to support";
		// return $this->subject($subject)->from('admin@yarvinen.ru', 'Admin')->view('emails.posts.commented');
		
		
	
		return $this
		->subject($subject)
		->attachFromStorage($this->request->path, 'support_picture.jpeg')
		->view('emails.support');
    }
}
