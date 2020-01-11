@extends('layout')

@section('content')

	<form action="{{ route('login') }}" method="POST">
		@csrf

		<div class="form-group">
			<label>name</label>
			<input type="text" name="name" value="{{ old('name') }}" required class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
			@if ($errors->has('name'))
				<span class="invalid-feedback">
					{{ $errors->first('name') }}
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
			<input type="checkbox" name="remember" class="form-check-input" value="{{ old('remrmber') ? 'checked' : '' }}">	
			<label for="remember" class="form-check-label">
				Запомнить меня
			</label>
		</div>

		<div class="form-group text-center">
			<input type="submit" value="Login" class="btn btn-dark">
		</div>
	</form>

@endsection