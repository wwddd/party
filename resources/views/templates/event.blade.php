<div class="event">

	<?php $title = (strlen($event->title) > 70) ? substr($event->title,0,70).'...' : $event->title; ?>
	<div class="event-title"><a href="{{ route('index_event', $event->id) }}" class="title">{{ $title }}</a></div>

	<?php if($event->tags != NULL) { ?>
		<div class="event-tags">
			<div class="event-note">Условия входа: </div>
			<?php
				$tags_arr = explode(',', $event->tags);
				foreach ($tags_arr as $key => $tag) {
					if($tag !== '') { ?>
						<span class="event-tag">{{ $tag }}</span>
					<?php } ?>
				<?php } ?>
		</div>
	<?php } ?>

	<?php $description = (strlen($event->description) > 360) ? substr($event->description,0,360).'...' : $event->description; ?>
	<div class="event-description">{{ $description }}</div>

	<div class="event-inline">
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
	</div>

	<div class="event-achivements"></div>
	<div class="event-rating">
		<?php $rating = $event->user_rating; ?>
		@include('templates.rating')
	</div>
</div>