<p>Как это работает за 30 секунд</p>

@if(Auth::user())
	<form enctype="multipart/form-data" action="{{ route('ads_store') }}" method="POST">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="text" name="title" placeholder="Название">
					<input type="file" name="image" placeholder="картинка">
					<input type="text" name="link" 	placeholder="Ссылка">
					<input type="checkbox" name="condition"> C <a href="">правилами</a> согласен
					<button type="submit">Купить</button>
	</form>	

<!-- 	<form class="form" enctype="multipart/form-data" action="{{ route('ads_store') }}" method="POST">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="container">
			<div class="col-6">
				<div class="form-group required">
					<input type="text" name="title" placeholder="Название">
				</div>
				<div class="form-group required">
					<input type="file" name="image" placeholder="картинка">
				</div>
				<div class="form-group required">
					<input type="text" name="link" min="15" max="90" placeholder="Ссылка">
				</div>
				<div class="form-group required">
					<input type="checkbox" name="condition"> C <a href="">правилами</a> согласен
				</div>
				<div class="form-group required">
					<button type="submit" class="button create-button">Купить</button>
				</div>
			</div>
		</div>
	</form> -->
@else
	<p>Для создания рекаламы необсходимо <a href="{{ route('index_login') }}">войти</a> или <a href="{{ route('index_register') }}">зарегистрироваться</a></p>
@endif