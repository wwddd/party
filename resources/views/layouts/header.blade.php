<header class="full-wrapper main-background">
	<div class="wrapper">
		<div class="header">
			<nav>
				<div id="logo">PARTY-SCOPE.COM</div>
				<div id="menu">
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
						<li><a href="#">VK</a></li>
						<li><a href="#">FB</a></li>
						<li><a href="#">DNO</a></li>
					</ul>
				</div>
			</nav>
			<div class="clear"></div>
		</div>
	</div>
</header>
<div class="clear"></div>
<!-- CONTENT -->
<div id="content">