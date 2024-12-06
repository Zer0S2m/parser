<?php

namespace TestParser\api;

class ArtistDTO
{
    private InfoArtistDTO $infoArtist;

    private array $infoArtistTracks;

    public function __construct(InfoArtistDTO $infoArtist, array $infoArtistTracks)
    {
        $this->infoArtist = $infoArtist;
        $this->infoArtistTracks = $infoArtistTracks;
    }

    public function getInfoArtist(): InfoArtistDTO
    {
        return $this->infoArtist;
    }

    public function getInfoArtistTracks(): array
    {
        return $this->infoArtistTracks;
    }
}