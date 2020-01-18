<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
	];
	
	public function image()
	{
		return $this->morphOne(Image::class, 'imageable');
	}

	public function blogPosts(){
		return $this->hasMany(BlogPost::class);
	}
	public function comments(){
		return $this->hasMany(Comment::class);
	}

	public function commentsOn()
	{
		// return $this->hasMany(Comment::class)->latest();
		return $this->morphMany(Comment::class, 'commentable')->latest();
	}

	public function scopeMostActive(Builder $query)
	{
		return $query->withCount('blogPosts')->orderBy('blog_posts_count', 'desc');
	}

	public function scopeMostActiveLastMonth(Builder $query)
	{
		return $query->withCount(['blogPosts' => function(Builder $query){
			$query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
		}])->has('blogPosts', '>=', '2')->orderBy('blog_posts_count', 'desc');
		
	}

	public function scopeReturnUserHoCommentThisPost(Builder $query, BlogPost $post)
	{
		return $query->whereHas('comments', function($query) use ($post) {
			return $query->where('commentable_id', '=', $post->id)
				->where('commentable_type', '=', BlogPost::class);
		});
		
	}
}
