<?php 
require_once dirname( __FILE__ ) . "/better-admin-menu.php";
require_once dirname( __FILE__ ) . "/better-dashboard.php";

add_action( 'admin_enqueue_scripts', 'addAdminMenuScripts' );
function addAdminMenuScripts() {   
    wp_register_script( 'menu', get_stylesheet_directory_uri() . "/plugins/BetterAdmin/assets/js/betteradmin-menu.js", array('jquery') );
    wp_enqueue_script( 'menu' );

    // wp_enqueue_style( 'betteradmin-theme', get_stylesheet_directory_uri() . "/plugins/BetterAdmin/assets/css/theme.css" );
    wp_enqueue_style( 'betteradmin-style', get_stylesheet_directory_uri() . "/plugins/BetterAdmin/assets/css/style.css" );
}
?>