<?php

namespace OWC_PDC_Base\Core\Template;

use OWC_PDC_Base\Core\Plugin\ServiceProvider;

class TemplateServiceProvider extends ServiceProvider
{

	public function register()
	{
		$this->plugin->loader->addAction('template_redirect', $this, 'redirectAllButAdmin', 10);
	}

	public function redirectAllButAdmin()
	{
		if ( ! ( is_admin() || wp_doing_ajax() || is_feed() ) ) {

			wp_redirect('https://www.openwebconcept.nl/');
			die;
		}
	}
}