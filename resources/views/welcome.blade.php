@extends('layout')

@section('content')
	<h1>Welcome</h1>

	<div id="app">
		<example-component></example-component>
	</div>
	<form action="{{ route('sendSupportMail') }}" method="POST" enctype="multipart/form-data">
		@csrf

		<input type="email" name="email">
		<textarea name="content" cols="30" rows="10"></textarea>
		<input type="file" name='file'>
		<input type="submit" value="send">
	</form>
@endsection