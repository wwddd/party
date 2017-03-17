@section('title')
	Account page
@stop

@include('layouts.head')
@include('layouts.header')

<div class="full-wrapper">
	<div class="wrapper">
		<div id="account_tabs">
			<div class="container">
				<div class="col-2 tab" id="create" data-url="{{ route('ajax-create') }}">Создать</div>
				<div class="col-2 tab" id="opened" data-url="{{ route('ajax-opened') }}">Открытые</div>
				<div class="col-2 tab" id="closed" data-url="{{ route('ajax-closed') }}">Завершенные</div>
				<div class="col-2 tab" id="favourite" data-url="{{ route('ajax-favourite') }}">Избранное</div>
				<div class="col-2 tab" id="achievements" data-url="{{ route('ajax-achievements') }}">Мои достижения</div>
				<div class="col-2 tab" id="personal" data-url="{{ route('ajax-personal') }}">Личные данные</div>
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
@include('layouts.foot')