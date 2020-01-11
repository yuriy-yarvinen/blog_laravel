<p>
	@foreach ($tags as $tag)
		<a class='badge badge-success' href="{{ route('posts.tag.index', ['id' => $tag->id]) }}">{{ $tag->name }}</a>
	@endforeach
</p>