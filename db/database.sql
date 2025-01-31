CREATE SCHEMA IF NOT EXISTS movie_star;
USE movie_star;
CREATE TABLE IF NOT EXISTS users(
    cd_user INT UNSIGNED AUTO_INCREMENT NOT NULL,
    nm_email VARCHAR(255) UNIQUE NOT NULL,
    nm_user_name VARCHAR(50) NOT NULL,
    nm_last_name VARCHAR(60) NOT NULL,
    nm_password VARCHAR(60) NOT NULL,
    ic_image BOOLEAN DEFAULT FALSE,
    nm_token VARCHAR(60),
    ds_user TEXT,
    PRIMARY KEY (cd_user)
);
CREATE TABLE IF NOT EXISTS movies(
    cd_movie INT UNSIGNED AUTO_INCREMENT NOT NULL,
    nm_movie VARCHAR(255) NOT NULL,
    qt_total_review INT UNSIGNED DEFAULT 0,
    qt_total_rating INT UNSIGNED DEFAULT 0,
    qt_length SMALLINT UNSIGNED DEFAULT 0,
    ds_movie TEXT NOT NULL,
    nm_trailer VARCHAR(255),
    cd_user INT UNSIGNED,
    PRIMARY KEY (cd_movie),
    FOREIGN KEY (cd_user) REFERENCES users(cd_user) ON DELETE SET NULL
);
CREATE TABLE IF NOT EXISTS reviews(
    cd_user INT UNSIGNED NOT NULL,
    cd_movie INT UNSIGNED NOT NULL,
    qt_rating TINYINT UNSIGNED NOT NULL,
    ds_comment TEXT,
    PRIMARY KEY (cd_user, cd_movie),
    FOREIGN KEY (cd_user) REFERENCES users(cd_user) ON DELETE CASCADE,
    FOREIGN KEY (cd_movie) REFERENCES movies(cd_movie) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS categories(
    cd_category SMALLINT UNSIGNED NOT NULL,
    nm_category VARCHAR(30) NOT NULL, -- Should be unique
    PRIMARY KEY (cd_category)
);
CREATE TABLE IF NOT EXISTS movies_categories(
    cd_movie INT UNSIGNED NOT NULL,
    cd_category SMALLINT UNSIGNED NOT NULL, 
    PRIMARY KEY (cd_movie, cd_category),
    FOREIGN KEY (cd_movie) REFERENCES movies(cd_movie) ON DELETE CASCADE,
    FOREIGN KEY (cd_category) REFERENCES categories(cd_category) ON DELETE CASCADE
);