@section('title')
	Index page
@stop

@include('layouts.head')
@include('layouts.header')

<div class="full-wrapper">
	<div class="wrapper">
		<div class="container">
			<div class="col-2"></div>
			<div class="col-8">
				<div class="container">
					<div class="col-6 center-child">
						<button>ВПИСАТЬСЯ</button>
					</div>
					<div class="col-6 center-child">
						<button>СОЗДАТЬ</button>
					</div>
				</div>
			</div>
			<div class="col-2"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')