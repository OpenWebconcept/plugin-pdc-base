<?php

namespace OWC\PDC\Base\Models;

class UPLResponseBody
{
    /**
     * @var array
     */
    protected $body = [];

    public function __construct(array $body)
    {
        $this->body = $body;
    }

    public function getStatus(): string
    {
        return !empty($this->body['results']['bindings']) ? 'success' : 'error';
    }

    public function getData(): array
    {
        return $this->body['results']['bindings'] ?? [];
    }
}
