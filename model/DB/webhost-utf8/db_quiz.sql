-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 27 avr. 2023 à 07:36
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données : `db_quiz`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `account_login` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `account_psw` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `account_profile` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'user',
  `account_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `account_firstname` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `account_loginadmin` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `account_company` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `account_email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`account_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `account`
--

INSERT INTO `account` (`account_login`, `account_psw`, `account_profile`, `account_name`, `account_firstname`, `account_loginadmin`, `account_company`, `account_email`) VALUES
('adm', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin', 'Smith', 'Adam', 'adm', '', ''),
('adm2', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin', 'Mareau', 'Christian', 'adm2', NULL, NULL),
('aze', 'c6faf72572ce634d34f0011f6341112e563c4d29', 'user', 'adm-Ze', 'Alain', 'adm', 'BRED', ''),
('aze1', 'c6faf72572ce634d34f0011f6341112e563c4d29', 'user', 'adm-Ze1', 'Alain1', 'adm', 'BRED', ''),
('aze2', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'user', 'adm-Ze2', 'Alain2', 'adm', 'BRED', ''),
('aze3', 'c6faf72572ce634d34f0011f6341112e563c4d29', 'user', 'adm-Ze3', 'Alain3', 'adm', 'BRED', ''),
('chr', 'c6faf72572ce634d34f0011f6341112e563c4d29', 'user', 'MAREAU', 'christian', 'cma', 'SFR', 'christian.mareau@gmail.com'),
('chr1', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'user', 'cma-dupont1', 'Charles1', 'cma', 'SFR', ''),
('chr2', 'c6faf72572ce634d34f0011f6341112e563c4d29', 'user', 'cma-dupont2', 'Charles2', 'cma', 'SFR', ''),
('chr3', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'user', 'cma-dupont3', 'Charles3', 'cma', 'SFR', ''),
('cma', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin', 'Mareau', 'Christian', 'cma', NULL, NULL),
('cma1', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin', 'Mareau1', 'Christian1', 'cma1', NULL, NULL),
('cma2', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin', 'Mareau2', 'Christian2', 'cma2', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `answer`
--

DROP TABLE IF EXISTS `answer`;
CREATE TABLE IF NOT EXISTS `answer` (
  `answer_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `answer_answer` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `answer_ok` tinyint NOT NULL DEFAULT '0',
  `answer_status` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'draft',
  `answer_creationdate` bigint NOT NULL DEFAULT '0',
  `answer_lastmodificationdate` bigint NOT NULL DEFAULT '0',
  `answer_idquestion` int UNSIGNED NOT NULL,
  PRIMARY KEY (`answer_id`),
  KEY `CIR_DELETE_QUESTION_ANSWER` (`answer_idquestion`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `answer`
--

INSERT INTO `answer` (`answer_id`, `answer_answer`, `answer_ok`, `answer_status`, `answer_creationdate`, `answer_lastmodificationdate`, `answer_idquestion`) VALUES
(47, 'Un marin', 0, 'draft', 1681745244, 1682010344, 62),
(48, 'Une application cliente', 1, 'inline', 1681745244, 1681745244, 62),
(49, 'Un serveur web', 0, 'inline', 1681745244, 1681807759, 62),
(50, 'Le moteur d’un navire de pêche industrielle', 0, 'inline', 1681745413, 1681745413, 63),
(51, 'Un serveur web qui cherche des sites web sur la base de mots clés', 1, 'inline', 1681745413, 1681745413, 63),
(52, 'Une partie du navigateur', 0, 'inline', 1681745413, 1681745413, 63),
(53, 'Une partie', 0, 'inline', 1681745923, 1681745923, 64),
(54, 'Deux parties', 0, 'inline', 1681745923, 1681745923, 64),
(55, 'Trois parties', 1, 'inline', 1681745923, 1681745923, 64),
(56, 'Sécurisé', 1, 'inline', 1681746227, 1681746227, 65),
(57, 'Sensible', 0, 'inline', 1681746227, 1681746227, 65),
(58, 'Style', 0, 'inline', 1681746227, 1681746227, 65),
(59, 'Système des noms de domaine', 1, 'inline', 1681746788, 1681746788, 66),
(60, 'Société des noms de domaine', 0, 'inline', 1681746788, 1681746788, 66),
(61, 'Acide dinitrosalicylique', 1, 'inline', 1681746788, 1681746788, 66),
(62, 'Un protocole', 1, 'inline', 1681746960, 1681746960, 67),
(63, 'Un langage', 0, 'inline', 1681746960, 1681746960, 67),
(64, 'Un serveur spécialisé', 0, 'inline', 1681746960, 1681746960, 67),
(65, 'Un style d’affichage', 1, 'inline', 1681747231, 1681747231, 68),
(66, 'Un type de page', 0, 'inline', 1681747231, 1681747231, 68),
(67, 'Un type d’utilisateur', 0, 'inline', 1681747231, 1681747231, 68),
(68, 'Réponse1.1', 1, 'inline', 1681752567, 1681752567, 69),
(69, 'Réponse1.2', 0, 'inline', 1681752567, 1681752567, 69),
(70, 'Réponse1.3', 0, 'inline', 1681752567, 1681752567, 69),
(71, 'Réponse1.4', 0, 'draft', 1681752567, 1681752567, 69),
(72, 'Réponse 2.1', 1, 'inline', 1681752787, 1681752787, 70),
(73, 'Réponse 2.2', 1, 'inline', 1681752787, 1681752787, 70),
(74, 'Réponse 2.3', 0, 'inline', 1681752787, 1681752787, 70),
(75, 'Réponse3.1', 1, 'inline', 1681754942, 1681754942, 71),
(76, 'Réponse3.2', 0, 'inline', 1681754942, 1681754942, 71),
(77, 'Réponse3.3', 0, 'inline', 1681754942, 1681754942, 71),
(78, 'Réponse4.1', 1, 'inline', 1681755427, 1681755427, 72),
(79, 'Réponse4.2', 0, 'inline', 1681755427, 1681755427, 72),
(80, 'Réponse4.3', 0, 'inline', 1681755427, 1681755427, 72),
(81, 'Réponse5.1', 1, 'inline', 1681755535, 1681755535, 73),
(82, 'Réponse5.2', 1, 'inline', 1681755535, 1681755535, 73),
(83, 'Réponse6.1', 1, 'inline', 1681755635, 1681755635, 74),
(84, 'Réponse6.2', 0, 'inline', 1681755635, 1681755635, 74),
(85, 'Réponse6.3', 0, 'inline', 1681755635, 1681755635, 74),
(86, 'Réponse6.4', 0, 'inline', 1681755635, 1681755635, 74),
(87, 'Réponse6.5', 0, 'inline', 1681755635, 1681755635, 74),
(88, 'Réponse7.1', 1, 'inline', 1681755793, 1681755793, 75),
(89, 'Réponse7.2', 0, 'inline', 1681755793, 1681755793, 75),
(90, 'Réponse7.3', 0, 'inline', 1681755793, 1681755793, 75);

-- --------------------------------------------------------

--
-- Structure de la table `keyword`
--

DROP TABLE IF EXISTS `keyword`;
CREATE TABLE IF NOT EXISTS `keyword` (
  `keyword_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `keyword_loginadmin` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `keyword_word` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`keyword_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `keyword`
--

INSERT INTO `keyword` (`keyword_id`, `keyword_loginadmin`, `keyword_word`) VALUES
(10, 'cma', 'internet'),
(11, 'cma', 'CG'),
(12, 'adm', 'MC1'),
(13, 'adm', 'MC2'),
(14, 'adm', 'MC3'),
(15, 'cma', 'Littérature');

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `question_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `question_question` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `question_guideline` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `question_explanationtitle` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `question_explanation` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `question_status` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'draft',
  `question_creationdate` bigint NOT NULL,
  `question_lastmodificationdate` bigint NOT NULL DEFAULT '0',
  `question_idwidget` varchar(15) NOT NULL,
  `question_loginadmin` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `question_motherquest` int UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`question_id`, `question_question`, `question_guideline`, `question_explanationtitle`, `question_explanation`, `question_status`, `question_creationdate`, `question_lastmodificationdate`, `question_idwidget`, `question_loginadmin`, `question_motherquest`) VALUES
(62, 'Un navigateur web est :', '', 'Installé sur le poste client', 'Lequel utilisez-vous pour naviguer sur internet ?', 'inline', 1681745244, 1681745244, 'radio', 'cma', 0),
(63, 'Un moteur de recherche est :', '', 'Ton ami', 'Pour vous servir.', 'inline', 1681745413, 1681807699, 'radio', 'cma', 0),
(64, 'L\'URL d\'une page web est composée de :', '', 'Autant de parties qu\'il y a de lettres dans URL', 'Moyen mnémotechnique : URL = Uniform Resource Locator. Uniforme comme un protocole d\'accès, Ressource du domaine, Localisé comme une page numérotée.', 'inline', 1681745923, 1681807601, 'radio', 'cma', 0),
(65, 'Le « s » de https signifie :', '', 'Comme dans CRS', 'Vous êtes sensible et ne manquez pas de style mais restez sur vos gardes.', 'inline', 1681746227, 1681807514, 'radio', 'cma', 0),
(66, 'DNS signifie :', '', 'Révisez votre anglais', 'Domain Name : compte tenu de l\'ordre des mots, c\'est clairement de l\'anglais, et en anglais, société se dit Company ! Quant à l\'acide, il tire son nom du saule (salix en latin).', 'inline', 1681746788, 1681831002, 'checkbox', 'cma', 0),
(67, 'HTTP est :', '', 'Avec un P comme Protocole', 'Ne confondez pas avec le langage HTML avec un L comme Langage', 'inline', 1681746960, 1682280237, 'radio', 'cma', 0),
(68, 'CSS permet de préciser :', '', '', 'Deux S et vous êtes passé à côté du style ! ', 'inline', 1681747231, 1681807368, 'checkbox', 'cma', 0),
(69, 'Question 1', '', 'Titre explication 1', 'Explication 1', 'inline', 1681752567, 1681752567, 'radio', 'adm', 0),
(70, 'Question 2', 'Instruction 2', 'Titre des explications 2', 'Explications 2', 'inline', 1681752787, 1681752787, 'checkbox', 'adm', 0),
(71, 'Question 3', '', 'Titre des explications 3', 'Explications 3', 'inline', 1681754942, 1681754942, 'radio', 'adm', 0),
(72, 'Question 4', '', '', '', 'inline', 1681755427, 1681755427, 'radio', 'adm', 0),
(73, 'Question 5', '', '', '', 'inline', 1681755535, 1681755535, 'checkbox', 'adm', 0),
(74, 'Question 6', '', '', '', 'inline', 1681755635, 1681755635, 'radio', 'adm', 0),
(75, 'Question 7', '', '', '', 'inline', 1681755793, 1681755793, 'radio', 'adm', 0),
(76, 'question test', '', '', '', 'inline', 1682284044, 1682284044, 'radio', 'cma', 0);

-- --------------------------------------------------------

--
-- Structure de la table `questionstat`
--

DROP TABLE IF EXISTS `questionstat`;
CREATE TABLE IF NOT EXISTS `questionstat` (
  `questionstat_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `questionstat_idquestion` int UNSIGNED NOT NULL,
  `questionstat_ok` smallint NOT NULL,
  `questionstat_idwidget` varchar(15) NOT NULL,
  `questionstat_date` bigint NOT NULL,
  `questionstat_idquiz` int UNSIGNED DEFAULT NULL,
  `questionstat_quiztitle` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `questionstat_loginadmin` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`questionstat_id`),
  KEY `CIR_DELETE_QUESTION_QUESTIONSTATSWER` (`questionstat_idquestion`)
) ENGINE=InnoDB AUTO_INCREMENT=327 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `questionstat`
--

INSERT INTO `questionstat` (`questionstat_id`, `questionstat_idquestion`, `questionstat_ok`, `questionstat_idwidget`, `questionstat_date`, `questionstat_idquiz`, `questionstat_quiztitle`, `questionstat_loginadmin`) VALUES
(262, 63, 1, 'radio', 1681803805, 21, 'Recherche internet', 'cma'),
(263, 67, 1, 'radio', 1681803805, 21, 'Recherche internet', 'cma'),
(264, 62, 1, 'radio', 1681803805, 21, 'Recherche internet', 'cma'),
(265, 66, 0, 'checkbox', 1681803805, 21, 'Recherche internet', 'cma'),
(266, 64, 0, 'radio', 1681803805, 21, 'Recherche internet', 'cma'),
(267, 68, 0, 'checkbox', 1681806733, 21, 'Recherche internet', 'cma'),
(268, 63, 0, 'radio', 1681806733, 21, 'Recherche internet', 'cma'),
(269, 64, 0, 'radio', 1681806733, 21, 'Recherche internet', 'cma'),
(270, 65, 0, 'radio', 1681806733, 21, 'Recherche internet', 'cma'),
(271, 66, 0, 'checkbox', 1681806733, 21, 'Recherche internet', 'cma'),
(272, 62, 0, 'radio', 1681806733, 21, 'Recherche internet', 'cma'),
(273, 67, 0, 'radio', 1681806733, 21, 'Recherche internet', 'cma'),
(274, 62, 1, 'radio', 1681808376, 21, 'Recherche internet', 'cma'),
(275, 66, 0, 'checkbox', 1681808376, 21, 'Recherche internet', 'cma'),
(276, 68, 0, 'checkbox', 1681808376, 21, 'Recherche internet', 'cma'),
(277, 65, 0, 'radio', 1681808376, 21, 'Recherche internet', 'cma'),
(278, 67, 0, 'radio', 1681808376, 21, 'Recherche internet', 'cma'),
(279, 64, 0, 'radio', 1681808376, 21, 'Recherche internet', 'cma'),
(280, 63, 0, 'radio', 1681808376, 21, 'Recherche internet', 'cma'),
(281, 65, 0, 'radio', 1681808612, 21, 'Recherche internet', 'cma'),
(282, 64, 0, 'radio', 1681808612, 21, 'Recherche internet', 'cma'),
(283, 63, 0, 'radio', 1681808612, 21, 'Recherche internet', 'cma'),
(284, 62, 0, 'radio', 1681808612, 21, 'Recherche internet', 'cma'),
(285, 68, 0, 'checkbox', 1681808612, 21, 'Recherche internet', 'cma'),
(286, 67, 0, 'radio', 1681808612, 21, 'Recherche internet', 'cma'),
(287, 66, 0, 'checkbox', 1681808612, 21, 'Recherche internet', 'cma'),
(288, 63, 1, 'radio', 1681808800, 21, 'Recherche internet', 'cma'),
(289, 65, 0, 'radio', 1681808800, 21, 'Recherche internet', 'cma'),
(290, 64, 0, 'radio', 1681808800, 21, 'Recherche internet', 'cma'),
(291, 62, 0, 'radio', 1681808800, 21, 'Recherche internet', 'cma'),
(292, 68, 0, 'checkbox', 1681808800, 21, 'Recherche internet', 'cma'),
(293, 67, 0, 'radio', 1681808800, 21, 'Recherche internet', 'cma'),
(294, 66, 0, 'checkbox', 1681808800, 21, 'Recherche internet', 'cma'),
(295, 67, 1, 'radio', 1681827457, 21, 'Recherche internet', 'cma'),
(296, 65, 1, 'radio', 1681827457, 21, 'Recherche internet', 'cma'),
(297, 63, 0, 'radio', 1681827457, 21, 'Recherche internet', 'cma'),
(298, 64, 0, 'radio', 1681827457, 21, 'Recherche internet', 'cma'),
(299, 62, 1, 'radio', 1681827457, 21, 'Recherche internet', 'cma'),
(300, 66, 0, 'checkbox', 1681827457, 21, 'Recherche internet', 'cma'),
(301, 64, 1, 'radio', 1681831518, 21, 'Recherche internet', 'cma'),
(302, 63, 0, 'radio', 1681831518, 21, 'Recherche internet', 'cma'),
(303, 65, 0, 'radio', 1681831518, 21, 'Recherche internet', 'cma'),
(304, 67, 1, 'radio', 1681831518, 21, 'Recherche internet', 'cma'),
(305, 62, 1, 'radio', 1681831518, 21, 'Recherche internet', 'cma'),
(306, 68, 1, 'checkbox', 1681831518, 21, 'Recherche internet', 'cma'),
(307, 62, 1, 'radio', 1682362102, 21, 'Recherche internet', 'cma'),
(308, 63, 1, 'radio', 1682362102, 21, 'Recherche internet', 'cma'),
(309, 64, 0, 'radio', 1682362102, 21, 'Recherche internet', 'cma'),
(310, 67, 1, 'radio', 1682362102, 21, 'Recherche internet', 'cma'),
(311, 65, 0, 'radio', 1682362102, 21, 'Recherche internet', 'cma'),
(312, 66, 1, 'checkbox', 1682362102, 21, 'Recherche internet', 'cma'),
(313, 68, 0, 'checkbox', 1682362102, 21, 'Recherche internet', 'cma'),
(314, 67, 0, 'radio', 1682430332, 21, 'Recherche internet', 'cma'),
(315, 62, 1, 'radio', 1682430332, 21, 'Recherche internet', 'cma'),
(316, 63, 1, 'radio', 1682430332, 21, 'Recherche internet', 'cma'),
(317, 65, 0, 'radio', 1682430332, 21, 'Recherche internet', 'cma'),
(318, 64, 1, 'radio', 1682430332, 21, 'Recherche internet', 'cma'),
(319, 66, 1, 'checkbox', 1682430332, 21, 'Recherche internet', 'cma'),
(320, 68, 1, 'checkbox', 1682430332, 21, 'Recherche internet', 'cma'),
(321, 63, 1, 'radio', 1682580075, 21, 'Recherche internet', 'cma'),
(322, 65, 1, 'radio', 1682580075, 21, 'Recherche internet', 'cma'),
(323, 64, 1, 'radio', 1682580075, 21, 'Recherche internet', 'cma'),
(324, 67, 0, 'radio', 1682580075, 21, 'Recherche internet', 'cma'),
(325, 62, 1, 'radio', 1682580075, 21, 'Recherche internet', 'cma'),
(326, 66, 0, 'checkbox', 1682580075, 21, 'Recherche internet', 'cma');

-- --------------------------------------------------------

--
-- Structure de la table `question_keyword`
--

DROP TABLE IF EXISTS `question_keyword`;
CREATE TABLE IF NOT EXISTS `question_keyword` (
  `question_keyword_idquestion` int UNSIGNED NOT NULL,
  `question_keyword_idkeyword` int UNSIGNED NOT NULL,
  PRIMARY KEY (`question_keyword_idquestion`,`question_keyword_idkeyword`),
  KEY `CIR_DELETE_KEYWORD_QUESTION` (`question_keyword_idkeyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `question_keyword`
--

INSERT INTO `question_keyword` (`question_keyword_idquestion`, `question_keyword_idkeyword`) VALUES
(62, 10),
(63, 10),
(64, 10),
(65, 10),
(66, 10),
(67, 10),
(68, 10),
(62, 11),
(63, 11),
(69, 12),
(70, 12),
(71, 12),
(72, 12),
(73, 12),
(74, 12),
(75, 12),
(70, 13),
(71, 13),
(73, 13),
(74, 13),
(71, 14),
(74, 14);

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
  `quiz_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `quiz_title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `quiz_subtitle` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `quiz_status` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'draft',
  `quiz_creationdate` bigint NOT NULL,
  `quiz_lastmodificationdate` bigint NOT NULL DEFAULT '0',
  `quiz_loginadmin` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`quiz_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `quiz`
--

INSERT INTO `quiz` (`quiz_id`, `quiz_title`, `quiz_subtitle`, `quiz_status`, `quiz_creationdate`, `quiz_lastmodificationdate`, `quiz_loginadmin`) VALUES
(21, 'Recherche internet', 'Terminologie', 'inline', 1681747444, 1681747444, 'cma'),
(22, 'Quiz 1', 'Sous-titre Quiz 1', 'inline', 1681755986, 1681755986, 'adm'),
(23, 'Quiz 2', '', 'inline', 1681759040, 1681759040, 'adm'),
(24, 'Culture générale', '', 'inline', 1682147486, 1682147486, 'cma');

-- --------------------------------------------------------

--
-- Structure de la table `quizlock`
--

DROP TABLE IF EXISTS `quizlock`;
CREATE TABLE IF NOT EXISTS `quizlock` (
  `quizlock_user` varchar(50) NOT NULL,
  `quizlock_sessionid` int UNSIGNED NOT NULL,
  `quizlock_quizid` int UNSIGNED NOT NULL,
  `quizlock_datetime` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`quizlock_user`,`quizlock_quizid`),
  KEY `CIR_DELETE_QUIZ_QUIZLOCK` (`quizlock_quizid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `quizlock`
--

INSERT INTO `quizlock` (`quizlock_user`, `quizlock_sessionid`, `quizlock_quizid`, `quizlock_datetime`) VALUES
('chr1', 12, 21, 1682579865);

-- --------------------------------------------------------

--
-- Structure de la table `quizresult`
--

DROP TABLE IF EXISTS `quizresult`;
CREATE TABLE IF NOT EXISTS `quizresult` (
  `quizresult_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `quizresult_sessiontitle` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `quizresult_sessionsubtitle` varchar(50) DEFAULT NULL,
  `quizresult_quiztitle` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `quizresult_quizsubtitle` varchar(100) DEFAULT NULL,
  `quizresult_firstnameadmin` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `quizresult_loginadmin` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `quizresult_nameadmin` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `quizresult_startdate` bigint NOT NULL,
  `quizresult_enddate` bigint NOT NULL DEFAULT '0',
  `quizresult_maxduration` smallint UNSIGNED NOT NULL DEFAULT '0',
  `quizresult_nbquestasked` smallint UNSIGNED NOT NULL DEFAULT '0',
  `quizresult_maxnbquest` smallint UNSIGNED NOT NULL DEFAULT '0',
  `quizresult_questaskedscore` smallint NOT NULL DEFAULT '0',
  `quizresult_maxquestaskedscore` smallint NOT NULL DEFAULT '0',
  `quizresult_maxscore` smallint NOT NULL DEFAULT '0',
  `quizresult_loginuser` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `quizresult_idsession` int UNSIGNED DEFAULT NULL,
  `quizresult_idquiz` int UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`quizresult_id`),
  KEY `CIR_DELETE_ACCOUNT_QUIZRESULT` (`quizresult_loginuser`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `quizresult`
--

INSERT INTO `quizresult` (`quizresult_id`, `quizresult_sessiontitle`, `quizresult_sessionsubtitle`, `quizresult_quiztitle`, `quizresult_quizsubtitle`, `quizresult_firstnameadmin`, `quizresult_loginadmin`, `quizresult_nameadmin`, `quizresult_startdate`, `quizresult_enddate`, `quizresult_maxduration`, `quizresult_nbquestasked`, `quizresult_maxnbquest`, `quizresult_questaskedscore`, `quizresult_maxquestaskedscore`, `quizresult_maxscore`, `quizresult_loginuser`, `quizresult_idsession`, `quizresult_idquiz`) VALUES
(137, 'Internet', NULL, 'Recherche internet', NULL, '', NULL, '', 1682579867, 1682580075, 3, 6, 7, 6, 9, 10, 'chr1', 12, 21);

-- --------------------------------------------------------

--
-- Structure de la table `quizresult_questionko`
--

DROP TABLE IF EXISTS `quizresult_questionko`;
CREATE TABLE IF NOT EXISTS `quizresult_questionko` (
  `quizresult_questionko_idquizresult` int UNSIGNED NOT NULL,
  `quizresult_questionko_idquestion` int UNSIGNED NOT NULL,
  PRIMARY KEY (`quizresult_questionko_idquizresult`,`quizresult_questionko_idquestion`),
  KEY `CIR_DELETE_QUESTION_QUIZRESULT-QUESTIONKO` (`quizresult_questionko_idquestion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `quizresult_questionko`
--

INSERT INTO `quizresult_questionko` (`quizresult_questionko_idquizresult`, `quizresult_questionko_idquestion`) VALUES
(137, 66),
(137, 67);

-- --------------------------------------------------------

--
-- Structure de la table `quiz_question`
--

DROP TABLE IF EXISTS `quiz_question`;
CREATE TABLE IF NOT EXISTS `quiz_question` (
  `quiz_question_idquiz` int UNSIGNED NOT NULL,
  `quiz_question_idquestion` int UNSIGNED NOT NULL,
  `quiz_question_weight` smallint NOT NULL DEFAULT '1',
  `quiz_question_numorder` smallint NOT NULL DEFAULT '0',
  PRIMARY KEY (`quiz_question_idquiz`,`quiz_question_idquestion`),
  KEY `CIR_DELETE_QUESTION_QUIZ-QUESTION` (`quiz_question_idquestion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `quiz_question`
--

INSERT INTO `quiz_question` (`quiz_question_idquiz`, `quiz_question_idquestion`, `quiz_question_weight`, `quiz_question_numorder`) VALUES
(21, 62, 1, 0),
(21, 63, 1, 0),
(21, 64, 2, 0),
(21, 65, 2, 0),
(21, 66, 1, 1),
(21, 67, 2, 0),
(21, 68, 1, 1),
(22, 70, 2, 0),
(22, 71, 3, 1),
(22, 73, 1, 2),
(22, 74, 1, 3),
(23, 69, 1, 0),
(23, 70, 1, 0),
(23, 72, 1, 0),
(23, 75, 1, 0),
(24, 68, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `session_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `session_title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `session_subtitle` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `session_startdate` bigint UNSIGNED NOT NULL DEFAULT '0',
  `session_enddate` bigint UNSIGNED NOT NULL DEFAULT '0',
  `session_loginadmin` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `session_logolocation` varchar(50) DEFAULT NULL,
  `session_bgimagelocation` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `session`
--

INSERT INTO `session` (`session_id`, `session_title`, `session_subtitle`, `session_startdate`, `session_enddate`, `session_loginadmin`, `session_logolocation`, `session_bgimagelocation`) VALUES
(9, 'adm-session1', 'un jour passé', 1681689600, 1681776000, 'adm', NULL, NULL),
(10, 'adm-session2', 'passé/futur', 1681689600, 1713312000, 'adm', '', ''),
(11, 'adm-session3', 'passé/futur', 1681689600, 1744848000, 'adm', '', ''),
(12, 'Internet', 'Les acteurs', 1681689600, 1713312000, 'cma', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `session_quiz`
--

DROP TABLE IF EXISTS `session_quiz`;
CREATE TABLE IF NOT EXISTS `session_quiz` (
  `session_quiz_idquiz` int UNSIGNED NOT NULL,
  `session_quiz_idsession` int UNSIGNED NOT NULL,
  `session_quiz_openingdate` bigint NOT NULL DEFAULT '0',
  `session_quiz_closingdate` bigint NOT NULL DEFAULT '0',
  `session_quiz_minutesduration` smallint UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_quiz_idsession`,`session_quiz_idquiz`),
  KEY `CIR_DELETE_QUIZ_SESSION-QUIZ-QUESTION` (`session_quiz_idquiz`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `session_quiz`
--

INSERT INTO `session_quiz` (`session_quiz_idquiz`, `session_quiz_idsession`, `session_quiz_openingdate`, `session_quiz_closingdate`, `session_quiz_minutesduration`) VALUES
(22, 10, 1681763880, 1713386280, 1),
(22, 11, 1681765860, 1713388260, 1),
(23, 11, 1681766280, 1713388680, 1),
(21, 12, 1681754820, 1713377220, 3);

-- --------------------------------------------------------

--
-- Structure de la table `session_user`
--

DROP TABLE IF EXISTS `session_user`;
CREATE TABLE IF NOT EXISTS `session_user` (
  `session_user_idsession` int UNSIGNED NOT NULL,
  `session_user_loginuser` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`session_user_idsession`,`session_user_loginuser`),
  KEY `CIR_DELETE_ACCOUNT_SESSION-USER` (`session_user_loginuser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `session_user`
--

INSERT INTO `session_user` (`session_user_idsession`, `session_user_loginuser`) VALUES
(10, 'aze2'),
(11, 'aze2'),
(11, 'aze3'),
(12, 'chr1'),
(12, 'chr2'),
(12, 'chr3');

-- --------------------------------------------------------

--
-- Structure de la table `widget`
--

DROP TABLE IF EXISTS `widget`;
CREATE TABLE IF NOT EXISTS `widget` (
  `widget_id` varchar(15) NOT NULL,
  `widget_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`widget_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `widget`
--

INSERT INTO `widget` (`widget_id`, `widget_name`) VALUES
('checkbox', 'boîte à cocher'),
('radio', 'radio bouton');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `CIR_DELETE_QUESTION_ANSWER` FOREIGN KEY (`answer_idquestion`) REFERENCES `question` (`question_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `questionstat`
--
ALTER TABLE `questionstat`
  ADD CONSTRAINT `CIR_DELETE_QUESTION_QUESTIONSTAT` FOREIGN KEY (`questionstat_idquestion`) REFERENCES `question` (`question_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `question_keyword`
--
ALTER TABLE `question_keyword`
  ADD CONSTRAINT `CIR_DELETE_KEYWORD_QUESTION-KEYWORD` FOREIGN KEY (`question_keyword_idkeyword`) REFERENCES `keyword` (`keyword_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `CIR_DELETE_QUESTION_QUESTION-KEYWORD` FOREIGN KEY (`question_keyword_idquestion`) REFERENCES `question` (`question_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `quizlock`
--
ALTER TABLE `quizlock`
  ADD CONSTRAINT `CIR_DELETE_ACCOUNT_QUIZLOCK` FOREIGN KEY (`quizlock_user`) REFERENCES `account` (`account_login`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `CIR_DELETE_QUIZ_QUIZLOCK` FOREIGN KEY (`quizlock_quizid`) REFERENCES `quiz` (`quiz_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `quizresult`
--
ALTER TABLE `quizresult`
  ADD CONSTRAINT `CIR_DELETE_ACCOUNT_QUIZRESULT` FOREIGN KEY (`quizresult_loginuser`) REFERENCES `account` (`account_login`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `quizresult_questionko`
--
ALTER TABLE `quizresult_questionko`
  ADD CONSTRAINT `CIR_DELETE_QUESTION_QUIZRESULT-QUESTIONKO` FOREIGN KEY (`quizresult_questionko_idquestion`) REFERENCES `question` (`question_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `CIR_DELETE_QUIZRESULT_QUIZRESULT-QUESTIONKO` FOREIGN KEY (`quizresult_questionko_idquizresult`) REFERENCES `quizresult` (`quizresult_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD CONSTRAINT `CIR_DELETE_QUESTION_QUIZ-QUESTION` FOREIGN KEY (`quiz_question_idquestion`) REFERENCES `question` (`question_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `CIR_DELETE_QUIZ_QUIZ-QUESTION` FOREIGN KEY (`quiz_question_idquiz`) REFERENCES `quiz` (`quiz_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `session_quiz`
--
ALTER TABLE `session_quiz`
  ADD CONSTRAINT `CIR_DELETE_QUIZ_SESSION-QUIZ-QUESTION` FOREIGN KEY (`session_quiz_idquiz`) REFERENCES `quiz` (`quiz_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `CIR_DELETE_SESSION_SESSION-QUIZ` FOREIGN KEY (`session_quiz_idsession`) REFERENCES `session` (`session_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `session_user`
--
ALTER TABLE `session_user`
  ADD CONSTRAINT `CIR_DELETE_ACCOUNT_SESSION-USER` FOREIGN KEY (`session_user_loginuser`) REFERENCES `account` (`account_login`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `CIR_DELETE_SESSION_SESSION-USER` FOREIGN KEY (`session_user_idsession`) REFERENCES `session` (`session_id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
