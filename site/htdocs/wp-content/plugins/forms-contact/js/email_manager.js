jQuery(document).ready(function(){		
		/*******//////////////////Email Manager Scripts////////////////*********/
		var showC='true';
		var myVar;
		//Send Mailings
		jQuery('#hugeit_contact_email_manager').on('click tap','#btn',function(){
				alert('This option is disabled for free version. Please upgrade to pro license to be able to use it.');		
			});

		//Choose Form
		jQuery('#hugeit_contact_email_manager #huge_it_form_choose').on('change',function(){
			var formsToShow=jQuery(this).val();
			jQuery.ajax({
					type: "POST",
					url: ajaxurl,
					data: {
						"data": formsToShow,
						"action": 'hugeit_email_action',
		                "task": 'showForms',
		                "nonce" : huge_it_obj.nonce
					},
					beforeSend: function(){
						jQuery('#hugeit_contact_email_manager #table_overlay').css('display','block');					
					},
					success: function(response){
						var response = jQuery.parseJSON(response);
				   			if(response.output){		   				
				   				jQuery("#hugeit_contact_email_manager").find("#huge_it-table").html(response.output); 	
				   				jQuery('#hugeit_contact_email_manager #table_overlay').css('display','none'); 
				            }
					},
					error: function(){
						//alert('Error!');
					}
				});
		});
		//Delete Subscriber
		jQuery('#hugeit_contact_email_manager').on('click tap','.del_wrap',function(e){
			e.preventDefault();
			alert('This option is disabled for free version. Please upgrade to pro license to be able to use it.');	
		});
		//Add Subscriber
		jQuery('#hugeit_contact_email_manager').on('click tap','.add_wrap',function(e){
			e.preventDefault();
			alert('This option is disabled for free version. Please upgrade to pro license to be able to use it.');	

		});
		setInterval(function(){
			var formId=jQuery('#hugeit_contact_email_manager #huge_it_form_choose').val();
			jQuery.ajax({
						type: "POST",
						url: ajaxurl,
						data: {
							data:formId,
							action: 'hugeit_email_action',
			                task: 'refreshTable',
			                nonce : huge_it_obj.nonce
						},
						beforeSend: function(){
							//jQuery("#hugeit_contact_email_manager #huge_it-table").find("tbody").css('overflow','hidden');
						},
						success: function(response){
							var response = JSON.parse(response);
				   			if(response.output){
				   				var decoded = jQuery("<textarea/>").html(response.output).text();
				   				jQuery("#hugeit_contact_email_manager #huge_it-table").find("tbody").html(decoded);
				            }
						},
					});
		}, 5000);
		//Refresh
		function refreshTable(formID){
			var formId=jQuery('#hugeit_contact_email_manager #huge_it_form_choose').val();
			jQuery.ajax({
						type: "POST",
						url: ajaxurl,
						data: {
							"data":formID,
							"action": 'hugeit_email_action',
			                "task": 'refreshTable',
		                	nonce : huge_it_obj.nonce
						},
						beforeSend: function(){
						},
						success: function(response){
							var response = jQuery.parseJSON(response);
				   			if(response.output){
				   				jQuery("#hugeit_contact_email_manager #huge_it-table").find("tbody").html(response.output);                             
				            }
						},
						error: function(){
							//alert('Error!');
						}
					});
		}
		// if(typeof huge_it_obj =="undefined"){
		// 		var huge_it_obj=new Array();
		// 	}
		if(huge_it_obj.mail_status=='start'){
			setInterval(function(){
				jQuery.ajax({
						type: "POST",
						url: ajaxurl,
						data: {
							"action": 'hugeit_email_action',
			                "task": 'refreshProgress',
			                "nonce" : huge_it_obj.nonce
						},
						beforeSend: function(){
						},
						success: function(response){
							var response = jQuery.parseJSON(response);
							jQuery("#hugeit_contact_email_manager").find("#progress_meter").css('width',response.percent+'%');
							jQuery("#hugeit_contact_email_manager").find("#progress_time").text(response.need_time);
							if(response.cond=="finish"){
									showCont(showC);
								}
						},
						error: function(){
							//alert('Error!');
						}
					});
			},10000);
		}
		function loadingProcess(){
			jQuery.ajax({
						type: "POST",
						url: ajaxurl,
						data: {
							"action": 'hugeit_email_action',
			                "task": 'refreshProgress'
						},
						beforeSend: function(){
						},
						success: function(response){
							var response = jQuery.parseJSON(response);
							jQuery("#hugeit_contact_email_manager").find("#progress_meter").css('width',response.percent+'%');
							jQuery("#hugeit_contact_email_manager").find("#progress_time").text(response.need_time);
							if(response.cond=="finish"){
									showCont(showC);
							}
						},
						error: function(){
							//alert('Error!');
						}
					});

		}
		function showCont(some){
			//jQuery('#button').on('click',function(){
				jQuery.ajax({
						type: "POST",
						url: ajaxurl,
						data: {
							"action": 'hugeit_email_action',
			                "task": 'showCont',
			                "noCancel":some
						},
						beforeSend: function(){
						},
						success: function(response){
							var response = jQuery.parseJSON(response);
							if(response.output){
								jQuery("#hugeit_contact_email_manager").find("#showCont").html(response.output);
							}
						},
						error: function(){
							//alert('Error!');
						}
					});
				//})
			
		}
		//Cancel
		jQuery('#hugeit_contact_email_manager').on('click tap','#huge_it_cancel',function(){
			var sub_choose_form=jQuery('#hugeit_contact_email_manager #huge_it_form_choose').val();
			jQuery.ajax({
						type: "POST",
						url: ajaxurl,
						data: {
							action: 'hugeit_email_action',
			                task: 'huge_it_cancel',
						},
						beforeSend: function(){
						},
						success: function(response){
							clearInterval(myVar);
							var cancel='false';
							showCont(cancel);
							jQuery("#hugeit_contact_email_manager").find("#done").hide();
							refreshTable(sub_choose_form);
						},
						error: function(){
							//alert('Error!');
						}
					});
		})
		/*******//////////////////Email Manager Scripts////////////////*********/
});