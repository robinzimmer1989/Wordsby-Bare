<?php // Silencio 

$schema_builder_posts = get_posts(array(
    'posts_per_page'   => 1,
    'post_type'        => 'schema_builder',
));

$post_id = $schema_builder_posts[0]->ID;

// $acf = get_fields($post_id, false);




// https://www.grzegorowski.com/how-to-get-list-of-all-acf-fields 
$options = array();

$field_groups = acf_get_field_groups();
foreach ( $field_groups as $group ) {
  $fields = get_posts(array(
    'posts_per_page'   => -1,
    'post_type'        => 'acf-field',
    'orderby'          => 'menu_order',
    'order'            => 'ASC',
    'suppress_filters' => true, // DO NOT allow WPML to modify the query
    'post_parent'      => $group['ID'],
    'post_status'      => 'any',
    'update_post_meta_cache' => false
  ));
  foreach ( $fields as $field ) {
    $options[$field->post_name] = $field->post_title;
    
  }
}

// var_dump( $options);

?>