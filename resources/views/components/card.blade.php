<div class="card" style="width:100%;">
	<div class="card-body">
		<h5 class="card-title">
			{{ $card_title }}
		</h5>
		<p class="card-text text-muted">
			{{ $card_text }}
		</p>
	</div>
	<ul class="list-group list-group-flush">
	
		@forelse ($items as $item)
			<li class="list-group-item">

				@if (isset($type) && $type === 'post')
					<a href="{{ route('posts.show', ['post' => $item->id]) }}">{{ $item->title }}</a>
				@endif
				@if (isset($type) && $type === 'active')
					{{ $item->name }} add {{ $item->blog_posts_count }} posts
				@endif
				
				{{-- {{ $item }} --}}
			</li>
			
		@empty
			<p>{{ isset($empty_text) }}</p>	
		@endforelse
		
	</ul>
</div>		
