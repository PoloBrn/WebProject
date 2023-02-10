SET FOREIGN_KEY_CHECKS = 0;
SET GROUP_CONCAT_MAX_LEN=32768;
SET @tables = NULL;
SELECT GROUP_CONCAT('`', table_name, '`') INTO @tables
  FROM information_schema.tables
  WHERE table_schema = (SELECT DATABASE());
SELECT IFNULL(@tables,'dummy') INTO @tables;
SET @tables = CONCAT('DROP TABLE IF EXISTS ', @tables);
PREPARE stmt FROM @tables;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users(
   id_user INT,
   email VARCHAR(50) NOT NULL,
   password VARCHAR(50) NOT NULL,
   role VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_user)
);

CREATE TABLE company(
   id_company int,
   name VARCHAR(50),
   active BOOLEAN,
   PRIMARY KEY(id_company)
);

CREATE TABLE city(
   id_city int,
   name VARCHAR(50),
   postal_code VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_city)
);

CREATE TABLE address(
   id_address int,
   name VARCHAR(50) not null,
   id_city int NOT NULL,
   PRIMARY KEY(id_address),
   FOREIGN KEY(id_city) REFERENCES city(id_city) on delete cascade
);

CREATE TABLE activity(
   id_activity INT,
   name VARCHAR(50) not null,
   PRIMARY KEY(id_activity)
);

CREATE TABLE localities(
   id_locality INT,
   id_company int NOT NULL,
   id_address int NOT NULL,
   PRIMARY KEY(id_locality),
   FOREIGN KEY(id_company) REFERENCES company(id_company) on delete cascade,
   FOREIGN KEY(id_address) REFERENCES address(id_address) on delete cascade
);

CREATE TABLE campus(
   id_campus INT,
   name VARCHAR(50) not null,
   id_address int NOT NULL,
   PRIMARY KEY(id_campus),
   FOREIGN KEY(id_address) REFERENCES address(id_address) on delete cascade
);

CREATE TABLE promo(
   id_promo INT,
   name VARCHAR(50) not null,
   id_campus INT NOT NULL,
   PRIMARY KEY(id_promo),
   FOREIGN KEY(id_campus) REFERENCES campus(id_campus) on delete cascade
);

CREATE TABLE offer(
   id_offer INT,
   name VARCHAR(50) not null,
   active BOOLEAN NOT NULL,
   skills VARCHAR(50) not null,
   length VARCHAR(50) NOT NULL,
   start_date DATE NOT NULL,
   amount INT NOT NULL,
   salary VARCHAR(50) NOT NULL,
   id_locality INT NOT NULL,
   id_activity INT NOT NULL,
   PRIMARY KEY(id_offer),
   FOREIGN KEY(id_locality) REFERENCES localities(id_locality) on delete cascade,
   FOREIGN KEY(id_activity) REFERENCES activity(id_activity) on delete cascade
);

CREATE TABLE affiliated(
   id_user INT not null,
   id_promo INT not null,
   PRIMARY KEY(id_user, id_promo),
   FOREIGN KEY(id_user) REFERENCES users(id_user) on delete cascade,
   FOREIGN KEY(id_promo) REFERENCES promo(id_promo) on delete cascade
);

CREATE TABLE sector(
   id_company int not null,
   id_activity INT not null,
   PRIMARY KEY(id_company, id_activity),
   FOREIGN KEY(id_company) REFERENCES company(id_company) on delete cascade,
   FOREIGN KEY(id_activity) REFERENCES activity(id_activity) on delete cascade
);

CREATE TABLE postulate(
   id_user INT not null,
   id_offer INT not null,
   cv VARCHAR(50),
   motivation_letter VARCHAR(50),
   progress VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_user, id_offer),
   FOREIGN KEY(id_user) REFERENCES users(id_user) on delete cascade,
   FOREIGN KEY(id_offer) REFERENCES offer(id_offer) on delete cascade
);

CREATE TABLE wish(
   id_user INT not null,
   id_offer INT not null,
   PRIMARY KEY(id_user, id_offer),
   FOREIGN KEY(id_user) REFERENCES users(id_user) on delete cascade,
   FOREIGN KEY(id_offer) REFERENCES offer(id_offer) on delete cascade
);

CREATE TABLE feedback(
   id_user INT not null,
   id_company int not null,
   rate INT not null,
   comment VARCHAR(50) not null,
   PRIMARY KEY(id_user, id_company),
   FOREIGN KEY(id_user) REFERENCES users(id_user) on delete cascade,
   FOREIGN KEY(id_company) REFERENCES company(id_company) on delete cascade
);
