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
function hugeit_contact_sub_pagination($count2){
	//Submitions per Page
	$perpage = 50;
	//Count of Submissions
	$countOfPages = (int) $count2;
	//Pages at all
	$count_pages = ceil( $countOfPages / $perpage );
	//Page minimum 1
	if ( ! $count_pages ) {
		$count_pages = 1;
	}
	//Get Current Page
	if ( isset( $_GET['page_number'] ) ) {
		$page = (int) $_GET['page_number'];
		if ( $page < 1 ) {
			$page = 1;
		}
	} else {
		$page = 1;
	}
	//if wanted page is more than pages count
	if ( $page > $count_pages ) {
		$page = $count_pages;
	}
	//Starting Position
	$start_pos = ( $page - 1 ) * $perpage;
	$from      = (int) $start_pos + (int) $perpage;
	if ( $from > $countOfPages ) {
		$from = $countOfPages;
	}
	$start = $start_pos;
	if ( $start_pos == 0 ) {
		$start = 1;
	}
	$protocol = stripos( $_SERVER['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
	//$actual_link = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."?";
	$actual_link = "?";
	foreach ( $_GET as $key => $value ) {
		if ( $key != 'page_number' ) {
			$actual_link .= "{$key}=$value&amp;";
		}

	}
	$url_link  = $actual_link;
	$next_link = $url_link . 'page_number=' . ( $page + 1 );
	$prev_link = $url_link . 'page_number=' . ( $page - 1 );


	$pagination_params = array(
		'start_pos'    => $start_pos,
		'perpage'      => $perpage,
		'count_pages'  => $count_pages,
		'countOfPages' => $countOfPages,
		'page'         => $page,
		'fromTo'       => $from,
		'start'        => $start,
		'nextLink'     => $next_link,
		'prevLink'     => $prev_link,

	);

	return $pagination_params;

}

function hugeit_contact_html_showhugeit_contacts( $rows,  $pageNav,$sort,$cat_row,$form_styles){
	global $wpdb;
	?>
    <script language="javascript">
		function ordering(name,as_or_desc) {
			document.getElementById('asc_or_desc').value=as_or_desc;		
			document.getElementById('order_by').value=name;
			document.getElementById('admin_form').submit();
		}
		function saveorder() {
			document.getElementById('saveorder').value="save";
			document.getElementById('admin_form').submit();
			
		}
		function listItemTask(this_id,replace_id) {
			document.getElementById('oreder_move').value=this_id+","+replace_id;
			document.getElementById('admin_form').submit();
		}
		function doNothing() {  
			var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			if( keyCode == 13 ) {


				if (!e) var e = window.event;

				e.cancelBubble = true;
				e.returnValue = false;

				if (e.stopPropagation) {
					e.stopPropagation();
					e.preventDefault();
				}
			}
		}
	</script>

<div class="wrap">
	<?php hugeit_contact_drawFreeBanner();?>
	<div id="poststuff">
		<div id="hugeit_contacts-list-page">
			<form method="post"  onkeypress="doNothing()" action="admin.php?page=hugeit_forms_main_page" id="admin_form" name="admin_form">
			<h2>Huge IT Submissions
			</h2>
			
			<?php
			echo do_action('huge_it_forms_export',$rows);
			$serch_value='';
			if ( isset( $_POST['serch_or_not'] ) ) {
				if ( $_POST['serch_or_not'] == "search" ) {
					$serch_value = esc_html( stripslashes( $_POST['search_events_by_title'] ) );
				} else {
					$serch_value = "";
				}
			}
			$serch_fields='<div class="alignleft actions"">				
			<div class="alignleft actions">
				<input type="button" value="Search" onclick="document.getElementById(\'page_number\').value=\'1\'; document.getElementById(\'serch_or_not\').value=\'search\';
				 document.getElementById(\'admin_form\').submit();" class="button-secondary action">
				 <input type="button" value="Reset" onclick="window.location.href=\'admin.php?page=hugeit_forms_main_page\'" class="button-secondary action">
			</div>';

			?>
			<table class="wp-list-table widefat fixed pages" style="width:95%">
				<thead>
				 <tr>
					<th scope="col" id="id" style="width:30px" ><span>ID</span><span class="sorting-indicator"></span></th>
					<th scope="col" id="name" style="width:85px" ><span>Name</span><span class="sorting-indicator"></span></th>
					<th scope="col" id="prod_count"  style="width:75px;" ><span>Submissions</span><span class="sorting-indicator"></span></th>
					<th style="width:40px">Delete</th>
				 </tr>
				</thead>
				<tbody>
				<?php
				$trcount = 1;
				for ( $i = 0; $i < count( $rows ); $i ++ ) {
					$trcount ++;
					$ka0 = 0;
					$ka1 = 0;
					if ( isset( $rows[ $i - 1 ]->id ) ) {
						if ( $rows[ $i ]->hc_width == $rows[ $i - 1 ]->hc_width ) {
							$x1  = $rows[ $i ]->id;
							$x2  = $rows[ $i - 1 ]->id;
							$ka0 = 1;
						} else {
							$jj = 2;
							while ( isset( $rows[ $i - $jj ] ) ) {
								if ( $rows[ $i ]->hc_width == $rows[ $i - $jj ]->hc_width ) {
									$ka0 = 1;
									$x1  = $rows[ $i ]->id;
									$x2  = $rows[ $i - $jj ]->id;
									break;
								}
								$jj ++;
							}
						}
						if ( $ka0 ) {
							$move_up = '<span><a href="#reorder" onclick="return listItemTask(\'' . $x1 . '\',\'' . $x2 . '\')" title="Move Up">   <img src="' . plugins_url( 'images/uparrow.png', __FILE__ ) . '" width="16" height="16" border="0" alt="Move Up"></a></span>';
						} else {
							$move_up = "";
						}
					} else {
						$move_up = "";
					}


					if ( isset( $rows[ $i + 1 ]->id ) ) {

						if ( $rows[ $i ]->hc_width == $rows[ $i + 1 ]->hc_width ) {
							$x1  = $rows[ $i ]->id;
							$x2  = $rows[ $i + 1 ]->id;
							$ka1 = 1;
						} else {
							$jj = 2;
							while ( isset( $rows[ $i + $jj ] ) ) {
								if ( $rows[ $i ]->hc_width == $rows[ $i + $jj ]->hc_width ) {
									$ka1 = 1;
									$x1  = $rows[ $i ]->id;
									$x2  = $rows[ $i + $jj ]->id;
									break;
								}
								$jj ++;
							}
						}

						if ( $ka1 ) {
							$move_down = '<span><a href="#reorder" onclick="return listItemTask(\'' . $x1 . '\',\'' . $x2 . '\')" title="Move Down">  <img src="' . plugins_url( 'images/downarrow.png', __FILE__ ) . '" width="16" height="16" border="0" alt="Move Down"></a></span>';
						} else {
							$move_down = "";
						}
					}

					$uncat = $rows[ $i ]->par_name;
					if ( isset( $rows[ $i ]->prod_count ) ) {
						$pr_count = $rows[ $i ]->prod_count;
					} else {
						$pr_count = 0;
					}


					?>
					<tr <?php if($trcount%2==0){ echo 'class="has-background"';}?>>
						<td><?php echo $rows[$i]->id; ?></td>
						<td><a  href="admin.php?page=hugeit_forms_submissions&task=view_submissions&id=<?php echo $rows[$i]->id; ?>"><?php echo esc_html(stripslashes($rows[$i]->name)); ?></a></td>
						<td>(<?php echo !($pr_count) ? '0' : $rows[$i]->prod_count; ?>)</td>
						<td><a  href="admin.php?page=hugeit_forms_submissions&task=remove_submissions&amp;id=<?php echo $rows[$i]->id; ?>">Delete</a></td>
					</tr> 
				 <?php } ?>
				</tbody>
			</table>
			<input type="hidden" name="oreder_move" id="oreder_move" value="" />
			<input type="hidden" name="asc_or_desc" id="asc_or_desc" value="<?php if(isset($_POST['asc_or_desc'])) echo esc_attr($_POST['asc_or_desc']);?>"  />
			<input type="hidden" name="order_by" id="order_by" value="<?php if(isset($_POST['order_by'])) echo esc_attr($_POST['order_by']);?>"  />
			<input type="hidden" name="saveorder" id="saveorder" value="" />

			</form>
		</div>
	</div>
</div>
    <?php
}


function hugeit_contact_html_view_submissions($submitionsArray, $submitionsCount,$limitPage,$subName,$id) {
$keyForBackground = 1;
?>
<div class="wrap">
	<?php hugeit_contact_drawFreeBanner();?>
    <div id="poststuff">
        <div id="hugeit_submission_page">
            <div class="search_block">
                <form action="admin.php?page=hugeit_forms_submissions" method="POST">
                    <input type="text" name="search_events_by_title" value="" class="search_input" placeholder="Search...">
                    <input  class="button" type="submit" value="Search">
                </form>
            </div>
            <div style="clear:both;"></div> 
            <div class="current_form"><p><?php if(isset($subName[0]->name)) echo $subName[0]->name; ?> Submissions</p></div>
            <div style="clear:both;"></div> 
            <div id="hugeit_top_controls">
                <ul class="controls-list">
                    <li class="select">
                            <input type="checkbox" name="all" />
                            <select class="">
                                    <option value="none">None</option>
                                    <option value="read">Read</option>
                                    <option value="unread">Unread</option>
                                    <option value="spam">Spam</option>
                            </select>
                    </li>
                    <li class="back"><a href="admin.php?page=hugeit_forms_submissions" title="Back">Back</a></li>
                    <li class="spam"><a href="#" title="Mark as Spam">Spam</a></li>
                    <li class="trash"><a href="#">Trash</a></li>
                    <li class="refrash"><a href="#">Refresh</a></li>
                    <li class="select_actions">
                            <select>
                                    <option value="none">Bulk Actions</option>
                                    <option value="read">Mark as Read</option>
                                    <option value="unread">Mark as Unread</option>
                                    <option value="spam">Mark as Spam</option>
                                    <option value="unspam">Unmark as Spam</option>
                            </select>
                    </li>
                    <li>
                    <a class="apply" href="#">Apply</a>
                    </li>
                    <li>
                        <img class="control_list_spinner" src="<?php echo plugins_url( '../images/spinner.gif', __FILE__ ); ?>">
                    </li>
                </ul>
                <?php
                	echo do_action('huge_it_forms_export_single',$id);
                if($limitPage['count_pages'] >1):?>
                <div class="page-navigation">
                        <span class="count"><?php if(isset($limitPage['countOfPages'])&&$limitPage['countOfPages'] > $limitPage['perpage'] && $limitPage['countOfPages']!=0 ){ echo $limitPage['start']."-".$limitPage['fromTo']." From ".$limitPage['countOfPages']; }?></span>
                        <div class="buttons">
                            <form action="admin.php?page=hugeit_forms_submissions" method="POST">
                                <a <?php if($limitPage['page'] <= 1) echo'style="display:none;"'; ?> href="<?php echo $limitPage['prevLink']; ?>" class="prev">Prev</a>
                                <a <?php if($limitPage['page'] >= $limitPage['count_pages']) echo'style="display:none;"'; ?> href="<?php echo $limitPage['nextLink']; ?>" class="next">Next</a>                                
                            </form>
                        </div>
                </div>
            	<?php endif;?>
            </div>
            <table class="wp-list-table widefat fixed pages" style="width:100%">
                <thead>
                     <tr>
                        <th scope="col" id="id" style="width:5%" ><span></span><span class="sorting-indicator"></span></th>
                        <th scope="col" id="name" style="width:24%" ><span>User Message</span><span class="sorting-indicator"></span></th>
                        <th scope="col" id="name" style="width:24%" ><span>User Country</span><span class="sorting-indicator"></span></th>                        
                        <th scope="col" id="prod_count"  style="width:24%;" ><span>User Submission Date</span><span class="sorting-indicator"></span></th>
                        <th scope="col" id="prod_count"  style="width:24%;" ><span>User IP</span><span class="sorting-indicator"></span></th>
                     </tr>
                </thead>		
				<tbody id="the-comment-list" data-wp-lists="list:comment">
				<?php foreach ($submitionsArray as $submition) {?>
				    <tr id="comment-<?php echo $submition->id; ?>" class="comment even thread-even <?php if($submition->customer_read_or_not == 1){ echo "read"; } else { echo "unread"; } if($submition->customer_spam == 1){ echo " spam"; } else { echo ""; }?> depth-<?php echo $keyForBackground; if($keyForBackground%2 == 0) echo " alt"; ?> ">
				        <th scope="row" class="check-column">
				            <label class="screen-reader-text" for="cb-select-<?php echo $submition->id; ?>">Select Submission</label>
				            <input id="cb-select-<?php echo $keyForBackground; ?>" type="checkbox" name="check_comments" value="<?php echo $submition->id; ?>">
				        </th>
				        <td class="comment column-comment">
				            <div class="comment-author">
				            </div>
				            <div class="submitted-on">Submitted on <a><?php echo "  ".$submition->submission_date; ?></a></div>
				                <div class="submition_message" id_for_edit="<?php echo $submition->id; ?>" readonly>
				                </div>
				            <div id="inline-1" class="hidden">
				            <textarea class="comment" rows="1" cols="1" readonly="readonly" ></textarea>
				            <div class="author-email"></div>
				            <div class="author"></div>
				            <div class="comment_status">1</div>
				            </div>
				            <div class="row-actions">
				                <span class="edit" value="<?php echo $submition->id; ?>">
				                    <?php if ($submition->customer_read_or_not == 1):?>
				                    <a href="admin.php?page=hugeit_forms_submissions&task=show_submissions&id=<?php echo $submition->id; ?>&submissionsId=<?php echo $submition->contact_id; ?>">Show</a>
				                    <?php else:?>
				                    <a href="admin.php?page=hugeit_forms_submissions&task=show_submissions&id=<?php echo $submition->id; ?>&read=unread&submissionsId=<?php echo $submition->contact_id; ?>">Show</a>
				                    <?php endif;?>
				                </span>
				                <span class="spam" value="<?php echo $submition->id; ?>" style='<?php  if($submition->customer_spam == 1) { echo "display: none"; } ?>'>  |
				                    <a class="vim-s vim-destructive" title="Mark this comment as spam">Spam</a>
				                </span>
				                <span class="not_spam" value="<?php echo $submition->id; ?>" style='<?php  if($submition->customer_spam != 1) { echo "display: none"; } ?>'>  |
				                    <a class="vim-s vim-destructive" title="Unmark as Spam">Not Spam</a>
				                </span>
				                <span class="trash" value="<?php echo $submition->id; ?>"> |
				                    <a class="delete vim-d vim-destructive" title="Move this comment to the trash">Trash</a>
				                </span>
				                <span id="huge_it_spinner_<?php echo $submition->id; ?>" class="huge_it_spinner">
				                    <img src="<?php echo plugins_url( '../images/spinner.gif', __FILE__ ); ?>">
				                </span>
				            </div>
				        </td>
				        <td class="author column-author user-name">
				            <?php if ($submition->customer_read_or_not == 1):?>
							<a href="admin.php?page=hugeit_forms_submissions&task=show_submissions&id=<?php echo $submition->id; ?>&submissionsId=<?php echo $submition->contact_id; ?>"><?php echo $submition->customer_country; ?></a>
				            <p class='spamer' <?php  if($submition->customer_spam != 1) echo "style= 'display: none'"; ?>>Spam!</p>
				            <?php else:?>
				            <a href="admin.php?page=hugeit_forms_submissions&task=show_submissions&id=<?php echo $submition->id; ?>&read=unread&submissionsId=<?php echo $submition->contact_id; ?>"><?php echo $submition->customer_country; ?></a>
				            <p class='spamer' <?php  if($submition->customer_spam != 1) echo "style= 'display: none'"; ?>>Spam!</p>
				            <?php endif;?>
				        </td>
				        <td class="author column-author user_email">
				            <input value="<?php echo $submition->submission_date; ?>" id_for_edit="<?php echo $submition->id; ?>" readonly="readonly" />
				        </td>
				        <?php $ipOfSub = array_filter(explode("*()*", $submition->submission_ip),'strlen');?>
				        <td class="author column-author user_phone">
				            <input value="<?php echo $ipOfSub[0]; ?>" id_for_edit="<?php echo $submition->id; ?>" readonly="readonly" />
				        </td>
				    </tr>
				</tbody>
				<?php $keyForBackground++; } ?>
			</table>
			<input type="hidden" name="oreder_move" id="oreder_move" value="" />
			<input type="hidden" name="asc_or_desc" id="asc_or_desc" value="<?php if(isset($_POST['asc_or_desc'])) echo $_POST['asc_or_desc'];?>"  />
			<input type="hidden" name="order_by" id="order_by" value="<?php if(isset($_POST['order_by'])) echo $_POST['order_by'];?>"  />
			<input type="hidden" name="saveorder" id="saveorder" value="" />
			<input type="hidden" name="countTorefresh" id="countTorefresh" value="<?php echo $submitionsCount[0]->all_count; ?>" />
			<input type="hidden" name="subID" id="subID" value="<?php if(isset($submition->contact_id)) {echo $submition->contact_id;}else {echo 'empty';} ?>" />
			<div id="huge-it-contact-dialog-confirm" title="Delete Submission(s)">Are you sure?</div>
    </div>
</div>
	<script>
    jQuery(window).load(function() {
        jQuery("#the-comment-list tr.comment").each(function(){
            jQuery(this).find(".message-block tr").each(function(){
                var this_class = jQuery(this).attr("class");
                if( this_class !== "message-text"){
                    jQuery(this).closest(".submition_message").css({ "opacity" : 1 });
                    jQuery(this).remove();
                }
            });
        });
    });
</script>
<?php }

function hugeit_contact_html_show_messages($messageInArray, $submitionsCount) {
	if ( isset( $_GET["id"] ) ) {
		$custom_id       = '';
		$current_page_id = (int) $_GET["id"];
		$max_count       = count( $submitionsCount );
		$myNum           = 1;
		foreach ( $submitionsCount AS $num => $submition ) {
			if ( $submition->id == $current_page_id ) {
				$myNum     = $num + 1;
				$custom_id = $num;
			}
		}
		$current_page_url = $_SERVER["REQUEST_URI"];
		$current_page_url = strstr( $current_page_url, 'admin.php' );
		if ( array_key_exists( $custom_id - 1, $submitionsCount ) ) {
			$previous_page_id = $submitionsCount[ $custom_id - 1 ]->id;
		} else {
			$previous_page_id = $submitionsCount[0]->id;
		}
		if ( array_key_exists( $custom_id + 1, $submitionsCount ) ) {
			$next_page_id = $submitionsCount[ $custom_id + 1 ]->id;
		} else {
			$next_page_id = $submitionsCount[0]->id;
		}
		$next_page_url     = str_replace( $current_page_id, $next_page_id, $current_page_url );
		$previous_page_url = str_replace( $current_page_id, $previous_page_id, $current_page_url );
	}
require_once dirname(__FILE__) ."/../hugeit_contact_function/download.php";
?>
<div class="wrap">
	<?php hugeit_contact_drawFreeBanner();?>
    <div id="poststuff">
        <div id="hugeit_single_submission_page">
            <h2>User Submission</h2>
            <div style="clear: both;"></div>
            <div id="hugeit_top_controls">
                <ul class="controls-list" style="overflow: hidden;margin: 3px 0;">
                        <li class="back"><a href="admin.php?page=hugeit_forms_submissions&task=view_submissions&id=<?php echo $messageInArray[0]->contact_id; ?>" title="Back">Back</a></li>
                        <li class="spam <?php if($messageInArray[0]->customer_spam==1) echo "spamed"?>" value="<?php echo $messageInArray[0]->id; ?>" need_to_reload="yes" ><a href="#" title="Mark as spam">Spam</a></li>
                        <li class="trash" value="<?php echo $messageInArray[0]->id; ?>" need_to_reload="yes" title="Delete"><a href="admin.php?page=hugeit_forms_submissions&task=remove_submissions&amp;id=<?php echo $messageInArray[0]->id; ?>&subId=<?php echo $messageInArray[0]->contact_id; ?>">Trash</a></li>
                        <li>
                        	<img class="control_list_spinner" src="<?php echo plugins_url( '../images/spinner.gif', __FILE__ ); ?>">
                        </li>
                </ul>
                <div class="page-navigation">
                        <span class="count"><?php echo "Submission ". $myNum . " Of " . $max_count; ?></span>
                        <div class="buttons">
                                <?php
                                    if($myNum > 1){
                                        echo "<a href='".$previous_page_url."' class='prev' >Prev</a>";
                                    }                                  
                                    if($myNum < $max_count){
                                        echo "<a href='".$next_page_url."' class='next' >Next</a>";
                                    }
                                ?>
                        </div>
                </div> 
            </div>
            <div style="clear: both;"></div>
            <div id="hugeit_messages_content">
            	<div id="submission_details">
            		<?php $ipOfSub2 = array_filter(explode("*()*", $messageInArray[0]->submission_ip),'strlen');?>			
					<table class="detailsTable">
						<tr><td>Submission Date:</td><td ><?php echo $messageInArray[0]->submission_date; ?></td></tr>
						<tr><td>User Browser:</td><td><?php if(isset($ipOfSub2[1])){echo $ipOfSub2[1].'  <img style="vertical-align: sub;"src="'.plugins_url( '../images/'.$ipOfSub2[1].'.png', __FILE__ ).'">';}else{echo '';} ?></td></tr>
						<tr><td>User Country:</td><td><?php echo $messageInArray[0]->customer_country; ?></td></tr>
						<tr><td>User IP:</td><td><?php echo $ipOfSub2[0]; ?></td></tr>

					</table>
				</div>
				<hr style="border: 1px dashed #ddd;">
                <div id="submission_content">
					<br>
            	<?php
		            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		            $messagelabbelsexp = array_filter( explode( "*()*", $messageInArray[0]->sub_labels ), 'strlen' );
		            $messagesubmisexp = explode( "*()*", $messageInArray[0]->submission );
		            $filesUrlExploded = array_filter( explode( "*()*", $messageInArray[0]->files_url ), 'strlen' );
		            $filesTypeExploded = array_filter( explode( "*()*", $messageInArray[0]->files_type ), 'strlen' );
					$separator=':';
					foreach($messagelabbelsexp as $key=>$messagelabbelsexpls){	
						if(isset($messagesubmisexp[$key]) && $messagesubmisexp[$key]!=''){
							echo '<strong>'.$messagelabbelsexpls.'</strong> '.$separator.' '.$messagesubmisexp[$key].'<br>';						
						}
					}
					?>
					<div style="clear:both;"></div>
					<?php
					if ( ! empty( $filesUrlExploded ) && ! empty( $filesTypeExploded ) ): ?>
						<div id="submission_attachements">
							<hr>
							<h3>File Attachements</h3>
							<div class="attachement_wrapper">
								<form id="my_form" action="hugeit_contact_ajax.php" method="post">
								<?php foreach ($filesTypeExploded as $key => $filesTypeExplodeds) {
									$link_pattern='/^(.*)\/uploads\//';
									$file_path=preg_replace($link_pattern,'',$filesUrlExploded[$key]);
									$secure_link = wp_nonce_url($actual_link.'&file='.$file_path,'hugeit_contact_donwload_file');

									if(preg_match('/image\//',$filesTypeExplodeds)){
										$link_pattern='/^(.*)\/uploads\//';
										$file_path=preg_replace($link_pattern,'',$filesUrlExploded[$key]);
									?>
									<a href="<?php echo esc_attr($secure_link) ;?>" class="file_wrapper image">
										<div class="wrapper_icon image_wrapper_icon"></div>
										<div class="file_info"><?php
											$pattern='/^(.*)\//';
											$filesUrlExploded[$key]=preg_replace($pattern,'',$filesUrlExploded[$key]);
											echo $filesUrlExploded[$key];
									 ?></div>
									</a>
									<?php
									}elseif(preg_match('/pdf/',$filesTypeExplodeds)){
										$link_pattern='/^(.*)\/uploads\//';
										$file_path=preg_replace($link_pattern,'',$filesUrlExploded[$key]);
									?>
										<a href="<?php echo esc_attr($secure_link) ;?>" class="file_wrapper pdf">
											<div class="wrapper_icon pdf_wrapper_icon"></div>
											<div class="file_info"><?php
											$pattern='/^(.*)\//';
											$filesUrlExploded[$key]=preg_replace($pattern,'',$filesUrlExploded[$key]);
											echo $filesUrlExploded[$key];
										 ?></div>
										</a>
									<?php
									}elseif(preg_match('/application\/msword/',$filesTypeExplodeds)||preg_match('/application\/vnd.openxmlformats-officedocument.wordprocessingml.document/',$filesTypeExplodeds)){
										$link_pattern='/^(.*)\/uploads\//';
										$file_path=preg_replace($link_pattern,'',$filesUrlExploded[$key]);
									?>
										<a href="<?php echo esc_attr($secure_link) ;?>" class="file_wrapper word">
											<div class="wrapper_icon word_wrapper_icon"></div>
											<div class="file_info"><?php
											$pattern='/^(.*)\//';
											$filesUrlExploded[$key]=preg_replace($pattern,'',$filesUrlExploded[$key]);
											echo $filesUrlExploded[$key];
										 ?></div>
										</a>
									<?php
									}elseif(preg_match('/application\/zip/',$filesTypeExplodeds)||preg_match('/application\/x-gzip/',$filesTypeExplodeds)){
										$link_pattern='/^(.*)\/uploads\//';
										$file_path=preg_replace($link_pattern,'',$filesUrlExploded[$key]);
									?>
										<a href="<?php echo esc_attr($secure_link) ;?>" class="file_wrapper zip">
											<div class="wrapper_icon zip_wrapper_icon"></div>
											<div class="file_info"><?php
											$pattern='/^(.*)\//';
											$filesUrlExploded[$key]=preg_replace($pattern,'',$filesUrlExploded[$key]);
											echo $filesUrlExploded[$key];
										 ?></div>
										</a>
									<?php
									}elseif(preg_match('/application\/rar/',$filesTypeExplodeds)||preg_match('/application\/x-7z-compressed/',$filesTypeExplodeds)){
										$link_pattern='/^(.*)\/uploads\//';
										$file_path=preg_replace($link_pattern,'',$filesUrlExploded[$key]);
									?>
										<a href="<?php echo esc_attr($secure_link) ;?>" class="file_wrapper rar">
											<div class="wrapper_icon rar_wrapper_icon"></div>
											<div class="file_info"><?php
											$pattern='/^(.*)\//';
											$filesUrlExploded[$key]=preg_replace($pattern,'',$filesUrlExploded[$key]);
											echo $filesUrlExploded[$key];
										 ?></div>
										</a>
									<?php
									}elseif(preg_match('/application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet/',$filesTypeExplodeds)){
										$link_pattern='/^(.*)\/uploads\//';
										$file_path=preg_replace($link_pattern,'',$filesUrlExploded[$key]);
									?>
										<a href="<?php echo esc_attr($secure_link) ;?>" class="file_wrapper excel">
											<div class="wrapper_icon excel_wrapper_icon"></div>
											<div class="file_info"><?php
											$pattern='/^(.*)\//';
											$filesUrlExploded[$key]=preg_replace($pattern,'',$filesUrlExploded[$key]);
											echo $filesUrlExploded[$key];
										 ?></div>
										</a>
									<?php
									}elseif(preg_match('/audio\//',$filesTypeExplodeds)){
										$link_pattern='/^(.*)\/uploads\//';
										$file_path=preg_replace($link_pattern,'',$filesUrlExploded[$key]);
									?>
										<a href="<?php echo esc_attr($secure_link) ;?>" class="file_wrapper audio">
											<div class="wrapper_icon audio_wrapper_icon"></div>
											<div class="file_info"><?php
											$pattern='/^(.*)\//';
											$filesUrlExploded[$key]=preg_replace($pattern,'',$filesUrlExploded[$key]);
											echo $filesUrlExploded[$key];
										 ?></div>
										</a>
									<?php
									}elseif(preg_match('/video\//',$filesTypeExplodeds)){
										$link_pattern='/^(.*)\/uploads\//';
										$file_path=preg_replace($link_pattern,'',$filesUrlExploded[$key]);
									?>
										<a href="<?php echo esc_attr($secure_link) ;?>" class="file_wrapper video">
											<div class="wrapper_icon video_wrapper_icon"></div>
											<div class="file_info"><?php
											$pattern='/^(.*)\//';
											$filesUrlExploded[$key]=preg_replace($pattern,'',$filesUrlExploded[$key]);
											echo $filesUrlExploded[$key];
										 ?></div>
										</a>
									<?php
									}elseif(preg_match('/text\/csv/',$filesTypeExplodeds)){
										$link_pattern='/^(.*)\/uploads\//';
										$file_path=preg_replace($link_pattern,'',$filesUrlExploded[$key]);
									?>
										<a href="<?php echo esc_attr($secure_link) ;?>" class="file_wrapper csv">
											<div class="wrapper_icon csv_wrapper_icon"></div>
											<div class="file_info"><?php
											$pattern='/^(.*)\//';
											$filesUrlExploded[$key]=preg_replace($pattern,'',$filesUrlExploded[$key]);
											echo $filesUrlExploded[$key];
										 ?></div>
										</a>
									<?php
									}else{
										$link_pattern='/^(.*)\/uploads\//';
										$file_path=preg_replace($link_pattern,'',$filesUrlExploded[$key]);
									?>
										<a href="<?php echo esc_attr($secure_link) ;?>" class="file_wrapper all">
											<div class="wrapper_icon all_wrapper_icon"></div>
											<div class="file_info"><?php
												$pattern='/^(.*)\//';
												$filesUrlExploded[$key]=preg_replace($pattern,'',$filesUrlExploded[$key]);
												echo $filesUrlExploded[$key];
											?></div>
										</a>
									<?php
									}
								}
								?>
								</form>
							</div>
						</div>
					<?php endif; ?>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </div>
</div>
    
    
<?php } ?>
