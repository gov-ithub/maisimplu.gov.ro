<?php


/**
  * Sidebar LoginLogout widget with Facebook Connect button
  **/
class Widget_LoginLogout extends WP_Widget
{
    //////////////////////////////////////////////////////
    //Init the Widget
    public function __construct()
    { 
        parent::__construct( false, "WP-FB AutoConnect Basic", array( 'description' => __('A Login/Logout widget with Facebook Connect button', 'wp-fb-autoconnect') ) );
    }
     
    //////////////////////////////////////////////////////
    //Output the widget's content.
    function widget( $args, $instance )
    {
        //Get args and output the title
        extract( $args );
        echo $before_widget;
        $title = apply_filters('widget_title', $instance['title']);
        if( $title ) echo $before_title . $title . $after_title;
        
        //If logged in, show "Welcome, User!"
        if( is_user_logged_in() ):
        ?>
            <div style='text-align:center'>
              <?php 
                $userdata = wp_get_current_user();
                _e('Welcome', 'wp-fb-autoconnect') . ', ' . $userdata->display_name;
              ?>!<br />
              <small>
                <a href="<?php echo get_option('siteurl')?>/wp-admin/profile.php"><?php _e("Edit Profile", 'wp-fb-autoconnect')?></a> | <a href=" <?php echo wp_logout_url( $_SERVER['REQUEST_URI'] )?>"><?php _e("Logout", 'wp-fb-autoconnect')?></a>
              </small>
            </div>
        <?php
        //Otherwise, show the login form (with Facebook Connect button)
        else:
        ?>
            <form name='loginform' id='loginform' action='<?php echo wp_login_url(); ?>' method='post'>
                <label><?php _e("User", 'wp-fb-autoconnect')?>:</label><br />
                <input type='text' name='log' id='user_login' class='input' tabindex='20' /><input type='submit' name='wp-submit' id='wp-submit' value='<?php _e("Login", 'wp-fb-autoconnect')?>' tabindex='23' /><br />
                <label><?php _e("Pass", 'wp-fb-autoconnect')?>:</label><br />
                <input type='password' name='pwd' id='user_pass' class='input' tabindex='21' />
                <span id="forgotText"><a href="<?php echo wp_lostpassword_url()?>" rel="nofollow" ><?php _e('Forgot', 'wp-fb-autoconnect')?>?</a></span><br />
                <?php //echo "<input name='rememberme' type='hidden' id='rememberme' value='forever' />";?>
                <?php echo wp_register('',''); ?>
                <input type='hidden' name='redirect_to' value='<?php echo htmlspecialchars($_SERVER['REQUEST_URI'])?>' />
            </form>
            <?php
            global $opt_jfb_hide_button;
            if( !get_option($opt_jfb_hide_button) )
            {
                jfb_output_facebook_btn();
                //jfb_output_facebook_init(); This is output in wp_footer as of 1.5.4
                //jfb_output_facebook_callback(); This is output in wp_footer as of 1.9.0
            }
        endif;
        echo $after_widget;
    }
    
    
    //////////////////////////////////////////////////////
    //Update the widget settings
    function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        return $instance;
    }

    ////////////////////////////////////////////////////
    //Display the widget settings on the widgets admin panel
    function form( $instance )
    {
        ?>
        <p>
            <b><?php _e('Title', 'wp-fb-autoconnect')?>:</b>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo isset($instance['title'])?$instance['title']:""; ?>" />
        </p>
        
        <?php
        //If the Premium addon isn't installed, show a teaser of the premium widget options.
        if(!defined('JFB_PREMIUM')):
        
        global $jfb_homepage;
        echo "<hr/><i><small>".
             __("The following options are available to Premium users only.", "wp-fb-autoconnect") .
             " ".
             __("For information about the WP-FB-AutoConnect Premium Add-On, including purchasing instructions, please visit the plugin homepage:","wp-fb-autoconnect") . 
             " <a target='preminfo' href=\"$jfb_homepage#premium\">here</a>." .
             "</small></i><br/><br/>";
        ?>
        <p>
            <b><?php _e('Labels', 'wp-fb-autoconnect'); ?>:</b><br />
            <input <?php $this->disableatt() ?> style="width:50%;" id="<?php echo $this->get_field_id('labelUserName'); ?>" name="<?php echo $this->get_field_name('labelUserName'); ?>" type="text" <?php $this->eValue($instance, 'labelUserName'); ?> /> <small><?php _e('User', 'wp-fb-autoconnect')?>:</small><br />
            <input <?php $this->disableatt() ?> style="width:50%;" id="<?php echo $this->get_field_id('labelPass'); ?>" name="<?php echo $this->get_field_name('labelPass'); ?>" type="text" <?php $this->eValue($instance, 'labelPass'); ?> /> <small><?php _e('Pass', 'wp-fb-autoconnect')?>:</small><br />
            <input <?php $this->disableatt() ?> style="width:50%;" id="<?php echo $this->get_field_id('labelBtn'); ?>" name="<?php echo $this->get_field_name('labelBtn'); ?>" type="text" <?php $this->eValue($instance, 'labelBtn'); ?> /> <small><?php _e('Login', 'wp-fb-autoconnect')?></small>
            <input <?php $this->disableatt() ?> style="width:50%;" id="<?php echo $this->get_field_id('labelRemember'); ?>" name="<?php echo $this->get_field_name('labelRemember'); ?>" type="text" <?php $this->eValue($instance, 'labelRemember'); ?> /> <small><?php _e('Remember', 'wp-fb-autoconnect')?></small>
            <input <?php $this->disableatt() ?> style="width:50%;" id="<?php echo $this->get_field_id('labelForgot'); ?>" name="<?php echo $this->get_field_name('labelForgot'); ?>" type="text" <?php $this->eValue($instance, 'labelForgot'); ?> /> <small><?php _e('Forgot', 'wp-fb-autoconnect')?>?</small>
            <input <?php $this->disableatt() ?> style="width:50%;" id="<?php echo $this->get_field_id('labelLogout'); ?>" name="<?php echo $this->get_field_name('labelLogout'); ?>" type="text" <?php $this->eValue($instance, 'labelLogout'); ?> /> <small><?php _e('Logout', 'wp-fb-autoconnect')?></small>
            <input <?php $this->disableatt() ?> style="width:50%;" id="<?php echo $this->get_field_id('labelProfile'); ?>" name="<?php echo $this->get_field_name('labelProfile'); ?>" type="text" <?php $this->eValue($instance, 'labelProfile'); ?> /> <small><?php _e('Edit Profile', 'wp-fb-autoconnect')?></small>
            <input <?php $this->disableatt() ?> style="width:50%;" id="<?php echo $this->get_field_id('labelWelcome'); ?>" name="<?php echo $this->get_field_name('labelWelcome'); ?>" type="text" <?php $this->eValue($instance, 'labelWelcome'); ?> /> <small><?php _e('Welcome', 'wp-fb-autoconnect')?>,</small>
        </p>
        <p>
            <b><?php _e('Other', 'wp-fb-autoconnect')?>:</b><br />
            <input <?php $this->disableatt() ?> class="checkbox" type="checkbox" <?php $this->eChecked( $instance, 'showwplogin'); ?> id="<?php echo $this->get_field_id( 'showwplogin' ); ?>" name="<?php echo $this->get_field_name( 'showwplogin' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'showwplogin' ); ?>"><?php _e('Show WP User/Pass Login', 'wp-fb-autoconnect')?></label><br />
            <input <?php $this->disableatt() ?> class="checkbox" type="checkbox" <?php $this->eChecked( $instance, 'showrememberme' ); ?> id="<?php echo $this->get_field_id( 'showrememberme' ); ?>" name="<?php echo $this->get_field_name( 'showrememberme' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'showrememberme' ); ?>"><?php _e("Show 'Remember'", 'wp-fb-autoconnect')?></label><br />
            <input <?php $this->disableatt() ?> class="checkbox" type="checkbox" <?php $this->eChecked( $instance, 'showregister'); ?> id="<?php echo $this->get_field_id( 'showregister' ); ?>" name="<?php echo $this->get_field_name( 'showregister' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'showregister' ); ?>"><?php _e("Show 'Register'", 'wp-fb-autoconnect')?></label><br />
            <input <?php $this->disableatt() ?> class="checkbox" type="checkbox" <?php $this->eChecked( $instance, 'showforgot' ); ?> id="<?php echo $this->get_field_id( 'showforgot' ); ?>" name="<?php echo $this->get_field_name( 'showforgot' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'showforgot' ); ?>"><?php _e("Show 'Forgot?'", 'wp-fb-autoconnect')?></label><br />
            <input <?php $this->disableatt() ?> class="checkbox" type="checkbox" <?php $this->eChecked( $instance, 'showEditProfile' ); ?> id="<?php echo $this->get_field_id( 'showEditProfile' ); ?>" name="<?php echo $this->get_field_name( 'showEditProfile' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'showEditProfile' ); ?>"><?php _e("Show 'Edit Profile'", 'wp-fb-autoconnect')?></label><br />
            <input <?php $this->disableatt() ?> class="checkbox" type="checkbox" <?php $this->eChecked( $instance, 'logoutofFB' ); ?> id="<?php echo $this->get_field_id( 'logoutofFB' ); ?>" name="<?php echo $this->get_field_name( 'logoutofFB' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'logoutofFB' ); ?>"><?php echo __('Prompt') . ' \'' . __('Logout of Facebook too?', 'wp-fb-autoconnect') . "'";?></label><br />
            <input <?php $this->disableatt() ?> class="checkbox" type="checkbox" <?php $this->eChecked( $instance, 'bpProfileLink' ); ?> id="<?php echo $this->get_field_id( 'bpProfileLink' ); ?>" name="<?php echo $this->get_field_name( 'bpProfileLink' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'bpProfileLink' ); ?>"><?php _e("Edit profile links to BP (if available)", 'wp-fb-autoconnect')?></label><br />
            <input <?php $this->disableatt() ?> class="checkbox" type="checkbox" <?php $this->eChecked( $instance, 'showavatar' ); ?> id="<?php echo $this->get_field_id( 'showavatar' ); ?>" name="<?php echo $this->get_field_name( 'showavatar' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'showavatar' ); ?>"><?php _e("Show Avatar (when logged in)", 'wp-fb-autoconnect')?></label><br />
            <?php _e('Avatar Size', 'wp-fb-autoconnect')?>: <input <?php $this->disableatt() ?> style="width:35px" id="<?php echo $this->get_field_id('avatarsize'); ?>" name="<?php echo $this->get_field_name('avatarsize'); ?>" type="text" <?php $this->eValue($instance, 'avatarsize'); ?> />px<br/>
            <?php _e('Forgot Pass URL', 'wp-fb-autoconnect')?>:<br/>
            <input <?php $this->disableatt() ?> style="width:100%" id="<?php echo $this->get_field_id('forgotURL'); ?>" name="<?php echo $this->get_field_name('forgotURL'); ?>" type="text" <?php $this->eValue($instance, 'forgotURL'); ?> />
        </p>
        <?php
        endif; //Premium teaser
    }
    
    /*
     * Helpers for outputting a 'teaser' premium widget in the free plugin.
     */
    function eValue($instance, $index) { echo "value=\"" . (isset($instance[$index])?$instance[$index]:'') . "\" "; }
    function eChecked($instance, $index) { isset($instance[$index])?checked( $instance[$index], true ):checked(false, true);}
    function disableatt() { echo (get_class($this) == "Widget_AutoConnect_Premium"?"":"disabled='disabled'"); }
}


//Register the widget
add_action( 'widgets_init', 'register_jfbLogin' );
function register_jfbLogin() { register_widget( 'Widget_LoginLogout' ); }

?>