<?php

namespace TestParser\api;

class InfoArtistDTO
{
    private int $artistID;

    private string $artistName;

    private int $lastMonthListenersArtist;

    private int $countAlbums;

    private int $countSubscriptions;

    public function __construct(
        int $artistID,
        string $artistName,
        int $lastMonthListenersArtist,
        int $countAlbums,
        int $countSubscriptions,
    )
    {
        $this->artistID = $artistID;
        $this->artistName = $artistName;
        $this->lastMonthListenersArtist = $lastMonthListenersArtist;
        $this->countAlbums = $countAlbums;
        $this->countSubscriptions = $countSubscriptions;
    }

    public function getArtistID(): int
    {
        return $this->artistID;
    }

    public function getArtistName(): string
    {
        return $this->artistName;
    }

    public function getLastMonthListenersArtist(): int
    {
        return $this->lastMonthListenersArtist;
    }

    public function getCountAlbums(): int
    {
        return $this->countAlbums;
    }

    public function getCountSubscriptions(): int
    {
        return $this->countSubscriptions;
    }

    public function __toString(): string
    {
        return "InfoArtistDTO"
            . "\n("
            . "\n\tartistID => " . $this->getArtistID()
            . "\n\tartistName => " . $this->getArtistName()
            . "\n\tlastMonthListenersArtist => " . $this->getLastMonthListenersArtist()
            . "\n\tcountAlbums => " . $this->getCountAlbums()
            . "\n\tcountSubscriptions => " . $this->getCountSubscriptions()
            . "\n)";
    }
}