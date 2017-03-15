$(function() {
	var afterloadOverlayTpl = '<div class="afterload-overlay"><div class="afterload-loader"></div></div>';
	var afterloadErrorTpl = '<div class="afterload-error"><p>Something goes wrong...</p></div>';

	function afterload() {
		// var url = window.location.href.replace(/\/$/, "") + '_ajax';
		$(document).find('.afterload').each(function() {
			if($(this).is(':empty')) {
				getAfterload($(this));
			}
		});
	}

	function afterloadOverlay(selector) {
		selector.html(afterloadOverlayTpl);
	}

	function getAfterload(selector, attemps = 0) {
		if(attemps < 3) {
			var toSend = selector.data();
			$.ajax({
				url: toSend.url,
				data: toSend,
				type: 'GET',
				beforeSend: function() {
					afterloadOverlay(selector);
				},
				success: function(data) {
					selector.html(data);
				},
				error: function() {
					getAfterload(selector, ++attemps);
				}
			});
		} else {
			selector.html(afterloadErrorTpl);
		}
	}

	afterload();
});