<?php
 /* 
    Plugin Name: Send email notification to author when post is published
    Plugin URI:http://www.i13websolution.com/wordpress-publish-post-email-notification-pro-plugin.html
    Description: Send email notification to author when post is published
    Author:I Thirteen Web Solution
    Version:1.0
    Author URI:http://www.i13websolution.com/wordpress-publish-post-email-notification-pro-plugin.html
*/  

  add_action('admin_menu', 'load_submenu');
  //add_action( 'admin_init', 'publish_post_notification_plugin_admin_init' );
  add_action( 'transition_post_status', 'send_email_notification', 10, 3 );
  function load_submenu(){
  
        $hook_suffix_email_notify=add_submenu_page( 'options-general.php', 'Publish post notification options', 'Publish post email template', 'manage_options', 'manage_publish_post_notification_options', 'manage_publish_post_notification_options_func' );
        add_action( 'load-' . $hook_suffix_email_notify , 'publish_post_notification_plugin_admin_init' );
  }
  
  
  function publish_post_notification_plugin_admin_init(){
    
        $url = plugin_dir_url(__FILE__);  
        wp_enqueue_script('jquery'); 
        wp_enqueue_script( 'jqueryValidate', $url.'js/jqueryValidate.js' );  
  
  }
  
  function send_email_notification( $new_status, $old_status, $post ){
      
      $post_ID=$post->ID;
      
      $postType=get_post_type($post_ID);
      
      if($postType=="post" ){  
          
            if ( 'publish' !== $new_status )
              return;

           if('publish' != $old_status){


             $meta_values = get_post_meta($post_ID, 'is_notified', true);

             if($meta_values!='yes'){
       
                $pub_post = get_post($post_ID);
                $author_id=$pub_post->post_author;
                $post_title=$pub_post->post_title;
                $postperma=get_permalink( $post_ID );
                $user_info = get_userdata($author_id);

                $usernameauth=$user_info->user_login;
                $user_nicename=$user_info->user_nicename;
                $user_email=$user_info->user_email;
                $first_name=$user_info->user_firstname;
                $last_name=$user_info->user_lastname;

                $blog_title = get_bloginfo('name');
                $siteurl=get_bloginfo('wpurl');  
                $siteurlhtml="<a href='$siteurl' target='_blank' >$siteurl</a>";



                $publish_post_notification_settings=get_option('publish_post_notification_settings');  

                $subject=$publish_post_notification_settings['subject'];
                $from_name=$publish_post_notification_settings['from_name'];
                $from_email=$publish_post_notification_settings['from_email'];
                $emailBody=$publish_post_notification_settings['emailBody'];
                $emailBody=stripslashes($emailBody);
                $emailBody=str_replace('[username]',$usernameauth,$emailBody); 
                $emailBody=str_replace('[user_login]',$usernameauth,$emailBody); 
                $emailBody=str_replace('[user_nicename]',$user_nicename,$emailBody); 
                $emailBody=str_replace('[user_email]',$user_email,$emailBody); 
                $emailBody=str_replace('[first_name]',$first_name,$emailBody); 
                $emailBody=str_replace('[last_name]',$last_name,$emailBody); 

                $emailBody=str_replace('[published_post_link_plain]',$postperma,$emailBody); 

                $postlinkhtml="<a href='$postperma' target='_blank'>$postperma</a>";

                $emailBody=str_replace('[published_post_link_html]',$postlinkhtml,$emailBody); 

                $emailBody=str_replace('[published_post_title]',$post_title,$emailBody); 
                $emailBody=str_replace('[site_name]',$blog_title,$emailBody); 
                $emailBody=str_replace('[site_url]',$siteurl,$emailBody); 
                $emailBody=str_replace('[site_url_html]',$siteurlhtml,$emailBody); 

                $emailBody=stripslashes(htmlspecialchars_decode($emailBody));
                $mailheaders='';
                $mailheaders .= "Content-Type: text/html; charset=\"UTF-8\"\n";
                $mailheaders .= "From: $from_name <$from_email>" . "\r\n";
                $message='<html><head></head><body>'.$emailBody.'</body></html>';
                $Rreturns=wp_mail($user_email, $subject, $message, $mailheaders);

                if($Rreturns){
                  add_post_meta($post_ID, 'is_notified', 'yes');
                } 
            }
            
         } 
      }   
  }

  function manage_publish_post_notification_options_func(){
  
  if(isset($_POST['savesettings'])){
  
        $subject=$_POST['email_subject'];
        $from_name=$_POST['email_From_name'];
        $from_email=$_POST['email_From'];
         $emailBody=$_POST['txtArea'];
        if(function_exists('get_magic_quotes_gpc')){
            if(get_magic_quotes_gpc()){
              $emailBody=addslashes($emailBody);  
            }
        }
        
        $emailBody=htmlentities($emailBody);
        

        $publish_post_notification_settings=array('subject'=>$subject,'from_name'=>$from_name,'from_email'=>$from_email,'emailBody'=>$emailBody);
        update_option('publish_post_notification_settings',$publish_post_notification_settings); 
        $publish_post_notification_settings=get_option('publish_post_notification_settings');
  
  ?>
  
  <div id='succMsg'>Settings updated successfully</div>
 <?php 
  }
 else{
 
     $publish_post_notification_settings=get_option('publish_post_notification_settings');
     
     
     
 } 
?>  
<table><tr><td><a href="https://twitter.com/FreeAdsPost" class="twitter-follow-button" data-show-count="false" data-size="large" data-show-screen-name="false">Follow @FreeAdsPost</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></td>
<td>
<a target="_blank" title="Donate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&amp;business=nvgandhi123@gmail.com&amp;item_name=Publish Post Email Notification&amp;item_number=publish post notification support&amp;no_shipping=0&amp;no_note=1&amp;tax=0&amp;currency_code=USD&amp;lc=US&amp;bn=PP%2dDonationsBF&amp;charset=UTF%2d8">
<img id="help us for free plugin" height="30" width="90" src="<?php echo plugins_url( 'images/paypaldonate.jpg', __FILE__ );?>" border="0" alt="help us for free plugin" title="help us for free plugin">
</a>
</td>
</tr>
</table>
<span><h3 style="color: blue;"><a target="_blank" href="http://www.i13websolution.com/wordpress-pro-plugins/wordpress-publish-post-email-notification-pro-plugin.html">Update to Publish Post Email Notification Pro</a></h3></span>
<br/>
<h3>Post notification email template settings</h3>  
   <?php  $url = plugin_dir_url(__FILE__);
      
       $urlCss=$url."styles.css";
 ?>
 <link rel='stylesheet' href='<?php echo $urlCss; ?>' type='text/css' media='all' />
 <div style="width: 100%;">  
     <div style="float:left;" >
      
        <form name="publishpostfrm" id='publishpostfrm' method="post" action=""> 
        <table class="form-table" style="" >
        <tbody>
          <tr valign="top" id="subject">
             <th scope="row" style="width:30%;text-align: right;">Subject *</th>
             <td>    
                <input type="text" id="email_subject" name="email_subject" value="<?php echo stripslashes($publish_post_notification_settings['subject']);?>"  class="valid" size="70">
                <div style="clear: both;"></div><div></div>
              </td>
           </tr>
           <tr valign="top" id="subject">
             <th scope="row" style="width:30%;text-align: right">Email From Name*</th>
             <td>    
                <input type="text" id="email_From_name" name="email_From_name"  value="<?php echo stripslashes($publish_post_notification_settings['from_name']);?>" class="valid" size="70">
                 <br/>(ex. admin)  
                <div style="clear: both;"></div><div></div>
               
              </td>
           </tr>
           <tr valign="top" id="subject">
             <th scope="row" style="width:30%;text-align: right">Email From *</th>
             <td>    
                <input type="text" id="email_From" name="email_From" value="<?php echo stripslashes($publish_post_notification_settings['from_email']);?>"  class="valid" size="70">
                <br/>(ex. admin@yoursite.com) 
                <div style="clear: both;"></div><div></div>
          
              </td>
           </tr>
          
           <tr valign="top" id="subject">
             <th scope="row" style="width:30%;text-align: right">Email Body *</th>
              <?php
                   
                    $emailBody=stripslashes($publish_post_notification_settings['emailBody']);  
                    $emailBody=html_entity_decode($emailBody);
               ?>

             <td>    
               <div class="wrap">
                <textarea id="txtArea"  cols="100" rows="8" name="txtArea" class="ckeditor"><?php echo $emailBody;?></textarea>
                 <div style="clear: both;"></div><div></div> 
                </div>
                <span>you can use [username] , [user_login] , [user_nicename] , [user_email] , [first_name] , [last_name] ,[published_post_link_html] , [published_post_link_plain] ,
                    [published_post_title] , [site_name] , [site_url],[site_url_html] place holder into email body</span>   
              </td>
           </tr>
           
              <tr valign="top" id="subject">
             <th scope="row" style="width:30%"></th>
             <td> 
                <?php wp_nonce_field('action_settings_nonce','add_edit_nonce'); ?>
               <input type='submit'  value='Save Settings' name='savesettings' class='button-primary' id='savesettings' >  
              </td>
           </tr> 
           <tr valign="top" id="subject">
             <th scope="row" style="width:30%"></th>
             <td> 
                 <div id="postbox-container-1" class="postbox-container"> 
            
            <div class="postbox"> 
              <h3 class="hndle"><span></span>Access All Themes One price</h3> 
              <div class="inside">
                   <center><a href="http://www.elegantthemes.com/affiliates/idevaffiliate.php?id=11715_0_1_10" target="_blank">
                           <img border="0" src="<?php echo plugins_url( 'images/300x250.gif', __FILE__ );?>" width="250" height="250">
                       </a>
                   </center>

                  <div style="margin:10px 5px">
          
                  </div>
          </div></div>

            <div class="postbox"> 
                <h3 class="hndle"><span></span>Recommended WordPress Hostings</h3> 
                <div class="inside">
                    <center><a href="https://mythemeshop.com/?ref=nik_gandhi007" target="_blank">
                            <img src="<?php echo plugins_url( 'images/300x250.png', __FILE__ );?>" width="250" height="250" border="0">
                        </a></center>
                    <div style="margin:10px 5px">
                    </div>
                </div></div>


        </div> 

           
              </td>
           </tr>
           
        </table>
        </form>
     </div>
        
 </div>   

    <script type="text/javascript">


     jQuery(document).ready(function() {

     

       jQuery("#publishpostfrm").validate({
                        errorClass: "error_admin_massemail",
                        rules: {
                                     email_subject: { 
                                            required: true
                                      },
                                      email_From_name: { 
                                            required: true
                                      },  
                                      email_From: { 
                                            required: true ,email:true
                                      }, 
                                     txtArea:{
                                        required: true
                                     }  
                                
                           }, 
          
                                errorPlacement: function(error, element) {
                                error.appendTo( element.next().next());
                          }
                          
                     });
                          

      });
     
     </script> 


<?php  
  }

?>