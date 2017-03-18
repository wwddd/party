<form class="form" action="{{ route('user_update') }}" method="PUT">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<!-- <input type="hidden" value="put"> -->
	<div class="container">
		<div class="col-6">
			<div class="form-group">
				<input type="text" name="name" placeholder="Имя" value="{{ $user->name }}">
			</div>
			<div class="form-group">
				<input type="number" name="age" min="15" max="90" placeholder="Возраст" value="{{ $user->age }}">
			</div>
			<div class="form-group">
				<input type="text" name="contact" placeholder="Skype, телефон, messeger" value="{{ $user->contact }}">
			</div>
		</div>
		<div class="col-6">
			<div class="form-group">
				<input type="text" name="country" placeholder="Страна" value="{{ $user->country }}">
			</div>
			<div class="form-group">
				<input type="text" name="city" placeholder="Город" value="{{ $user->city }}">
			</div>
			<div class="form-group">
				<input type="password" name="password" placeholder="Новый пароль">
			</div>
			<div class="form-group">
				<button type="submit" class="button create-button no-disabled">Сохранить</button>
			</div>
		</div>
	</div>
</form>