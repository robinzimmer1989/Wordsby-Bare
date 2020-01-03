<?php 
$develop_preview = 
	defined('DANGEROUS__WORDSBY_PUBLIC_PREVIEWS') && DANGEROUS__WORDSBY_PUBLIC_PREVIEWS 
		? DANGEROUS__WORDSBY_PUBLIC_PREVIEWS : false;

global $pagenow;
if ( 'post.php' == $pagenow || 'post-new.php' == $pagenow ) {
    add_action( 'admin_head', 'wpse_125800_custom_publish_box' );
    function wpse_125800_custom_publish_box() {
		if (!is_admin()) return;
		
		if(function_exists('get_field')){
			if (get_field('build_site_url', 'option')) return;

			$style = '';
			$style .= '<style type="text/css">';
			$style .= '#edit-slug-box, #minor-publishing-actions';
			$style .= '{display: none; }';
			$style .= '</style>';

			echo $style;
		}
    }
}

function wordsby_get_template($id){

	$post_type = get_post_type($id);

	if($post_type == 'page'){

		if(function_exists('get_field') && get_field('is_archive', $id)){
			$archive_post_type = get_field('post_type', $id);
			return "archive/$archive_post_type";
		}

		$template = get_post_meta($id, "_wp_page_template", true);

		if($template == 'default'){
			return 'index';
		}

		return $template;
	}

	return "single/$post_type";

}

function custom_preview_page_link($link) {
	global $develop_preview;

	if(function_exists('get_field')){
		$id = get_the_ID();
		$user_id = get_current_user_id();
		$nonce = get_field('preview_key', 'options');

		$available_templates = get_option('templates-collections');
		if (!$available_templates) return false;
		
		$post_type = get_post_type($id);
		$obj = get_post_type_object($post_type);

		$rest_base = !empty($obj->rest_base) ? $obj->rest_base : $obj->name;

		$template = wordsby_get_template($id);

		if(!$template){
			$template = 'index';
		}

		if ($develop_preview) {
			$link = "http://localhost:8000/preview/$template/?rest_base=$rest_base&preview=$id&nonce=$nonce&userId=$user_id&localhost=true";
		} else {
			$link = get_home_url() . "/preview/?available_template=" . urlencode($template) . "&rest_base=$rest_base&preview=$id&id=$id&nonce=$nonce&userId=$user_id";
		}
	}

	return $link;
}

add_filter('preview_post_link', 'custom_preview_page_link');
?>