CREATE DATABASE IF NOT EXISTS `abeille`;
use `abeille`;

CREATE TABLE IF NOT EXISTS fleurs(
  fleur_id int(50) AUTO_INCREMENT,
  points int(50) not null,
  nom varchar(500),
  description varchar(500),
  emplacement int(50) not null,
  deleted_at datetime,
  PRIMARY KEY (fleur_id)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
