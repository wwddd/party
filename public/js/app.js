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
					if($(this).is(':empty') || tab.hasClass('dynamic')) {
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
						if($(document).find('.notices-body .notice').length > 0) {
							$('.notice-circle').addClass('active');
						}
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

	function sendForm(form, confirm = false) {
		if(confirm) {
			// form.find('button[type="submit"]').prop('disabled', true);
			var action = form.attr('action');
			var method = form.attr('method');
			form.find('.form-group').each(function() {
				createInputs($(this));
			});
			var toSend = new FormData(form[0]);
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
					callbackForm(form, response)
					form.find('button.no-disabled').prop('disabled', false);
				},
				error: function(e) {
					var errors = e.responseJSON;
					for(err in errors) {
						form.find('*[name="' + err + '"]').closest('.form-group').append('<span class="error">' + errors[err] + '</span>');
					}

					if(e.status == 422) {
						mainNotice('Введите корректные данные!', 'fail');
					} else if(e.status == 500) {
						mainNotice('Ошибка 500! Разработчик - мудак :)', 'fail');
					}
					form.find('button[type="submit"]').prop('disabled', false);
				}
			});
		}
	}

	function callbackForm(form, response) {
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

		if(response.event_image !== undefined) {
			$('.event-image img').attr('src', response.event_image);
			$('.event-upload').remove();
		}

		if(response.close_modal !== undefined) {
			$('.modal').removeClass('active');
			$('.overlay').fadeOut(300);
		}

		if(response.send_again !== undefined) {
			$('#send_again').html('<button type="submit" class="send_again">Не пришло письмо?</button>');
		}
	}

	function confirmSend(form) {
		$('#confirm-modal').addClass('active');
		$('#confirm-overlay').fadeIn(300);
		$('.confirm-yes').on('click.confirm', function() {
			$('#confirm-modal').removeClass('active');
			$('#confirm-overlay').fadeOut(300);
			sendForm(form, true);
		});
	}

	$('.confirm-no').on('click', function() {
		$('.confirm-yes').off('click.confirm');
		$('#confirm-modal').removeClass('active');
		$('#confirm-overlay').fadeOut(300);
	});

	$(document).on('submit', 'form.form', function(e) {
		$('.confirm-yes').off('click.confirm');
		e.preventDefault();
		var form = $(this);
		if(form.hasClass('confirm')) {
			confirmSend(form);
		} else {
			sendForm(form, true);
		}
	});

	$(document).on('change', '.submit_upload', function() {
		var form = $(this).closest('form.form');
		sendForm(form, true);
	});





	function generateAutocomplete(input, items) {
		var resultBlock = input.siblings('.autocomplete-result');
		var result = '';
		for(i in items) {
			result += '<div data-id="' + items[i].id + '">' + items[i].title + '</div>';
		}
		resultBlock.html(result);
		resultBlock.fadeIn(200);
	}

	function autocompleteByName(input) {
		var resultBlock = input.siblings('.autocomplete-result');
		resultBlock.find('div').each(function() {
			if($(this).is(':contains("' + input.val() + '")')) {
				$(this).show();
			} else {
				$(this).hide();
			}
		});
		resultBlock.fadeIn(200);
	}

	$(document).on('keypress', '.autocomplete-input', function(e) {
		if(e.keyCode == 13) {
			e.preventDefault();
			var resultBlock = $(this).siblings('.autocomplete-result');
			if(resultBlock.find('div.active').length > 0) {
				$(this).val(resultBlock.find('div.active').text());
				$(this).data('id', resultBlock.find('div.active').data('id'));
			}
			$(this).blur();
			resultBlock.fadeOut(200);
		}
	});

	$(document).on('blur', '.autocomplete-input', function(e) {
		$(this).siblings('.autocomplete-result').fadeOut(200);
		$(this).siblings('.autocomplete-result').find('div.active').removeClass('active');
	});

	$(document).on('click', '.autocomplete-result div', function(e) {
		$(this).closest('.autocomplete-body').find('.autocomplete-input').val($(this).text());
		$(this).closest('.autocomplete-body').find('.autocomplete-input').data('id', $(this).data('id'));
	});

	$(document).on('keyup focus', '.autocomplete-input', function(e) {
		var input = $(this);
		var resultBlock = input.siblings('.autocomplete-result');
		var q = input.val();
		var keyCode = e.keyCode;
		if (keyCode == 38 || keyCode == 40) {
			if(keyCode == 38) {
				if(resultBlock.find('div.active:visible').length > 0) {
					resultBlock.find('div.active').removeClass('active').prevAll('div:visible').first().addClass('active');
				} else {
					resultBlock.find('div:visible').last().addClass('active');
				}
			}
			if(keyCode == 40) {
				if(resultBlock.find('div.active:visible').length > 0) {
					resultBlock.find('div.active').removeClass('active').nextAll('div:visible').first().addClass('active');
				} else {
					resultBlock.find('div:visible').first().addClass('active');
				}
			}
		} else {
			var count = 7;
			var need_all = 0;
			if(input.data('sense') == 'city') {
				var sense = 'getCities';
			} else if(input.data('sense') == 'country') {
				var sense = 'getCountries';
				count = 200;
				need_all = 1;
				if(resultBlock.find('div').length > 0) {
					autocompleteByName(input);
					return false;
				}
			}
			var country_id = 1;
			$('.autocomplete-input').each(function() {
				if($(this).data('sense') == 'country' && $(this).data('id')) {
					country_id = $(this).data('id');
				}
			});

			// 83e2d3fb83e2d3fb83509f1f8183b8bc76883e283e2d3fbdb2b9eaaab67dfda22037aeb
			// ff61b0b5ff61b0b5ffd3fc5121ff3b0e14fff61ff61b0b5a7b7555d105a7be78cdc5d48
			$.ajax({
				url: "https://api.vk.com/method/database." + sense,
				crossDomain: true,
				dataType: 'jsonp',
				type: 'GET',
				data: {
					access_token: 'ff61b0b5ff61b0b5ffd3fc5121ff3b0e14fff61ff61b0b5a7b7555d105a7be78cdc5d48',
					country_id: country_id,
					count: count,
					need_all: need_all,
					q: q,
					v: 5.62
				},
				success: function(data) {
					console.log(data);
					var items = data.response.items;
					generateAutocomplete(input, items);
				}
			});
		}
	});
// /FORMS

// NOTICES
	$('#notices i').on('click', function(e) {
		if($(document).find('.notices-body .notice').length > 0) {
			$('.notices-parent').toggle();
			$('.notice-circle').removeClass('active');
		}
	});

	$(document).on('click', '#notices .notice-head-x', function() {
		var notice = $(this).closest('.notice');
		var id = $(this).data('id');
		var url = $(this).data('url');
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': _token
			},
			url: url,
			data: {
				id: id
			},
			type: 'POST',
			success: function(data) {
				notice.remove();
				if($(document).find('.notices-body .notice').length == 0) {
					$('.notices-parent').hide();
					$('.notice-circle').removeClass('active');
				}
			}
		});
		
	});
// /NOTICES


// google api key - AIzaSyBDXGYgmltbd4c0zuLi7DbEjeldxlTRlUg