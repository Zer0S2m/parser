# Parser

Парсер сервиса - [Yandex Music](https://music.yandex.ru).

## Структура проекта

**`./src`** - Исходники проекта.

**`./src/api`** - Готовое API для обращения к сервису Yandex Music.

**`./src/config`** - Конфигурация проекта.

**`./src/core`** _и_ **`./src/db`** - Фундаментальные строительные блоки для создание **api** и к обращению к **DB**.

**`./src/YandexMusicParser`** - Готовый парсер для сервиса Yandex Music с обеспечением сохранения данных в БД.

## Запуск БД через docker

```bash
docker-compose -f docker-compose.dev.yml up -d --force-recreate --build db
```

## Пример запуска проекта

Перед запуском настройте БД и обновите конфигурацию БД для системы **`./src/config/DB.php`**, и примените миграции
**`./migrations`**.

```php
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
```

Также пример находиться в корне проекта **`Example.php`**.
