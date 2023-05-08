CREATE TABLE Applications (
    id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(128) NOT NULL DEFAULT '',
    year int NOT NULL DEFAULT 0,
    mail VARCHAR(255) NOT NULL DEFAULT '',
    sex varchar(5) NOT NULL DEFAULT '',
    limbs int NOT NULL DEFAULT 0,
    biography varchar(255) NOT NULL DEFAULT ''
)

CREATE TABLE Applications_skills (
    id int unsigned NOT NULL,
    skill_id int unsigned NOT NULL,
    FOREIGN KEY (id) REFERENCES Applications(id),
    FOREIGN KEY (skill_id) REFERENCES Skills(skill_id)
);

CREATE TABLE Skills (
    skill_id int unsigned NOT NULL PRIMARY KEY,
    skill_name varchar(128) NOT NULL
);
