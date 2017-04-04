@section('title')
	Forgot password
@stop

@include('layouts.head')
@include('layouts.header')

<form class="form" action="{{ route('reset_password_init') }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="container">
		<div class="col-6">
			<div class="form-group required">
				<input type="text" name="email" placeholder="Email">
			</div>
			<div class="form-group">
				<button type="submit" class="button create-button">Сбросить пароль</button>
			</div>
			<div class="form-group" id="send_again"></div>
		</div>
	</div>
</form>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')
