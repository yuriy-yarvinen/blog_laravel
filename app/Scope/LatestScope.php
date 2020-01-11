<?php

namespace App\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LatestScope implements Scope
{
	public function apply(Builder $builer, Model $model)
	{
		// $builer->orderBy('created_at', 'desc');
		$builer->orderBy($model::CREATED_AT, 'desc');
	}
}