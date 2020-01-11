<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function blogPost()
	{
		return $this->belongsToMany(BlogPost::class)->withTimestamps()->as('tagged');
	}
}
