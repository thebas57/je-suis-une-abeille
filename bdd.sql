CREATE DATABASE IF NOT EXISTS `abeille`;
use `abeille`;

CREATE TABLE IF NOT EXISTS emplacement(
  emplacement_id int(50) AUTO_INCREMENT,
  nom varchar(500),
  PRIMARY KEY (emplacement_id)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS fleurs(
  fleur_id int(50) AUTO_INCREMENT,
  nomLatin varchar(500),
  nomFr varchar(500),
  pollen int(50) not null,
  nectar int(50) not null,
  floraison varchar(500),
  couleur varchar(500),
  hauteur decimal(50,2),
  emplacement_id int(50) not null,
  illustration text,
  deleted_at datetime,
  FOREIGN KEY (emplacement_id) references emplacement(emplacement_id),
  PRIMARY KEY (fleur_id)


)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

