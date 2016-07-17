-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Dim 17 Juillet 2016 à 17:19
-- Version du serveur :  5.5.42
-- Version de PHP :  5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `improcite`
--

-- --------------------------------------------------------

--
-- Structure de la table `impro_recrutement`
--

DROP TABLE IF EXISTS `impro_recrutement`;
CREATE TABLE `impro_recrutement` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `datenaissance` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adresse` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `source` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `experience` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `envie` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `disponibilite` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `selection` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `impro_recrutement`
--
ALTER TABLE `impro_recrutement`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `impro_recrutement`
--
ALTER TABLE `impro_recrutement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
