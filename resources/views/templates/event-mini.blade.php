<div class="event little-event">

	<?php $title = (strlen($event->title) > 30) ? substr($event->title,0,30).'...' : $event->title; ?>
	<div class="event-title"><a href="{{ route('index_event', $event->id) }}" class="title">{{ $title }}</a></div>

	<div class="event-place">
		<div class="event-nm event-note"><i class="fa fa-map-marker" aria-hidden="true"></i> </div>
		{{ $event->country }}, {{ $event->city }}, {{ $event->place }}
	</div>

	<div class="event-time">
		<div class="event-note"><i class="fa fa-clock-o" aria-hidden="true"></i> </div>
		{{ gmdate("d M H:i, l", $event->start) }}
	</div>

	<?php
		$max_peoples = '';
		if($event->peoples_count !== NULL) {
			$max_peoples = ' из ' . $event->peoples_count;
		}
	?>
	<div class="event-currentpeoples">
		<div class="event-note"><i class="fa fa-users" aria-hidden="true"></i> </div>
		{{ $event->current_followers }} {{ $max_peoples }}
	</div>

	<div class="event-achivements"></div>
	<div class="event-rating"></div>
</div>