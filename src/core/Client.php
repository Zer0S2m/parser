<?php

namespace TestParser\core;

use CurlHandle;
use Exception;

abstract class Client
{
    protected CurlHandle|null $curl = null;

    private bool $isInit = false;

    private array $headers = [];

    protected function init(): void
    {
        if (!$this->isInit) {
            $this->curl = curl_init();

            $this->isInit = true;

            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
        }
    }

    abstract public function setSettings(ClientSettingsDTO|null $settings): void;

    /**
     * @throws Exception
     */
    protected function setUrl(string $url): void
    {
        $this->checkCurlInit();

        curl_setopt($this->curl, CURLOPT_URL, $url);
    }

    /**
     * @throws Exception
     */
    protected function setHeader(ClientSettingsHeaderDTO ...$headers): void
    {
        $collectedHeaders = [];

        foreach ($headers as $header) {
            $collectedHeaders[] = (string)$header;
        }

        array_push($this->headers, ...$collectedHeaders);
    }

    /**
     * @throws Exception
     */
    public function close(): void
    {
        $this->checkCurlInit();

        curl_close($this->curl);

        $this->isInit = false;
    }

    /**
     * @throws Exception
     */
    protected function checkCurlInit(): void
    {
        if (is_null($this->curl)) {
            throw new Exception();
        }
    }

    abstract public function get(): mixed;
}