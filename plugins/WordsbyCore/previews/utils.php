<?php

function save_temporary_preview_key() {
    $user_id = get_current_user_id();
    update_user_meta($user_id, 'temporary_preview_key', generateRandomString(20));
}
add_action('admin_init', 'save_temporary_preview_key');

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function isUserAuthorized($data){
    $preview_token = $data->get_param('nonce');
    $user_id = $data->get_param('userId');

    if($preview_token && $user_id){
        $preview_key = get_field('preview_key', 'options');

        if($preview_key == $preview_token){
            return true;
        }
    }

    return null;
}


function preview_remove_urls(&$item, $key) {
    $item = preview_replace_urls_with_pathnames($item);
}

function preview_replace_urls_with_pathnames($input) {
    if (is_string($input)) {
        $url = preg_quote(get_site_url(), "/");
        $match = "/$url(?!\/wp-content\/|\/wp-admin\/|\/wp-includes\/)/";
        return preg_replace($match, '', $input);
    } else {
        return $input;
    }
}


?>