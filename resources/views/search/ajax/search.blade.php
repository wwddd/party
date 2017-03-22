<div class="container events">
	@if($events->count() == 0)
		<h2 class="title">К сожалению, по запросу ничего не найдено :(</h2>
	@endif
	@foreach($events as $event)
		@include('templates.event')
	@endforeach

	<div class="paginate">
		<ul>
			<?php for($i = 1; $i <= $paginate_count; $i++) { ?>
				<li class="<?php $current_page == $i ? print 'active' : ''; ?>" data-page="{{ $i }}">{{ $i }}</li>
			<?php } ?>
		</ul>
	</div>
</div>