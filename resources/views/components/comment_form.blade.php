<div class="mb-2 mt-2">

	@auth
		<form action="{{ $route }}" method="POST">
			@csrf
			<div class="form-group">
				<textarea class="form-control" type="text" name='comment' ></textarea>
			</div>
			
			<button class="btn btn-primary btn-block" type="submit">Добавить комментарий</button>
		</form>	

		@errors @enderrors
	@else
		<p>
			Только зарегистрированые пользователи могут оставлять комментарий
		</p>
		<p>
			<a href="{{ route('login') }}">Вход</a>
			<a href="{{ route('register') }}">Регистрация</a>
		</p>
	@endauth

</div>
<hr/>