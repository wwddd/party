@section('title')
	Cooperation
@stop

@include('layouts.head')
@include('layouts.header')
	
<div class="full-wrapper">
	<div class="wrapper">
	<div id="cooperation_tabs">		
		<div class="container">
			<div class="col-6 tab" id="membership" data-url="{{ route('membership') }}">Членство</div>
			<div class="col-6 tab active" id="ads" data-url="{{ route('ads') }}">Реклама</div>
		</div>
		
		<div class="clear"></div>
		<div class="afterload-tabs" data-id="membership"></div>
		<div class="afterload-tabs" data-id="ads"></div>
	</div>
	</div>	
</div>

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')
