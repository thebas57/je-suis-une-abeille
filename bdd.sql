CREATE DATABASE IF NOT EXISTS `abeille`;
use `abeille`;

CREATE TABLE IF NOT EXISTS fleurs(
  fleur_id int(50) AUTO_INCREMENT,
  points int(50) not null,
  nom varchar(500),
  description varchar(500),
  emplacement_id int(50) not null,
  deleted_at datetime,
  FOREIGN KEY (emplacement_id) references emplacement(emplacement_id),
  PRIMARY KEY (fleur_id)


)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS emplacement(
  emplacement_id int(50) AUTO_INCREMENT,
  nom varchar(500),
  PRIMARY KEY (emplacement_id)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
