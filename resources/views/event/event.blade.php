@section('title')
	Event page
@stop

@include('layouts.head')
@include('layouts.header')
<div class="container events">
	<div class="wrapper">
		<div class="event no-pading">

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
				{{ $event->name }} ({{ $event->age }} лет) 
			</div>

			@if($event->status == 1)
				@if(!Auth::user())
					<p>Для участия во встрече необсходимо <a href="{{ route('index_login') }}">войти</a> или <a href="{{ route('index_register') }}">зарегистрироваться</a></p>
				@else
					<div class="event-inline subscribe">
						<form class="form confirm" action="{{ $actions_arr['action1'] }}" method="POST">
							<button type="submit" class="button">{{ $actions_arr['button1'] }}</button>
						</form>
					</div>
					<div class="event-inline to-favourites">
						<form class="form confirm" action="{{ $actions_arr['action2'] }}" method="POST">
							@if($event->user_id == Auth::user()->id)
								<div class="form-group required">
									<textarea type="text" name="reason" placeholder="Причина закрытия"></textarea>
								</div>
							@endif
							<button type="submit" class="button">{{ $actions_arr['button2'] }}</button>
						</form>
					</div>
				@endif
			@else
				@if($follower_info && $follower_info->count() && !$follower_info[0]->follower_eval)
					<div class="rating_block">
						<form class="rating form" action="{{ route('ajax_store_rating') }}" method="POST">
							<div class="rating-note">
								<button class="button" type="submit">Оценить</button>
							</div>
							<div class="stars">
								<input value="1" type="radio" name="star" class="star-1" id="star-1" />
								<label class="star-1" for="star-1">1</label>
								<input value="2" type="radio" name="star" class="star-2" id="star-2" />
								<label class="star-2" for="star-2">2</label>
								<input value="3" type="radio" name="star" class="star-3" id="star-3" />
								<label class="star-3" for="star-3">3</label>
								<input value="4" type="radio" name="star" class="star-4" id="star-4" />
								<label class="star-4" for="star-4">4</label>
								<input value="5" type="radio" name="star" class="star-5" id="star-5" />
								<label class="star-5" for="star-5">5</label>
								<span></span>
							</div>
							<input type="hidden" name="event_id" value="{{ $event->id }}">
							<input type="hidden" name="owner_id" value="{{ $event->user_id }}">
						</form>
					</div>
				@else
					<?php $rating = $event->event_rating; $sense = 'события'; ?>
					@include('templates.rating')
				@endif
			@endif
		</div>
	</div>
</div>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')