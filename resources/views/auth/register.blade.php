@section('title')
	Register
@stop


@include('layouts.head')
@include('layouts.header')

@foreach($errors->all() as $error)
	<div class="container">
		<p>{{ $error }}</p>
	</div>
@endforeach

<div class="full-wrapper">
	<div class="wrapper">
	<div id="register_tabs">
		<div class="container">
			<div class="col-6 tab active" id="user" data-url="{{ route('user_form') }}">Пользователь</div>
			<div class="col-6 tab" id="company" data-url="{{ route('company_form') }}">Компания</div>
		</div>
		
		<div class="clear"></div>
		<div class="afterload-tabs" data-id="user"></div>
		<div class="afterload-tabs" data-id="company"></div>
	</div>
	</div>
</div>

@include('layouts.footer')
@include('layouts.scripts')
{{-- <script type="text/javascript" src="//vk.com/js/api/openapi.js?143"></script> --}}
@include('layouts.foot')