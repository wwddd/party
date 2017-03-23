// $(function() {
// TABS, AJAX LOADING
	var afterloadOverlayTpl = '<div class="afterload-overlay"><div class="afterload-loader"></div></div>';
	var afterloadErrorTpl = '<div class="afterload-error"><p>Something goes wrong...</p></div>';
	var currentTab = getUrlParameter('tab');
	var loading = false;
	var _token = $('meta[name="csrf-token"]').attr('content');

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
		if($('.tab').length > 0) {
			if(!loading) {
				if(e.state){
					sendTab($('#' + e.state));
				}
			}
		}
	};

	if($('.tab').length > 0) {
		if(!currentTab) {
			sendTab($('.tab').first());
		} else {
			sendTab($('#' + currentTab));
		}
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
				// $('.afterload').hide();
				$(this).show();
				getAfterload($(this));
			}
		});
	}

	function afterloadOverlay(selector) {
		selector.html(afterloadOverlayTpl).show();
	}

	function getAfterload(selector, attemps = 0) {
		loading = true;
		if(attemps < 3) {
			var toSend = selector.data();
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': _token
				},
				url: toSend.url,
				data: toSend,
				type: 'POST',
				beforeSend: function() {
					afterloadOverlay(selector);
				},
				success: function(data) {
					setTimeout(function() {
					selector.html(data);
					}, 300);
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
// /TABS, AJAX LOADING

// SELECTS
	$(document).on('click', '.select-multiple', function(e) {
		if(e.target.className === 'select-multiple' || e.target.className === 'select-title') {
			$(this).toggleClass('active');
		}
	});

	$(document).on('click', '.select-multiple .select-inner span', function() {
		$(this).siblings('input').click();
	});

	$(document).on('click', '.select-multiple .select-inner input', function() {
		var choosenTags = '';
		$(this).closest('.select-inner').find('input:checked').each(function() {
			choosenTags += '<span data-val="' + $(this).val() + '" class="tag">' + $(this).val() + ' x</span>';
		});
		$('.choosen-select').html(choosenTags);
	});

	$(document).on('click', '.tag', function() {
		var _self = $(this);
		var value = $(this).data('val');
		$('.select-inner').find('input:checked').each(function() {
			if($(this).val() === value) {
				$(this).prop('checked', false);
				_self.remove();
			}
		});
	});
// /SELECTS

// TAGS
	$(document).on('keypress', '.input-tags input', function(e) {
		if(e.keyCode == 13) {
			var inputTag = '<span class="input-tag">' + $(this).val() + ' x</span>';
			$(this).closest('.input-tags').prepend(inputTag);
			$(this).val('');
			return false;
		}
	});

	$(document).on('click', '.input-tag', function() {
		$(this).remove();
	});

// /TAGS

// NOTICES
	setTimeout(function() {
		$('.temporary-message').hide(300);
	}, 4000);


	var intervalMainNotice;
	function mainNotice(text, status) {
		clearInterval(intervalMainNotice);
		var notice = $('#main-notice');
		notice.removeAttr('class');
		notice.find('.notice-message').text(text);
		if(status == 'success') {
			notice.addClass('success');
		} else if(status == 'fail') {
			notice.addClass('fail');
		}
		notice.addClass('active');

		intervalMainNotice = setInterval(function() {
			$('#main-notice').removeClass('active');
		}, 4000);
	}

	$('#main-notice .notice-x').on('click', function() {
		$('#main-notice').removeClass('active');
	});
// /NOTICES

// FORMS
	// function validate(formGroup) {
	// 	var value = formGroup.find('input, textarea').val();
	// 	if(value == '') {
	// 		// formGroup.append('<b>error</b>');
	// 	}
	// 	// console.log(value);
	// }

	function createInputs(formGroup) {
		if(formGroup.hasClass('form-input-tags')) {
			var inputName = formGroup.find('input').attr('name');
			formGroup.find('input[type="hidden"]').remove();
			$(formGroup).find('.input-tag').each(function() {
				formGroup.append('<input type="hidden" name="' + inputName + '" value="' + $(this).text() + '">');
			});
		} else {

		}
	}

	$(document).on('focus', 'input, textarea, select', function() {
		$(this).closest('.form-group').find('.error').remove();
	});

	$(document).on('submit', 'form.form', function(e) {
		e.preventDefault();
		var form = $(this);
		// form.find('button[type="submit"]').prop('disabled', true);
		var action = form.attr('action');
		var method = form.attr('method');
		form.find('.form-group').each(function() {
			if($(this).hasClass('required')) {
				// validate($(this));
			}
			createInputs($(this));
		});
		// var toSend = form.serializeArray();
		// var toSend = form.serializeArray();
		var toSend = new FormData(form[0]);
		// console.log(toSend);
		// console.log(toSend);
		// console.log($('meta[name="csrf-token"]').attr('content'));
		$.ajax({
			url: action,
			data: toSend,
			type: method,
			contentType: false,
			cache: false,
			processData:false,
			headers: {
				'X-CSRF-TOKEN': _token
			},
			beforeSend: function() {
				$('.error').remove();
			},
			success: function(data) {
				var response = $.parseJSON(data);
				if(response.status == 'success') {
					mainNotice(response.message, 'success');
				} else if(response.status == 'fail') {
					mainNotice(response.message, 'fail');
				}

				if(response.redirect !== undefined) {
					setTimeout(function() {
						window.location.href = response.redirect;
					}, 2000);
				}

				if(response.event_action !== undefined && response.event_button !== undefined) {
					form.attr('action', response.event_action);
					form.find('button[type="submit"]').text(response.event_button);
				}

				if(response.avg_event !== undefined) {
					$('.rating_block').html(response.avg_event);
				}
				form.find('button.no-disabled').prop('disabled', false);
			},
			error: function(e) {
				var errors = e.responseJSON;
				for(err in errors) {
					form.find('*[name="' + err + '"]').closest('.form-group').append('<span class="error">' + errors[err] + '</span>');
				}

				if(e.status == 422) {
					mainNotice('Заполните все необходимые поля!', 'fail');
				} else if(e.status == 500) {
					mainNotice('Ошибка 500! Разработчик - мудак :)', 'fail');
				}
				form.find('button[type="submit"]').prop('disabled', false);
			}
		});
	});
// /FORMS

// google api key - AIzaSyBDXGYgmltbd4c0zuLi7DbEjeldxlTRlUg

// });


// });



// var MIN_LENGTH = 2;
// $(document).ready(function() {
// 	$("#keyword").keyup(function(e) {
// 		var keyCode = e.keyCode;
// 		var keyword = $("#keyword").val();
// 		if (keyword.length >= MIN_LENGTH && keyCode !== 38 && keyCode !== 40) {
// 			$.get("/autocomplete", {
// 				keyword: keyword
// 			}).done(function(data) {
// 				$('#results').html('');
// 				var results = jQuery.parseJSON(data);
// 				$(results).each(function(key, value) {
// 					if (typeof value.image != 'undefined') {
// 						$('#results').append('<div class="item col-xs-12"><div class="col-xs-2"><a href="/' + value.controller + '/' + value.cat_slug + '"><img src="' + value.image + '"/></a></div><div class="col-xs-10"><a href="/' + value.controller + '/' + value.cat_slug + '">' + value.cat_name + '</a></div></div>');
// 					} else {
// 						$('#results').append('<div class="item col-xs-12 autosuggest"><a href="/' + value.controller + '/' + value.cat_slug + '">' + value.cat_name + '</a></div>');
// 					}
// 				})
// 			});
// 		} else if (keyCode == 38 || keyCode == 40) {
// 			if (!$('.autosuggest').hasClass('.search-selected')) {
// 				if (keyCode === 38) {
// 					if ($('.search-selected').prev('.autosuggest').length > 0) {
// 						$('.search-selected').removeClass('search-selected').prev('.autosuggest').addClass('search-selected');
// 					} else {
// 						$('.search-selected').removeClass('search-selected');
// 						$('.autosuggest:last-child').addClass('search-selected');
// 					}
// 				} else {
// 					if ($('.search-selected').next('.autosuggest').length > 0) {
// 						$('.search-selected').removeClass('search-selected').next('.autosuggest').addClass('search-selected');
// 					} else {
// 						$('.search-selected').removeClass('search-selected');
// 						$('.autosuggest:first-child').addClass('search-selected');
// 					}
// 				}
// 			}
// 			$("#keyword").val($('.search-selected a').text());
// 			$('form.header-search').attr('action', $('.search-selected a').attr('href'));
// 		} else {
// 			$('#results').html('');
// 		}
// 	});
// 	$("#keyword").blur(function() {
// 		$("#results").fadeOut(500);
// 	}).focus(function() {
// 		$("#results").show();
// 	});
// });
