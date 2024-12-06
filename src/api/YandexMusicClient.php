<?php

namespace TestParser\api;

use TestParser\core\Client;
use TestParser\core\ClientSettingsDTO;
use Exception;
use Override;

final class YandexMusicClient extends Client
{
    private string $baseUrlAPIGetInfoArtist = "https://music.yandex.ru/handlers/artist.jsx";

    private array $baseQueryParams = [
        "period" => "month",
        "lang" => "ru",
        "external-domain" => "yandex.music.ru",
        "overembed" => "false",
        "what" => "tracks",
        "trackPage" => 0,
        "trackPageSize" => 9999,
    ];

    private int $artistID;

    private string $collectedUrl;

    /**
     * @throws Exception
     */
    public function __construct(string $url)
    {
        $this->artistID = $this
            ->collectSettingsDTO($url)
            ->getArtistID();

        $this->collectedUrl = $this->collectUrl();
    }

    /**
     * @throws Exception
     */
    private function collectSettingsDTO(string $url): YandexMusicClientSettingsDTO
    {
        $matchers = [];

        preg_match("/\d{1,99}/", $url, $matchers);

        if (count($matchers) === 0) {
            throw new Exception();
        }

        return new YandexMusicClientSettingsDTO(artistID: intval($matchers[0]));
    }

    private function collectUrl(): string
    {
        return $this->baseUrlAPIGetInfoArtist .
            "?" .
            http_build_query(
                array_merge(
                    $this->baseQueryParams,
                    [
                        "artist" => $this->artistID
                    ]
                )
            );
    }

    /**
     * @throws Exception
     */
    #[Override]
    public function setSettings(ClientSettingsDTO|null $settings): void
    {
        if (!is_null($settings)) {
            $this->setHeader(...$settings->getHeaders());
        }
    }

    /**
     * @throws Exception
     */
    #[Override]
    public function get(): array
    {
        $this->init();

        $this->setUrl($this->collectedUrl);

        $result = curl_exec($this->curl);
        $json = json_decode($result, true);

        $this->close();

        return $json;
    }
}
