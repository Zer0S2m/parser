CREATE TABLE artist_tracks
(
    id          INT PRIMARY KEY AUTO_INCREMENT,
    title       VARCHAR(512) UNIQUE NOT NULL,
    duration    LONG                NOT NULL,
    external_id INT UNIQUE          NOT NULL,
    artist_id   INT                 NOT NULL
);
