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


