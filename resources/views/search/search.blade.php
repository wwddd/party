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
								<div class="autocomplete-body">
									<input autocomplete="off" data-sense="country" class="autocomplete-input" type="text" name="country" placeholder="Страна">
									<div class="autocomplete-result"></div>
								</div>
								<div class="autocomplete-body">
									<input autocomplete="off" data-sense="city" class="autocomplete-input" type="text" name="city" placeholder="Город">
									<div class="autocomplete-result"></div>
								</div>
								<select name="tags">
									<option value="">--Условия входа--</option>
									<option {{ app('request')->get('tags') == 'деньги' ? 'selected="selected"' : '' }} value="деньги">Платный вход</option>
									<option {{ app('request')->get('tags') == 'мужчины' ? 'selected="selected"' : '' }} value="мужчины">Для мужчин</option>
									<option {{ app('request')->get('tags') == 'женщины' ? 'selected="selected"' : '' }} value="женщины">Для женщин</option>
									<option {{ app('request')->get('tags') == 'дети' ? 'selected="selected"' : '' }} value="дети">Для детей</option>
								</select>
								<select name="peoples_count">
									<option value="">--Количество гостей--</option>
									<option {{ app('request')->get('peoples_count') == '3' ? 'selected="selected"' : '' }} value="3">> 3</option>
									<option {{ app('request')->get('peoples_count') == '10' ? 'selected="selected"' : '' }} value="10">> 10</option>
								</select>
							</form>
						</div>
					</div>
					<?php
						$getParams = app('request')->all();
						$dataParams = '';
						foreach ($getParams as $name => $value) {
							$dataParams .= 'data-' . $name . '=' . $value . ' ';
						}
					?>
					<div id="search" class="afterload" {{ $dataParams }} data-url="{{ route('ajax-search') }}"></div>
				</div>
			</div>
		</div>
	</div>
</div>

@include('layouts.footer')
@include('layouts.scripts')
<link rel="stylesheet" type="text/css" href="{{ asset('/js/pluigins/select2/dist/css/select2.min.css') }}"/>
<script src="{{ asset('/js/pluigins/select2/dist/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
	$('select').select2();
	$(function() {
		var search = $('#search');
		var dataUrl = search.data('url');
		var clickedPage = $('.paginate li.active').data('page');

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
			var urlString = '?';
			for(var i in data) {
				search.data(data[i].name, data[i].value);
				urlString += generateUrlString(data[i].name, data[i].value);
			}
			if(urlString != '?') {
				window.history.pushState(' ', ' ', urlString.slice(0, -1));
			} else {
				window.history.pushState(' ', ' ', window.location.pathname);
			}
			search.data('url', dataUrl);
			// search.data('page', clickedPage);
		}

		function generateUrlString(name, value) {
			return name + '=' + value + '&';
		}

		function getSearchParams(k){
			var p={};
			location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(s,k,v){p[k]=decodeURI(v)})
			return k?p[k]:p;
		}

		function addDataFromUrl() {
			clearData();
			$('option').prop('selected', false);
			var params = getSearchParams();
			console.log(params);
			for(i in params) {
				$('#properties')
					.find('select[name="' + i + '"]')
					.find('option[value="' + params[i] + '"]')
					.prop('selected', true);
				search.data(i, params[i]);
			}
			search.data('url', dataUrl);
			afterloadOverlay(search);
			getAfterload(search);
		}

		window.onpopstate = function(e){
			// if(e.state){
				addDataFromUrl();
			// }
		};

		function sendAll() {
			var data = handleParams($('form#properties').serializeArray());
			data['page'] = {};
			data['page']['name'] = 'page';
			data['page']['value'] = clickedPage;
			clearData();
			addData(data);
			afterloadOverlay(search);
			getAfterload(search);
		}

		$('form#properties').submit(function(e) {
			e.preventDefault();
			clickedPage = 1;
			sendAll();
		});

		$(document).on('keypress', 'input', function(e) {
			if(e.keyCode == 13) {
				clickedPage = 1;
				sendAll();
			}
		});

		$(document).on('click', '.autocomplete-result div', function(e) {
			clickedPage = 1;
			sendAll();
		});

		$(document).on('click', '.paginate li:not(.active)', function() {
			clickedPage = $(this).data('page');
			sendAll();
		});

		$('form#properties select').on('change', function() {
			$('form#properties').submit();
		});
	});
</script>
@include('layouts.foot')