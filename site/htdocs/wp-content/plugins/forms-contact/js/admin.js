var defaultTitleVisibility;

jQuery(document).ready(function () {

  	jQuery(".hugeit_contact_custom_settings_dropdown_heading").on("click",function () {
		jQuery(".hugeit_contact_custom_settings_dropdown_content").toggleClass("-hidden");
		if( jQuery(".hugeit_contact_custom_settings_dropdown_heading i").hasClass("hugeicons-chevron-down") ){
			jQuery(".hugeit_contact_custom_settings_dropdown_heading i")
				.removeClass("hugeicons-chevron-down")
				.addClass("hugeicons-chevron-up");
		}else{
			jQuery(".hugeit_contact_custom_settings_dropdown_heading i")
				.removeClass("hugeicons-chevron-up")
				.addClass("hugeicons-chevron-down");
		}
	});

	  if( jQuery("#hugeit_contact_user_message").length ){
		  jQuery("#hugeit_contact_user_message").attr("disabled","disabled");
	  }

	  if( jQuery("#hugeit_contact_admin_message").length ){
		  jQuery("#hugeit_contact_admin_message").attr("disabled","disabled");
	  }

  /*******//////////////////Submission Scripts////////////////*********/
  //   CHECK OR UNCHECK ALL SUBMITIONS
    var check_all = "#hugeit_submission_page #hugeit_top_controls .select input[name='all']";
    jQuery(check_all).change(function(){
        if(jQuery(this).is(':checked')){
            jQuery("input[name='check_comments']").each(function(){
                jQuery(this).attr("checked","checked");
            });
        }
        else{
            jQuery("input[name='check_comments']").each(function(){
                jQuery(this).removeAttr("checked");
            });
        }
    });
  // Check READ/UNREAD
  	jQuery('#hugeit_submission_page #hugeit_top_controls .controls-list .select select').change(function(){   //   alert(jQuery(this).val());
        var select_val = jQuery(this).val();
           if(select_val == "all"){    //    alert(select_val);
               jQuery("#the-comment-list tr").each(function(){
                   jQuery(this).find("input[name='check_comments']").attr("checked","checked");
               });
           }
            if(select_val == "none"){
                jQuery(this).parent().find("input[name='all']").removeAttr("checked");
                jQuery("#the-comment-list tr").each(function(){
                    jQuery(this).find("input[name='check_comments']").removeAttr("checked");
                });
            }else{
                jQuery("#the-comment-list tr").each(function(){
                    if(jQuery(this).hasClass(select_val)){ jQuery(this).find("input[name='check_comments']").attr("checked","checked"); }
                    else{ jQuery(this).find("input[name='check_comments']").removeAttr("checked"); }
                });
            }
        }); 
  // Delete or Mark as Spam
  jQuery('#hugeit_submission_page #hugeit_top_controls .controls-list li').click(function(e){
            var command = jQuery(this).attr("class");                 // VALUES CAN BE SPAM OR TRASH
            var marked_submitions = [];                               // THERE ARE ALL CHECKED SUBMITIONS(MESSAGES)
            var self=jQuery('#hugeit_submission_page #hugeit_top_controls .controls-list li');
            jQuery("input[name='check_comments']").each(function(){   // GETTING CHECKED SUBMITIONS
                if(jQuery(this).is(':checked')){
                    marked_submitions.push(jQuery(this).val()); 
                }
            });
            if(marked_submitions.length > 0){                         // IF EXIST SOME CHECKED SUBMITION
                if(command == "spam"){                                 // IF CLICKED IN SPAM IMAGE
                    var data = {
                                action: 'hugeit_contact_action',
                                task: 'moveTospamSubmitions',
                                spam_submitions: marked_submitions,
                                nonce:huge_it_obj.nonce
                        };
                     var forEach = Function.prototype.call.bind( Array.prototype.forEach );
                     forEach( marked_submitions, function( submition_id ) {
                     	function showRowActions(){
  				   			jQuery('#comment-'+submition_id+'').hover(function(){
  				                     	jQuery(this).find('.row-actions').css('display','table-row');
  				                     },function(){
  				                     	jQuery(this).find('.row-actions').css('display','table-row')
  				                     }); 
  				   			jQuery('#comment-'+submition_id+'').find('.row-actions').css('display','table-row');
  				   			jQuery('#comment-'+submition_id+'').find('#huge_it_spinner_'+submition_id+' img').fadeIn();
  				   		}
  				   		showRowActions();
                     })
                     jQuery.post(ajaxurl, data, function(response) {   //    alert(response);
                       if(response) {                                //    alert(reviews_for_delete);
                             var forEach = Function.prototype.call.bind( Array.prototype.forEach );
                             forEach( marked_submitions, function( submition_id ) {    //    alert( submition_id );
                                 jQuery("#comment-"+submition_id+" .row-actions .not_spam").css({"display" : ""});
                                 jQuery("#comment-"+submition_id+" .row-actions .spam").css({"display" : "none"});
                                 jQuery("#comment-"+submition_id+" .author p.spamer").css({"display" : ""});                                 
                                 jQuery('#comment-'+submition_id+'').find('#huge_it_spinner_'+submition_id+' img').fadeOut();
  			                     jQuery('#comment-'+submition_id+'').find('.row-actions').css('display','none');
  			                     jQuery('#comment-'+submition_id+'').hover(function(){
  			                     	jQuery(this).find('.row-actions').css('display','table-row');
  			                     },function(){
  			                     	jQuery(this).find('.row-actions').css('display','none')
  			                     }) 
                             });
                         }
                    });
                }
                else{
                    if(command == "trash"){                             // IF CLICKED IN TRASH IMAGE
                        jQuery( "#huge-it-contact-dialog-confirm" ).dialog({ // ALERTING ARE YOU SURE DIALOG
                            dialogClass:'dialog_style56',  
                            draggable: false,         
                            resizable: false,
                            height:150,
                            modal: true,
                            buttons: {
                              "Yes": function() {      // ID USER CLICKED YES I SURE
                                jQuery( this ).dialog( "close" );
                                var forEach = Function.prototype.call.bind( Array.prototype.forEach );
  			                     forEach( marked_submitions, function( submition_id ) {
  			                     	function showRowActions(){
  							   			jQuery('#comment-'+submition_id+'').hover(function(){
  							                     	jQuery(this).find('.row-actions').css('display','table-row');
  							                     },function(){
  							                     	jQuery(this).find('.row-actions').css('display','table-row')
  							                     }); 
  							   			jQuery('#comment-'+submition_id+'').find('.row-actions').css('display','table-row');
  							   			jQuery('#comment-'+submition_id+'').find('#huge_it_spinner_'+submition_id+' img').fadeIn();
  							   		}
  							   		showRowActions();
  			                     })
                                var data = {
                                    action: 'hugeit_contact_action',
                                    task: 'deleteSubmitions',
                                    submitions_for_delete: marked_submitions,
                                    nonce:huge_it_obj.nonce
                                };
                                jQuery.post(ajaxurl, data, function(response) {    //      alert(response);
                                    if(response) {
                                        var forEach = Function.prototype.call.bind( Array.prototype.forEach );
                                            forEach( marked_submitions, function( submition_id ) {
                                                jQuery('#comment-'+submition_id+'').fadeOut(function(){
  													 jQuery(this).animate({"left": "0","top":"0"});
  													 jQuery(this).empty();
  												});
                                            });
                                    }
                                });                                                       
                              },
                              Cancel: function() {
                                jQuery( this ).dialog( "close" );
                              }
                            }
                        });
                    }
                }                
            }            
            if(command == "refrash"){
            	e.preventDefault();
            	var marked_submitions_refresh = []; 
            	var countTorefresh=jQuery('#hugeit_submission_page input[name="countTorefresh"]').val();
            	var subID=jQuery('#hugeit_submission_page input[name="subID"]').val();
            	var marked_submitions_refresh= jQuery("#hugeit_submission_page").find("input[name='check_comments']").filter(':first').val();
            	jQuery.ajax({
  			   		type: "POST",
  			   		url:ajaxurl,
  			   		data:{
  			   			action: 'hugeit_contact_action',
  			            task: 'refreshSubmissions',
  			            subID: subID,
  			            countTorefresh:countTorefresh,
  			            marked_submitions:marked_submitions_refresh,
  			            nonce:huge_it_obj.nonce
  			   		},
  			   		beforeSend:function(){
  			   			self.parent().find('li img.control_list_spinner').fadeIn();
  			   		},
  			   		success: function(response){
  			   			var response = jQuery.parseJSON(response);
  			   			if(response.output){
  			   				jQuery('input[name=countTorefresh]').val(response.countTorefresh);
  			   				jQuery("#hugeit_submission_page table").find("tbody").prepend(response.output);
  			                self.parent().find('li img.control_list_spinner').fadeOut();
  			                setTimeout(function(){
  			                	jQuery("#hugeit_submission_page table").find("tbody").find(".prepended").removeClass("prepended");
  			                },1000);                     
  			            }else{
  		            		self.parent().find('li img.control_list_spinner').fadeOut(); 		            	
  			            }
  			   		}
  			   });
            }
        });
  //////////////Unmark As Spam Single////////////////////////
   jQuery('#hugeit_submission_page').on('click tap','.row-actions .not_spam a',function(){
   		var self=jQuery(this);
  		var submissionId=jQuery(this).parent().attr('value');
  		   jQuery.ajax({
  		   		type: "POST",
  		   		url:ajaxurl,
  		   		data:{
  		   			action: 'hugeit_contact_action',
  		            task: 'moveFromSpamSingleSubmition',
  		            submissionId: submissionId,
  		            nonce:huge_it_obj.nonce
  		   		},
  		   		beforeSend:function(){
  		   			jQuery('#comment-'+submissionId+'').hover(function(){
  		                     	self.parent().parent().css('display','table-row');
  		                     },function(){
  		                     	self.parent().parent().css('display','table-row')
  		                     }); 
  		   			self.parent().parent().css('display','table-row');
  		   			self.parent().parent().find('#huge_it_spinner_'+submissionId+' img').fadeIn();
  		   		},
  		   		success: function(response){
  		   			if(response) {
  		                     jQuery("#comment-"+submissionId+" .row-actions .not_spam").css({"display" : "none"});
  		                     jQuery("#comment-"+submissionId+" .row-actions .spam").css({"display" : ""});
  		                     jQuery("#comment-"+submissionId+" .author p.spamer").css({"display" : "none"}); 
  		                     self.parent().parent().find('#huge_it_spinner_'+submissionId+' img').fadeOut(); 
  		                     self.parent().parent().css('display','none'); 
  		                     jQuery('#comment-'+submissionId+'').hover(function(){
  		                     	self.parent().parent().css('display','table-row');
  		                     },function(){
  		                     	self.parent().parent().css('display','none')
  		                     });                   
  		             }
  		   		}
  		   }); 
   });   
  //////////////Mark As Spam Single////////////////////////
   jQuery('#hugeit_submission_page').on('click tap','.row-actions .spam a',function(){
  	   	var self=jQuery(this);
  		var submissionId=jQuery(this).parent().attr('value');
  		   jQuery.ajax({
  		   		type: "POST",
  		   		url:ajaxurl,
  		   		data:{
  		   			action: 'hugeit_contact_action',
  		            task: 'moveToSpamSingleSubmition',
  		            submissionId: submissionId,
  		            nonce:huge_it_obj.nonce
  		   		},
  		   		beforeSend:function(){
  		   			jQuery('#comment-'+submissionId+'').hover(function(){
  		                     	self.parent().parent().css('display','table-row');
  		                     },function(){
  		                     	self.parent().parent().css('display','table-row')
  		                     }); 
  		   			self.parent().parent().css('display','table-row');
  		   			self.parent().parent().find('#huge_it_spinner_'+submissionId+' img').fadeIn();
  		   		},
  		   		success: function(response){
  		   			if(response) {
  		                     jQuery("#comment-"+submissionId+" .row-actions .not_spam").css({"display" : ""});
  		                     jQuery("#comment-"+submissionId+" .row-actions .spam").css({"display" : "none"});
  		                     jQuery("#comment-"+submissionId+" .author p.spamer").css({"display" : ""}); 
  		                     self.parent().parent().find('#huge_it_spinner_'+submissionId+' img').fadeOut();
  		                     self.parent().parent().css('display','none');
  		                     jQuery('#comment-'+submissionId+'').hover(function(){
  		                     	self.parent().parent().css('display','table-row');
  		                     },function(){
  		                     	self.parent().parent().css('display','none')
  		                     })                    
  		             }
  		   		}
  		   })   		
   })
  ///////////////Mark As Spam From Message Page////////////////////////////////////////
   jQuery('#hugeit_single_submission_page #hugeit_top_controls li.spam a').click(function(){
  	   	var self=jQuery(this);
  		var submissionId=jQuery(this).parent().attr('value');
  		if(self.parent().hasClass('spamed')){
  			jQuery.ajax({
  		   		type: "POST",
  		   		url:ajaxurl,
  		   		data:{
  		   			action: 'hugeit_contact_action',
  		            task: 'moveFromSpamSingleSubmition',
  		            submissionId: submissionId,
  		            nonce:huge_it_obj.nonce
  		   		},
  		   		beforeSend:function(){
  		   			self.parent().parent().find('li .control_list_spinner').fadeIn();
  		   		},
  		   		success: function(response){
  		   			if(response) {
  		                    self.parent().removeClass('spamed'); 
  		                    self.parent().parent().find('li .control_list_spinner').fadeOut();                  
  		             }
  		   		}
  		   })
  		}else{
  			jQuery.ajax({
  		   		type: "POST",
  		   		url:ajaxurl,
  		   		data:{
  		   			action: 'hugeit_contact_action',
  		            task: 'moveToSpamSingleSubmition',
  		            submissionId: submissionId,
  		            nonce:huge_it_obj.nonce
  		   		},
  		   		beforeSend:function(){
  		   			self.parent().parent().find('li .control_list_spinner').fadeIn();
  		   		},
  		   		success: function(response){
  		   			if(response) {
  		                    self.parent().addClass('spamed'); 
  		                    self.parent().parent().find('li .control_list_spinner').fadeOut();                    
  		             }
  		   		}
  		   })
  		}
  		      		
   })
  /////////////Delete Single//////////////////////////
  jQuery('#hugeit_submission_page').on('click tap','.row-actions .trash a',function(){
  	var self=jQuery(this);
  	var submissionId=jQuery(this).parent().attr('value');
  		jQuery( "#huge-it-contact-dialog-confirm" ).dialog({ // ALERTING ARE YOU SURE DIALOG
            dialogClass:'dialog_style56',  
            draggable: false,         
            resizable: false,
            height:150,
            modal: true,
            buttons: {
              "Yes": function() {      // ID USER CLICKED YES I SURE
            jQuery( this ).dialog( "close" );
            jQuery.ajax({
  		   		type: "POST",
  		   		url:ajaxurl,
  		   		data:{
  		   			action: 'hugeit_contact_action',
  		            task: 'deleteSingleSubmition',
  		            submissionId: submissionId,
  		            nonce:huge_it_obj.nonce
  		   		},
  		   		beforeSend:function(){
  		   			self.parent().parent().css('display','table-row');
  		   			self.parent().parent().find('#huge_it_spinner_'+submissionId+' img').fadeIn();
  		   		},
  		   		success: function(response){
  		   			if(response) {		                      
  	                     jQuery('#comment-'+submissionId+'').fadeOut(function(){
  							 jQuery(this).animate({"left": "0","top":"0"});
  							 jQuery(this).empty();
  						});	
  		             }
  		   		}
  		   })                    
              },
              Cancel: function() {
                jQuery( this ).dialog( "close" );
              }
            }
        }); 
  })
  //////Search
  jQuery('#hugeit_submission_page > .search_block .button').click(function(e){
  	e.preventDefault();
  	var self=jQuery(this);
  	var subID=jQuery('#hugeit_submission_page input[name="subID"]').val();
  	var searchData=jQuery(this).parent().find('input[name=search_events_by_title]').val();
  	if(searchData==''){
  		return;
  	}else{
  		jQuery.ajax({
  		   		type: "POST",
  		   		url:ajaxurl,
  		   		data:{
  		   			action: 'hugeit_contact_action',
  		            task: 'searchSubmission',
  		            searchData: searchData,
  		            subID:subID,
  		            nonce:huge_it_obj.nonce
  		   		},
  		   		beforeSend:function(){
  		   			self.parent().parent().parent().find('.controls-list li .control_list_spinner').fadeIn();
  		   		},
  		   		success: function(response){
  		   			var response = jQuery.parseJSON(response);
  		   			if(response.output) {
  		   				jQuery("#hugeit_submission_page table").find("tbody").html(response.output);
  	              		self.parent().parent().parent().find('.controls-list li .control_list_spinner').fadeOut();
  	              		self.parent().parent().parent().find('.page-navigation').css('display','none'); 
  		             }else{		             	
  		             	self.parent().parent().parent().find('.controls-list li .control_list_spinner').fadeOut();
  		             	self.parent().find('input[name=search_events_by_title]').val('')
  		             	self.parent().find('input[name=search_events_by_title]').attr('placeholder','No results found...') 
  		             }
  		   		}
  		   })
  	}
  })
  /*******////////BULK ACTIONS////////*********/
  jQuery('#hugeit_submission_page #hugeit_top_controls .controls-list li a.apply').click(function(e){
  	e.preventDefault();
  	var _this=jQuery(this);
  	var marked_submitions = [];
  	var selectVal=_this.parent().parent().find('.select_actions select').val();
  	jQuery("input[name='check_comments']").each(function(){   // GETTING CHECKED SUBMITIONS
        if(jQuery(this).is(':checked')){
            marked_submitions.push(jQuery(this).val()); 
        }
    });
  	if(selectVal=='none'){
  		return false;
  	}else if(selectVal=='read'){
  		if(marked_submitions.length > 0){
  			var data = {
  	                    action: 'hugeit_contact_action',
  	                    task: 'markAsRead',
  	                    read_submitions: marked_submitions,
  	                    nonce:huge_it_obj.nonce
  	            };
            jQuery('#hugeit_top_controls .controls-list li img.control_list_spinner').fadeIn();
  	         var forEach = Function.prototype.call.bind( Array.prototype.forEach );
  	         forEach( marked_submitions, function( submition_id ) {
  	         	function showRowActions(){
  		   			jQuery('#comment-'+submition_id+'').hover(function(){
  		                     	jQuery(this).find('.row-actions').css('display','table-row');
  		                     },function(){
  		                     	jQuery(this).find('.row-actions').css('display','none')
  		                     }); 
  		   			jQuery('#comment-'+submition_id+'').find('.row-actions').css('display','table-row');
  		   			jQuery('#comment-'+submition_id+'').find('#huge_it_spinner_'+submition_id+' img').fadeIn();
  		   		}
  		   		showRowActions();
  	         })
  	         jQuery.post(ajaxurl, data, function(response) {   //    alert(response);
  	           if(response) {                                //    alert(reviews_for_delete);
  	                 var forEach = Function.prototype.call.bind( Array.prototype.forEach );
  	                 forEach( marked_submitions, function( submition_id ) {    //    alert( submition_id );
  	                     jQuery("#comment-"+submition_id).removeClass('unread');
  	                     jQuery("#comment-"+submition_id).addClass('read');                                 
  	                     jQuery('#comment-'+submition_id+'').find('#huge_it_spinner_'+submition_id+' img').fadeOut();
  	                     jQuery('#comment-'+submition_id+'').find('.row-actions').css('display','none');
  	                     jQuery('#comment-'+submition_id+'').hover(function(){
  	                     	jQuery(this).find('.row-actions').css('display','table-row');
  	                     },function(){
  	                     	jQuery(this).find('.row-actions').css('display','none')
  	                     }) 
  	                 });
  	                 jQuery('#hugeit_top_controls .controls-list li img.control_list_spinner').fadeOut();
  	             }
  	        });
  		}
  	}else if(selectVal=='unread'){
  		if(marked_submitions.length > 0){
  			var data = {
  	                    action: 'hugeit_contact_action',
  	                    task: 'markAsUnread',
  	                    unread_submitions: marked_submitions,
  	                    nonce:huge_it_obj.nonce
  	            };
            jQuery('#hugeit_top_controls .controls-list li img.control_list_spinner').fadeIn();
  	         var forEach = Function.prototype.call.bind( Array.prototype.forEach );
  	         forEach( marked_submitions, function( submition_id ) {
  	         	function showRowActions(){
  		   			jQuery('#comment-'+submition_id+'').hover(function(){
  		                     	jQuery(this).find('.row-actions').css('display','table-row');
  		                     },function(){
  		                     	jQuery(this).find('.row-actions').css('display','none')
  		                     }); 
  		   			jQuery('#comment-'+submition_id+'').find('.row-actions').css('display','table-row');
  		   			jQuery('#comment-'+submition_id+'').find('#huge_it_spinner_'+submition_id+' img').fadeIn();
  		   		}
  		   		showRowActions();
  	         })
  	         jQuery.post(ajaxurl, data, function(response) {   //    alert(response);
  	           if(response) {                                //    alert(reviews_for_delete);
  	                 var forEach = Function.prototype.call.bind( Array.prototype.forEach );
  	                 forEach( marked_submitions, function( submition_id ) {    //    alert( submition_id );
                 		 jQuery("#comment-"+submition_id).removeClass('read');
  	                     jQuery("#comment-"+submition_id).addClass('unread');
  	                                                      
  	                     jQuery('#comment-'+submition_id+'').find('#huge_it_spinner_'+submition_id+' img').fadeOut();
  	                     jQuery('#comment-'+submition_id+'').find('.row-actions').css('display','none');
  	                     jQuery('#comment-'+submition_id+'').hover(function(){
  	                     	jQuery(this).find('.row-actions').css('display','table-row');
  	                     },function(){
  	                     	jQuery(this).find('.row-actions').css('display','none')
  	                     }) 
  	                 });
  	                 jQuery('#hugeit_top_controls .controls-list li img.control_list_spinner').fadeOut();
  	             }
  	        });
  		}
  	}else if(selectVal=='spam'){
  		if(marked_submitions.length > 0){
  			var data = {
  	                    action: 'hugeit_contact_action',
  	                    task: 'moveTospamSubmitions',
  	                    spam_submitions: marked_submitions,
  	                    nonce:huge_it_obj.nonce
  	            };
            jQuery('#hugeit_top_controls .controls-list li img.control_list_spinner').fadeIn();
  	         var forEach = Function.prototype.call.bind( Array.prototype.forEach );
  	         forEach( marked_submitions, function( submition_id ) {
  	         	function showRowActions(){
  		   			jQuery('#comment-'+submition_id+'').hover(function(){
  		                     	jQuery(this).find('.row-actions').css('display','table-row');
  		                     },function(){
  		                     	jQuery(this).find('.row-actions').css('display','none')
  		                     }); 
  		   			jQuery('#comment-'+submition_id+'').find('.row-actions').css('display','table-row');
  		   			jQuery('#comment-'+submition_id+'').find('#huge_it_spinner_'+submition_id+' img').fadeIn();
  		   		}
  		   		showRowActions();
  	         })
  	         jQuery.post(ajaxurl, data, function(response) {   //    alert(response);
  	           if(response) {                                //    alert(reviews_for_delete);
  	                 var forEach = Function.prototype.call.bind( Array.prototype.forEach );
  	                 forEach( marked_submitions, function( submition_id ) {    //    alert( submition_id );
  	                     jQuery("#comment-"+submition_id+" .row-actions .not_spam").css({"display" : ""});
  	                     jQuery("#comment-"+submition_id+" .row-actions .spam").css({"display" : "none"});
  	                     jQuery("#comment-"+submition_id+" .author p.spamer").css({"display" : ""});                                 
  	                     jQuery('#comment-'+submition_id+'').find('#huge_it_spinner_'+submition_id+' img').fadeOut();
  	                     jQuery('#comment-'+submition_id+'').find('.row-actions').css('display','none');
  	                     jQuery('#comment-'+submition_id+'').hover(function(){
  	                     	jQuery(this).find('.row-actions').css('display','table-row');
  	                     },function(){
  	                     	jQuery(this).find('.row-actions').css('display','none')
  	                     }) 
  	                 });
  	                 jQuery('#hugeit_top_controls .controls-list li img.control_list_spinner').fadeOut();
  	             }
  	        });
  		}
  	}else if(selectVal=='unspam'){
  		if(marked_submitions.length > 0){
  			var data = {
  	                    action: 'hugeit_contact_action',
  	                    task: 'moveFromspamSubmitions',
  	                    spam_submitions: marked_submitions,
  	                    nonce:huge_it_obj.nonce
  	            };
            jQuery('#hugeit_top_controls .controls-list li img.control_list_spinner').fadeIn();
  	         var forEach = Function.prototype.call.bind( Array.prototype.forEach );
  	         forEach( marked_submitions, function( submition_id ) {
  	         	function showRowActions(){
  		   			jQuery('#comment-'+submition_id+'').hover(function(){
  		                     	jQuery(this).find('.row-actions').css('display','table-row');
  		                     },function(){
  		                     	jQuery(this).find('.row-actions').css('display','none')
  		                     }); 
  		   			jQuery('#comment-'+submition_id+'').find('.row-actions').css('display','table-row');
  		   			jQuery('#comment-'+submition_id+'').find('#huge_it_spinner_'+submition_id+' img').fadeIn();
  		   		}
  		   		showRowActions();
  	         })
  	         jQuery.post(ajaxurl, data, function(response) {   //    alert(response);
  	           if(response) {                                //    alert(reviews_for_delete);
  	                 var forEach = Function.prototype.call.bind( Array.prototype.forEach );
  	                 forEach( marked_submitions, function( submition_id ) {    //    alert( submition_id );
  	                     jQuery("#comment-"+submition_id+" .row-actions .not_spam").css({"display" : "none"});
  	                     jQuery("#comment-"+submition_id+" .row-actions .spam").css({"display" : ""});
  	                     jQuery("#comment-"+submition_id+" .author p.spamer").css({"display" : "none"});                                 
  	                     jQuery('#comment-'+submition_id+'').find('#huge_it_spinner_'+submition_id+' img').fadeOut();
  	                     jQuery('#comment-'+submition_id+'').find('.row-actions').css('display','none');
  	                     jQuery('#comment-'+submition_id+'').hover(function(){
  	                     	jQuery(this).find('.row-actions').css('display','table-row');
  	                     },function(){
  	                     	jQuery(this).find('.row-actions').css('display','none')
  	                     }) 
  	                 });
                 jQuery('#hugeit_top_controls .controls-list li img.control_list_spinner').fadeOut();
  	             }
  	        });
  		}
  	}
  	
  })
  			/*******////////BULK ACTIONS////////*********/
  /*******//////////////////Submission Scripts END////////////////*********/
  	var form_clean;
  	// serialize clean form
  	jQuery(function() { 
  	    form_clean = jQuery("form").serialize(); 
  	});
  	jQuery('#save-button-block').on('click','input#save-buttom',function(){
  		form_clean = jQuery("form").serialize();
  		form_clean=form_clean.replace(/g-recaptcha-response=([^]*?)&/g, '');
  	})
  	function getParameterByName(name) {
  	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
  	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
  	}
  	var pageCheck=getParameterByName('page');
  	// compare clean and dirty form before leaving
  	if(pageCheck != 'hugeit_forms_theme_options' && pageCheck != 'hugeit_forms_general_options'){
  		window.onbeforeunload = function (e) {
  			var form_dirty = jQuery("form").serialize();
  			form_dirty=form_dirty.replace(/g-recaptcha-response=([^]*?)&/g, '');
  		    if(form_clean != form_dirty) {
  		        return 'There is unsaved form data.';
  		    }else{
  		    	window.onbeforeunload = null;
  		    }
  		}		
  	}		
  	jQuery(window).scroll(function(){
  	      if (jQuery(this).scrollTop() > 114) {
  	          jQuery('.fields-list > li.open').addClass('fixedStyles');
  	      }else{
  	          jQuery('.fields-list > li.open').removeClass('fixedStyles');
  	      }
  	});
  	jQuery("#shortcode_toggle").toggle(function(){
        jQuery('#post-body-heading').stop().animate({height:145},500,function(){
        	jQuery('#post-body-heading #shortcode_fields').fadeIn()
        });
    },function(){
    	jQuery('#post-body-heading #shortcode_fields').fadeOut()
        jQuery('#post-body-heading').stop().animate({height:40},500,function(){
        	
        });
    });
  	
  	jQuery('.icons-block input[type="radio"]').change(function(){
  		jQuery(this).parents('ul').find('li.active').removeClass('active');
  		jQuery(this).parents('li').addClass('active');
  	});
  	
  	jQuery('input[data-slider="true"]').bind("slider:changed", function (event, data) {
  		 jQuery(this).parent().find('span').html(parseInt(data.value)+"%");
  		 jQuery(this).val(parseInt(data.value));
  	});	
  		
  	jQuery('#form_background').change(function(){
  		if(jQuery(this).val()=='gradient'){
  			jQuery('.form_first_background_color').addClass('half');
  			jQuery('.form_second_background_color').addClass('half ');
  			jQuery('.form_second_background_color').removeClass('none');
  		}else{
  			jQuery('.form_first_background_color').removeClass('half');
  			jQuery('.form_second_background_color').addClass('none');
  		}
  	});
  	
  	jQuery('#add-fields-block ').on('click','li > ul  li.disabled',function(){return false;})
  	
  	
  	jQuery('.fields-list ').on('click tap','li > div .open-close',function(){
  		var fieldWidth=jQuery('#fields-list-block').width();
  		fieldWidth=fieldWidth-20;
  		if(jQuery(this).parent().parent().parent().hasClass('open')){
  			jQuery('.fields-list li').removeClass('open');
  			jQuery('.fields-list>li').each(function(){				
  					jQuery(this).css('display','block')				
  			});
  			jQuery(this).parent().parent().parent().removeClass('fixedStyles');			
  		}else {
  			jQuery('.fields-list>li').each(function(){				
  					jQuery(this).css('display','block')				
  			})
  			jQuery('.fields-list li').removeClass('open');
  			jQuery(this).parent().parent().parent().addClass('open');
  			jQuery('.fields-list > li.open').css({'width':fieldWidth});
  			jQuery('.fields-list>li').each(function(){
  				if(!jQuery(this).hasClass('open')){
  					jQuery(this).css('display','none')
  				}
  			});
  			if(jQuery(window).scrollTop() > 114){
  				jQuery(this).parent().parent().parent().addClass('fixedStyles');
  			}
  		}
  		return false;
  	});
  	jQuery(window).resize(function(){
  		jQuery('.fields-list>li').each(function(){
  			var fieldWidth=jQuery('#fields-list-block').width();
  			fieldWidth=fieldWidth-20;
  				jQuery(this).css('width',fieldWidth)
  			
  		});
  	});
  	
  		
  		
  	/*################MULTIPLE OPTIONS##################*/	
  	/*####Set Active Option###*/
  	jQuery("#fields-list-block").on('click','.fields-list .field-multiple-option-list li .set-active input',function(){
  		var index=jQuery(this).parent().parent().index();
  		var fieldID=jQuery(this).parents(".field-multiple-option-list").attr('rel');
  		if(jQuery(this).parents('.field-multiple-option-list').hasClass('checkbox')){
  			if(jQuery(this).parent().hasClass('checked')){
  				jQuery(this).parent().removeClass('checked');
  				jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-'+fieldID+'"] ul').find('li').eq(index).find('input[type="checkbox"]').removeAttr('checked');
  			}else {
  				jQuery(this).parent().addClass("checked");
  				var previewcheckbox=jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-'+fieldID+'"] ul').find('li').eq(index).find('input[type="checkbox"]');
  				previewcheckbox.attr('checked','checked');
  			}
  			
  			var allchecks='';
  			jQuery(this).parents(".field-multiple-option-list").find('.set-active.checked input[type="radio"]').each(function(){
  				allchecks+=jQuery(this).val()+";;";
  			});
  			allchecks=allchecks.slice(0,-2);
  			jQuery(this).parents(".field-multiple-option-list").find('.field-multiple-option-active-field').val(allchecks);
  		}
  		else if(jQuery(this).parents('.field-multiple-option-list').hasClass('selectbox')){
  			var allowChange=1;
  			var selectVal=jQuery(this).parents('.fields-options').find('select').val();
  			if(selectVal=='formsInsideAlign'){
  				allowChange=0;
  			}
  			// jQuery(this).parents('.field-multiple-option-list').find('li').each(function(){
  			// 	if(jQuery(this).attr('id')=='defaultSelect'){allowChange=0}
  			// });
  			if(allowChange!=0){
  				jQuery(this).parents(".field-multiple-option-list").find(".set-active.checked").removeClass('checked');
  				jQuery(this).parent().addClass("checked");
  				
  				jQuery(this).parents(".field-multiple-option-list").find('.field-multiple-option-active-field').val(index);
  						
  				jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-'+fieldID+'"] select').find('option').removeAttr('selected');
  				var previewselect=jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-'+fieldID+'"] select').find('option').eq(index);
  				previewselect.attr('selected','selected');
  				jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-'+fieldID+'"] .textholder').val(previewselect.val());
  			}
  		}
  		else {
  			jQuery(this).parents(".field-multiple-option-list").find(".set-active.checked").removeClass('checked');
  			jQuery(this).parent().addClass("checked");
  			
  			jQuery(this).parents(".field-multiple-option-list").find('.field-multiple-option-active-field').val(index);			
  		
  			
  			jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-'+fieldID+'"] ul').find('li input[type="radio"]').removeAttr('checked');
  			var previewradio=jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-'+fieldID+'"] ul').find('li').eq(index).find('input[type="radio"]');
  			previewradio.attr('checked','checked');		
  		}				
  	});
  	
  	
  	/*####Change Existing Option###*/
  	jQuery("#fields-list-block").on('keypress keyup change','.fields-list .field-multiple-option-list li input:text',function(){
  		if(!jQuery(this).hasClass('add-new-name')){
  			var index=jQuery(this).parent().index();
  			var fieldID=jQuery(this).parents(".field-multiple-option-list").attr('rel');
  			var valToChange=jQuery(this).val();
  		
  			if(jQuery(this).parents('.field-multiple-option-list').hasClass('selectbox')){
  				jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-'+fieldID+'"] select').find('option').eq(index).html(jQuery(this).val());
  				if(index==jQuery(this).parents(".field-multiple-option-list").find('.field-multiple-option-active-field').val()){
  					jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-'+fieldID+'"] .textholder').val(valToChange);
  					//alert(1)
  				}
  			}else{			
  				jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-'+fieldID+'"] ul').find('li').eq(index).find('.sublable').html(jQuery(this).val());
  			}
  			var allvalues='';
  			jQuery(this).parents(".field-multiple-option-list").find('.field-multiple-option').each(function(){
  				allvalues+=jQuery(this).val()+";;";
  			});
  			allvalues=allvalues.slice(0,-2);
  			jQuery(this).parents(".field-multiple-option-list").find('.field-multiple-option-all-values').val(allvalues);
  		}
  	});
  	
  	/*####ADD NEW OPTION###*/
  	jQuery("#fields-list-block").on('click','.fields-list .field-multiple-option-list li .add-new',function(){ 
  		var fieldID=jQuery(this).parents(".field-multiple-option-list").attr('rel');
  						
  		var value=jQuery(this).parent().find('.add-new-name').val();
  		
  		
  		
  		if(jQuery(this).parents(".field-multiple-option-list").hasClass('selectbox')){	
  			if(value==""){return false;}
  			var previewselect=jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-'+fieldID+'"] select');
  			previewselect.append('<option>'+value+'</options>');
  		}
  		else {
  			var width=100/parseInt(jQuery(this).parents('.fields-options').find('.field-columns-count').val())+"%";
  			/*var isactive='disabled="disabled"'
  			if(jQuery(this).parents('.fields-options').find('.fieldisactive').is(':checked')){
  				isactive='';
  			}

  			alert(isactive);*/
			var previewradio = jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-' + fieldID + '"]').find('.field-block input').last();
			var radiocont = previewradio.parent().html().replace('checked="checked"', '');
			var inputclass = "";
			if (previewradio.is(':checkbox')) {
				inputclass = "checkbox-block";
				previewradio.parent().parent().parent().after('<li style="width:' + width + ';"><label class="secondary-label"><div class="' + inputclass + '">' + radiocont + '</div><span class="sublable">' + value + '</span></label></li>');
			}
			else {
				inputclass = "radio-block big";
				previewradio.parent().parent().parent().after('<li style="width:' + width + ';"><label class="secondary-label"><div class="' + inputclass + '">' + radiocont + '</div><span class="sublable">' + value + '</span></label></li>');
			}
			//previewradio.parent().parent().parent().after('<li style="width:'+width+';"><label class="secondary-label"><div class="'+inputclass+'">'+radiocont+'</div>'+value+'</label></li>');
		}


		jQuery(this).parent().before('<li><input class="field-multiple-option" type="text" name="fieldoption' + fieldID + '" value="' + value + '" /><div class="set-active"><input type="radio" name="options_active_' + fieldID + '" value="' + value + '" /></div><a href="#remove" class="remove-field-option">remove</a></li>');
		var allvalues = '';
		jQuery(this).parents(".field-multiple-option-list").find('.field-multiple-option').each(function() {
			allvalues += jQuery(this).val() + ";;";
		});
		allvalues = allvalues.slice(0, -2);
		jQuery(this).parents(".field-multiple-option-list").find('.field-multiple-option-all-values').val(allvalues);
		jQuery(this).parent().find('.add-new-name').val('');
		return false;
	});


	/*####Remove Option###*/
	jQuery("#fields-list-block").on('click', '.fields-list .field-multiple-option-list li .remove-field-option', function() {
		var elemCount = jQuery(this).parent().parent().contents().filter(function() {
			return this.nodeName === 'LI';
		}).length;
		if (elemCount != 2) {
			jQuery(this).parent().find('.field-multiple-option').addClass('removeing');
			var allvalues = '';
			jQuery(this).parents(".field-multiple-option-list").find('.field-multiple-option').not('.removeing').each(function() {
				allvalues += jQuery(this).val() + ";;";
			});

			var fieldID = jQuery(this).parents(".field-multiple-option-list").attr('rel');
			var index = jQuery(this).parent().index();

			var firstval = jQuery(this).parents('.field-multiple-option-list').find('li').eq(0).find('.field-multiple-option').val();
			var secondval = jQuery(this).parents('.field-multiple-option-list').find('li').eq(1).find('.field-multiple-option').val();

			if (jQuery(this).parents('.field-multiple-option-list').hasClass('selectbox')) {
				var allowChange = 1;
				var selectVal = jQuery(this).parents('.fields-options').find('select').val();
				if (selectVal == 'formsInsideAlign') {
					allowChange = 0;
				}
				// jQuery(this).parents('.field-multiple-option-list').find('li').each(function(){
				// 	if(jQuery(this).attr('id')=='defaultSelect'){allowChange=0}
				// });
				if (allowChange != 0) {
					if (index == jQuery(this).parents(".field-multiple-option-list").find('.field-multiple-option-active-field').val()) {
						jQuery(this).parents(".field-multiple-option-list").find('.field-multiple-option-active-field').val('0');
					}
					if (jQuery(this).parent().index() == 0) {
						jQuery(this).parents('.field-multiple-option-list').find('li').eq(1).find('.set-active').addClass('checked');
						jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-' + fieldID + '"] .textholder').val(secondval);
					} else {
						jQuery(this).parents('.field-multiple-option-list').find('li').eq(0).find('.set-active').addClass('checked');
						jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-' + fieldID + '"] .textholder').val(firstval);
					}
					jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-' + fieldID + '"] select').find('option').eq(index).remove();
				}
			} else if (jQuery(this).parents('.field-multiple-option-list').hasClass('radio')) {
				if (index == jQuery(this).parents(".field-multiple-option-list").find('.field-multiple-option-active-field').val()) {
					jQuery(this).parents(".field-multiple-option-list").find('.field-multiple-option-active-field').val('0');
					jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-' + fieldID + '"] .textholder').val(firstval);
				}
				if (jQuery(this).parent().index() == 0) {
					jQuery(this).parents('.field-multiple-option-list').find('li').eq(1).find('.set-active').addClass('checked');
					var previewradio = jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-' + fieldID + '"] ul').find('li').eq(1).find('input[type="radio"]');
					previewradio.attr('checked', 'checked');
				} else {
					jQuery(this).parents('.field-multiple-option-list').find('li').eq(0).find('.set-active').addClass('checked');
					var previewradio = jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-' + fieldID + '"] ul').find('li').eq(0).find('input[type="radio"]');
					previewradio.attr('checked', 'checked');
				}
				jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-' + fieldID + '"] ul').find('li').eq(index).remove();
			} else {
				jQuery('.hugeit-contact-column-block > div[rel="huge-contact-field-' + fieldID + '"] ul').find('li').eq(index).remove();
			}
			allvalues = allvalues.slice(0, -2);
			jQuery(this).parents(".field-multiple-option-list").find('.field-multiple-option-all-values').val(allvalues);
			jQuery(this).parent().addClass("checked");
			var allowChange = 1;
			var selectVal = jQuery(this).parents('.fields-options').find('select').val();
			if (selectVal == 'formsInsideAlign') {
				allowChange = 0;
			}
			if (allowChange != 0) {
				jQuery(this).parent().remove();
			}
			return false;
		}
	});


	jQuery("#fields-list-block").on('change keyup', '.fields-list .fields-options .field-columns-count', function() {
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		var liwidth = 100 / parseInt(jQuery(this).val());
		jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] ul li').css({'width': liwidth + '%'});
	});


	/*##########ONCHANGE############*/
	jQuery('.hugeit_contact_top_tabs>li').on('keyup', 'input.text_area', function() {
		var titleVal = jQuery(this).val();
		jQuery('.text_area_title').val(titleVal);
	});
	jQuery('.text_area_title').on('keyup', function() {
		var titleVal = jQuery(this).val();
		jQuery('.hugeit_contact_top_tabs input.text_area').val(titleVal);
	});
	jQuery('.hugeItTitleOverlay').click(function() {
		jQuery('.text_area_title').focus();
	});

	jQuery('#fields-list-block > ul').on({
		mouseenter: function() {
			var fieldid = jQuery(this).attr('id');
			jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"]').addClass('hover-active');
			jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"]').find('span.hugeOverlay').css('display', 'block');
		},
		mouseleave: function() {
			var fieldid = jQuery(this).attr('id');
			jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"]').removeClass('hover-active');
			jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"]').find('span.hugeOverlay').css('display', 'none');
		}
	}, "li");
	jQuery('#hugeit-contact-wrapper .hugeit-contact-column-block').on({
		mouseenter: function() {
			var fieldid = jQuery(this).attr('rel');
			jQuery(this).find('span.hugeOverlay').css('display', 'block')
			jQuery('#fields-list-block > ul > li[id="' + fieldid + '"]').addClass('border-active');
		},
		mouseleave: function() {
			var fieldid = jQuery(this).attr('rel');
			jQuery('#fields-list-block > ul > li[id="' + fieldid + '"]').removeClass('border-active');
			jQuery(this).find('span.hugeOverlay').css('display', 'none')
		}
	}, "div.hugeit-field-block");

	jQuery('#fields-list-block').on('keyup change', 'input.label', function() {
		if (jQuery(this).parents('.fields-options').find('select#form_label_position').val() == 'formsInsideAlign') {
			var toChange = jQuery(this).parents('.fields-options').find('input.label').val();
			jQuery(this).parents('.fields-options').find('input.placeholder').attr('value', toChange);
			jQuery(this).parents('.fields-options').find('li#defaultSelect>input').attr('value', toChange);
			var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
			var previewfield = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block input');
			var previewfieldtextarea = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block textarea');
			previewfield.attr("placeholder", toChange);
			previewfield.attr("value", toChange);
			previewfieldtextarea.attr("placeholder", toChange);
			var allvalues = '';
			jQuery(this).parents(".fields-options").find('.field-multiple-option-list .field-multiple-option').each(function() {
				allvalues += jQuery(this).val() + ";;";
			});
			allvalues = allvalues.slice(0, -2);
			jQuery(this).parents(".fields-options").find('.field-multiple-option-list .field-multiple-option-all-values').val(allvalues);
		}
		var value = jQuery(this).val();
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		if (value != '') {
			jQuery(this).parents('.fields-options').parent().find('h4').html(value);
		} else {
			var defLabel = jQuery(this).parents('.fields-options').parent().find('input.left-right-position').attr('fileType');
			jQuery(this).parents('.fields-options').parent().find('h4').html(defLabel);
		}
		var previewfield = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] label').not('.secondary-label');
		var addstar = "";
		if (previewfield.find('.required-star').length > 0) {
			addstar = '<em class="required-star">*</em>';
		}
		previewfield.html(value + addstar);
	});
	jQuery('#fields-list-block').on('keyup change', 'li#defaultSelect>input', function() {
		var toChange = jQuery(this).val();
		jQuery(this).parents('.fields-options').find('input.label').attr('value', toChange);
		jQuery(this).parents('.fields-options').parent().find('h4').html(toChange);
	});

	jQuery('#fields-list-block').on('keypress keyup change', '.required', function() {
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		var previewfield = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] label').not('.secondary-label');
		if (jQuery(this).is(':checked')) {
			previewfield.append('<em class="required-star">*</em>');
		} else {
			previewfield.find('.required-star').remove();
		}
	});
	jQuery('#fields-list-block').on('keypress keyup change', 'select#form_label_position', function() {
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		var currentClass = jQuery(this).val();
		var previewfield = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] label');
		var previewfield2 = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] div.field-block');
		if (currentClass == 'formsAboveAlign' || currentClass == 'formsInsideAlign') {
			if (currentClass == 'formsInsideAlign') {
				var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
				var checkSelect = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] > div');
				var label = jQuery(this).parents('.fields-options').find('input.label').val();
				if (checkSelect.hasClass('selectbox-block')) {
					jQuery(this).parents(".fields-options").find('.field-multiple-option-list li').each(function() {
						if (jQuery(this).find('div.set-active').hasClass('checked')) {
							jQuery(this).find('div.set-active').removeClass('checked');
						}
					});
					var previewselect2 = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"]').find('select');
					previewselect2.prepend('<option class="selectDefault" disabled>' + label + '</options>');
					jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] select').find('option').each(function() {
						if (jQuery(this).attr('selected') == 'selected') {
							jQuery(this).removeAttr('selected');
						}

					})

					jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] select').find('option').each(function() {
						if (jQuery(this).hasClass('selectDefault')) {
							var secondval = jQuery(this).parents('.fields-options').find('.field-multiple-option-list li').eq(0).find('.field-multiple-option').val();
							jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .textholder').val(label);
							jQuery(this).attr('selected', 'selected');
						}
					})
					jQuery(this).parents('.fields-options').find('ul.selectbox').prepend('<li id="defaultSelect"><input class="field-multiple-option" type="text" name="fieldoption' + fieldid + '" value="' + label + '" /><div class="set-active checked"><input type="radio" name="options_active_' + fieldid + '" value="' + label + '" /></div><a href="#remove" class="remove-field-option">remove</a></li>');
					jQuery(this).parents('.fields-options').find('ul.selectbox').find('input.field-multiple-option-active-field').attr('value', '0');
					var allvalues = '';
					jQuery(this).parents(".fields-options").find('.field-multiple-option-list .field-multiple-option').each(function() {
						allvalues += jQuery(this).val() + ";;";
					});
					allvalues = allvalues.slice(0, -2);
					jQuery(this).parents(".fields-options").find('.field-multiple-option-list .field-multiple-option-all-values').val(allvalues);
					previewfield.addClass(currentClass);
					previewfield2.addClass(currentClass);
					return false;
				} else {
					jQuery(this).parents('.fields-options').find('input.placeholder').attr('value', label);
					var toChangepreviewfield = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block input');
					var toChangepreviewfieldtextarea = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block textarea');
					toChangepreviewfield.attr("placeholder", label);
					toChangepreviewfieldtextarea.attr("placeholder", label);
				}
			} else {
				var checkSelect = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] > div');
				var previewselect2 = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"]').find('select option');
				previewselect2.each(function() {
					if (jQuery(this).hasClass('selectDefault')) {
						var previewselect2 = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"]').find('select');
						previewselect2.find('option.selectDefault').remove();

					}
				});
				jQuery(this).parents('.fields-options').find('ul.selectbox li#defaultSelect').remove();
				var secondval = jQuery(this).parents('.fields-options').find('.field-multiple-option-list li').eq(0).find('.field-multiple-option').val();
				jQuery(this).parents('.fields-options').find('.field-multiple-option-list li').eq(0).find('.set-active').addClass('checked');
				jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .textholder').val(secondval);
				var oldvalue = jQuery(this).parents('.fields-options').find('input.placeholder').attr('oldvalue');
				jQuery(this).parents('.fields-options').find('input.placeholder').attr('value', oldvalue);
				var toChangepreviewfieldFile = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] input.textholder');
				toChangepreviewfieldFile.attr('placeholder', '')
				var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
				var toChangepreviewfield = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block input');
				var toChangepreviewfieldArea = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block textarea');
				toChangepreviewfield.attr('placeholder', oldvalue);
				toChangepreviewfieldArea.attr('placeholder', oldvalue);
				var allvalues = '';
				jQuery(this).parents(".fields-options").find('.field-multiple-option-list .field-multiple-option').each(function() {
					allvalues += jQuery(this).val() + ";;";
				});
				allvalues = allvalues.slice(0, -2);
				jQuery(this).parents(".fields-options").find('.field-multiple-option-list .field-multiple-option-all-values').val(allvalues);
			}
			if (previewfield2.hasClass('formsAboveAlign')) {
				previewfield2.removeClass('formsAboveAlign')
			}
			if (previewfield2.hasClass('formsInsideAlign')) {
				previewfield2.removeClass('formsInsideAlign')
			}
			previewfield.addClass(currentClass);
			previewfield2.addClass(currentClass);
		} else {
			var previewselect2 = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"]').find('select');
			previewselect2.find('option.selectDefault').remove();
			jQuery(this).parents('.fields-options').find('ul.selectbox li#defaultSelect').remove();
			var secondval = jQuery(this).parents('.fields-options').find('.field-multiple-option-list li').eq(0).find('.field-multiple-option').val();
			jQuery(this).parents('.fields-options').find('.field-multiple-option-list li').eq(0).find('.set-active').addClass('checked');
			jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .textholder').val(secondval);
			var oldvalue = jQuery(this).parents('.fields-options').find('input.placeholder').attr('oldvalue');
			jQuery(this).parents('.fields-options').find('input.placeholder').attr('value', oldvalue);
			var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
			var toChangepreviewfield = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block input');
			var toChangepreviewfieldFile = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] input.textholder');
			toChangepreviewfieldFile.attr('placeholder', '')
			toChangepreviewfield.attr('placeholder', oldvalue);
			if (previewfield2.hasClass('formsAboveAlign')) {
				previewfield2.removeClass('formsAboveAlign')
			}
			if (previewfield2.hasClass('formsInsideAlign')) {
				previewfield2.removeClass('formsInsideAlign')
			}
			var allvalues = '';
			jQuery(this).parents(".fields-options").find('.field-multiple-option-list .field-multiple-option').each(function() {
				allvalues += jQuery(this).val() + ";;";
			});
			allvalues = allvalues.slice(0, -2);
			jQuery(this).parents(".fields-options").find('.field-multiple-option-list .field-multiple-option-all-values').val(allvalues);
		}
		previewfield.removeClass();
		previewfield.addClass(currentClass);
	});

	jQuery('#fields-list-block').on('keypress keyup change', '.fieldisactive', function() {
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		var previewfieldtextarea = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] textarea');
		var previewfield = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block input');
		if (jQuery(this).is(':checked')) {
			previewfield.removeAttr("disabled");
			previewfieldtextarea.removeAttr("disabled");
		} else {
			previewfield.attr("disabled", "disabled");
			previewfieldtextarea.attr("disabled", "disabled");
		}
	});

	jQuery('#fields-list-block').on('keypress keyup change', '.placeholder', function() {
		if (jQuery(this).parents('.fields-options').find('select#form_label_position').val() == 'formsInsideAlign') {
			var toChange = jQuery(this).parents('.fields-options').find('input.placeholder').val();
			jQuery(this).parents('.fields-options').find('input.label').attr('value', toChange);
			var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
			var previewfield = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] label').not('.secondary-label');
			jQuery(this).parents('.fields-options').parent().find('h4').html(toChange);
			previewfield.html(toChange);
		}
		var value = jQuery(this).val();
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		var previewfield = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block input');
		var previewfieldtextarea = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block textarea');
		previewfield.attr("placeholder", value);
		previewfieldtextarea.attr("placeholder", value);
	});


	jQuery('#fields-list-block').on('change keyup', '.textbox_file_type input', function() {
		var value = jQuery(this).val();
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block > input').prop('type', value);
	});


	jQuery('#fields-list-block').on('change keyup', '.textarea-resize', function() {
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		var textarea = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] textarea').not('.secondary-label');
		if (jQuery(this).is(':checked')) {
			textarea.css({'resize': 'vertical'});
		} else {
			textarea.css({'resize': 'none'});
		}
	});

	jQuery('#fields-list-block').on('change keyup', '.textarea-size', function() {

		var value = jQuery(this).val();
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		var textarea = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] textarea');
		textarea.css({"height": value});
	});


	jQuery('#fields-list-block').on('keypress keyup', '.submitbutton', function() {
		var value = jQuery(this).val();
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		var submitbutton = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] button[type="submit"]');
		submitbutton.html(value);
	});

	jQuery('#fields-list-block').on('keypress', '.resetbutton', function() {
		var value = jQuery(this).val();
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		var resetbutton = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] button[type="reset"]');
		resetbutton.html(value);
	});

	jQuery('#fields-list-block').on('change keyup', '.showresetbutton', function() {
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		var resetbutton = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] button[type="reset"]');
		if (jQuery(this).is(':checked')) {
			resetbutton.css({'display': 'inline-block'});
		} else {
			resetbutton.css({'display': 'none'});
		}
	});

	if (jQuery('select[id="form_checkbox_size"]').val() != 'go_to_url') {
		jQuery('div[id="go_to_url_field"]').hide();
	} else {
		jQuery('div[id="go_to_url_field"]').show();
	}
	jQuery('#fields-list-block').on('change', '.hugeit_contact_captcha_theme', function() {
		var position = jQuery('#fields-list-block .captcha_position').val();
		if (position == '1') {
			position = "right";
		} else {
			position = "left";
		}
		if (jQuery(this).val() == 'light') {
			jQuery('#democaptchadark').css({'display': 'none', 'float': position});
			jQuery('#democaptchalight').css({'display': 'block', 'float': position});
		} else {
			jQuery('#democaptchalight').css({'display': 'none', 'float': position});
			jQuery('#democaptchadark').css({'display': 'block', 'float': position});
		}
	});
	jQuery('#fields-list-block').on('change', '.captcha_position', function() {
		if (jQuery('#fields-list-block .hugeit_contact_captcha_theme').val() == 'light') {
			if (jQuery(this).val() == '2') {
				jQuery('#democaptchalight').css({'display': 'block', 'float': 'left'});
			} else {
				jQuery('#democaptchalight').css({'display': 'block', 'float': 'right'});
			}
		} else {
			if (jQuery(this).val() == '2') {
				jQuery('#democaptchadark').css({'display': 'block', 'float': 'left'});
			} else {
				jQuery('#democaptchadark').css({'display': 'block', 'float': 'right'});
			}
		}
	});
	jQuery('#fields-list-block').on('change', 'select[id="form_checkbox_size"]', function() {
		if (jQuery(this).val() != 'go_to_url') {
			jQuery('div[id="go_to_url_field"]').hide();
		} else {
			jQuery('div[id="go_to_url_field"]').show();
		}
	});
	//Ready to Go Onchange//
	jQuery('#fields-list-block').on('keypress keyup change', 'select#ready_form_label_position', function() {
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		var currentClass = jQuery(this).val();
		var previewfield = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] label');
		var previewfield2 = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] div.field-block');
		var fieldtype = jQuery(this).parents('.fields-options').parent().find('input.left-right-position').attr('filetype');
		if (fieldtype == 'nameSurname') {
			if (previewfield2.hasClass('formsAboveAlign')) {
				previewfield2.removeClass('formsAboveAlign')
			}
			if (previewfield2.hasClass('formsLeftAlign')) {
				previewfield2.removeClass('formsLeftAlign')
			}
			if (previewfield2.hasClass('formsRightAlign')) {
				previewfield2.removeClass('formsRightAlign')
			}
			if (previewfield2.hasClass('formsLabelHide')) {
				previewfield2.removeClass('formsLabelHide')
			}
			previewfield.removeClass();
			previewfield.addClass(currentClass);
			previewfield2.addClass(currentClass);
		}
	});
	jQuery('#fields-list-block').on('keypress keyup change', '.placeholderName', function() {
		var value = jQuery(this).val();
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		var previewfield = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block input.pl_name');
		previewfield.attr("placeholder", value);
	});
	jQuery('#fields-list-block').on('keypress keyup change', '.placeholderSur', function() {
		var value = jQuery(this).val();
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		var previewfield = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block input.pl_surname');
		previewfield.attr("placeholder", value);
	});
	jQuery('#fields-list-block').on('keypress keyup change', 'select.country-list', function() {
		var codeName = jQuery(this).val();
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		var numCode = jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block ul.country-list').find('li[data-country-code="' + codeName + '"]').attr('data-dial-code');
		numCode = '+' + numCode;
		var plToReplace = jQuery(this).parents('.fields-options').find('input.placeholder').val();
		plToReplace = plToReplace.replace(/(\+\d*)/, numCode)
		jQuery(this).parents('.fields-options').find('input.placeholder').val(plToReplace);
		jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block div.selected-flag').click();
		jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .field-block ul.country-list').find('li[data-country-code="' + codeName + '"]').click();
	});
	jQuery('#fields-list-block').on('keypress keyup change', 'input.linkName', function() {
		var codeName = jQuery(this).val();
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .license-block').find('span.sublable a').text(codeName);
	});
	jQuery('#fields-list-block').on('keypress keyup change', 'input.linkUrl', function() {
		var url = jQuery(this).val();
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .license-block').find('span.sublable a').attr('href', url);
	});
	jQuery('#fields-list-block').on('keypress keyup change', 'textarea.fieldContent', function() {
		var fieldContent = jQuery(this).val();
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		var linkName = jQuery(this).parents('.fields-options').find('input.linkName').val();
		var linkUrl = jQuery(this).parents('.fields-options').find('input.linkUrl').val();
		fieldContent = fieldContent.replace(/{link}/, '<a target="_blank" href="' + linkUrl + '">' + linkName + '</a> ');
		jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .license-block').find('span.sublable').html(fieldContent);
	});
	jQuery('#fields-list-block').on('keypress keyup change', 'select.fieldPos', function() {
		var position = jQuery(this).val();
		var fieldid = jQuery(this).parents('.fields-options').parent().attr('id');
		jQuery('.hugeit-contact-column-block > div[rel="' + fieldid + '"] .license-block').css('text-align', position)
	});
	//Ready to Go Onchange//
	/*edit field*/
	jQuery('#hugeit-contact-wrapper').on('click tap', '.hugeit-field-block>label', function(e) {
		e.preventDefault();
	});
	jQuery('#hugeit-contact-wrapper').on('click tap', '.hugeit-field-block', function() {
		var fieldID = jQuery(this).attr('rel');
		jQuery('#fields-list-block').find('li#' + fieldID + ' .field-top-options-block a.open-close').click();
	});
	jQuery('#hugeit-contact-wrapper').on('click tap', '.hugeit-field-block .flag-container', function() {
		return false;
	});
	/*edit field*/
	/*FRONT END PREVIEW */

	jQuery(".hugeit-contact-column-block input[type='file']").on('change keyup', function() {
		var value = jQuery(this).val().substr(jQuery(this).val().indexOf('fakepath') + 9);
		jQuery(this).parent().find('input[type="text"]').val(value);
	});

	jQuery(".hugeit-contact-column-block select").on('change keyup', function() {
		jQuery(this).prev('.textholder').val(jQuery(this).val());
	});

	jQuery.fn.ForceNumericOnly = function() {
		return this.each(function() {
			jQuery(this).keydown(function(e) {
				var key = e.charCode || e.keyCode || 0;
				// allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
				// home, end, period, and numpad decimal
				return (
				key == 8 ||
				key == 9 ||
				key == 13 ||
				key == 32 ||
				key == 46 ||
				key == 110 ||
				key == 190 ||
				(key >= 35 && key <= 40) ||
				(key >= 48 && key <= 57) ||
				(key >= 96 && key <= 105));
			});
		});
	};


	/*STYLE OPTIONS*/

	jQuery('#form_wrapper_background_type').on('change keyup', function() {

		if (jQuery(this).val() == 'gradient') {
			jQuery('.form_first_background_color').addClass('half');
			jQuery('.form_second_background_color').removeClass('none')
		} else {
			jQuery('.form_second_background_color').addClass('none');
			jQuery('.form_first_background_color').removeClass('half');
		}
	});

	jQuery('.form_background_color').on('change keyup', function() {
		var bgcolor = jQuery('.form_first_background_color').val() + ',' + jQuery('.form_second_background_color').val();
		jQuery('#form_wrapper_background_color').val(bgcolor);
	});

	jQuery('.hugeit_forms_delete_form').on('click', function() {
	  var c = confirm('Are you sure you want to delete this form ?');

	  if (!c) {
		  return false;
	  }
	});

	jQuery('.hugeit_contact_duplicate_form').on('click', function(e) {
		e.preventDefault();

		var id = jQuery(this).data('form-id'),
			nonce = jQuery(this).data('nonce');

		jQuery.ajax({
			url: ajaxurl,
			dataType: 'JSON',
			type: 'POST',
			data: {
				action: 'hugeit_contact_duplicate_form',
				nonce: nonce,
				id: id
			}
		}).done(function(response) {
			if (response.success) {
				location.reload();
			}
		})
	});


	  jQuery(".close_free_banner").on("click",function(){
		  jQuery(".free_version_banner").css("display","none");
		  HugeitContactSetCookie( 'hgFormsFreeBannerShow', 'no', {expires:86400} );
	  });
		defaultTitleVisibility = jQuery('#hugeit-contact-wrapper').find('h3').css('display');

	  jQuery('#select_form_show_title').on('change', function() {
		  switch (jQuery(this).val()) {
			  case 'yes' :
				  jQuery('#hugeit-contact-wrapper').find('h3').css('display', 'block');
				  break;
			  case 'no' :
				  jQuery('#hugeit-contact-wrapper').find('h3').css('display', 'none');
				  break;
			  case 'default' :
				  jQuery('#hugeit-contact-wrapper').find('h3').css('display', defaultTitleVisibility);
		  }
	  })
});

  function HugeitContactSetCookie(name, value, options) {
	  options = options || {};

	  var expires = options.expires;

	  if (typeof expires == "number" && expires) {
		  var d = new Date();
		  d.setTime(d.getTime() + expires * 1000);
		  expires = options.expires = d;
	  }
	  if (expires && expires.toUTCString) {
		  options.expires = expires.toUTCString();
	  }


	  if(typeof value == "object"){
		  value = JSON.stringify(value);
	  }
	  value = encodeURIComponent(value);
	  var updatedCookie = name + "=" + value;

	  for (var propName in options) {
		  updatedCookie += "; " + propName;
		  var propValue = options[propName];
		  if (propValue !== true) {
			  updatedCookie += "=" + propValue;
		  }
	  }

	  document.cookie = updatedCookie;
  }

var checkAnimate;
jQuery(function() {
	jQuery(".hugeit-contact-column-block").sortable({
		placeholder: 'ui_custom_pl',
		cancel: '',
		start: function(e, ui) {
			ui.placeholder.height(ui.item.height());
			ui.helper.find('select').addClass('openedSelect');
			ui.helper.css({'width': '90%', 'z-index': '9999'});
			if (jQuery("#fields-list-right li").length > 0) {
				checkAnimate = true;
			} else {
				var hieghtOfColumn = jQuery("#hugeit-contact-wrapper  div.hugeit-contact-block-left").height();
				var res = (hieghtOfColumn - 116) / 2;
				jQuery("#hugeit-contact-wrapper  div.hugeit-contact-block-left").animate({'width': "70%"}, 500);
				jQuery("#hugeit-contact-wrapper  div.hugeit-contact-block-right").animate({
					'width': "23%",
					'min-width': "23%"
				}, 500, function() {
					jQuery(this).css('background-position', 'center 5px')
				});
				checkAnimate = false;
			}
		},
		connectWith: ".hugeit-contact-column-block",
		stop: function(e, ui) {
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

			i = 0;
			jQuery("#fields-list-right > li").each(function() {
				jQuery(this).find('.ordering').val(i);
				i++;
				if (jQuery(this).attr('data-fieldType') == 'custom_text') {
					var i, t = tinyMCE.editors;
					for (i in t) {
						if (t.hasOwnProperty(i)) {
							t[i].remove();
						}
					}
					jQuery(this).find('button.switch-html').click();
				}
			});
			i = 0;
			jQuery("#fields-list-left > li").each(function() {
				jQuery(this).find('.ordering').val(i);
				i++;
				if (jQuery(this).attr('data-fieldType') == 'custom_text') {
					var i, t = tinyMCE.editors;
					for (i in t) {
						if (t.hasOwnProperty(i)) {
							t[i].remove();
						}
					}
					jQuery(this).find('button.switch-html').click();
				}
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
			if (jQuery("#hugeit-contact-wrapper  div.hugeit-contact-block-right>div").length > 0) {
				if (jQuery("#hugeit-contact-wrapper  div.hugeit-contact-block-right>div").length == 1 && checkAnimate == false) {
					jQuery("#hugeit-contact-wrapper  div.hugeit-contact-block-left").animate({'width': "47%"}, 500);
					jQuery("#hugeit-contact-wrapper  div.hugeit-contact-block-right").animate({'width': "47%"}, 500);
				} else {
					checkAnimate = true;
				}
			} else {
				jQuery("#hugeit-contact-wrapper  div.hugeit-contact-block-left").animate({'width': "93%"}, 500);
				jQuery("#hugeit-contact-wrapper  div.hugeit-contact-block-right").animate({
					'width': "1%",
					"min-width": "1%"
				}, 500, function() {
					jQuery(this).css('background-position', 'center bottom')
				});
				//alert(2)
			}

			if (jQuery("#fields-list-right li").length > 0) {
				jQuery("#hugeit-contact-wrapper > div").addClass('multicolumn');
			} else {
				jQuery("#hugeit-contact-wrapper > div").removeClass('multicolumn');
			}
			jQuery(".fields-list > li").removeClass('has-background');
			count = jQuery(".fields-list > li").length;
			for (var i = 0; i <= count; i += 2) {
				jQuery("#fields-list-left > li").eq(i).addClass("has-background");
				jQuery("#fields-list-right > li").eq(i).addClass("has-background");
			}

		},
		over: function() {
		},
		revert: true
	});
	jQuery('.hugeit-contact-column-block').on('click', 'input', function() {
		jQuery(this).focus();
	});
	jQuery('.hugeit-contact-column-block').on('click', 'textarea', function() {
		jQuery(this).focus();
	});
	jQuery('.hugeit-contact-column-block').on('click', 'select', function() {
		if (!jQuery(this).hasClass('openedSelect')) {
			var e = document.createEvent('MouseEvents');
			e.initMouseEvent('mousedown');
			jQuery(this)[0].dispatchEvent(e);
			jQuery(this).addClass('openedSelect');

		} else {
			jQuery('body').click();
			jQuery(this).removeClass('openedSelect');
		}
		return false;
	});
});
