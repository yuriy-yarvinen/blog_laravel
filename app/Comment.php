<?php

namespace App;

use App\Scope\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
	use SoftDeletes;
	protected $fillable = [
		'content',
		'user_id'
	]; 
    public function blogPost()
	{
		// return $this->belongsTo('App\BlogPost','post_id', 'blog_post_id');
		return $this->belongsTo(BlogPost::class);
	}

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
			Cache::tags(['blog-post'])->forget("blog-post-$comment->blog_post_id");
			Cache::tags(['blog-post'])->forget("most_commented");
		});
		
	}

}
