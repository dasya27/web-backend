create table regions (
    id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(128) NOT NULL DEFAULT '',
    center varchar(128) NOT NULL DEFAULT ''
);

create table develop (
    id_region int unsigned NOT NULL,
    health decimal(5,2) NOT NULL,
    education decimal(5,2) NOT NULL,
    happy decimal(5,2) NOT NULL,
    quality decimal(5,2) NOT NULL,
    ecology decimal(5,2) NOT NULL,
    FOREIGN KEY (id_region) REFERENCES regions(id)
);

create table statistics (
    id_region int unsigned NOT NULL,
    area int unsigned NOT NULL,
    population int unsigned NOT NULL,
    production decimal(5,2) NOT NULL,
    unemployment decimal(5,2) NOT NULL,
    FOREIGN KEY (id_region) REFERENCES regions(id)
);

create table fields (
    id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(128) NOT NULL DEFAULT ''
);

create table fields_regions (
    id_region int unsigned NOT NULL,
    id_field int unsigned NOT NULL,
    FOREIGN KEY (id_region) REFERENCES regions(id),
    FOREIGN KEY (id_field) REFERENCES fields(id)
);

