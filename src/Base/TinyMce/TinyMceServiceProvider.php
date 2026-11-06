<?php

namespace OWC\PDC\Base\TinyMce;

use OWC\PDC\Base\Foundation\ServiceProvider;

class TinyMceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
		$this->plugin->loader->addFilter('tiny_mce_before_init', $this, 'filterIframeAttribs', 10, 2);
        $this->plugin->loader->addAction('admin_enqueue_scripts', $this, 'enqueueSelectionGuard');
    }

    public function enqueueSelectionGuard(string $hook): void
    {
        if (! in_array($hook, ['post.php', 'post-new.php'], true)) {
            return;
        }

        // Firefox throws in core's caret restore when a Visual/Code switch happens in an editor without
        // layout, which Meta Box clone templates and collapsed groups produce. See the script.
        wp_enqueue_script('owc-pdc-editor-selection-guard', $this->plugin->getPluginUrl() . '/js/editor-selection-guard.js', [], false, true);
    }

	public function filterIframeAttribs(array $options): array
	{
		// The TinyMCE HTML editor features an attribute whitelist, which may remove certain attributes. Specifically,
		// the referrerpolicy attributes of iframes are removed, which breaks YouTube embeds. We add it here.
		$options['extended_valid_elements'] = 'iframe[allowfullscreen|csp|height|loading|name|referrerpolicy|src|width]';
		return $options;
	}
}
