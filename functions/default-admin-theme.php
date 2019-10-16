<?php
function set_default_admin_color($user_id) {
    $args = array(
        'ID' => $user_id,
        'admin_color' => 'midnight'
    );
    wp_update_user( $args );
}
add_action('user_register', 'set_default_admin_color');
?>