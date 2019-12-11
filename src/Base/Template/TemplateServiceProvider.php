<?php
/**
 * Provider which handles the redirection of the homepage.
 */

namespace OWC\PDC\Base\Template;

use OWC\PDC\Base\Foundation\ServiceProvider;

/**
 * Provider which handles the redirection of the homepage.
 */
class TemplateServiceProvider extends ServiceProvider
{

    /**
     * Register hooks
     *
     * @return void
     */
    public function register()
    {
        $this->plugin->loader->addAction('template_redirect', $this, 'redirectAllButAdmin', 10);
    }

    /**
     * Handle the redirection if the homepage is reached.
     *
     * @return void
     */
    public function redirectAllButAdmin()
    {
        if ((is_admin() || wp_doing_ajax() || is_feed() || defined('WP_DEBUG'))) {
            return;
        }
        if (wp_redirect('https://www.openwebconcept.nl/')) {
            exit();
        }
    }
}
