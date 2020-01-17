@extends('layout')

@section('content')
	<div class="row">
		{{-- @foreach ($posts as $post)
				<h1>{{ $post->title }}</h1>
		@endforeach --}}
		<div class="col-8">
			@forelse ($posts as $post)
				<h3>
					@if ($post->trashed())
						<del>
					@endif
					<a class="{{ $post->trashed() ? 'text-muted' : '' }}" href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
					@if ($post->trashed())
						</del>
					@endif
				</h3>
				
				@updated([
					'date' => $post->created_at,
					'name' => $post->user->name,
					'userId' => $post->user->id
				])
				Добавленно:
				@endupdated

				@tags(['tags'=> $post->tags])@endtags

				@if ($post->comments_count)
					<p>have {{ $post->comments_count }} comments</p>
				@else
					<p>No comment yet</p>	
				@endif			

				@auth
					@can('update', $post)
						<a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Изменить</a>	
					@endcan		
	
					@if (!$post->trashed())					
						@can('delete', $post)
							<form method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}" class="fm-inline">
							@csrf
							@method('DELETE')
								<input class="btn btn-primary" type="submit" value="Delete Post">
							</form>
						@endcan				
					@endif				
				@endauth
				
				{{-- @if ($post->trashed())
					@can('restore', $post)
						<form method="POST" action="{{ route('posts.restore', ['post' => $post->id]) }}" class="fm-inline">
						@csrf
						@method('PUT')
							<input class="btn btn-primary" type="submit" value="Восстановить Post">
						</form>
					@endcan				
				@endif --}}


				{{-- @cannot('delete', $post)
					<p>You can't delete this post</p>
				@endcannot --}}
			@empty
				<p>No blog post here</p>
			@endforelse
		</div>
		<div class="col-4">
			@include('posts._activity')			
		</div>
	</div>
@endsection