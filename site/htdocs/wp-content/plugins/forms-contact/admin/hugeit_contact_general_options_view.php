<?php
if(! defined( 'ABSPATH' )) exit;
if (function_exists('current_user_can'))
    if (!current_user_can('manage_options')) {
        die('Access Denied');
    }
if (!function_exists('current_user_can')) {
    die('Access Denied');
}
require_once("hugeit_free_version.php");
function hugeit_contact_html_show_settings($param_values) {
	$path_site = plugins_url("Front_images", __FILE__); ?>
	<div class="wrap">
		<?php hugeit_contact_drawFreeBanner();?>
		<div id="poststuff">
			<div id="post-body-content">
				<div id="post-body-heading">
					<h3>General Options</h3>
					<a onclick="document.getElementById('adminForm').submit()" class="save-hugeit_contact-options button-primary">Save</a>
				</div>
				<div class="options-block">
				<form action="admin.php?page=hugeit_forms_general_options&task=save" method="post" id="adminForm" name="adminForm">
					<div class="hugeit-contact-general-options-column hugeit-contact-general-options-left">
						<div class="hugeit-contact-general-options-block">
							<h3>Your Form Settings</h3>
							<div>
								<label for="form_adminstrator_user_name">Send Emails From Name</label>
								<input type="text" id="form_adminstrator_user_name" name="params[form_adminstrator_user_name]" value="<?php echo $param_values['form_adminstrator_user_name']; ?>" />
							</div>
							<div>
								<label for="form_adminstrator_user_mail">Send Emails From Email</label>
								<input type="text" id="form_adminstrator_user_mail" name="params[form_adminstrator_user_mail]" value="<?php echo $param_values['form_adminstrator_user_mail']; ?>" />
							</div>
							<div>
								<label for="form_captcha_public_key">Captcha Public Key</label>
								<input type="text" id="form_captcha_public_key" name="params[form_captcha_public_key]" value="<?php echo $param_values['form_captcha_public_key']; ?>" />
							</div>
							<div>
								<label for="form_captcha_private_key">Captcha Private Key</label>
								<input type="text" id="form_captcha_private_key" name="params[form_captcha_private_key]" value="<?php echo $param_values['form_captcha_private_key']; ?>" />
							</div>
							<div>
								<label for="form_save_to_database">Save Submissions To Database</label>
								<input type="hidden" value="off" name="params[form_save_to_database]" />
								<input type="checkbox" id="form_save_to_database" <?php if($param_values['form_save_to_database']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[form_save_to_database]" value="on" />
							</div>
						</div>
						<div class="hugeit-contact-general-options-block brlable" >
							<h3>Form Messages</h3>
							<div>
								<label for="msg_send_success">Sender's message was sent successfully</label>
								<input name="params[msg_send_success]" type="text" id="msg_send_success" value="<?php echo $param_values['msg_send_success']; ?>" />
							</div>
							<div>
								<label for="msg_send_false">Sender's message was failed to send</label>
								<input name="params[msg_send_false]" type="text" id="msg_send_false" value="<?php echo $param_values['msg_send_false']; ?>" />
							</div>
							<div>
								<label for="msg_refered_spam">Submission was referred to as spam</label>
								<input name="params[msg_refered_spam]" type="text" id="msg_refered_spam" value="<?php echo $param_values['msg_refered_spam']; ?>" />
							</div>
							<div style="display:none;">
								<label for="msg_number_smaller">Number is smaller than minimum limit</label>
								<input name="params[msg_number_smaller]" type="text" id="msg_number_smaller" value="<?php echo $param_values['msg_number_smaller']; ?>" />
							</div>
							<div style="display:none;">
								<label for="msg_number_large">Number is larger than maximum limit</label>
								<input name="params[msg_number_large]" type="text" id="msg_number_large" value="<?php echo $param_values['msg_number_large']; ?>" />
							</div>
							<div>
								<label for="msg_captcha_error">Captcha is Not Validated</label>
								<input name="params[msg_captcha_error]" type="text" id="msg_captcha_error" value="<?php echo $param_values['msg_captcha_error']; ?>" />
							</div>
							<div>
								<label for="required_empty_field">Required Field Is Empty</label>
								<input name="params[required_empty_field]" type="text" id="required_empty_field" value="<?php echo $param_values['required_empty_field']; ?>" />
							</div>
							<div>
								<label for="msg_invalid_email">Email address that the sender entered is invalid</label>
								<input name="params[msg_invalid_email]" type="text" id="msg_invalid_email" value="<?php echo $param_values['msg_invalid_email']; ?>" />
							</div>
							<div style="display:none;">
								<label for="msg_invalid_url">URL that the sender entered is invalid</label>
								<input name="params[msg_invalid_url]" type="text" id="msg_invalid_url" value="<?php echo $param_values['msg_invalid_url']; ?>" />
							</div>
							<div style="display:none;">
								<label for="msg_invalid_tel">Telephone number that the sender entered is invalid</label>
								<input name="params[msg_invalid_tel]" type="text" id="msg_invalid_tel" value="<?php echo $param_values['msg_invalid_tel']; ?>" />
							</div>
							<div style="display:none;">
								<label for="msg_invalid_date">Date format that the sender entered is invalid</label>
								<input name="params[msg_invalid_date]" type="text" id="msg_invalid_date" value="<?php echo $param_values['msg_invalid_date']; ?>" />
							</div>
							<div style="display:none;">
								<label for="msg_early_date">Date is earlier than minimum limit</label>
								<input name="params[msg_early_date]" type="text" id="msg_early_date" value="<?php echo $param_values['msg_early_date']; ?>" />
							</div>
							<div style="display:none;">
								<label for="msg_late_date">Date is later than maximum limit</label>
								<input name="params[msg_late_date]" type="text" id="msg_late_date" value="<?php echo $param_values['msg_late_date']; ?>" />
							</div>
							<div>
								<label for="msg_fail_failed">Uploading a file fails for any reason</label>
								<input name="params[msg_fail_failed]" type="text" id="msg_fail_failed" value="<?php echo $param_values['msg_fail_failed']; ?>" />
							</div>
							<div>
								<label for="msg_file_format">Uploaded file is not allowed file type</label>
								<input name="params[msg_file_format]" type="text" id="msg_file_format" value="<?php echo $param_values['msg_file_format']; ?>" />
							</div>
							<div>
								<label for="msg_large_file">Uploaded file is too large</label>
								<input name="params[msg_large_file]" type="text" id="msg_large_file" value="<?php echo $param_values['msg_large_file']; ?>" />
							</div>
						</div>
					</div>
					<div class="hugeit-contact-general-options-column hugeit-contact-general-options-right">
						<div class="hugeit-contact-general-options-block">
							<h3>Email To Administrator</h3>
							<div>
								<label for="form_send_email_for_each_submition">Send Email For Each Submission</label>
								<input type="hidden" value="off" name="params[form_send_email_for_each_submition]" />
								<input type="checkbox" id="form_send_email_for_each_submition"  <?php if($param_values['form_send_email_for_each_submition']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[form_send_email_for_each_submition]" value="on" />
							</div>
							<div>
								<label for="form_adminstrator_email">Administrator Email</label>
								<input type="text" id="form_adminstrator_email" name="params[form_adminstrator_email]" value="<?php echo $param_values['form_adminstrator_email']; ?>" />
								<dfn class="huge_it_forms_mess_subject_help_box" data-info="Add multiple emails separating them with commas.">?</dfn>
							</div>
							<div>
								<label for="form_message_subject">Message Subject</label>
								<input name="params[form_message_subject]" type="text" class="color" id="form_message_subject" value="<?php echo $param_values['form_message_subject']; ?>" size="10" />
								<dfn class="huge_it_forms_mess_subject_help_box" data-info="If you leave this field empty, the name of the submitted form will be used as the subject of the email.">?</dfn>
							</div>
							<div class="autoheight">
								<label for="form_adminstrator_message">Message</label>
								<?php
								function hugeit_contact_wptiny($initArray){
									$initArray['height'] = '300px';
									$initArray['forced_root_block'] = false;
									$initArray['remove_linebreaks']=false;
									$initArray['remove_redundant_brs'] = false;
									$initArray['wpautop']=false;
									return $initArray;
								}
								add_filter('tiny_mce_before_init', 'hugeit_contact_wptiny' );
								wp_editor(html_entity_decode($param_values['form_adminstrator_message']), "adminmessage");;
								?>
								<div class="clear"></div>
							</div>
						</div>

						<div class="hugeit-contact-general-options-block">
							<h3>Email To User</h3>
							<div>
								<label for="form_send_to_email_user">Send Email To User</label>
								<input type="hidden" value="off" name="params[form_send_to_email_user]" />
								<input type="checkbox" id="form_send_to_email_user"  <?php if($param_values['form_send_to_email_user']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[form_send_to_email_user]" value="on" />
							</div>
							<div>
								<label for="form_user_message_subject">Message Subject</label>
								<input name="params[form_user_message_subject]" type="text" class="color" id="form_user_message_subject" value="<?php echo $param_values['form_user_message_subject']; ?>" size="10" />
								<dfn class="huge_it_forms_mess_subject_help_box" data-info="If you leave this field empty, the name of the submitted form will be used as the subject of the email.">?</dfn>
							</div>
							<div class="autoheight">
								<label for="form_user_message">Message</label>
								<?php wp_editor(html_entity_decode(stripslashes($param_values['form_user_message'])), "usermessage"); ?>
							</div>
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
<?php
}
