<?php

namespace OWC\PDC\Base\Support;

use Closure;
use Exception;
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
            if ('content-length' !== $key) {
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

        try {
            $response = $this->getHeadersCurl($url);
        } catch (Exception $e) {
            $response = false;
        }

        if (empty($response) || ! is_array($response)) {
            return [];
        }

        \set_transient($url, $response, 86400);

        return $response;
    }

    protected function getHeadersCurl(string $url): array
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);

        $response = curl_exec($ch);

        if (false === $response || curl_errno($ch)) {
            return [];
        }

        curl_close($ch);

        return $this->parseHeaders($response);
    }

    /**
     * Parses a raw HTTP headers string and converts it into an associative array.
     * Handles headers with multiple values by storing them as arrays.
     */
    protected function parseHeaders(string $headers): array
    {
        $result = [];
        $lines = explode("\r\n", $headers);

        foreach ($lines as $line) {
            if (empty($line)) {
                continue;
            }

            $parts = explode(":", $line, 2);

            // If the line doesn't contain exactly two parts, it's not a valid header.
            if (2 !== count($parts)) {
                continue;
            }

            // Normalize the header key to lowercase and trim any extra whitespace.
            $key = strtolower(trim($parts[0]));
            $value = trim($parts[1]);

            if (isset($result[$key])) {
                // If the key already exists, store the value as an array and append the new value.
                $result[$key] = (array) $result[$key];
                $result[$key][] = $value;
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
