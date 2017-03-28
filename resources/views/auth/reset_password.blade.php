@section('title')
	Forgot password
@stop

@include('layouts.head')
@include('layouts.header')

@foreach($errors->all() as $error)
	<p>{{ $error }}</p>
@endforeach

@if(Session::has('message'))
	<p>{{ Session::get('message') }}</p>
@endif

<form class="form" action="{{ route('reset-password') }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="container">
		<div class="col-6">			
			<div class="form-group required">
				<input type="text" name="token" placeholder="Код из письма">
			</div>
			<a href="{{ route('forgot-password') }}">Не пришло письмо?</a>
			<div class="form-group required">
				<input type="password" name="password" placeholder="Новый пароль">
			</div>
			<div class="form-group required">
				<button type="submit" class="button create-button">Сбросить</button>
			</div>
		</div>
	</div>
</form>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')
