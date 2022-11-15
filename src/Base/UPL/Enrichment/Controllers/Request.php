<?php

namespace OWC\PDC\Base\UPL\Enrichment\Controllers;

class Request
{
    protected string $url;
    protected array $args;

    public function __construct(string $url = '', array $args = [])
    {
        $this->url = $url;
        $this->args = $args;
    }

    public function setURL(string $url): void
    {
        $this->url = $url;
    }

    public function setArgs(array $args): void
    {
        $this->args = $args;
    }

    public function get(): array
    {
        $response = $this->request();

        return $this->validateResponse($response);
    }

    public function post(): array
    {
        $response = $this->request();

        return $this->validateResponse($response);
    }

    protected function request(): array
    {
        $response = \wp_remote_request($this->url);

        if (\is_wp_error($response)) {
            throw new \Exception($response->get_error_message());
        }

        $responseCode = $response['response']['code'] ?? 404;

        if (! in_array($responseCode, [200, 201])) {
            throw new \Exception('Request failed.', $responseCode);
        }

        return $response;
    }

    protected function validateResponse(array $response): array
    {
        $decodedBody = json_decode($response['body'] ?? '', true);

        if (! $decodedBody && json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON decoding failed.');
        }

        return $decodedBody;
    }
}
