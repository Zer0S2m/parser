<?php

namespace TestParser\core;

class ClientSettingsDTO
{
    private array $headers = [];

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function addHeader(ClientSettingsHeaderDTO $header): ClientSettingsDTO
    {
        $this->headers[] = $header;

        return $this;
    }
}