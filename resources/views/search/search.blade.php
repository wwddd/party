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
					<div class="container">
						<div class="search-properties">
							<form id="properties">
								<select name="city">
									<option value="">--Город--</option>
									<option value="Москва">Москва</option>
									<option value="Таганрог">Таганрог</option>
									<option value="Санкт-Петербург">Санкт-Петербург</option>
								</select>
								<select name="tags">
									<option value="">--Условия входа--</option>
									<option value="деньги">Платный вход</option>
									<option value="мужчины">Для мужчин</option>
									<option value="женщин">Для женщин</option>
									<option value="дети">Для детей</option>
								</select>
								<select name="peoples_count">
									<option value="">--Количество гостей--</option>
									<option value="3">> 3</option>
									<option value="10">> 10</option>
								</select>
							</form>
						</div>
					</div>
					<div id="search" class="afterload" data-url="{{ route('ajax-search') }}"></div>
				</div>
			</div>
		</div>
	</div>
</div>

@include('layouts.footer')
@include('layouts.scripts')
<script type="text/javascript">
	$(function() {
		var search = $('#search');
		var dataUrl = search.data('url');
		function handleParams(params) {
			var i = params.length;
			while(i--) {
				if(params[i].value == '') {
					params.splice(i, 1);
				}
			}
			return params;
		}

		function clearData() {
			var attrs = search.data();
			for(var i in attrs) {
				search.removeData(i);
			}
		}

		function addData(data) {
			for(var i in data) {
				search.data(data[i].name, data[i].value);
			}
			search.data('url', dataUrl);
		}

		$('form#properties').submit(function(e) {
			e.preventDefault();
			var data = handleParams($(this).serializeArray());
			clearData();
			addData(data);
			afterloadOverlay(search);
			getAfterload(search);
			console.log(data);
		});

		$('form#properties select').on('change', function() {
			$('form#properties').submit();
		});
	});
</script>
@include('layouts.foot')