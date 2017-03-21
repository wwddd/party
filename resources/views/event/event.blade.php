@section('title')
	Event page
@stop

@include('layouts.head')
@include('layouts.header')
<div class="container events">
	@foreach($event as $event)
	<div class="event">

		<?php $title = (strlen($event->title) > 20) ? substr($event->title,0,20).'...' : $event->title; ?>
		<div class=" event-title">{{ $event->title }}</div>

		<?php if($event->tags !== NULL) { ?>
			<div class="event-inline">
				<div class="event-note">Условия входа: </div>
				{{ $event->tags }}
			</div>
		<?php } ?>

		<?php $description = (strlen($event->description) > 360) ? substr($event->description,0,360).'...' : $event->description; ?>
		<div class="event-inline">
			<div class="event-note">Описание: </div>
			{{ $description }}
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

		@foreach($owner as $owner)
			<div class="event-inline">
				<div class="event-note">О пользователе: </div>
				{{ $owner->name }} ({{ $owner->age }} лет) 
			</div>
		@endforeach

		@if(!Auth::user())
			<p>Для участия во встрече необсходимо <a href="{{ route('index_login') }}">войти</a> или <a href="{{ route('index_register') }}">зарегистрироваться</a></p>
		@elseif($owner->name == $current_user->name)
			<div class="event-inline">
				<form class="form" action="{{ route('event_complete', ['event_id' => $event->id]) }}" method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<button type="submit" class="button">Завершить</button>
				</form>			
			</div>

			<div class="event-inline">
				<form class="form" action="{{ route('event_close', ['event_id' => $event->id]) }}" method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group required">
						<textarea type="text" name="reason" placeholder="Причина закрытия"></textarea>
					</div>
				<div class="form-group">
					<button type="submit" class="button">Закрыть</button>
				</div>
				</form>			
			</div>
		@elseif(empty($event_follower[0]->id) == false && empty($event_to_favorites[0]->id) == true)
			<div class="event-inline">
				<form class="form" action="{{ route('event_un_subscribe', ['event_id' => $event->id, 'follower_id' => $event_follower[0]->follower_id]) }}" method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<button type="submit" class="button">Отписаться</button>
				</form>			
			</div>
			
			<div class="event-inline">
				<form class="form" action="" method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<button type="submit" class="button">В закладки</button>
				</form>			
			</div>
		@elseif(empty($event_follower[0]->id) == true && empty($event_to_favorites[0]->id) == false))
			<div class="event-inline">
				<form class="form" action="{{ route('event_subscribe', ['event_id' => $event->id, 'follower_id' => $current_user->id]) }}" method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<button type="submit" class="button">Вписаться</button>
				</form>			
			</div>
			
			<div class="event-inline">
				<form class="form" action="{{ route('event_un_favorites') }}" method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<button type="submit" class="button">Убрать из закладок</button>
				</form>			
			</div>
		@elseif(empty($event_follower[0]->id) == false && empty($event_to_favorites[0]->id) == false)
			<div class="event-inline">
				<form class="form" action="{{ route('event_un_subscribe', ['event_id' => $event->id, 'follower_id' => $event_follower[0]->follower_id]) }}" method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<button type="submit" class="button">Отписаться</button>
				</form>			
			</div>
			
			<div class="event-inline">
				<form class="form" action="{{ route('event_un_favorites', ['user_id' => $current_user->id, 'event_id' => $event->id]) }}" method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<button type="submit" class="button">Убрать из закладок</button>
				</form>			
			</div>
		@else
			<div class="event-inline">
				<form class="form" action="{{ route('event_subscribe', ['event_id' => $event->id, 'follower_id' => $current_user->id]) }}" method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<button type="submit" class="button">Вписаться</button>
				</form>			
			</div>
			
			<div class="event-inline">
				<form class="form" action="{{ route('to_favorites', ['user_id' => $current_user->id, 'event_id' => $event->id]) }}" method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<button type="submit" class="button">В закладки</button>
				</form>			
			</div>			
		@endif
	</div>
	@endforeach
</div>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')