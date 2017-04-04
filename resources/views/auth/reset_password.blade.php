@section('title')
	Forgot password
@stop

@include('layouts.head')
@include('layouts.header')

<form class="form" action="{{ route('reset_password_confirmed') }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="email" value="{{ $email }}">
	<div class="container">
		<div class="col-6">
			<div class="form-group required">
				<input type="password" name="password" placeholder="Новый пароль">
			</div>
			<div class="form-group required">
				<button type="submit" class="button create-button">Изменить</button>
			</div>
		</div>
	</div>
</form>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')
