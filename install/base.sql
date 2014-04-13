-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Client :  localhost:3306
-- Généré le :  Dim 13 Avril 2014 à 00:40
-- Version du serveur :  5.5.36
-- Version de PHP :  5.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `42_rush`
--

-- --------------------------------------------------------

--
-- Structure de la table `party`
--

CREATE TABLE IF NOT EXISTS `party` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_1_login` varchar(255) NOT NULL,
  `player_1_obj` text NOT NULL,
  `player_2_login` varchar(255) NOT NULL,
  `player_2_obj` text NOT NULL,
  `player_3_login` varchar(255) NOT NULL,
  `player_3_obj` text NOT NULL,
  `player_4_login` varchar(255) NOT NULL,
  `player_4_obj` text NOT NULL,
  `board` text NOT NULL,
  `asteroid` text NOT NULL,
  `running` tinyint(1) NOT NULL,
  `turn` int(11) NOT NULL,
  `player` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `party`
--

INSERT INTO `party` (`id`, `player_1_login`, `player_1_obj`, `player_2_login`, `player_2_obj`, `player_3_login`, `player_3_obj`, `player_4_login`, `player_4_obj`, `board`, `asteroid`, `running`, `turn`, `player`) VALUES
(1, '', '', '', '', '', '', '', '', '', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `t_chat`
--

CREATE TABLE IF NOT EXISTS `t_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `text` varchar(200) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=77 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
