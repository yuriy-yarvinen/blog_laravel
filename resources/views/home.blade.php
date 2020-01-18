@extends('layout')

@section('content')
<div id="app">
	<example-component></example-component>
</div>

<form action="{{ route('support') }}" method="POST">
	@csrf
	<input type="email" name="email">
	<textarea name="content" cols="30" rows="10"></textarea>
	<input type="submit" value="send">
</form>
@endsection
