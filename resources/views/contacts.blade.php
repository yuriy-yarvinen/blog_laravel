@extends('layout')

@section('content')
	<h1>Contacts</h1>
	@can('contact.secret')
		<a href="{{ route('secret') }}">Secret link</a>
	@endcan
@endsection