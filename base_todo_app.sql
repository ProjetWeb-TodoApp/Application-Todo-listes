-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 22 juin 2018 à 16:51
-- Version du serveur :  5.7.17
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `todo_app`
--

-- --------------------------------------------------------

--
-- Structure de la table `belongs`
--

CREATE TABLE `belongs` (
  `id_user` int(24) NOT NULL,
  `id_group` int(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `belongs`
--

INSERT INTO `belongs` (`id_user`, `id_group`) VALUES
(2, 1),
(7, 1),
(10, 1),
(11, 1),
(12, 1),
(14, 1),
(3, 2),
(8, 2),
(13, 2),
(15, 2),
(16, 2),
(19, 2),
(20, 2),
(4, 3),
(6, 3),
(9, 3),
(18, 3),
(1, 4),
(5, 4),
(17, 4);

-- --------------------------------------------------------

--
-- Structure de la table `checklist`
--

CREATE TABLE `checklist` (
  `id` int(24) NOT NULL,
  `id_task` int(24) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `checklist`
--

INSERT INTO `checklist` (`id`, `id_task`, `state`, `title`) VALUES
(1, 3, 0, 'Liste des éléments nécessaires'),
(2, 3, 0, 'Dimensionnement du moteur '),
(3, 1, 0, 'Modélisation mécanique '),
(4, 2, 0, 'Simulation'),
(5, 5, 0, 'Première version budget'),
(6, 5, 0, 'Deuxième version'),
(7, 4, 0, 'Rédaction du cahier des charges');

-- --------------------------------------------------------

--
-- Structure de la table `group`
--

CREATE TABLE `group` (
  `id` int(24) NOT NULL,
  `id_group_manager` int(24) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `group`
--

INSERT INTO `group` (`id`, `id_group_manager`, `title`) VALUES
(1, 2, 'Pôle mécanique'),
(2, 3, 'Pôle électrique'),
(3, 4, 'Pôle financier'),
(4, 1, 'Pôle gestion de projet');

-- --------------------------------------------------------

--
-- Structure de la table `realize`
--

CREATE TABLE `realize` (
  `id_user` int(24) NOT NULL,
  `id_task` int(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `realize`
--

INSERT INTO `realize` (`id_user`, `id_task`) VALUES
(2, 1),
(7, 1),
(10, 1),
(11, 2),
(12, 2),
(14, 2),
(3, 3),
(8, 3),
(13, 3),
(15, 3),
(16, 3),
(19, 3),
(20, 3),
(1, 4),
(5, 4),
(17, 4),
(4, 5),
(6, 5),
(9, 5),
(18, 5);

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

CREATE TABLE `task` (
  `id` int(24) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `deadline` date NOT NULL,
  `completion_date` date DEFAULT NULL,
  `parent_task` int(24) DEFAULT NULL,
  `id_group` int(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id`, `title`, `description`, `deadline`, `completion_date`, `parent_task`, `id_group`) VALUES
(1, 'Modélisation mécanique de la planche de surf', 'Modélisation en CAO de la planche, en prenant en compte les efforts dynamques de l\'eau sur l\'aileron et la surface au contact avec l\'eau.', '2018-06-30', NULL, NULL, 1),
(2, 'Simulation aérodynamique de la planche de surf', 'Simulation numérique des efforts et contraintes et exercés sur la planche ainsi que la vitesse du moteur de la planche en fonction des vagues et des courants', '2018-07-05', NULL, 1, 1),
(3, 'Dimensionnement du moteur électrique de la planche', 'Dimensionner les différents éléments du moteur de la planche en fonction des contraintes du cahier des charges', '2018-07-19', NULL, 4, 2),
(4, 'Rédaction du cahier des charges', 'Rédaction complet du cahier des charges en discutant avec les différents clients pour satisfaire leurs exigences vis à vis de la conception de la planche de surf.', '2018-06-23', NULL, NULL, 4),
(5, 'Réalisation du budget du projet', 'Rédaction du budget et des différentes commandes de matériel en partenariat avec les différents pôles du projet.', '2018-07-27', NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(24) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `project_manager` tinyint(1) NOT NULL,
  `mail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `login`, `password`, `project_manager`, `mail`) VALUES
(1, 'Simon', 'Suzan', 'ssuzan', 'simonsimon', 1, 'simon.suzan@centrale.centralelille.fr'),
(2, 'Ninon', 'Le Floch', 'nlefloch', 'ninonninon', 0, 'ninon.lefloch@centrale.centralelille.fr'),
(3, 'Nicolas', 'Levy', 'nlevy', 'nicolasnicolas', 0, 'nicolas.levy@centrale.centralelille.fr'),
(4, 'Simon', 'Vial', 'svial', 'simonsimon', 0, 'simon.vial@centrale.centralelille.fr'),
(5, 'Raphaëlle', 'Hug', 'rhug', 'raphaëlleraphaëlle', 0, 'raphaëlle.hug@centrale.centralelille.fr'),
(6, 'Arthur', 'Terrasse', 'aterrasse', 'arthurarthur', 0, 'arthur.terrasse@centrale.centralelille.fr'),
(7, 'Emma', 'Vigneron', 'evigneron', 'emmaemma', 0, 'emma.vigneron@centrale.centralelille.fr'),
(8, 'Clément', 'Vo', 'cvo', 'clémentclément', 0, 'clément.vo@centrale.centralelille.fr'),
(9, 'Pierre', 'Aries', 'paries', 'pierrepierre', 0, 'pierre.aries@centrale.centralelille.fr'),
(10, 'Elian', 'Bernard', 'ebernard', 'elianelian', 0, 'elian.bernard@centrale.centralelille.fr'),
(11, 'Alice', 'Bachelot', 'abachelot', 'alicealice', 0, 'alice.bachelot@centrale.centralelille.fr'),
(12, 'Morgane', 'Moullié', 'mmoullié', 'morganemorgane', 0, 'morgane.moullié@centrale.centralelille.fr'),
(13, 'Alexandre', 'Pizigo', 'apizigo', 'alexandrealexandre', 0, 'alexandre.pizigo@centrale.centralelille.fr'),
(14, 'Margot', 'Guichard', 'mguichard', 'margotmargot', 0, 'margot.guichard@centrale.centralelille.fr'),
(15, 'Aymeric', 'Bouvier', 'abouvier', 'aymericaymeric', 0, 'aymeric.bouvier@centrale.centralelille.fr'),
(16, 'Marceau', 'Beyou', 'mbeyou', 'marceaumarceau', 0, 'marceau.beyou@centrale.centralelille.fr'),
(17, 'Camille', 'Brunet', 'cbrunet', 'camillecamille', 0, 'camille.brunet@centrale.centralelille.fr'),
(18, 'Noah', 'Philippe', 'nphilippe', 'noahnoah', 0, 'noah.phiippe@centrale.centralelille.fr'),
(19, 'Hugo', 'Gitton', 'hgitton', 'hugohugo', 0, 'hugo.gitton@centrale.centralelille.fr'),
(20, 'Maximilien', 'Grattepanche', 'mgrattepanche', 'maximilienmaximilien', 0, 'maximilien.grattepanche@centrale.centralelille.fr');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `belongs`
--
ALTER TABLE `belongs`
  ADD UNIQUE KEY `couple_user_group` (`id_user`,`id_group`),
  ADD KEY `belongs_group` (`id_group`);

--
-- Index pour la table `checklist`
--
ALTER TABLE `checklist`
  ADD UNIQUE KEY `couple_task_user` (`id`,`id_task`),
  ADD KEY `id_task` (`id_task`);

--
-- Index pour la table `group`
--
ALTER TABLE `group`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `realize`
--
ALTER TABLE `realize`
  ADD UNIQUE KEY `couple_user_task` (`id_user`,`id_task`),
  ADD KEY `idtask` (`id_task`);

--
-- Index pour la table `task`
--
ALTER TABLE `task`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD UNIQUE KEY `id` (`id`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `belongs`
--
ALTER TABLE `belongs`
  ADD CONSTRAINT `belongs_group` FOREIGN KEY (`id_group`) REFERENCES `group` (`id`),
  ADD CONSTRAINT `belongs_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `checklist`
--
ALTER TABLE `checklist`
  ADD CONSTRAINT `id_task` FOREIGN KEY (`id_task`) REFERENCES `task` (`id`);

--
-- Contraintes pour la table `realize`
--
ALTER TABLE `realize`
  ADD CONSTRAINT `idtask` FOREIGN KEY (`id_task`) REFERENCES `task` (`id`),
  ADD CONSTRAINT `iduser` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
