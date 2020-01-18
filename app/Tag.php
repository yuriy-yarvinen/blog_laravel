<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function blogPost()
	{
		// return $this->belongsToMany(BlogPost::class)->withTimestamps()->as('tagged');
		return $this->morphedByMany(BlogPost::class, 'taggable')->withTimestamps()->as('tagged');
	}
    public function comments()
	{
		return $this->morphedByMany(Comment::class, 'taggable')->withTimestamps()->as('tagged');
	}
}
