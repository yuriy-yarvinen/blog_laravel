@extends('layout')

@section('content')
<div class="row">
	<div class="col-8">
		{{-- <img src="{{ Storage::url($post->image->path) }}" alt="image"> --}}
		{{-- <img src="{{ $post->image->url() }}" alt="image"> --}}
		@if ($post->image)
		<div style="color:#fff;width:100%;min-height:500px;background-image: url({{ $post->image->url() }});background-attachment:fixed;text-align:center;">
			<h1 style="padding-top:100px; text-shadow: 1px 2px #000;">
		@else
			<h1>		
		@endif

			{{ $post->title }}
			@badge([
				'type' => 'primary',
				'show' => now()->diffInMinutes($post->created_at) < 60
			])
				New!!!
			@endbadge
		@if ($post->image)
			</h1>
		</div>
		@else
			</h1>
		@endif
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