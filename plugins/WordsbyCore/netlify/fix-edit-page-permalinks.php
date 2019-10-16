<?php
    add_filter('get_sample_permalink_html', 'perm', '',4);

    function perm($return, $id, $new_title, $new_slug){
        if (get_post_status( $id ) !== 'publish') return '';
        if (get_post_type($id) === 'psychic_window') return $return;
        if (get_post_type($id) === 'schema_builder') return "";

        $mydomain = get_field('build_site_url', 'option');
        $mydomain = $mydomain ? $mydomain : "http://localhost:8000";
        
        // if $mydomain ends in a slash, remove it
        if(substr($mydomain, -1) == '/') {
            $mydomain = substr($mydomain, 0, -1);
        }

        $currentsiteurl = get_site_url();

        $newurl = preg_replace("($currentsiteurl)", $mydomain, $return);

        return $newurl;
    }
?>