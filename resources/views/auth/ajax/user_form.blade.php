<form class="form" action="{{ route('user_store') }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="container">
		<div class="col-6">
			<div class="form-group required">
				<input type="text" name="name" placeholder="Имя">
			</div>
			<div class="form-group required">
				<input type="text" name="email" placeholder="email">
			</div>
			<div class="form-group required">
				<input type="radio" name="gender" value="man">Мужчина
				<input type="radio" name="gender" value="woman">Женщина
			</div>
			<div class="form-group required">
				<input type="number" name="age" min="15" max="90" placeholder="Возраст">
			</div>
			<div class="form-group required">
				<input type="text" name="contact" placeholder="Skype, телефон, messeger">
			</div>
		</div>
		<div class="col-6">
			<div class="form-group required">
				<input type="text" name="country" placeholder="Страна">
			</div>
			<div class="form-group required">
				<input type="text" name="city" placeholder="Город">
			</div>
			<div class="form-group required">
				<input type="password" name="password" placeholder="Пароль">
			</div>
			<div class="form-group required">
				<input type="checkbox" name="condition"> C <a href="">правилами</a> согласен
			</div>
			<div class="form-group required">
				<button type="submit" class="button create-button">Зарегестрироваться</button>
			</div>
		</div>
	</div>
</form>