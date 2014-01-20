DROP TABLE IF EXISTS vehicule, internaute;

CREATE TABLE internaute (
	identifiant int(11) AUTO_INCREMENT,
	login varchar(20),
	mdp varchar(20),
	compte int(11),
	CONSTRAINT pk_internaute_identifiant PRIMARY KEY (identifiant)
) ENGINE=InnoDB ;

CREATE TABLE vehicule (
	identifiant int(11) AUTO_INCREMENT,
	categorie varchar(20),
	carburant varchar(7),
	consommation varchar(20),
	volume_reservoir int(3),
	volume_restant int(3),
	kilometrage int(11),
	proprietaire int(11),
	CONSTRAINT pk_vehicule_identifiant PRIMARY KEY (identifiant),
	CONSTRAINT fk_vehicule_proprietaire FOREIGN KEY (proprietaire) REFERENCES internaute(identifiant)
) ENGINE=InnoDB ;

