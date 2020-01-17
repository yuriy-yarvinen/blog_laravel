<?php

namespace App\Http\Controllers;

use App\CreateAllTables;
use App\Http\Requests\UpdateUser;
use App\Image;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
		$this->authorizeResource(User::class, 'user');
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
		// dd($user);
		return view("users.show", ["user"=> $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
		return view("users.edit", ["user" => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, User $user)
    {
		// dd($user);
		if ($request->hasFile('avatar')) {
			$path = $request->file('avatar')->store('avatars');

			if ($user->image) {
				Storage::delete($user->image->path);
				$user->image->path = $path;
				$user->image->save();
			}
			else {
				$user->image()->save(
					// Image::create(['path' => $path]));				
					Image::make(['path' => $path])
				);

				// OR
				// $image = new Image();
				// $image->path = $path;
				// $image->save();
			}

			// $request->session()->flash('request_status','Пост обновлен');

			return redirect()->back()->withRequestStatus('User image was updated');
		}
		else{
			return redirect()->back();
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
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
