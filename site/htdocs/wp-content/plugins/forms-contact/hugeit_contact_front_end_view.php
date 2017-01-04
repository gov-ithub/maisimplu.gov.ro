<?php
if(! defined( 'ABSPATH' )) exit;
function hugeit_contact_front_end_hugeit_contact($rowim,  $paramssld, $hugeit_contact, $frontendformid, $style_values, $huge_it_gen_opt,$rowspar){
	ob_start();
	?>
	<style>
			/*########### PREVIEW CONTAINER ##############*/

#hugeit-contact-preview-container {
	position:relative;
	float:right;
	width:60%;
	padding:10px 0 10px 0;
	background:#fff;
	min-width:310px;
	
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?>  {
	margin:0 auto;
	min-width:315px;
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block  {
	position:relative;
	float:left;
	width:94%;
	min-width:305px;
	margin:0 1% 0 1%;
	height:auto;
	min-height:30px;
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?>  div.multicolumn .hugeit-contact-column-block  {
	width:47%;
	padding-top: 10px;
}
#hugeit-contact-wrapper_<?php echo $frontendformid; ?>  .hugeit-contact-column-block  {
	padding-top: 10px;
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div {
	width:100%;
	padding:5px 0 5px 0;
	clear:both;
	line-height: 0;
}
#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div.custom-text-block{
	font-size:<?php echo $style_values['form_label_size']; ?>px !important;
	line-height:<?php echo $style_values['form_label_size']+1; ?>px !important;
}
#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div.hugeit-check-field,
#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div.hugeit-radio-field{
	padding:5px 0 5px 0;
}
#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div.buttons-block{
	position: relative;
}
#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div.hover-active {
	border:2px dashed #2EA2CC;
	padding-left:2px;
	padding-right:2px;
	padding-bottom:2px;
	margin-left:-4px;
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div.captcha-block {
	/*height:78px;*/
}

/***fvpps***/
.free_video .portelemented .play-icss {
    position: relative;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
	overflow: hidden;
	outline:none; 
}	
/***fvpps***/
#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div > label {
	display:block;
	width:38%;
	float:left;
	cursor: pointer;
	margin-right: 2%;
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .field-block {
	display:inline-block;
	width:60%;
	vertical-align: super !important;
    line-height: 0;
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .field-block select,
#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .field-block textarea,
#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .field-block input[type="text"],
#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .field-block input[type="password"],
#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .field-block input[type="name"],
#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .field-block input[type="email"],
#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .field-block input[type="number"] {
	width:100%;
	line-height: initial !important;
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .field-block ul {
	width:100%;
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .field-block ul li {
	float:left;
	line-height: 1 !important;
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .field-block ul li label {margin:0 10px 0 0;}
#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .field-block ul li label span.sublable{vertical-align: super;}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div  ul {
	position:relative;
	display:table !important;
	padding:0 !important;
	margin:0 !important;
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div > label  ul li {
	clear:both;
	padding:0 !important;
	margin:0 !important;
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?> #huge_it_captcha {
	float:right;
}
/*FIELDS CUSTOM STYLES*/


/*radio + checkbox*/

#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.big-radio .radio-block, #hugeit-contact-wrapper_<?php echo $frontendformid; ?>.big-checkbox .checkbox-block {
	width: 24px;
    height: 24px;
	border-radius:13px;
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.big-radio .radio-block input:checked + span,#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.big-checkbox .checkbox-block  input:checked + span {
	width: 12px;
    height: 12px;
	border-radius:6px;
	top:5px;
	left:5px;
}


#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.medium-radio .radio-block,#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.medium-checkbox .checkbox-block {
	width: 20px;
    height: 20px;
	border-radius:10px;
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.medium-radio .radio-block input:checked + span,#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.medium-checkbox .checkbox-block  input:checked + span{
	width: 10px;
    height: 10px;
	border-radius:5px;
	top:4px;
	left:4px;
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.small-radio .radio-block.small,#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.small-checkbox .checkbox-block {
	width: 15px;
    height: 15px;
	border-radius:8px;
}

#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.small-radio .radio-block input:checked + span, #hugeit-contact-wrapper_<?php echo $frontendformid; ?>.small-checkbox  .checkbox-block  input:checked + span{
	width: 7px;
    height: 7px;
	border-radius:7px;
	top:3px;
	left:3px;
}

#huge-it-captcha-popup > div > label {
	display:inline-block;
	height:30px;
	width:150px;
}

#huge-it-captcha-popup > div > input {
	width:350px;
}

/*######################## END OFO CHOR ######################*/

			body #hugeit-contact-wrapper_<?php echo $frontendformid; ?> input, body #hugeit-contact-wrapper_<?php echo $frontendformid; ?> textarea {padding:0; margin:0;}
			
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> {
				width:<?php echo $style_values['form_wrapper_width']; ?>%;
			
							
				<?php
					$color = explode(',', $style_values['form_wrapper_background_color']);
				 if($style_values['form_wrapper_background_type']=="color"){?>
						background:#<?php echo $color[0]; ?>;
				<?php }
					elseif($style_values['form_wrapper_background_type']=="gradient"){ ?>
						background: -webkit-linear-gradient(#<?php echo $color[0]; ?>, #<?php echo $color[1]; ?>); /* For Safari 5.1 to 6.0 */
						background: -o-linear-gradient(#<?php echo $color[0]; ?>, #<?php echo $color[1]; ?>); /* For Opera 11.1 to 12.0 */
						background: -moz-linear-gradient(#<?php echo $color[0]; ?>, #<?php echo $color[1]; ?>); /* For Firefox 3.6 to 15 */
						background: linear-gradient(#<?php echo $color[0]; ?>, #<?php echo $color[1]; ?>); /* Standard syntax */
				<?php
					}
				?>	
			}
			
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> > div {
				border:<?php echo $style_values['form_border_size']; ?>px solid #<?php echo $style_values['form_border_color']; ?>;
			}
			
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> > div > h3 {
				position:relative;
				display:block;
				clear:both !important;
				padding:5px 0 10px 1% !important;
				font-size:<?php echo $style_values['form_title_size']; ?>px !important;
				line-height:<?php echo $style_values['form_title_size']; ?>px !important;
				color:#<?php echo $style_values['form_title_color']; ?> !important;
				margin: 10px 0 15px 0 !important;
			}
			
			/*LABELS*/
			
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> label {
				font-size:<?php echo $style_values['form_label_size']; ?>px !important;
				line-height:<?php echo $style_values['form_label_size']; ?>px !important;
				color:#<?php echo $style_values['form_label_color']; ?>;
				font-family:<?php echo $style_values['form_label_font_family']; ?>;
			}
			
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-field-block >label.error {
				color:#<?php echo $style_values['form_label_error_color']; ?> !important;
			}
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> label em.required-star{
				color: #<?php echo $style_values['form_label_required_color']; ?>;
			}
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> label em.error{
				color: #<?php echo $style_values['form_label_error_color']; ?>;
			}
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-field-block span.hugeit-error-message{
				font-size: 12px !important;
				color: #<?php echo $style_values['form_label_error_color']; ?>;
				line-height:<?php echo $style_values['form_label_size']; ?>px !important;
				font-family:<?php echo $style_values['form_label_font_family']; ?>;
				display: inline;
				vertical-align: top;
				padding-top: 5px;
			}
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-field-block span.huge_it_success_msg{
				font-size: 16px !important;
				display: block;
				text-align: center;
				vertical-align:super;
				font-family:<?php echo $style_values['form_label_font_family']; ?>;
				color:#<?php echo $style_values['form_label_success_message']; ?>;
			}
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-field-block span.huge_it_spam_msg{
				font-size: 16px !important;
				display: block;
				text-align: center;
				vertical-align:super;
				font-family:<?php echo $style_values['form_label_font_family']; ?>;
				color:#<?php echo $style_values['form_label_error_color']; ?>;
			}
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-field-block span.huge_it_button_overlay{
				background: rgba(241, 241, 241, 0.85);
			    position: absolute;
			    top: 0;
			    left: 0;
			    text-align: center;
			}
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-field-block span.huge_it_button_overlay>img#buttLoad{
				width: 20px;
				height: 20px;
			}
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div > label.formsRightAlign{
				text-align: right !important;
			}
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div > label.formsAboveAlign{
				width:100% !important;
				float:none !important;
				padding-bottom: 5px !important;
			}
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .formsAboveAlign {
				width:100% !important;				
			}
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div > label.formsLabelHide{
				display: none;!
			}
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .formsLabelHide {
				width:100% !important;				
			}
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div > label.formsInsideAlign{
				display:none !important;				
			}
			#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .formsInsideAlign {
				width:100% !important;
			}
			/*FIELDS CUSTOM STYLES*/
			
				/*############INPUT TEXT############*/
			
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .input-text-block input,
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .input-text-block input:focus {
					height:<?php echo $style_values['form_input_text_font_size']*2; ?>px;
					<?php if($style_values['form_input_text_has_background']=="on"){?>
					background:#<?php echo $style_values['form_input_text_background_color']; ?>;
					<?php }else { ?>
					background:none;
					<?php } ?>
					border:<?php echo $style_values['form_input_text_border_size']; ?>px solid #<?php echo $style_values['form_input_text_border_color']; ?> !important;
					box-shadow:none  !important ;
					border-radius:<?php echo $style_values['form_input_text_border_radius']; ?>px;
					font-size:<?php echo $style_values['form_input_text_font_size']; ?>px;
					color:#<?php echo $style_values['form_input_text_font_color']; ?>;
					margin:0 !important;
					padding:0 0 0 5px !important;
					outline:none;
					vertical-align:top !important;
					box-sizing: border-box;
					-moz-box-sizing: border-box;
				}
				
				/*/////INPUT TEXT FullName//////*/
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?>  .input-name-block{
					font-size: 0 !important;
				}
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .input-name-block input,
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .input-name-block input:focus {
					width: 49% !important;
					height:<?php echo $style_values['form_input_text_font_size']*2; ?>px;
					<?php if($style_values['form_input_text_has_background']=="on"){?>
					background:#<?php echo $style_values['form_input_text_background_color']; ?>;
					<?php }else { ?>
					background:none;
					<?php } ?>
					border:<?php echo $style_values['form_input_text_border_size']; ?>px solid #<?php echo $style_values['form_input_text_border_color']; ?> !important;
					box-shadow:none  !important ;
					border-radius:<?php echo $style_values['form_input_text_border_radius']; ?>px;
					font-size:<?php echo $style_values['form_input_text_font_size']; ?>px;
					color:#<?php echo $style_values['form_input_text_font_color']; ?>;
					margin:0 !important;
					padding:0 5px 0 5px !important;
					outline:none;
					box-sizing: border-box;
					-moz-box-sizing: border-box;
				}
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?>  .input-name-block input:first-child,
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?>  .input-name-block input:first-child:focus{
					margin-right: 2% !important;
				}
				/*/////INPUT TEXT FullName//////*/
				/*/////////*/
				/*############ Phone Field############*/
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .ready-phone-block input.readyPhone,.ready-phone-block input.readyPhone:focus {
					width: 100%;
					box-sizing:border-box;
					height:<?php echo $style_values['form_input_text_font_size']*2; ?>px;
					<?php if($style_values['form_input_text_has_background']=="on"){?>
					background:#<?php echo $style_values['form_input_text_background_color']; ?>;
					<?php }else { ?>
					background:none;
					<?php } ?>
					border:<?php echo $style_values['form_input_text_border_size']; ?>px solid #<?php echo $style_values['form_input_text_border_color']; ?> !important;
					box-shadow:none  !important ;
					border-radius:<?php echo $style_values['form_input_text_border_radius']; ?>px;
					font-size:<?php echo $style_values['form_input_text_font_size']; ?>px;
					color:#<?php echo $style_values['form_input_text_font_color']; ?>;
					margin:0 !important;
					outline:none;
				    padding-left: 48px;
				}
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div ul.hide{
					display: none !important;
				}
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div ul.country-list{
					display: block !important;
				    z-index: 10;
				}
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-contact-column-block > div .field-block ul.country-list li{
					float: none !important;
					margin: 0 !important;
				}
				/*############TEXTAREA############*/
				
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .textarea-block textarea {
					<?php if($style_values['form_textarea_has_background']=="on"){?>
					background:#<?php echo $style_values['form_textarea_background_color']; ?>;
					<?php }else { ?>
					background:none;
					<?php } ?>
					border:<?php echo $style_values['form_textarea_border_size']; ?>px solid #<?php echo $style_values['form_textarea_border_color']; ?>;
					border-radius:<?php echo $style_values['form_textarea_border_radius']; ?>px;
					font-size:<?php echo $style_values['form_textarea_font_size']; ?>px;
					color:#<?php echo $style_values['form_textarea_font_color']; ?>;
					margin:0 !important;
					padding:0 0 0 5px !important;
					 box-sizing: border-box;
					-moz-box-sizing: border-box;
				}
				
				/*############CHECKBOX RADIOBOX############ */
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-checkbox-list {
					list-style:none;					
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-checkbox-list li,
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-radiobox-list li {
					
					margin:0 0 6px 0 !important;
					padding:0 !important;
					list-style:none;	
				 }
				 
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-checkbox-list li label ,
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-radiobox-list li label {
					cursor:pointer;					
				}
		
			
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .radio-block, 
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .checkbox-block {
					position:relative;
					float:left;
					margin:0 5px 0 5px !important;
					display: block;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .radio-block input,
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .checkbox-block input {
					visibility:hidden;
					position:absolute;
					top:0;
					left:0;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .radio-block i {
					display:inline-block;
					float:left;
					width:20px;
					color:#<?php echo $style_values['form_radio_color']; ?>;
					cursor:pointer;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .checkbox-block i {
					display:inline-block;
					float:left;
					width:20px;
					color:#<?php echo $style_values['form_checkbox_color']; ?>;
				 }


				#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.big-radio .radio-block i ,
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.big-checkbox .checkbox-block i {
					font-size:24px;
				}
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.medium-radio .radio-block i ,
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.medium-checkbox .checkbox-block i {
					font-size:20px;
				}
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.small-radio .radio-block i ,
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.small-checkbox .checkbox-block i {
					font-size:15px;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .radio-block i:hover {
					color:#<?php echo $style_values['form_radio_hover_color']; ?>;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?>.checkbox-block i:hover {
					color:#<?php echo $style_values['form_checkbox_hover_color']; ?>;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .radio-block i.active, 
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .checkbox-block i.active {
					display:none;
				}/*Voch checked inputi motic heracnumenq active@*/
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .radio-block input:checked + i.active + i.passive,
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .checkbox-block  input:checked + i.active + i.passive {
					display:none;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .radio-block input:checked + i.active, 
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .radio-block input:checked + i.active:hover {
					display:inline-block;
					color:#<?php echo $style_values['form_radio_active_color']; ?>;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .checkbox-block	input:checked + i.active, 
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .checkbox-block input:checked + i.active:hover {
					display:inline-block;
					color:#<?php echo $style_values['form_checkbox_active_color']; ?>;
				}


				/*############SELECTBOX#############*/
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .selectbox-block {
					position:relative;
					height:<?php echo $style_values['form_selectbox_font_size']*2+$style_values['form_selectbox_border_size']; ?>px;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .selectbox-block select {
					position:relative;
					height:<?php echo $style_values['form_selectbox_font_size']*2-$style_values['form_selectbox_border_size']*2; ?>px;
					margin:<?php echo $style_values['form_selectbox_border_size']; ?>px 0 0 1px !important;
					opacity:0;
					z-index:2;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .selectbox-block .textholder {
					position:absolute;
					height:<?php echo $style_values['form_selectbox_font_size']*2; ?>px;
					width:90%;
					margin:0 !important;
					top:0;
					color:#<?php echo $style_values['form_selectbox_font_color']; ?>; 
					left:0;
					border:0;
					opacity: 1 !important;
					background:none;
					border:<?php echo $style_values['form_selectbox_border_size']; ?>px solid #<?php echo $style_values['form_selectbox_border_color']; ?>;
					border-radius:<?php echo $style_values['form_selectbox_border_radius']; ?>px;
					font-size:<?php echo $style_values['form_selectbox_font_size']; ?>px;
					<?php if($style_values['form_selectbox_has_background']=="on"){?>
					background:#<?php echo $style_values['form_selectbox_background_color']; ?>;
					<?php  }else { ?>
					background:none;
					<?php } ?>
					padding:0 10% 0 5px !important;
					 box-sizing: border-box;
					-moz-box-sizing: border-box;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .selectbox-block i {
					position:absolute;
					top:<?php echo $style_values['form_selectbox_font_size']/2+$style_values['form_selectbox_border_size']/4; ?>px;
					right:10px;
					z-index:0;
					color:#<?php echo $style_values['form_selectbox_arrow_color']; ?>;
					font-size:<?php echo $style_values['form_selectbox_font_size']; ?>px;
				}
				
				/*############FILE#############*/
				
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .file-block {
					position:relative;
					cursor:pointer;
				}
								
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .file-block .textholder {
					position:relative;
					float:left;
					width:calc(60% - <?php echo $style_values['form_file_border_size']*2 + 5; ?>px) !important;
					height:<?php echo $style_values['form_file_font_size']*2; ?>px;
					margin:0;
					border:<?php echo $style_values['form_file_border_size']; ?>px solid #<?php echo $style_values['form_file_border_color']; ?> !important;
					border-radius:<?php echo $style_values['form_file_border_radius']; ?>px !important;
					font-size:<?php echo $style_values['form_file_font_size']; ?>px;
					color:#<?php echo $style_values['form_file_font_color']; ?>;
					<?php if($style_values['form_file_has_background']=="on"){?>
					background:#<?php echo $style_values['form_file_background']; ?>;
					<?php  }else { ?>
					background:none;
					<?php } ?>
					padding:0 40% 0 5px !important;
					box-sizing: content-box;
					-moz-box-sizing: content-box;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .file-block .uploadbutton {	
					position:absolute;
					top:0;
					right:0;
					width:38%;
					border-top:<?php echo $style_values['form_file_border_size']; ?>px solid #<?php echo $style_values['form_file_border_color']; ?> !important;
					border-bottom:<?php echo $style_values['form_file_border_size']; ?>px solid #<?php echo $style_values['form_file_border_color']; ?> !important;
					border-right:<?php echo $style_values['form_file_border_size']; ?>px solid #<?php echo $style_values['form_file_border_color']; ?> !important;
					border-top-right-radius:<?php echo $style_values['form_file_border_radius']; ?>px !important;
					border-bottom-right-radius:<?php echo $style_values['form_file_border_radius']; ?>px !important;
					<?php $fileheight=$style_values['form_file_font_size']*2; ?>
					height:<?php echo $fileheight; ?>px;
					padding:0 1%;
					margin:0;
					overflow: hidden;
					font-size:<?php echo $style_values['form_file_font_size']; ?>px;
					line-height:<?php echo $style_values['form_file_font_size']*2; ?>px;
					color:#<?php echo $style_values['form_file_button_text_color']; ?>;
					background:#<?php echo $style_values['form_file_button_background_color']; ?>;
					text-align:center;
					-webkit-transition: all 0.5s ease;
					transition: all 0.5s ease;		
					box-sizing:content-box;			
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .file-block:hover .uploadbutton {	
					color:#<?php echo $style_values['form_file_button_text_color']; ?>;
					background:#<?php echo $style_values['form_file_button_background_color']; ?>;
					vertical-align: baseline;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .file-block .uploadbutton i {
					color:#<?php echo $style_values['form_file_icon_color']; ?>;
					font-size:<?php echo $style_values['form_file_font_size']; ?>px;
					vertical-align: baseline;
					-webkit-transition: all 0.5s ease;
					transition: all 0.5s ease;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .file-block:hover .uploadbutton {
					color:#<?php echo $style_values['form_file_button_text_hover_color']; ?>;
					background:#<?php echo $style_values['form_file_button_background_hover_color']; ?>;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .file-block:hover .uploadbutton i {
					color:#<?php echo $style_values['form_file_icon_hover_color']; ?>;
				}
							
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .file-block input[type='file'] {
					height:30px;
					width:100%;
					position:absolute;
					top:0;
					left:0;
					opacity:0;
					cursor:pointer;
				}
				

				/*###########CAPTCHA#############*/
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .captcha-block div {
					margin-right:-1px;
					float: right;
				}
				/*############BUTTONS#############*/
				
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .buttons-block  {
					<?php
						if($style_values['form_button_position']=="left"){echo "text-align:left;";}
						else if ($style_values['form_button_position']=="right"){echo "text-align:right;";}
						else {echo "text-align:center;";}
					?>
				}

				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .buttons-block button {
					height:auto;
					padding:<?php echo $style_values['form_button_padding']; ?>px <?php echo $style_values['form_button_padding']*2; ?>px <?php echo $style_values['form_button_padding']; ?>px <?php echo $style_values['form_button_padding']*2; ?>px;
					cursor:pointer;
					text-transform: none;
					<?php
						if($style_values['form_button_fullwidth']=="on") :
					?>
						clear:both;
						width:100%;
						margin:0 0 0 0 !important;
						padding-left:0;
						padding-right:0;
					<?php endif; ?>
					font-size:<?php echo $style_values['form_button_font_size']; ?>px;
				}
				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .buttons-block button.submit {
					color:#<?php echo $style_values['form_button_submit_font_color']; ?> !important;
					background-color:#<?php echo $style_values['form_button_submit_background']; ?> !important;
					border:<?php echo $style_values['form_button_submit_border_size']; ?>px solid #<?php echo $style_values['form_button_submit_border_color']; ?> !important;
					border-radius:<?php echo $style_values['form_button_submit_border_radius']; ?>px !important;
					-webkit-transition: all 0.5s ease !important;
					transition: all 0.5s ease !important;
					margin:0 0 5px 0 !important;
					background-image: none !important;
				}				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .buttons-block button.submit:hover {
					color:#<?php echo $style_values['form_button_submit_font_hover_color']; ?> !important;
					background:#<?php echo $style_values['form_button_submit_hover_background']; ?> !important;
				}				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .buttons-block button.submit i {
					color:#<?php echo $style_values['form_button_submit_icon_color']; ?> !important;
					font-size:<?php echo $style_values['form_button_font_size']; ?>px !important;
					vertical-align: baseline !important;
					-webkit-transition: all 0.5s ease !important;
					transition: all 0.5s ease !important;
				}				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .buttons-block button.submit:hover i {
					color:#<?php echo $style_values['form_button_submit_icon_hover_color']; ?> !important;
				}	
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .buttons-block button.reset {
					color:#<?php echo $style_values['form_button_reset_font_color']; ?> !important;
					background-color:#<?php echo $style_values['form_button_reset_background']; ?> !important;
					border:<?php echo $style_values['form_button_reset_border_size']; ?>px solid #<?php echo $style_values['form_button_reset_border_color']; ?> !important;
					border-radius:<?php echo $style_values['form_button_reset_border_radius']; ?>px !important;
					-webkit-transition: all 0.5s ease !important;
					transition: all 0.5s ease !important;
					background-image: none !important;
				}				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .buttons-block button.reset:hover {
					color:#<?php echo $style_values['form_button_reset_font_hover_color']; ?> !important;
					background:#<?php echo $style_values['form_button_reset_hover_background']; ?> !important;
				}				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .buttons-block button.reset i {
				
					color:#<?php echo $style_values['form_button_reset_icon_color']; ?> !important;
					font-size:<?php echo $style_values['form_button_font_size']; ?>px !important;
					vertical-align: baseline !important;
					-webkit-transition: all 0.5s ease !important;
					transition: all 0.5s ease !important;
				}				
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .buttons-block button.reset:hover i {
					color:#<?php echo $style_values['form_button_reset_icon_hover_color']; ?> !important;
				}
				/*############ License Field ############*/
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-check-field >.license-block{
					width: 100% !important;
				}
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-check-field > .license-block >.secondary-label{
					vertical-align: super !important;
				}
				#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-check-field > .license-block >.secondary-label > .checkbox-block{
					margin: 0 5px 0 0 !important;
					float: none !important;
					display: inline-block;
					vertical-align: middle !important;
				}
			</style>
			<script>
				jQuery(document).ready(function () {						
					/*FRONT END PREVIEW FROM ADMIN JS*/					
					<?php if(isset($_SERVER['HTTP_USER_AGENT']))  $agent = $_SERVER['HTTP_USER_AGENT'];?>
					<?php if (strlen(strstr($agent, 'Firefox')) > 0):?>
					  	jQuery(".hugeit-contact-column-block input[type='file']").on('change',function(){
							var value=jQuery(this).val().substr(jQuery(this).val().indexOf('fakepath'));
							jQuery(this).parent().find('input[type="text"]').val(jQuery(this).val());
						});
						<?php else: ?>
							jQuery(".hugeit-contact-column-block input[type='file']").on('change',function(){
							var value=jQuery(this).val().substr(jQuery(this).val().indexOf('fakepath')+9);
							jQuery(this).parent().find('input[type="text"]').val(value);
						});
					<?php endif; ?>	
					
					jQuery(".hugeit-contact-column-block select").on('change',function(){
						jQuery(this).prev('.textholder').val(jQuery(this).val());
					});
				});
			</script>
	<form action="" method="post" enctype="multipart/form-data" verified="0" id="huge_it_contact_form_<?php echo $frontendformid; ?>" class="hugeit_form">
		<div id="hugeit-contact-wrapper_<?php echo $frontendformid; ?>" class="<?php echo $style_values['form_radio_size']; ?>-radio <?php echo $style_values['form_checkbox_size']; ?>-checkbox"   >
					<?php $rowim=array_reverse($rowim); ?>
					<div <?php foreach ($rowim as $key=>$rowimages){if($rowimages->hc_left_right == 'right'){echo 'class="multicolumn"';}} ?>>
						<?php foreach ( $hugeit_contact as $key => $row_contact ) {
							$show_title_custom_setting = get_option( 'hugeit_contact_show_title_for_form_' . $row_contact->id );
							switch ( $show_title_custom_setting ) {
								case 'yes' :
									$show_title = true;
									break;

								case 'no' :
									$show_title = false;
									break;

								default :
									$show_title = $style_values['form_show_title'] === 'on' ? true : false;
							}
							if ( $show_title ) {
								echo "<h3>" . $row_contact->name . "</h3>";
							}
						} ?>
						<div class="hugeit-contact-column-block hugeit-contact-block-left" id="hugeit-contact-block-left">
							<?php
								$i=2;
								foreach ($rowim as $key=>$rowimages){
									if($rowimages->hc_left_right == 'left'){
										$inputtype = $rowimages->conttype;
										switch ($inputtype) {
											case 'text':  //1
											?>
												<div class="hugeit-field-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<label class="<?php if($rowimages->hc_input_show_default!='1')echo $rowimages->hc_input_show_default;?>" for="hugeit_preview_textbox_<?php echo $rowimages->id;?>"><?php echo $rowimages->hc_field_label; if($rowimages->hc_required == 'on'){ echo '<em class="required-star">*</em>';} ?> </label>
													<div class="field-block input-text-block <?php if($rowimages->hc_input_show_default=='formsAboveAlign'||$rowimages->hc_input_show_default=='formsInsideAlign')echo $rowimages->hc_input_show_default;?>">
														<input id="hugeit_preview_textbox_<?php echo $rowimages->id;?>" name="huge_it_<?php echo $frontendformid.'_'.$rowimages->id; ?>" type="<?php echo $rowimages->field_type;?>" placeholder="<?php echo $rowimages->name;?>" class="<?php if($rowimages->hc_required == 'on'){echo 'required';}?>"  <?php if($rowimages->description != 'on'){echo 'disabled="disabled"';}?>/>
														<span class="hugeit-error-message"></span>
													</div>
												</div>
											<?php
											break;
											case 'textarea':  //2
											?>
												<div class="hugeit-field-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<label class="<?php if($rowimages->hc_input_show_default!='1')echo $rowimages->hc_input_show_default;?>" for="hugeit_preview_textbox_<?php echo $rowimages->id;?>"><?php echo $rowimages->hc_field_label; if($rowimages->hc_required == 'on'){ echo '<em class="required-star">*</em>';} ?></label>
													<div class="field-block textarea-block <?php if($rowimages->hc_input_show_default=='formsAboveAlign'||$rowimages->hc_input_show_default=='formsInsideAlign')echo $rowimages->hc_input_show_default;?>">
														<textarea style="height:<?php echo $rowimages->hc_other_field;?>px;resize:<?php if($rowimages->field_type=='on'){echo 'vertical';}else{ echo 'none';}?>;" name="huge_it_<?php echo $frontendformid.'_'.$rowimages->id; ?>" id="hugeit_preview_textbox_<?php echo $rowimages->id;?>" <?php if($rowimages->description != 'on'){echo 'disabled="disabled"';}?> class="<?php if($rowimages->hc_required == 'on'){echo 'required';}?>" placeholder="<?php echo $rowimages->name; ?>"></textarea>
														<span class="hugeit-error-message"></span>
													</div>													
												</div>
											<?php 
											break;
											case 'selectbox':  //3
											?>
												<div class="hugeit-field-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<label class="<?php if($rowimages->hc_input_show_default!='1')echo $rowimages->hc_input_show_default;?>" for="hugeit_preview_textbox_<?php echo $rowimages->id;?>"><?php echo $rowimages->hc_field_label; if($rowimages->hc_required == 'on'){ echo '<em class="required-star">*</em>';} ?></label>
													<div class="field-block selectbox-block <?php if($rowimages->hc_input_show_default=='formsAboveAlign'||$rowimages->hc_input_show_default=='formsInsideAlign')echo $rowimages->hc_input_show_default;?>">
														<?php
															 $options=explode(';;',$rowimages->name);
															 $j=0;
															 foreach($options as $option){
															 if($rowimages->hc_other_field==$j){
														?>
															<input type="text" disabled="disabled" class="textholder" value="<?php echo $option; ?>" />
														<?php } $j++; } ?>
														
														<select id="hugeit_preview_textbox_<?php echo $rowimages->id;?>" class="<?php if($rowimages->hc_required == 'on'){echo 'required';}?>" name="huge_it_<?php echo $frontendformid.'_'.$rowimages->id; ?>" >
															<?php
															 $options=explode(';;',$rowimages->name);
															 $i=0;
															 foreach($options as $opt_key=>$option){
															?>
																<option <?php if($rowimages->hc_input_show_default=='formsInsideAlign'&&$opt_key==0) echo 'disabled ';?><?php if($rowimages->hc_other_field==$i){echo 'selected="selected"';} ?>><?php echo $option; ?></option>
															<?php $i++; } ?>
														</select>
														<i class="hugeicons-chevron-down"></i>
														<span class="hugeit-error-message"></span>
													</div>
												</div>
											<?php	
											break;
											case 'checkbox':  //4
											?>
												<div class="hugeit-field-block hugeit-check-field" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<label class="<?php if($rowimages->hc_input_show_default!='1')echo $rowimages->hc_input_show_default;?>" for="hugeit_preview_textbox_<?php echo $rowimages->id;?>"><?php echo $rowimages->hc_field_label; if($rowimages->hc_required == 'on'){ echo '<em class="required-star">*</em>';} ?></label>
													<div class="field-block checkbox-field-block <?php if($rowimages->hc_input_show_default=='formsAboveAlign')echo $rowimages->hc_input_show_default;?>">
														<ul id="hugeit_preview_textbox_<?php echo $rowimages->id;?>" class="hugeit-checkbox-list">
															<?php
															 $options=explode(';;',$rowimages->name);
															 $actives=explode(';;',$rowimages->hc_other_field);
															
															 $i=0;
															 $j=0;
															 foreach($options as $keys=>$option){
															?>
																<li style="width:<?php if($rowimages->field_type!=0){echo 100/intval($rowimages->field_type);}?>%;">
																	<label class="secondary-label">
																		<div class="checkbox-block big">
																		<input <?php if(isset($actives[$j])&&$actives[$j]==''.$keys.''){echo 'checked="checked"';$j++;} ?> type="checkbox" value="<?php echo $option;?>" name="check_<?php echo $frontendformid.'_'.$rowimages->id; ?>[huge_it_<?php echo $frontendformid.'_'.$rowimages->id.'_'.$keys; ?>]" <?php if($rowimages->description != 'on'){echo 'disabled="disabled"';}?>/>
																			<?php if($style_values['form_checkbox_type']=='circle'){ ?>
																				<i class="hugeicons-dot-circle-o active"></i>
																				<i class="hugeicons-circle-o passive"></i>
																			<?php }else{ ?>			
																				<i class="hugeicons-check-square active"></i>
																				<i class="hugeicons-square-o passive"></i>
																			<?php }?>	
																		</div>
																		<span class="sublable"><?php echo $option; ?></span>
																	</label>
																</li>
															<?php $i++; } ?>
														</ul>
														<span class="hugeit-error-message"></span>
													</div>													
												</div>
											<?php
											break;
											case 'radio_box':  //5
											?>
												<div class="hugeit-field-block hugeit-radio-field" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<label class="<?php if($rowimages->hc_input_show_default!='1')echo $rowimages->hc_input_show_default;?>" for="hugeit_preview_textbox_<?php echo $rowimages->id;?>"><?php echo $rowimages->hc_field_label; if($rowimages->hc_required == 'on'){ echo '<em class="required-star">*</em>';}?></label>
													<div class="field-block radio-field-block <?php if($rowimages->hc_input_show_default=='formsAboveAlign')echo $rowimages->hc_input_show_default;?>">
														<ul id="hugeit_preview_textbox_<?php echo $rowimages->id;?>" class="hugeit-radiobox-list">
															<?php
															 $options=explode(';;',$rowimages->name);
															 $i=0;
															 foreach($options as $keys=>$option){
															?>
 																<li style="width:<?php if($rowimages->description!=0){echo 100/$rowimages->description;}?>%;">
																	<label class="secondary-label">
																		<div class="radio-block big">
																		<input <?php if(trim($rowimages->hc_other_field)==$i){echo 'checked="checked"';} ?> type="radio" value="<?php echo $option; ?>" name="huge_it_<?php echo $frontendformid.'_'.$rowimages->id; ?>">
																		
																			<?php if($style_values['form_radio_type']=='circle'){ ?>
																				<i class="hugeicons-dot-circle-o active"></i>
																				<i class="hugeicons-circle-o passive"></i>
																			<?php }else{ ?>			
																				<i class="hugeicons-check-square active"></i>
																				<i class="hugeicons-square-o passive"></i>
																			<?php }?>	
																		</div>
																		<span class="sublable"><?php echo $option; ?></span>
																	</label>
																</li>
															<?php $i++; } ?>
														</ul>
													</div>
												</div>
											<?php 
											break;
											case 'file_box':  //6
											?>
												<script>
												jQuery(document).ready(function(){
													function mbToBytes(mb){
														return Math.round(mb * 1048576 * 100000) / 100000;
													}
													var byteRes=mbToBytes(<?php echo $rowimages->name;?>);
													jQuery("div[rel='huge-contact-field-<?php echo $rowimages->id;?>']").find("input[name='MAX_FILE_SIZE']").attr('value',byteRes);	
												})
													
												</script>
												<div class="hugeit-field-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<label class="<?php if($rowimages->hc_input_show_default!='1')echo $rowimages->hc_input_show_default;?>" for="hugeit_preview_textbox_<?php echo htmlspecialchars($rowimages->id);?>"><?php echo $rowimages->hc_field_label;  if($rowimages->hc_required == 'on'){ echo '<em class="required-star">*</em>';}?></label>
													<div class="field-block file-block <?php if($rowimages->hc_input_show_default=='formsAboveAlign'||$rowimages->hc_input_show_default=='formsInsideAlign')echo $rowimages->hc_input_show_default;?>">
														<input type="text" class="textholder" placeholder="<?php if($rowimages->hc_input_show_default=='formsInsideAlign') echo $rowimages->hc_field_label;?>"/>
														<span class="uploadbutton">
															<?php if($style_values['form_file_has_icon']=='on'):?>
															<?php if($style_values['form_file_icon_position']=="left"){?><i class="<?php echo $style_values['form_file_icon_style']; ?>"></i><?php } ?>
															<?php endif;?>
															<?php echo $style_values['form_file_button_text'];?>
															<?php if($style_values['form_file_has_icon']=='on'):?>
															<?php if($style_values['form_file_icon_position']=="right"){?><i class="<?php echo $style_values['form_file_icon_style']; ?>"></i><?php }?>
															<?php endif;?>
														</span>
														<input type="hidden" name="MAX_FILE_SIZE" value="" />
														<input type="hidden" name="fileTypeArr" value="<?php echo $rowimages->hc_other_field; ?>">
														<input id="hugeit_preview_textbox_<?php echo $rowimages->id;?>" type="file" class="fileUploader <?php if($rowimages->hc_required == 'on'){echo 'required';}?>" name="userfile_<?php echo $rowimages->id;?>"/>
														<span class="hugeit-error-message"></span>
													</div>													
												</div>
											<?php 
											break;
											case 'custom_text':  //7
											?>
												<div class="hugeit-field-block custom-text-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<?php echo $rowimages->name; ?>
												</div>
											<?php 
											break;
											case 'captcha': //8
											?>
												<div class="hugeit-field-block captcha-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>" data-form_id="<?php echo $frontendformid; ?>" data-sitekey="<?php echo $paramssld['form_captcha_public_key']; ?>" data-theme="<?php echo $rowimages->hc_required; ?>" data-cname="<?php echo $rowimages->name; ?>">
													<?php $capPos='right';if($rowimages->hc_input_show_default=='2')$capPos="left";?>
													<div style="float:<?php echo $capPos; ?>;" id="huge_it_captcha_<?php echo $frontendformid; ?>"></div>
													<span style="text-align:right;" class="hugeit-error-message"></span>
												</div>
											<?php
											break;
											case 'buttons': //9										
											?>
												<div class="hugeit-field-block buttons-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<button type="submit" class="submit" id="hugeit_preview_button__submit_<?php echo $rowimages->id;?>" value="Submit">
														<?php if($style_values['form_button_icons_position']=="left" and $style_values['form_button_submit_has_icon']=="on"){?><i class="<?php echo $style_values['form_button_submit_icon_style']; ?>"></i><?php }?>
														<?php echo $rowimages->description; ?>
														<?php if($style_values['form_button_icons_position']=="right" and $style_values['form_button_submit_has_icon']=="on"){?><i class="<?php echo $style_values['form_button_submit_icon_style']; ?>"></i><?php }?>
													</button>
													<?php if($rowimages->hc_required=='checked'):?>
													<button type="reset" class="reset" id="hugeit_preview_button_reset_<?php echo $rowimages->id;?>" value="Reset">												
														<?php if($style_values['form_button_icons_position']=="left" and $style_values['form_button_reset_has_icon']=="on"){?><i class="<?php echo $style_values['form_button_reset_icon_style']; ?>"></i><?php }?>
														<?php echo $rowimages->hc_field_label; ?>
														<?php if($style_values['form_button_icons_position']=="right" and $style_values['form_button_reset_has_icon']=="on"){?><i class="<?php echo $style_values['form_button_reset_icon_style']; ?>"></i><?php }?>
													</button>
													<?php endif;?>
												</div>
											<?php
											break;
											case 'e_mail':  //10
											?>
												<div class="hugeit-field-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<label class="<?php if($rowimages->hc_input_show_default!='1')echo $rowimages->hc_input_show_default;?>" class="<?php if($rowimages->hc_input_show_default!='1')echo $rowimages->hc_input_show_default;?>" for="hugeit_preview_textbox_<?php echo $rowimages->id;?>"><?php echo $rowimages->hc_field_label; if($rowimages->hc_required == 'on'){ echo '<em class="required-star">*</em>';} ?> </label>
													<div class="field-block input-text-block email-block <?php if($rowimages->hc_input_show_default=='formsAboveAlign'||$rowimages->hc_input_show_default=='formsInsideAlign')echo $rowimages->hc_input_show_default;?>">
														<input id="hugeit_preview_textbox_<?php echo $rowimages->id;?>" name="huge_it_<?php echo $frontendformid.'_'.$rowimages->id; ?>" type="email" placeholder="<?php echo $rowimages->name;?>" class="<?php if($rowimages->hc_required == 'on'){echo 'required';}?>" <?php if($rowimages->description != 'on'){echo 'disabled="disabled"';}?> />
														<span class="hugeit-error-message"></span>
													</div>													
												</div>
											<?php
											break;
										}
									}
								}
							?>
						</div>
						<?php if (!hugeit_contact_is_single_column($rowim)): ?>
						<div class="hugeit-contact-column-block hugeit-contact-block-right" id="hugeit-contact-block-right">
														<?php
								$i=2;
								foreach ($rowim as $key=>$rowimages){
									if($rowimages->hc_left_right == 'right'){
										$inputtype = $rowimages->conttype;
										switch ($inputtype) {
											case 'text':  //1
											?>
												<div class="hugeit-field-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<label class="<?php if($rowimages->hc_input_show_default!='1')echo $rowimages->hc_input_show_default;?>" for="hugeit_preview_textbox_<?php echo $rowimages->id;?>"><?php echo $rowimages->hc_field_label; if($rowimages->hc_required == 'on'){ echo '<em class="required-star">*</em>';} ?> </label>
													<div class="field-block input-text-block <?php if($rowimages->hc_input_show_default=='formsAboveAlign'||$rowimages->hc_input_show_default=='formsInsideAlign')echo $rowimages->hc_input_show_default;?>">
														<input id="hugeit_preview_textbox_<?php echo $rowimages->id;?>" name="huge_it_<?php echo $frontendformid.'_'.$rowimages->id; ?>" type="<?php echo $rowimages->field_type;?>" placeholder="<?php echo $rowimages->name;?>" class="<?php if($rowimages->hc_required == 'on'){echo 'required';}?>"  <?php if($rowimages->description != 'on'){echo 'disabled="disabled"';}?>/>
														<span class="hugeit-error-message"></span>
													</div>													
												</div>
											<?php
											break;
											case 'textarea':  //2
											?>
												<div class="hugeit-field-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<label class="<?php if($rowimages->hc_input_show_default!='1')echo $rowimages->hc_input_show_default;?>" for="hugeit_preview_textbox_<?php echo $rowimages->id;?>"><?php echo $rowimages->hc_field_label; if($rowimages->hc_required == 'on'){ echo '<em class="required-star">*</em>';} ?></label>
													<div class="field-block textarea-block <?php if($rowimages->hc_input_show_default=='formsAboveAlign'||$rowimages->hc_input_show_default=='formsInsideAlign')echo $rowimages->hc_input_show_default;?>">
														<textarea style="height:<?php echo $rowimages->hc_other_field;?>px;resize:<?php if($rowimages->field_type=='on'){echo 'vertical';}else{ echo 'none';}?>;" name="huge_it_<?php echo $frontendformid.'_'.$rowimages->id; ?>" id="hugeit_preview_textbox_<?php echo $rowimages->id;?>" <?php if($rowimages->description != 'on'){echo 'disabled="disabled"';}?> class="<?php if($rowimages->hc_required == 'on'){echo 'required';}?>" placeholder="<?php echo $rowimages->name; ?>"></textarea>
														<span class="hugeit-error-message"></span>
													</div>													
												</div>
											<?php 
											break;
											case 'selectbox':  //3
											?>
												<div class="hugeit-field-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<label class="<?php if($rowimages->hc_input_show_default!='1')echo $rowimages->hc_input_show_default;?>" for="hugeit_preview_textbox_<?php echo $rowimages->id;?>"><?php echo $rowimages->hc_field_label; if($rowimages->hc_required == 'on'){ echo '<em class="required-star">*</em>';} ?></label>
													<div class="field-block selectbox-block <?php if($rowimages->hc_input_show_default=='formsAboveAlign'||$rowimages->hc_input_show_default=='formsInsideAlign')echo $rowimages->hc_input_show_default;?>">
														<?php
															 $options=explode(';;',$rowimages->name);
															 $j=0;
															 foreach($options as $option){
															 if($rowimages->hc_other_field==$j){
														?>
															<input type="text" disabled="disabled" class="textholder" value="<?php echo $option; ?>" />
														<?php } $j++; } ?>
														
														<select id="hugeit_preview_textbox_<?php echo $rowimages->id;?>" class="<?php if($rowimages->hc_required == 'on'){echo 'required';}?>" name="huge_it_<?php echo $frontendformid.'_'.$rowimages->id; ?>" >
															<?php
															 $options=explode(';;',$rowimages->name);
															 $i=0;
															 foreach($options as $opt_key=>$option){
															?>
																<option <?php if($rowimages->hc_input_show_default=='formsInsideAlign'&&$opt_key==0) echo 'disabled ';?><?php if($rowimages->hc_other_field==$i){echo 'selected="selected"';} ?>><?php echo $option; ?></option>
															<?php $i++; } ?>
														</select>
														<i class="hugeicons-chevron-down"></i>
														<span class="hugeit-error-message"></span>
													</div>
												</div>
											<?php	
											break;
											case 'checkbox':  //4
											?>
												<div class="hugeit-field-block hugeit-check-field" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<label class="<?php if($rowimages->hc_input_show_default!='1')echo $rowimages->hc_input_show_default;?>" for="hugeit_preview_textbox_<?php echo $rowimages->id;?>"><?php echo $rowimages->hc_field_label; if($rowimages->hc_required == 'on'){ echo '<em class="required-star">*</em>';} ?></label>
													<div class="field-block checkbox-field-block <?php if($rowimages->hc_input_show_default=='formsAboveAlign')echo $rowimages->hc_input_show_default;?>">
														<ul id="hugeit_preview_textbox_<?php echo $rowimages->id;?>" class="hugeit-checkbox-list">
															<?php
															 $options=explode(';;',$rowimages->name);
															 $actives=explode(';;',$rowimages->hc_other_field);															
															 $i=0;
															 $j=0;
															 foreach($options as $keys=>$option){
															?>
																<li style="width:<?php if($rowimages->field_type!=0){echo 100/intval($rowimages->field_type);}?>%;">
																	<label class="secondary-label">
																		<div class="checkbox-block big">
																		<input <?php if(isset($actives[$j])&&$actives[$j]==''.$keys.''){echo 'checked="checked"';$j++;} ?> type="checkbox" name="check_<?php echo $frontendformid.'_'.$rowimages->id; ?>[huge_it_<?php echo $frontendformid.'_'.$rowimages->id.'_'.$keys; ?>]" value="<?php echo $option; ?>" <?php if($rowimages->description != 'on'){echo 'disabled="disabled"';}?>/>
																			<?php if($style_values['form_checkbox_type']=='circle'){ ?>
																				<i class="hugeicons-dot-circle-o active"></i>
																				<i class="hugeicons-circle-o passive"></i>
																			<?php }else{ ?>			
																				<i class="hugeicons-check-square active"></i>
																				<i class="hugeicons-square-o passive"></i>
																			<?php }?>	
																		</div>
																		<span class="sublable"><?php echo $option; ?></span>
																	</label>
																</li>
															<?php $i++; } ?>
														</ul>
														<span class="hugeit-error-message"></span>
													</div>													
												</div>
											<?php
											break;
											case 'radio_box':  //5
											?>
												<div class="hugeit-field-block hugeit-radio-field" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<label class="<?php if($rowimages->hc_input_show_default!='1')echo $rowimages->hc_input_show_default;?>" for="hugeit_preview_textbox_<?php echo $rowimages->id;?>"><?php echo $rowimages->hc_field_label; if($rowimages->hc_required == 'on'){ echo '<em class="required-star">*</em>';}?></label>
													<div class="field-block radio-field-block <?php if($rowimages->hc_input_show_default=='formsAboveAlign')echo $rowimages->hc_input_show_default;?>">
														<ul id="hugeit_preview_textbox_<?php echo $rowimages->id;?>" class="hugeit-radiobox-list">
															<?php
															 $options=explode(';;',$rowimages->name);
															 $i=0;
															 foreach($options as $keys=>$option){?>
																<li style="width:<?php if($rowimages->description!=0){echo 100/$rowimages->description;}?>%;">
																	<label class="secondary-label">
																		<div class="radio-block big">
																		<input <?php if(trim($rowimages->hc_other_field)==$i){echo 'checked="checked"';} ?> type="radio" value="<?php echo $option; ?>" name="huge_it_<?php echo $frontendformid.'_'.$rowimages->id; ?>">
																		
																			<?php if($style_values['form_radio_type']=='circle'){ ?>
																				<i class="hugeicons-dot-circle-o active"></i>
																				<i class="hugeicons-circle-o passive"></i>
																			<?php }else{ ?>			
																				<i class="hugeicons-check-square active"></i>
																				<i class="hugeicons-square-o passive"></i>
																			<?php }?>	
																		</div>
																		<span class="sublable"><?php echo $option; ?></span>
																	</label>
																</li>
															<?php $i++; } ?>
														</ul>
													</div>
												</div>
											<?php 
											break;
											case 'file_box':  //6
											?>
												<script>
												jQuery(document).ready(function(){
													function mbToBytes(mb){
														return Math.round(mb * 1048576 * 100000) / 100000;
													}
													var byteRes=mbToBytes(<?php echo $rowimages->name;?>);
													jQuery(".hugeit-contact-column-block div[rel='huge-contact-field-<?php echo $rowimages->id;?>']").find("input[name='MAX_FILE_SIZE']").attr('value',byteRes);
												});													
												</script>
												<div class="hugeit-field-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<label class="<?php if($rowimages->hc_input_show_default!='1')echo $rowimages->hc_input_show_default;?>" for="hugeit_preview_textbox_<?php echo htmlspecialchars($rowimages->id);?>"><?php echo $rowimages->hc_field_label;  if($rowimages->hc_required == 'on'){ echo '<em class="required-star">*</em>';} ?></label>
													<div class="field-block file-block <?php if($rowimages->hc_input_show_default=='formsAboveAlign'||$rowimages->hc_input_show_default=='formsInsideAlign')echo $rowimages->hc_input_show_default;?>">
														<input type="text" class="textholder" placeholder="<?php if($rowimages->hc_input_show_default=='formsInsideAlign') echo $rowimages->hc_field_label;?>"/>
														<span class="uploadbutton">
															<?php if($style_values['form_file_has_icon']=='on'):?>
															<?php if($style_values['form_file_icon_position']=="left"){?><i class="<?php echo $style_values['form_file_icon_style']; ?>"></i><?php } ?>
															<?php endif;?>
															<?php echo $style_values['form_file_button_text'];?>
															<?php if($style_values['form_file_has_icon']=='on'):?>
															<?php if($style_values['form_file_icon_position']=="right"){?><i class="<?php echo $style_values['form_file_icon_style']; ?>"></i><?php }?>
															<?php endif;?>
														</span>
														<input type="hidden" name="MAX_FILE_SIZE" value="" />
														<input type="hidden" name="fileTypeArr" value="<?php echo $rowimages->hc_other_field; ?>">
														<input id="hugeit_preview_textbox_<?php echo $rowimages->id;?>" type="file" class="fileUploader <?php if($rowimages->hc_required == 'on'){echo 'required';}?>" name="userfile_<?php echo $rowimages->id;?>"/>
														<span class="hugeit-error-message"></span>
													</div>
												</div>
											<?php 
											break;
											case 'custom_text':  //7
											?>
												<div class="hugeit-field-block custom-text-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<?php echo $rowimages->name; ?>
												</div>
											<?php 
											break;
											case 'captcha': //8
											?>
												<div class="hugeit-field-block captcha-block custom-text-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>" data-form_id="<?php echo $frontendformid; ?>" data-sitekey="<?php echo $paramssld['form_captcha_public_key']; ?>" data-theme="<?php echo $rowimages->hc_required; ?>" data-cname="<?php echo $rowimages->name; ?>">
													<?php $capPos='right';if($rowimages->hc_input_show_default=='2')$capPos="left";?>
													<div style="float:<?php echo $capPos; ?>;" id="huge_it_captcha_<?php echo $frontendformid; ?>"></div>
													<span style="text-align:right;" class="hugeit-error-message"></span>
												</div>
											<?php
											break;
											case 'buttons': //9									

											?>
												<div class="hugeit-field-block buttons-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<button type="submit" class="submit" id="hugeit_preview_button__submit_<?php echo $rowimages->id;?>" value="Submit">
														<?php if($style_values['form_button_icons_position']=="left" and $style_values['form_button_submit_has_icon']=="on"){?><i class="<?php echo $style_values['form_button_submit_icon_style']; ?>"></i><?php }?>
														<?php echo $rowimages->description; ?>
														<?php if($style_values['form_button_icons_position']=="right" and $style_values['form_button_submit_has_icon']=="on"){?><i class="<?php echo $style_values['form_button_submit_icon_style']; ?>"></i><?php }?>
													</button>
													<?php if($rowimages->hc_required=='checked'):?>
													<button type="reset" class="reset" id="hugeit_preview_button_reset_<?php echo $rowimages->id;?>" value="Reset">											
														<?php if($style_values['form_button_icons_position']=="left" and $style_values['form_button_reset_has_icon']=="on"){?><i class="<?php echo $style_values['form_button_reset_icon_style']; ?>"></i><?php }?>
														<?php echo $rowimages->hc_field_label; ?>
														<?php if($style_values['form_button_icons_position']=="right" and $style_values['form_button_reset_has_icon']=="on"){?><i class="<?php echo $style_values['form_button_reset_icon_style']; ?>"></i><?php }?>
													</button>
													<?php endif;?>
												</div>
											<?php
											break;
											case 'e_mail':  //10
											?>
												<div class="hugeit-field-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<label class="<?php if($rowimages->hc_input_show_default!='1')echo $rowimages->hc_input_show_default;?>" for="hugeit_preview_textbox_<?php echo $rowimages->id;?>"><?php echo $rowimages->hc_field_label; if($rowimages->hc_required == 'on'){ echo '<em class="required-star">*</em>';} ?> </label>
													<div class="field-block input-text-block email-block <?php if($rowimages->hc_input_show_default=='formsAboveAlign'||$rowimages->hc_input_show_default=='formsInsideAlign')echo $rowimages->hc_input_show_default;?>">
														<input id="hugeit_preview_textbox_<?php echo $rowimages->id;?>" name="huge_it_<?php echo $frontendformid.'_'.$rowimages->id; ?>" type="email" placeholder="<?php echo $rowimages->name;?>" class="<?php if($rowimages->hc_required == 'on'){echo 'required';}?>" <?php if($rowimages->description != 'on'){echo 'disabled="disabled"';}?>/>
														<span class="hugeit-error-message"></span>
													</div>
												</div>
											<?php
											break;
										}
									}
								}
							?>	
						</div>
						<?php endif ?>
						<div class="clear"></div>
						</div>
					</div>
		<input type="hidden" value="hc_email_r" name="hc_email_r">
		<input type="hidden" value="ok" name="submitok">
	</form>
<script>
		jQuery.fn.ForceNumericOnly =function(){
		    return this.each(function()		    {
		        jQuery(this).keydown(function(e){
		            var key = e.charCode || e.keyCode || 0;
		            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
		            // home, end, period, and numpad decimal
		            return (
		                key == 8 || 
		                key == 9 ||
		                key == 13 ||
		                key == 46 ||
		                key == 110 ||
		                key == 190 ||
		                (key >= 35 && key <= 40) ||
		                (key >= 48 && key <= 57) ||
		                (key >= 96 && key <= 105));
		        });
		    });
		};
	jQuery(document).ready(function(){
		var requiredError='<?php echo $huge_it_gen_opt[36]->value;?>';
        var captchaError='<?php echo $huge_it_gen_opt[37]->value;?>';
        var emailError='<?php echo $huge_it_gen_opt[20]->value;?>';
        var uploadTypeError='<?php echo $huge_it_gen_opt[27]->value;?>';
        var uploadSizeError='<?php echo $huge_it_gen_opt[28]->value;?>';
        function isValidEmailAddress(emailAddress) {
			    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
			    return pattern.test(emailAddress);
		}
		function Validate(oForm,_validFileExtensions) {
		    var arrInputs = document.getElementsByTagName("input");
		    for (var i = 0; i < arrInputs.length; i++) {
		        var oInput = arrInputs[i];
		        if (oInput.type == "file") {
		            var sFileName = oInput.value;
		            if (sFileName.length > 0) {
		                var blnValid = false;
		                for (var j = 0; j < _validFileExtensions.length; j++) {
		                    var sCurExtension = _validFileExtensions[j];
		                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
		                        blnValid = true;
		                        break;
		                    }
		                }		                
		                if (!blnValid) {
		                    return false;
		                }
		            }
		        }
		    }		  
		    return true;
		}
		
		jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('.hugeit-field-block').not('.buttons-block').not('.captcha-block').each(function(){
			if(jQuery(this).find('div.ready-phone-block input.readyPhone').attr('type')=='tel'){
				phone_field=jQuery(this).find('div.ready-phone-block input.readyPhone');
				if(phone_field.attr('data-required')=='required'){
					phone_field.on('blur',function(){
	        			if(jQuery(this).val().trim()==''){
	        				jQuery(this).parents('.hugeit-field-block').find('.hugeit-error-message').text(requiredError);
	        				jQuery(this).parents('.hugeit-field-block').find('label').addClass('error');
	        				jQuery(this).parents('.hugeit-field-block').find('label>em.required-star').addClass('error');
	        			}else{
	        				jQuery(this).parents('.hugeit-field-block').find('.hugeit-error-message').text('');
	        				jQuery(this).parents('.hugeit-field-block').find('label').removeClass('error');
	        				jQuery(this).parents('.hugeit-field-block').find('label>em.required-star').removeClass('error');
	        			}
	        		});
				}
				
				phone_field.on('keypress keyup change blur',function(){
        			var phoneVal=jQuery(this).val();
        			jQuery(this).parents('.field-block').find('input[type="hidden"]').val(phoneVal);
        			//alert(phoneVal)
        		})
			}
        	if(jQuery(this).find('div.input-text-block >input').hasClass('required')){
        		var text_emailField=jQuery(this).find('input');
        		text_emailField.on('blur',function(){
        			if(jQuery(this).val().trim()==''){
        				jQuery(this).parent().find('.hugeit-error-message').text(requiredError);
        				jQuery(this).parent().parent().find('label').addClass('error');
        				jQuery(this).parent().parent().find('label>em.required-star').addClass('error');
        			}else{
        				jQuery(this).parent().find('.hugeit-error-message').text('');
        				jQuery(this).parent().parent().find('label').removeClass('error');
        				jQuery(this).parent().parent().find('label>em.required-star').removeClass('error');
        			}
        		})
        	}
        	if(jQuery(this).find('div.selectbox-block >select').hasClass('required')){
        		var selectField=jQuery(this).find('div.selectbox-block >select');
        		selectField.on('blur change',function(){
	        		if(selectField.val()==null){
	    				jQuery(this).parent().find('.hugeit-error-message').text(requiredError);
	    				jQuery(this).parent().parent().find('label').addClass('error');
	    				jQuery(this).parent().parent().find('label>em.required-star').addClass('error');
	    				errorsAllow='no';
	    			}else{
	    				jQuery(this).parent().find('.hugeit-error-message').text('');
	    				jQuery(this).parent().parent().find('label').removeClass('error');
	    			}
    			});	        		
        	}
        	if(jQuery(this).find('div.input-name-block >input.pl_name').hasClass('required')){
        		var text_fullnameField=jQuery(this).find('input.pl_name');
        		var text_fullnameField2=jQuery(this).find('input.pl_surname');
        		text_fullnameField.on('blur',function(){
        			if(jQuery(this).val().trim()==''||text_fullnameField2.val().trim()==''){
        				jQuery(this).parent().parent().find('.hugeit-error-message').text(requiredError);
        				jQuery(this).parent().parent().find('label').addClass('error');
        				jQuery(this).parent().parent().find('label>em.required-star').addClass('error');
        			}else{
        				jQuery(this).parent().parent().find('.hugeit-error-message').text('');
        				jQuery(this).parent().parent().find('label').removeClass('error');
        				jQuery(this).parent().parent().find('label>em.required-star').removeClass('error');
        			}
        		});
        		text_fullnameField2.on('blur',function(){
        			if(jQuery(this).val().trim()==''||text_fullnameField.val().trim()==''){
        				jQuery(this).parent().parent().find('.hugeit-error-message').text(requiredError);
        				jQuery(this).parent().parent().find('label').addClass('error');
        				jQuery(this).parent().parent().find('label>em.required-star').addClass('error');
        			}else{
        				jQuery(this).parent().parent().find('.hugeit-error-message').text('');
        				jQuery(this).parent().parent().find('label').removeClass('error');
        				jQuery(this).parent().parent().find('label>em.required-star').removeClass('error');
        			}
        		});
        	}
        	if(jQuery(this).find('div.textarea-block >textarea').hasClass('required')){
        		var textarea_field=jQuery(this).find('textarea');
        		textarea_field.on('blur',function(){
        			if(jQuery(this).val().trim()==''){
        				jQuery(this).parent().find('.hugeit-error-message').text(requiredError);
        				jQuery(this).parent().parent().find('label').addClass('error');
        				jQuery(this).parent().parent().find('label>em.required-star').addClass('error');
        			}else{
        				jQuery(this).parent().find('.hugeit-error-message').text('');
        				jQuery(this).parent().parent().find('label').removeClass('error');
        				jQuery(this).parent().parent().find('label>em.required-star').removeClass('error');
        			}
        		})
        	}
        	if(jQuery(this).find('div.email-block >input').attr('type')=='email'){
        		var emailField=jQuery(this).find('input');
        		emailField.on('blur',function(){
        			if(jQuery(this).val()!=''){
        				if(!isValidEmailAddress(jQuery(this).val())){
	        				jQuery(this).parent().find('.hugeit-error-message').text(emailError);
	        				jQuery(this).parent().parent().find('label').addClass('error');
	        				jQuery(this).parent().parent().find('label>em.required-star').addClass('error');
	        			}else{
	        				jQuery(this).parent().find('.hugeit-error-message').text('');
	        				jQuery(this).parent().parent().find('label').removeClass('error');
	        				jQuery(this).parent().parent().find('label>em.required-star').removeClass('error');
	        			}
        			}
        		})
        	}
        	if(jQuery(this).find('div.file-block >input[type="file"]').attr('type')=='file'){
        		var fileInput=jQuery(this).find('input[type="file"]');
        		var maxSize = fileInput.parent().find('input[name="MAX_FILE_SIZE"]').val();        		
        		fileInput.on('blur',function(){
        			var typeStr = jQuery(this).parent().find('input[name="fileTypeArr"]').val().trim();
        			typeStr = typeStr.replace(/\s+/g, '');
					var _validFileExtensions = typeStr.split(",");
					if(fileInput.val()!=''){
						var validREsult=Validate(jQuery('#huge_it_contact_form_<?php echo $frontendformid; ?>'),_validFileExtensions);
						if(!validREsult){
							jQuery(this).parent().find('.hugeit-error-message').text(uploadTypeError);
							jQuery(this).parent().parent().find('label').addClass('error');
							jQuery(this).parent().parent().find('label>em.required-star').addClass('error');
							jQuery(this).parent().parent().find('label>em.required-star').removeClass('error');
						}else{
							if(fileInput.val()!=''){
			        			var fileSize = fileInput.get(0).files[0].size;
			    			}
			    			if(jQuery(this).hasClass('required')&&jQuery(this).val().trim()==''){
			    				jQuery(this).parent().find('.hugeit-error-message').text(requiredError);
			    				jQuery(this).parent().parent().find('label').addClass('error');
			    				jQuery(this).parent().parent().find('label>em.required-star').addClass('error');
			    			}else if(fileSize>maxSize){
			    				jQuery(this).parent().find('.hugeit-error-message').text(uploadSizeError);
			    				jQuery(this).parent().parent().find('label').addClass('error');
			    				jQuery(this).parent().parent().find('label>em.required-star').addClass('error');
			    			}else{
			    				jQuery(this).parent().find('.hugeit-error-message').text('');
			    				jQuery(this).parent().parent().find('label').removeClass('error');
			    				jQuery(this).parent().parent().find('label>em.required-star').removeClass('error');
			    			}
						}
					}else{
						if(jQuery(this).hasClass('required')&&jQuery(this).val().trim()==''){
		    				jQuery(this).parent().find('.hugeit-error-message').text(requiredError);
		    				jQuery(this).parent().parent().find('label').addClass('error');
		    				jQuery(this).parent().parent().find('label>em.required-star').addClass('error');
		    			}else{
		    				jQuery(this).parent().find('.hugeit-error-message').text('');
		    				jQuery(this).parent().parent().find('label').removeClass('error');
		    				jQuery(this).parent().parent().find('label>em.required-star').removeClass('error');
		    			}
					}		    			
        		})
        	}       		
        });
		var captchaExists='no';
	jQuery( "#huge_it_contact_form_<?php echo $frontendformid; ?>" ).on( "submit", function(e){
	        e.preventDefault();
	        var errorsAllow='yes';
			var nVer = navigator.appVersion;
			var nAgt = navigator.userAgent;
			var browserName  = navigator.appName;
			var fullVersion  = ''+parseFloat(navigator.appVersion); 
			var majorVersion = parseInt(navigator.appVersion,10);
			var nameOffset,verOffset,ix;

		// In Opera 15+, the true version is after "OPR/" 
		if ((verOffset=nAgt.indexOf("OPR/"))!=-1) {
		 browserName = "Opera";
		 fullVersion = nAgt.substring(verOffset+4);
		}
		// In older Opera, the true version is after "Opera" or after "Version"
		else if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
		 browserName = "Opera";
		 fullVersion = nAgt.substring(verOffset+6);
		 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
		   fullVersion = nAgt.substring(verOffset+8);
		}
		// In MSIE, the true version is after "MSIE" in userAgent
		else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
		 browserName = "MSIE";
		 fullVersion = nAgt.substring(verOffset+5);
		}
		// In Chrome, the true version is after "Chrome" 
		else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
		 browserName = "Chrome";
		 fullVersion = nAgt.substring(verOffset+7);
		}
		// In Safari, the true version is after "Safari" or after "Version" 
		else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
		 browserName = "Safari";
		 fullVersion = nAgt.substring(verOffset+7);
		 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
		   fullVersion = nAgt.substring(verOffset+8);
		}
		// In Firefox, the true version is after "Firefox" 
		else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
		 browserName = "Firefox";
		 fullVersion = nAgt.substring(verOffset+8);
		}
		// In most other browsers, "name/version" is at the end of userAgent 
		else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) < 
		          (verOffset=nAgt.lastIndexOf('/')) ) 
		{
		 browserName = nAgt.substring(nameOffset,verOffset);
		 fullVersion = nAgt.substring(verOffset+1);
		 if (browserName.toLowerCase()==browserName.toUpperCase()) {
		  browserName = navigator.appName;
		 }
		}
		// trim the fullVersion string at semicolon/space if present
		if ((ix=fullVersion.indexOf(";"))!=-1)
		   fullVersion=fullVersion.substring(0,ix);
		if ((ix=fullVersion.indexOf(" "))!=-1)
		   fullVersion=fullVersion.substring(0,ix);

		majorVersion = parseInt(''+fullVersion,10);
		if (isNaN(majorVersion)) {
			 fullVersion  = ''+parseFloat(navigator.appVersion); 
			 majorVersion = parseInt(navigator.appVersion,10);
		}
////
      jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('.hugeit-field-block').not('.buttons-block').each(function(){
	        	if(jQuery(this).find('div.input-text-block >input').hasClass('required')){
	        		var text_emailField=jQuery(this).find('input');
	        			if(text_emailField.val().trim()==''){
	        				text_emailField.parent().find('.hugeit-error-message').text(requiredError);
	        				text_emailField.parent().parent().find('label').addClass('error');
	        				text_emailField.parent().parent().find('label>em.required-star').addClass('error');
	        				errorsAllow='no';
	        			}else{
	        				text_emailField.parent().find('.hugeit-error-message').text('');
	        				text_emailField.parent().parent().find('label').removeClass('error');
	        			}
	        	}
	        	if(jQuery(this).find('div.ready-phone-block input.readyPhone').attr('type')=='tel'){
					phone_field=jQuery(this).find('div.ready-phone-block input.readyPhone');
					if(phone_field.attr('data-required')=='required'){
		        			if(phone_field.val().trim()==''){
		        				phone_field.parents('.hugeit-field-block').find('.hugeit-error-message').text(requiredError);
		        				phone_field.parents('.hugeit-field-block').find('label').addClass('error');
		        				phone_field.parents('.hugeit-field-block').find('label>em.required-star').addClass('error');
		        				errorsAllow='no';
		        			}else{
		        				phone_field.parents('.hugeit-field-block').find('.hugeit-error-message').text('');
		        				phone_field.parents('.hugeit-field-block').find('label').removeClass('error');
		        				phone_field.parents('.hugeit-field-block').find('label>em.required-star').removeClass('error');
		        			}
					}
				}
				if(jQuery(this).find('div.license-block input#ifChecked').hasClass('required')){
					license_field=jQuery(this).find('div.license-block input[type="checkbox"]');
					if(!license_field.is(':checked')){
		        		license_field.parents('.hugeit-field-block').find('.hugeit-error-message').text('Please tick on checkbox');	
		        		errorsAllow='no';
					}else{
						license_field.parents('.hugeit-field-block').find('.hugeit-error-message').text('');
					}
				}
	        	if(jQuery(this).find('div.input-name-block >input.pl_name').hasClass('required')){
	        		var text_fullnameField=jQuery(this).find('input.pl_name');
	        		var text_fullnameField2=jQuery(this).find('input.pl_surname');
	        			if(text_fullnameField==''||text_fullnameField2.val().trim()==''){
	        				text_fullnameField.parent().parent().find('.hugeit-error-message').text(requiredError);
	        				text_fullnameField.parent().parent().find('label').addClass('error');
	        				text_fullnameField.parent().parent().find('label>em.required-star').addClass('error');
	        				errorsAllow='no';
	        			}else{
	        				text_fullnameField.parent().parent().find('.hugeit-error-message').text('');
	        				text_fullnameField.parent().parent().find('label').removeClass('error');
	        				text_fullnameField.parent().parent().find('label>em.required-star').removeClass('error');
	        			}
	        			if(text_fullnameField2.val().trim()==''||text_fullnameField.val().trim()==''){
	        				text_fullnameField2.parent().parent().find('.hugeit-error-message').text(requiredError);
	        				text_fullnameField2.parent().parent().find('label').addClass('error');
	        				text_fullnameField2.parent().parent().find('label>em.required-star').addClass('error');
	        				errorsAllow='no';
	        			}else{
	        				text_fullnameField2.parent().parent().find('.hugeit-error-message').text('');
	        				text_fullnameField2.parent().parent().find('label').removeClass('error');
	        				text_fullnameField2.parent().parent().find('label>em.required-star').removeClass('error');
	        			}	        		
	        	}
	        	if(jQuery(this).find('div.textarea-block >textarea').hasClass('required')){
	        		var textarea_field=jQuery(this).find('textarea');
	        			if(textarea_field.val().trim()==''){
	        				textarea_field.parent().find('.hugeit-error-message').text(requiredError);
	        				textarea_field.parent().parent().find('label').addClass('error');
	        				textarea_field.parent().parent().find('label>em.required-star').addClass('error');
	        				errorsAllow='no';
	        			}else{
	        				textarea_field.parent().find('.hugeit-error-message').text('');
	        				textarea_field.parent().parent().find('label').removeClass('error');
	        			}
	        	}
	        	if(jQuery(this).find('div.email-block >input').attr('type')=='email'){
	        		var emailField=jQuery(this).find('input');
	        		emailField.on('blur',function(){
	        			if(jQuery(this).val()!=''){
	        				if(!isValidEmailAddress(jQuery(this).val())){
		        				jQuery(this).parent().find('.hugeit-error-message').text(emailError);
		        				jQuery(this).parent().parent().find('label>em.required-star').addClass('error');
		        				errorsAllow='no';
		        			}else{
		        				jQuery(this).parent().find('.hugeit-error-message').text('');
		        			}
	        			}
	        		})
	        	}
	        	if(jQuery(this).find('div.selectbox-block >select').hasClass('required')){
	        		var selectField=jQuery(this).find('div.selectbox-block >select');
	        		if(selectField.val()==null){
        				selectField.parent().find('.hugeit-error-message').text(requiredError);
	    				selectField.parent().parent().find('label').addClass('error');
	    				selectField.parent().parent().find('label>em.required-star').addClass('error');
	    				errorsAllow='no';
        			}else{
        				selectField.parent().find('.hugeit-error-message').text('');
        				selectField.parent().parent().find('label').removeClass('error');
        			}	        		
	        	}
	        	if(jQuery(this).find('div.file-block >input[type="file"]').attr('type')=='file'){
	        		var fileInput=jQuery(this).find('input[type="file"]');
	        		var maxSize = fileInput.parent().find('input[name="MAX_FILE_SIZE"]').val();        		
	        			var typeStr = fileInput.parent().find('input[name="fileTypeArr"]').val().trim();
	        			typeStr = typeStr.replace(/\s+/g, '');
						var _validFileExtensions = typeStr.split(",");					
						if(fileInput.val()!=''){
							var validREsult=Validate(jQuery('#huge_it_contact_form_<?php echo $frontendformid; ?>'),_validFileExtensions);
							if(!validREsult){
								fileInput.parent().find('.hugeit-error-message').text(uploadTypeError);
								fileInput.parent().parent().find('label').addClass('error');
								fileInput.parent().parent().find('label>em.required-star').addClass('error');
							    errorsAllow='no';
							}else{
								if(fileInput.val()!=''){
				        			var fileSize = fileInput.get(0).files[0].size;
				    			}
				    			if(fileInput.hasClass('required')&&fileInput.val().trim()==''){
				    				fileInput.parent().find('.hugeit-error-message').text(requiredError);
				    				fileInput.parent().parent().find('label').addClass('error');
				    				fileInput.parent().parent().find('label>em.required-star').addClass('error');
				    			    errorsAllow='no';
				    			}else if(fileSize>maxSize){
				    				fileInput.parent().find('.hugeit-error-message').text(uploadSizeError);
				    				fileInput.parent().parent().find('label').addClass('error');
				    				fileInput.parent().parent().find('label>em.required-star').addClass('error');
				    				errorsAllow='no';
				    			}else{
				    				fileInput.parent().find('.hugeit-error-message').text('');
				    				fileInput.parent().parent().find('label').removeClass('error');
				    			}
							}
						}else{
							if(fileInput.hasClass('required')&&fileInput.val().trim()==''){
			    				fileInput.parent().find('.hugeit-error-message').text(requiredError);
			    				fileInput.parent().parent().find('label').addClass('error');
			    				fileInput.parent().parent().find('label>em.required-star').addClass('error');
			    				errorsAllow='no';
			    			}else{
			    				fileInput.parent().find('.hugeit-error-message').text('');
			    				fileInput.parent().parent().find('label').removeClass('error');
			    			}
						}		    			
	        	}
	        	if(jQuery(this).hasClass('captcha-block')){
	        		captchaExists='yes';
	        	}       		
	        });
	        if(captchaExists=='yes'){
	        	if(jQuery('#huge_it_contact_form_<?php echo $frontendformid; ?>').attr('verified')==0){
					if(!jQuery(this).find('div.captcha-block #huge_it_captcha_<?php echo $frontendformid; ?>').find('span').length){
	        			jQuery(this).find('div.captcha-block #huge_it_captcha_<?php echo $frontendformid; ?>').append('<span style="text-align:right;" class="hugeit-error-message">'+captchaError+'</span>')
	        		}		 			
		 			errorsAllow='no';
		 		}else{
		 			jQuery(this).find('div.captcha-block').find('span.hugeit-error-message').text('');
		 		}
	        } 		 		
	 		if(errorsAllow=='yes'){
				var fd = new FormData();
		        var files_data = jQuery('.fileUploader');
		        var self=jQuery(this);
		        var postData=self.serialize();
		        jQuery.each(jQuery(files_data), function(i, obj) {
		            jQuery.each(obj.files,function(j,file){
		                fd.append(obj.name, file);
		            })
		        });       

		        fd.append('action', 'hugeit_validation_action');
		        fd.append('formId', '<?php echo $frontendformid; ?>');
		        fd.append('browser',browserName);
		        fd.append('nonce', huge_it_obj.nonce);
		        fd.append('postData', postData);
	            jQuery.ajax({
		            type: 'POST',
		            url: '<?php echo admin_url("admin-ajax.php"); ?>',
		            nonce:huge_it_obj.nonce,
		            data: fd,
		            contentType: false,
		            processData: false,
		            beforeSend: function(){
		            	var buttonsHeightBs=jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('div.buttons-block').height();
						var buttonsWidthBs=jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('div.buttons-block').width();
						jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('div.buttons-block').append('<span class="huge_it_button_overlay"style="line-height:'+buttonsHeightBs+'px;height:'+buttonsHeightBs+'px;width:'+buttonsWidthBs+'px;"><img id="buttLoad" src="<?php echo plugins_url( "images/279.GIF", __FILE__ ); ?>"></span>');
					},
		            success: function(response){
		            	var response = jQuery.parseJSON(response);
						if(response.markedAsSpam){
							jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('.huge_it_button_overlay').css('display','none');
							var buttonField=response.spamButton;
							jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-error-message').empty();
							jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('.hugeit-field-block').find('label').removeClass('error');
							document.getElementById("huge_it_contact_form_<?php echo $frontendformid; ?>").reset();
							var buttonsHeight=jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('div[rel="'+buttonField+'"]').height()+3;
							var buttonsWidth=jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('div[rel="'+buttonField+'"]').width()-2;
							var spamText=response.markedAsSpam;
							jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('div[rel="'+buttonField+'"]').empty().append('<span class="huge_it_spam_msg"style="line-height:'+buttonsHeight+'px;height:'+buttonsHeight+'px;width:'+buttonsWidth+'px;"><span>'+spamText+'</span></span>');
						}else if(response.errors){

							jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('.huge_it_button_overlay').css('display','none');
							if(captchaExists=='yes'){
								grecaptcha.reset(recaptchas[<?php echo $frontendformid; ?>]);
							}
							jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-error-message').empty();
							jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('.hugeit-field-block').find('label').removeClass('error');
							jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('.hugeit-field-block').find('label>em.required-star').removeClass('error');

							jQuery.each( response.errors, function( key, value ) {
								jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('div [rel="'+key+'"]').find('span.hugeit-error-message').append(value);
								jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('div [rel="'+key+'"]').find('label').addClass('error');
								jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('div [rel="'+key+'"]').find('label>em.required-star').addClass('error');
							});
						}else if(response.success){
							if(response.afterSubmit=='print_success_message'){
								jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('.huge_it_button_overlay').css('display','none');
								var buttonField=response.buttons;
								var successText=response.success;
								var buttonsHeight=jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('div[rel="'+buttonField+'"]').height()+3;
								var buttonsWidth=jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('div[rel="'+buttonField+'"]').width()-2;
								jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('div[rel="'+buttonField+'"]').empty().append('<span class="huge_it_success_msg"style="line-height:'+buttonsHeight+'px;height:'+buttonsHeight+'px;width:'+buttonsWidth+'px;"><span>'+successText+'</span></span>');
								document.getElementById("huge_it_contact_form_<?php echo $frontendformid; ?>").reset();
								jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-error-message').empty();
								jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('.hugeit-field-block').find('label').removeClass('error');
							}else if(response.afterSubmit=='refresh_page'){
								jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('.huge_it_button_overlay').css('display','none');
								location.reload();
							}else if(response.afterSubmit=='go_to_url'){
								jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('.huge_it_button_overlay').css('display','none');
								document.getElementById("huge_it_contact_form_<?php echo $frontendformid; ?>").reset();
								jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-error-message').empty();
								jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('.hugeit-field-block').find('label').removeClass('error');
								var redirectUrl=response.afterSubmitUrl;
								window.location.href=redirectUrl;
							}
								
						}
		            }
		        });
	 		}
   		});
	 	jQuery( "#huge_it_contact_form_<?php echo $frontendformid; ?>" ).on( "reset", function() {
	 		if(captchaExists=='yes'){
	 			grecaptcha.reset(recaptchas[<?php echo $frontendformid; ?>]);
	 		}
	 		jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?> .hugeit-error-message').empty();
			jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('.hugeit-field-block').find('label').removeClass('error');
			jQuery('#hugeit-contact-wrapper_<?php echo $frontendformid; ?>').find('.hugeit-field-block').find('label>em.required-star').removeClass('error');
	 	});

									

	})
</script>	
<?php  
	return ob_get_clean();
}
