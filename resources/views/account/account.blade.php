@section('title')
	Account page
@stop

@include('layouts.head')
@include('layouts.header')

<div class="full-wrapper">
	<div class="wrapper">
		<div id="account_tabs">
			<div class="container">
				<div class="col-2 tab" id="create" data-url="{{ route('ajax_create') }}">Создать</div>
				<div class="col-2 tab dynamic" id="opened" data-url="{{ route('ajax_opened') }}">Открытые</div>
				<div class="col-2 tab dynamic" id="closed" data-url="{{ route('ajax_closed') }}">Завершенные</div>
				<div class="col-2 tab dynamic" id="favourite" data-url="{{ route('ajax_favourite') }}">Избранное</div>
				<div class="col-2 tab" id="achievements" data-url="{{ route('ajax_achievements') }}">Мои достижения</div>
				<div class="col-2 tab" id="personal" data-url="{{ route('ajax_personal') }}">Личные данные</div>
			</div>
			<div class="clear"></div>
			@if(Session::has('message'))
				<p class="temporary-message">{{ Session::get('message') }}</p>
			@endif
			<div class="afterload-tabs" data-id="create"></div>
			<div class="afterload-tabs" data-id="opened"></div>
			<div class="afterload-tabs" data-id="closed"></div>
			<div class="afterload-tabs" data-id="favourite"></div>
			<div class="afterload-tabs" data-id="achievements"></div>
			<div class="afterload-tabs" data-id="personal"></div>
		</div>
	</div>
</div>

@include('layouts.footer')
@include('layouts.scripts')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/jquery.datetimepicker.css') }}"/>
<script src="{{ asset('/js/jquery.datetimepicker.full.min.js') }}"></script>

@if(Session::has('social_name'))
	<script type="text/javascript">
		mainNotice("Добро пожаловать, {{ Session::get('social_name') }}!", 'success');
	</script>
@endif

@include('layouts.foot')