CREATE TABLE Applications (
    id int unsigned NOT NULL AUTO_INCREMENT,
    name varchar(128) NOT NULL DEFAULT '',
    year int NOT NULL DEFAULT 0,
    mail VARCHAR(255) NOT NULL DEFAULT '',
    sex varchar(5) NOT NULL DEFAULT '',
    limbs int NOT NULL DEFAULT 0,
    biography varchar(255) NOT NULL DEFAULT '',
    PRIMARY KEY (id)
)

CREATE TABLE Applications_skills (
    id int unsigned NOT NULL,
    skill_id int unsigned NOT NULL
);

CREATE TABLE Skills (
    id int unsigned NOT NULL,
    skill_name varchar(128) NOT NULL
);