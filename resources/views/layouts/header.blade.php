<header class="full-wrapper main-background">
	<div class="wrapper">
		<div class="header">
			<nav class="container">
				<div id="logo" class="col-3">
					<a href="/">
						<img src="{{ asset('/images/logo.png') }}">
					</a>
				</div>
				<div class="col-2"></div>
				<div id="menu" class="col-6">
					<ul class="register">
							<li><a href="{{ route('search') }}">Поиск</a></li>
						@if(Auth::user())
							<li><a href="{{ route('account') }}">Кабинет</a></li>
							<li><a href="{{ route('logout') }}">Выход</a></li>
						@else
							<li><a href="{{ route('index_login') }}">Вход</a></li>
							<li><a href="{{ route('index_register') }}">Регистрация</a></li>
						@endif
					</ul>
					<ul class="social">
						<li><a href="https://oauth.vk.com/authorize?client_id=5926797&display=page&redirect_uri=http://127.0.0.1:8000/login/vk&scope=email&response_type=token&v=5.63&state=1">VK</a></li>
						<li><a href="#">FB</a></li>
						<li><a href="#">DNO</a></li>
					</ul>
				</div>
				<div id="notices" class="col-1">
					<span class="notice-circle"></span>
					@if(Auth::user())
						<i class="fa fa-bell-o" aria-hidden="true"></i>
						<div class="notices-parent">
							<div class="afterload" data-url="{{ route('ajax_get_notices') }}"></div>
						</div>
					@endif
				</div>
			</nav>
			<div class="clear"></div>
		</div>
	</div>
</header>
<div class="clear"></div>
<!-- CONTENT -->
<div id="content">