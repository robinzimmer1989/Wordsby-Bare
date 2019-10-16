<?php 
function get_menu_link_path($item, $submenu = "") {
    $menu_hookname = get_plugin_page_hookname( $item[2], 'admin.php' );
    $menu_file = $item[2];            

    if (! empty( $menu_hookname ) && 'index.php' != $menu_file && ! strpos($menu_file, '.php')) {
        $admin_is_parent = true;
        return "admin.php?page={$item[2]}";
    } else {
        return $item[2];
    }
}

function remove_non_menu_items($value) {
    return strpos($value[2], 'separator') === false;
}

function check_diff_multi($array1, $array2){
    $result = array();
    foreach($array1 as $key => $val) {
         if(isset($array2[$key])){
           if(is_array($val) && $array2[$key]){
               $result[$key] = check_diff_multi($val, $array2[$key]);
           }
       } else {
           $result[$key] = $val;
       }
    }
    return $result;
}

$collections_blacklist = array('Psychic Window', 'Schema Builder', 'preview');

function get_collections_menu_items($menu_item) {
    global $wp_post_types, $collections_blacklist;

    if (in_array($menu_item[0], $collections_blacklist)) return false;

    foreach($wp_post_types as $post_type) {
        if($post_type->label === $menu_item[0]) return true;
    }
    return false;
}

function find_submenu_items($item) {
    global $submenu;
    if ( ! empty( $submenu[$item[2]] ) ) {
        return $submenu[$item[2]];
    }   else {
        return false;
    }
}

function create_section_submenu($item) {       
    $submenu_items = find_submenu_items($item); ?>
<a href="<?php echo get_menu_link_path($item); ?>">
    <?php echo $item[0]; ?>
</a>

<?php if(is_array($submenu_items)): ?>
<ul class="wp-subsubmenu">
    <?php foreach($submenu_items as $item): ?>
    <li>
        <a href="<?php echo get_menu_link_path($item, true); ?>">
            <?php echo $item[0]; ?>
        </a>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif; 
}

function create_section_menu($section_menu) { ?>
<ul class="wp-submenu wp-submenu-wrap">
    <?php foreach($section_menu as $item): ?>
    <li><?php create_section_submenu($item); ?></li>
    <?php endforeach; ?>
</ul>
<?php }

function find_menu_item($menu, $string){
    foreach($menu as $item){
        if($item[0] == $string){
            return $item;
        }
    }
    return false;
}

function remove_from_menu($menu, $string){
    foreach($menu as $key=>$value){
        if($value[0] == $string){
            unset($menu[$key]);
            return $menu;
        }
    }
    return $menu;
}

add_action('adminmenu', 'my_admin_footer_function');
function my_admin_footer_function() {
    global $menu, $submenu, $self, $parent_file;

    $menu = array_filter($menu, 'remove_non_menu_items');

    $users = find_menu_item($menu, 'Users');
    $collections = array_filter($menu, 'get_collections_menu_items');
    array_push($collections, $users);

    $menu = array_filter(check_diff_multi($menu, $collections));
    $menu = remove_from_menu($menu, 'Dashboard');
    $menu = remove_from_menu($menu, 'Users');

    $final_menu = array('Collections' => $collections, 'Development' => $menu);
?>

<li class="menu-top not-hidden">
    <a href="<?php echo site_url('/wp-admin/admin.php?page=wordsby'); ?>" class="menu-top" aria-haspopup="false">
        <div class="wp-menu-arrow">
            <div></div>
        </div>
        <div class="wp-menu-image dashicons-before dashicons-admin-home"><br></div>
        <div class="wp-menu-name">Dashboard</div>
    </a>
</li>

<?php foreach($final_menu as $section_title => $section_menu): 
    
    if($section_title == 'Collections'){
        $icon = 'screenoptions';
    }else{
        $icon = 'admin-generic';
    }

    ?>
<?php $is_active = false; ?>

<li class="wp-has-submenu menu-top not-hidden
    <?php if ($is_active){echo "wp-has-current-submenu wp-menu-open";}else{echo "wp-not-current-submenu";} ?>">

    <a class="wp-has-submenu menu-top <?php if ($is_active){echo "wp-has-current-submenu wp-menu-open";}else{echo "wp-not-current-submenu";} ?>"
        aria-haspopup="false">
        <div class="wp-menu-arrow">
            <div></div>
        </div>
        <div class="wp-menu-image dashicons-before dashicons-<?php echo $icon; ?>">
            <br></div>
        <div class="wp-menu-name"><?php echo $section_title; ?></div>
    </a>

    <?php create_section_menu($section_menu); ?>

</li>
<?php endforeach; ?>

<div class="wp-menu-bare-branding">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/bare.png" />
</div>

<?php
} 


add_action( 'admin_bar_menu', 'make_parent_node', 0 );

function make_parent_node( $wp_admin_bar ) {

    if(get_field('netlify_deploy_status', 'option')){
        $badge = '<img src="' . get_field('netlify_deploy_status', 'option') . '" />';
    }else{
        $badge = '';
    }

    $args = array(
        'id'     => 'build-status',
        'title' => $badge,
        'parent' => false,
	);
    $wp_admin_bar->add_node( $args );
    
	$args = array(
        'id'     => 'trigger-build',
        'title' => '<div class="build_webhook" data-value="' . get_field('build_webhook', 'option') . '">Trigger build</div>',
        'parent' => false,
	);
    $wp_admin_bar->add_node( $args );
}


?>