<form action="{{ route('user_store') }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="text" name="name" placeholder="Имя">
	<label>Пол:</label>
	<p><input type="radio" name="gender" value="man">Мужчина</p>
	<p><input type="radio" name="gender" value="woman">Женщина</p>
	<input type="number" name="age" min="15" max="90" placeholder="Возраст">
	<input type="text" name="country" placeholder="Страна">
	<input type="text" name="city" placeholder="Город">
	<input type="text" name="contact" placeholder="Skype, телефон, messeger">
	<input type="text" name="email" placeholder="email">
	<input type="password" name="password" placeholder="password">
	<input type="checkbox" required> C <a href="">правилами</a> согласен
	<input type="submit" name="go">
</form>