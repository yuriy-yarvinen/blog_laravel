<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel="stylesheet" href="{{ mix('css/app.css') }}">	
</head>
<body>
	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
		<h5 class="my-0 mr-md-auto font-weight-normal">Laravel Blog</h5>
		<nav class="my-2 my-md-0 mr-md-3">
			<a class="p-2 text-dark" href="{{ route('home') }}">Home</a>
			<a class="p-2 text-dark" href="{{ route('contacts') }}">Contact</a>
			<a class="p-2 text-dark" href="{{ route('posts.index') }}">Blog Posts</a>
			<a class="p-2 text-dark" href="{{ route('posts.create') }}">Add Blog Post</a>

			@guest
				@if (Route::has('register'))
					<a class="p-2 text-dark" href="{{ route('register') }}">Регистрация</a>
				@endif

				<a class="p-2 text-dark" href="{{ route('login') }}">Вход</a>
			@else
				<a class="p-2 text-dark" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Выйти ({{ Auth::user()->name }})</a>
				<form method="POST" id='logout-form' action="{{ route('logout') }}" style='display:none;'>@csrf</form>				
				<a class="p-2 text-dark" href="{{ route('deleteUser') }}" onclick="event.preventDefault();document.getElementById('logout2-form').submit();">Удалить ({{ Auth::user()->name }})</a>
				<form method="POST" id='logout2-form' action="{{ route('deleteUser') }}" style='display:none;'>@csrf</form>				
			@endguest
		</nav>
	</div>
	<div class="container">
		@if (session()->has('request_status'))
			<p style="color:aqua;">
				{{ session()->get('request_status') }}
			</p>		
		@endif

		@yield('content')		
	</div>



	<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>