<?php

namespace TestParser\api;

use TestParser\db\ClientMysql;

class ClientMysqlYandexMusic extends ClientMysql
{
    public function saveArtist(InfoArtistDTO $info): void
    {
        $this->init();

        if ($this->isExistsArtistByExternalID($info->getArtistID())) {
            $countAlbums = $info->getCountAlbums();
            $countSubscriptions = $info->getCountSubscriptions();
            $lastMonthListenersArtist = $info->getLastMonthListenersArtist();
            $artistExternalID = $info->getArtistID();

            $this
                ->conn
                ->query("
                    UPDATE artists 
                        SET count_albums=$countAlbums,
                        count_subscriptions=$countSubscriptions,
                        last_month_listeners={$lastMonthListenersArtist}
                    WHERE external_id={$artistExternalID}
                    "
                );

            $this->close();

            return;
        }

        $stmt = $this
            ->conn
            ->prepare("
                INSERT INTO artists(
                    name, 
                    count_albums, 
                    count_subscriptions, 
                    last_month_listeners, 
                    external_id
                ) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "siiii",
            $name,
            $countAlbums,
            $countSubscriptions,
            $lastMonthListeners,
            $externalId
        );

        $name = $info->getArtistName();
        $countAlbums = $info->getCountAlbums();
        $countSubscriptions = $info->getCountSubscriptions();
        $lastMonthListeners = $info->getLastMonthListenersArtist();
        $externalId = $info->getArtistID();

        $stmt->execute();
        $stmt->close();

        $this->close();
    }

    private function isExistsArtistByExternalID(int $externalID): bool
    {
        $query = "SELECT 1 FROM artists WHERE external_id=?";
        $result = $this
            ->conn
            ->execute_query($query, [$externalID]);

        $row = $result->fetch_assoc();

        return (bool)$row;
    }

    public function saveArtistTracks(int $artistID, array $tracks): void
    {
        $this->init();

        $existsArtistTracks = $this->getArtistTrackIDSByArtistID($artistID);

        if (count($existsArtistTracks) > 0) {
            $tracks = array_filter($tracks, function ($track) use ($existsArtistTracks) {
                return !in_array($track->getTrackID(), $existsArtistTracks);
            });
        }

        if (count($tracks) === 0) {
            $this->close();

            return;
        }

        $stmt = $this
            ->conn
            ->prepare("
                INSERT INTO artist_tracks(
                    title, 
                    duration, 
                    external_id, 
                    artist_id
                ) VALUES (?, ?, ?, ?)"
            );
        $stmt->bind_param(
            "siii",
            $titleTrack,
            $durationTrack,
            $externalId,
            $externalArtistID
        );

        $this
            ->conn
            ->query("START TRANSACTION");

        foreach ($tracks as $track) {
            $titleTrack = $track->getTrackTitle();
            $durationTrack = $track->getTrackDuration();
            $externalId = $track->getTrackID();
            $externalArtistID = $artistID;

            $stmt->execute();
        }

        $stmt->close();

        $this
            ->conn
            ->query("COMMIT");

        $this->close();
    }

    private function getArtistTrackIDSByArtistID(int $artistID): array
    {
        $rows = $this
            ->conn
            ->query("SELECT * FROM artist_tracks WHERE artist_id=$artistID");

        $artistTrackIDS = [];

        foreach ($rows as $row) {
            $artistTrackIDS[] = intval($row["external_id"]);
        }

        return $artistTrackIDS;
    }
}