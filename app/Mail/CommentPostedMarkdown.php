<?php

namespace App\Mail;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPostedMarkdown extends Mailable
// class CommentPostedMarkdown extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

	public $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

		$subject = "Comment was posted on your blog post {$this->comment->commentable->title}";
        // return $this->subject($subject)->from('admin@yarvinen.ru', 'Admin')->view('emails.posts.commented');
	
		return $this
		// ->attachFromStorage($this->comment->user->image->path, 'profile_picture.jpeg')
		->subject($subject)
        ->markdown('emails.posts.commented-markdown');
    }
}
