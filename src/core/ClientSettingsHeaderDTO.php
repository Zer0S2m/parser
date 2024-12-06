<?php

namespace TestParser\core;

final class ClientSettingsHeaderDTO
{
    private string $key;

    private string $value;

    public function __construct(string $key, string $value) {
        $this->key = $key;
        $this->value = $value;
    }

    public function key(): string
    {
        return $this->key;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->key() . ': ' . $this->value();
    }
}