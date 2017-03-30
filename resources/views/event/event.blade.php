@section('title')
	{{ $event->title }}
@stop

@include('layouts.head')
@include('layouts.header')
<div class="container events">
	<div class="wrapper">
		<div class="event no-pading">
		<button id="init_event_report">Пожаловаться</button>
			<div class=" event-title">{{ $event->title }}</div>

			@if(Auth::user() && $event->user_id == Auth::user()->id && $event->image === NULL)
				<div class="event-upload">
					<form class="form" action="{{ route('event_upload_image') }}" method="POST">
						<div class="form-group left">
							<span class="fileContainer">
								Загрузить фото
								<input class="submit_upload" type="file" name="image">
							</span>
						</div>
						<input type="hidden" name="event_id" value="{{ $event->id }}">
					</form>
				</div>
			@endif

			<div class="event-image">
				@if(Auth::user() && $event->user_id == Auth::user()->id)
					<div class="event-imageprop">
						<form class="form" action="{{ route('event_upload_image') }}" method="POST">
							<div class="form-group">
								<span class="fileContainer">
									Сменить фото
									<input class="submit_upload" type="file" name="image">
								</span>
							</div>
							<input type="hidden" name="event_id" value="{{ $event->id }}">
						</form>
					</div>
				@endif
				<img src="<?php $event->image !== NULL ? print $event->image : '' ?>">
			</div>

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
						$max_peoples = ' из ' . $event->peoples_count;
					}
				?>
				<br>
				<div class="event-currentpeoples">
					<div class="event-note">Кол-во гостей: </div>
					{{ $event->current_followers }} {{ $max_peoples }}
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
					@if($actions_arr['action1'] !== '' && $actions_arr['button1'] !== '')
						<div class="event-inline subscribe">
							<form class="form confirm" action="{{ $actions_arr['action1'] }}" method="POST">
								<button type="submit" class="button button-mid">{{ $actions_arr['button1'] }}</button>
								<input type="hidden" name="event_id" value="{{ $event->id }}">
								<input type="hidden" name="owner_id" value="{{ $event->user_id }}">
								<input type="hidden" name="follower_id" value="{{ Auth::user()->id }}">
							</form>
						</div>
					@endif
					<div class="event-inline to-favourites">
						<form class="form confirm" action="{{ $actions_arr['action2'] }}" method="POST">
							@if($event->user_id == Auth::user()->id)
								<div class="form-group required">
									<textarea type="text" name="reason" placeholder="Причина закрытия"></textarea>
								</div>
							@endif
							<button type="submit" class="button button-mid">{{ $actions_arr['button2'] }}</button>
							<input type="hidden" name="event_id" value="{{ $event->id }}">
							<input type="hidden" name="owner_id" value="{{ $event->user_id }}">
							<input type="hidden" name="follower_id" value="{{ Auth::user()->id }}">
						</form>
					</div>
				@endif
			@else
				@if($follower_info && $follower_info->count() && !$follower_info[0]->follower_eval)
					<div class="rating_block">
						<form class="rating form" action="{{ route('ajax_store_rating') }}" method="POST">
							<div class="rating-note">
								<button class="button button-mid" type="submit">Оценить</button>
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

			@if(Auth::user())
				<div class="event-inline repost-vk">
					<script type="text/javascript" src="https://vk.com/js/api/share.js?94" charset="windows-1251"></script>
					<script type="text/javascript">
						document.write(VK.Share.button({
							url: 'http://pre05.deviantart.net/bfd7/th/pre/f/2011/006/8/6/position_46_by_ivanpaduano-d36kjqa.jpg',
							title: 'Заголовок страницы',
							image: 'http://pre05.deviantart.net/bfd7/th/pre/f/2011/006/8/6/position_46_by_ivanpaduano-d36kjqa.jpg',
							noparse: true
						}, {
							text: 'Поделиться',
							type: 'round'
						}));
					</script>
				</div>
			@endif
		</div>
	</div>
</div>

<div id="event-overlay" class="overlay"></div>
<div id="report-modal" class="modal">
	<div class="report-content">
		<div class="report-x"></div>
		<form class="form" method="POST" action="{{ route('send_report') }}">
			<div class="form-group required">
				<input type="text" name="email" placeholder="Email">
			</div>
			<div class="form-group required">
				<textarea name="message" placeholder="Сообщение"></textarea>
			</div>
			<div class="form-group required">
				<select name="reason">
					<option value="Спам">Рассылка спама</option>
					<option value="Порнография">Порнография</option>
					<option value="Оскорбления">Оскорбительное поведение</option>
					<option value="Реклама">Рекламная страница, засоряющая поиск</option>
				</select>
			</div>
			<input type="hidden" name="event_id" value="{{ $event->id }}">
			<input type="hidden" name="guilty_id" value="{{ $event->user_id }}">
			<div class="form-group">
				<button class="button create-button">Пожаловаться</button>
			</div>
		</form>
	</div>
</div>

@include('layouts.footer')
@include('layouts.scripts')

<script type="text/javascript">
	$('#init_event_report').on('click', function() {
		$('#report-modal').addClass('active');
		$('#event-overlay').fadeIn(300);
	});
	$('.report-x, #event-overlay').on('click', function() {
		$('.modal').removeClass('active');
		$('.overlay').fadeOut(300);
	});
</script>

@include('layouts.foot')