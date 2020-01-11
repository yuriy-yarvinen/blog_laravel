<?php

namespace App\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;


class DeletedPostAdminScope implements Scope
{
	public function apply(Builder $builer, Model $model)
	{
		if ((Auth::check()) && (Auth::user()->type === 111)) {
			$builer->withTrashed();
			// $builer->withoutGlobalScope('Illuminate\Database\Eloquent\SoftDeletingScope');
		}
	}
}