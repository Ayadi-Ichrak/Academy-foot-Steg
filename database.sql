-- Supprimer la base de données si elle existe
DROP DATABASE IF EXISTS Tiger_foot_Academy;

-- Créer une nouvelle base de données
CREATE DATABASE Tiger_foot_Academy CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Utiliser la base de données nouvellement créée
USE Tiger_foot_Academy;

-- Création de la table Joueur
CREATE TABLE Joueur (
    code VARCHAR(255) PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    date_naissance DATE NOT NULL,
    photo VARCHAR(255) NOT NULL,
    groupe_id INT,
    parent_cin INT
);

-- Création de la table Parents
CREATE TABLE Parents (
    cin INT(8) PRIMARY KEY ,    
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    num_tel VARCHAR(20) NOT NULL,
    photo VARCHAR(255),
    joueur_code VARCHAR(255)
);

-- Création de la table Entraineur
CREATE TABLE Entraineur (
    cin INT(8) PRIMARY KEY ,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    num_tel INT(8) Not NULL,
    date_cin DATE NOT NULL
);

-- Création de la table Terrain
CREATE TABLE Terrain (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    localisation VARCHAR(255) NOT NULL

);

-- Création de la table Matériel
CREATE TABLE Materiel (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    quantite INT NOT NULL,
    date_achat DATE NOT NULL
);

-- Création de la table Groupe
CREATE TABLE Groupe (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL
);

-- Création de la table Planning
CREATE TABLE Planning (
    id INT PRIMARY KEY AUTO_INCREMENT,
    jour ENUM('Lundi', 'Mardi', 'Mercredi','Jeudi','vendredi','Samedi','Dimanche') NOT NULL,
    temps_debut TIME NOT NULL,
    temps_fin TIME NOT NULL,
    entraineur_cin INT(8)NOT NULL,
    groupe_id INT NOT NULL,
    terrain_id INT NOT NULL
);

-- Création de la table Authentification
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    identifiant VARCHAR(50) ,
    pass VARCHAR(255) NOT NULL,
    user_type ENUM('Admin', 'Gestionnaire', 'Membre') NOT NULL
);

-- Création de la table Paiement_Joueur
CREATE TABLE Paiement_Joueur (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(255)  NOT NULL  ,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    montant DECIMAL(10, 2) NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    nb_mois INT NOT NULL
);

-- Création de la table Paiement_Entraineur
CREATE TABLE Paiement_Entraineur (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cin INT(8) NOT NULL ,
    date_cin DATE NOT NULL,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    montant  DECIMAL(10, 2) NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    nb_mois INT NOT NULL
);
-- Création de la table historique_acces
CREATE TABLE historique_acces (
    id INT PRIMARY KEY AUTO_INCREMENT,
    joueur_code VARCHAR(255) NOT NULL,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    validiter VARCHAR(255) NOT NULL,
    groupe_id INT NOT NULL,
    date_acces DATE NOT NULL,
    terrain_id INT NOT NULL,
    heure TIME NOT NULL,
    FOREIGN KEY (groupe_id) REFERENCES Groupe(id)
);
-- Création de la table notification
CREATE TABLE Notification_paiement (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type_utilisateur ENUM('Joueur', 'Entraineur') NOT NULL,
    utilisateur_id VARCHAR(255) NOT NULL,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    date_fin DATE NOT NULL,
    date_notification DATE NOT NULL
);
-- Ajout des clés étrangères pour la table Joueur
ALTER TABLE Joueur
ADD CONSTRAINT FK_Joueur_Groupe FOREIGN KEY (groupe_id) REFERENCES Groupe(id),
ADD CONSTRAINT FK_Joueur_Parents FOREIGN KEY (parent_cin) REFERENCES Parents(cin);

-- Ajout des clés étrangères pour la table Parents
ALTER TABLE Parents
ADD CONSTRAINT FK_Parents_Joueur FOREIGN KEY (joueur_code) REFERENCES Joueur(code);

-- Ajout des clés étrangères pour la table Planning
ALTER TABLE Planning
ADD CONSTRAINT FK_Planning_Groupe FOREIGN KEY (groupe_id) REFERENCES Groupe(id),
ADD CONSTRAINT FK_Planning_Terrain FOREIGN KEY (terrain_id) REFERENCES Terrain(id);

INSERT INTO Joueur (code, nom, prenom, date_naissance, photo, groupe_id, parent_cin) VALUES
('ABD070NN85', 'Nouira', 'Abdelkader', '1985-07-15', 'abdelkader.jpg', 1, 01234567),
('SOU040DN90', 'Daghbaji', 'Sofiene', '1990-04-22', 'sofiene.jpg', 2, 12345678);

INSERT INTO Parents (cin, nom, prenom, num_tel, photo, joueur_code) VALUES
(01234567, 'Nouira', 'Habib', '98989898', 'habib.jpg', 'ABD070NN85'),
(12345678, 'Daghbaji', 'Ali', '97979797', 'ali.jpg', 'SOU040DN90');

INSERT INTO Entraineur (cin, nom, prenom, num_tel, date_cin) VALUES
(01122334, 'Jaziri', 'Mohamed', 99778899,'1985-07-15'),
(10111213, 'Trabelsi', 'Sami', 99887766,'1985-04-16');

INSERT INTO Groupe (nom ) VALUES
('2009-2010'),
('2011-2012');

INSERT INTO Terrain (nom, localisation) VALUES
('Stade El Menzah', 'Tunis'),
('Stade Hammamet', 'Hammamet');

INSERT INTO Materiel (nom, quantite, date_achat) VALUES
('Ballons', 20, '2024-01-15'),
('Maillots', 30, '2024-02-10');

INSERT INTO Paiement_Joueur (code, nom, prenom, montant, date_debut, date_fin, nb_mois) VALUES
('BEN050AA92', 'Ben Salah', 'Ali', 450.00, '2024-07-01', DATE_ADD('2024-07-01', INTERVAL 3 MONTH), 3),
('HAM030BB88', 'Hammami', 'Bilel', 600.00, '2024-06-15', DATE_ADD('2024-06-15', INTERVAL 4 MONTH), 4);

INSERT INTO Paiement_Entraineur (cin, date_cin, nom, prenom, montant, date_debut, date_fin, nb_mois) VALUES
(01122334, '2002-07-09','Nom1', 'Prenom1', 1000.00, '2024-07-05', DATE_ADD('2024-07-05', INTERVAL 1 MONTH), 1),
(10111213, '2004-03-05','Nom2', 'Prenom2', 1200.00, '2024-06-28', DATE_ADD('2024-06-28', INTERVAL 1 MONTH), 1);

INSERT INTO Planning (jour, heure,entraineur_cin, groupe_id, terrain_id) VALUES
('2024-08-10', '10:00:00',01122334, 1, 1),
('2024-08-11', '15:00:00',10111213, 2, 2);

INSERT INTO users (identifiant, pass, user_type) VALUES
('admin', 'admin', 'Admin'),
('gestionnaire', 'gestionnaire', 'Gestionnaire'),
('membre', 'membre', 'Membre');

