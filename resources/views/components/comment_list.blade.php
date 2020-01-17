@forelse ($comments as $comment)
<p>{{ $comment->content }}</p>
@updated([
	'date' => $comment->created_at,
	'name' => $comment->user->name,
	'userId' => $comment->user->id
])
Добавлен:
@endupdated

@empty
<p>No comment yet</p>
@endforelse