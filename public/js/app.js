$(function() {
	var afterloadOverlayTpl = '<div class="afterload-overlay"><div class="afterload-loader"></div></div>';
	var afterloadErrorTpl = '<div class="afterload-error"><p>Something goes wrong...</p></div>';
	var currentTab = getUrlParameter('tab');
	var loading = false;

	function getUrlParameter(sParam) {
		var sPageURL = decodeURIComponent(window.location.search.substring(1)),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;
		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : sParameterName[1];
			}
		}
	}

	function setUrlParameter(sParam, value) {
		window.history.pushState(value, '', '?' + sParam + '=' + value);
	}

	window.onpopstate = function(e){
		if(!loading) {
			if(e.state){
				sendTab($('#' + e.state));
			}
		}
	};

	if(!currentTab) {
		sendTab($('.tab').first());
	} else {
		sendTab($('#' + currentTab));
	}

	function sendTab(tab) {
		if(!loading) {
			setUrlParameter('tab', tab[0].id);
			$('.tab').removeClass('active');
			tab.addClass('active');
			$(document).find('.afterload-tabs').each(function() {
				if(tab[0].id == $(this).data('id')) {
					if($(this).is(':empty')) {
						$('.afterload-tabs').hide();
						$(this).show();
						$(this).data('url', tab.data('url'));
						getAfterload($(this));
					} else {
						$('.afterload-tabs').hide();
						$(this).show();
					}
				}
			});
		}
	}

	$('.tab').on('click', function() {
		sendTab($(this));
	});

	function afterload() {
		$(document).find('.afterload').each(function() {
			if($(this).is(':empty')) {
				$('.afterload').hide();
				$(this).show();
				getAfterload($(this));
			}
		});
	}

	function afterloadOverlay(selector) {
		selector.html(afterloadOverlayTpl);
	}

	function getAfterload(selector, attemps = 0) {
		loading = true;
		if(attemps < 3) {
			var toSend = selector.data();
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: toSend.url,
				data: toSend,
				type: 'POST',
				beforeSend: function() {
					afterloadOverlay(selector);
				},
				success: function(data) {
					// setTimeout(function() {
					selector.html(data);
					// }, 2000);
				},
				error: function() {
					getAfterload(selector, ++attemps);
				},
				complete: function() {
					loading = false;
				}
			});
		} else {
			selector.html(afterloadErrorTpl);
			loading = false;
		}
	}

	afterload();
});