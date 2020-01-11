<div class="form-group">
	<label>Title</label>
	<input class="form-control" type="text" name='title' value="{{ old('title', $post->title ?? null) }}"/>
</div>
<div class="form-group">
	<label>Content</label>
	<input class="form-control" type="text" name='content' value="{{ old('content', $post->content ?? null) }}"/>
</div>
<div class="form-group">
	<label>Json</label>
	<input class="form-control" type="text" name='json' value="{{ old('json', $post->json ?? null) }}"/>
</div>

<div class="form-group">
	<label>image</label>
	<input class="form-control-file" type="file" name='image' />
</div>
{{-- <input type="hidden" name='user_id' value="{{ $post->user->id ?? Auth::user()->id }}"> --}}
@errors @enderrors
