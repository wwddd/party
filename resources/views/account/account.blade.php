@section('title')
	Account page
@stop

@include('layouts.head')
@include('layouts.header')

<div class="full-wrapper">
	<div class="wrapper">
		<div id="account_tabs">
			<div class="container">
				<div class="col-2 tab active">Открытые вписки</div>
				<div class="col-2 tab">Завершенные вписки</div>
				<div class="col-2 tab">Избранное</div>
				<div class="col-2 tab">Создать вписку</div>
				<div class="col-2 tab">Мои достижения</div>
				<div class="col-2 tab">Личные данные</div>
			</div>
			<div class="clear"></div>
			<div class="afterload" data-url="{{ route('opened_events') }}"></div>
		</div>
	</div>
</div>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')