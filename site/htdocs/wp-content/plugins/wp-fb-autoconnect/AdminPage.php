<?php

/*
 * Tell WP about the Admin page
 */
add_action('admin_menu', 'jfb_add_admin_page', 99);
function jfb_add_admin_page()
{ 
    global $jfb_name;
    add_options_page("$jfb_name Options", 'WP-FB AutoConn' . (defined('JFB_PREMIUM')?"+":""), 'administrator', "wp-fb-autoconnect", 'jfb_admin_page');
}


/**
  * Link to Settings on Plugins page 
  */
add_filter('plugin_action_links', 'jfb_add_plugin_links', 10, 2);
function jfb_add_plugin_links($links, $file)
{
    if( dirname(plugin_basename( __FILE__ )) == dirname($file) )
        $links[] = '<a href="options-general.php?page=' . "wp-fb-autoconnect" .'">' . __('Settings','wp-fb-autoconnect') . '</a>';
    return $links;
}

/**
 * Styles
 */
add_action('admin_head', 'jfb_admin_styles');
function jfb_admin_styles()
{
    echo '<style type="text/css">'.
            '.jfb-admin_warning     {background-color: #FFEBE8; border:1px solid #C00; padding:0 .6em; margin:10px 0 15px; -khtml-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;}'.
            '.jfb-admin_wrapper     {clear:both; background-color:#FFFEEB; border:1px solid #CCC; padding:0 8px; }'.
    	    '.jfb-admin_wrapper dfn {border-bottom:1px dotted #0000FF; cursor:help; font-style:italic; font-size:80%;}'.
    		'.jfb-admin_tabs        {width:100%; clear:both; float:left; margin:0 0 -0.1em 0; padding:0;}'.
            '.jfb-admin_tabs li     {list-style:none; float:left; margin:0; padding:0.2em 0.5em 0.2em 0.5em; }'.
            '.jfb-admin_tab_selected{background-color:#FFFEEB; border-left:1px solid #CCC; border-right:1px solid #CCC; border-top:1px solid #CCC;}'.
            '.jfb-greybox           {width:600px; padding:5px; margin:2px 0; background-color:#EEEDDA; border:1px solid #CCC;}'.
         '</style>';
    //Simple 'lightbox' for showing pop-up 'more info' descriptions.  From http://stephenmcintyre.net/blog/simple-css-lightbox
    echo '<style type="text/css">'.
           '.wpfb-moreinfo-bg{display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:#000; -moz-opacity:0.5; opacity:.50; filter:alpha(opacity=50); }' .
           '.wpfb-moreinfo-box{display:none; position:fixed; top:100px; left:25%; width:50%; background-color:#fff; padding:5px; }'.
           '.wpfb-moreinfo-lnk{text-decoration:none;font-size:80%;border-bottom: 1px dotted #0000FF;color:inherit;cursor: help;font-style: italic;}'.
         '</style>';
}


/**
  * Admin warning notices (shown globally; warnings only shown on this page are below)
  */
add_action('admin_notices', 'jfb_admin_notices');
function jfb_admin_notices()
{
	global $jfb_homepage;
	//Version 2.1.0 moved to a new version of the Facebook API that required changes on both the free and premium plugins;
 	//warn Premium users who have upgraded their free plugin, but not their addon.
	if( defined('JFB_PREMIUM') && version_compare(JFB_PREMIUM_VER, 30) == -1 )
	{
	    ?><div class="error"><p>
	    	<strong><?php _e("Warning", 'wp-fb-autoconnect')?>:</strong> 
	    	<?php echo sprintf(__("This version of WP-FB-AutoConnect is only compatible with Premium addon version 30 or better (you're currently using version %s).  If you haven't done so already, please read the important information in FAQ46 of the plugin documentation:", 'wp-fb-autoconnect'), JFB_PREMIUM_VER) ?> <a target='store' href='<?php echo $jfb_homepage?>/#faq46'><b>here</b></a><br/><br/>
	    	<?php _e("If you'd like to revert to a previous version of the free plugin until you're ready to update the addon, previous versions can be downloaded from:", 'wp-fb-autoconnect') ?> <a target="prev" href='http://wordpress.org/extend/plugins/wp-fb-autoconnect/developers/'><b>here</b></a>
	      </p></div><?php
	}
	
	//Warn if the user's server doesn't have json_decode
	if (!function_exists('json_decode'))
	{
  	 	?><div class="error"><p><strong><?php _e("Warning", 'wp-fb-autoconnect')?>:</strong> <?php _e("WP-FB-AutoConnect requires the JSON PHP extension to work.  Please install / enable it before attempting to use this plugin.", 'wp-fb-autoconnect')?></p></div><?php
	}
    
    //Warn if w3 total cache is enabled
    global $opt_jfb_hidew3warning;
    if( isset($_REQUEST[$opt_jfb_hidew3warning]) ) update_option($opt_jfb_hidew3warning, 1);
    if (!get_option($opt_jfb_hidew3warning) && is_plugin_active("w3-total-cache/w3-total-cache.php"))
    {?>
        <div class="error">
            <p><strong><?php _e("Warning", 'wp-fb-autoconnect')?>:</strong> <?php _e("In some situations, W3-Total-Cache has been reported to cause problems with WP-FB-AutoConnect's Facebook logins.  If you're experiencing issues with WP-FB-AutoConnect (for instance, the Widget doesn't properly show the logged-in state immediately after a login), please try temporarily disabling W3-Total-Cache.  If that fixes it, you may re-enable W3-Total-Cache and try selectively enabling its various caching/CDN options until you find a combination that works for you.", 'wp-fb-autoconnect')?></p>
            <?php echo '<a href="?' . http_build_query(array_merge($_GET, array($opt_jfb_hidew3warning => "1"))) . '">'.__("Hide this message", 'wp-fb-autoconnect') . '</a>'; ?>
        </div>
    <?php
    }
    
    //Warn if it looks like we're on wpengine
    global $opt_jfb_hidewpenginewarning;
    if( isset($_REQUEST[$opt_jfb_hidewpenginewarning]) ) update_option($opt_jfb_hidewpenginewarning, 1);
    if (!get_option($opt_jfb_hidewpenginewarning) && defined('WPMU_PLUGIN_DIR') && file_exists(WPMU_PLUGIN_DIR . "/wpengine-common/plugin.php"))
    {?>
        <div class="error">
            <p><strong><?php _e("Warning", 'wp-fb-autoconnect')?>:</strong> <?php _e("It looks like your site is running on WPEngine.  Some users have reported that WPEngine's built-in caching causes problems with WP-FB-AutoConnect's Facebook logins.  If you're experiencing issues with WP-FB-AutoConnect (for instance, the Widget doesn't properly show the logged-in state immediately after a login), please contact WPEngine support and ask them to add a cache exclusion for the WP-FB-AutoConnect plugin folder (and for the Premium addon, if you're using it).", 'wp-fb-autoconnect')?></p>
            <?php echo '<a href="?' . http_build_query(array_merge($_GET, array($opt_jfb_hidewpenginewarning => "1"))) . '">'.__('Hide this message', 'wp-fb-autoconnect').'</a>'; ?>
        </div>
    <?php
    }
} 



/*
 * Output the Admin page
 */
function jfb_admin_page()
{
    global $jfb_name, $jfb_version, $opt_jfb_app_token, $jfb_apiver;
    global $opt_jfb_app_id, $opt_jfb_api_key, $opt_jfb_api_sec, $opt_jfb_email_to, $opt_jfb_email_logs, $opt_jfb_email_logs_missingpost, $opt_jfb_delay_redir, $jfb_homepage;
    global $opt_jfb_ask_perms, $opt_jfb_mod_done, $opt_jfb_ask_stream, $opt_jfb_stream_content;
    global $opt_jfb_bp_avatars, $opt_jfb_wp_avatars, $opt_jfb_valid, $opt_jfb_fulllogerr, $opt_jfb_disablenonce, $opt_jfb_show_credit;
    global $opt_jfb_username_style, $opt_jfb_hidesponsor, $opt_jfb_reportstats, $opt_jfb_hidew3warning, $opt_jfb_hidewpenginewarning;
    ?>
    <div class="wrap">
     <h2><?php echo $jfb_name; ?> Options</h2>
    <?php
    
    //Show applicable warnings (only on this panel's page; global warnings are above)
    if(version_compare('5', PHP_VERSION, ">"))
    {
        ?><div class="error"><p><?php _e("Sorry, but as of v1.3.0, WP-FB AutoConnect requires PHP5.", 'wp-fb-autoconnect')?></p></div><?php
        die();
    }
    if( function_exists('is_multisite') && is_multisite() && !jfb_premium() )
    {
        ?><div class="error"><p><strong><?php _e("Warning", 'wp-fb-autoconnect')?>:</strong> <?php _e("Wordpress MultiSite is only fully supported by the premium version of this plugin; please visit the documentation page for more details:", 'wp-fb-autoconnect')?> <a target='no_multisite' href='<?php echo $jfb_homepage?>#premium'><b>here</b></a></p></div><?php
    }
    if( file_exists(realpath(dirname(__FILE__))."/WP-FB-AutoConnect-Premium.php" ) )
    {
        ?><div class="error"><p><strong><?php _e("Notice", 'wp-fb-autoconnect')?>:</strong> 
        	<?php _e("You seem to've uploaded the premium addon to the wrong directory.", 'wp-fb-autoconnect')?><br/><br/>
        	<?php echo sprintf(__("The %s file needs to go in your plugins directory (%s), not the WP-FB-AutoConnect directory (%s). This is to prevent it from getting overwritten when you auto-update the core plugin.", 'wp-fb-autoconnect'), "'WP-FB-AutoConnect-Premium.php'", "i.e. wp-content/plugins/WP-FB-AutoConnect-Premium.php", "i.e. wp-content/plugins/wp-fb-autoconnect/WP-FB-AutoConnect-Premium.php")?>
          </p></div>
        <?php
    }
	
    //Rare warning: if they've updated their plugin to 4.2.0+ (when this notice was added), *and* they're using an older premium addon,
    //(from before the textdomain was changed) *and* their site is localized to one of the 2 languages to which the addon had been 
    //translated, warn them to update the addon.
    global $locale;
    if( defined('JFB_PREMIUM') && version_compare(JFB_PREMIUM_VER, 39) == -1 && isset($locale) && ($locale == 'es_ES' || $locale == 'sr_RS') )
    {
        ?><div class="error"><p>
            <strong><?php _e("Warning", 'wp-fb-autoconnect')?>:</strong> 
            Your site appears to be running in a foreign language, using an older version of the WP-FB-AutoConnect Premium addon.  While the addon's functionality will work just fine, it may not reflect your site's selected language.  This is due to a change since core plugin v4.2.0, to support localization on translate.wordpress.org.<br/><br/>If you'd like to see the translated version of the premium addon, please download the latest addon from justin-klein.com/store.  If you don't mind English, feel free to disregard this message. 
          </p></div><?php
    }
    
    do_action('wpfb_admin_messages');
    
    //Which tab to show by default
    $shownTab = get_option($opt_jfb_valid)?1:0;
      
	//When saving the Facebook options, make sure the key and secret are valid...
    if( isset($_POST['fb_opts_updated']) )
    {
        update_option( $opt_jfb_valid, 0 );
        $shownTab = 0;
		$response = jfb_api_get("https://graph.facebook.com/$jfb_apiver/oauth/access_token?client_id=" . $_POST[$opt_jfb_api_key] . "&client_secret=" . $_POST[$opt_jfb_api_sec] . "&grant_type=client_credentials");        
		if( isset($response['access_token']) )
		{
            //We got a valid app access token!  Note: this plugin doesn't actually use the app-token after this initial 
            //validation; I simply cache it so it can be accessible to users wishing to further interact with Facebook 
            //via hooks & filters. App tokens never expire unless the app secret is refreshed.
            $shownTab = 1;
            update_option( $opt_jfb_valid, 1 );
            update_option( $opt_jfb_app_token, $response['access_token'] );
			
			//Now I can use the app token to fetch the app's name.  This isn't really necessary - just a final double-confirmation,
			//and to show a 'nicer' message to the user when they save.
			$result = jfb_api_get("https://graph.facebook.com/$jfb_apiver/" . $_POST[$opt_jfb_api_key] . "?fields=id,name&access_token=" . get_option($opt_jfb_app_token));
			if(!$result || isset($result['error']))
			{
            	?><div class="error"><p><?php 
            		_e("Failed to confirm your app access token.", "wp-fb-autoconnect");
            		echo "<br/>Error Message: <i>" . (isset($result['error']) && isset($result['error']['message'])?$result['error']['message']:"Unknown") . "</i><br/>";
            		_e("Your plugin will probably function as normal, but if you encounter this message, please report it to the WP-FB-AutoConnect author.", "wp-fb-autoconnect")
            	?></p></div><?php
			}
        	else
			{
				?><div class="updated"><p><strong><?php _e("Successfully connected with:", 'wp-fb-autoconnect')?> <?php echo "'" . $result['name'] . "' (ID " . $result['id'] . ")";?></strong></p></div><?php
			}
		}
		else
		{
			$result = $response;
            ?><div class="error"><p><?php _e("Failed to validate your App ID and Secret.", "wp-fb-autoconnect")?><br/>
            Error Message: <i><?php echo (isset($result['error']['message'])?$result['error']['message']:"Unknown"); ?></i></p></div><?php
		}

        //We can save these either way, because if "valid" isn't set, a button won't be shown.
        update_option( $opt_jfb_app_id, ( isset($result['id']) ? $result['id'] : "") );
        update_option( $opt_jfb_api_key, esc_html($_POST[$opt_jfb_api_key]) );
        update_option( $opt_jfb_api_sec, esc_html($_POST[$opt_jfb_api_sec]) );
    }
    if( isset($_POST['main_opts_updated']) )
    {
        $shownTab = 1;
        update_option( $opt_jfb_ask_perms, esc_html( isset( $_POST[$opt_jfb_ask_perms] ) ? $_POST[$opt_jfb_ask_perms] : 0 ) );
        update_option( $opt_jfb_ask_stream, esc_html( isset( $_POST[$opt_jfb_ask_stream] ) ? $_POST[$opt_jfb_ask_stream] : 0 ) );
        update_option( $opt_jfb_wp_avatars, esc_html( isset( $_POST[$opt_jfb_wp_avatars] ) ? $_POST[$opt_jfb_wp_avatars] : 0 ) );
        update_option( $opt_jfb_stream_content, esc_html( isset( $_POST[$opt_jfb_stream_content] ) ? $_POST[$opt_jfb_stream_content] : '' ) );        
        update_option( $opt_jfb_show_credit, esc_html( isset( $_POST[$opt_jfb_show_credit] ) ? $_POST[$opt_jfb_show_credit] : 0 ) );
        update_option( $opt_jfb_email_to, esc_html( isset( $_POST[$opt_jfb_email_to] ) ? $_POST[$opt_jfb_email_to] : '' ) );
        update_option( $opt_jfb_email_logs, esc_html( isset( $_POST[$opt_jfb_email_logs] ) ? $_POST[$opt_jfb_email_logs] : 0 ) );
		update_option( $opt_jfb_email_logs_missingpost, esc_html( isset( $_POST[$opt_jfb_email_logs_missingpost] ) ? $_POST[$opt_jfb_email_logs_missingpost] : 0 ) );
        update_option( $opt_jfb_delay_redir, esc_html( isset( $_POST[$opt_jfb_delay_redir] ) ? $_POST[$opt_jfb_delay_redir] : 0 ) );
        update_option( $opt_jfb_fulllogerr, esc_html( isset( $_POST[$opt_jfb_fulllogerr] ) ? $_POST[$opt_jfb_fulllogerr] : 0 ) );
        update_option( $opt_jfb_disablenonce, esc_html( isset( $_POST[$opt_jfb_disablenonce] ) ? $_POST[$opt_jfb_disablenonce] : 0 ) );
        update_option( $opt_jfb_username_style, esc_html( isset( $_POST[$opt_jfb_username_style] ) ? $_POST[$opt_jfb_username_style] : 0 ) );
        update_option( $opt_jfb_reportstats, esc_html( isset( $_POST[$opt_jfb_reportstats] ) ? $_POST[$opt_jfb_reportstats] : 0 ) );
        ?><div class="updated"><p><strong><?php _e("Options saved", 'wp-fb-autoconnect')?></strong></p></div><?php         
    }
    if( isset($_POST['prem_opts_updated']) && function_exists('jfb_update_premium_opts'))
    {
        $shownTab = 2;
        jfb_update_premium_opts();
    }
    if( isset($_POST['remove_all_settings']) )
    {
        $shownTab = 0;
        delete_option($opt_jfb_api_key);
        delete_option($opt_jfb_api_sec);
        delete_option($opt_jfb_email_to);
        delete_option($opt_jfb_email_logs);
		delete_option($opt_jfb_email_logs_missingpost);
        delete_option($opt_jfb_delay_redir);
        delete_option($opt_jfb_ask_perms);
        delete_option($opt_jfb_ask_stream);
        delete_option($opt_jfb_stream_content);
        delete_option($opt_jfb_mod_done);
        delete_option($opt_jfb_valid);
		delete_option($opt_jfb_app_token);
        delete_option($opt_jfb_bp_avatars);
        delete_option($opt_jfb_wp_avatars);
        delete_option($opt_jfb_fulllogerr);
        delete_option($opt_jfb_disablenonce);
        delete_option($opt_jfb_show_credit);
        delete_option($opt_jfb_username_style);
        delete_option($opt_jfb_hidesponsor);
        delete_option($opt_jfb_hidew3warning);
        delete_option($opt_jfb_hidewpenginewarning);
        delete_option($opt_jfb_reportstats);
        if( function_exists('jfb_delete_premium_opts') ) jfb_delete_premium_opts();
        ?><div class="updated"><p><strong><?php _e('All plugin settings have been cleared.', 'wp-fb-autoconnect' ); ?></strong></p></div><?php
    }
    ?>
    
    <?php 
     if( isset($_REQUEST[$opt_jfb_hidesponsor]) )
          update_option($opt_jfb_hidesponsor, esc_html($_REQUEST[$opt_jfb_hidesponsor]));
     if(!get_option($opt_jfb_hidesponsor) && !defined('JFB_PREMIUM')): ?>
      	<!-- Sponsorship message *was* here, until Automattic demanded they be removed from all plugins - see http://gregsplugins.com/lib/2011/11/26/automattic-bullies/ -->
     <?php endif; ?>
     

    <!-- Tab Navigation -->
    <?php 
    //Define some variables that'll be used for our tab-switching
    $allTabsClass    = "jfb_admin_tab";
    $allTabBtnsClass = "jfb_admin_tab_btn";
    $tabIds          = array("jfb_admin_fbsetup", "jfb_admin_basicoptions", "jfb_admin_premiumoptions", "jfb_admin_uninstall", "jfb_admin_supportinfo");
    $tabNames        = array(__("Facebook Setup", 'wp-fb-autoconnect'),
    						 __("Basic Options", 'wp-fb-autoconnect'),
    						 __("Premium Options", 'wp-fb-autoconnect'),
    						 __("Uninstall", 'wp-fb-autoconnect'),
    						 __("Support Info", 'wp-fb-autoconnect'));
    ?>
    
    <script type="text/javascript">
        function jfb_swap_tabs(show_tab_num) 
        {
            //Find the ID of the tab we want to show
            var tabIds = <?php echo json_encode($tabIds);?>;
            var show_tab_id = tabIds[show_tab_num];
            
            //Hide all the tabs, then show just the one specified
        	jQuery(".<?php echo $allTabsClass ?>").hide();
        	jQuery("#" + show_tab_id).show();

        	//Unhighlight all the tab buttons, then highlight just the one specified
        	jQuery(".<?php echo $allTabBtnsClass?>").attr("class", "<?php echo $allTabBtnsClass?>");
        	jQuery("#" + show_tab_id + "_btn").addClass("jfb-admin_tab_selected");
		}
		
		//When the page is loaded, if there's a hash like "#1, #2, etc" in the URL, switch to that tab.
		//This handles restoring the previously-displayed tab after a page refresh.
		jQuery(document).ready(function() 
		{
    		if(window.location.hash)
    		{
    		    var num = parseInt(window.location.hash.substr(1));
    		    if( !isNaN(num) )
    		      jfb_swap_tabs(num);
    		}
        });
	</script>
	        
    <div>     
         <ul class="jfb-admin_tabs"><?php
             for($i=0; $i < count($tabIds); $i++)
             {
                 ?><li id="<?php echo $tabIds[$i]?>_btn" class="<?php echo $allTabBtnsClass?> <?php echo ($shownTab==$i?"jfb-admin_tab_selected":"")?>"><a href="#<?php echo $i;?>" onclick="jfb_swap_tabs('<?php echo $i?>');"><?php echo $tabNames[$i];?></a></li><?php
             }
       ?></ul>
     </div>
     
    <div class="jfb-admin_wrapper">
        <div class="<?php echo $allTabsClass ?>" id="<?php echo $tabIds[0]?>" style="display:<?php echo ($shownTab==0?"block":"none")?>">
		<h3><?php _e("Setup Instructions", 'wp-fb-autoconnect')?></h3>
			<?php _e("To allow your users to login with their Facebook accounts, you must first setup a Facebook Application for your website:",'wp-fb-autoconnect')?><br /><br />
            <ol>
			  <li><?php echo sprintf(__("Visit %s and select 'Add a New App' from the 'Apps' menu at the top.", 'wp-fb-autoconnect'), "<a href='http://developers.facebook.com/apps' target='lnk'>developers.facebook.com/apps</a>")?></li>
			  <li><?php _e("When the 'Add a New App' window pops up, click the 'advanced setup' link at the bottom.", 'wp-fb-autoconnect')?></li>
			  <li><?php _e("Type in a name (i.e. the name of your site), select a category, and click 'Create App.'", 'wp-fb-autoconnect')?></li>
			  <li><?php _e("Go to the 'Settings' page and click 'Add Platform,' then 'Website,' then fill in your 'Site URL.'", 'wp-fb-autoconnect')?><br/>
			  	  <?php _e("Note: http://example.com/ and http://www.example.com/ are NOT the same.", 'wp-fb-autoconnect')?></li>
			  <li><?php _e("Also on the 'Settings' page, enter a Contact EMail, note the App ID and App Secret (you'll need them in a minute), and save changes.", 'wp-fb-autoconnect')?></li>
			  <li><?php _e("Go to the 'Status & Review' page and make the app live (flip the switch at the top).", 'wp-fb-autoconnect')?></li>
			  <li><?php _e("Copy the App ID and App Secret to the boxes below, and click the 'Connect' button.", 'wp-fb-autoconnect')?></li>
			  <li><?php echo sprintf(__("In your Wordpress admin panel, navigate to Appearance->Widgets (%s) and add the WP-FB AutoConnect widget to your sidebar.", 'wp-fb-autoconnect'), "<a href='".admin_url('widgets.php')."' target='widgets'><b>here</b></a>");?></li>
        </ol>
            <br />
            <?php echo sprintf(__("That's it - users should now be able to login to your blog with their Facebook accounts.  For more complete documentation and help, please visit the %s plugin homepage %s.", 'wp-fb-autoconnect'), "<a target='moreinfo' href='$jfb_homepage'>", "</a>"); ?><br />
            <br />
            <hr />
            
            <h3><?php _e("Facebook Connect", 'wp-fb-autoconnect')?></h3>
            <form name="formFacebook" method="post" action="">
                <input type="text" size="40" name="<?php echo $opt_jfb_api_key?>" value="<?php echo get_option($opt_jfb_api_key) ?>" /> App ID<br />
                <input type="text" size="40" name="<?php echo $opt_jfb_api_sec?>" value="<?php echo get_option($opt_jfb_api_sec) ?>" /> App Secret
                <input type="hidden" name="fb_opts_updated" value="1" />
                <div class="submit"><input type="submit" name="Submit" value="<?php _e("Connect", 'wp-fb-autoconnect')?>" /></div>
            </form>
        </div> <!-- End Tab -->
        
        <div class="<?php echo $allTabsClass ?>" id="<?php echo $tabIds[1]?>" style="display:<?php echo ($shownTab==1?"block":"none")?>">
            <?php
            if(!get_option($opt_jfb_valid))
                echo "<div class=\"jfb-admin_warning\"><i><b>".__("You must enter a valid App ID and Secret under the 'Facebook Setup' tab before this plugin will function.", 'wp-fb-autoconnect')."</b></i></div>";    
            ?>
            <h3><?php _e("Basic Options", 'wp-fb-autoconnect')?></h3>
            <form name="formMainOptions" method="post" action="">
                <b><?php _e("Autoregistered Usernames", 'wp-fb-autoconnect')?>:</b><br />
                <input type="radio" name="<?php echo $opt_jfb_username_style; ?>" value="0" <?php echo (get_option($opt_jfb_username_style)==0?"checked='checked'":"")?> ><?php _e("Based on Facebook ID (i.e. FB_123456)", 'wp-fb-autoconnect')?><br />
                <input type="radio" name="<?php echo $opt_jfb_username_style; ?>" value="1" <?php echo (get_option($opt_jfb_username_style)==1?"checked='checked'":"")?> ><?php _e("Based on real name with prefix (i.e. FB_John_Smith)", 'wp-fb-autoconnect')?><br />
                <input type="radio" name="<?php echo $opt_jfb_username_style; ?>" value="3" <?php echo (get_option($opt_jfb_username_style)==3?"checked='checked'":"")?> ><?php _e("Based on real name without prefix (i.e. John_Smith)", 'wp-fb-autoconnect') . " <i><b>(" . __("Recommended for BuddyPress", 'wp-fb-autoconnect') . ")</b></i>";?><br />
                <input type="radio" name="<?php echo $opt_jfb_username_style; ?>" value="2" <?php echo (get_option($opt_jfb_username_style)==2?"checked='checked'":"")?> ><?php _e("Legacy Format (i.e. John.Smith)", 'wp-fb-autoconnect')?> 
                <i><b>(<?php _e("Not recommended", "wp-fb-autoconnect")?>)</b></i> <?php jfb_output_simple_lightbox("", __("Although the original 'BuddyPress-friendly' username format included a period, I later learned that this creates issues with author links in Wordpress.  I've left the option here for legacy support, but advise against using it (unless you have only one author on your blog, in which case Facebook-connected users won't have author links and so it doesn't matter).  If you do have multiple authors and are experiencing broken author links, changing this option will fix it for all NEW users, but you may want to consider fixing your existing users by replacing all of the '.'s with '_'s in the 'user_nicename' field of the 'wp_users' database table.", 'wp-fb-autoconnect')); ?><br /><br />
            
                <b><?php _e("E-Mail", 'wp-fb-autoconnect')?>:</b><br />
                <input type="checkbox" name="<?php echo $opt_jfb_ask_perms?>" value="1" <?php echo get_option($opt_jfb_ask_perms)?'checked="checked"':''?> /> <?php _e("Request permission to get the connecting user's email address", 'wp-fb-autoconnect')?>
                <?php jfb_output_simple_lightbox("", sprintf(__("Fetching your users' Facebook e-mail addresses will enable the plugin to give new (autoregistered) user accounts a valid e-mail.  However, note that this is only a request - they may still deny permission in the Facebook login popup.  If that happens, their autoregistered user account will be created with a 'placeholder' e-mail %s.<br/><br/>If you would like to require visiters to approve access to their e-mail before they're allowed to login, please check out the 'Request and REQUIRE' option under the Premium tab of the admin panel.", "wp-fb-autoconnect"), '(FB_&lt;user_id&gt;@unknown.com)')) ?><br />
        
                <br /><b><?php _e("Announcement", 'wp-fb-autoconnect')?>:</b><br />
        		<?php add_option($opt_jfb_stream_content, "has connected to " . get_option('blogname') . " with WP-FB AutoConnect."); ?>
        		<input type="checkbox" name="<?php echo $opt_jfb_ask_stream?>" value="1" <?php echo get_option($opt_jfb_ask_stream)?'checked="checked"':''?> /> <?php _e("Request permission to post the following announcement on users' Facebook walls when they connect for the first time:", 'wp-fb-autoconnect')?><br />
        		<input type="text" size="80" name="<?php echo $opt_jfb_stream_content?>" value="<?php echo stripslashes(get_option($opt_jfb_stream_content)) ?>" />
        		<?php jfb_output_simple_lightbox("", __("Unfortunately, Facebook has stopped granting this permission for new apps as of April 30 2015, effectively killing off this great feature.  <b>The option will thus only function on sites that were already using it before.</b>", 'wp-fb-autoconnect'))?><br />
        
        		<br /><b><?php _e("Avatars", 'wp-fb-autoconnect')?>:</b><br />
                <input type="checkbox" name="<?php echo $opt_jfb_wp_avatars?>" value="1" <?php echo get_option($opt_jfb_wp_avatars)?'checked="checked"':''?> /> <?php _e("Use Facebook profile pictures as avatars", 'wp-fb-autoconnect')?><br />
        
                <br /><b><?php _e("Appreciation", 'wp-fb-autoconnect')?>:</b><br />
                <input type="checkbox" name="<?php echo $opt_jfb_show_credit?>" value="1" <?php echo get_option($opt_jfb_show_credit)?'checked="checked"':''?> /> <?php _e("Display a 'Powered By' link in the blog footer (would be appreciated! :))", 'wp-fb-autoconnect')?><br />
                <input type="checkbox" name="<?php echo $opt_jfb_reportstats?>" value="1" <?php echo get_option($opt_jfb_reportstats)?'checked="checked"':''?> /> <?php _e("Periodically report usage stats to the plugin author", 'wp-fb-autoconnect')?>  <?php jfb_output_simple_lightbox("", __("Reports include some very basic server info & a login count, to help me understand how & where the plugin is most used, and how I should focus my development.  No names or e-mail addresses are sent.", 'wp-fb-autoconnect'));?><br />
        
        		<br /><b><?php _e("Debug", 'wp-fb-autoconnect')?>:</b><br />
        		<?php add_option($opt_jfb_email_to, get_bloginfo('admin_email')); ?>
        		<input id="log_mainoption" type="checkbox" name="<?php echo $opt_jfb_email_logs?>" value="1" <?php echo get_option($opt_jfb_email_logs)?'checked="checked"':''?> /> <?php _e("Send event logs to:", 'wp-fb-autoconnect')?> <input type="text" size="40" name="<?php echo $opt_jfb_email_to?>" value="<?php echo get_option($opt_jfb_email_to) ?>" /> <?php jfb_output_simple_lightbox("", __("Event logs show detailed information about the login process, and are useful for debugging various types of issues.  However, note that this option will send you an e-mail every time the login form is submitted - whether it's by a person or an automated spambot probing your site for vulnerabilities.  The latter type of submission is very common and is nothing to worry about, as both Wordpress and this plugin have various types of security to prevent the bots from getting in.  To avoid these spambot-generated messages, you may disable the suboption below.", 'wp-fb-autoconnect'));?><br />
        		<input id="log_suboption" style="margin-left:20px;" type="checkbox" name="<?php echo $opt_jfb_email_logs_missingpost?>" value="1" <?php echo get_option($opt_jfb_email_logs_missingpost)?'checked="checked"':''?> /> ...<?php echo sprintf(__("Include '%s' error events", "wp-fb-autoconnect"), 'Missing POST Data')?><br />
        		<input type="checkbox" name="<?php echo $opt_jfb_disablenonce?>" value="1" <?php echo get_option($opt_jfb_disablenonce)?'checked="checked"':''?> /> <?php _e("Disable nonce security check",'wp-fb-autoconnect')?> (<?php _e("Not recommended", 'wp-fb-autoconnect')?>)<br />
                <input type="checkbox" name="<?php echo $opt_jfb_delay_redir?>" value="1" <?php echo get_option($opt_jfb_delay_redir)?'checked="checked"':''?> /> <?php _e("Delay redirect after login", 'wp-fb-autoconnect')?> (<i><u><?php _e("Not for production sites!", 'wp-fb-autoconnect')?></u></i>)<br />
                <input type="checkbox" name="<?php echo $opt_jfb_fulllogerr?>" value="1" <?php echo get_option($opt_jfb_fulllogerr)?'checked="checked"':''?> /> <?php _e("Show full log on error", 'wp-fb-autoconnect')?> (<i><u><?php _e("Not for production sites!", 'wp-fb-autoconnect')?></u></i>)<br />
                <script type="text/javascript">
	                jQuery('#log_suboption').change(function()
	                {
					  if(jQuery(this).is(':checked'))
					    jQuery('#log_mainoption').prop('checked', true);
					});
					jQuery('#log_mainoption').change(function()
	                {
					  if(!jQuery(this).is(':checked'))
					    jQuery('#log_suboption').prop('checked', false);
					});
				</script>

                <input type="hidden" name="main_opts_updated" value="1" />
                <div class="submit"><input type="submit" name="Submit" value="<?php _e("Save", 'wp-fb-autoconnect')?>" /></div>
            </form>
    	</div><!-- End Tab -->
    
    	<div class="<?php echo $allTabsClass ?>" id="<?php echo $tabIds[2]?>" style="display:<?php echo ($shownTab==2?"block":"none")?>">
            <?php
            if(!get_option($opt_jfb_valid))
                echo "<div class=\"jfb-admin_warning\"><i><b>" . __("You must enter a valid App ID and Secret under the 'Facebook Setup' tab before this plugin will function.", 'wp-fb-autoconnect')."</b></i></div>";    
            if( function_exists('jfb_output_premium_panel')) 
                jfb_output_premium_panel(); 
            else
                jfb_output_premium_panel_tease(); 
            ?>
        </div> <!-- End Tab -->
        
        <div class="<?php echo $allTabsClass ?>" id="<?php echo $tabIds[3]?>" style="display:<?php echo ($shownTab==3?"block":"none")?>">
            <h3><?php _e("Delete All Plugin Options", 'wp-fb-autoconnect')?></h3>
            <?php _e("The following button will PERMANENTLY delete all of this plugin's options from your Wordpress database, as if it had never been installed.  Use with care!", 'wp-fb-autoconnect')?>
            <form name="formDebugOptions" method="post" action="">
                <input type="hidden" name="remove_all_settings" value="1" />
                <div class="submit"><input type="submit" name="Submit" value="<?php _e("Delete", 'wp-fb-autoconnect')?>" /></div>
            </form>
        </div> <!-- End Tab -->
        
        <div class="<?php echo $allTabsClass ?>" id="<?php echo $tabIds[4]?>" style="display:<?php echo ($shownTab==4?"block":"none")?>">
            <h3><?php _e("Support Information", 'wp-fb-autoconnect')?></h3>
            <div style="width:600px;">
            <?php echo sprintf(__("Before submitting a support request, please make sure to carefully read all the documentation and FAQs on the %s plugin homepage %s.  Every problem that's ever been reported has a solution posted there.", 'wp-fb-autoconnect'), "<a href='$jfb_homepage#faq' target='support'>", "</a>")?><br /><br />                        
            <?php echo sprintf(__("If you do choose to submit a request, please do so via the %s plugin homepage %s, not on Wordpress.org (which I rarely check).  Also, please specifically mention that you've tried it with all other plugins disabled and the default theme (see %s) and include the following information about your Wordpress environment:", 'wp-fb-autoconnect'), "<a href='$jfb_homepage#feedback' target='support'>", "</a>", "<a href='$jfb_homepage#faq100' target='faq100'>FAQ100</a>")?><br /><br />
            </div>
            <textarea readonly="readonly" onclick="this.focus();this.select();" title="<?php _e("To copy the system info, click below then press Ctrl + C (PC) or Cmd + C (Mac)", "wp-fb-autoconnect")?>" style="width:800px; height:350px; font-family: Menlo, Monaco, monospace;">
Server URL:         <?php echo "http://" . $_SERVER["HTTP_HOST"] . "\n" ?>
Site URL:           <?php echo get_bloginfo('url') . "\n" ?>
Wordpress URL:      <?php echo get_bloginfo('wpurl') . "\n" ?>
Wordpress Version:  <?php echo $GLOBALS['wp_version'] . "\n" ?>
BuddyPress Version: <?php echo (defined('BP_VERSION')?BP_VERSION:"Not Detected") . "\n"; ?>
Plugin Version:     <?php echo $jfb_version . "\n" ?>
Premium Version:    <?php echo (defined('JFB_PREMIUM_VER')?JFB_PREMIUM_VER:"Not Detected") . "\n";?>
Premium Number:     <?php echo (defined('JFB_PREMIUM')?JFB_PREMIUM:"Not Detected") . "\n";?>
WP MultiSite:       <?php echo (defined('WP_ALLOW_MULTISITE')?"Allowed":"Off") . " / " . (function_exists('is_multisite')?(is_multisite()?"Enabled":"Disabled"):"Undefined") . "\n"; ?>
WP Locale:          <?php echo get_locale() . "\n";?>
WP Debug:           <?php echo (defined('WP_DEBUG') && WP_DEBUG?"Yes":"No") . "\n"; ?>
WP Engine:          <?php echo ((defined('WPMU_PLUGIN_DIR') && file_exists(WPMU_PLUGIN_DIR . "/wpengine-common/plugin.php"))?"Yes":"No") . "\n";?>
Facebook App:       <?php echo (get_option($opt_jfb_app_id)?get_option($opt_jfb_app_id):"&lt;Unset&gt;") . "\n"?>
Facebook PHP API:   <?php echo (class_exists('Facebook')?"Already present!":"OK") . "\n" ?>
Facebook Reachable: <?php 
                $result = wp_remote_get("https://graph.facebook.com/$jfb_apiver", array( 'sslverify' => false ));
                if(is_wp_error($result))                             echo "ERROR (wp_error - unreachable)\n";
                else if (NULL == json_decode($result['body'], true)) echo "ERROR (json_decode - invalid)\n";
                else                                                 echo "OK\n"; ?>
Facebook Graph:     <?php echo $result['headers']['facebook-api-version'] . "\n";?>
Facebook Validated: <?php echo (get_option($opt_jfb_valid)?"OK":"NO")."\n";?>
Server:             <?php echo substr($_SERVER['SERVER_SOFTWARE'], 0, 65) . (strlen($_SERVER['SERVER_SOFTWARE'])>65?"...":""); ?>  
Browser:            <?php $browser = jfb_get_browser(); echo $browser['shortname'] . " " . $browser['version'] . " for " . $browser['platform'] . "\n"; ?>
Theme:              <?php echo wp_get_theme() . "\n"; ?>
Active Plugins:     <?php $active_plugins = get_option('active_plugins');
                      $plug_info=get_plugins();
                      echo count($active_plugins) . "\n";
        	          foreach($active_plugins as $name) echo "-->" . $plug_info[$name]['Title']. " " . $plug_info[$name]['Version']."\n";?>
</textarea>
        </div> <!-- End Tab -->
    
    </div><!-- div jfb-admin_wrapper -->  
   </div> <!-- div wrap -->
<?php
}


/*
 * Simple helper to output my "simple lightbox" for "click for more info" links.
 * Based on http://stephenmcintyre.net/blog/simple-css-lightbox
 */
function jfb_output_simple_lightbox($deprecated, $contents)
{
    global $jfbLbID;
    if(!isset($jfbLbID)) $jfbLbID = 0;
    else                 $jfbLbID++;
    ?>
    <a class="wpfb-moreinfo-lnk" href="javascript:void(0)" title="<?php echo $contents?>" onclick="document.getElementById('wpfb-moreinfo-bg<?php echo $jfbLbID?>').style.display='block'; document.getElementById('wpfb-moreinfo-box<?php echo $jfbLbID?>').style.display='block';">(<?php _e('Click for more info','wp-fb-autoconnect'); ?>)</a>
    <div class="wpfb-moreinfo-bg" id="wpfb-moreinfo-bg<?php echo $jfbLbID?>" onclick="document.getElementById('wpfb-moreinfo-bg<?php echo $jfbLbID?>').style.display='none'; document.getElementById('wpfb-moreinfo-box<?php echo $jfbLbID?>').style.display='none';"></div>
    <div class="wpfb-moreinfo-box" id="wpfb-moreinfo-box<?php echo $jfbLbID?>">
      <a href="javascript:void(0)" onclick="document.getElementById('wpfb-moreinfo-bg<?php echo $jfbLbID?>').style.display='none'; document.getElementById('wpfb-moreinfo-box<?php echo $jfbLbID?>').style.display='none';"><?php _e("Close", 'wp-fb-autoconnect')?></a><br />
      <div style="padding:5px;">
        <?php echo $contents; ?>
      </div>
    </div>
    <?php
}


/*********************************************************************************/
/**********************Premium Teaser - show the premium options******************/
/*********************************************************************************/

/*
 * This is an exact copy of jfb_output_premium_panel() from the premium addon; it of course just doesn't include implementation...
 */
function jfb_output_premium_panel_tease()
{
    global $jfb_homepage;
    global $opt_jfbp_notifyusers, $opt_jfbp_notifyusers_subject, $opt_jfbp_notifyusers_content, $opt_jfbp_commentfrmlogin, $opt_jfbp_wploginfrmlogin, $opt_jfbp_registrationfrmlogin, $opt_jfbp_bpregistrationfrmlogin, $opt_jfbp_cache_avatars, $opt_jfbp_cache_avatars_fullsize, $opt_jfbp_cache_avatar_dir, $opt_jfbp_cachedir_changetoblog;
    global $opt_jfbp_buttonstyle, $opt_jfbp_buttonsize, $opt_jfbp_buttontext, $opt_jfbp_buttonimg, $opt_jfbp_requirerealmail;
    global $opt_jfbp_redirect_new, $opt_jfbp_redirect_new_custom, $opt_jfbp_redirect_existing, $opt_jfbp_redirect_existing_custom, $opt_jfbp_redirect_logout, $opt_jfbp_redirect_logout_custom;
    global $opt_jfbp_restrict_reg, $opt_jfbp_restrict_reg_url, $opt_jfbp_restrict_reg_uid, $opt_jfbp_restrict_reg_pid, $opt_jfbp_restrict_reg_gid;
    global $opt_jfbp_show_spinner, $opt_jfbp_allow_link, $opt_jfbp_allow_disassociate, $opt_jfbp_autoregistered_role, $jfb_data_url;
    global $opt_jfbp_wordbooker_integrate, $opt_jfbp_signupfrmlogin, $opt_jfbp_localize_facebook;
    global $opt_jfbp_xprofile_map, $opt_jfbp_xprofile_mappings, $jfb_xprofile_field_prefix;
    global $opt_jfbp_bpstream_login, $opt_jfbp_bpstream_logincontent, $opt_jfbp_bpstream_register, $opt_jfbp_bpstream_registercontent;
    global $opt_jfbp_email_rejected_msg, $opt_jfbp_avatar_full_dimensions_w, $opt_jfbp_avatar_full_dimensions_h;
    global $opt_jfbp_link_buttontext, $opt_jfbp_unlink_buttontext;
    function disableatt() { echo (defined('JFB_PREMIUM')?"":"disabled='disabled'"); }
    ?>
    <!--Show the Premium version number along with a link to immediately check for updates-->
    <form name="formPremUpdateCheck" method="post" action="">
        <h3><?php _e('Premium Options', 'wp-fb-autoconnect')?> <?php echo (defined('JFB_PREMIUM_VER')?"<span style='font-size:x-small;'>(<a href=\"javascript:document.formPremUpdateCheck.submit();\">".__('Check for Updates', 'wp-fb-autoconnect')."</a>)</span>":""); ?></h3>
        <input type="hidden" name="VersionCheckNow" value="1" />
    </form>
    
    <?php 
    if( !defined('JFB_PREMIUM') )
        echo "<div class=\"jfb-admin_warning\"><i><b>".__("The following options are available to Premium users only.", "wp-fb-autoconnect")."</b><br />".__("For information about the WP-FB-AutoConnect Premium Add-On, including purchasing instructions, please visit the plugin homepage:","wp-fb-autoconnect") . " <b><a target='preminfo' href=\"$jfb_homepage#premium\">here</a></b></i>.</div>";
    ?>
    
    <form name="formPremOptions" method="post" action="">
    
        <b><?php _e('MultiSite Support', 'wp-fb-autoconnect')?>:</b><br/>
        <input disabled='disabled' type="checkbox" name="musupport" value="1" <?php echo ((defined('JFB_PREMIUM')&&function_exists('is_multisite')&&is_multisite())?"checked='checked'":"")?> >
        <?php _e('Automatically enabled when a MultiSite install is detected', 'wp-fb-autoconnect')?>
        <?php jfb_output_simple_lightbox("", __("The free plugin is not aware of users registered on other sites in your WPMU installation, which can result in problems i.e. if someone tries to register on more than one site.  The Premium version will actively detect and handle existing users across all your sites.", "wp-fb-autoconnect"))?><br /><br />

        <b><?php _e('E-Mail Permissions', 'wp-fb-autoconnect')?>:</b><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_requirerealmail?>" value="1" <?php echo get_option($opt_jfbp_requirerealmail)?'checked="checked"':''?> /> <?php _e("Request and REQUIRE access to user's email address", 'wp-fb-autoconnect')?>
        <?php jfb_output_simple_lightbox("", __("The basic option to request user email addresses will prompt your visitors, but they can still choose not to share it (in the Facebook login prompt).  This option performs a secondary check to REQUIRE them to share; if they don't, the site won't log them in (until they click the button again, and agree to share their address).", 'wp-fb-autoconnect'))?><br />
        <?php add_option($opt_jfbp_email_rejected_msg, __("Sorry, this site requires an e-mail address to log you in.",'wp-fb-autoconnect'));?>
        <?php _e("Message to users who deny e-mail access:", 'wp-fb-autoconnect')?> <input <?php disableatt() ?> type="text" size="55" name="<?php echo $opt_jfbp_email_rejected_msg; ?>" value="<?php echo get_option($opt_jfbp_email_rejected_msg); ?>" /><br /><br/>

        <b><?php _e('Button Style', 'wp-fb-autoconnect')?>:</b><br />
        <?php add_option($opt_jfbp_buttontext, "Login with Facebook");
        add_option($opt_jfbp_buttonsize, "2");
        $btnDefault = $jfb_data_url . "/assets/btn01.png";
        add_option($opt_jfbp_buttonimg, $btnDefault);
        $btnPreview = get_option($opt_jfbp_buttonimg);
        if(!$btnPreview) $btnPreview = $btnDefault;
        ?>

        <input <?php disableatt() ?> type="radio" style="float:left;" name="<?php echo $opt_jfbp_buttonstyle; ?>" value="0" <?php echo (get_option($opt_jfbp_buttonstyle)==0?"checked='checked'":"")?>>
        <div class="jfb-greybox" style="float:left;">
            <b><?php _e('Original', 'wp-fb-autoconnect')?> (xfbml):</b><br/>
            <?php _e('Text', 'wp-fb-autoconnect')?>: <input <?php disableatt() ?> type="text" size="30" name="<?php echo $opt_jfbp_buttontext; ?>" value="<?php echo get_option($opt_jfbp_buttontext); ?>" /><br />
            <?php _e('Style', 'wp-fb-autoconnect')?>: 
            <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_buttonsize; ?>" value="2" <?php echo (get_option($opt_jfbp_buttonsize)==2?"checked='checked'":"")?>><?php _e('Small', 'wp-fb-autoconnect')?>
            <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_buttonsize; ?>" value="3" <?php echo (get_option($opt_jfbp_buttonsize)==3?"checked='checked'":"")?>><?php _e('Medium', 'wp-fb-autoconnect')?>
            <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_buttonsize; ?>" value="4" <?php echo (get_option($opt_jfbp_buttonsize)==4?"checked='checked'":"")?>><?php _e('Large', 'wp-fb-autoconnect')?>
            <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_buttonsize; ?>" value="5" <?php echo (get_option($opt_jfbp_buttonsize)==5?"checked='checked'":"")?>><?php _e('X-Large', 'wp-fb-autoconnect')?><br />
        </div><br clear="all"/>
        <input <?php disableatt() ?> type="radio" style="float:left;" name="<?php echo $opt_jfbp_buttonstyle; ?>" value="1" <?php echo (get_option($opt_jfbp_buttonstyle)==1?"checked='checked'":"")?>>
        <div class="jfb-greybox" style="float:left;">
            <b><?php _e('Image (styleable)', 'wp-fb-autoconnect')?>:</b><br/>
            <?php _e('URL', 'wp-fb-autoconnect')?>: <input <?php disableatt() ?> type="text" size="80" name="<?php echo $opt_jfbp_buttonimg; ?>" value="<?php echo get_option($opt_jfbp_buttonimg); ?>" /><br/>
            <?php _e('Preview', 'wp-fb-autoconnect')?>: <img style="vertical-align:middle;margin-top:5px;" src="<?php echo $btnPreview?>" alt="(Login Button)" />
        </div><br clear="all"/><br/>
        
        <b><?php _e('Additional Buttons', 'wp-fb-autoconnect')?>:</b><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_commentfrmlogin?>" value="1" <?php echo get_option($opt_jfbp_commentfrmlogin)?'checked="checked"':''?> /> <?php _e('Add a Facebook Login button below the comment form', 'wp-fb-autoconnect')?><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_wploginfrmlogin?>" value="1" <?php echo get_option($opt_jfbp_wploginfrmlogin)?'checked="checked"':''?> /> <?php _e('Add a Facebook Login button to the standard Login page', 'wp-fb-autoconnect')?> (wp-login.php)<br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_registrationfrmlogin?>" value="1" <?php echo get_option($opt_jfbp_registrationfrmlogin)?'checked="checked"':''?> /> <?php _e('Add a Facebook Login button to the Registration page', 'wp-fb-autoconnect')?> (wp-login.php)<br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_bpregistrationfrmlogin?>" value="1" <?php echo get_option($opt_jfbp_bpregistrationfrmlogin)?'checked="checked"':''?> /> <?php _e('Add a Facebook Login button to the BuddyPress Registration page', 'wp-fb-autoconnect')?> (/register)<br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_signupfrmlogin?>" value="1" <?php echo get_option($opt_jfbp_signupfrmlogin)?'checked="checked"':''?> /> <?php _e('Add a Facebook Login button to the Signup page (WPMU Only)', 'wp-fb-autoconnect')?> (wp-signup.php)<br /><br />
                        
        <!-- Facebook's OAuth 2.0 migration BROKE my ability to localize the XFBML-generated dialog.  I've reported a bug, and will do my best to fix it as soon as possible.
         <b>Facebook Localization:</b><br />
        <?php add_option($opt_jfbp_localize_facebook, 1); ?>
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_localize_facebook?>" value="1" <?php echo get_option($opt_jfbp_localize_facebook)?"checked='checked'":""?> >
        Translate Facebook prompts to the same locale as your Wordpress blog (Detected locale: <i><?php echo ( (defined('WPLANG')&&WPLANG!="") ? WPLANG : "en_US" ); ?></i>)
        <dfn title="The Wordpress locale is specified in wp-config.php, where valid language codes are of the form 'en_US', 'ja_JP', 'es_LA', etc.  Please see http://codex.wordpress.org/Installing_WordPress_in_Your_Language for more information on localizing Wordpress, and http://developers.facebook.com/docs/internationalization/ for a list of locales supported by Facebook.">(Mouseover for more info)</dfn><br /><br />
         -->
                        
        <b><?php _e('Avatars', 'wp-fb-autoconnect')?>:</b><br />
        <script type="text/javascript">function isNumber(evt) {evt = (evt) ? evt : window.event;var charCode = (evt.which) ? evt.which : evt.keyCode; if (charCode > 31 && (charCode < 48 || charCode > 57)) { return false;}return true;}</script>  
        <?php 
        add_option($opt_jfbp_cache_avatars_fullsize, get_option($opt_jfbp_cache_avatars)); 
        add_option($opt_jfbp_avatar_full_dimensions_w, 200);
        add_option($opt_jfbp_avatar_full_dimensions_h, 200);        
        ?> 
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_cache_avatars?>" value="1" <?php echo get_option($opt_jfbp_cache_avatars)?'checked="checked"':''?> />
        <?php _e('Cache Facebook avatars locally', 'wp-fb-autoconnect')?> (<?php _e('thumbnail', 'wp-fb-autoconnect')?>) <?php jfb_output_simple_lightbox("", __("This will make a local copy of Facebook avatars, so they'll always load reliably, even if Facebook's servers go offline or if a user deletes their photo from Facebook. They will be fetched and updated whenever a user logs in.", "wp-fb-autoconnect"));?><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_cache_avatars_fullsize?>" value="1" <?php echo get_option($opt_jfbp_cache_avatars_fullsize)?'checked="checked"':''?> />
        <?php _e('Cache Facebook avatars locally', 'wp-fb-autoconnect')?> (<?php _e('large', 'wp-fb-autoconnect')?>):
        <input <?php disableatt() ?> onkeypress="return isNumber(event)" type="text" size="4" name="<?php echo $opt_jfbp_avatar_full_dimensions_w; ?>" value="<?php echo get_option($opt_jfbp_avatar_full_dimensions_w) ?>" />
        x
        <input <?php disableatt() ?> onkeypress="return isNumber(event)" type="text" size="4" name="<?php echo $opt_jfbp_avatar_full_dimensions_h; ?>" value="<?php echo get_option($opt_jfbp_avatar_full_dimensions_h) ?>" />
        <?php jfb_output_simple_lightbox("", __("The 'thumbnail' avatar is what will be shown when your theme requests avatars sized 50x50 or less (Facebook's default thumbnail size).  If your theme displays avatars larger than this, you'll want to cache larger avatars as well (but note that there's a small per-login performance cost to copying the files locally, so if you're not actually using large avatars, I recommend leaving this option disabled).", 'wp-fb-autoconnect') . "<br/><br/>" . 
                                             __("Please note that the dimensions you specify should be considered a MAXIMUM; Facebook will attempt to scale the avatar as close to your requested dimensions as possible, and then crop it down to fit.  If you just want the largest possible image, you can enter very large numbers (i.e. 99999x99999).  But since the final size is not precisely guaranteed, please consider using CSS to ensure the images mesh nicely with your theme.", 'wp-fb-autoconnect'))?><br/>
        
        <?php add_option($opt_jfbp_cache_avatar_dir, 'facebook-avatars'); ?>
        <?php _e('Cache dir', 'wp-fb-autoconnect')?>:
            <?php
            //If this is multisite, we'll allow the use of the uploaddir of *any* blog in the network (not just the current one).
            //This way, all the blogs can share the same avatar cache if desired.
            if(function_exists('is_multisite') && is_multisite())
            {
                global $wpdb;
                $blogs = $wpdb->get_results( $wpdb->prepare("SELECT blog_id, domain, path FROM $wpdb->blogs WHERE site_id = %d AND public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' ORDER BY registered ASC", $wpdb->siteid), ARRAY_A );
                echo "<select name='".$opt_jfbp_cachedir_changetoblog."'>";
                foreach ($blogs AS $blog)
                {
                    switch_to_blog($blog['blog_id']);
                    $path = wp_upload_dir();
                    restore_current_blog();
                    $selectedBlogID = get_option($opt_jfbp_cachedir_changetoblog);
                    if($selectedBlogID == 0) $selectedBlogID = get_current_blog_id();
                    $selected = ($selectedBlogID == $blog['blog_id'])?" selected='true' ":'';
                    echo '<option '.$selected.' value="'.$blog['blog_id'].'">'.$path['basedir'].'</option>';
                }
                echo "</select>\\";
            }
            //If this is NOT multisite, we'll always use the current blog's upload_dir as the basedir for our avatar cache
            else
            {
                $path = wp_upload_dir();
                update_option($opt_jfbp_cachedir_changetoblog, 0);
                ?><span style="background-color:#FFFFFF; color:#aaaaaa; padding:2px 0;"><i><?php echo $path['basedir']; ?>/</i></span><?php
            }
            ?>
        <input <?php disableatt() ?> type="text" size="15" name="<?php echo $opt_jfbp_cache_avatar_dir; ?>" value="<?php echo get_option($opt_jfbp_cache_avatar_dir); ?>" />
        <?php jfb_output_simple_lightbox("", __("Changing the cache directory will not move existing avatars or update existing users; it only applies to subsequent logins.  It's therefore recommended that you choose a cache directory once, then leave it be.", 'wp-fb-autoconnect'))?><br /><br/>
<!--        
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_wordbooker_integrate?>" value="1" <?php echo get_option($opt_jfbp_wordbooker_integrate)?'checked="checked"':''?> /> <?php _e('Use Facebook avatars for comments imported by the Wordbooker plugin', 'wp-fb-autoconnect')?>
        <?php jfb_output_simple_lightbox("", __("The Wordbooker plugin allows you to push blog posts to your Facebook wall, and also to import comments on these posts back to your blog.  This option will display real Facebook avatars for imported comments, provided the commentor logs into your site at least once.", 'wp-fb-autoconnect'))?><br /><br />
-->

        <b><?php _e('Manual Linking & Unlinking', 'wp-fb-autoconnect')?>:</b><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_allow_link?>" value="1" <?php echo get_option($opt_jfbp_allow_link)?'checked="checked"':''?> /> <?php _e('Allow users to manually link their Wordpress/Buddypress accounts to Facebook', 'wp-fb-autoconnect')?>
        <?php jfb_output_simple_lightbox("", __("This will add a button to each non-Facebook-connected user's Wordpress (and Buddypress) profile page, allowing them to manually link their blog account to their Facebook profile.  Although this plugin does try to match connecting Facebook users to existing Wordpress accounts by e-mail, this option provides a way for users to explicitly identify their local blog account - even if their e-mails don't match.", 'wp-fb-autoconnect'))?><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_allow_disassociate?>" value="1" <?php echo get_option($opt_jfbp_allow_disassociate)?'checked="checked"':''?> /> <?php _e('Allow users to disassociate their Wordpress/Buddypress accounts from Facebook', 'wp-fb-autoconnect')?>
        <?php jfb_output_simple_lightbox("", __("This will add a button to each connected user's Wordpress (and Buddypress) profile page, allowing them to disassociate their blog account from their Facebook profile.  User accounts which are not connected to Facebook will display 'Not Connected' in place of a button.", 'wp-fb-autoconnect'))?><br />
        <input disabled='disabled' type="checkbox" name="admindisassociate" value="1" <?php echo (defined('JFB_PREMIUM')?"checked='checked'":"")?> /> <?php _e('Allow administrators to disassociate Wordpress/Buddypress user accounts from Facebook', 'wp-fb-autoconnect')?>
        <?php jfb_output_simple_lightbox("", __("This option is always enabled for administrators.", 'wp-fb-autoconnect'))?><br />
        
        <?php add_option($opt_jfbp_link_buttontext, __("Link with Facebook", 'wp-fb-autoconnect'));?>
        <?php add_option($opt_jfbp_unlink_buttontext, __("Disassociate From Facebook", 'wp-fb-autoconnect'));?>
        <?php _e('Link button text (shown on user profiles)', 'wp-fb-autoconnect')?>: <input <?php disableatt() ?> type="text" size="30" name="<?php echo $opt_jfbp_link_buttontext; ?>" value="<?php echo get_option($opt_jfbp_link_buttontext); ?>" /><br />
        <?php _e('Disassociate button text (shown on user profiles)', 'wp-fb-autoconnect')?>: <input <?php disableatt() ?> type="text" size="30" name="<?php echo $opt_jfbp_unlink_buttontext; ?>" value="<?php echo get_option($opt_jfbp_unlink_buttontext); ?>" /><br /><br/>

        <b><?php _e('Shortcode Support', 'wp-fb-autoconnect')?>:</b><br />
        <input disabled='disabled' type="checkbox" name="shortcodesupport" value="1" <?php echo (defined('JFB_PREMIUM')?"checked='checked'":"")?> />
        <?php _e('Enable shortcode for rendering Facebook buttons to your posts and pages', 'wp-fb-autoconnect')?>
        <?php 
        $lbContent = sprintf(__("Shortcode support will allow you to manually place Facebook login buttons in your posts or pages, simply by inserting the tag %s in their content. The Facebook button will only be shown when nobody is logged into the site; otherwise, nothing is shown.  If you'd like to specify something to output for logged-in users, you can use the %s parameter, like %s.", 'wp-fb-autoconnect'), "<b>[jfb_facebook_btn]</b>", "'loggedin'", "<b>[jfb_facebook_btn loggedin='Welcome!']</b>");
        $lbContent .= "<br/><br/>";
        $lbContent .= sprintf(__("With the Premium addon installed, shortcode support is always enabled.  For general information on Wordpress shortcode, please see %s.", 'wp-fb-autoconnect'), "<a href='http://codex.wordpress.org/Shortcode' target='shortcode'>http://codex.wordpress.org/Shortcode</a>"); 
        jfb_output_simple_lightbox("", $lbContent)?><br /><br />
            
        <b><?php _e('Double Logins', 'wp-fb-autoconnect')?>:</b><br />
        <input disabled='disabled' type="checkbox" name="doublelogin" value="1" <?php echo (defined('JFB_PREMIUM')?"checked='checked'":"")?> />
        <?php _e('Automatically handle double logins', 'wp-fb-autoconnect')?> 
        <?php jfb_output_simple_lightbox("", sprintf(__("If a visitor opens two browser windows, logs into one, then logs into the other, the security nonce check will fail.  This is because in the second window, the current user no longer matches the user for which the nonce was generated.  The free version of the plugin reports this to the visitor, giving them a link to their desired redirect page.  The premium version will transparently handle such double-logins: to visitors, it'll look like the page has just been refreshed and they're now logged in.  For more information on nonces, please visit %s.", 'wp-fb-autoconnect'), "<a href='http://codex.wordpress.org/WordPress_Nonces' target='nonces'>http://codex.wordpress.org/WordPress_Nonces</a>"))?><br /><br />
        
        <b><?php _e('Autoregistered User Role', 'wp-fb-autoconnect')?>:</b><br />
        <?php
        add_option($opt_jfbp_autoregistered_role, get_option('default_role'));
        $currSelection = get_option($opt_jfbp_autoregistered_role);
        $editable_roles = get_editable_roles();
        if ( empty( $editable_roles[$currSelection] ) ) $currSelection = get_option('default_role');
        ?>
        <?php _e('Users who are autoregistered with Facebook will be created with the role:', 'wp-fb-autoconnect')?> 
        <select <?php disableatt() ?> name="<?php echo $opt_jfbp_autoregistered_role?>" id="<?php echo $opt_jfbp_autoregistered_role?>">
            <?php wp_dropdown_roles( $currSelection ); ?>
        </select><br /><br />

        <b><?php _e('Widget Appearance', 'wp-fb-autoconnect')?>:</b><br />
        <?php echo sprintf(__("Please use the %s if you'd like to:", 'wp-fb-autoconnect'), "<a href='".admin_url('widgets.php')."' target='widgets'>WP-FB AutoConnect <b><i>Premium</i></b> Widget</a>"); ?><br />
        &bull; <?php _e("Customize the Widget's text", 'wp-fb-autoconnect')?> <?php jfb_output_simple_lightbox("", __("You can customize the text of: User, Pass, Login, Remember, Forgot, Logout, Edit Profile, Welcome.", 'wp-fb-autoconnect'))?><br />
        &bull; <?php _e("Show/Hide any of the Widget's links, checkboxes, or textfields", 'wp-fb-autoconnect')?> <?php jfb_output_simple_lightbox("", __("You can show or hide:", 'wp-fb-autoconnect') . "<ul style='list-style-type:disc;list-style-position:inside;'><li>".__('The User/Pass fields (leaving Facebook as the only way to login)', 'wp-fb-autoconnect')."</li><li>".__("The 'Register' link (only applicable if registration is enabled on the site/network)", 'wp-fb-autoconnect')."</li><li>".__("The 'Remember' tickbox", 'wp-fb-autoconnect')."</li><li>".__("The 'Edit Profile' link", 'wp-fb-autoconnect')."</li><li>".__("The 'Forgot Password' link",'wp-fb-autoconnect')."</li></ul>")?><br />      
        &bull; <?php _e("Show the user's avatar next to their username (when logged in)", 'wp-fb-autoconnect')?><br />
        &bull; <?php _e("Point the 'Edit Profile' link to the BP profile, rather than WP", 'wp-fb-autoconnect')?><br/>
        &bull; <?php _e("Point the 'Forgot Password' link to a custom URL of your choosing", 'wp-fb-autoconnect')?><br />
        &bull; <?php _e("Allow the user to simultaneously logout of your site *and* Facebook", 'wp-fb-autoconnect')?><br /><br />
            
        <b><?php _e('AJAX Spinner', 'wp-fb-autoconnect')?>:</b><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_show_spinner; ?>" value="0" <?php echo (get_option($opt_jfbp_show_spinner)==0?"checked='checked'":"")?> ><?php _e("Don't show an AJAX spinner", 'wp-fb-autoconnect')?><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_show_spinner; ?>" value="1" <?php echo (get_option($opt_jfbp_show_spinner)==1?"checked='checked'":"")?> ><?php _e('Show a white AJAX spinner to indicate the login process has started', 'wp-fb-autoconnect')?> (<img src=" <?php echo $jfb_data_url ?>/assets/spinner_white.gif" alt="spinner" />)<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_show_spinner; ?>" value="2" <?php echo (get_option($opt_jfbp_show_spinner)==2?"checked='checked'":"")?> ><?php _e('Show a black AJAX spinner to indicate the login process has started', 'wp-fb-autoconnect')?> (<img src=" <?php echo $jfb_data_url ?>/assets/spinner_black.gif" alt="spinner" />)<br /><br />
                
        <b><?php _e('AutoRegistration Restrictions', 'wp-fb-autoconnect')?>:</b><br />
        <?php add_option($opt_jfbp_restrict_reg_url, '/') ?>
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_restrict_reg; ?>" value="0" <?php echo (get_option($opt_jfbp_restrict_reg)==0?"checked='checked'":"")?>><?php _e('Open - Anyone can login (Default)', 'wp-fb-autoconnect')?><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_restrict_reg; ?>" value="1" <?php echo (get_option($opt_jfbp_restrict_reg)==1?"checked='checked'":"")?>><?php _e('Closed - Only login existing blog users', 'wp-fb-autoconnect')?><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_restrict_reg; ?>" value="2" <?php echo (get_option($opt_jfbp_restrict_reg)==2?"checked='checked'":"")?>><?php echo sprintf(__("Invitational - Only autoregister users who've been invited via the %s plugin", 'wp-fb-autoconnect'), '<a target="secureinvites" href="http://wordpress.org/extend/plugins/wordpress-mu-secure-invites/">Secure Invites</a>')?> <?php jfb_output_simple_lightbox("", __("For invites to work, the connecting user's Facebook email must be accessible, and it must match the email to which the invitation was sent.", 'wp-fb-autoconnect'))?><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_restrict_reg; ?>" value="3" <?php echo (get_option($opt_jfbp_restrict_reg)==3?"checked='checked'":"")?>><?php _e('Friendship - Only autoregister friends of Facebook user id:', 'wp-fb-autoconnect')?> <input <?php disableatt() ?> type="text" size="15" name="<?php echo $opt_jfbp_restrict_reg_uid?>" value="<?php echo get_option($opt_jfbp_restrict_reg_uid) ?>" /> <?php jfb_output_simple_lightbox("", sprintf(__("To find your Facebook uid, login and view your Profile Pictures album.  The URL will be something like '%s'.  In this example, your uid would be 789 (the numbers after the last decimal point).<br/><br/>Note: For this feature to work, the user you enter here must login via this Facebook app at least once.",'wp-fb-autoconnect'), "http://www.facebook.com/media/set/?set=a.123.456.789"))?><br />
        <!--<input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_restrict_reg; ?>" value="4" <?php echo (get_option($opt_jfbp_restrict_reg)==4?"checked='checked'":"")?>><?php _e('Membership - Only autoregister members of Facebook group id:', 'wp-fb-autoconnect')?> <input <?php disableatt() ?> type="text" size="15" name="<?php echo $opt_jfbp_restrict_reg_gid?>" value="<?php echo get_option($opt_jfbp_restrict_reg_gid); ?>" /> <?php jfb_output_simple_lightbox("", sprintf(__("To find a group's id, view its URL.  If it's something like '%s', the id would be 12345678.  If it uses a vanity URL (like %s) and is public, you can use %s to find its id.  If the group is both private/secret AND it uses a vanity URL, you'll have to use Facebook's Graph Explorer tool to lookup the id.  Visit %s, then click 'Submit.'  Assuming you're a member of the group, you should see it listed in the result, along with its id.", 'wp-fb-autoconnect'), "www.facebook.com/groups/12345678/", "www.facebook.com/groups/MyGroupName/", "<a href='http://lookup-id.com' target='vanity'>lookup-id.com</a>", "<a href='https://developers.facebook.com/tools/explorer/?method=GET&path=me%3Ffields%3Dgroups' target='explorer'>here</a>") . "<br/><br/>" . __("In order to use this option, you'll need to submit your app for review by Facebook.  Please see FAQ#56 for more info:", 'wp-fb-autoconnect') . " <a href='$jfb_homepage#faq56' target='extendedfaq'>here</a>")?><br />-->
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_restrict_reg; ?>" value="5" <?php echo (get_option($opt_jfbp_restrict_reg)==5?"checked='checked'":"")?>><?php _e('Fanpage - Only autoregister fans of Facebook page id:', 'wp-fb-autoconnect')?> <input <?php disableatt() ?> type="text" size="15" name="<?php echo $opt_jfbp_restrict_reg_pid?>" value="<?php echo get_option($opt_jfbp_restrict_reg_pid); ?>" /> <?php jfb_output_simple_lightbox("", sprintf(__("To find a page's id, view one of its photo albums.  The URL will be something like '%s'.  In this example, the id would be 789 (the numbers after the last decimal point).", 'wp-fb-autoconnect'),"http://www.facebook.com/media/set/?set=a.123.456.789") . "<br/><br/>" . __("In order to use this option, you'll need to submit your app for review by Facebook.  Please see FAQ#56 for more info:", 'wp-fb-autoconnect') . " <a href='$jfb_homepage#faq56' target='extendedfaq'>here</a>")?><br />
        <?php _e('Redirect URL for denied logins:', 'wp-fb-autoconnect')?> <input <?php disableatt() ?> type="text" size="30" name="<?php echo $opt_jfbp_restrict_reg_url?>" value="<?php echo get_option($opt_jfbp_restrict_reg_url) ?>" /><br /><br />
                
        <b><?php _e('Custom Redirects', 'wp-fb-autoconnect')?>:</b><br />
        <?php add_option($opt_jfbp_redirect_new, "1"); ?>
        <?php add_option($opt_jfbp_redirect_existing, "1"); ?>
        <?php add_option($opt_jfbp_redirect_logout, "1"); ?>
        <?php _e('When a new user is autoregistered on your site, redirect them to:', 'wp-fb-autoconnect')?><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_new; ?>" value="1" <?php echo (get_option($opt_jfbp_redirect_new)==1?"checked='checked'":"")?> ><?php _e('Default (refresh current page)', 'wp-fb-autoconnect')?><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_new; ?>" value="2" <?php echo (get_option($opt_jfbp_redirect_new)==2?"checked='checked'":"")?> ><?php _e('Custom URL', 'wp-fb-autoconnect')?>:
        <input <?php disableatt() ?> type="text" size="47" name="<?php echo $opt_jfbp_redirect_new_custom?>" value="<?php echo get_option($opt_jfbp_redirect_new_custom) ?>" /> <small>(<?php echo sprintf(__('Supports %s variables', 'wp-fb-autoconnect'), "%username%")?>)</small><br /><br />
        <?php _e('When an existing user returns to your site, redirect them to:', 'wp-fb-autoconnect')?><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_existing; ?>" value="1" <?php echo (get_option($opt_jfbp_redirect_existing)==1?"checked='checked'":"")?> ><?php _e('Default (refresh current page)', 'wp-fb-autoconnect')?><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_existing; ?>" value="2" <?php echo (get_option($opt_jfbp_redirect_existing)==2?"checked='checked'":"")?> ><?php _e('Custom URL', 'wp-fb-autoconnect')?>:
        <input <?php disableatt() ?> type="text" size="47" name="<?php echo $opt_jfbp_redirect_existing_custom?>" value="<?php echo get_option($opt_jfbp_redirect_existing_custom) ?>" /> <small>(<?php echo sprintf(__('Supports %s variables', 'wp-fb-autoconnect'), "%username%") ?>)</small><br /><br />
        <?php _e('When a user logs out of your site, redirect them to:', 'wp-fb-autoconnect')?><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_logout; ?>" value="1" <?php echo (get_option($opt_jfbp_redirect_logout)==1?"checked='checked'":"")?> ><?php _e('Default (refresh current page)', 'wp-fb-autoconnect')?><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_logout; ?>" value="2" <?php echo (get_option($opt_jfbp_redirect_logout)==2?"checked='checked'":"")?> ><?php _e('Custom URL', 'wp-fb-autoconnect')?>:
        <input <?php disableatt() ?> type="text" size="47" name="<?php echo $opt_jfbp_redirect_logout_custom?>" value="<?php echo get_option($opt_jfbp_redirect_logout_custom) ?>" /><br /><br />

        <b><?php _e('Welcome Message', 'wp-fb-autoconnect')?>:</b><br />
        <?php add_option($opt_jfbp_notifyusers_content, "Thank you for logging into " . get_option('blogname') . " with Facebook.\nIf you would like to login manually, you may do so with the following credentials.\n\nUsername: %username%\nPassword: %password%"); ?>
        <?php add_option($opt_jfbp_notifyusers_subject, "Welcome to " . get_option('blogname')); ?>
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_notifyusers?>" value="1" <?php echo get_option($opt_jfbp_notifyusers)?'checked="checked"':''?> /> <?php _e('Send a custom welcome e-mail to users who register via Facebook', 'wp-fb-autoconnect')?> <small>(*<?php _e('If we know their address', 'wp-fb-autoconnect')?>)</small><br />
        <input <?php disableatt() ?> type="text" size="102" name="<?php echo $opt_jfbp_notifyusers_subject?>" value="<?php echo get_option($opt_jfbp_notifyusers_subject) ?>" /><br />
        <textarea <?php disableatt() ?> cols="85" rows="5" name="<?php echo $opt_jfbp_notifyusers_content?>"><?php echo get_option($opt_jfbp_notifyusers_content) ?></textarea><br /><br />

        <b><?php _e('BuddyPress Activity Stream', 'wp-fb-autoconnect')?>:</b><br />
        <?php add_option($opt_jfbp_bpstream_logincontent, sprintf(__("%s logged in with Facebook", 'wp-fb-autoconnect'), "%user%")); ?>
        <?php add_option($opt_jfbp_bpstream_registercontent, sprintf(__("%s registered with Facebook", 'wp-fb-autoconnect'), "%user%")); ?>
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_bpstream_register?>" value="1" <?php echo get_option($opt_jfbp_bpstream_register)?'checked="checked"':''?> /> <?php _e('When a new user autoconnects to your site, post to the BP Activity Stream:', 'wp-fb-autoconnect')?>
        <input <?php disableatt() ?> type="text" size="50" name="<?php echo $opt_jfbp_bpstream_registercontent?>" value="<?php echo get_option($opt_jfbp_bpstream_registercontent) ?>" /><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_bpstream_login?>" value="1" <?php echo get_option($opt_jfbp_bpstream_login)?'checked="checked"':''?> /> <?php _e('When an existing user returns to your site, post to the BP Activity Stream:', 'wp-fb-autoconnect')?>
        <input <?php disableatt() ?> type="text" size="50" name="<?php echo $opt_jfbp_bpstream_logincontent?>" value="<?php echo get_option($opt_jfbp_bpstream_logincontent) ?>" /><br /><br />
 
        <b><?php _e('BuddyPress X-Profile Mappings', 'wp-fb-autoconnect')?>:</b><br />
        <?php _e("This section will let you automatically fill in your Buddypress users' X-Profile data from their Facebook profiles.", 'wp-fb-autoconnect')?><br />
        <small>&bull; <?php _e('Some limitations exist regarding which X-Profile fields can be populated', 'wp-fb-autoconnect')?></small> <?php jfb_output_simple_lightbox("", __("Only 'Text Box,' 'Multi-Line Text Box,' and 'Date Selector'-type profile fields can be mapped at this time.  Due to unpredictability in matching freeform values from Facebook to pre-defined values on BuddyPress, support for dropdowns, radiobuttons, and checkboxes MAY be added in the future.", 'wp-fb-autoconnect'))?><br />
        <small>&bull; <?php _e('Some limitations exist regarding which Facebook fields can be imported', 'wp-fb-autoconnect')?></small> <?php jfb_output_simple_lightbox("", __("Because some Facebook fields are formatted differently, each one needs to be explicitly implemented.  I've included an initial selection of fields (i.e. Name, Gender, Birthday, Bio, etc), but if you need another field to be available, please request it on the support page and I'll do my best to add it to the next update.", 'wp-fb-autoconnect'))?><br />
        <small>&bull; <?php _e("In order to import fields marked with an asterisk (i.e. Birthday*), you'll need to submit your app for review by Facebook.  Please see FAQ#56 for more info:", 'wp-fb-autoconnect'); echo " <a href='$jfb_homepage#faq56' target='extendedfaq'>here</a>"; ?></small><br/><br/>
                
         <?php
         //If people report problems with Buddypress detection, use this more robust method: http://codex.buddypress.org/plugin-development/checking-buddypress-is-active/
         if( !function_exists('bp_has_profile') ) echo "<i>".__("BuddyPress Not Found.  This section is only available on BuddyPress-enabled sites.",'wp-fb-autoconnect')."</i>";
         else if ( !bp_has_profile() )            echo __("Error: BuddyPress Profile Not Found.  This should never happen - if you see this message, please report it on the plugin support page.", 'wp-fb-autoconnect');
         else
         {
            //Present the 3 mapping options: disable mapping, map new users, or map new and returning users ?> 
            <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_xprofile_map; ?>" value="0" <?php echo (get_option($opt_jfbp_xprofile_map)==0?"checked='checked'":"")?> ><?php _e('Disable Mapping', 'wp-fb-autoconnect')?>
            <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_xprofile_map; ?>" value="1" <?php echo (get_option($opt_jfbp_xprofile_map)==1?"checked='checked'":"")?> ><?php _e('Map New Users Only', 'wp-fb-autoconnect')?>
            <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_xprofile_map; ?>" value="2" <?php echo (get_option($opt_jfbp_xprofile_map)==2?"checked='checked'":"")?> ><?php _e('Map New And Returning Users', 'wp-fb-autoconnect')?><br /><?php
            
            //Make a list of which Facebook fields may be mapped to each type of xProfile field.  Omitted types (i.e. checkbox) are treated as "unmappable."
            //The format is "xprofile_field_type"->"(fbfieldname1, fbfieldDisplayname1), (fbfieldname2, fbfieldDisplayname2), ..."
            //(Available FB fields are documented at: https://developers.facebook.com/docs/reference/api/user/)
            $allowed_mappings = array(
                'textbox' =>array('id'=>"ID", 'name'=>"Name", 'first_name'=>"First Name", 'middle_name'=>"Middle Name", 'last_name'=>"Last Name",
                                  'gender'=>"Gender", 'link'=>"Profile URL", "website"=>"Website*", 'bio'=>"Bio*", 
                                  'political'=>"Political*", "religion"=>"Religion*", 'relationship_status'=>"Relationship*", "location"=>"City*",
                                  'hometown'=>"Hometown*", 'languages'=>"Languages*", 'music'=>'Music*'),
                'textarea'=>array('id'=>"ID", 'name'=>"Name", 'first_name'=>"First Name", 'middle_name'=>"Middle Name", 'last_name'=>"Last Name", 
                                  'gender'=>"Gender", 'link'=>"Profile URL", "website"=>"Website*", 'bio'=>"Bio*",
                                  'political'=>"Political*", "religion"=>"Religion*", 'relationship_status'=>"Relationship*", "location"=>"City*", 
                                  'hometown'=>"Hometown*", 'languages'=>"Languages*", 'music'=>'Music*'),
                'datebox' =>array('birthday'=>'Birthday*'));
            $allowed_mappings = apply_filters('wpfb_xprofile_allowed_mappings', $allowed_mappings);

            //Go through all of the XProfile fields and offer possible Facebook mappings for each (in a dropdown).
            //(current_mappings is used to set the initial state of the panel, i.e. based on what mappings are already in the db)
            $current_mappings = get_option($opt_jfbp_xprofile_mappings);
            while ( bp_profile_groups() )
            {
                //Create a "box" for each XProfile Group
                global $group;
                bp_the_profile_group();
                ?><div style="width:520px; padding:5px; margin:2px 0; background-color:#EEEDDA; border:1px solid #CCC;"><?php
                echo "Group \"$group->name\":<br />";
                
                //And populate the group box with Textarea(xprofile field)->Dropdown(possible facebook mappings)
                while ( bp_profile_fields() )
                {
                    //Output the X-Profile field textarea
                    global $field;
                    bp_the_profile_field();
                    ?><input disabled='disabled' type="text" size="20" name="<?php echo $field->name ?>" value="<?php echo $field->name; ?>" /> -&gt;
                    
                    <?php 
                    //If there aren't any available Facebook mappings, just put a disabled textbox and "hidden" field that sets this option as '0' 
                    if( !isset($allowed_mappings[$field->type]) || !$allowed_mappings[$field->type] )
                    {
                        echo "<input disabled='disabled' type='text' size='30' name='$field->name"."_unavail"."' value='(".__("No Mappings Available", 'wp-fb-autoconnect').")' />";
                        echo "<input type='hidden' name='$field->id' value='0' />";
                        continue;
                    }
                    
                    //Otherwise, list all of the available mappings in a dropdown.
                    ?><select name="<?php echo $jfb_xprofile_field_prefix . $field->id?>">
                        <option value="0">(<?php _e('No Mapping', 'wp-fb-autoconnect')?>)</option><?php
                        foreach($allowed_mappings[$field->type] as $fbname => $userfriendlyname)
                            echo "<option " . ($current_mappings[$field->id]==$fbname?"selected":"") . " value=\"$fbname\">$userfriendlyname</option>";
                    ?></select><br /><?php
                }
                ?></div><?php
            }
        }?>
                                        
        <input type="hidden" name="prem_opts_updated" value="1" />
        <div class="submit"><input <?php disableatt() ?> type="submit" name="Submit" value="<?php _e('Save Premium', 'wp-fb-autoconnect')?>" /></div>
    </form>
    <?php
}


?>