<div class="container">
	<div class="col-6 events">
		<h2 class="title">Мои вечеринки</h2>
		<hr>
		@if($events_as_owner->count() == 0)
			<h2 class="title">К сожалению, по запросу ничего не найдено :(</h2>
		@endif
		@foreach($events_as_owner as $event)
			@include('templates.event-mini')
		@endforeach
	</div>
	</div>
	<div class="col-6 events">
		<h2 class="title">Куда я вписан</h2>
		<hr>
		@if($events_as_guest->count() == 0)
			<h2 class="title">К сожалению, по запросу ничего не найдено :(</h2>
		@endif
		@foreach($events_as_guest as $event)
			@include('templates.event-mini')
		@endforeach
	</div>
</div>
