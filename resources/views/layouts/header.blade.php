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
							<li><a href="{{ route('contact') }}">Контакты</a></li>
						@if(Auth::user())
							<li><a href="{{ route('account') }}">Кабинет</a></li>
							<li><a href="{{ route('logout') }}">Выход</a></li>
						@else
							<li><a href="{{ route('index_login') }}">Вход</a></li>
							<li><a href="{{ route('index_register') }}">Регистрация</a></li>
						@endif
					</ul>
					<ul class="social">
						<li> <a href="{{ url('/auth/facebook') }}"><i class="fa fa-facebook"></i></a></li>
						<li> <a href="{{ url('/auth/vkontakte') }}"><i class="fa fa-vk"></i></a></li>
						<li> <a href="{{ url('/auth/twitter') }}"><i class="fa fa-twitter"></i></a></li>
						<li> <a href="{{ url('/auth/odnoklassniki') }}"><i class="fa fa-odnoklassniki"></i></a></li>
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