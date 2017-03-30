@section('title')
	Login
@stop

@include('layouts.head')
@include('layouts.header')

@foreach($errors->all() as $error)
	<p>{{ $error }}</p>
@endforeach

@if(Session::has('message'))
	<p>{{ Session::get('message') }}</p>
@endif

<!-- <form action="{{ route('login') }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="text" name="email" placeholder="Email">
	<input type="password" name="password" placeholder="Пароль">
	<input type="submit" value="Go">
</form> -->

<form class="form" action="{{ route('login') }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="container">
		<div class="col-6">
			<div class="form-group required">
				<input type="text" name="email" placeholder="Email">
			</div>
			<div class="form-group required">
				<input type="password" name="password" placeholder="Пароль">
			</div>
			<div class="form-group">
				<p><a href="{{ route('forgot_password') }}">Забыли пароль?</a></p>
			</div>
			<div class="form-group required">
				<button type="submit" class="button create-button">Войти</button>
			</div>
		</div>
	</div>
</form>
@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')
