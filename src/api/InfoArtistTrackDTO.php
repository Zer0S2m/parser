<?php

namespace TestParser\api;

class InfoArtistTrackDTO
{
    private int $trackID;

    private string $trackTitle;

    private int $trackDuration;

    public function __construct(int $trackID, string $trackTitle, int $trackDuration)
    {
        $this->trackID = $trackID;
        $this->trackTitle = $trackTitle;
        $this->trackDuration = $trackDuration;
    }

    public function getTrackID(): int
    {
        return $this->trackID;
    }

    public function getTrackTitle(): string
    {
        return $this->trackTitle;
    }

    public function getTrackDuration(): int
    {
        return $this->trackDuration;
    }

    public function __toString(): string
    {
        return "InfoArtistTrackDTO"
            . "\n("
            . "\n\ttrackID => " . $this->getTrackID()
            . "\n\ttrackTitle => " . $this->getTrackTitle()
            . "\n\ttrackDuration => " . $this->getTrackDuration()
            . "\n)";
    }
}