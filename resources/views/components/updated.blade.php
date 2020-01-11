<p class="text-muted">
	{{ empty(trim($slot)) ? 'Добаленно:' : $slot }} {{ $date->locale(config('app.const.lang'))->diffForHumans() }}
	@if (isset($name))
		автор {{ $name }}
	@endif	
</p>