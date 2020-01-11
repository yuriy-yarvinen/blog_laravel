<?php

namespace App\Http\Controllers;

use App\CreateAllTables;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth')->only(['deleteUser']);	
	}
	public function deleteUser(Request $request)
    {
		$id = $request->user()->id;
		$user = User::find($id);
		$user->delete();
		CreateAllTables::down($id);

        $request->session()->invalidate();

        return redirect('/');
    }
}
