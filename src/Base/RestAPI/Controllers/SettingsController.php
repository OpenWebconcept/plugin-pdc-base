<?php

/**
 * Controller which handles the (requested) settings.
 */

namespace OWC\PDC\Base\RestAPI\Controllers;

use WP_REST_Request;
use OWC\PDC\Base\Settings\SettingsPageOptions;

/**
 * Controller which handles the settings.
 */
class SettingsController extends BaseController
{
	/**
	 * Get the settings.
	 */
	public function getSettings(WP_REST_Request $request): array
	{
		$settingsPageOptions = SettingsPageOptions::make();

		$settings = [
			'portal_url' => $settingsPageOptions->getPortalURL(),
			'item_slug' => $settingsPageOptions->getPortalItemSlug(),
			'theme_in_portal_url' => $settingsPageOptions->themeInPortalURL(),
			'subtheme_in_portal_url' => $settingsPageOptions->subthemeInPortalURL(),
			'id_in_portal_url' => $settingsPageOptions->idInPortalURL(),
		];

		return $settings;
	}
}
