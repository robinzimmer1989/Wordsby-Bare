<?php

add_action( 'rest_api_init', 'getPreviewData' );
function getPreviewData() {
    register_rest_route(
        'wp/v2',
        '/previewData',
        array(
              'methods' => 'GET',
              'callback' => 'getPreviewData_callback',
  ));
}
    
function getPreviewData_callback( $data ) {

    $post_id = $data->get_param('preview');
    $user_id = $data->get_param('userId');

    if( $post_id && isUserAuthorized($data)) :

        $post = array_shift(wp_get_post_revisions($post_id));
        $result = posts_formatted_for_gatsby($post_id, true)[0];
    
        return $result;
    endif;
}

?>