<div class="container">
	<h1 class="title">Здесь вы можете оставить пожелания касаемо проекта</h1>
	<form class="form" action="{{ route('feedback') }}" method="POST">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="container">
			<div class="col-6">
				<div class="form-group required">
					<textarea placeholder="Текст" name="text"></textarea>
				</div>
				<div class="form-group">
					<button type="submit" class="button create-button">Отправить</button>
				</div>
			</div>
		</div>
	</form>
</div>