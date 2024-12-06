ALTER TABLE artist_tracks
    ADD CONSTRAINT fk_artist_id FOREIGN KEY (artist_id) REFERENCES artists (external_id) ON DELETE CASCADE
