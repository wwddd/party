<div class="notices-body">
	@foreach($notices as $key => $notice)
		<div class="notice">
			@if($notice->link !== NULL)
				<a href="{{ $notice->link }}">
			@endif
				{{ $notice->title }}
			@if($notice->link !== NULL)
				</a>
			@endif
			<div data-url="{{ route('delete_notice') }}" data-id="{{ $notice->id }}" class="notice-head-x"></div>
		</div>
	@endforeach
</div>