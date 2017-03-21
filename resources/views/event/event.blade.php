@section('title')
	Event page
@stop

@include('layouts.head')
@include('layouts.header')
<div class="container events">
	<div class="event">

		<div class=" event-title">{{ $event->title }}</div>

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

		<div class="event-inline">
			<div class="event-note">Описание: </div>
			{{ $event->description }}
		</div>

		<div class="event-inline">
			<div class="event-place">
				<div class="event-note">Место: </div>
				{{ $event->country }}, {{ $event->city }}, {{ $event->place }} 
			</div>
			<br>
			<div class="event-time">
				<div class="event-note">Время: </div>
				{{ gmdate("d M H:i, l", $event->start) }}
			</div>

			<?php
				$max_peoples = '';
				if($event->peoples_count !== NULL) {
					$max_peoples = ' из ' . $max_peoples;
				}
			?>
			<br>
			<div class="event-currentpeoples">
				<div class="event-note">Максимальное кол-во гостей: </div>
				{{ $event->peoples_count }}
			</div>
		</div>

		<div class="event-inline">
			<div class="event-note">Контакт для связи: </div>
			{{ $event->contact }}
		</div>

		<div class="event-inline">
			<div class="event-note">О пользователе: </div>
			{{ $owner->name }} ({{ $owner->age }} лет) 
		</div>

		@if(!Auth::user())
			<p>Для участия во встрече необсходимо <a href="{{ route('index_login') }}">войти</a> или <a href="{{ route('index_register') }}">зарегистрироваться</a></p>
		@else

			<div class="event-inline subscribe">
				<form class="form" action="{{ $actions_arr['action1'] }}" method="POST">
					<button type="submit" class="button">{{ $actions_arr['button1'] }}</button>
				</form>
			</div>
			<div class="event-inline to-favourites">
				<form class="form" action="{{ $actions_arr['action2'] }}" method="POST">
					@if($owner->id == Auth::user()->id)
						<div class="form-group required">
							<textarea type="text" name="reason" placeholder="Причина закрытия"></textarea>
						</div>
					@endif
					<button type="submit" class="button">{{ $actions_arr['button2'] }}</button>
				</form>
			</div>

		@endif
	</div>
</div>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')