<?php

return [

	'base' => [

		'id'            => '_owc_pdc_base_settings',
		'option_name'   => '_owc_pdc_base_settings',
		'menu_title'    => __('PDC instellingen', 'pdc-base'),
		'icon_url'      => 'dashicons-admin-settings',
		'submenu_title' => _x('Basis', 'PDC instellingen subpagina', 'pdc-base'),
		'position'      => 9,
		'columns'       => 1,
		'submit_button' => _x('Opslaan', 'PDC instellingen subpagina', 'pdc-base'),
		'tabs'          => array(
			'base'        => _x('Algemeen', 'PDC instellingen tab', 'pdc-base')
		)
	]
];