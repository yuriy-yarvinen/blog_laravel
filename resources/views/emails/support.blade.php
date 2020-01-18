<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<p>Message from {{ $request->user()->name }}</p>

<hr/>

<p>
	{{-- <img src="{{ $message->embed($comment->user->image->url()) }}" alt=""> --}}

	
	<img src="{{ $message->embed($request->url) }}" alt="">

    <a href="{{ route('users.show', ['user' => $request->user()->id]) }}">
        {{ $request->user()->name }}
    </a> said:
</p>

<p>
    "{{ $request->content }}"
</p>
<p>
    Email:
</p>
<p>
    "{{ $request->email }}"
</p>