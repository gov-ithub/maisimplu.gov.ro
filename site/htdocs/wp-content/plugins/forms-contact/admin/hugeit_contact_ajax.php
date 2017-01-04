<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
function hugeit_contact_ajax_action_callback(){
	global $wpdb;
////////////////////////SUBMISSION PAGE////////////////////////BEGIN
	// Mark as Spam
	if(isset($_POST['task'])&&$_POST['task']=='moveTospamSubmitions'){
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'admin_nonce')) {
			return false;
		}
		$arrayOfids=$_POST['spam_submitions'];
		$allNumbers = true;
		foreach ($arrayOfids as &$item) {
			$item = absint($item);
		    if (!is_numeric($item)) {
		        $allNumbers = false;
		        break;
		    }
		}
		unset($item);
		if($allNumbers){
			foreach ($arrayOfids as $arrayOfid) {
				$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."huge_it_contact_submission SET customer_spam = '%d'  WHERE id = '%d' ", 1, $arrayOfid));
			}
		}		
		return;
	}
	// Mark as Spam Single
	if(isset($_POST['task'])&&$_POST['task']=='moveToSpamSingleSubmition'){
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'admin_nonce')) {
			return false;
		}
		$subId= sanitize_text_field($_POST['submissionId']);
		if(is_numeric($subId)){
			$subId = absint($subId);
			$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."huge_it_contact_submission SET customer_spam = '%d'  WHERE id = '%d' ", 1, $subId));
		}			
		return;
	}
	// Unmark as Spam
	if(isset($_POST['task'])&&$_POST['task']=='moveFromspamSubmitions'){
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'admin_nonce')) {
			return false;
		}
		$arrayOfids=$_POST['spam_submitions'];
		$allNumbers = true;
		foreach ($arrayOfids as &$item) {
			$item = absint($item);
		    if (!is_numeric($item)) {
		        $allNumbers = false;
		        break;
		    }
		}
		unset($item);
		if($allNumbers){
			foreach ($arrayOfids as $arrayOfid) {
				$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."huge_it_contact_submission SET customer_spam = '%d'  WHERE id = '%d' ", 0, $arrayOfid));
			}
		}	
		return;
	}
	// Unmark as Spam Single
	if(isset($_POST['task'])&&$_POST['task']=='moveFromSpamSingleSubmition'){
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'admin_nonce')) {
			return false;
		}
		$subId=$_POST['submissionId'];	
		if(is_numeric($subId)){
			$subId = absint($subId);
			$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."huge_it_contact_submission SET customer_spam = '%d'  WHERE id = '%d' ", 0, $subId));
		}
		return;
	}
	// Delete
	if(isset($_POST['task'])&&$_POST['task']=='deleteSubmitions'){
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'admin_nonce')) {
			return false;
		}
		$arrayOfids=$_POST['submitions_for_delete'];
		$allNumbers = true;
		foreach ($arrayOfids as &$item) {
			$item = absint($item);
		    if (!is_numeric($item)) {
		        $allNumbers = false;
		        break;
		    }
		}
		unset($item);
		if($allNumbers){
			foreach ($arrayOfids as $arrayOfid) {
				$arrayOfid = absint($arrayOfid);
				$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."huge_it_contact_submission WHERE id=%d",$arrayOfid));
			}
		}		
		return;
	}
	// Delete Single
	if(isset($_POST['task'])&&$_POST['task']=='deleteSingleSubmition'){
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'admin_nonce')) {
			return false;
		}
		$subId=$_POST['submissionId'];
		if(is_numeric($subId)){
			$subId = absint($subId);
			$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."huge_it_contact_submission WHERE id=%d",$subId));
		}	
		return;
	}
	// Mark as Read
	if(isset($_POST['task'])&&$_POST['task']=='markAsRead'){
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'admin_nonce')) {
			return false;
		}
		$arrayOfids=$_POST['read_submitions'];
		$allNumbers = true;
		foreach ($arrayOfids as $item) {
		    if (!is_numeric($item)) {
		        $allNumbers = false;
		        break;
		    }
		}
		if($allNumbers==true){
			foreach ($arrayOfids as $arrayOfid) {
				$arrayOfid = absint($arrayOfid);
				$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."huge_it_contact_submission SET customer_read_or_not = '%d'  WHERE id = '%d' ", 1, $arrayOfid));
			}
		}
		return;
	}
	// Mark as Unread
	if(isset($_POST['task'])&&$_POST['task']=='markAsUnread'){
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'admin_nonce')) {
			return false;
		}
		$arrayOfids=$_POST['unread_submitions'];
		$allNumbers = true;
		foreach ($arrayOfids as $item) {
		    if (!is_numeric($item)) {
		        $allNumbers = false;
		        break;
		    }
		}
		if($allNumbers==true){
			foreach ($arrayOfids as $arrayOfid) {
				$arrayOfid = absint($arrayOfid);
				$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."huge_it_contact_submission SET customer_read_or_not = '%d'  WHERE id = '%d' ", 0, $arrayOfid));
			}
		}
		return;
	}
	// Refreshing submissions page
	if(isset($_POST['task'])&&$_POST['task']=='refreshSubmissions'){
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'admin_nonce')) {
			return false;
		}
		$countSub= absint($_POST['countTorefresh']);
		$subID= absint($_POST['subID']);
		if($countSub!=0){
			$submitionsCount = $wpdb->get_results("SELECT count(customer_read_or_not) AS all_count FROM " . $wpdb->prefix . "huge_it_contact_submission WHERE contact_id=".$subID."");
		}
		if(isset($_POST['marked_submitions'])){
			$markedSubmitions = sanitize_text_field($_POST['marked_submitions']);
		}else{
			$markedSubmitions='';
		}		
		$counmarked=absint($_POST['countTorefresh']);
		if(trim($markedSubmitions)!=''){
			if(isset($submitionsCount[0]) && $submitionsCount[0]->all_count != $counmarked && $counmarked != 0){
				$subToAppend=$wpdb->prepare("SELECT * FROM ". $wpdb->prefix . "huge_it_contact_submission WHERE `id` > %d",$markedSubmitions);
				$subToAppends2=$wpdb->get_results($subToAppend);
				$output='';
				$keyForBackground = 1;
				
				foreach ($subToAppends2 as $subToAppend) {
					$readOrNot='';
					$readOrNot = $subToAppend->customer_read_or_not == 1 ? "read" : $readOrNot="unread";
					$spamOrNot='';
					$spamOrNot = $subToAppend->customer_spam == 1 ? " spam" : "";
					$depth='';
					if($keyForBackground%2 == 0) $depth=" alt";
					$displayOrNot='';
					if($subToAppend->customer_spam != 1) $displayOrNot="style= 'display: none'";
					if ($subToAppend->customer_read_or_not == 1){
						$spamer='<a href="admin.php?page=hugeit_forms_submissions&task=show_submissions&id='.$subToAppend->id.'&submissionsId='.$subToAppend->contact_id.'">'.$subToAppend->customer_country.'</a>
						<p class="spamer" '.$displayOrNot.'>Spam!</p>';
						$show='<span class="edit" value="'.$subToAppend->id.'"><a href="admin.php?page=hugeit_forms_submissions&task=show_submissions&id='.$subToAppend->id.'&submissionsId='.$subToAppend->contact_id.'">Show</a></span>';
					}else{
						$spamer='<a href="admin.php?page=hugeit_forms_submissions&task=show_submissions&id='.$subToAppend->id.'&read=unread&submissionsId='.$subToAppend->contact_id.'">'.$subToAppend->customer_country.'</a>
						<p class="spamer" '.$displayOrNot.'>Spam!</p>';
						$show='<span class="edit" value="'.$subToAppend->id.'"><a href="admin.php?page=hugeit_forms_submissions&task=show_submissions&id='.$subToAppend->id.'&read=unread&submissionsId='.$subToAppend->contact_id.'">Show</a></span>';
					}
					$customer_spam_or_not2 = $subToAppend->customer_spam == 1 ? "display: none" : "";
					$customer_spam_or_not  = $subToAppend->customer_spam != 1 ? "display: none" : "";
					$ipOfSub = array_filter(explode("*()*", $subToAppend->submission_ip),'strlen');
					$output.='<tr id="comment-'.$subToAppend->id.'" class="comment even thread-even '.$readOrNot.' '.$spamOrNot.' depth-'.$keyForBackground.' '.$depth.' prepended">
									<th scope="row" class="check-column">
										<label class="screen-reader-text" for="cb-select-'.$subToAppend->id.'">Select Submission</label>
										<input id="cb-select-'.$keyForBackground.'" type="checkbox" name="check_comments" value="'.$subToAppend->id.'">
									</th>
									<td class="comment column-comment">
										<div class="comment-author">                
										</div>
										<div class="submitted-on">Submitted on <a>'."  ".$subToAppend->submission_date.'</a></div>
											<div class="submition_message" id_for_edit="'.$subToAppend->id.'" readonly >
											</div>
										<div id="inline-1" class="hidden">
										<textarea class="comment" rows="1" cols="1" readonly="readonly" ></textarea>
										<div class="author-email"></div>
										<div class="author"></div>
										<div class="comment_status">1</div>
										</div>
										<div class="row-actions">'.$show.'
											<span class="spam" value="'.$subToAppend->id.'" style="'.$customer_spam_or_not2.'">  | 
												<a class="vim-s vim-destructive" title="Mark this comment as spam">Spam</a>
											</span>
											<span class="not_spam" value="'.$subToAppend->id.'" style="'.$customer_spam_or_not.'">  | 
												<a class="vim-s vim-destructive" title="Unmark as Spam">Not Spam</a>
											</span>
											<span class="trash" value="'.$subToAppend->id.'"> | 
												<a class="delete vim-d vim-destructive" title="Move this comment to the trash">Trash</a>
											</span>
											<span id="huge_it_spinner_'.$subToAppend->id.'" class="huge_it_spinner">
												<img src="'.plugins_url( "../images/spinner.gif", __FILE__ ).'">
											</span>
										</div>
									</td>
									<td class="author column-author user-name">
										'.$spamer.'
									</td>						        
									<td class="author column-author user_email">
										<input value="'.$subToAppend->submission_date.'" id_for_edit="'.$subToAppend->id.'" readonly="readonly" />
									</td>
									<td class="author column-author user_phone">
										<input value="'.$ipOfSub[0].'" id_for_edit="'.$subToAppend->id.'" readonly="readonly" />						            
									</td>
							</tr>';
							$keyForBackground++;
				}
				echo json_encode(array(
					"output"=>$output,
					"countTorefresh"=>$submitionsCount[0]->all_count
				));
			}else{
				return;
			}
		}else{
			return;
		}
		
	}
	//SEARCH Submission
	if(isset($_POST['task']) && $_POST['task'] == 'searchSubmission') {
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'admin_nonce')) {
			return false;
		}
		$search_value=sanitize_text_field($_POST['searchData']);
		$subID=absint($_POST['subID']);
		if(!empty($search_value)&&$subID!='empty'){
			$pattern='/\%/';
			if(preg_match($pattern, $search_value)){
				$search_value=preg_replace($pattern, '\%', $search_value);
			}
			$query = "SELECT * FROM `". $wpdb->prefix ."huge_it_contact_submission` WHERE ((("
                . "" . $wpdb->prefix . "huge_it_contact_submission.sub_labels LIKE '%" .$search_value . "%') OR ("
                . "" . $wpdb->prefix . "huge_it_contact_submission.submission LIKE '%" .$search_value . "%') OR ("
                . "" . $wpdb->prefix . "huge_it_contact_submission.submission_date LIKE '%" .$search_value . "%') OR ("
                     . $wpdb->prefix . "huge_it_contact_submission.submission_ip LIKE '%" .$search_value . "%') OR ("
                     . $wpdb->prefix . "huge_it_contact_submission.customer_country LIKE '%" .$search_value . "%')) AND "
                . "" . $wpdb->prefix . "huge_it_contact_submission.contact_id=".$subID." )GROUP BY " . $wpdb->prefix . "huge_it_contact_submission.id ORDER BY " . $wpdb->prefix . "huge_it_contact_submission.id DESC";
			$subToAppends2=$wpdb->get_results($query);
			$output='';
			$keyForBackground = 1;
			foreach ($subToAppends2 as $subToAppend) {
				$readOrNot = $subToAppend->customer_read_or_not == 1 ? "read" : "unread";
				$spamOrNot = $subToAppend->customer_spam == 1 ? " spam" : "";
				$depth='';
				if($keyForBackground%2 == 0) $depth=" alt";
				$displayOrNot='';
				if($subToAppend->customer_spam != 1) $displayOrNot="style= 'display: none'";
				if ($subToAppend->customer_read_or_not == 1){
					$spamer='<a href="admin.php?page=hugeit_forms_submissions&task=show_submissions&id='.$subToAppend->id.'&submissionsId='.$subToAppend->contact_id.'">'.$subToAppend->customer_country.'</a>
			            <p class="spamer" '.$displayOrNot.'>Spam!</p>';
			            $show='<span class="edit" value="'.$subToAppend->id.'"><a href="admin.php?page=hugeit_forms_submissions&task=show_submissions&id='.$subToAppend->id.'&submissionsId='.$subToAppend->contact_id.'">Show</a></span>';
		        	}else{
		        	$spamer='<a href="admin.php?page=hugeit_forms_submissions&task=show_submissions&id='.$subToAppend->id.'&read=unread&submissionsId='.$subToAppend->contact_id.'">'.$subToAppend->customer_country.'</a>
		            	<p class="spamer" '.$displayOrNot.'>Spam!</p>';
		            	$show='<span class="edit" value="'.$subToAppend->id.'"><a href="admin.php?page=hugeit_forms_submissions&task=show_submissions&id='.$subToAppend->id.'&read=unread&submissionsId='.$subToAppend->contact_id.'">Show</a></span>';
		        	}
				$customer_spam_or_not2 = $subToAppend->customer_spam == 1 ? "display: none" : "";
				$customer_spam_or_not  = $subToAppend->customer_spam != 1 ? "display: none" : "";
	        	$ipOfSub = array_filter(explode("*()*", $subToAppend->submission_ip),'strlen');
				$output.='<tr id="comment-'.$subToAppend->id.'" class="comment even thread-even '.$readOrNot.' '.$spamOrNot.' depth-'.$keyForBackground.' '.$depth.'">
						        <th scope="row" class="check-column">
						            <label class="screen-reader-text" for="cb-select-'.$subToAppend->id.'">Select Submission</label>
						            <input id="cb-select-'.$keyForBackground.'" type="checkbox" name="check_comments" value="'.$subToAppend->id.'">
						        </th>
						        <td class="comment column-comment">
						            <div class="comment-author">                
						            </div>
						            <div class="submitted-on">Submitted on <a>'."  ".$subToAppend->submission_date.'</a></div>
						                <div class="submition_message" id_for_edit="'.$subToAppend->id.'" readonly >
						                </div>
						            <div id="inline-1" class="hidden">
						            <textarea class="comment" rows="1" cols="1" readonly="readonly" ></textarea>
						            <div class="author-email"></div>
						            <div class="author"></div>
						            <div class="comment_status">1</div>
						            </div>
						            <div class="row-actions">'.$show.'
						                <span class="spam" value="'.$subToAppend->id.'" style="'.$customer_spam_or_not2.'">  | 
						                    <a class="vim-s vim-destructive" title="Mark this comment as spam">Spam</a>
						                </span>
						                <span class="not_spam" value="'.$subToAppend->id.'" style="'.$customer_spam_or_not.'">  | 
						                    <a class="vim-s vim-destructive" title="Unmark as Spam">Not Spam</a>
						                </span>
						                <span class="trash" value="'.$subToAppend->id.'"> | 
						                    <a class="delete vim-d vim-destructive" title="Move this comment to the trash">Trash</a>
						                </span>
						                <span id="huge_it_spinner_'.$subToAppend->id.'" class="huge_it_spinner">
						                	<img src="'.plugins_url( "../images/spinner.gif", __FILE__ ).'">
						                </span>
						            </div>
						        </td>
						        <td class="author column-author user-name">
						        	'.$spamer.'
						        </td>
						        <td class="author column-author user_email">
						            <input value="'.$subToAppend->submission_date.'" id_for_edit="'.$subToAppend->id.'" readonly="readonly" />
						        </td>
						        <td class="author column-author user_phone">
						            <input value="'.$ipOfSub[0].'" id_for_edit="'.$subToAppend->id.'" readonly="readonly" />						            
						        </td>
    					</tr>';
    					$keyForBackground++;
			}
			echo json_encode(array("output"=>$output));
		}else{
			return;
		}		
	}
////////////////////////SUBMISSION PAGE////////////////////////END
	die();
}
