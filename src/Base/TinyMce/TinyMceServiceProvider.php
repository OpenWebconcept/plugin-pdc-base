<?php

namespace OWC\PDC\Base\TinyMce;

use OWC\PDC\Base\Foundation\ServiceProvider;

class TinyMceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
		$this->plugin->loader->addFilter('tiny_mce_before_init', $this, 'filterIframeAttribs', 10, 2);
    }

	public function filterIframeAttribs(array $options): array
	{
		// The TinyMCE HTML editor features an attribute whitelist, which may remove certain attributes. Specifically,
		// the referrerpolicy attributes of iframes are removed, which breaks YouTube embeds. We add it here.
		$options['extended_valid_elements'] = 'iframe[allowfullscreen|csp|height|loading|name|referrerpolicy|src|width]';
		return $options;
	}
}
