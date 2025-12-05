-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 02 déc. 2025 à 20:37
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `crepobd`
--

-- --------------------------------------------------------

--
-- Structure de la table `block`
--

CREATE TABLE `block` (
  `id_project` int(11) NOT NULL,
  `id_block` int(11) NOT NULL,
  `nom` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `block`
--

INSERT INTO `block` (`id_project`, `id_block`, `nom`) VALUES
(64, 0, 'Future'),
(64, 1, 'En cours'),
(64, 2, 'Finit'),
(70, 0, 'Future'),
(70, 1, 'En cours'),
(70, 2, 'Finit');

-- --------------------------------------------------------

--
-- Structure de la table `membre_task`
--

CREATE TABLE `membre_task` (
  `id_task` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `membre_task`
--

INSERT INTO `membre_task` (`id_task`, `id_user`) VALUES
(13, 3),
(14, 3);

-- --------------------------------------------------------

--
-- Structure de la table `msg`
--

CREATE TABLE `msg` (
  `id_project` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `contenu` varchar(535) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `id_project` int(11) NOT NULL,
  `contenu` varchar(535) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

CREATE TABLE `project` (
  `id_project` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `contenu` text NOT NULL,
  `color` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`id_project`, `nom`, `contenu`, `color`) VALUES
(1, 'crepo', '', '#94332'),
(50, 'Projet leveling', 'séance de pex en groupe pour atteindre le niveau 80 et faire du gameplay ensemble', ''),
(51, 'test', 'on espère que ça fonctionne de ouf', ''),
(64, 'l\'Arme', 'créer de quoi gentiment calmer tout le monde', ''),
(70, 'Vol', 'fabriquer une MACHINE VOLANTE', '');

-- --------------------------------------------------------

--
-- Structure de la table `project_membre`
--

CREATE TABLE `project_membre` (
  `id_user` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  `droit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `project_membre`
--

INSERT INTO `project_membre` (`id_user`, `id_project`, `droit`) VALUES
(2, 1, 9),
(3, 64, 9),
(3, 68, 9),
(3, 69, 9),
(3, 70, 9);

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

CREATE TABLE `task` (
  `id_task` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `contenu` varchar(535) NOT NULL,
  `status` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id_task`, `id_project`, `nom`, `contenu`, `status`, `priority`, `date_start`, `date_end`) VALUES
(1, 1, 'connexion/inscritpion', 'permet la connexion au service mais aussi la création de nouveau compte', 2, 9, '2025-11-27', '2025-11-28'),
(2, 1, 'ajout', 'ajout de tâche a un projet spécififc', 0, 9, '2025-11-28', '2025-12-01'),
(7, 1, 'testsecu', 'sécurisation sql contre l\'injection sql', 0, 11, '2025-11-30', '2025-12-02'),
(12, 64, 'capture', 'capture Ceres la source d\'alimentation de l\'Arme', 0, 11, '2017-06-12', '2017-07-12'),
(13, 64, 'défense', 'création d\'un système de défense pour protéger le laboratoire ', 2, 7, '2025-11-24', '2025-11-28'),
(14, 64, 'besoin primaire', 'trouver une source de nourriture et d\'eau potable ainsi qu\'un lit décent pour dormir', 1, 9, '2025-11-10', '2025-11-12'),
(15, 64, 'remettre en ordre', 'remettre en état le labo a 100% de son potentiel afin de l\'utiliser', 0, 3, '2018-12-04', '2025-12-16');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `user` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(25) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `user`, `password`, `email`, `status`) VALUES
(1, 'protest', '56789', 'protest@gmail.com', 0),
(2, 'patate', '1234', 'patate@gmail.com', 0),
(3, 'Giro', 'profg', 'giro@magi.com', 0),
(4, 'admin', 'admin', 'admin@mail.com', 0),
(5, 'fina', '19735', 'fina@mail.Com', 0),
(10, 'Menos', 'Demonia', 'menos@demonia.fr', 0),
(11, 'Albert', '$2y$10$G5M2YnUKSOLUN5SaWVSEQ.w9vD6H2KvtRcjAq7MVvPBKcn2Y.pHUy', 'Albert@magi.com', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id_project`),
  ADD UNIQUE KEY `nom_pro` (`nom`);

--
-- Index pour la table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id_task`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `mail` (`email`),
  ADD UNIQUE KEY `user` (`user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `project`
--
ALTER TABLE `project`
  MODIFY `id_project` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT pour la table `task`
--
ALTER TABLE `task`
  MODIFY `id_task` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
