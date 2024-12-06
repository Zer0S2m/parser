<?php

namespace TestParser;

use TestParser\api\ArtistDTO;
use TestParser\api\ClientMysqlYandexMusic;
use TestParser\api\InfoArtistDTO;
use TestParser\api\InfoArtistTrackDTO;
use TestParser\api\YandexMusicClient;
use TestParser\core\ClientSettingsDTO;
use TestParser\core\ClientSettingsHeaderDTO;
use Exception;

final class YandexMusicParser
{
    private YandexMusicClient $client;

    private ClientSettingsDTO $baseSettings;

    /**
     * @throws Exception
     */
    public function __construct(string $url)
    {
        $this->client = new YandexMusicClient($url);

        $this->init();

        $this->client->setSettings($this->baseSettings);
    }

    private function init(): void
    {
        $this->baseSettings = (new ClientSettingsDTO())
            ->addHeader(new ClientSettingsHeaderDTO(
                key: "Accept",
                value: "application/json, text/javascript, */*; q=0.01"
            ))
            ->addHeader(new ClientSettingsHeaderDTO(
                key: "Accept-Language",
                value: "en-US,en;q=0.8,ru-RU;q=0.5,ru;q=0.3"
            ))
            ->addHeader(new ClientSettingsHeaderDTO(
                key: "User-Agent",
                value: "Mozilla/5.0 (X11; Linux x86_64; rv:131.0) Gecko/20100101 Firefox/131.0"
            ));
    }

    /**
     * @throws Exception
     */
    public function loadDataArtist(): ArtistDTO|null
    {
        $json = $this
            ->client
            ->get();

        if (!isset($json['artist'])) {
            return null;
        }

        return new ArtistDTO(
            infoArtist: $this->collectInfoArtist($json),
            infoArtistTracks: $this->collectInfoArtistTracks($json),
        );
    }

    public function saveDataInDB(ArtistDTO $artist): void
    {
        $clientMysql = new ClientMysqlYandexMusic();

        $clientMysql->saveArtist($artist->getInfoArtist());
        $clientMysql->saveArtistTracks(
            $artist
                ->getInfoArtist()
                ->getArtistID(),
            $artist->getInfoArtistTracks()
        );
    }

    private function collectInfoArtist(array $json): InfoArtistDTO
    {
        return new InfoArtistDTO(
            artistID: intval($json["artist"]["id"]),
            artistName: $json["artist"]["name"],
            lastMonthListenersArtist: $json["stats"]["lastMonthListeners"],
            countAlbums: intval($json["artist"]["counts"]["directAlbums"]),
            countSubscriptions: intval($json["artist"]["likesCount"]),
        );
    }

    private function collectInfoArtistTracks(array $json): array
    {
        $tracks = [];

        foreach ($json["tracks"] as $track) {
            $tracks[] = new InfoArtistTrackDTO(
                trackID: intval($track["id"]),
                trackTitle: $track["title"],
                trackDuration: intval($track["durationMs"]),
            );
        }

        return $tracks;
    }
}
