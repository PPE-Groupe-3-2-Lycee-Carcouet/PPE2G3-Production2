/*SET storage_engine=InnoDB;

SET AUTOCOMMIT=0;
START TRANSACTION; */

/*D'abord on créé la base si elle n'existe pas
    Puis on déclare vouloir l'utiliser
*/


/*On DROP toutes les tables afin de s'assurer de ne pas créér de doublons*/
DROP TABLE IF EXISTS `clientInscritVoyage`;
DROP TABLE IF EXISTS `client`;
DROP TABLE IF EXISTS `instanceVoyage`;
DROP TABLE IF EXISTS `villeDepartVoyage`;
DROP TABLE IF EXISTS `guideParticipeVoyage`;
DROP TABLE IF EXISTS `voyage`;
DROP TABLE IF EXISTS `ville`;
DROP TABLE IF EXISTS `pays`;
DROP TABLE IF EXISTS `langue`;
DROP TABLE IF EXISTS `guide`;
DROP TABLE IF EXISTS `utilisateur`;
DROP TABLE IF EXISTS `parler`;

/*On créé les tables*/
CREATE TABLE IF NOT EXISTS `utilisateur`(
`id` INT NOT NULL,
`login` VARCHAR(48) NOT NULL,
`password` VARCHAR(96) NOT NULL,
`grade` INT NOT NULL,
PRIMARY KEY (`id`));

CREATE TABLE IF NOT EXISTS `guide`(
`id` INT NOT NULL,
`nom` VARCHAR(48),
PRIMARY KEY (`id`));

CREATE TABLE IF NOT EXISTS `langue`(
`id` INT NOT NULL,
`Libelle` VARCHAR(48),
PRIMARY KEY (`id`));

CREATE TABLE IF NOT EXISTS `parler`(
`idGuide` INT NOT NULL,
`idLangue` INT NOT NULL,
PRIMARY KEY (`idGuide`,`idLangue`),
FOREIGN KEY (idGuide) REFERENCES guide(id) ON DELETE CASCADE,
FOREIGN KEY (idLangue) REFERENCES langue(id) ON DELETE CASCADE);


CREATE TABLE IF NOT EXISTS `pays`(
`code` INT NOT NULL,
`nom` VARCHAR(48),
`photos` VARCHAR(96),
`idLangue` INT,
PRIMARY KEY (`code`),
FOREIGN KEY (idLangue) REFERENCES langue(id) ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS `ville`(
`id` INT NOT NULL,
`nom` VARCHAR(48),
`idPays` INT,
PRIMARY KEY (`id`),
FOREIGN KEY (idPays) REFERENCES pays(code) ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS `voyage`(
`id` INT NOT NULL,
`nom` VARCHAR(48),
`idVilleArrivee` INT,
PRIMARY KEY (`id`),
FOREIGN KEY (idVilleArrivee) REFERENCES ville(id) ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS `guideParticipeVoyage`(
`idGuide` INT NOT NULL,
`idVoyage` INT NOT NULL,
PRIMARY KEY (`idGuide`,`idVoyage`),
FOREIGN KEY (idGuide) REFERENCES guide(id) ON DELETE CASCADE,
FOREIGN KEY (idVoyage) REFERENCES voyage(id) ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS `villeDepartVoyage`(
`idVoyage` INT NOT NULL,
`idVille` INT NOT NULL,
PRIMARY KEY (`idVoyage`,`idVille`),
FOREIGN KEY (idVoyage) REFERENCES voyage(id) ON DELETE CASCADE,
FOREIGN KEY (idVille) REFERENCES ville(id) ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS `instanceVoyage`(
`id` INT NOT NULL,
`idVoyage` INT NOT NULL,
`dateDeb` DATE NOT NULL,
`dateFin` DATE NOT NULL,
`nbPlace` INT NOT NULL,
PRIMARY KEY (`id`,`idVoyage`),
FOREIGN KEY (idVoyage) REFERENCES voyage(id) ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS `client`(
`id` INT NOT NULL,
`nom` VARCHAR(48) NOT NULL,
`prenom` VARCHAR(48) NOT NULL,
`adresse` VARCHAR(96) NOT NULL,
PRIMARY KEY (`id`));

CREATE TABLE IF NOT EXISTS `clientInscritVoyage`(
`idNmVoyage` INT NOT NULL,
`idClient` INT NOT NULL,
`nbPlaceReserve` INT NOT NULL,
PRIMARY KEY (`idNmVoyage`,`idClient`),
FOREIGN KEY (idNmVoyage) REFERENCES instanceVoyage(id) ON DELETE CASCADE,
FOREIGN KEY (idClient) REFERENCES client(id) ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS `activite`(
`idActivite` INT NOT NULL,
`libelleActivite` VARCHAR(48) NOT NULL,
PRIMARY KEY (`idActivite`)
);

/*On insère à l'intérieur*/
INSERT INTO `utilisateur` VALUES ("1","Directeur","Directeur","1");
INSERT INTO `utilisateur` VALUES ("2","Hotesse","Hotesse","2");
INSERT INTO `utilisateur` VALUES ("3","Guide","Guide","3");

INSERT INTO `guide` VALUES ("1","Cléôpatre");
INSERT INTO `guide` VALUES ("2","Mohamed");
INSERT INTO `guide` VALUES ("3","Tao");
INSERT INTO `guide` VALUES ("4","Yún chá");
INSERT INTO `guide` VALUES ("5","Georges");
INSERT INTO `guide` VALUES ("6","Touarig");
INSERT INTO `guide` VALUES ("7","Pablo");

INSERT INTO `langue` VALUES ("1","Arabe");
INSERT INTO `langue` VALUES ("2","Mandarin");
INSERT INTO `langue` VALUES ("3","Cantonais");
INSERT INTO `langue` VALUES ("4","Anglais");
INSERT INTO `langue` VALUES ("5","Espagnol");

INSERT INTO `parler` VALUES ("1","1");
INSERT INTO `parler` VALUES ("1","4");
INSERT INTO `parler` VALUES ("2","1");
INSERT INTO `parler` VALUES ("2","5");


INSERT INTO `pays` VALUES ("1","Egypte","Egypte.jpg","1");
INSERT INTO `pays` VALUES ("2","Chine","Chine.jpg","2");
INSERT INTO `pays` VALUES ("3","Etats-Unis","USA.jpg","3");
INSERT INTO `pays` VALUES ("4","Maroc","Maroc.jpg","4");
INSERT INTO `pays` VALUES ("5","Perou","Perou.jpg","5");

INSERT INTO `ville` VALUES ("1","Le Caire","1");
INSERT INTO `ville` VALUES ("2","Alexandrie","1");
INSERT INTO `ville` VALUES ("3","Pekin","2");
INSERT INTO `ville` VALUES ("4","Shanghai","2");
INSERT INTO `ville` VALUES ("5","Hong-Kong","2");
INSERT INTO `ville` VALUES ("6","Xian","2");
INSERT INTO `ville` VALUES ("7","Dallas","3");
INSERT INTO `ville` VALUES ("8","Laâyoune","4");
INSERT INTO `ville` VALUES ("9","Lima","5");

INSERT INTO `voyage` VALUES ("1","Balade sur le nil (Alexandrie-Le Caire)","1");
INSERT INTO `voyage` VALUES ("2","Balade sur le nil (Le Caire-Alexandrie)","2");
INSERT INTO `voyage` VALUES ("3","Un rêve d'Asie (Sud-Est de La Chine)","5");
INSERT INTO `voyage` VALUES ("4","Un rêve d'Asie (Nord-Est de La Chine)","3");
INSERT INTO `voyage` VALUES ("5","Un rêve d'Asie (Centre de La Chine)","6");
INSERT INTO `voyage` VALUES ("6","American Dream (Texas)","7");
INSERT INTO `voyage` VALUES ("7","Le Sahara : Un désert pas comme les autres","8");
INSERT INTO `voyage` VALUES ("8","Au coeur des Andes","9");

INSERT INTO `guideParticipeVoyage` VALUES ("1","1");
INSERT INTO `guideParticipeVoyage` VALUES ("2","2");
INSERT INTO `guideParticipeVoyage` VALUES ("3","3");
INSERT INTO `guideParticipeVoyage` VALUES ("3","4");
INSERT INTO `guideParticipeVoyage` VALUES ("4","4");
INSERT INTO `guideParticipeVoyage` VALUES ("4","5");
INSERT INTO `guideParticipeVoyage` VALUES ("5","6");
INSERT INTO `guideParticipeVoyage` VALUES ("6","7");
INSERT INTO `guideParticipeVoyage` VALUES ("7","8");

INSERT INTO `villeDepartVoyage` VALUES ("1","2");
INSERT INTO `villeDepartVoyage` VALUES ("2","1");
INSERT INTO `villeDepartVoyage` VALUES ("3","4");
INSERT INTO `villeDepartVoyage` VALUES ("4","3");
INSERT INTO `villeDepartVoyage` VALUES ("5","6");
INSERT INTO `villeDepartVoyage` VALUES ("6","7");
INSERT INTO `villeDepartVoyage` VALUES ("7","8");
INSERT INTO `villeDepartVoyage` VALUES ("8","9");

INSERT INTO `activite` VALUES ("3", "Culture");
INSERT INTO `activite` VALUES ("1", "sport");
INSERT INTO `activite` VALUES ("2", "famille");









