CREATE DATABASE IF NOT EXISTS nutrihealth;
USE nutrihealth;

CREATE TABLE `user` (
  id int not null AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  typeUser char(1) not null,
  primary key (id)
); ENGINE=InnoDB DEFAULT charset=utf8mb4;

CREATE TABLE `anotacoes` (
  id int not null AUTO_INCREMENT,
  texto VARCHAR(1000) not null,
  data 
  user_id int NOT NULL,
  PRIMARY KEY (id),
  KEY idx_anotacoes_user_id (user_id),
  CONSTRAINT fk_anotacoes_user_id FOREIGN KEY (user_id)
    REFERENCES `user` (id)
    ON DELETE CASCADE
    on UPDATE CASCADE
) ENGINE=InnoDB DEFAULT charset=utf8mb4;
