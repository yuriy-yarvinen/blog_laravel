@extends('layout')

@section('content')
	<h1>Secret contacts!</h1>
	<p>Email {{ Auth::user()->email }}</p>
@endsection