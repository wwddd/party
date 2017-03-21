@foreach($ads as $ad)
	<div class="adve">
		<a href="{{ $ad->link }}" target="_blank">
			<div class="adve-img">
				<img src="{{ $ad->image }}">
			</div>
			<div class="adve-title">
				<span>{{ $ad->title }}</span>
			</div>
		</a>
	</div>
@endforeach