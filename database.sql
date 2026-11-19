-- =============================================================
-- Plateforme de cours en ligne
-- Script de création complet de la base de données (MySQL / MariaDB)
--
-- Relations :
--   categorie 1 ── N cours        (un-à-plusieurs)
--   formateur 1 ── N cours        (un-à-plusieurs)
--   etudiant  N ── N cours        (plusieurs-à-plusieurs, via inscription)
-- =============================================================

DROP DATABASE IF EXISTS cours_en_ligne;
CREATE DATABASE cours_en_ligne
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE cours_en_ligne;
SET NAMES utf8mb4;

-- -------------------------------------------------------------
-- Table categorie
-- -------------------------------------------------------------
CREATE TABLE categorie (
    idcategorie  INT          NOT NULL AUTO_INCREMENT,
    nom          VARCHAR(80)  NOT NULL,
    description  VARCHAR(255) NULL,
    PRIMARY KEY (idcategorie)
) ENGINE = InnoDB;

-- -------------------------------------------------------------
-- Table formateur
-- -------------------------------------------------------------
CREATE TABLE formateur (
    idformateur  INT          NOT NULL AUTO_INCREMENT,
    nom          VARCHAR(100) NOT NULL,
    prenom       VARCHAR(45)  NOT NULL,
    specialite   VARCHAR(100) NOT NULL,
    biographie   LONGTEXT     NULL,
    email        VARCHAR(120) NOT NULL,
    PRIMARY KEY (idformateur)
) ENGINE = InnoDB;

-- -------------------------------------------------------------
-- Table etudiant
-- -------------------------------------------------------------
CREATE TABLE etudiant (
    idetudiant     INT          NOT NULL AUTO_INCREMENT,
    nom            VARCHAR(60)  NOT NULL,
    prenom         VARCHAR(60)  NOT NULL,
    email          VARCHAR(120) NOT NULL,
    date_creation  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idetudiant)
) ENGINE = InnoDB;

-- -------------------------------------------------------------
-- Table cours (relations un-à-plusieurs avec categorie et formateur)
-- -------------------------------------------------------------
CREATE TABLE cours (
    idcours                INT          NOT NULL AUTO_INCREMENT,
    titre                  VARCHAR(150) NOT NULL,
    description            MEDIUMTEXT   NULL,
    niveau                 ENUM('Débutant', 'Intermédiaire', 'Avancé') NOT NULL DEFAULT 'Débutant',
    duree_heures           SMALLINT     NOT NULL,
    prix                   DECIMAL(7,2) NOT NULL DEFAULT 0.00,
    image                  VARCHAR(255) NULL,
    categorie_idcategorie  INT          NOT NULL,
    formateur_idformateur  INT          NOT NULL,
    PRIMARY KEY (idcours),
    INDEX fk_cours_categorie_idx (categorie_idcategorie),
    INDEX fk_cours_formateur_idx (formateur_idformateur),
    CONSTRAINT fk_cours_categorie
        FOREIGN KEY (categorie_idcategorie)
        REFERENCES categorie (idcategorie)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT fk_cours_formateur
        FOREIGN KEY (formateur_idformateur)
        REFERENCES formateur (idformateur)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE = InnoDB;

-- -------------------------------------------------------------
-- Table inscription (table de liaison : relation plusieurs-à-plusieurs
-- entre etudiant et cours)
-- -------------------------------------------------------------
CREATE TABLE inscription (
    idinscription        INT     NOT NULL AUTO_INCREMENT,
    date_inscription     DATE    NOT NULL,
    cours_idcours        INT     NOT NULL,
    etudiant_idetudiant  INT     NOT NULL,
    progression          TINYINT(3) NOT NULL DEFAULT 0,
    PRIMARY KEY (idinscription),
    INDEX fk_inscription_cours_idx (cours_idcours),
    INDEX fk_inscription_etudiant_idx (etudiant_idetudiant),
    CONSTRAINT fk_inscription_cours
        FOREIGN KEY (cours_idcours)
        REFERENCES cours (idcours)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_inscription_etudiant
        FOREIGN KEY (etudiant_idetudiant)
        REFERENCES etudiant (idetudiant)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE = InnoDB;

-- =============================================================
-- TP3 : utilisateurs, privilèges et journal de bord
-- =============================================================

-- -------------------------------------------------------------
-- Table privilege : les rôles possibles (1 = Administrateur, 2 = Client)
-- -------------------------------------------------------------
CREATE TABLE privilege (
    idprivilege  INT          NOT NULL AUTO_INCREMENT,
    privilege    VARCHAR(45)  NOT NULL,
    PRIMARY KEY (idprivilege)
) ENGINE = InnoDB;

-- -------------------------------------------------------------
-- Table user : les comptes qui peuvent se connecter
-- Le mot de passe est haché avec password_hash() (jamais en clair).
-- Un client est relié à un étudiant (etudiant_idetudiant),
-- un administrateur n'en a pas (NULL).
-- -------------------------------------------------------------
CREATE TABLE user (
    iduser                 INT          NOT NULL AUTO_INCREMENT,
    nom                    VARCHAR(100) NOT NULL,
    username               VARCHAR(120) NOT NULL,
    password               VARCHAR(255) NOT NULL,
    privilege_idprivilege  INT          NOT NULL,
    etudiant_idetudiant    INT          NULL,
    PRIMARY KEY (iduser),
    UNIQUE INDEX username_UNIQUE (username),
    UNIQUE INDEX etudiant_UNIQUE (etudiant_idetudiant),
    CONSTRAINT fk_user_privilege
        FOREIGN KEY (privilege_idprivilege)
        REFERENCES privilege (idprivilege)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT fk_user_etudiant
        FOREIGN KEY (etudiant_idetudiant)
        REFERENCES etudiant (idetudiant)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE = InnoDB;

-- -------------------------------------------------------------
-- Table journal : une ligne par page visitée
-- -------------------------------------------------------------
CREATE TABLE journal (
    idjournal    INT          NOT NULL AUTO_INCREMENT,
    ip           VARCHAR(45)  NOT NULL,
    date_visite  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    utilisateur  VARCHAR(120) NOT NULL,
    page         VARCHAR(255) NOT NULL,
    PRIMARY KEY (idjournal)
) ENGINE = InnoDB;

-- =============================================================
-- Données d'exemple
-- =============================================================

INSERT INTO categorie (nom, description) VALUES
('Programmation', 'Langages, algorithmes et bonnes pratiques de développement.'),
('Design', 'Interfaces, typographie, couleur et expérience utilisateur.'),
('Données', 'Bases de données, SQL et analyse.'),
('Langues', 'Apprendre à communiquer dans une nouvelle langue.');

INSERT INTO formateur (nom, prenom, specialite, biographie, email) VALUES
('Bergeron', 'Camille', 'Développement web', 'Développeuse depuis dix ans, elle enseigne PHP et JavaScript.', 'camille.bergeron@exemple.ca'),
('Haddad', 'Karim', 'Bases de données', 'Administrateur de bases de données, il rend le SQL concret.', 'karim.haddad@exemple.ca'),
('Tremblay', 'Julie', 'Design d''interfaces', 'Designer UX depuis huit ans.', 'julie.tremblay@exemple.ca'),
('Morales', 'Diego', 'Espagnol', 'Enseigne l''espagnol conversationnel depuis quinze ans.', 'diego.morales@exemple.ca');

INSERT INTO etudiant (nom, prenom, email, date_creation) VALUES
('Gagnon', 'Léa', 'lea.gagnon@exemple.ca', '2026-08-18 10:12:00'),
('Côté', 'Samuel', 'samuel.cote@exemple.ca', '2026-08-21 14:30:00'),
('Benali', 'Amira', 'amira.benali@exemple.ca', '2026-08-25 09:05:00'),
('Roy', 'Thomas', 'thomas.roy@exemple.ca', '2026-09-02 19:47:00'),
('Pelletier', 'Nadia', 'nadia.pelletier@exemple.ca', '2026-09-10 08:20:00');

INSERT INTO cours (titre, description, niveau, duree_heures, prix, categorie_idcategorie, formateur_idformateur) VALUES
('PHP orienté objet', 'Classes, objets, héritage et PDO pas à pas.', 'Débutant', 24, 89.00, 1, 1),
('JavaScript moderne', 'Fonctions, promesses et manipulation du DOM.', 'Intermédiaire', 30, 99.00, 1, 1),
('SQL pour débutants', 'Requêtes SELECT, filtres, tris et jointures.', 'Débutant', 12, 0.00, 3, 2),
('Modéliser une base de données', 'Diagrammes entité-relation et clés étrangères.', 'Intermédiaire', 16, 59.00, 3, 2),
('Typographie pour le web', 'Choisir et associer des polices lisibles.', 'Débutant', 8, 39.00, 2, 3),
('Espagnol : premières conversations', 'Se présenter, commander, demander son chemin.', 'Débutant', 20, 49.00, 4, 4);

INSERT INTO inscription (date_inscription, cours_idcours, etudiant_idetudiant, progression) VALUES
('2026-08-19', 1, 1, 100),
('2026-08-20', 3, 1, 65),
('2026-08-22', 1, 2, 40),
('2026-09-01', 2, 2, 10),
('2026-08-26', 5, 3, 80),
('2026-09-03', 3, 3, 0),
('2026-09-04', 6, 4, 25),
('2026-09-11', 4, 5, 5);

-- Privilèges
INSERT INTO privilege (privilege) VALUES
('Administrateur'),
('Client');

-- Comptes de démonstration
--   Administrateur : admin@apprendo.ca      / Admin123!
--   Client (Léa)   : lea.gagnon@exemple.ca  / Client123!
INSERT INTO user (nom, username, password, privilege_idprivilege, etudiant_idetudiant) VALUES
('Administrateur', 'admin@apprendo.ca', '$2y$10$rI7jYOp9DppB1l6tO2IHTOg6Rhc1dD6WCSsvwY0SG2C9wBBypWPBu', 1, NULL),
('Léa Gagnon', 'lea.gagnon@exemple.ca', '$2y$10$uWb2ZfCu1gXNqkdV2ulrfOiSZjywKMdjJDLQXettXfdC5Xcu7FNc6', 2, 1);
