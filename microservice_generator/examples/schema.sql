-- Example schema: equipment & event inventory system
-- Use this as input to msgen generate

CREATE TABLE equipment_category (
    id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name        VARCHAR(100) NOT NULL,
    description TEXT,
    image       VARCHAR(255),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE equipments (
    id                    BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name                  VARCHAR(200) NOT NULL,
    equipment_category_id BIGINT UNSIGNED,
    condition             VARCHAR(50),
    size                  VARCHAR(50),
    description           TEXT,
    barcode               VARCHAR(100) UNIQUE,
    is_available          TINYINT(1) NOT NULL DEFAULT 1,
    image                 VARCHAR(255),
    created_at            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (equipment_category_id) REFERENCES equipment_category (id)
);

CREATE TABLE equipment_checkin (
    id           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    equipment_id BIGINT UNSIGNED NOT NULL,
    checked_in_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    notes        TEXT,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (equipment_id) REFERENCES equipments (id)
);

CREATE TABLE events (
    id           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name         VARCHAR(200) NOT NULL,
    location     VARCHAR(255),
    description  TEXT,
    start_date   DATETIME NOT NULL,
    end_date     DATETIME NOT NULL,
    image        VARCHAR(255),
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE event_equipment_checkout (
    id           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    event_id     BIGINT UNSIGNED NOT NULL,
    equipment_id BIGINT UNSIGNED NOT NULL,
    quantity     INT NOT NULL DEFAULT 1,
    checked_out_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    returned_at  TIMESTAMP,
    notes        TEXT,
    PRIMARY KEY (id),
    FOREIGN KEY (event_id)     REFERENCES events (id),
    FOREIGN KEY (equipment_id) REFERENCES equipments (id)
);

CREATE TABLE users (
    id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    email      VARCHAR(255) NOT NULL UNIQUE,
    username   VARCHAR(100) NOT NULL,
    password   VARCHAR(255) NOT NULL,
    is_active  TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE user_groups (
    id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name        VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(255),
    PRIMARY KEY (id)
);

CREATE TABLE user_group_members (
    user_id  BIGINT UNSIGNED NOT NULL,
    group_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (user_id, group_id),
    FOREIGN KEY (user_id)  REFERENCES users (id),
    FOREIGN KEY (group_id) REFERENCES user_groups (id)
);
