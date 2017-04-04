<div>
	<h1>Перейдите по ссылке ниже для ввода нового пароля:</h1>
	<a href="{{ route('reset_password') }}?token={{ $token }}&email={{ $email }}">Ссылка</a>
</div>