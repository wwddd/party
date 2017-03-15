@section('title')
	Register
@stop


@include('layouts.head')
@include('layouts.header')
<div class="full-wrapper">
	<div class="wrapper">
		<div class="container">
			<div class="col-6 tab active">Tab 1</div>
			<div class="col-6 tab">Tab 2</div>
		</div>
		<form action="{{ route('user_store') }}" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="text" name="name" placeholder="Имя">
			<label>Пол:</label>
			<p><input type="radio" name="gender" value="man">Мужчина</p>
			<p><input type="radio" name="gender" value="woman">Женщина</p>
			<input type="number" name="age" min="15" max="90" placeholder="Возраст">
			<input type="text" name="contact" placeholder="Skype, телефон, messeger">
			<input type="text" name="email" placeholder="email">
			<input type="password" name="password" placeholder="password">
			<input type="checkbox"> C <a href="">правилами</a> согласен
			<input type="button" name="submit" value="go">
		</form>
	</div>	
</div>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')