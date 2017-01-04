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
function html_showhugeit_contacts( $rows,$pageNav,$sort,$cat_row,$a,$form_styles){
	global $wpdb;
	?>
<div class="wrap">
	<?php hugeit_contact_drawFreeBanner();?>
	<div id="poststuff">
		<div id="hugeit_contacts-list-page">
			<form method="post"  onkeypress="doNothing()" action="admin.php?page=hugeit_forms_main_page" id="admin_form" name="admin_form">
			<h2>Huge IT Forms
				<a onclick="window.location.href='<?php echo wp_nonce_url(admin_url('admin.php?page=hugeit_forms_main_page&task=add_cat'), 'add_form', 'hugeit_contact_add_form_nonce');?>'" class="add-new-h2" >Add New Form</a>
			</h2>
			<?php

			$serch_value='';
			if ( ! isset( $_POST['search_events_by_title'] ) ) {
				$_POST['search_events_by_title'] = '';
			}
			if ( isset( $_POST['serch_or_not'] ) ) {
				if ( $_POST['serch_or_not'] == "search" ) {
					$serch_value = esc_html( stripslashes( $_POST['search_events_by_title'] ) );
				} else {
					$serch_value = "";
				}
			}
			$serch_fields='<div class="alignleft actions"">
									<label for="search_events_by_title" style="font-size:14px">Filter: </label>
									<input type="text" name="search_events_by_title" value="'.$serch_value.'" id="search_events_by_title" onchange="hugeit_contact_clear_search_texts()">
							</div>				
							<div class="alignleft actions">
								<input type="button" value="Search" onclick="document.getElementById(\'page_number\').value=\'1\'; document.getElementById(\'serch_or_not\').value=\'search\';
								 document.getElementById(\'admin_form\').submit();" class="button-secondary action">
								 <input type="button" value="Reset" onclick="window.location.href=\'admin.php?page=hugeit_forms_main_page\'" class="button-secondary action">
							</div>';

			 hugeit_contact_print_html_nav($pageNav['total'],$pageNav['limit'],$serch_fields);
			?>
			<table class="wp-list-table widefat fixed pages" style="width:95%">
				<thead>
				 <tr>
					<th scope="col" id="id" style="width:30px" ><span>ID</span><span class="sorting-indicator"></span></th>
					<th scope="col" id="name" style="width:85px" ><span>Name</span><span class="sorting-indicator"></span></th>
					<th scope="col" id="prod_count"  style="width:75px;" ><span>Fields</span><span class="sorting-indicator"></span></th>
					 <th style="width:40px"><span>Duplicate</span><span class="sorting-indicator"></span></th>
					 <th style="width:40px"><span>Delete</span><span class="sorting-indicator"></span></th>
				 </tr>
				</thead>
				<tbody>
				 <?php 
				 $trcount=1;
				  for($i=0; $i<count($rows);$i++){
					$trcount++;
					$ka0=0;
					$ka1=0;
					if(isset($rows[$i-1]->id)){
						  if($rows[$i]->hc_width==$rows[$i-1]->hc_width){
						  $x1=$rows[$i]->id;
						  $x2=$rows[$i-1]->id;
						  $ka0=1;
						  }
						  else
						  {
							  $jj=2;
							  while(isset($rows[$i-$jj]))
							  {
								  if($rows[$i]->hc_width==$rows[$i-$jj]->hc_width)
								  {
									  $ka0=1;
									  $x1=$rows[$i]->id;
									  $x2=$rows[$i-$jj]->id;
									   break;
								  }
								$jj++;
							  }
						  }
						  if($ka0){
							$move_up='<span><a href="#reorder" onclick="return listItemTask(\''.$x1.'\',\''.$x2.'\')" title="Move Up">   <img src="'.plugins_url('images/uparrow.png',__FILE__).'" width="16" height="16" border="0" alt="Move Up"></a></span>';
						  }
						  else{
							$move_up="";
						  }
					}else{$move_up="";}							
					if(isset($rows[$i+1]->id)){
						
						if($rows[$i]->hc_width==$rows[$i+1]->hc_width){
						  $x1=$rows[$i]->id;
						  $x2=$rows[$i+1]->id;
						  $ka1=1;
						}
						else
						{
							  $jj=2;
							  while(isset($rows[$i+$jj]))
							  {
								  if($rows[$i]->hc_width==$rows[$i+$jj]->hc_width)
								  {
									  $ka1=1;
									  $x1=$rows[$i]->id;
									  $x2=$rows[$i+$jj]->id;
									  break;
								  }
								$jj++;
							  }
						}
						
						if($ka1){
							$move_down='<span><a href="#reorder" onclick="return listItemTask(\''.$x1.'\',\''. $x2.'\')" title="Move Down">  <img src="'.plugins_url('images/downarrow.png',__FILE__).'" width="16" height="16" border="0" alt="Move Down"></a></span>';
						}else{
							$move_down="";	
						}
					}

					  $uncat = $rows[ $i ]->par_name;
					  if ( isset( $rows[ $i ]->prod_count ) ) {
						  $pr_count = $rows[ $i ]->prod_count;
					  } else {
						  $pr_count = 0;
					  }
					  $edit_form_safe_link = wp_nonce_url(
						  'admin.php?page=hugeit_forms_main_page&task=edit_cat&id=' . $rows[$i]->id,
						  'edit_form_' . $rows[$i]->id,
						  'hugeit_contact_edit_form_nonce'
					  );
					$remove_form_safe_link = wp_nonce_url(
						admin_url('admin.php?page=hugeit_forms_main_page&task=remove_cat&id=' . $rows[$i]->id.''),
						'remove_form_' . $rows[$i]->id,
						'hugeit_forms_remove_form_nonce'
					);
					?>
					<tr <?php if ($trcount%2==0) { echo 'class="has-background"';}?>>
						<td><?php echo $rows[$i]->id; ?></td>
						<td><a  href="<?php echo $edit_form_safe_link; ?>"><?php echo esc_html(stripslashes($rows[$i]->name)); ?></a></td>
						<td>(<?php if(!($pr_count)){echo '0';} else{ echo $rows[$i]->prod_count;} ?>)</td>
						<td>
							<a
								href="#"
								class="copy-field hugeit_contact_duplicate_form"
								data-form-id="<?php echo $rows[$i]->id; ?>"
								data-nonce="<?php echo wp_create_nonce('duplicate_form_' . $rows[$i]->id) ?>"></a>
						</td>
						<td><a href="<?php echo $remove_form_safe_link; ?>" class="hugeit_forms_delete_form"><span class="hugeit-contact-delete"></span></a></td>
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
function hugeit_contact_html_edithugeit_contact($id, $ord_elem, $count_ord,$images, $row, $cat_row, $rowim, $rowsld, $paramssld, $rowsposts, $rowsposts8, $postsbycat, $form_styles,$style_values,$themeId){
 	global $wpdb;
	
	if(isset($_GET["addslide"]) && $_GET["addslide"] == 1){
		$apply_safe_link = wp_nonce_url(
			'admin.php?page=hugeit_forms_main_page&id=' . $row->id . '&task=apply',
			'apply_form_' . $row->id,
			'hugeit_contact_apply_form_nonce'
		);
		$apply_safe_link = htmlspecialchars_decode($apply_safe_link);
		header('Location: ' . $apply_safe_link);
	}
	
	if (isset($_GET["inputtype"]) && $_GET["inputtype"]) {
		$apply_safe_link = wp_nonce_url(
			'admin.php?page=hugeit_forms_main_page&id=' . $row->id . '&task=apply',
			'apply_form_' . $row->id,
			'hugeit_contact_apply_form_nonce'
		);
		$apply_safe_link = htmlspecialchars_decode($apply_safe_link);

		header('Location: ' . $apply_safe_link);
	}	
?>
<script type="text/javascript">
function submitbuttonSave(pressbutton){
	window.onbeforeunload = null;
	if(!document.getElementById('huge_it_contact_formname').value){
		alert("Name is required.");
		return;
	}
	document.getElementById("adminForm").action=document.getElementById("adminForm").action+"&task=apply&inputtype="+pressbutton+"";
	document.getElementById("adminForm").submit();
}
function submitbuttonRemove(pressbutton){
	window.onbeforeunload = null;
	if(!document.getElementById('huge_it_contact_formname').value){
		alert("Name is required.");
		return;
	}	
	document.getElementById("adminForm").action=document.getElementById("adminForm").action+"&task=apply&removeslide="+pressbutton;
	document.getElementById("adminForm").submit();
}
function submitbutton(pressbutton){
	window.onbeforeunload = null;
	if(!document.getElementById('huge_it_contact_formname').value){
		alert("Name is required.");
		return;
	}
	document.getElementById("adminForm").action=document.getElementById("adminForm").action+"&task="+pressbutton;
	document.getElementById("adminForm").submit();
}
</script>
<!-- GENERAL PAGE, ADD FIELDS PAGE -->
<div class="wrap">
	<?php
	hugeit_contact_drawFreeBanner();
	$apply_safe_link = wp_nonce_url(
		'admin.php?page=hugeit_forms_main_page&id=' . $id,
		'apply_form_' . $id,
		'hugeit_contact_apply_form_nonce'
	);
	?>
<form action="<?php echo $apply_safe_link; ?>" method="post" name="adminForm" id="adminForm">
	<div id="poststuff" >
	<div class="hugeit_tabs_block">
		<ul id="" class="hugeit_contact_top_tabs">			
			<?php
			foreach ($rowsld as $rowsldires) :
				if ($rowsldires->id != $_GET['id']) :
					$edit_form_safe_link = wp_nonce_url(
						'admin.php?page=hugeit_forms_main_page&task=edit_cat&id=' . $rowsldires->id,
						'edit_form_' . $rowsldires->id,
						'hugeit_contact_edit_form_nonce'
					);
				?>
					<li>
						<a href="#" onclick="window.location.href='<?php echo $edit_form_safe_link; ?>'" ><?php echo $rowsldires->name; ?></a>
					</li>
				<?php
				else : ?>
					<li class="active" onclick="this.firstElementChild.style.width = ((this.firstElementChild.value.length + 1) * 8) + 'px';" style="background-image:url(<?php echo plugins_url('../images/edit.png', __FILE__) ;?>);cursor:pointer;">
						<input class="text_area" onfocus="this.style.width = ((this.value.length + 1) * 8) + 'px'" type="text" name="name" id="huge_it_contact_formname" maxlength="250" value="<?php echo esc_html(stripslashes($row->name));?>" />
					</li>
				<?php	
				endif;
			endforeach;
			?>
			<li class="add-new">
				<a onclick="window.location.href='<?php echo wp_nonce_url(admin_url('admin.php?page=hugeit_forms_main_page&task=add_cat'), 'add_form', 'hugeit_contact_add_form_nonce');?>'">+</a>
			</li>
		</ul>
	</div>
	<div id="post-body" class="metabox-holder huge_contacts columns-2">
		<!-- Content -->
		<div id="post-body-content">
		<?php add_thickbox(); ?>
			<div id="post-body-heading">
				<div id="save-button-block">
					<div class="saveSpinnerWrapper">
						<img src="<?php echo plugins_url( '../images/spinner.gif', __FILE__ ); ?>">		
					</div>			
					<input type="button" value="Save Form" id="save-buttom" class="button button-primary button-large">
					<button class="button" id="shortcode_toggle">Get Shortcode</button>
					<label for="select_form_theme">Select Theme</label>
					<select width="200" id="select_form_theme" name="select_form_theme" class="select-theme">
					<?php foreach($form_styles as $form_style){ ?>
						<option <?php if($form_style->id == $row->hc_yourstyle){ echo 'selected'; } ?> value="<?php echo $form_style->id; ?>"><?php echo $form_style->name; ?></option>
					<?php } ?>
					</select>
					<label for="select_form_show_title">Show Form Title</label>
					<select id="select_form_show_title" name="hugeit_contact_show_title_for_form_<?php echo $id; ?>">
						<option value="default">Use Default Settings</option>
						<option value="yes" <?php if (get_option('hugeit_contact_show_title_for_form_' . $id) === 'yes') echo ' selected' ?>>Yes</option>
						<option value="no" <?php if (get_option('hugeit_contact_show_title_for_form_' . $id) === 'no') echo ' selected' ?>>No</option>
					</select>
					<img class="themeSpinner" src="<?php echo plugins_url( '../images/spinner.gif', __FILE__ ); ?>">						
				</div>
				<div id="shortcode_fields">
					<div class="short_incl"><label for="short_text">Shortcode</label>
						<textarea id="short_text" readonly="readonly">[huge_it_forms id="<?php echo esc_html(stripslashes($id)); ?>"]</textarea>
					</div>
					<div class="templ_incl"><label for="temp_text">Template Include</label>
						<textarea id="temp_text" readonly="readonly">&lt;?php echo do_shortcode("[huge_it_forms id='<?php echo esc_html(stripslashes($id)); ?>']"); ?&gt;</textarea>
					</div>
				</div>
				<?php
				$fordisablebut = '0';						
				foreach ($rowim as $key=>$rowimages){
					if($rowimages->conttype == 'buttons'){ 
					$fordisablebut = '1';
					}
				}	
				$fordisablecaptcha = '0';
				foreach ($rowim as $key=>$rowimages){
					if($rowimages->conttype == 'captcha'){ 
					$fordisablecaptcha = '1';
					}
				}	
				$fordisablelicense = '0';
				foreach ($rowim as $key=>$rowimages){
					if($rowimages->conttype == 'license'){ 
					$fordisablelicense = '1';
					}
				}						
				?>
				<ul id="add-fields-block">
					<li class="spinnerLi" data-idForm="<?php echo $id;?>">
						<img class="defSpin" src="<?php echo plugins_url( '../images/spinner.gif', __FILE__ ); ?>">
					</li>
					<li>
						<strong>Add Form Fields</strong>
						<ul id="add-default-fields">
							<li><a onclick="" class="" id="text" data-formId="<?php echo $id;?>" data-themeId="<?php echo $row->hc_yourstyle;?>">Text Box</a><li>
							<li><a onclick="" class="" id="textarea" data-formId="<?php echo $id;?>" data-themeId="<?php echo $row->hc_yourstyle;?>">Textarea</a></li>
							<li><a onclick="" class="" id="e_mail" data-formId="<?php echo $id;?>" data-themeId="<?php echo $row->hc_yourstyle;?>">Email</a></li>
							<li><a onclick="" class="" id="selectbox" data-formId="<?php echo $id;?>" data-themeId="<?php echo $row->hc_yourstyle;?>">Selectbox</a></li>
							<li><a onclick="" class="" id="checkbox" data-formId="<?php echo $id;?>" data-themeId="<?php echo $row->hc_yourstyle;?>">Checkbox</a></li>
							<li><a onclick=""  class="" id="radio_box" data-formId="<?php echo $id;?>" data-themeId="<?php echo $row->hc_yourstyle;?>">Radio Box</a></li>
							<li><a onclick="" class="" id="file_box" data-formId="<?php echo $id;?>" data-themeId="<?php echo $row->hc_yourstyle;?>">File Box</a></li>
							<li><a onclick="submitbuttonSave('custom_text')" class="" id="custom_text" data-formId="<?php echo $id;?>" data-themeId="<?php echo $row->hc_yourstyle;?>">Custom Text</a></li>


							<?php if ( $fordisablecaptcha == 0 ) :
								if ( $paramssld['form_captcha_public_key'] != '' and $paramssld['form_captcha_private_key'] != '' ) :
									?>
									<li class="bbdisabled"><a onclick="" class="captcha" id="captcha"
									                          data-formId="<?php echo $id; ?>"
									                          data-themeId="<?php echo $row->hc_yourstyle; ?>">Captcha</a>
									</li>
								<?php else : ?>
									<li class="bbdisabled"><a
											href="admin.php?page=hugeit_forms_main_page&task=captcha_keys&id=<?php echo esc_html( $_GET['id'] ); ?>&TB_iframe=1"
											id="Nocaptcha" data-formId="<?php echo $id; ?>"
											data-themeId="<?php echo $row->hc_yourstyle; ?>"
											class="thickbox">Captcha</a></li>
									<?php
								endif;
							else : ?>
								<li class="disabled"><a onclick="" class="captcha" id="captcha"
								                        data-formId="<?php echo $id; ?>"
								                        data-themeId="<?php echo $row->hc_yourstyle; ?>">Captcha</a>
								</li>
							<?php endif;
							if ( $fordisablebut == 0 ) : ?>
								<li class=""><a onclick="" class="" id="buttons" data-formId="<?php echo $id; ?>"
								                data-themeId="<?php echo $row->hc_yourstyle; ?>">Buttons</a></li>
							<?php else : ?>
								<li class="disabled"><a onclick="" class="" id="buttons"
								                        data-formId="<?php echo $id; ?>"
								                        data-themeId="<?php echo $row->hc_yourstyle; ?>">Buttons</a>
								</li>
							<?php endif; ?>
						</ul>
					</li>
					<li class="spinnerLi" data-idForm="<?php echo $id;?>">
						<img class="readySpin" src="<?php echo plugins_url( '../images/spinner.gif', __FILE__ ); ?>">
					</li>
					<li>
						<strong>Ready-To-Go Fields  <i>(Pro)</i></strong>
						<ul id="add-default-fields" class="readyFields">
							<li><a onclick="" class="" id="nameSurname" data-formId="<?php echo $id;?>" data-themeId="<?php echo $row->hc_yourstyle;?>">Full Name</a></li>
							<li><a onclick="" class="" id="phone" data-formId="<?php echo $id;?>" data-themeId="<?php echo $row->hc_yourstyle;?>">Phone</a></li>
							<li><a onclick="" class="" id="date" data-formId="<?php echo $id;?>" data-themeId="<?php echo $row->hc_yourstyle;?>">Date</a></li>
							<li><a onclick="" class="" id="address" data-formId="<?php echo $id;?>" data-themeId="<?php echo $row->hc_yourstyle;?>">Address</a></li>
							<?php if($fordisablelicense==0):?>
								<li><a onclick="" class="" id="license" data-formId="<?php echo $id;?>" data-themeId="<?php echo $row->hc_yourstyle;?>">Policy Agreement</a></li>
							<?php else:?>
								<li class="disabled"><a onclick="" class="" id="license" data-formId="<?php echo $id;?>" data-themeId="<?php echo $row->hc_yourstyle;?>">Policy Agreement</a></li>
							<?php endif;?>
						</ul>
					</li>
				</ul>
			</div>
			<?php
			function hugeit_contact_huge_wptiny($initArray){
					$initArray['height'] = '300px';
					$initArray['forced_root_block'] = false;
					$initArray['remove_linebreaks']=false;
				    $initArray['remove_redundant_brs'] = false;
				    $initArray['wpautop']=false;
					$initArray['setup'] ="function(ed) {
						ed.on('change',function(){
							ed.save();
						})
						ed.onKeyUp.add(function(ed, e) {
							if (jQuery('#wp-titleimage73-wrap').hasClass('tmce-active')){
							var value= tinyMCE.activeEditor.getContent();
							}else{
							var value= jQuery('#wp-titleimage73-wrap').val();
							}

							value=tinyMCE.activeEditor.getContent();
							editorchange(value);
						})

					}";
					return $initArray;
				}
				add_filter('tiny_mce_before_init', 'hugeit_contact_huge_wptiny' );
				 ?>
			<div id="fields-list-block">
				<ul id="fields-list-left" class="fields-list">
				<?php
				$backColor=1;
				$rowim = array_reverse($rowim);

				foreach ( $rowim as $key => $rowimages ) {
					if ( $rowimages->hc_left_right == 'left' ) {
						$inputtype = $rowimages->conttype;
						switch ( $inputtype ) {
							case 'text':  //1

								echo hugeit_contact_textBoxSettingsHtml( $rowimages );
								break;

							case 'textarea':  //2

								echo hugeit_contact_textareaSettingsHtml( $rowimages );
								break;
							case 'selectbox':  //3

								echo hugeit_contact_selectboxSettingsHtml( $rowimages );
								break;
							case 'checkbox':  //4

								echo hugeit_contact_checkboxSettingsHtml( $rowimages );
								break;
							case 'radio_box':  //5

								echo hugeit_contact_radioboxSettingsHtml( $rowimages );
								break;
							case 'file_box':  //6

								echo hugeit_contact_fileboxSettingsHtml( $rowimages );
								break;
							case 'custom_text':  //7

								echo hugeit_contact_cutomtextSettingsHtml( $rowimages );
								break;
							case 'captcha':  //8

								echo hugeit_contact_captchaSettingsHtml( $rowimages );
								break;
							case 'buttons':  //9

								echo hugeit_contact_buttonsSettingsHtml( $rowimages );
								break;
							case 'e_mail':  //10

								echo hugeit_contact_emailSettingsHtml( $rowimages );
								break;
						}
					}
				} ?>
				</ul>
				
				<ul id="fields-list-right" class="fields-list">		
				<?php
				foreach ($rowim as $key=>$rowimages){
				if($rowimages->hc_left_right == 'right'){
					$inputtype = $rowimages->conttype;
					switch ($inputtype) {
						case 'text':  //1
						
						echo hugeit_contact_textBoxSettingsHtml($rowimages);
						break;

						case 'textarea':  //2

						echo hugeit_contact_textareaSettingsHtml($rowimages);
						break;

						case 'selectbox':  //3
						
						echo hugeit_contact_selectboxSettingsHtml($rowimages);
						break;

						case 'checkbox':  //4
						
						echo hugeit_contact_checkboxSettingsHtml($rowimages);
						break;

						case 'radio_box':  //5
						
						echo hugeit_contact_radioboxSettingsHtml($rowimages);
						break;

						case 'file_box':  //6
						
						echo hugeit_contact_fileboxSettingsHtml($rowimages);
						break;

						case 'custom_text':  //7											
						
						echo hugeit_contact_cutomtextSettingsHtml($rowimages);
						break;

						case 'captcha':  //8
						
						echo hugeit_contact_captchaSettingsHtml($rowimages);
						break;

						case 'buttons':  //9

						echo hugeit_contact_buttonsSettingsHtml($rowimages);
						break;

						case 'e_mail':  //10
						
						echo hugeit_contact_emailSettingsHtml($rowimages);
						break;
					} 
				} 
				} ?>
				</ul>
			<div class="clear"></div>
			
			</div>
			
			
			<!-- ################################################ LIVE PREVIEW GOESE TO FRONT END #################################################### -->
			
			<style id="formStyles">
			
			#hugeit-contact-wrapper {
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
			
			#hugeit-contact-wrapper > div {
				border:<?php echo $style_values['form_border_size']; ?>px solid #<?php echo $style_values['form_border_color']; ?>;
			}
			
			#hugeit-contact-wrapper > div > h3 {
				<?php if($style_values['form_show_title']=='on'):?>
				position:relative;
				display:block;
				clear:both !important;
				padding:5px 0 10px 2% !important;
				font-size:<?php echo $style_values['form_title_size']; ?>px !important;
				line-height:<?php echo $style_values['form_title_size']; ?>px !important;
				color:#<?php echo $style_values['form_title_color']; ?> !important;
				margin: 10px 0 15px 0 !important;
				<?php else:?>
				display:none;
				<?php endif;?>
			}
			.text_area_title{
				border: 1px solid transparent !important;
				outline: none !important;
				-webkit-box-shadow: none !important;
				box-shadow: none !important;
				background-color: transparent !important;
				font-size:<?php echo $style_values['form_title_size']; ?>px !important;
				line-height:<?php echo $style_values['form_title_size']; ?>px !important;
				color:#<?php echo $style_values['form_title_color']; ?>!important;
				outline: 0 !important;
				-webkit-transition: none !important;
				transition: none !important;
			}

			/*LABELS*/
			
			#hugeit-contact-wrapper label  {
				font-size:<?php echo $style_values['form_label_size']; ?>px;
				color:#<?php echo $style_values['form_label_color']; ?>;
				font-family:<?php echo $style_values['form_label_font_family']; ?>;
			}
			#hugeit-contact-wrapper .hugeit-contact-column-block > div > label {
				display:block;
				width:38%;
				float:left;
				margin-right:2%;
				cursor: move;
			}
			#hugeit-contact-wrapper .hugeit-contact-column-block > div .field-block {
				display:inline-block;
				width:60%;
				/*min-width:150px;*/
			}
			#hugeit-contact-wrapper label.error {
				color:#<?php echo $style_values['form_label_error_color']; ?>;
			}
			#hugeit-contact-wrapper label em.required-star{
				color: #<?php echo $style_values['form_label_required_color']; ?>;
			}
			#hugeit-contact-wrapper .hugeit-contact-column-block > div .field-block ul li label span.sublable{vertical-align: super;}

			#hugeit-contact-wrapper .hugeit-contact-column-block > div > label.formsRightAlign{
				text-align: right !important;
			}
			#hugeit-contact-wrapper .hugeit-contact-column-block > div > label.formsAboveAlign{
				width:100% !important;
				float:none !important;
				padding-bottom: 5px !important;
			}
			#hugeit-contact-wrapper .hugeit-contact-column-block > div .formsAboveAlign {
				width:100% !important;				
			}
			#hugeit-contact-wrapper .hugeit-contact-column-block > div > label.formsInsideAlign{
				display:none !important;				
			}
			#hugeit-contact-wrapper .hugeit-contact-column-block > div .formsInsideAlign {
				width:100% !important;
			}
			/*FIELDS CUSTOM STYLES*/
				/*############INPUT TEXT############*/

				.input-text-block input,.input-text-block input:focus {
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
				}
				/*############TEXTAREA############*/

				.textarea-block textarea {
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
				}
				
				/*############CHECKBOX RADIOBOX############ */

				 .hugeit-checkbox-list li {
					width:<?php echo $rowimages->id; ?>px;
				 }
			
			
				.radio-block, .checkbox-block {
					position:relative;
					float:left;
					margin:0 5px 0 5px;
					display: block;
				}
				
				.radio-block input, .checkbox-block input {
					visibility:hidden;
					position:absolute;
					top:0;
					left:0;
				}
				
				.radio-block i {
					display:inline-block;
					float:left;
					width:20px;
					color:#<?php echo $style_values['form_radio_color']; ?>;
				}
				
				 .checkbox-block i {
					display:inline-block;
					float:left;
					width:20px;
					color:#<?php echo $style_values['form_checkbox_color']; ?>;
				 }
				
				#hugeit-contact-wrapper.big-radio .radio-block i ,#hugeit-contact-wrapper.big-checkbox .checkbox-block i {font-size:24px;}
				#hugeit-contact-wrapper.medium-radio .radio-block i ,#hugeit-contact-wrapper.medium-checkbox .checkbox-block i {font-size:20px;}
				#hugeit-contact-wrapper.small-radio .radio-block i ,#hugeit-contact-wrapper.small-checkbox .checkbox-block i {font-size:15px;}
				
				.radio-block i:hover {
					color:#<?php echo $style_values['form_radio_hover_color']; ?>;
				}
				
				.checkbox-block i:hover {
					color:#<?php echo $style_values['form_checkbox_hover_color']; ?>;
				}
				
				.radio-block i.active, .checkbox-block i.active {display:none;}
				.radio-block input:checked + i.active + i.passive, .checkbox-block  input:checked + i.active + i.passive {display:none;}
				
				.radio-block input:checked + i.active, .radio-block input:checked + i.active:hover {
					display:inline-block;
					color:#<?php echo $style_values['form_radio_active_color']; ?>;
				}
				
				.checkbox-block	input:checked + i.active, .checkbox-block input:checked + i.active:hover {
					display:inline-block;
					color:#<?php echo $style_values['form_checkbox_active_color']; ?>;
				}
				
				
				
				/*############SELECTBOX#############*/
				
				.selectbox-block {
					position:relative;
					height:<?php echo $style_values['form_selectbox_font_size']*2+$style_values['form_selectbox_border_size']; ?>px;
				}
				
				.selectbox-block select {
					position:relative;
					height:<?php echo $style_values['form_selectbox_font_size']*2-$style_values['form_selectbox_border_size']*2; ?>px;
					margin:<?php echo $style_values['form_selectbox_border_size']; ?>px 0px 0px 1px !important;
					opacity:0;
					z-index:2;
				}
				
				.selectbox-block .textholder {
					position:absolute;
					height:<?php echo $style_values['form_selectbox_font_size']*2; ?>px;
					width:90%;
					padding-right:10%;
					margin:0 !important;
					top;0;
					left:0;
					border:0;
					color:#<?php echo $style_values['form_selectbox_font_color']; ?>; 
					background:none;
					border:<?php echo $style_values['form_selectbox_border_size']; ?>px solid #<?php echo $style_values['form_selectbox_border_color']; ?>;
					border-radius:<?php echo $style_values['form_selectbox_border_radius']; ?>px;
					color:#<?php echo $style_values['form_selectbox_font_color']; ?>;
					font-size:<?php echo $style_values['form_selectbox_font_size']; ?>px;
					<?php if($style_values['form_selectbox_has_background']=="on"){?>
					background:#<?php echo $style_values['form_selectbox_background_color']; ?>;
					<?php  }else { ?>
					background:none;
					<?php } ?>
				}
				
				.selectbox-block i {
					position:absolute;
					top:<?php echo $style_values['form_selectbox_font_size']/2+$style_values['form_selectbox_border_size']/4; ?>px;
					right:10px;
					z-index:0;
					color:#<?php echo $style_values['form_selectbox_arrow_color']; ?>;
					font-size:<?php echo $style_values['form_selectbox_font_size']; ?>px;
				}
				
				/*############FILE#############*/
				
				
				.file-block {
					position:relative;
					cursor:pointer;
				}
								
				.file-block .textholder {
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
				
				.file-block .uploadbutton {	
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
				
				.file-block:hover .uploadbutton {	
					color:#<?php echo $style_values['form_file_button_text_color']; ?>;
					background:#<?php echo $style_values['form_file_button_background_color']; ?>;
					vertical-align: baseline;
				}
				
				.file-block .uploadbutton i {
					color:#<?php echo $style_values['form_file_icon_color']; ?>;
					font-size:<?php echo $style_values['form_file_font_size']; ?>px;
					vertical-align: baseline;
					-webkit-transition: all 0.5s ease;
					transition: all 0.5s ease;
				}
				
				.file-block:hover .uploadbutton {
					color:#<?php echo $style_values['form_file_button_text_hover_color']; ?>;
					background:#<?php echo $style_values['form_file_button_background_hover_color']; ?>;
				}
				
				.file-block:hover .uploadbutton i {
					color:#<?php echo $style_values['form_file_icon_hover_color']; ?>;
				}
							
				.file-block input[type='file'] {
					height:30px;
					width:100%;
					position:absolute;
					top:0;
					left:0;
					opacity:0;
					cursor:pointer;
				}
				
				
				/*###########CAPTCHA#############*/
				.captcha-block div {
					margin-right:-1px;
				}
				
				/*############BUTTONS#############*/
				
				
				.buttons-block  {
					<?php
						if($style_values['form_button_position']=="left"){echo "text-align:left;";}
						else if ($style_values['form_button_position']=="right"){echo "text-align:right;";}
						else {echo "text-align:center;";}
					?>
					
				}

				.buttons-block button {
					height:auto;
					padding:<?php echo $style_values['form_button_padding']; ?>px <?php echo $style_values['form_button_padding']*2; ?>px <?php echo $style_values['form_button_padding']; ?>px <?php echo $style_values['form_button_padding']*2; ?>px;
					cursor:pointer;
					text-transform: none;
					<?php
						if($style_values['form_button_fullwidth']=="on"){
					?>
						clear:both;
						width:100%;
						margin:0 0 0 0 !important;
						padding-left:0;
						padding-right:0;
					<?php } ?>
					font-size:<?php echo $style_values['form_button_font_size']; ?>px;
				}
				
				.buttons-block button.submit {
					color:#<?php echo $style_values['form_button_submit_font_color']; ?> !important;
					background-color:#<?php echo $style_values['form_button_submit_background']; ?> !important;
					border:<?php echo $style_values['form_button_submit_border_size']; ?>px solid #<?php echo $style_values['form_button_submit_border_color']; ?> !important;
					border-radius:<?php echo $style_values['form_button_submit_border_radius']; ?>px !important;
					-webkit-transition: all 0.5s ease !important;
					transition: all 0.5s ease !important;
					margin:0 0 5px 0 !important;
				}
				
				.buttons-block button.submit:hover {
					color:#<?php echo $style_values['form_button_submit_font_hover_color']; ?> !important;
					background:#<?php echo $style_values['form_button_submit_hover_background']; ?> !important;
				}
				
				.buttons-block button.submit i {
					color:#<?php echo $style_values['form_button_submit_icon_color']; ?> !important;
					vertical-align: baseline !important;
					font-size:<?php echo $style_values['form_button_font_size']; ?>px !important;
					-webkit-transition: all 0.5s ease !important;
					transition: all 0.5s ease !important;
				}
				
				.buttons-block button.submit:hover i {
					color:#<?php echo $style_values['form_button_submit_icon_hover_color']; ?> !important;
				}
	
				.buttons-block button.reset {
					color:#<?php echo $style_values['form_button_reset_font_color']; ?> !important;
					background-color:#<?php echo $style_values['form_button_reset_background']; ?> !important;
					border:<?php echo $style_values['form_button_reset_border_size']; ?>px solid #<?php echo $style_values['form_button_reset_border_color']; ?> !important;
					border-radius:<?php echo $style_values['form_button_reset_border_radius']; ?>px !important;
					-webkit-transition: all 0.5s ease !important;
					transition: all 0.5s ease !important;
				}
				
				.buttons-block button.reset:hover {
					color:#<?php echo $style_values['form_button_reset_font_hover_color']; ?> !important;
					background:#<?php echo $style_values['form_button_reset_hover_background']; ?> !important;
				}
				
				.buttons-block button.reset i {
				
					color:#<?php echo $style_values['form_button_reset_icon_color']; ?> !important;
					vertical-align: baseline !important;
					font-size:<?php echo $style_values['form_button_font_size']; ?>px !important;
					-webkit-transition: all 0.5s ease !important;
					transition: all 0.5s ease !important;
				}
				
				.buttons-block button.reset:hover i {
					color:#<?php echo $style_values['form_button_reset_icon_hover_color']; ?> !important;
				}

				/*############ Name Field############*/
				.input-name-block{
					font-size: 0 !important;
				}
				.input-name-block input,.input-name-block input:focus {
					width: 49% !important;
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
				}
				.input-name-block input:first-child,.input-name-block input:first-child:focus{
					margin-right: 2% !important;
				}
				/*############ Phone Field############*/
				.ready-phone-block input.readyPhone,.ready-phone-block input.readyPhone:focus {
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
				}
				#hugeit-contact-wrapper .hugeit-contact-column-block > div ul.hide{
					display: none !important;
				}
				#hugeit-contact-wrapper .hugeit-contact-column-block > div ul.country-list{
					display: block ;
				    z-index: 10;
				}
				#hugeit-contact-wrapper .hugeit-contact-column-block > div .field-block ul.country-list li{
					float: none !important;
					margin: 0 !important;
				}
				/*############ License Field ############*/
				.hugeit-check-field >.license-block{
					width: 100% !important;
				}
				.hugeit-check-field > .license-block >.secondary-label{
					vertical-align: super !important;
				}
				.hugeit-check-field > .license-block >.secondary-label > .checkbox-block{
					margin: 0 5px 0 0 !important;
					float: none !important;
					display: inline-block;
					vertical-align: middle !important;
				}
				/*additional*/
				#hugeit-contact-wrapper .hugeit-contact-column-block > div > label.formsLabelHide{
					display: none !important;
				}
				#hugeit-contact-wrapper .hugeit-contact-column-block > div .formsLabelHide {
					width:100% !important;				
				}
			
			
			</style>
			<script>
				jQuery(document).ready(function () {					
						
					/*FRONT END PREVIEW FROM ADMIN JS*/
					
					jQuery(".hugeit-contact-column-block input[type='file']").on('change',function(){
						var value=jQuery(this).val().substr(jQuery(this).val().indexOf('fakepath')+9);
						jQuery(this).parent().find('input[type="text"]').val(value);
					});
					
					jQuery(".hugeit-contact-column-block select").on('change',function(){
						jQuery(this).prev('.textholder').val(jQuery(this).val());
					});
					jQuery(".submit").on('click',function(e){
						e.preventDefault();
    					//return false;

					});
				});
			</script>
			<!--LIVE PREVIEW-->
			<div id="hugeit-contact-preview-container">
				<form onkeypress="doNothing()" id="hugeit-contact-preview-form">
					<div id="hugeit-contact-wrapper" class="<?php echo $style_values['form_radio_size']; ?>-radio <?php echo $style_values['form_checkbox_size']; ?>-checkbox">
					<div <?php foreach ($rowim as $key=>$rowimages){if($rowimages->hc_left_right == 'right'){echo 'class="multicolumn"';}} ?>>
						<?php foreach($rowsld as $key=>$rowsldires) {if($id==$rowsldires->id) {echo "<h3><input class='text_area_title' type='text' maxlength='250' value='".$rowsldires->name."' /><span class='hugeItTitleOverlay'></span></h3>";}} ?>
						<div class="hugeit-contact-column-block hugeit-contact-block-left" id="hugeit-contact-block-left">
							<?php
								$i=2;
								foreach ($rowim as $key=>$rowimages){
									if($rowimages->hc_left_right == 'left'){
										$inputtype = $rowimages->conttype;
										switch ($inputtype) {
											case 'text'://1

											echo hugeit_contact_textBoxHtml($rowimages);
											break;

											case 'textarea'://2

											echo hugeit_contact_textareaHtml($rowimages);
											break;

											case 'selectbox'://3
											
											echo hugeit_contact_selectboxHtml($rowimages);
											break;

											case 'checkbox':  //4

											echo hugeit_contact_checkboxHtml($rowimages,$themeId);
											break;

											case 'radio_box':  //5
											
											echo hugeit_contact_radioboxHtml($rowimages,$themeId);
											break;
											case 'file_box':  //6
											
											echo hugeit_contact_fileboxHtml($rowimages,$themeId);
											break;

											case 'custom_text':  //7

											echo hugeit_contact_cutomtextHtml($rowimages);
											break;

											case 'captcha': //8
											?>
												<div class="hugeit-field-block captcha-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<script type="text/javascript">
													  var verifyCallback = function(response) {
													  };
													  var onloadCallback = function() {
														grecaptcha.render('democaptchalight', {
														  'sitekey' : '<?php echo $paramssld['form_captcha_public_key']; ?>',
														  'callback' : verifyCallback,
														  'theme' : 'light',
														  'type' : '<?php echo $rowimages->name; ?>'
														});
														
														grecaptcha.render('democaptchadark', {
														  'sitekey' : '<?php echo $paramssld['form_captcha_public_key']; ?>',
														  'callback' : verifyCallback,
														  'theme' : 'dark',
														  'type' : '<?php echo $rowimages->name; ?>'
														});
													  };
													 
													</script>
													<?php $capPos='right';if($rowimages->hc_input_show_default=='2')$capPos="left";?>
													<div <?php echo $rowimages->hc_required=='dark' ? 'style="display:none"' : 'style="float:'.$capPos.'"';?> id="democaptchalight"></div>
													<div <?php echo $rowimages->hc_required=='light' ? 'style="display:none"' : 'style="float:'.$capPos.'"';?> id="democaptchadark"></div>
													<span class="hugeOverlay"></span>
													<input type="hidden" class="ordering" name="hc_ordering<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->ordering; ?>">
													<input type="hidden" class="left-right-position" name="hc_left_right<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->hc_left_right; ?>" />
												</div>
											<?php
											break;
											case 'buttons': //9									
											
											echo hugeit_contact_buttonsHtml($rowimages,$themeId);
											break;

											case 'e_mail':  //10

											echo hugeit_contact_emailHtml($rowimages);
											break;
										}
									}
								}
							?>
						</div>
					
						<div class="hugeit-contact-column-block hugeit-contact-block-right" id="hugeit-contact-block-right">
						
						<?php	
								$i=2;
								foreach ($rowim as $key=>$rowimages){
									if($rowimages->hc_left_right == 'right'){
										$inputtype = $rowimages->conttype;
										switch ($inputtype) {
											case 'text'://1

											echo hugeit_contact_textBoxHtml($rowimages);
											break;

											case 'textarea'://2

											echo hugeit_contact_textareaHtml($rowimages);
											break;

											case 'selectbox'://3
											
											echo hugeit_contact_selectboxHtml($rowimages);
											break;

											case 'checkbox':  //4

											echo hugeit_contact_checkboxHtml($rowimages,$themeId);
											break;

											case 'radio_box':  //5
											
											echo hugeit_contact_radioboxHtml($rowimages,$themeId);
											break;
											case 'file_box':  //6
											
											echo hugeit_contact_fileboxHtml($rowimages,$themeId);
											break;

											case 'custom_text':  //7

											echo hugeit_contact_cutomtextHtml($rowimages);
											break;

											case 'captcha': //8
											?>
												<div class="hugeit-field-block captcha-block" rel="huge-contact-field-<?php echo $rowimages->id; ?>">
													<script type="text/javascript">
													  var verifyCallback = function(response) {
													  };
													  var onloadCallback = function() {
														grecaptcha.render('democaptchalight', {
														  'sitekey' : '<?php echo $paramssld['form_captcha_public_key']; ?>',
														  'callback' : verifyCallback,
														  'theme' : 'light',
														  'type' : '<?php echo $rowimages->name; ?>'
														});
														
														grecaptcha.render('democaptchadark', {
														  'sitekey' : '<?php echo $paramssld['form_captcha_public_key']; ?>',
														  'callback' : verifyCallback,
														  'theme' : 'dark',
														  'type' : '<?php echo $rowimages->name; ?>'
														});
													  };

													</script>
													<?php $capPos='right';if($rowimages->hc_input_show_default=='2')$capPos="left";?>
													<div <?php if($rowimages->hc_required=='dark'){echo 'style="display:none"';}else{echo 'style="float:'.$capPos.'"';}?> id="democaptchalight"></div>
													<div <?php if($rowimages->hc_required=='light'){echo 'style="display:none"';}else{echo 'style="float:'.$capPos.'"';}?> id="democaptchadark"></div>
													<span class="hugeOverlay"></span>
													<input type="hidden" class="ordering" name="hc_ordering<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->ordering; ?>">
													<input type="hidden" class="left-right-position" name="hc_left_right<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->hc_left_right; ?>" />
												</div>
											<?php
											break;
											case 'buttons': //9									
											
											echo hugeit_contact_buttonsHtml($rowimages,$themeId);
											break;

											case 'e_mail':  //10

											echo hugeit_contact_emailHtml($rowimages);
											break;
										}
									}
								}
								$hugeit_contact_form_admin_subject = get_option('hugeit_contact_form_admin_subject_' . $id);
								$hugeit_contact_form_admin_subject = $hugeit_contact_form_admin_subject ? $hugeit_contact_form_admin_subject : '';

								$hugeit_contact_form_user_subject = get_option('hugeit_contact_form_user_subject_' . $id);
								$hugeit_contact_form_user_subject = $hugeit_contact_form_user_subject ? $hugeit_contact_form_user_subject : '';
							?>
						</div>
					<div class="clear"></div>
					</div>
				</div>
				</form>
			</div>
			<div class="hugeit_contact_custom_settings_main">
				<div class="hugeit_contact_custom_settings_dropdown_heading_wrapper">
					<div class="hugeit_contact_custom_settings_dropdown_heading"><h4>Advanced email options</h4><i class="hugeicons-chevron-down"></i></div>
					<div class="hugeit_contact_custom_settings_dropdown_description">In your LITE version of the plugin you can send ONE custom email message and set the same admin recipients for ALL forms, whereas Advanced email options in PRO version allow you to customize your email messages and admin recipients for EACH form.</div>
				</div>
				<div class="hugeit_contact_custom_settings_dropdown_content -hidden">
					<div class="hugeit_contact_custom_settings_outer_wrapper">
						<div style="width:48%">
							<p>
								<label for="hugeit_contact_receivers_group">Send Email To:</label>
								<select disabled="disabled" id="hugeit_contact_receivers_group" name="hugeit_contact_receivers_group">
									<option value="default" <?php if ( get_option( 'hugeit_contact_receivers_group_' . $id ) === 'default' ) echo ' selected'; ?>>Default Receivers</option>
									<option value="both" <?php if ( get_option( 'hugeit_contact_receivers_group_' . $id ) === 'both' ) echo ' selected'; ?>>Default &amp; Custom Receivers</option>
									<option value="custom" <?php if ( get_option( 'hugeit_contact_receivers_group_' . $id ) === 'custom' ) echo ' selected'; ?>>Custom Recievers</option>
								</select>
							</p>
							<p>
								<label for="hugeit_contact_form_custom_admin_receivers">Admin Custom Receivers:</label>
								<input
									disabled="disabled"
									type="text"
									id="hugeit_contact_form_custom_admin_receivers"
									name="hugeit_contact_form_custom_admin_receivers"
									placeholder="Use comma-separated email addresses"
									value="<?php $custom_receivers = get_option( 'hugeit_contact_form_custom_admin_receivers_' . $id ); if ( $custom_receivers ) echo $custom_receivers; ?>"/>
								<dfn class="huge_it_forms_mess_subject_help_box" data-info="Add multiple emails separating them with commas.">?</dfn>
							</p>
						</div>
						<div class="hugeit_contact_custom_settings_inner_wrapper leftblock">
							<div>
								<p>
									<input disabled="disabled" class="primary-check" type="checkbox" id="enable_custom_text_for_admin_email"
										   name="enable_custom_text_for_admin_email"
										   value="1" <?php if ( get_option( 'hugeit_contact_form_custom_text_for_admin_enabled_' . $id ) ) echo ' checked' ?> />
									<label class="primary-label" for="enable_custom_text_for_admin_email">Custom settings for admin</label>
								</p>
							</div>
							<h3>Email To Admin</h3>
							<div>
								<p>
									<label class="small-label" for="hugeit_contact_form_admin_subject">Admin Subject:</label>
									<input disabled="disabled" type="text" id="hugeit_contact_form_admin_subject"
										   name="hugeit_contact_form_admin_subject"
										   value="<?php echo $hugeit_contact_form_admin_subject; ?>"/>
								</p>
							</div>
							<div class="autoheight">
								<?php
								wp_editor( get_option( 'hugeit_contact_form_admin_message_' . $id ), "hugeit_contact_admin_message", array( 'media_buttons' => false ) );
								?>
							</div>
						</div>
						<div class="hugeit_contact_custom_settings_inner_wrapper">
							<p>
								<input disabled="disabled" class="primary-check" type="checkbox" id="enable_custom_text_for_user_email"
									   name="enable_custom_text_for_user_email"
									   value="1" <?php if ( get_option( 'hugeit_contact_form_custom_text_for_user_enabled_' . $id ) ) echo ' checked' ?> />
								<label class="primary-label" for="enable_custom_text_for_user_email">Custom settings for user</label>
							</p>
							<h3>Email To User</h3>
							<p>
								<label class="small-label" for="hugeit_contact_form_user_subject">User Subject:</label>
								<input disabled="disabled" type="text" id="hugeit_contact_form_user_subject" name="hugeit_contact_form_user_subject"
									   value="<?php echo $hugeit_contact_form_user_subject; ?>"/>
							</p>
							<div class="autoheight">
								<?php
								wp_editor( get_option( 'hugeit_contact_form_user_message_' . $id ), "hugeit_contact_user_message", array( 'media_buttons' => false ) );
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ################################################ LIVE PREVIEW GOESE TO FRONT END #################################################### -->
		</div>
	</div>
	<input type="hidden" name="task" value="" />
</form>
</div>

<?php

}

function html_captcha_keys($param_values){
	global $wpdb;

?>
	<style>
		html.wp-toolbar {
			padding:0 !important;
		}
		#wpadminbar,#adminmenuback,#screen-meta, .update-nag,#dolly {
			display:none;
		}
		#wpbody-content {
			padding-bottom:30px;
		}
		#adminmenuwrap {display:none !important;}
		.auto-fold #wpcontent, .auto-fold #wpfooter {
			margin-left: 0;
		}
		#wpfooter {display:none;}
		iframe {height:250px !important;}
		#TB_window {height:250px !important;}
		#adminFormPopup label{
			width: 20% !important;
    		display: inline-block !important;
		}
		#adminFormPopup div>input{
			width: 360px;
		}
		#adminFormPopup button{
			margin-top: 20px;
		}
	</style>
	<script type="text/javascript">
		jQuery(document).ready(function() {			

			jQuery('.huge-it-insert-post-button').on('click', function() {
				var ID1 = jQuery('#huge_it_add_video_input').val();
				if(ID1==""){alert("Please copy and past url form Youtobe or Vimeo to insert into slider.");return false;}
				
				window.parent.uploadID.val(ID1);
				
				tb_remove();
				jQuery("#save-buttom").click();
			});
								
			jQuery('.updated').css({"display":"none"});
			<?php	if(isset($_GET["closepop"])&&$_GET["closepop"] == 1){ ?>
				jQuery("#closepopup").click();
				self.parent.location.reload();
			<?php } ?>
			

			

		});		
	</script>
	<a id="closepopup"  onclick=" parent.eval('tb_remove()')" style="display:none;" > [X] </a>

	<div id="huge_it_contacts_captcha_keys">
		<div id="huge_it_contacts_captcha_keys_wrap">
			<h2>Captcha Keys</h2>
			<div class="control-panel">
				<p>Please register your blog through the <a href="https://www.google.com/recaptcha/admin" target="_blank">Google reCAPTCHA admin page</a> and enter the public and private key in the fields below.</p>			
				<form method="post" action="admin.php?page=hugeit_forms_main_page" id="adminFormPopup" name="admin_form">
					<div>
						<label for="form_captcha_public_key">Captcha Public Key</label>
						<input type="text" id="form_captcha_public_key" name="params[form_captcha_public_key]" value="<?php echo $param_values['form_captcha_public_key']; ?>" />
					</div>
					<div>
						<label for="form_captcha_private_key">Captcha Private Key</label>
						<input type="text" id="form_captcha_private_key" name="params[form_captcha_private_key]" value="<?php echo $param_values['form_captcha_private_key']; ?>" />
					</div>
					<button onclick="submitbutton(<?php echo esc_html($_GET['id']); ?>)" class='button-primary'>Save</button>
				</form>
				<p><a href="https://developers.google.com/recaptcha/intro">What is this all about?</a></p>
				<p>Please be known you may always change it from <a target="blank" href="admin.php?page=hugeit_forms_general_options&closepop=1">General Options</a></p>
			</div>
		</div>	
	</div>
	<script>
		function submitbutton(pressbutton){
			window.onbeforeunload = null;
			document.getElementById("adminFormPopup").action=document.getElementById("adminFormPopup").action+"&task=captcha_keys&id="+pressbutton+"&closepop=1";
			document.getElementById("adminFormPopup").submit();
		}
	</script>
<?php

}
