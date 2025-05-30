<?php

namespace OWC\PDC\Base\Models;

use WP_Term;
use OWC\PDC\Base\Settings\SettingsPageOptions;

class PortalLinkGenerator
{
    protected Item $post;
    protected SettingsPageOptions $pdcSettings;
    protected string $portalURL = '';

    public function __construct(Item $post)
    {
        $this->post = $post;
        $this->pdcSettings = SettingsPageOptions::make();
    }

    private function updatePortalURL(string $value = ''): void
    {
        if (empty($value)) {
            return;
        }

        $this->portalURL = sprintf('%s%s', $this->portalURL, trailingslashit($value));
    }

    public function generateFullPortalLink(): string
    {
        $this->createPortalSlug()->appendTheme()->appendSubTheme()->appendPostSlug()->appendPostID();

        return $this->portalURL;
    }

    public function generateBasePortalLink(): string
    {
        $this->createPortalSlug()->appendTheme()->appendSubTheme();

        return $this->portalURL;
    }

    private function createPortalSlug(): self
    {
        $portalURL = $this->pdcSettings->getPortalURL();

        if ($this->pdcSettings->useShowOn()) {
            $portalURL = $this->getShowOnPortalURL();
        }

        $portalSlug = $this->pdcSettings->getPortalItemSlug();

        $this->updatePortalURL($portalURL);
        $this->updatePortalURL($portalSlug);

        return $this;
    }

    /**
     * When the portal URL from the settings is not valid use the taxonomy 'pdc-show-on' as fallback.
     */
    private function getShowOnPortalURL(): string
    {
        $terms = wp_get_object_terms($this->post->getID(), 'pdc-show-on');

        if (! is_array($terms) || empty($terms)) {
            return '';
        }

        $portalURL = reset($terms);

        if (isset($_GET['source'])) {
            foreach ($terms as $term) {
                if ($term->slug === $_GET['source']) {
                    $portalURL = $term;

                    break;
                }
            }
        }
        $portalURL = $portalURL instanceof WP_Term ? $portalURL->name : '';

        return wp_http_validate_url($portalURL) ? $portalURL : '/';
    }

    private function appendTheme(): self
    {
        if (! $this->pdcSettings->themeInPortalURL()) {
            return $this;
        }

        $theme = $this->post->getConnected('pdc-item_to_pdc-category');

        if (! $theme instanceof \WP_Post) {
            $this->updatePortalURL('thema');

            return $this;
        }

        $this->updatePortalURL($theme->post_name);

        return $this;
    }

    private function appendSubTheme(): self
    {
        if (! $this->pdcSettings->subthemeInPortalURL()) {
            return $this;
        }

        $subtheme = $this->post->getConnected('pdc-item_to_pdc-subcategory') ?? '';

        if (! $subtheme instanceof \WP_Post) {
            $this->updatePortalURL('subthema');

            return $this;
        }

        $this->updatePortalURL($subtheme->post_name);

        return $this;
    }

    private function appendPostSlug(): self
    {
        if (! empty($this->post->getPostName())) {
            $this->updatePortalURL($this->post->getPostName());

            return $this;
        }

        // Drafts do not have a post_name so use the sanitized title instead.
        $this->updatePortalURL(sanitize_title($this->post->getTitle(), 'untitled-draft'));

        return $this;
    }

    private function appendPostID(): self
    {
        if (! $this->pdcSettings->idInPortalURL()) {
            return $this;
        }

        $this->updatePortalURL($this->post->getID());

        return $this;
    }

    public static function make(Item $post): self
    {
        return new static($post);
    }
}
