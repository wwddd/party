@section('title')
	Search page
@stop

@include('layouts.head')
@include('layouts.header')

<div class="full-wrapper">
	<div class="wrapper">
		<div class="container">
			<h1 class="title">Найди вписку своей мечты!</h1>
			<div class="container">
				<div class="col-3">
					<div class="afterload" data-url="{{ route('ajax-ads') }}"></div>
				</div>
				<div class="col-9">
					<div class="afterload" data-url="{{ route('ajax-search') }}"></div>
				</div>
			</div>
		</div>
	</div>
</div>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')