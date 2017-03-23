<div class="container events">
	<h2 class="title">Избранное</h2>
	<hr>
	@if($events->count() == 0)
		<h2 class="title">К сожалению, по запросу ничего не найдено :(</h2>
	@endif
	@foreach($events as $event)
		@include('templates.event')
	@endforeach
</div>