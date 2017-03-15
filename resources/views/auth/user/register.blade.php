@section('title')
	Register
@stop


@include('layouts.head')
@include('layouts.header')
<div class="full-wrapper">
	<div class="wrapper">
		<div class="container">
			<div class="col-6">Tab 1</div>
			<div class="col-6">Tab 2</div>
		</div>	
		<form action="{{ route('user_store') }}" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="text" name="name">
			<input type="" name="">
			<input type="number" name="age" min="15" max="90">
		</form>
	</div>	
</div>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')