<?php

require 'vendor/autoload.php';

use TestParser\YandexMusicParser;

$yandexClient = new YandexMusicParser("https://music.yandex.ru/artist/36800/tracks");

$data = $yandexClient->loadDataArtist();
if (is_null($data)) {
    echo "Артист не найден";
} else {
    $yandexClient->saveDataInDB($data);
}
