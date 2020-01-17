<p class="text-muted">
	{{ empty(trim($slot)) ? 'Добаленно:' : $slot }} {{ $date->locale(config('app.const.lang'))->diffForHumans() }}
	@if (isset($name))
		@if (isset($userId))
			<a href="{{ route('users.show', ['user' => $userId]) }}">{{ $name }}</a>
		@else
			автор {{ $name }}
		@endif
	@endif	
</p>