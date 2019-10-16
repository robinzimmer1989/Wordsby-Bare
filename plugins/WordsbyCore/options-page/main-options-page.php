<?php
// disable the git pull webhook field
function disable_acf_load_field( $field ) {
	$field['disabled'] = 1;
	$field['default_value'] = get_stylesheet_directory_uri() . "/webhooks/git_pull.php";
	return $field;
}

add_filter('acf/load_field/name=git_pull_webhook', 'disable_acf_load_field');

if( function_exists('acf_add_options_page') ) {

	$gatsby_icon_url = get_stylesheet_directory_uri() . "/plugins/WordsbyCore/options-page/icons/gatsby.svg";

	acf_add_options_page([
		'page_title' => 'Gatsby',
		'icon_url' => $gatsby_icon_url
    ]);
	
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5bbd6668c1ee0',
	'title' => 'Settings',
	'fields' => array(
		array(
			'key' => 'field_5bbda2ed92b36',
			'label' => 'Gatsby',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'left',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5bbda59d91140',
			'label' => 'Frontend Site URL',
			'name' => 'build_site_url',
			'instructions' => 'This url is used to link to the permalink of your front end site from your backend edit page.',
			'type' => 'url',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'http://localhost:8000',
			'placeholder' => '',
        ),
		array(
			'key' => 'field_5bbdb59d91140',
			'label' => 'Build Webhook',
			'name' => 'build_webhook',
			'instructions' => 'This url is the webhook to trigger a build in Netlify.',
			'type' => 'url',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
		array(
			'key' => 'field_5bbdb69d91140',
			'label' => 'Deploy Status',
			'name' => 'netlify_deploy_status',
			'instructions' => 'Add the deploy status url here',
			'type' => 'url',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
		array(
			'key' => 'field_5bbda2ed92b361',
			'label' => 'ACF Options',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'left',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5bbd666ed62e41',
			'label' => 'Google Maps API Key',
			'name' => 'google_maps_api_key',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-gatsby',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;
?>