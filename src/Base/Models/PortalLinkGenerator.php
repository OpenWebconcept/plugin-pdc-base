<?php

namespace OWC\PDC\Base\Models;

use OWC\PDC\Base\Settings\SettingsPageOptions;
use WP_Post;
use WP_Term;

class PortalLinkGenerator
{
    protected Item $post;
    protected SettingsPageOptions $pdcSettings;
    protected string $portalURL = '';

	protected ?WP_Post $theme = null;
	protected ?WP_Post $subtheme = null;

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

        $this->theme = $this->post->getConnected('pdc-item_to_pdc-category');
		$this->updatePortalURL($this->theme instanceof WP_Post ? $this->theme->post_name : 'thema');

        return $this;
    }

    private function appendSubTheme(): self
    {
        if (! $this->pdcSettings->subthemeInPortalURL()) {
            return $this;
        }

        if (! $this->theme instanceof WP_Post) {
            $this->updatePortalURL('subthema');

            return $this;
        }

        $this->subtheme = $this->getCommonConnectedSubtheme($this->theme);
		$this->updatePortalURL($this->subtheme instanceof WP_Post ? $this->subtheme->post_name : 'subthema');

        return $this;
    }

    /**
     * Get the first common connected subtheme between the pdc-item and the theme.
     */
    private function getCommonConnectedSubtheme(WP_Post $theme): ?WP_Post
    {
        $connectedArgs = ['fields' => 'ids'];

        $themeConnectedSubthemes = Item::makeFrom($theme)
                                    ->getConnectedAll('pdc-category_to_pdc-subcategory', $connectedArgs);

        $postConnectedSubthemes = $this->post
                                    ->getConnectedAll('pdc-item_to_pdc-subcategory', $connectedArgs);

        if (count($themeConnectedSubthemes) < 1 || count($postConnectedSubthemes) < 1) {
            return null;
        }

        $commonSubthemeIds = array_intersect($postConnectedSubthemes, $themeConnectedSubthemes);

        $firstSubthemeId = reset($commonSubthemeIds);
        $connectedSubtheme = $firstSubthemeId ? get_post($firstSubthemeId) : null;

        return $connectedSubtheme instanceof WP_Post ? $connectedSubtheme : null;
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
