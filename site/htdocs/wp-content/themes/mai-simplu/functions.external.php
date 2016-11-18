<?php
 //function to print publish button
function show_publish_button(){
Global $post;
//only print fi admin
if (current_user_can('manage_options')){
echo '

<form action="" method="POST" name="front_end_publish"><input id="pid" type="hidden" name="pid" value="'.$post->ID.'" />
<input id="FE_PUBLISH" type="hidden" name="FE_PUBLISH" value="FE_PUBLISH" />
<input id="submit" type="submit" name="submit" value="Publica pe site!" /></form>';


}
}

//function to update post status
function change_post_status($post_id,$status){
$current_post = get_post( $post_id, 'ARRAY_A' );
$current_post['post_status'] = $status;
wp_update_post($current_post);
}

if (isset($_POST['FE_PUBLISH']) && $_POST['FE_PUBLISH'] == 'FE_PUBLISH'){
if (isset($_POST['pid']) && !empty($_POST['pid'])){
change_post_status((int)$_POST['pid'],'publish');
}
}
 
 
function show_trash_button(){
Global $post;
//only print fi admin
if (current_user_can('manage_options')){
echo '<form action="" method="POST" name="front_end_trash"><input id="pid" type="hidden" name="pid" value="'.$post->ID.'" />
<input id="FE_trash" type="hidden" name="FE_trash" value="FE_trash" />
<input id="submit" type="submit" name="submit" value="Sterge de pe site!" /></form>';

}
}

//function to update post status
function change_post_status1($post_id,$status){
$current_post = get_post( $post_id, 'ARRAY_A' );
$current_post['post_status'] = $status;
wp_update_post($current_post);
}

if (isset($_POST['FE_trash']) && $_POST['FE_trash'] == 'FE_trash'){
if (isset($_POST['pid']) && !empty($_POST['pid'])){
change_post_status1((int)$_POST['pid'],'trash');
}
}
 
 
 add_action( 'init', 'blockusers_init' );
function blockusers_init() {
if ( is_admin() && ! current_user_can( 'administrator' ) &&
! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
wp_redirect( home_url() );
exit;
}
}
 
 
 
 
 
 
 function my_login_logo_one() { 
?> 
<style type="text/css"> 
body.login div#login h1 a {
 background-image: url(/wp-content/uploads/2016/02/300x300.jpg);  //Add your own logo image in this url 
padding-bottom: 30px; 

} 
</style>
 <?php 
} add_action( 'login_enqueue_scripts', 'my_login_logo_one' );





/* redirect users to front page after login */
//function redirect_home( $redirect_to, $request, $user )
//{
//    return home_url();
//}
//add_filter( 'login_redirect', 'redirect_home' );


add_filter('wp_mail_from', 'new_mail_from');
add_filter('wp_mail_from_name', 'new_mail_from_name');
 
function new_mail_from($old) {
 return 'donotreply@maisimplu.gov.ro';
}
function new_mail_from_name($old) {
 return 'MaiSimplu.Gov.Ro';
}
