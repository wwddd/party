<div class="container">
	<h1 class="title">Создай свою вечеринку!</h1>
	<form class="form" action="{{ route('event-store') }}" method="POST">
		<div class="container">
			<div class="col-6">
				<div class="form-group required">
					<input placeholder="Заголовок" type="text" name="title">
				</div>
				<div class="form-group required">
					<textarea placeholder="Описание" name="description"></textarea>
				</div>
				<div class="form-group">
					<div class="choosen-tags choosen-conditions"></div>
					<select id="conditions">
						<option>-Условия вписки-</option>
						<option value="деньги">Деньги</option>
						<option value="женщины">Женщины</option>
						<option value="мужчины">Мужчины</option>
						<option value="дети">Дети для педофилов</option>
					</select>
				</div>
				<div class="form-group">
					<textarea placeholder="Доп. условия" name="more_conditions"></textarea>
				</div>
				<div class="form-group">
					<textarea placeholder="Ваши предложения" name="offer"></textarea>
				</div>
			</div>
			<div class="col-6">
				<div class="place">
					<div class="form-group required">
						<input placeholder="Страна" type="text" name="country">
					</div>
					<div class="form-group required">
						<input placeholder="Город" type="text" name="city">
					</div>
					<div class="form-group required">
						<input placeholder="Адрес" type="text" name="address">
					</div>
				</div>
				<div class="form-group required">
					<input placeholder="Время" type="text" name="time">
				</div>
				<div class="form-group required">
					<input placeholder="Контакты" type="text" name="contact">
				</div>
				<div class="form-group">
					<input placeholder="Максимальное количество гостей" type="number" name="peoples_count">
				</div>
				<div class="form-group">
					<button class="button create-button">СОЗДАТЬ</button>
				</div>
			</div>
		</div>
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	</form>
</div>