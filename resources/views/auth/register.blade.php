@section('title')
	Register
@stop


@include('layouts.head')
@include('layouts.header')

<div class="full-wrapper">
	<div class="wrapper">
		<div class="container">
			<div class="col-6 tab active id="user" data-url="{{ route('user_form') }}"">User</div>
			<div class="col-6 tab id="company" data-url="{{ route('company_form') }}"">Company</div>
		</div>
		<div class="clear"></div>
		<div class="afterload-tabs"></div>
	</div>	
</div>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')