var grecatptcha_loaded=0;
var recaptchas=[];
var hugeit_forms_onloadCallback = function() {
	var form_ids = [];
	var sitekeys = [];
	var themes = [];
	var type= [];
  	jQuery(".captcha-block").each(function(i){
  		form_ids[i] = jQuery(this).data("form_id");
  		sitekeys[i] = jQuery(this).data("sitekey");
  		themes[i] = jQuery(this).data("theme");
  		type[i] = jQuery(this).data("cname");
  	}).promise().done(function(){  		
		jQuery.each(form_ids,function(i){
			var dom_id = 'huge_it_captcha_'+form_ids[i];
			var callback = 'verifyCallback_'+form_ids[i];
			var typeofcapt=type[i];
			recaptchas[form_ids[i]] = grecaptcha.render(dom_id,{
				'sitekey':sitekeys[i],
				'callback': function(response) {
					jQuery( "#huge_it_contact_form_"+form_ids[i]).attr("verified","1");														
			  },'theme' : themes[i],
			  	'type' : typeofcapt
			});
		});

  	});
};
