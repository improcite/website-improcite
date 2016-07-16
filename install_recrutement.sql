-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Sam 16 Juillet 2016 à 18:56
-- Version du serveur :  5.5.42
-- Version de PHP :  5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `improcite`
--

-- --------------------------------------------------------

--
-- Structure de la table `impro_comediens`
--

DROP TABLE IF EXISTS `impro_comediens`;
CREATE TABLE `impro_comediens` (
  `id` int(11) NOT NULL,
  `login` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `surnom` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `prenom` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nom` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `jour` smallint(6) NOT NULL DEFAULT '0',
  `mois` smallint(6) NOT NULL DEFAULT '0',
  `annee` smallint(6) NOT NULL DEFAULT '0',
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `portable` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `adresse` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `qualite` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `defaut` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `debut` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `debutimprocite` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `envie` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `apport` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `improcite` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `saison` smallint(10) NOT NULL DEFAULT '0',
  `affichernom` int(11) DEFAULT '0',
  `rights` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `notif_email` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `impro_comediens`
--
ALTER TABLE `impro_comediens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `impro_comediens`
--
ALTER TABLE `impro_comediens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;