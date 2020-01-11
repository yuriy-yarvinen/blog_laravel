<div class="container">
	<div class="row">
		
		@card([
			'card_title' => 'Most commented posts',
			'card_text' => 'What people are talking about',
			'items' => $most_commented,
			'empty_text' => 'No comment yet',
			'type' => 'post'
		])

		@endcard

	</div>

	<div class="row mt-2">
	
		@card([
			'card_title' => 'Most active users',
			'card_text' => 'Yes',
			'items' => $most_active,
			'empty_text' => 'No users yet',
			'type' => 'active',
		])

		@endcard

		{{-- @card([
			'card_title' => 'Most active users',
			'card_text' => 'Yes',
			// 'items' => $most_active,
			'empty_text' => 'No users yet'
		])
		@slot('items', collect($most_active)->pluck(['name']))

		@endcard --}}

	</div>

	<div class="row mt-2">
		@card([
			'card_title' => 'Most active users last month',
			'card_text' => 'Last month',
			'items' => $most_active_last_month,
			'empty_text' => 'No users yet',
			'type' => 'active',
		])

		@endcard

	</div>
</div>