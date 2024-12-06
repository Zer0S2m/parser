CREATE TABLE artists
(
    id                   INT PRIMARY KEY AUTO_INCREMENT,
    name                 VARCHAR(255) UNIQUE NOT NULL,
    count_albums         INT                 NOT NULL,
    count_subscriptions  LONG                NOT NULL,
    last_month_listeners LONG                NOT NULL,
    external_id          INT UNIQUE          NOT NULL
);
