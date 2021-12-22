<?php
/*
Plugin Name:       Post to Qrcode
Plugin URI:        https://diptonath.com/
Description:       Post Qrcode Plugin
Version:           1.0.0
Author:            Dipto Nath
Author URI:        https://diptonath.com/
License:           GPL v2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
Update URI:        
Text Domain:       post-to-qrcode
Domain Path:       
 */

 
// function wordcount_activation_hook(){}
// register_activation_hook(__FILE__, "wordcount_activation_hook");

// function wordcount_deactivation_hook(){}
// register_activation_hook(__FILE__, "wordcount_deactivation_hook");


function post_to_qrcode_load_textdomain(){
    load_plugin_textdomain('post-to-qrcode',false,dirname(__FILE__)."/languages");
}
add_action("plugins_loaded", "post_to_qrcode_load_textdomain");

function pqrc_display_qr_code($content){
    $current_post_id = get_the_ID();
    $current_post_title = get_the_title($current_post_id);
    $current_post_url = urldecode((get_the_permalink()));
    $current_post_type = get_post_type($current_post_id);
    
    //Post Type Check
    $excluded_post_types = apply_filters('pqrc_exclude_post_type',array("page"));
    if(in_array($current_post_type,$excluded_post_types)){
        return $content;
    }
    //Dimension Hook
    $dimension = apply_filters('pqrc_qrcode_dimension',"150x150");

    $image_src = sprintf('https://api.qrserver.com/v1/create-qr-code/?size=%s&data=%s',$dimension, $current_post_id);
    $content .= sprintf("<div class='qrcode'><img src='%s' alt='%s'/></div>",$image_src,$current_post_title);
    return $content;
}
add_filter('the_content','pqrc_display_qr_code');





