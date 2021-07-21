<?php

namespace OWC\PDC\Base\Support\Traits;

use OWC\PDC\Base\Models\UPLResponseBody;

trait RequestUPL
{
    public function getRequestData(array $response): array
    {
        $decodedBody = json_decode($response['body'] ?? '', true);

        if (!$decodedBody && json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }

        $body = new UPLResponseBody($decodedBody);

        if ($body->getStatus() !== 'success') {
            return [];
        }

        return $body->getData();
    }

    public function getOptionsUPL(): array
    {
        $cachedOptions = get_transient('uplOptions');

        if (is_array($cachedOptions) && count($cachedOptions) > 0) {
            return $cachedOptions;
        }

        $response = wp_remote_get('https://standaarden.overheid.nl/owms/oquery/UPL-gemeente.json');

        if (is_wp_error($response) || !is_array($response)) {
            return [];
        }

        $options = $this->getRequestData($response);

        set_transient('uplOptions', $options, 86400);

        return $options;
    }
}
