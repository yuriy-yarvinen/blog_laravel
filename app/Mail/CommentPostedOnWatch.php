<?php

namespace App\Mail;

use App\Comment;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPostedOnWatch extends Mailable
{
	use Queueable, SerializesModels;
	
	public $comment;
	public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, User $user)
    {
		$this->user = $user;
		$this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.posts.comment-posted-on-watch');
    }
}
