@extends('layout')

@section('content')
<div class="row">
	<div class="col-8">
		<h1>
			{{ $post->title }}
			{{-- @if ((new Carbon\Carbon())->diffInMinutes($post->created_at) < 60)
				@component('components.badge',['type' => 'primary'])
					New!!!
				@endcomponent

				@badge([
					'type' => 'primary',
				])
					New!!!
				@endbadge
			@endif --}}

			@badge([
				'type' => 'primary',
				'show' => now()->diffInMinutes($post->created_at) < 60
			])
				New!!!
			@endbadge
		</h1>
		<p>{{ $post->content }}</p>
		<p>{{ $post->json }}</p>


		@if ($post->id === 1)
				Пост 1
		@elseif ($post->id === 2)
				Пост 2
		@else
				Что то еще				
		@endif

		@updated([
			'date' => $post->created_at,
			'name' => $post->user->name
		])
		Добавленно:
		@endupdated

		@updated([
			'date' => $post->updated_at,
		])
		Обновленно:
		@endupdated

		<p>{{ $userCounter }} users read post</p>

		@tags(['tags'=> $post->tags])@endtags

		<h4>Comments</h4>

		@include('comments._form')

		@forelse ($post->comments as $comment)
			<p>{{ $comment->content }}</p>
			@updated([
				'date' => $comment->created_at,
				'name' => $comment->user->name,
			])
			Добавлен:
			@endupdated

		@empty
			<p>No comment yet</p>
		@endforelse
	</div>
	<div class="col-4">
		@include('posts._activity')	
	</div>
</div>
@endsection