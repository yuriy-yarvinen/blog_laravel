<?php

namespace App;

use App\Scope\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
	use SoftDeletes, Taggable;
	protected $fillable = [
		'content',
		'user_id'
	]; 
    // public function blogPost()
	// {
	// 	// return $this->belongsTo('App\BlogPost','post_id', 'blog_post_id');
	// 	return $this->belongsTo(BlogPost::class);
	// }

	public function commentable(){
		return $this->morphTo();
	}


	// move to a trait App\Traits\Taggable.php
	// public function tags()
	// {
	// 	// return $this->belongsToMany(Tag::class)->withTimestamps()->as('tagged');
	// 	return $this->morphToMany(Tag::class, 'taggable')->withTimestamps()->as('tagged');
	// }

	public function scopeLatest(Builder $query)
	{
		return $query->orderBy(static::CREATED_AT, 'desc');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public static function boot()
	{
		parent::boot();

		// static::addGlobalScope(new LatestScope);

		static::creating(function(Comment $comment){
			if ($comment->commentable_type === BlogPost::class) {
				Cache::tags(['blog-post'])->forget("blog-post-$comment->commentable_id");
				Cache::tags(['blog-post'])->forget("most_commented");				
			}
			if ($comment->commentable_type === User::class) {
				# code...
			}

		});
		
	}

}
