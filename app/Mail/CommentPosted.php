<?php

namespace App\Mail;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPosted extends Mailable
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
		// First example with full path
		->attach(
		    storage_path('app/public') . '/' . $this->comment->user->image->path,
		    [
		        'as' => 'profile_picture.jpeg',
		        'mime' => 'image/jpeg'
		    ]
		)
		// ->attachFromStorage($this->comment->user->image->path, 'profile_picture.jpeg')
		// ->attachFromStorageDisk('public', $this->comment->user->image->path)
		// ->attachData(Storage::get($this->comment->user->image->path), 'profile_picture_from_data.jpeg', [
		//     'mime' => 'image/jpeg'
		// ])
		->subject($subject)
		->view('emails.posts.commented');
	}
}
