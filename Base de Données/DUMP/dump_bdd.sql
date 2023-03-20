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

CREATE TABLE address(
   id_address INT AUTO_INCREMENT,
   name VARCHAR(50),
   postal_code VARCHAR(50) NOT NULL,
   city_name VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_address)
);

CREATE TABLE activity(
   id_activity INT AUTO_INCREMENT,
   name VARCHAR(50),
   PRIMARY KEY(id_activity)
);

CREATE TABLE campus(
   id_campus INT AUTO_INCREMENT,
   name VARCHAR(50),
   id_address INT NOT NULL,
   PRIMARY KEY(id_campus),
   FOREIGN KEY(id_address) REFERENCES address(id_address)
);

CREATE TABLE promo_type(
   id_type INT AUTO_INCREMENT,
   name VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_type)
);

CREATE TABLE skills(
   id_skill INT AUTO_INCREMENT,
   name VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_skill),
   UNIQUE(name)
);

CREATE TABLE role(
   id_role INT AUTO_INCREMENT,
   name VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_role)
);

CREATE TABLE users(
   id_user INT auto_increment,
   email VARCHAR(50) NOT NULL,
   password VARCHAR(255) NOT NULL,
   id_role INT NOT NULL default '3',
   PRIMARY KEY(id_user),
   FOREIGN KEY(id_role) REFERENCES role(id_role)
);

CREATE TABLE promo(
   id_promo INT AUTO_INCREMENT,
   name VARCHAR(50),
   id_type INT NOT NULL,
   id_campus INT NOT NULL,
   PRIMARY KEY(id_promo),
   FOREIGN KEY(id_type) REFERENCES promo_type(id_type) on delete cascade,
   FOREIGN KEY(id_campus) REFERENCES campus(id_campus) on delete cascade
);

CREATE TABLE company(
   id_company INT AUTO_INCREMENT,
   name VARCHAR(50),
   active boolean,
   email VARCHAR(50) NOT NULL,
   nb_student INT NOT NULL,
   logo VARCHAR(50),
   id_user INT,
   PRIMARY KEY(id_company),
   FOREIGN KEY(id_user) REFERENCES users(id_user) on delete set null
);

CREATE TABLE localities(
   id_locality INT AUTO_INCREMENT,
   id_company INT NOT NULL,
   id_address INT NOT NULL,
   PRIMARY KEY(id_locality),
   FOREIGN KEY(id_company) REFERENCES company(id_company) on delete cascade,
   FOREIGN KEY(id_address) REFERENCES address(id_address) on delete cascade
);

CREATE TABLE infos(
   id_user INT,
   first_name VARCHAR(50) NOT NULL,
   last_name VARCHAR(50) NOT NULL,
   cv VARCHAR(50),
   motivation_letter VARCHAR(50),
   id_address INT,
   PRIMARY KEY(id_user),
   FOREIGN KEY(id_user) REFERENCES users(id_user) on delete cascade,
   FOREIGN KEY(id_address) REFERENCES address(id_address)
);

CREATE TABLE offer(
   id_offer INT AUTO_INCREMENT,
   name VARCHAR(50),
   active BOOL NOT NULL,
   start_date DATE NOT NULL,
   end_date DATE NOT NULL,
   places INT NOT NULL,
   salary VARCHAR(50) NOT NULL,
   id_user INT,
   id_locality INT,
   id_activity INT,
   PRIMARY KEY(id_offer),
   FOREIGN KEY(id_user) REFERENCES users(id_user) on delete set null,
   FOREIGN KEY(id_locality) REFERENCES localities(id_locality) on delete set null,
   FOREIGN KEY(id_activity) REFERENCES activity(id_activity) on delete set null
);

CREATE TABLE affiliated(
   id_user INT,
   id_promo INT ,
   PRIMARY KEY(id_user, id_promo),
   FOREIGN KEY(id_user) REFERENCES users(id_user) on delete cascade,
   FOREIGN KEY(id_promo) REFERENCES promo(id_promo) on delete cascade
);

CREATE TABLE sector(
   id_company INT,
   id_activity INT ,
   PRIMARY KEY(id_company, id_activity),
   FOREIGN KEY(id_company) REFERENCES company(id_company) on delete cascade,
   FOREIGN KEY(id_activity) REFERENCES activity(id_activity) on delete cascade
);

CREATE TABLE postulate(
   id_user INT AUTO_INCREMENT,
   id_offer INT ,
   progress VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_user, id_offer),
   FOREIGN KEY(id_user) REFERENCES users(id_user) on delete cascade,
   FOREIGN KEY(id_offer) REFERENCES offer(id_offer) on delete cascade
);

CREATE TABLE wish(
   id_user INT,
   id_offer INT ,
   PRIMARY KEY(id_user, id_offer),
   FOREIGN KEY(id_user) REFERENCES users(id_user) on delete cascade,
   FOREIGN KEY(id_offer) REFERENCES offer(id_offer) on delete cascade
);

CREATE TABLE feedback(
   id_user INT,
   id_company INT ,
   rate INT,
   comment VARCHAR(50),
   PRIMARY KEY(id_user, id_company),
   FOREIGN KEY(id_user) REFERENCES users(id_user) on delete cascade,
   FOREIGN KEY(id_company) REFERENCES company(id_company) on delete cascade
);

CREATE TABLE which_promo(
   id_offer INT,
   id_type INT ,
   PRIMARY KEY(id_offer, id_type),
   FOREIGN KEY(id_offer) REFERENCES offer(id_offer) on delete cascade,
   FOREIGN KEY(id_type) REFERENCES promo_type(id_type) on delete cascade
);

CREATE TABLE need_skill(
   id_offer INT,
   id_skill INT ,
   PRIMARY KEY(id_offer, id_skill),
   FOREIGN KEY(id_offer) REFERENCES offer(id_offer),
   FOREIGN KEY(id_skill) REFERENCES skills(id_skill)
);
