<?php
if (!defined('ABSPATH'))
    exit;

// -> START Basic Fields
Redux::setSection($opt_name, array(
	'title' => esc_html__('Zoom API Setting', 'dwt-listing'),
	'id' => 'sb-zoom-settings',
	'desc' => '',
	'icon' => 'el el-cogs',
	'fields' => array(
		array(
			'id' => 'dwt_zoom_meeting_btn',
			'type' => 'switch',
			'title' => esc_html__('Zoom Meetings', 'dwt-listing'),
			'desc' => esc_html__('On/Off Zoom Meetings', 'dwt-listing'),
			'default' => false,
		),
		array(
			'id' => 'dwt_zoom_keys_link',
			'type' => 'text',
			'title' => esc_html__('Zoom Keys Link', 'dwt-listing'),
			'subtitle' => esc_html__('Zoom App Market Link', 'dwt-listing'),
			'desc' => esc_html__('Keys Creation Link', 'dwt-listing'),
			'default' => '#',
		),
		array(
			'id' => 'dwt_terms_condition_page',
			'type' => 'text',
			'title' => esc_html__('Terms and Conditions Page Link', 'dwt-listing'),
			'desc' => esc_html__('Terms and Conditions Page Link', 'dwt-listing'),
			'default' => '#',
		),
	)
));