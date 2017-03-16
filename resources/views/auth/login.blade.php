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

<form action="{{ route('login') }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="text" name="email" placeholder="Email">
	<input type="password" name="password" placeholder="Пароль">
	<input type="submit" value="Go">
</form>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')
