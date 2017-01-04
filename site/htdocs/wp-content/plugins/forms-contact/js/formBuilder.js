jQuery(document).ready(function(e) {
	////ADD FIELDS START///

	jQuery('#add-fields-block #add-default-fields').on('click', 'li>a', function(event) {
		event.preventDefault();
		var readyDef;
		if (jQuery(this).parents('#add-default-fields').hasClass('readyFields')) {
			alert('This option is disabled for free version. Please upgrade to pro license to be able to use it.');
			return;
		} else {
			readyDef = jQuery('#add-fields-block li.spinnerLi>img.defSpin');
		}
		var formId = jQuery(this).attr('data-formId');
		var inputType = jQuery(this).attr('id');
		var inputTypeStatus = 0;
		if (jQuery(this).parent().hasClass('disabled')) {
			inputTypeStatus = 'disabled';
		}
		var themeId = jQuery(this).attr('data-themeId');
		if (inputType == 'captcha' || inputType == 'buttons' || inputType == 'license') {
			jQuery('#add-default-fields').find('li>a#' + inputType + '').parent().addClass('disabled');
		}
		if (jQuery('#add-fields-block li.spinnerLi>img').css('display') != 'inline') {
			if (inputTypeStatus != 'disabled' && inputType != 'Nocaptcha' && inputType != 'custom_text') {
				readyDef.css('display', 'inline');
				jQuery.ajax({
					type: "POST",
					url: ajaxurl,
					data: {
						action: 'hugeit_contact_formBuilder_action',
						task: 'addFieldsTask',
						formId: formId,
						nonce: huge_it_obj.nonce,
						inputType: inputType,
						themeId: themeId
					}
				}).done(function(response) {
					var response = jQuery.parseJSON(response);
					if (response) {
						if (response.captchaNum) {
							var ifExists = false;
							if (jQuery('#fields-list-block #fields-list-right li').length == 0) {
								jQuery('#fields-list-block #fields-list-left').append(response.outputFieldSettings);
							} else {
								jQuery('#fields-list-block #fields-list-right').append(response.outputFieldSettings);
							}
							if (jQuery('#hugeit-contact-wrapper .hugeit-contact-block-right div').length == 0) {
								jQuery(".hugeit-contact-block-left > div").each(function() {
									if (jQuery(this).hasClass('buttons-block')) {
										ifExists = true;
									}
								});
								if (ifExists) {
									var beforeAdd = jQuery('.hugeit-contact-block-left').find('div.buttons-block');
									jQuery(response.outputField).insertBefore(beforeAdd);
								} else {
									jQuery('#hugeit-contact-wrapper .hugeit-contact-block-left').append(response.outputField);
								}
							} else {
								jQuery(".hugeit-contact-block-right > div").each(function() {
									if (jQuery(this).hasClass('buttons-block')) {
										ifExists = true;
									}
								});
								if (ifExists) {
									var beforeAdd = jQuery('.hugeit-contact-block-right').find('div.buttons-block');
									jQuery(response.outputField).insertBefore(beforeAdd);
								} else {
									jQuery('#hugeit-contact-wrapper .hugeit-contact-block-right').append(response.outputField);
								}
							}
							var leftelement = [];
							var rightelement = [];

							jQuery(".hugeit-contact-block-left > div").each(function() {
								leftelement.push(jQuery('.fields-list li[id="' + jQuery(this).attr('rel') + '"]'));
								jQuery(this).find('.left-right-position').val('left');
							});

							jQuery(".hugeit-contact-block-right > div").each(function() {
								rightelement.push(jQuery('.fields-list li[id="' + jQuery(this).attr('rel') + '"]'));
								jQuery(this).find('.left-right-position').val('right');
							});

							jQuery('#fields-list-left').html(leftelement);
							jQuery('#fields-list-right').html(rightelement);

							var public_num = response.captchaNum;
							var verifyCallback = function(response) {
							};
							grecaptcha.render('democaptchalight', {
								'sitekey': public_num,
								'callback': verifyCallback,
								'theme': 'light',
								'type': 'image'
							});

							grecaptcha.render('democaptchadark', {
								'sitekey': public_num,
								'callback': verifyCallback,
								'theme': 'dark',
								'type': 'image'
							});

							i = 0;
							jQuery("#fields-list-right > li").each(function() {
								jQuery(this).find('.ordering').val(i);
								i++;
							});
							i = 0;
							jQuery("#fields-list-left > li").each(function() {
								jQuery(this).find('.ordering').val(i);
								i++;
							});
							i = 0;
							jQuery(".hugeit-contact-block-left > div.hugeit-field-block").each(function() {
								jQuery(this).find('input.ordering').val(i);
								i++;
							});
							i = 0;
							jQuery(".hugeit-contact-block-right > div.hugeit-field-block").each(function() {
								jQuery(this).find('input.ordering').val(i);
								i++;
							});
							jQuery(".fields-list > li").removeClass('has-background');
							count = jQuery(".fields-list > li").length;
							for (var i = 0; i <= count; i += 2) {
								jQuery("#fields-list-left > li").eq(i).addClass("has-background");
								jQuery("#fields-list-right > li").eq(i).addClass("has-background");
							}
							readyDef.css('display', 'none');
						} else if (response.customText) {
							jQuery('#hugeit-contact-wrapper .hugeit-contact-block-left').prepend(response.outputField);
							jQuery('#fields-list-block #fields-list-left').prepend(response.outputFieldSettings);

							i = 0;
							jQuery("#fields-list-right > li").each(function() {
								jQuery(this).find('.ordering').val(i);
								i++;
							});
							i = 0;
							jQuery("#fields-list-left > li").each(function() {
								jQuery(this).find('.ordering').val(i);
								i++;
							});
							i = 0;
							jQuery(".hugeit-contact-block-left > div.hugeit-field-block").each(function() {
								jQuery(this).find('input.ordering').val(i);
								i++;
							});
							i = 0;
							jQuery(".hugeit-contact-block-right > div.hugeit-field-block").each(function() {
								jQuery(this).find('input.ordering').val(i);
								i++;
							});
							jQuery(".fields-list > li").removeClass('has-background');
							count = jQuery(".fields-list > li").length;
							for (var i = 0; i <= count; i += 2) {
								jQuery("#fields-list-left > li").eq(i).addClass("has-background");
								jQuery("#fields-list-right > li").eq(i).addClass("has-background");
							}
							readyDef.css('display', 'none');
						} else if (response.buttons) {
							if (jQuery('#fields-list-block #fields-list-right li').length == 0) {
								jQuery('#fields-list-block #fields-list-left').append(response.outputFieldSettings);
							} else {
								jQuery('#fields-list-block #fields-list-right').append(response.outputFieldSettings);
							}
							if (jQuery('#hugeit-contact-wrapper .hugeit-contact-block-right div').length == 0) {
								jQuery('#hugeit-contact-wrapper .hugeit-contact-block-left').append(response.outputField);
							} else {
								jQuery('#hugeit-contact-wrapper .hugeit-contact-block-right').append(response.outputField);
							}
							var leftelement = [];
							var rightelement = [];

							jQuery(".hugeit-contact-block-left > div").each(function() {
								leftelement.push(jQuery('.fields-list li[id="' + jQuery(this).attr('rel') + '"]'));
								jQuery(this).find('.left-right-position').val('left');
							});

							jQuery(".hugeit-contact-block-right > div").each(function() {
								rightelement.push(jQuery('.fields-list li[id="' + jQuery(this).attr('rel') + '"]'));
								jQuery(this).find('.left-right-position').val('right');
							});

							jQuery('#fields-list-left').html(leftelement);
							jQuery('#fields-list-right').html(rightelement);
							jQuery(".fields-list > li").removeClass('has-background');
							count = jQuery(".fields-list > li").length;
							for (var i = 0; i <= count; i += 2) {
								jQuery("#fields-list-left > li").eq(i).addClass("has-background");
								jQuery("#fields-list-right > li").eq(i).addClass("has-background");
							}
							readyDef.css('display', 'none');
						} else {
							jQuery('#hugeit-contact-wrapper .hugeit-contact-block-left').prepend(response.outputField);
							jQuery('#fields-list-block #fields-list-left').prepend(response.outputFieldSettings);
							//
							i = 0;
							jQuery("#fields-list-right > li").each(function() {
								jQuery(this).find('.ordering').val(i);
								i++;
							});
							i = 0;
							jQuery("#fields-list-left > li").each(function() {
								jQuery(this).find('.ordering').val(i);
								i++;
							});
							i = 0;
							jQuery(".hugeit-contact-block-left > div.hugeit-field-block").each(function() {
								jQuery(this).find('input.ordering').val(i);
								i++;
							});
							i = 0;
							jQuery(".hugeit-contact-block-right > div.hugeit-field-block").each(function() {
								jQuery(this).find('input.ordering').val(i);
								i++;
							});
							jQuery(".fields-list > li").removeClass('has-background');
							count = jQuery(".fields-list > li").length;
							for (var i = 0; i <= count; i += 2) {
								jQuery("#fields-list-left > li").eq(i).addClass("has-background");
								jQuery("#fields-list-right > li").eq(i).addClass("has-background");
							}
							readyDef.css('display', 'none');
						}
					}
				});
			}
		}
	});
	////ADD FIELDS END///
	/***************************/
	////DELETE FIELDS START///
	jQuery('#fields-list-block').on('click', '.field-top-options-block>a.remove-field', function(event) {
		var self = jQuery(this);
		var selfField = jQuery(this).parent().parent().parent();
		var formId = jQuery("#add-fields-block").find('li.spinnerLi').attr('data-idForm');
		var fieldId = jQuery(this).parents('li[data-fieldNum]').attr('data-fieldNum');
		event.preventDefault();
		var form = jQuery('#adminForm');
		var inputTypeStatus = 0;
		if (jQuery(this).parents('#huge-contact-field-' + fieldId + '').attr('data-fieldType') == 'captcha') {
			inputTypeStatus = 'captcha';
		} else if (jQuery(this).parents('#huge-contact-field-' + fieldId + '').attr('data-fieldType') == 'buttons') {
			inputTypeStatus = 'buttons';
		} else if (jQuery(this).parents('#huge-contact-field-' + fieldId + '').attr('data-fieldType') == 'license') {
			inputTypeStatus = 'license';
		}
		;
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'hugeit_contact_formBuilder_action',
				task: 'removeFieldTask',
				formId: formId,
				nonce: huge_it_obj.nonce,
				fieldId: fieldId,
				formData: form.serialize()
			},
			beforeSend: function() {
				self.addClass('remove-spinner');
			},
			success: function(response) {
				var response = jQuery.parseJSON(response);
				if (response.removedField) {
					var fieldRes = response.removedField;
					jQuery('#fields-list-block').find('li[id="huge-contact-field-' + fieldRes + '"]').fadeOut(function() {
						jQuery(this).animate({"left": "0", "top": "0"});
						jQuery(this).remove();
					});
					jQuery('#hugeit-contact-wrapper').find('div[rel="huge-contact-field-' + fieldRes + '"]').fadeOut(function() {
						jQuery(this).animate({"left": "0", "top": "0"});
						jQuery(this).remove();
					});
					i = 0;
					jQuery("#fields-list-right > li").each(function() {
						jQuery(this).find('.ordering').val(i);
						i++;
					});
					i = 0;
					jQuery("#fields-list-left > li").each(function() {
						jQuery(this).find('.ordering').val(i);
						i++;
					});
					i = 0;
					jQuery(".hugeit-contact-block-left > div.hugeit-field-block").each(function() {
						jQuery(this).find('input.ordering').val(i);
						i++;
					});
					i = 0;
					jQuery(".hugeit-contact-block-right > div.hugeit-field-block").each(function() {
						jQuery(this).find('input.ordering').val(i);
						i++;
					});
					jQuery(".fields-list > li").removeClass('has-background');
					count = jQuery(".fields-list > li").length;
					for (var i = 0; i <= count; i += 2) {
						jQuery("#fields-list-left > li").eq(i).addClass("has-background");
						jQuery("#fields-list-right > li").eq(i).addClass("has-background");
					}
					jQuery('.fields-list>li').each(function() {
						jQuery(this).css('display', 'block');
					});
				}
				if (inputTypeStatus == 'captcha' || inputTypeStatus == 'buttons' || inputTypeStatus == 'license') {
					jQuery('#add-default-fields').find('li>a#' + inputTypeStatus + '').parent().removeClass('disabled');
				}
			}
		});
	});
	////DELETE FIELDS END//
	////DUBLICATE FIELDS START///
	jQuery('#fields-list-block').on('click', '.field-top-options-block>a.copy-field', function(event) {
		var self = jQuery(this);
		var formId = jQuery("#add-fields-block").find('li.spinnerLi').attr('data-idForm');
		var fieldId = jQuery(this).parents('li[data-fieldNum]').attr('data-fieldNum');
		var themeId = jQuery("#add-fields-block #add-default-fields li>a").attr('data-themeId');
		var fieldType = jQuery(this).parents('#huge-contact-field-' + fieldId + '').attr('data-fieldType');
		event.preventDefault();
		var form = jQuery('#adminForm');
		if (fieldType != 'custom_text') {
			jQuery.ajax({
				type: "POST",
				url: ajaxurl,
				data: {
					action: 'hugeit_contact_formBuilder_action',
					task: 'dublicateFieldTask',
					formId: formId,
					nonce: huge_it_obj.nonce,
					fieldId: fieldId,
					themeId: themeId,
					formData: form.serialize()
				},
				beforeSend: function() {
					self.addClass('remove-spinner');
				},
				success: function(response) {
					var response = jQuery.parseJSON(response);
					var beforeID = response.beforeId;
					var beforeAdd = jQuery('#hugeit-contact-wrapper .hugeit-contact-column-block').find('div[rel="huge-contact-field-' + beforeID + '"]');
					var beforeAddSettings = jQuery('#fields-list-block .fields-list').find('li[id="huge-contact-field-' + beforeID + '"]');
					jQuery(response.outputFieldSettings).insertAfter(beforeAddSettings);
					jQuery(response.outputField).insertAfter(beforeAdd);
					i = 0;
					jQuery("#fields-list-right > li").each(function() {
						jQuery(this).find('.ordering').val(i);
						i++;
					});
					i = 0;
					jQuery("#fields-list-left > li").each(function() {
						jQuery(this).find('.ordering').val(i);
						i++;
					});
					i = 0;
					jQuery(".hugeit-contact-block-left > div.hugeit-field-block").each(function() {
						jQuery(this).find('input.ordering').val(i);
						i++;
					});
					i = 0;
					jQuery(".hugeit-contact-block-right > div.hugeit-field-block").each(function() {
						jQuery(this).find('input.ordering').val(i);
						i++;
					});
					jQuery(".fields-list > li").removeClass('has-background');
					count = jQuery(".fields-list > li").length;
					for (var i = 0; i <= count; i += 2) {
						jQuery("#fields-list-left > li").eq(i).addClass("has-background");
						jQuery("#fields-list-right > li").eq(i).addClass("has-background");
					}
					;
					self.removeClass('remove-spinner');
				}
			});
		} else {
			self.addClass('remove-spinner');
		}
	});
	////DUBLICATE FIELDS END///
	///SAVE FORM STARTS///
	jQuery('#save-button-block').on('click', 'input#save-buttom', function(event) {
		event.preventDefault();
		var formId = jQuery("#add-fields-block").find('li.spinnerLi').attr('data-idForm');
		var form = jQuery('#adminForm');
		var spinner = jQuery(this).parent().find('.saveSpinnerWrapper>img');
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'hugeit_contact_formBuilder_action',
				task: 'saveEntireForm',
				formId: formId,
				nonce: huge_it_obj.nonce,
				formData: form.serialize()
			},
			beforeSend: function() {
				spinner.css('display', 'block');
			},
			success: function(response) {
				var response = jQuery.parseJSON(response);
				if (response.saveForm) {
					spinner.css('display', 'none');
				}
			}
		});
	});
	///SAVE FORM END///
	///CHANGE THEME START///
	jQuery('#save-button-block').on('change', 'select#select_form_theme', function(event) {
		var themeId = jQuery(this).val();
		var formId = jQuery("#add-fields-block").find('li.spinnerLi').attr('data-idForm');
		var form = jQuery('#adminForm');
		var spinner = jQuery(this).parent().find('img.themeSpinner');
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'hugeit_contact_formBuilder_action',
				task: 'changeFormTheme',
				formId: formId,
				themeId: themeId,
				formData: form.serialize(),
				nonce: huge_it_obj.nonce
			},
			beforeSend: function() {
				spinner.css('display', 'inline');
			},
			success: function(response) {
				if (response) {
					var style = document.getElementById('formStyles'),
						script = document.getElementsByTagName('script')[0],
						styles = response;
					script.parentNode.insertBefore(style, script);
					var regexp = /#hugeit-contact-wrapper\s?>\s?div\s?>\s?h3\s?{.+?display\s?:\s?([a-zA-Z-]+)/i;
					defaultTitleVisibility = regexp.exec(styles)[1];
					jQuery('#select_form_show_title').trigger('change');
					try {
						style.innerHTML = styles;
					}
					catch (error) {
						style.styleSheet.cssText = styles;
					}
				}
				spinner.css('display', 'none');
			}
		});
	});
	///CHANGE THEME END///
});