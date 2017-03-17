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
					<div data-id="conditions" class="choosen-select"></div>
					<div id="conditions" class="select-multiple">
						<div class="select-title">Выберите условия для гостей</div>
						<div class="select-inner">
							<div><input type="checkbox" value="деньги"><span>Деньги</span></div>
							<div><input type="checkbox" value="женщины"><span>Женщины</span></div>
							<div><input type="checkbox" value="мужчины"><span>Мужчины</span></div>
							<div><input type="checkbox" value="дети"><span>Дети для педофилов</span></div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="input-tags">
						<input placeholder="Доп. условия (вводите и нажимайте Enter)" type="text" name="more_conditions">
					</div>
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
					<input id="time" placeholder="Время" type="text" name="time">
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

<script type="text/javascript">
	$(document).find('#time').datetimepicker({
		locale: 'ru',
	});
</script>