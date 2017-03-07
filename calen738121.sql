-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Mar 07 Mars 2017 à 10:16
-- Version du serveur :  10.1.19-MariaDB-1~jessie
-- Version de PHP :  5.6.27-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `calen738121`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

CREATE TABLE `abonnement` (
  `id` int(11) NOT NULL,
  `type_eve` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `abonnement`
--

INSERT INTO `abonnement` (`id`, `type_eve`, `user`) VALUES
(1, 1, 3),
(2, 2, 3),
(3, 3, 3),
(4, 4, 3),
(5, 5, 3),
(6, 6, 3),
(7, 7, 3),
(8, 8, 3),
(9, 9, 3),
(10, 10, 3),
(11, 11, 3),
(12, 12, 3),
(13, 13, 3),
(14, 14, 3),
(15, 15, 3),
(16, 16, 3),
(17, 17, 3),
(18, 18, 3),
(19, 20, 3),
(20, 21, 3),
(21, 22, 3),
(22, 23, 3),
(23, 24, 3),
(24, 25, 3),
(25, 26, 3),
(26, 27, 3),
(27, 28, 3),
(28, 29, 3),
(29, 30, 3),
(30, 31, 3),
(31, 32, 3),
(32, 33, 3),
(33, 34, 3),
(34, 35, 3),
(35, 36, 3);

-- --------------------------------------------------------

--
-- Structure de la table `droit`
--

CREATE TABLE `droit` (
  `id` int(11) NOT NULL,
  `libelle` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `droit_profil`
--

CREATE TABLE `droit_profil` (
  `id_user` int(11) NOT NULL,
  `id_profil` int(11) NOT NULL,
  `id_droit` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE `evenement` (
  `id` int(11) NOT NULL,
  `nom` varchar(200) DEFAULT NULL,
  `lieu` text,
  `date_pub` date DEFAULT NULL,
  `date_db` datetime DEFAULT NULL,
  `date_fn` datetime DEFAULT NULL,
  `contact` varchar(200) DEFAULT NULL,
  `prix` int(11) DEFAULT NULL,
  `description` text,
  `user` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `evenement`
--

INSERT INTO `evenement` (`id`, `nom`, `lieu`, `date_pub`, `date_db`, `date_fn`, `contact`, `prix`, `description`, `user`, `type`) VALUES
(2, 'Test_Nom', 'Test_Lieu', '2016-10-30', '2016-10-31 00:00:00', '2016-11-01 00:00:00', 'hsrt', 12, 'Un séminaire dans les alpes bavaroises quoi ..alo lékéo', 2, 29);

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `libelle` varchar(200) DEFAULT NULL,
  `lien` varchar(255) DEFAULT NULL,
  `type_photo` int(11) DEFAULT NULL,
  `id_eve` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `photo`
--

INSERT INTO `photo` (`id`, `libelle`, `lien`, `type_photo`, `id_eve`) VALUES
(1, NULL, '1477738351Moi&Toi/Photo_Couverture/20150318_165456.jpg', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `id` int(11) NOT NULL,
  `libelle` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `profil`
--

INSERT INTO `profil` (`id`, `libelle`) VALUES
(1, 'Abonné'),
(2, 'Utilisatuer'),
(3, 'Administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `sous_type_evenement`
--

CREATE TABLE `sous_type_evenement` (
  `id` int(11) NOT NULL,
  `libelle` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `sous_type_evenement`
--

INSERT INTO `sous_type_evenement` (`id`, `libelle`) VALUES
(1, 'Sportif'),
(2, 'Commercial'),
(3, 'Professionnel'),
(4, 'Culturel'),
(5, 'Entreprise');

-- --------------------------------------------------------

--
-- Structure de la table `type_evenement`
--

CREATE TABLE `type_evenement` (
  `id` int(11) NOT NULL,
  `libelle` varchar(200) DEFAULT NULL,
  `description` text,
  `type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `type_evenement`
--

INSERT INTO `type_evenement` (`id`, `libelle`, `description`, `type`) VALUES
(1, 'Match', NULL, 1),
(2, 'Jeu Olympique', NULL, 1),
(3, 'Compétition', NULL, 1),
(4, 'Promotion', NULL, 2),
(5, 'Solde', NULL, 2),
(6, 'Lancement Produit', NULL, 2),
(7, 'Congrès de métier', NULL, 3),
(8, 'Déstockage', NULL, 2),
(9, 'Séminaire', NULL, 3),
(10, 'Festival', NULL, 4),
(11, 'Journée du patrimoine', NULL, 4),
(12, 'Nuitt des musées', NULL, 4),
(13, 'Défilé', NULL, 4),
(14, 'Excursion', NULL, 4),
(15, 'Fête de science', NULL, 4),
(16, 'Fête de la musique', NULL, 4),
(17, 'Carnaval', NULL, 4),
(18, 'Concert', NULL, 4),
(20, 'Festival', NULL, 4),
(21, 'Journée du patrimoine', NULL, 4),
(22, 'Nuitt des musées', NULL, 4),
(23, 'Défilé', NULL, 4),
(24, 'Excursion', NULL, 4),
(25, 'Fête de science', NULL, 4),
(26, 'Fête de la musique', NULL, 4),
(27, 'Carnaval', NULL, 4),
(28, 'Concert', NULL, 4),
(29, 'Séminaire', NULL, 5),
(30, 'Convention d\'entreprise', NULL, 5),
(31, 'Dîner', NULL, 5),
(32, 'Spectacle', NULL, 5),
(33, 'Soirée Gala', NULL, 5),
(34, 'Team Bulding', NULL, 5),
(35, 'Soirée conviviale', NULL, 5),
(36, 'Journée du personnel', NULL, 5);

-- --------------------------------------------------------

--
-- Structure de la table `type_photo`
--

CREATE TABLE `type_photo` (
  `id` int(11) NOT NULL,
  `libelle` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `type_photo`
--

INSERT INTO `type_photo` (`id`, `libelle`) VALUES
(1, 'Couverture'),
(2, 'Profil');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(200) DEFAULT NULL,
  `prenom` varchar(200) DEFAULT NULL,
  `pseudo` varchar(200) DEFAULT NULL,
  `sexe` char(1) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `date_creation` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `code_activation` varchar(200) DEFAULT NULL,
  `photo` int(11) DEFAULT NULL,
  `profil` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `pseudo`, `sexe`, `telephone`, `date_creation`, `email`, `password`, `active`, `code_activation`, `photo`, `profil`) VALUES
(1, 'TOSSOU', 'Gisele', 'Gigi14', NULL, NULL, NULL, 'gigi@yahoo.fr', NULL, NULL, NULL, NULL, NULL),
(2, 'Toi', 'Moi', 'Moi&Toi', 'M', '0699669', '2016-10-29', 'javajavaget@yahoo.fr1', '$2y$10$UCUSZ1RHuuY7v27Xqgjiw.7c13T39FnaBziR3mQcT1Dgqd87xVYIC', 1, 'KQA0DD1kgFJTHPkLSWXJXHnQow3ZseD3U4ZmwQwAj4kOIuppeaY1H0GUvwJNAcDj4ttp8NQgHYSdg9si9f9EeCoyXVblXDuQWL4T', NULL, NULL),
(3, NULL, NULL, 'Moi&Toi2', NULL, NULL, NULL, 'sergecarmel@gmail.com', NULL, NULL, NULL, NULL, NULL),
(4, NULL, NULL, 'test', '', NULL, '2016-10-30', 'test@test.test', '$2y$10$DMTyDkmYz0np2qdArozBrureL7ScczOf4BfY6QbbupfD4ycc7Baf.', NULL, 'n9RA2OALNCKDZsvCFYX6awqytAEAMENZAsnq6L2IcCa2SvrnichixvGQT0gwBRjZ9xd496zavzZdTeo2hv8ERBiyypUZ75N3pQVn', NULL, NULL),
(5, NULL, NULL, 'javajavaget@yahoo.fr', '', NULL, '2016-10-30', 'javajavaget@yahoo.fr', '$2y$10$6e4u3rNMjP8eju6F.LLKG.R50aLBUzOldBjIOtakgLhzgw5YWojSm', 1, 'IzadVqE9sZOC1wXGZSdoliIIXWntb2CKrALaPf983MzT9mpW3raezIKltVEuM634tD49JZ7BCtkyEyiwPjycP7n9RQrsJjl3NdZm', NULL, NULL),
(6, NULL, NULL, 'Komir', '', NULL, '2016-11-03', 'ferrrsky@yahoo.fr', '$2y$10$drxJzPyO03Hmvr86Nj12ruS4ACUweF6Xh6g5ATXejZu0BdR10PO1m', 1, 'RF60Wv1dNxOjWxIrDXtKVg3ZjZNeOG1v0VuWfiXQDBZpWvEngWVZ3LM0AqbfWZyWJRGOXtsrSfEEA8QETzrLb4IzjJE5w2Q6IkHv', NULL, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_eve` (`type_eve`,`user`),
  ADD KEY `user` (`user`);

--
-- Index pour la table `droit`
--
ALTER TABLE `droit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `droit_profil`
--
ALTER TABLE `droit_profil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_profil` (`id_profil`),
  ADD KEY `id_profil_2` (`id_profil`),
  ADD KEY `id_user` (`id_user`,`id_droit`),
  ADD KEY `id_droit` (`id_droit`);

--
-- Index pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`,`type`),
  ADD KEY `type` (`type`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_photo` (`type_photo`),
  ADD KEY `id_eve` (`id_eve`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sous_type_evenement`
--
ALTER TABLE `sous_type_evenement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_evenement`
--
ALTER TABLE `type_evenement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Index pour la table `type_photo`
--
ALTER TABLE `type_photo`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photo` (`photo`,`profil`),
  ADD KEY `profil` (`profil`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `abonnement`
--
ALTER TABLE `abonnement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT pour la table `droit`
--
ALTER TABLE `droit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `droit_profil`
--
ALTER TABLE `droit_profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `sous_type_evenement`
--
ALTER TABLE `sous_type_evenement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `type_evenement`
--
ALTER TABLE `type_evenement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT pour la table `type_photo`
--
ALTER TABLE `type_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD CONSTRAINT `abonnement_ibfk_1` FOREIGN KEY (`type_eve`) REFERENCES `type_evenement` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `abonnement_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `droit_profil`
--
ALTER TABLE `droit_profil`
  ADD CONSTRAINT `droit_profil_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `droit_profil_ibfk_2` FOREIGN KEY (`id_profil`) REFERENCES `profil` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `droit_profil_ibfk_3` FOREIGN KEY (`id_droit`) REFERENCES `droit` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `evenement_ibfk_2` FOREIGN KEY (`type`) REFERENCES `type_evenement` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`id_eve`) REFERENCES `evenement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `type_evenement`
--
ALTER TABLE `type_evenement`
  ADD CONSTRAINT `type_evenement_ibfk_1` FOREIGN KEY (`type`) REFERENCES `sous_type_evenement` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`photo`) REFERENCES `photo` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`profil`) REFERENCES `profil` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
