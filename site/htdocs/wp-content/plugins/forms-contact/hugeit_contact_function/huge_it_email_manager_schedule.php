<?php
if(! defined( 'ABSPATH' )) exit;	
global $wpdb;
add_filter( 'cron_schedules', 'hugeit_contact_add_schedules' );
add_action( 'huge_it_cron_action', 'hugeit_contact_cron_cb' );

function hugeit_contact_cron_cb() {
	global $wpdb;
	$genOptions=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."huge_it_contact_general_options order by id");
	$headers = array('From: '.$genOptions[35]->value.' <'.$genOptions[34]->value.'>');
	$limit = $genOptions[30]->value;
	$formsID=$genOptions[29]->value;
	$email_subject=$genOptions[32]->value;
	$res_count = $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."huge_it_contact_subscribers SET send = '2' WHERE send = '1' ORDER BY subscriber_id DESC LIMIT %d", absint($limit)));

	if (!$res_count){
		wp_clear_scheduled_hook( 'huge_it_cron_action' );
		return;
	}
	$res = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE send = '2'", ARRAY_A);

	add_filter( 'wp_mail_content_type', 'hugeit_contact_set_html_content_type' );
	function hugeit_contact_set_html_content_type() {
		return 'text/html';
	}
	
	foreach($res as $item){
		$email = sanitize_email($item['subscriber_email']);
		$r = wp_mail( $email, $email_subject, $item['text'],$headers);

		if($r){
			$wpdb->update(
				$wpdb->prefix."huge_it_contact_subscribers",
				array('send' => '3'),
				array(
					'send' => '2',
					'subscriber_email' => $email
				),
				array('%d', '%s')
			);
		}
	}

	if($formsID=='all'){
		$check=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."huge_it_contact_subscribers", ARRAY_A);
	}else{
		$check=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE subscriber_form_id=".$formsID, ARRAY_A);
	}
	$remove=1;
	foreach($check as $checked){
		if($checked['send']!=3&&$checked['send']!=0){
			$remove=0;
		}
	}
	if($remove){
		$wpdb->query("UPDATE ".$wpdb->prefix."huge_it_contact_subscribers SET send = '0' WHERE send = '3'");
		$wpdb->query("UPDATE ".$wpdb->prefix."huge_it_contact_general_options SET value = 'finish' WHERE name = 'mailing_progress'");
	}
	// if part is not full
	if( $res_count < $limit ){
		wp_clear_scheduled_hook( 'huge_it_cron_action' );
		return;
	}
}

function hugeit_contact_add_schedules($schedules){
	$schedules['minute'] = array(
		'interval' => 60,
		'display' => '1 minute'
	);
	$schedules['two-minutes'] = array(
		'interval' => 120,
		'display' => '2 minutes'
	);
	$schedules['thirty-minutes'] = array(
		'interval' => 1800,
		'display' => '30 minutes'
	);
	return $schedules;
}

function hugeit_contact_email_ajax_action_callback() {
	if ( ( isset( $_POST['task'] ) && $_POST['task'] == 'subcriberSend' ) ) {
		if ( empty( $_POST['data'] ) ) {
			echo 'Fill text area';
		}
		global $wpdb;
		$time = wp_next_scheduled( 'huge_it_cron_action' );
		wp_unschedule_event( $time, 'huge_it_cron_action' );
		if ( ! wp_next_scheduled( 'huge_it_cron_action' ) ) {
			$schedule        = (int)$_POST['sub_interval'];
			$limit           = $_POST['sub_count_by_parts'];
			$limit           = ( (int) $limit > 0 ) ? (int) $limit : 10;
			$sub_choose_form = sanitize_text_field($_POST['sub_choose_form']);
			$sub_choose_form = ( (int) $sub_choose_form > 0 ) ? (int) $sub_choose_form : 'all';
			$email_subject   = sanitize_text_field($_POST['email_subject']);
			$schedules       = wp_get_schedules();

			$_POST['data'] = stripslashes( $_POST['data'] );
			$images        = '';
			$pattern       = '/(<img.*?>)/';
			preg_match_all( $pattern, $_POST['data'], $images );
			$i        = 0;
			$patterns = array();
			foreach ( $images[0] as $image ) {
				$image          = preg_replace( '/"/', "", $image );
				$image          = preg_replace( '/\</', "", $image );
				$image          = preg_replace( '/\>/', "", $image );
				$patterns[ $i ] = $image;
				$i ++;
			}
			$_POST['data'] = preg_replace( $images[0], $patterns, $_POST['data'] );

			foreach ( $schedules as $k => $v ) {
				if ( $v['interval'] == $schedule ) {
					$schedule_interval = $k;
					break;
				}
			}
			$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_general_options SET value = %s WHERE name = 'mailing_progress'", 'start' ) );
			$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_general_options SET value = %d WHERE name = 'sub_count_by_parts'", $limit ) );
			$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_general_options SET value = %s WHERE name = %s", $sub_choose_form, 'sub_choose_form' ) );
			$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_general_options SET value = %d WHERE name = %s", $schedule, 'sub_interval' ) );
			$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_general_options SET value = %s WHERE name = 'email_subject'", $email_subject ) );
			wp_schedule_event( time(), $schedule_interval, 'huge_it_cron_action' );
		}
		if ( $sub_choose_form == 'all' ) {
			$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_subscribers SET send = '1', text = %s", $_POST['data'] ) );
			$count_subscribers = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "huge_it_contact_subscribers" );
			$need_time         = ceil( $count_subscribers / $limit ) * $schedule;
			$need_time         = date( "H:i:s", mktime( 0, 0, $need_time ) );
		} else {
			$wpdb->query( $wpdb->prepare( "UPDATE " . $wpdb->prefix . "huge_it_contact_subscribers SET send = '1', text = %s WHERE subscriber_form_id=%d", $_POST['data'], $sub_choose_form ) );
			$count_subscribers = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "huge_it_contact_subscribers  WHERE subscriber_form_id=" . $sub_choose_form);
			$need_time         = ceil( $count_subscribers / $limit ) * $schedule;
			$need_time         = date( "H:i:s", mktime( 0, 0, $need_time ) );
		}

		die( "Mailings Are in Queue. Approximate Time (HH:ММ:SS): {$need_time}" );
	}

	if ( isset( $_POST['task'] ) && $_POST['task'] == 'showForms' ) {
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'email_nonce')) {
			return false;
		}
		global $wpdb;
		$formId = $_POST['data'];
		if ( $formId == 'all' ) {
			$subscribers = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_subscribers ORDER BY subscriber_id DESC", ARRAY_A );
			$count       = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "huge_it_contact_subscribers" );
		} else {
			$formId = absint($_POST['data']);
			$subscribers = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "huge_it_contact_subscribers WHERE subscriber_form_id=" . $formId . " ORDER BY subscriber_id DESC", ARRAY_A );
			$count       = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM " . $wpdb->prefix . "huge_it_contact_subscribers WHERE subscriber_form_id = %d", $formId));
		}
		$tableRows = '';
		foreach ( $subscribers as $subscriber ) {
			$tableRows .= '<tr id="sub_row_' . $subscriber['subscriber_id'] . '">';
			$tableRows .= '<td colspan="5">' . $subscriber['subscriber_email'] . '</td>';
			if ( $subscriber['send'] == 1 || $subscriber['send'] == 2 ) {
				$tableRows .= '<td colspan="2" id="' . $subscriber['subscriber_id'] . '" class="status_wrap_load"><a href="#" class="sub_status_load"></a></td>';
			} elseif ( $subscriber['send'] == 0 ) {
				$tableRows .= '<td colspan="2"  id="' . $subscriber['subscriber_id'] . '"  class="status_wrap_none"><a href="#" class="sub_status_none"></a></td>';
			} elseif ( $subscriber['send'] == 3 ) {
				$tableRows .= '<td colspan="2"  id="' . $subscriber['subscriber_id'] . '"  class="status_wrap_done"><a href="#" title="Sent" class="sub_status_done"></a></td>';
			}
			$tableRows .= '<td colspan="1" id="' . $subscriber['subscriber_id'] . '" class="del_wrap"><a href="#" class="sub_delete"></a></td>
						</tr>';
		}

		$output='<table class="wp-list-table widefat fixed posts" id="huge_it-table">
						<thead>
							<tr>
								<th colspan="7" style="text-align:center;">Emails</th>
								<th colspan="1" style="text-align:center;">'.$count.'</th>
							</tr>
							<tr>
								<td colspan="7"><input type="text" id="add_email" name="add_email" placeholder="Type Email to Add"></td>
								<td colspan="1" class="add_wrap"><a href="#" class="sub_add"></a></td>
							</tr>
						</thead>
						<tbody>
							'.$tableRows.'	
						</tbody>
					</table>';
		echo json_encode(array("output"=>esc_html($output)));
	}

	if(isset($_POST['task'])&&$_POST['task']=='deleteSubscriber'){
		$id=absint($_POST['subID']);
		$formId= sanitize_text_field($_POST['formId']);
		global $wpdb;
		$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE subscriber_id=%d",$id));
		if($formId=='all'){
			$count = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers");
		}else{
			$formId = absint($formId);
			$count = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE subscriber_form_id=".$formId);
		}
		echo json_encode(array("output"=>$count));
	}

	if(isset($_POST['task'])&&$_POST['task']=='addSubscriber'){
		global $wpdb;
		$email= sanitize_email($_POST['email']);
		$formId=$_POST['data'];
		$table_name = $wpdb->prefix . "huge_it_contact_subscribers";
		if($formId=='all'){
			$subscribers=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."huge_it_contact_subscribers ORDER by subscriber_id DESC", ARRAY_A);
			$count = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers");
			$insert=1;
			foreach ($subscribers as $subscriber) {
				if($subscriber['subscriber_email']==$email){
					$insert=0;
				}
			}
		    if($insert){
		    	$wpdb->insert(
				    $table_name,
				    array(
					    'subscriber_form_id' => 00,
						'subscriber_email' => $email,
				    ),
				    array('%d', '%s')
			    );
	            $subscribers=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."huge_it_contact_subscribers ORDER by subscriber_id DESC", ARRAY_A);
				$tableRows='';
				foreach($subscribers as $subscriber){
					$tableRows.='<tr id="sub_row_'.$subscriber['subscriber_id'].'">';
					$tableRows.='<td colspan="5">'.$subscriber['subscriber_email'].'</td>';
					if($subscriber['send']==1||$subscriber['send']==2){
						$tableRows.='<td colspan="2" id="'.$subscriber['subscriber_id'].'" class="status_wrap_load"><a href="#" class="sub_status_load"></a></td>';
					}elseif($subscriber['send']==0){
						$tableRows.='<td colspan="2"  id="'.$subscriber['subscriber_id'].'"  class="status_wrap_none"><a href="#" class="sub_status_none"></a></td>';
					}elseif($subscriber['send']==3){
						$tableRows.='<td colspan="2"  id="'.$subscriber['subscriber_id'].'"  class="status_wrap_done"><a href="#" title="Sent" class="sub_status_done"></a></td>';
				    }
					$tableRows.='<td colspan="1" id="'.$subscriber['subscriber_id'].'" class="del_wrap"><a href="#" class="sub_delete"></a></td>
								</tr>';
				}

				$output='<table class="wp-list-table widefat fixed posts" id="huge_it-table">
								<thead>
									<tr>
										<th colspan="7" style="text-align:center;">Emails</th>
										<th colspan="1" style="text-align:center;">'.$count.'</th>
									</tr>
									<tr>
										<td colspan="7"><input type="text" id="add_email" name="add_email" placeholder="Type Email to Add"></td>
										<td colspan="1" class="add_wrap"><a href="#" class="sub_add"></a></td>
									</tr>
								</thead>
								<tbody>
									'.$tableRows.'	
								</tbody>
							</table>';
				echo json_encode(array("output"=>esc_html($output)));
			}else{
				$output='Email Already Exists';
				echo json_encode(array("exists"=>$output));
			}

		}else{
			$formId = absint($formId);
			$subscribers=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE subscriber_form_id=".$formId." ORDER by subscriber_id DESC", ARRAY_A);
			$count = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE subscriber_form_id=".$formId);
			$insert=1;
			foreach ($subscribers as $subscriber) {
				if($subscriber['subscriber_email']==$email){
					$insert=0;
				}
			}
			if($insert){
				$wpdb->insert(
					$table_name,
					array(
						'subscriber_form_id' => $formId,
						'subscriber_email' => $email,
					),
					array('%d', '%s')
				);
				$subscribers=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE subscriber_form_id=".$formId." ORDER by subscriber_id DESC", ARRAY_A);
				$tableRows='';
				foreach($subscribers as $subscriber){
					$tableRows.='<tr id="sub_row_'.$subscriber['subscriber_id'].'">';
					$tableRows.='<td colspan="5">'.$subscriber['subscriber_email'].'</td>';
					if($subscriber['send']==1||$subscriber['send']==2){
						$tableRows.='<td colspan="2" id="'.$subscriber['subscriber_id'].'" class="status_wrap_load"><a href="#" class="sub_status_load"></a></td>';
					}elseif($subscriber['send']==0){
						$tableRows.='<td colspan="2"  id="'.$subscriber['subscriber_id'].'"  class="status_wrap_none"><a href="#" class="sub_status_none"></a></td>';
					}elseif($subscriber['send']==3){
						$tableRows.='<td colspan="2"  id="'.$subscriber['subscriber_id'].'"  class="status_wrap_done"><a href="#" title="Sent" class="sub_status_done"></a></td>';
				    } 
					$tableRows.='<td colspan="1" id="'.$subscriber['subscriber_id'].'" class="del_wrap"><a href="#" class="sub_delete"></a></td>
								</tr>';
				}
				$output='<table class="wp-list-table widefat fixed posts" id="huge_it-table">
								<thead>
									<tr>
										<th colspan="7" style="text-align:center;">Emails</th>
										<th colspan="1" style="text-align:center;">'.$count.'</th>
									</tr>
									<tr>
										<td colspan="7"><input type="text" id="add_email" name="add_email" placeholder="Type Email to Add"></td>
										<td colspan="1" class="add_wrap"><a href="#" class="sub_add"></a></td>
									</tr>
								</thead>
								<tbody>
									'.$tableRows.'	
								</tbody>
							</table>';
				echo json_encode(array("output"=>esc_html($output)));
			}else{
				$output='Email Already Exists';
				echo json_encode(array("exists"=>$output));
			}
			
		}
	}
	if(isset($_POST['task'])&&$_POST['task']=='refreshTable'){
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'email_nonce')) {
			return false;
		}
		global $wpdb;
		$formId=$_POST['data'];
		if($formId=='all'){
			$subscribers=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."huge_it_contact_subscribers ORDER by subscriber_id DESC", ARRAY_A);
			$count = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers");
		}else{
			$formId = absint($formId);
			$subscribers=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE subscriber_form_id=".$formId." ORDER by subscriber_id DESC", ARRAY_A);
			$count = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE subscriber_form_id=".$formId);
		}
		$tableRows='';
		foreach($subscribers as $subscriber){
			$tableRows.='<tr id="sub_row_'.$subscriber['subscriber_id'].'">';
			$tableRows.='<td colspan="5">'.$subscriber['subscriber_email'].'</td>';
			if($subscriber['send']==1||$subscriber['send']==2){
				$tableRows.='<td colspan="2" id="'.$subscriber['subscriber_id'].'" class="status_wrap_load"><a href="#" class="sub_status_load"></a></td>';
			}elseif($subscriber['send']==0){
				$tableRows.='<td colspan="2"  id="'.$subscriber['subscriber_id'].'"  class="status_wrap_none"><a href="#" class="sub_status_none"></a></td>';
			}elseif($subscriber['send']==3){
				$tableRows.='<td colspan="2"  id="'.$subscriber['subscriber_id'].'"  class="status_wrap_done"><a href="#" title="Sent" class="sub_status_done"></a></td>';
		    } 
			$tableRows.='<td colspan="1" id="'.$subscriber['subscriber_id'].'" class="del_wrap"><a href="#" class="sub_delete"></a></td>
						</tr>';
		}
		$output=$tableRows;

		echo json_encode(array("output"=>esc_html($output)));
	}
	if(isset($_POST['task'])&&$_POST['task']=='refreshProgress'){
		global $wpdb;
		$genOptions=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."huge_it_contact_general_options order by id");
		$formsID=$genOptions[29]->value;
		$limit=$genOptions[30]->value;
		$schedule=$genOptions[31]->value;
		$status=$genOptions[33]->value;
			if($formsID=='all'){
				$count_subscribers = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE `send`='1'");
				$total_total_percent = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE send='1' OR send='3'");
				$current_total_percent=$wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE send='3'");
				$need_time = ceil($count_subscribers / $limit) * $schedule;
				$need_time = date("H:i:s", mktime(0, 0, $need_time));
				if($need_time=='00:00:00'){
					$need_time='00:01:00';
				}
				if(!empty($current_total_percent)&&!empty($total_total_percent)){
					$percent=round($current_total_percent/$total_total_percent*100);
				}else{
					$percent='5';
				}
				echo json_encode(array("need_time"=>$need_time,"percent"=>(int)$percent,"cond"=>$status));
			}else{
				$count_subscribers = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers  WHERE `send`='1' AND subscriber_form_id='".$formsID."'");
				$total_total_percent = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE subscriber_form_id='".$formsID."' AND (send='1' OR send='3')");
				$current_total_percent=$wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE subscriber_form_id='".$formsID."' AND send='3'");
				$need_time = ceil($count_subscribers / $limit) * $schedule;
				$need_time = date("H:i:s", mktime(0, 0, $need_time));
				if($need_time=='00:00:00'){
					$need_time='00:01:00';
				}
				if(!empty($current_total_percent)&&!empty($total_total_percent)){
					$percent=round($current_total_percent/$total_total_percent*100);
				}else{
					$percent='5';
				}
				echo json_encode(array("need_time"=>$need_time,"percent"=>(int)$percent,"cond"=>$status));				
			}
	}

	if(isset($_POST['task'])&&$_POST['task']=='showCont'){
		global $wpdb;
		$subscribers=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."huge_it_contact_subscribers ORDER by subscriber_id DESC", ARRAY_A);
		$genOptions=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."huge_it_contact_general_options order by id");
		$mail_status=$genOptions[33]->value;
		if($mail_status=='start'){
			$formsID=$genOptions[29]->value;
			$limit=$genOptions[30]->value;
			$schedule=$genOptions[31]->value;
			if($formsID=='all'){
				$count_subscribers = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE `send`='1'");
				$total_total_percent = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE send='1' OR send='3'");
				$current_total_percent=$wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE send='3'");
				$need_time = ceil($count_subscribers / $limit) * $schedule;
				if($need_time=='00:00:00'){
					$need_time='00:01:00';
				}
				$need_time = date("H:i:s", mktime(0, 0, $need_time));
				if(!empty($current_total_percent)&&!empty($total_total_percent)){
					$percent=round($current_total_percent/$total_total_percent*100);
				}else{
					$percent='5';
				}
				$mailing['need_time']=$need_time;
				$mailing['percent']=$percent;
			}else{
				$count_subscribers = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers  WHERE `send`='1' AND subscriber_form_id=".$formsID);
				$total_total_percent = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE subscriber_form_id=".$formsID." AND (send='1' OR send='3')");
				$current_total_percent=$wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."huge_it_contact_subscribers WHERE subscriber_form_id=".$formsID." AND send='3'");
				$need_time = ceil($count_subscribers / $limit) * $schedule;
				$need_time = date("H:i:s", mktime(0, 0, $need_time));
				if($need_time=='00:00:00'){
					$need_time='00:01:00';
				}
				if(!empty($current_total_percent)&&!empty($total_total_percent)){
					$percent=round($current_total_percent/$total_total_percent*100);
				}else{
					$percent='5';
				}
				$mailing['need_time']=$need_time;
				$mailing['percent']=$percent;				
			}
			$output='<div id="sending_progress">
							<div>Estimated Approximate Time <span id="progress_time">'.$mailing['need_time'].'</span></div>					
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
									padding: 0px;
									border: 1px solid #CCCCCC;
									overflow:hidden;
								}
								.meter > span {
									display: block;
									height: 100%;
									width:'.$mailing['percent'].'%;
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
									background-repeat:repeat;
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
						<button id="huge_it_cancel" class="button-primary">Cancel<i class="hugeicons-ban"></i></button>';
			echo json_encode(array("output"=>esc_html($output)));
		}elseif ($mail_status=='finish') {
			if(!isset($_POST['noCancel']))$_POST['noCancel']='';
			$done=sanitize_text_field($_POST['noCancel']);
			if($done=='true'){
				$doneHtml='<span id="done" style="padding-left: 9px;">Successfully Sent <i class="hugeicons-check" style="color: #00A0D2;font-size: 21px;vertical-align: baseline;"></i></span>';
			}else{
				$doneHtml='';
			}
			$disabled='';
			if(!$subscribers) $disabled='disabled';
			$output='<div id="not_send">
							<button class="btn button-primary" id="btn" '.$disabled.'>Send<i class="hugeicons-paper-plane"></i></button>
							<span id="loader" style="display: none;"><img src="'.plugins_url( 'forms-contact/images/spinner.gif').'" alt=""></span>'.$doneHtml.'							
							<div id="res"></div>
					</div>';
			echo json_encode(array("output"=>esc_html($output)));
		}
		
	}
	if(isset($_POST['task'])&&$_POST['task']=='huge_it_cancel'){
		global $wpdb;
		$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."huge_it_contact_general_options SET value = %s WHERE name = 'mailing_progress'",'finish'));
		$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."huge_it_contact_subscribers SET send = %s WHERE send !=%s", '0','0'));
		wp_clear_scheduled_hook( 'huge_it_cron_action' );
		return;
	}
	die();
}
