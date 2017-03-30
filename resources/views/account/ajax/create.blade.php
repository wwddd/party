<div class="container">
	<h1 class="title">Создай свою вечеринку!</h1>
	<form class="form" action="{{ route('event_store') }}" method="POST">
		<div class="container">
			<div class="col-6">

				<div class="form-group required">
					<input placeholder="Заголовок" type="text" name="title">
				</div>

				<div class="form-group required">
					<textarea placeholder="Описание" name="description"></textarea>
				</div>

				<div class="form-group form-select-multiple">
					<div data-id="conditions" class="choosen-select"></div>
					<div id="conditions" class="select-multiple">
						<div class="select-title">Выберите условия для гостей</div>
						<div class="select-inner">
							<div><input name="conditions[]" type="checkbox" value="деньги"><span>Деньги</span></div>
							<div><input name="conditions[]" type="checkbox" value="женщины"><span>Женщины</span></div>
							<div><input name="conditions[]" type="checkbox" value="мужчины"><span>Мужчины</span></div>
							<div><input name="conditions[]" type="checkbox" value="дети"><span>Дети для педофилов</span></div>
						</div>
					</div>
				</div>

				<div class="form-group form-input-tags">
					<div class="input-tags">
						<input placeholder="Доп. условия (вводите и нажимайте Enter)" type="text" name="conditions[]">
					</div>
				</div>

				<div class="form-group">
					<textarea placeholder="Ваши предложения" name="offer"></textarea>
				</div>

			</div>
			<div class="col-6">
				<div class="place">

					<div class="form-group required autocomplete-body">
						<input autocomplete="off" data-sense="country" class="autocomplete-input" type="text" name="country" placeholder="Страна">
						<div class="autocomplete-result"></div>
					</div>
					<div class="form-group required autocomplete-body">
						<input autocomplete="off" data-sense="city" class="autocomplete-input" type="text" name="city" placeholder="Город">
						<div class="autocomplete-result"></div>
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
					<button type="submit" class="button create-button">СОЗДАТЬ</button>
				</div>

			</div>
		</div>
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	</form>
</div>

<script type="text/javascript">
	$(document).find('#time').datetimepicker();
</script>