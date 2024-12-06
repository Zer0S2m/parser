<?php

namespace TestParser\api;

use Exception;

class YandexMusicClientSettingsDTO
{
    private int $artistID;

    /**
     * @throws Exception
     */
    public function __construct(int $artistID)
    {
        if ($artistID <= 0) {
            throw new Exception();
        }

        $this->artistID = $artistID;
    }

    public function getArtistID(): int
    {
        return $this->artistID;
    }
}