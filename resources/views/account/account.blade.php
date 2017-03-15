@section('title')
	Account page
@stop

@include('layouts.head')
@include('layouts.header')

<div class="full-wrapper">
	<div class="wrapper">
		<div id="account_tabs">
			<div class="container">
				<div class="col-2 tab" id="opened" data-url="{{ route('ajax-opened') }}">Открытые вписки</div>
				<div class="col-2 tab" id="closed" data-url="{{ route('ajax-closed') }}">Завершенные вписки</div>
				<div class="col-2 tab" id="favourite" data-url="{{ route('ajax-favourite') }}">Избранное</div>
				<div class="col-2 tab" id="create" data-url="{{ route('ajax-create') }}">Создать вписку</div>
				<div class="col-2 tab" id="achievements" data-url="{{ route('ajax-achievements') }}">Мои достижения</div>
				<div class="col-2 tab" id="personal" data-url="{{ route('ajax-personal') }}">Личные данные</div>
			</div>
			<div class="clear"></div>
			<div class="afterload-tabs"></div>
		</div>
	</div>
</div>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')