<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( function_exists( 'current_user_can' ) ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		die( 'Access Denied' );
	}
}
if ( ! function_exists( 'current_user_can' ) ) {
	die( 'Access Denied' );
}
require_once( "hugeit_free_version.php" );
function  hugeit_contact_html_show_emails($subscribers,$mailerParams,$count,$formsToShow,$mailing) {
?>
<div class="wrap">
	<?php hugeit_contact_drawFreeBanner('yes');?>
	<div id="poststuff">
		<?php $path_site = plugins_url("Front_images", __FILE__); ?>
		<div id="post-body-content" class="hugeit_contact_email">
			<h3>Newsletter Manager</h3>
			<div id="hugeit_contact_email_manager">	
				<div class="sub_setting">			
					<form method="post" action="admin.php?page=hugeit_forms_email_manager&task=save" id="email_manager_form" name="email_manager_form">	
							<label for="huge_it_form_choose">Choose The Forms</label><br>
							<select name="" id="huge_it_form_choose">
								<option value="all">All Forms</option>
								<?php foreach ($formsToShow as $key => $value) : ?>
									<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
								<?php endforeach; ?>
							</select><br>
							<label for="huge_it_setting_subscriber_limit_id">Emails in One Flow</label><br>
							<input type="number" name="mailerParams[sub_count_by_parts]" id="huge_it_setting_subscriber_limit_id" value="<?php echo $mailerParams['sub_count_by_parts'] ?>" class="regular-text"><br>
							<label for="huge_it_setting_schedule_id">Interval Between Mailings</label><br>
							<select name="mailerParams[sub_interval]" id="huge_it_setting_schedule_id">
								<option value="60" <?php selected( '60', $mailerParams['sub_interval'], true ); ?>>1 Minute</option>
								<option value="120" <?php selected( '120', $mailerParams['sub_interval'], true ); ?>>2 Minutes</option>
								<option value="1800" <?php selected( '1800',$mailerParams['sub_interval'], true ); ?>>30 Minutes</option>
								<option value="3600" <?php selected( '3600', $mailerParams['sub_interval'], true ); ?>>1 Hour</option>
							</select><br>

							<label for="huge_it_email_subject">Email Subject</label><br>
							<input type="text" name="mailerParams[email_subject]" id="huge_it_email_subject" value="<?php echo $mailerParams['email_subject']; ?>" class="regular-text"><br>
						<input type="hidden" name="task" value=""/>
					</form>

						<label for="wp-subscriber_message-wrap">Type your text here</label>
					<?php function hugeit_contact_wptiny2( $initArray ) {
						$initArray['height']               = '250px';
						$initArray['forced_root_block']    = false;
						$initArray['remove_linebreaks']    = false;
						$initArray['remove_redundant_brs'] = false;
						$initArray['wpautop']              = false;

						return $initArray;
					}

					add_filter( 'tiny_mce_before_init', 'hugeit_contact_wptiny2' );
					$settings = array( 'media_buttons' => false );
					wp_editor( '', "subscriber_message", $settings );
					?>
					<div id="showCont">
						<?php if($mailerParams['mailing_progress']=='finish'):?>
						<div id="not_send">
							<button class="btn button-primary" id="btn" <?php if(!$subscribers) echo 'disabled'; ?>>Send <i>(pro)</i><i class="hugeicons-paper-plane"></i></button>
							<span id="loader" style="display: none;"><img src="<?php echo plugins_url( '../images/spinner.gif', __FILE__ ); ?>" alt=""></span>
							<span id="done" style="padding-left: 9px;display:none;">Successfully Sent <i class="hugeicons-check" style="color: #00A0D2;font-size: 21px;vertical-align: baseline;"></i></span>
						</div>
						<?php elseif($mailerParams['mailing_progress']=='start'):?>
						<div id="sending_progress">
							<div>Estimated Approximate Time <span id="progress_time"><?php echo $mailing['need_time']; ?></span></div>					
							<div class="meter">
								<span id="progress_meter"><span></span></span>
							</div>
							<style>
								.meter { 
									height: 20px;  /* Can be anything */
									position: relative;
									display: inline-block;
									width: 250px;
									margin: 20px 0 20px 0; /* Just for demo spacing */
									background: none;
									-moz-border-radius: 10px;
									-webkit-border-radius: 10px;
									border-radius: 10px;
									padding: 0;
									border: 1px solid #CCCCCC;
									overflow:hidden;
								}
								.meter > span {
									display: block;
									height: 100%;
									width:<?php echo $mailing['percent']; ?>%;
									-webkit-border-top-left-radius: 20px;
									-webkit-border-bottom-left-radius: 20px;
									-moz-border-radius-topleft: 20px;
									-moz-border-radius-bottomleft: 20px;
									border-top-left-radius: 20px;
									border-bottom-left-radius: 20px;
									background-color: rgb(18, 146, 196);
									position:relative;
									overflow:hidden;
								}							
								.meter > span > span {								
									position: absolute;
									display:block;
									top: 0; 
									left: 0;
									bottom: 0; 
									right: 0;
									background-repeat:repeat;
									z-index: 1;
								   background-image:
									   -webkit-gradient(linear, 0 0, 100% 100%, 
									      color-stop(.25, rgba(255, 255, 255, .2)), 
									      color-stop(.25, transparent), color-stop(.5, transparent), 
									      color-stop(.5, rgba(255, 255, 255, .2)), 
									      color-stop(.75, rgba(255, 255, 255, .2)), 
									      color-stop(.75, transparent), to(transparent)
									   );
									background-image: 
										-moz-linear-gradient(
										  -45deg, 
									      rgba(255, 255, 255, .2) 25%, 
									      transparent 25%, 
									      transparent 50%, 
									      rgba(255, 255, 255, .2) 50%, 
									      rgba(255, 255, 255, .2) 75%, 
									      transparent 75%, 
									      transparent
									   );
									background-size:50px 50px;
									background-position:0 0;
									-webkit-animation: move 10s linear infinite;
									animation: move 10s linear infinite;
									-moz-animation: move 10s linear infinite;
									overflow: hidden;
									-webkit-animation-name:move;
									-webkit-animation-duration: 10s;
									-webkit-animation-iteration-count: infinite;
									-webkit-animation-timing-function: linear;
								}					
								@-webkit-keyframes move {
								    0% {
								       -webkit-background-position: 0 0;
								       background-position: 0 0;
								    }
								    100% {
								      -webkit-background-position:1000px 0;
								       background-position:1000px 0;
								    }
								}
								@keyframes move {
								    0% {
								       -webkit-background-position: 0 0;
								       background-position: 0 0;
								    }
									50% {
										-webkit-background-position:500px 0;
								       background-position:500px 0;
									}
								    100% {
								       -webkit-background-position:1000px 0;
								       background-position:1000px 0;
								    }
								}	
							</style>
						</div>
					
					<button id="huge_it_cancel" class="button-primary">Cancel<i class="hugeicons-ban"></i></button>
					<?php endif;?>
					</div>
				</div>
				<div class="sub_table">
					<table class="wp-list-table widefat fixed posts" id="huge_it-table">
						<thead>
							<tr>
								<th colspan="7" style="text-align:center;">Emails</th>
								<th colspan="1" style="text-align:center;"><?php echo $count; ?></th>
							</tr>
							<tr>
								<td colspan="7"><input type="text" id="add_email" name="add_email" placeholder="Type Email to Add"></td>
								<td colspan="1" class="add_wrap"><a href="#" class="sub_add"></a></td>
							</tr>
						</thead>
						<tbody>	
							
						<?php foreach($subscribers as $subscriber): ?>
							<tr id="sub_row_<?php echo $subscriber['subscriber_id']; ?>">
								<td colspan="5"><?php echo $subscriber['subscriber_email']; ?></td>
								<?php if($subscriber['send']==1||$subscriber['send']==2):?>
								<td colspan="2" id="<?php echo $subscriber['subscriber_id']; ?>" class="status_wrap_load"><a href="#" class="sub_status_load"></a></td>
								<?php elseif($subscriber['send']==0):?>
								<td colspan="2" id="<?php echo $subscriber['subscriber_id']; ?>"  class="status_wrap_none"><a href="#" class="sub_status_none"></a></td>
								<?php elseif($subscriber['send']==3):?>
								<td colspan="2" id="<?php echo $subscriber['subscriber_id']; ?>"  class="status_wrap_done"><a href="#" class="sub_status_done"></a></td>
							    <?php endif;?>
								<td colspan="1" id="<?php echo $subscriber['subscriber_id']; ?>" class="del_wrap"><a href="#" class="sub_delete"></a></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
						<div id="table_overlay"><img id="loading" src="<?php echo plugins_url( '../images/279.GIF', __FILE__ ); ?>"></div>
					</table>
				</div>
				<div style="clear:both;"></div>
			</div>
		</div>
	</div>
</div>
<?php
}
