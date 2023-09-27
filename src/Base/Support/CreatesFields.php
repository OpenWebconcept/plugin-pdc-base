<?php

namespace OWC\PDC\Base\Support;

use Closure;
use OWC\PDC\Base\Foundation\Plugin;
use WP_Post;

abstract class CreatesFields
{
    protected Plugin $plugin;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * The default condition is true, can be overriden.
     */
    protected function condition(): callable
    {
        return function () {
            return \__return_true();
        };
    }

    /**
     * Run the current condition.
     */
    public function executeCondition(): ?Closure
    {
        if ($this->condition() instanceof Closure) {
            return $this->condition();
        }

        if (\is_callable($this->condition())) {
            return $this->condition();
        }

        return null;
    }

    /**
     * Create an additional field on an array.
     *
     * @return mixed
     */
    abstract public function create(WP_Post $post);

    protected function getFileSize(string $url = ''): string
    {
        if (! defined('WP_CONTENT_DIR') || empty($url)) {
            return '';
        }

        if ($this->isExternalURL($url) && $filesize = $this->getExternalFileSize($url)) {
            return $filesize;
        }

        return $this->handleInternalFile($url);
    }

    protected function handleInternalFile(string $url): string
    {
        $projectRoot = str_replace('/wp-content', '', WP_CONTENT_DIR);
        $parsedUrl = wp_parse_url($url);

        if (empty($parsedUrl['path'])) {
            return '';
        }

        $file = $projectRoot . $parsedUrl['path'];

        return file_exists($file) ? filesize($file) : '';
    }

    /**
     * Compare domain of the provided URL and the current site URL.
     */
    protected function isExternalURL(string $url): bool
    {
        $metaParsedURL = wp_parse_url($url);
        $siteParsedURL = wp_parse_url(get_site_url());

        $metaParsedURLHost = $metaParsedURL['host'] ?? '';
        $siteParsedURLHost = $siteParsedURL['host'] ?? '';

        return $metaParsedURLHost !== $siteParsedURLHost;
    }

    protected function getExternalFileSize(string $url): string
    {
        $headers = $this->getHeaders($url);
        $contentLength = '';

        foreach ($headers as $key => $header) {
            // Sometimes both parts of the key starts with capitals e.g. 'Content-Length'.
            if (strtolower($key) !== 'content-length') {
                continue;
            }

            $contentLength = is_array($header) ? end($header) : $header;

            break;
        }

        return $contentLength;
    }

    protected function getHeaders(string $url): array
    {
        if (empty($url) || ! \wp_http_validate_url($url)) {
            return [];
        }

        $cachedHeaders = \get_transient($url);

        if (! empty($cachedHeaders) && is_array($cachedHeaders)) {
            return $cachedHeaders;
        }

        $response = get_headers($url, 1, $this->streamContext());

        if (empty($response) || ! is_array($response)) {
            return [];
        }

        \set_transient($url, $response, 86400);

        return $response;
    }

    /**
     * SSL is usually not valid in local environments.
     * Disable verifications.
     */
    protected function streamContext()
    {
        if (($_ENV['APP_ENV'] ?? '') !== 'development') {
            return null;
        }

        return stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);
    }
}
