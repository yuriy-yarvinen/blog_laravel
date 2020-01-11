@extends('layout')

@section('content')

	<form action="{{ route('register') }}" method="POST">
		@csrf

		<div class="form-group">
			<label>Имя</label>
			<input type="text" name="name" value="{{ old('name') }}" required 
			class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">

			@if ($errors->has('name'))
				<span class="invalid-feedback">
					{{ $errors->first('name') }}
				</span>
			@endif
		</div>
		<div class="form-group">
			<label>Email</label>
			<input type="email" name="email" value="{{ old('email') }}" required class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}">
			@if ($errors->has('email'))
				<span class="invalid-feedback">
					{{ $errors->first('email') }}
				</span>
			@endif
		</div>
		<div class="form-group">
			<label>Type</label>
			<select class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}" name="type">
				<option value="1">Client 1</option>
				<option value="2">Client 2</option>
			</select>
			@if ($errors->has('type'))
				<span class="invalid-feedback">
					{{ $errors->first('type') }}
				</span>
			@endif

		</div>
		<div class="form-group">
			<label>Пароль</label>
			<input type="password" name="password" required 
			class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}">
			@if ($errors->has('password'))
				<span class="invalid-feedback">
					{{ $errors->first('password') }}
				</span>
			@endif			
		</div>
		<div class="form-group">
			<label>Повторите пароль</label>
			<input type="password" name="password_confirmation" required class="form-control">
		</div>

		<div class="form-group text-center">
			<input type="submit" value="Registr" class="btn btn-dark">
		</div>
	</form>

@endsection