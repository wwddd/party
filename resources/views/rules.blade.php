@section('title')
	Rules page 
@stop

@include('layouts.head')
@include('layouts.header')

<div class="full-wrapper">
	<div class="wrapper">
		<div class="container">
			<p>Тут будут правила</p>
		</div>
	</div>
</div>

<form class="form" action="{{ route('again_verify_account') }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<p>Не пришло письмо?</p>
	<button type="submit" class="button create-button">Отправить заново</button>
</form>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')