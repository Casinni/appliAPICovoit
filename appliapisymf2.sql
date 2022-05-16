-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 15 avr. 2022 à 22:37
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `appliapisymf`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220201181746', '2022-02-01 19:18:18', 53),
('DoctrineMigrations\\Version20220201190555', '2022-02-01 20:06:05', 56),
('DoctrineMigrations\\Version20220412195015', '2022-04-12 21:50:29', 99),
('DoctrineMigrations\\Version20220412201043', '2022-04-12 22:10:55', 98),
('DoctrineMigrations\\Version20220412201214', '2022-04-12 22:12:26', 97),
('DoctrineMigrations\\Version20220412202634', '2022-04-12 22:26:45', 473),
('DoctrineMigrations\\Version20220412203657', '2022-04-12 22:37:05', 180),
('DoctrineMigrations\\Version20220412204237', '2022-04-12 22:42:45', 114),
('DoctrineMigrations\\Version20220413185253', '2022-04-13 20:53:08', 170),
('DoctrineMigrations\\Version20220415182924', '2022-04-15 20:29:37', 178),
('DoctrineMigrations\\Version20220415183111', '2022-04-15 20:31:22', 62);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `id` int(11) NOT NULL,
  `pers_id` int(11) DEFAULT NULL,
  `trajet_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

CREATE TABLE `marque` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id`, `nom`) VALUES
(1, 'BMW'),
(2, 'peugeot'),
(4, 'fiat'),
(5, 'wolkswagen');

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `id` int(11) NOT NULL,
  `nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naiss` datetime DEFAULT NULL,
  `ville_id` int(11) DEFAULT NULL,
  `voiture_id` int(11) DEFAULT NULL,
  `tel` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`id`, `nom`, `prenom`, `date_naiss`, `ville_id`, `voiture_id`, `tel`, `email`) VALUES
(13, 'Hugo', 'Victor', '1972-01-14 18:43:59', 1, 2, '0612343423', 'vhugo@free.fr'),
(14, 'Valjean', 'Jean', '1972-01-14 18:43:59', 1, 3, '', ''),
(15, 'Macron', 'Brigitte', '1972-01-14 18:43:59', 1, NULL, '', ''),
(16, 'chirac', 'jacques', NULL, 1, NULL, '0623344534', 'jchiracfree.fr'),
(17, 'chirac', 'jacques', NULL, 1, 2, '0623344534', 'jchiracfree.fr'),
(18, 'chirac', 'jacques', NULL, 1, 2, '0623344534', 'jchiracfree.fr'),
(19, 'chirac', 'jacques', NULL, 1, 2, '0623344534', 'jchiracfree.fr'),
(21, 'chirac', 'jacques', NULL, 1, 2, '0623344534', 'jchirac@free.fr');

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

CREATE TABLE `trajet` (
  `id` int(11) NOT NULL,
  `ville_dep_id` int(11) DEFAULT NULL,
  `ville_arr_id` int(11) DEFAULT NULL,
  `pers_id` int(11) DEFAULT NULL,
  `nb_kms` int(11) NOT NULL,
  `datetrajet` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `api_token`) VALUES
(6, 'admin', '[\"ROLE_ADMIN\"]', '$2y$13$Lxs33w99UoUNU89YKW3tguuJ2PretLPzx8zkSf4akGJm29Nl/BgvO', '100972'),
(7, 'pascal', '[\"ROLE_USER\"]', '$2y$13$L3Y/KWS9meCULNP8hUmbK.Ed5TUb9/lGGi0syEvOxse7BeGOaWY1C', '130806');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `id` int(11) NOT NULL,
  `code_postal` int(11) NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`id`, `code_postal`, `ville`) VALUES
(1, 75000, 'paris');

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `id` int(11) NOT NULL,
  `nb_place` int(11) NOT NULL,
  `modele` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marque_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`id`, `nb_place`, `modele`, `marque_id`) VALUES
(2, 4, 'punto', 4),
(3, 4, '406', 2),
(6, 4, '307', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_5E90F6D64AA53143` (`pers_id`),
  ADD UNIQUE KEY `UNIQ_5E90F6D6D12A823` (`trajet_id`);

--
-- Index pour la table `marque`
--
ALTER TABLE `marque`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FCEC9EF181A8BA` (`voiture_id`),
  ADD KEY `IDX_FCEC9EFA73F0036` (`ville_id`);

--
-- Index pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2B5BA98C97A9E2C6` (`ville_dep_id`),
  ADD UNIQUE KEY `UNIQ_2B5BA98CBFADF06C` (`ville_arr_id`),
  ADD UNIQUE KEY `UNIQ_2B5BA98C4AA53143` (`pers_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_8D93D6497BA2F5EB` (`api_token`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E9E2810F4827B9B2` (`marque_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `marque`
--
ALTER TABLE `marque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `trajet`
--
ALTER TABLE `trajet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `voiture`
--
ALTER TABLE `voiture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `FK_5E90F6D64AA53143` FOREIGN KEY (`pers_id`) REFERENCES `personne` (`id`),
  ADD CONSTRAINT `FK_5E90F6D6D12A823` FOREIGN KEY (`trajet_id`) REFERENCES `trajet` (`id`);

--
-- Contraintes pour la table `personne`
--
ALTER TABLE `personne`
  ADD CONSTRAINT `FK_FCEC9EF181A8BA` FOREIGN KEY (`voiture_id`) REFERENCES `voiture` (`id`),
  ADD CONSTRAINT `FK_FCEC9EFA73F0036` FOREIGN KEY (`ville_id`) REFERENCES `ville` (`id`);

--
-- Contraintes pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD CONSTRAINT `FK_2B5BA98C4AA53143` FOREIGN KEY (`pers_id`) REFERENCES `personne` (`id`),
  ADD CONSTRAINT `FK_2B5BA98C97A9E2C6` FOREIGN KEY (`ville_dep_id`) REFERENCES `ville` (`id`),
  ADD CONSTRAINT `FK_2B5BA98CBFADF06C` FOREIGN KEY (`ville_arr_id`) REFERENCES `ville` (`id`);

--
-- Contraintes pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD CONSTRAINT `FK_E9E2810F4827B9B2` FOREIGN KEY (`marque_id`) REFERENCES `marque` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
