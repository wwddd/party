@section('title')
	Event page
@stop

@include('layouts.head')
@include('layouts.header')

	@foreach($event as $ev)
		<p>{{ $ev->title }}</p>
	@endforeach

@include('layouts.footer')
@include('layouts.scripts')
@include('layouts.foot')