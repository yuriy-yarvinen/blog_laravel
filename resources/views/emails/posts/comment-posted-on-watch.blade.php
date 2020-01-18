@component('mail::message')
# Comment post on post you comment

Hi {{ $user->name }}

@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable->id])])
Visit post
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user' => $comment->user->id])])
Show  {{ $comment->user->name }}
@endcomponent

@component('mail::panel')
{{ $comment->content }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
