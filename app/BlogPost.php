<?php

namespace App;

use App\Scope\DeletedPostAdminScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
	use SoftDeletes;
	//protected $table = 'blogpost';
	
	protected $fillable = ['title', 'content', 'json', 'user_id'];

	public function scopeNewlatest(Builder $query)
	{
		return $query->orderBy(static::CREATED_AT, 'desc');
	}

	public function scopeMostCommented(Builder $query)
	{
		return $query->withCount('comments')->orderBy('comments_count', 'desc');
	}

	public function scopePostWithRelations(Builder $query)
	{
		return $query->scopes('Newlatest')->withCount('comments')->with('tags')->with('user');
	}

	public function comments()
	{
		return $this->hasMany(Comment::class)->latest();
	}

	public function image()
	{
		return $this->hasOne(Image::class);
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class)->withTimestamps()->as('tagged');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public static function boot()
	{
		static::addGlobalScope(new DeletedPostAdminScope);

		parent::boot();

		// static::addGlobalScope(new LatestScope);
		
		static::deleting(function(BlogPost $blogPost){
			$blogPost->comments()->delete();
			// $blogPost->image()->delete();
			Cache::tags(['blog-post'])->forget("blog-post-$blogPost->id");
		});

		static::updating(function(BlogPost $blogPost){
			Cache::tags(['blog-post'])->forget("blog-post-$blogPost->id");
		});

		static::restoring(function(BlogPost $blogPost){
			$blogPost->comments()->restore();
		});

	}
}
