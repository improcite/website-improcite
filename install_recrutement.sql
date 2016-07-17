-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Client :  improcite.mysql.db
-- Généré le :  Dim 17 Juillet 2016 à 17:17
-- Version du serveur :  5.5.46-0+deb7u1-log
-- Version de PHP :  5.4.45-0+deb7u4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `improcite`
--

-- --------------------------------------------------------

--
-- Structure de la table `impro_comediens`
--

CREATE TABLE IF NOT EXISTS `impro_comediens` (
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
) ENGINE=MyISAM AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `impro_comediens`
--

INSERT INTO `impro_comediens` (`id`, `login`, `password`, `surnom`, `prenom`, `nom`, `jour`, `mois`, `annee`, `email`, `portable`, `adresse`, `qualite`, `defaut`, `debut`, `debutimprocite`, `envie`, `apport`, `improcite`, `saison`, `affichernom`, `rights`, `notif_email`) VALUES
(73, 'alexandre', 'qsdfgh', '', 'Alexandre', 'Delorme', 4, 12, 1981, 'happyalexandre@hotmail.com', '0648173042', '30 GRANDE RUE DE LA GUILLOTIERE 69007 LYON', '', '', '', '', '', '', '', 384, 0, 'selection', 1),
(74, 'mathieu', 'mathieu', 'Pemouche', 'Mathieu', 'Frémont', 7, 2, 1979, 'matfrem@gmail.com', '0623032083', '57 Rue Sergent Michel Berthet\r\n69009 Lyon', 'Je fais super bien l''accent québecois', 'Il y a souvent trop de québecois dans mes impros', 'Difficiles, après quelques années de théâtre', 'Il y a quelques années. Mon premier entrainement, j''ai du mimer le furoncle. Mémorable.', 'Après quelques années de théâtre et d''apprentissage par coeur de répliques, j''ai décidé que trouver quoi dire en live pourrait être vraiment plus sympa !', 'Détente, lacher prise, et une bonne dose de rigolade', 'C''est une troupe, c''est une asso, c''est un groupe de potes. C''est fou !', 1948, 0, 'admin;selection', 1),
(3, 'clement', 'improcite69', 'KPTN', 'Clément', 'OUDOT', 20, 8, 1980, 'clem.oudot@gmail.com', '06 60 73 38 58', '18 rue Gabillot, 69003 LYON\r\n2ème étage / Code ascenseur 1869 ', 'Je sais faire l''accent français', 'Je ne sais faire que l''accent français', 'Au club impro de l''INT (Evry) en 2001', 'En 2004, je suis enfermé dedans depuis', 'Ça semblait plus simple que la chute libre', 'Mes enfants apprécient que je puisse faire mes blagues ailleurs qu''à la maison. Ma femme également.', 'Tagada tsouin tsouin', 4095, 0, 'admin;selection', 1),
(4, 'francois', 'compteferme', '', 'François', 'Bourdel', 1, 6, 1981, 'bourdel@gmail.com', '06 76 95 67 63', '231, rue Vendôme 69003 Lyon', 'justesse des émotions', 'peut construire moins vite qu''un calmant ayant avalé un paresseux', 'Saison 2003/2004 dans le club d''Impro de Télécom Paristech', '2008', 'J''ai commencé par curiosité. J''ai vite accroché avec le groupe et l''idée de jouer 10 personnages différents en une soirée.', 'Du plaisir... à base de défoulement, d''amitié et d''une part de mystère (c''est toujours bluffant de voir comment 2 individus se rencontrent et montent une histoire qu''aucun d''eux n''aurait pu prévoir avant)', 'Ne pas être sérieux en se prenant au sérieux', 112, 0, 'selection;admin', 1),
(5, 'audrey', 'audrey', 'Maïté', 'Audrey', 'Astuto', 16, 1, 1979, 'astuto.audrey@free.fr', '0619468372', '01, rue du Mail 69004 Lyon', 'Mes racines du terroir profond...et les sentiments tout aussi profonds!', 'Trop modeste par rapport à mon immense talent...sans parler de mon charisme!', 'Il y a bien longtemps...à l''époque je me déplaçais à dos de mammouth!', 'en 2008', 'Par mon talent naturel déjà immense!', 'La gloire!', 'Vive la famille (sans moi ils ne sont rien...)!', 3056, 0, '', 1),
(7, 'marie', 'compteferme', 'Marie', 'Marie', 'Cuenot', 19, 4, 1986, 'marieqno@yahoo.fr', '06 03 40 74 09', '27 rue des charmettes 69100 villeurbanne', 'Mon energie... (quand j''ai envie!!)', 'Un manque cruel de concentration!', 'Je debute à la LUDI FC de Besancon, poursuis avec l''AIA d''Antibes pour atterir ensuite à Lyon', 'sept 2009', 'Je n''ai jamais eut envie d''en faire...!! J''ai commencé avant même de savoir en quoi cela consistait...', 'Mais tout mon ami!!', 'Dynamisme, motiv'', belle année en perspective!', 96, 0, '', 1),
(10, 'nicolaspelay', 'wayne', 'Piou', 'Nicolas P', 'Pelay', 2, 10, 1980, 'nico.impro@gmail.com', '06 30 35 71 98', '96ter, cours Emile Zola 69100 Villeurbanne', 'ne pas avoir de limite et être en énergie !', 'ne pas avoir de limite et être en énergie !', 'Le jour de ma naissance serait une réponse pas si éloignée de la vérité, mais si l''on y entend improvisation théâtrale, mes premiers pas remontent à 2003 du côté de Besançon.', '12 septembre 2009,19h12', 'Cela remonte à une soirée d''automne où mes parents m''ont amené à un spectacle d''improvisation, avec la patinoire, les joueurs de hockey, les chaussettes à jeter sur les comédiens,etc...Réaction immédiate: "C''est trop cool, je veux faire ça!"', 'Du lâcher prise et des voyages dans des délires et des imaginaires!\r\n', 'l''esprit de groupe,c''est nous ou c''est pas nous?', 96, 0, '', 1),
(11, 'valerie', 'valerie', '', 'Valérie', 'Vigoureux', 6, 8, 1970, 'valerie.vigoureux@axa.fr', '06 99 41 24 76 ', '5 rue Aynes 69100 Villeurbanne', '', '', '', '0', '', '', '', 224, 0, 'selection', 1),
(62, 'louise', 'compteferme', 'Louise', 'Louise', 'Broyer', 5, 4, 1975, 'sofibroyer@yahoo.fr', '0685742326', '296, rue Vendôme 69003 Lyon', 'Malice (une chipie quoi!)', 'Chipie (mais malicieuse!)', 'Et cie pendant deux ans en tant qu''élève', 'En vélo !', 'Grâce à la TIR (Troupe d''Impro de Rennes) ', 'Tous les autres mondes', 'C''est nous!', 64, 0, '', 1),
(63, 'nicolasbouquand', 'compteferme', '', 'Nicolas B', 'Bouquand', 5, 6, 1973, '', '', '', 'Cabo, tiens!', 'Ben Cabo mais assumé!', '3 years ago (Et Cie, Arts en Scène)', 'Discrète ', 'Mon médecin me l''a prescrit', 'Du plaisir et le maintien en liberté', 'La classe!', 64, 0, '', 1),
(64, 'pierric', 'pierric', 'Pierrot', 'Pierric', 'Tabouret', 7, 8, 1982, 'chezpierric@hotmail.fr', '0672758015', '21 rue du Bourbonnais 69009 LYON', 'Dynamique dans le jeu... un peu trop des fois...', 'Lacher prise...bordel !', '2008 avec Impro&Compagnie', '2010', '', 'Des moments incontrolés, des rencontres et une bonne humeur !', 'Une équipe de copains qui se retrouve pour passer un bon moment.', 192, 0, 'noselect', 1),
(65, 'diane', 'diane', '', 'Diane', 'Mercier', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 192, 0, 'noselect', 1),
(14, 'yohann', 'compteferme', 'Yo', 'Yohann', 'Bonelle', 7, 8, 1978, 'yoimpro@gmail.com', '06 28 50 65 64', '4a, rue Pascal 69100 Villeurbanne', 'Répartie, spontanéité, lecture d''impro, énergie et cabotinage.', 'Personnages, mimes, décrochages (en ateliers surtout heureusement) et cabotinage...', 'Découverte pendant mes tous premiers cours de théâtre et mise en pratique au sein des ateliers d''Et-Compagnie et des stages de la Lily.', '', 'En regardant mon poisson dans son tout petit bocal.', 'La découverte de soi, de nouveaux mondes, de personnes géniales et amies, de personnages souvent marrants et parfois flippants et de récréations parfaites.', 'Une famille belle,homogène et familiale.', 96, 0, 'selection', 1),
(76, 'sylvain', 'sylvain', 'Pitch', 'Sylvain', 'Loscos', 23, 8, 1983, 's.loscos@yahoo.fr', '0683764968', '12 avenue de Saxe 69006 Lyon', '3 Golden globes, 17 oscars et 23 prix d''interprétations à Cannes', 'Tout le monde veut prendre ma place.', 'Mars 2011, Lycée Français La Pérouse (San Francisco)', 'Septembre 2011', 'Parce que "trop souvent, on se cache, on manque souvent d''audace..."', 'L''Impro me remplie d’énergie, et de beaucoup de poésie!', 'Faire les choses sérieusement sans se prendre au sérieux...Tout ce que j''aime!', 384, 0, '', 1),
(66, 'florence', 'compteferme', 'Flo', 'Florence', 'Lachenal', 3, 12, 1975, 'flo.lachenal@free.fr', '0684537991', '256 rue vendôme 69003 Lyon', 'de l''énergie!', 'toujours un peu timide...', 'Il y a trois ans (à Arts en Scène puis à Et Compagnie)', 'septembre 2010', 'j''étais un peu timide...', 'le lâcher-prise...', 'le bonheur de jouer (et d''être) ensemble!', 64, 0, '', 1),
(67, 'chloe', 'compteferme', '', 'Chloé', 'Morel', 27, 4, 1987, 'chloemorel78@yahoo.fr', '', '', '', '', '', '', '', '', '', 64, 0, '', 1),
(68, 'valentin', 'compteferme', 'Val', 'Valentin', 'Trollé', 20, 7, 1983, 'valentin.trolle@gmail.com', '0608345384', '30 montée saint barthélémy 69005 Lyon', '', '', '', '', '', '', '', 64, 0, '', 1),
(69, 'xavier', 'compteferme', 'Xaveuh', 'Xavier', 'Pécout', 24, 12, 1969, 'xpecout@free.fr', '06 61 14 21 91', '4 place Wilson 69100 Villeurbanne', 'Toutes', 'Tous aussi. Du coup, ça s''équilibre !', 'Le 24 décembre 1969, vers 8 plombes du mat''', 'J''ai dû coucher... Mais je ne dirai pas avec qui !', 'A force qu''on me dise "tu devrais faire du théâtre". Comme quoi, faut jamais raconter n''importe quoi, même à ceux qu''on aime.', 'Un 150 m2 avec vue dégagée sur Fourvière, une voiture avec chauffeur, et une horde de groupies.', 'Je sais pas moi... Voir un spectacle d''Improcité... Et revenir ?', 64, 0, '', 1),
(71, 'helene', 'compteferme', '', 'Hélène', 'COGNE', 0, 0, 0, 'avocatcogne@gmail.com', '0648778697', '', '', '', '', '', '', '', '', 126, 0, '', 1),
(78, 'laurent', 'laurent', '', 'Laurent', 'PEBET', 26, 12, 1985, 'laurentpebet@gmail.com', '0672852201', 'batiment A, 185 avenue felix faure, 69003 LYON', 'Bon vivant', 'N''aime pas les pas bon vivants', 'Auprès de la troupe théâtrale de l''INSA et de Et CoMPAGNiE', 'En 2011 pour mon plus grand plaisir!', 'Je faisais déjà du théâtre, et la technique d''improvisation me paraissait très intéressante.', 'Du plaisir, de la joie, de la passion', 'Une super troupe avec laquelle on peut s''épanouir et se découvrir de multiples talents', 3968, 0, 'selection;admin', 1),
(79, 'pascal', 'pascal', '', 'Pascal', 'Sarecot', 4, 6, 1971, '', '0662074321', '', 'Humilité ', 'Aux autres de me le dire ', 'Chez et compagnie en 2008', 'En janvier 2012, le bonheur !....', 'Par curiosité puis par passion', 'Jouer des personnages et des situations hors du réel ', 'Ma nouvelle famille ...', 128, 0, '', 1),
(72, 'katia', 'katia', '', 'Katia', 'Mielczarek', 0, 0, 0, '', '', '', 'avec un s', 'aucun', 'eh eh CLICHY 1991/1992', 'ô combien attendue ', 'challenge & partage', 'Plaisir de la construction collective', 'plus les Improcitoyens jouent, plus ils ont envie de jouer\r\n', 384, 0, '', 1),
(80, 'marion', 'marion', 'binoose', 'Marion', 'Moni', 26, 4, 1982, 'marion_moni@hotmail.com', '0637248528', '25 rue Etienne Richerand, 69003 Lyon', '', '', '', '', '', '', '', 128, 0, '', 1),
(81, 'helene', 'helene', '', 'Hélène', 'GRASSELER', 23, 5, 1974, 'grasselerhelene@yahoo.fr', '06.50.63.71.41', '57 rue Sergent Michel BERTHET 69009 LYON', 'C''est pas à moi de le dire !', 'Arch... imbulziveu !', '', 'Septembre 2012.', '', '', 'Bouée de sauvetage !', 1792, 0, '', 1),
(82, 'jessica', 'jessica', 'Jess', 'Jessica', 'Lefaucheux', 18, 7, 1979, 'jessicalefaucheux@voila.fr', '0681651406', '32 rue clément michut, 69100 Villeurbanne', '', '', '', '', '', '', '', 256, 0, '', 1),
(83, 'nicolas', 'nicolas', '', 'Nicolas', 'Nouyrigat', 1, 9, 1984, 'nicolas.nouyrigat@gmail.com', '0650710559', '3 rue st pierre de Vaise\r\n69009 Lyon', 'Y''a un perso que je joue trop bien !', 'Nicolas, c''est toi ?', 'En septembre 2012, tel un imposteur !', 'Je me suis perdu dans Villeurbanne.', 'Ma mémoire défaillante ne permettait plus de faire du théâtre.', 'Des apéros à la maison', 'troupe, petits suisses, totem, amis, week-end', 3840, 0, '', 1),
(84, 'jerome', 'yu6kn7', 'CG', 'Jerome', 'Grondin', 3, 10, 1989, 'jerome.grondin55@gmail.com', '0666681887', '', 'Je fais bien l''accent Breton.', 'En équilibre sur une main le jeu est très limité.', 'Après mes 6 années de méditation au Népal puis au Tibet j''ai su, telle une révélation, qu''il fallait que je me tourne vers l''impro.', 'Mon baptême du feu improvisé au NINKAZI ! "Jerome t''es sur Lyon, dans deux heures tu peux être sur scène ?"', 'En regardant de bonnes séries Allemandes comme Alerte Cobra. ', 'Des bonnes notes en maths. (je suis encore à l''école)', 'Un pokémon ?', 256, 0, '', 1),
(85, 'sophie', 'sophie', 'sophie boulette', 'Sophie', 'Brouchet', 27, 7, 1987, 'brouchetsophie@gmail.com', '0667833230', '27 grande rue de la croix rousse 69004 LYON', 'skyzophrénie', 'je décrooooche!', 'La LIPAIX à Aix en provence, une grande découverte!', 'Envie de les rejoindre après les avoir vu jouer au Ninkasi...', 'Poussée pas des copains: toi tu devrais faire de l''impro!', 'lâcher prise, défoulement, création... c''est trop bon:)', 'Une troupe talentueuse et bosseuse.', 3840, 0, '', 1),
(86, 'arnaud', 'Mdpplc69', '', 'Arnaud', 'Demarty', 30, 8, 1979, 'burzum@brassageamateur.com', '06 08 03 80 14', '3 rue de l''espérance, 69 003 LYON', 'Mange 5 fruits et légumes par jour.', 'Vandalise les personnes agées au distributeur. Mais est-ce vraiment un défaut?', '2011', '2013', 'J''ai hélas été contraint d''admettre que faire l''andouille était ma seule prédisposition naturelle...', 'Des déductions fiscales.\r\nSavoir trouver un alibi au boulot en 2 secondes en cas d''absence injustifiée.\r\n', 'Comme une 2ème famille, mais qu''on aurait choisie.', 3584, 0, 'admin;selection;artistik', 1),
(87, 'virginie', 'virginie', '', 'Virginie', 'Soldat', 10, 7, 1980, 'virginiesoldat@gmail.com', '0672846656', '10 bis rue Villeneuve 69004 LYON', 'Ahhhh mon fameux accent !', 'Mon accent belge !', 'Après 4 années de théâtre classique je me lance et hop Improcité en 2013 !', 'Un casting en septembre 2013 ....', '', 'lâcher prise et défoulement Grrrrrrr !', 'Des potes :)', 3584, 0, '', 1),
(89, 'guillaume', 'parti', '', 'Guillaume', 'Begue', 10, 11, 1986, 'guillaumebegue@vertmprod.com', '0618554683', '219 rue Marcel Mérieux Bed in City apt 706  69007 Lyon', 'J''aide les aveugles à traverser la rue.', 'J''aide les aveugles à traverser la rue quand le feu est rouge.', 'Oui', 'En bus. Mais j''ai du prendre le métro d''abord.', 'J''en avais fini avec ma période taxidermiste et ma phase curling, l''impro était la suite logique.', 'un alibi.', 'Caribou, drosophile, cactus, steak haché, autodafé, graine de quinoa.', 512, 0, 'noselect', 1),
(90, 'gregoire', 'chgrego', '', 'Grégoire', 'Maurice', 1, 11, 1979, 'Gregoiremaurice@hotmail.com', '0645740353', '44 av du Gen Leclerc 69100 Villeurbanne', '', '', '', '', '', '', '', 1536, 0, '', 1),
(91, 'christian', 'christian', 'Mister Chris', 'Christian', 'Brac', 16, 3, 1977, 'christianbrac@htomail.com', '0662689914', '38 rue Sainte geneviève 69006 Lyon ', 'Je colorie ma vie de couleurs différentes !', 'Prétentieux, sourd, avare, soupe au lait,  gras du bide,  transpirateur, ivrogne (avec modération) , idéaliste, mauvais en grammaire et orthographe, caractériel, indépendant, et irrégulier. J’en oublie..', '2001 (avec 6 ans en pause d''art de rue: Crieur du Gang''Ouf)', '2014', '" Le Paradis n’est pas l’ailleurs, dont rêve le voyageur, il est peut-être dans l’au-delà, sûrement pas dans l’autrefois, le Paradis n’est pas demain, mais aujourd’hui entre tes mains, il est là où tu mets la marque, de conjointes élévations, là où tu construis ton "park", où règne l’improvisation !!"\r\nRepris des Fabulous Trobadors "Era pas de faire" puis Beaujolifié…\r\n', 'un peu de modestie (et il y a du boulot)', 'Un troupe sensible, bavarde, batailleuse, incorruptible, revancharde, insoumise, un poil en dessous de la ceinture (mais pas toujours) bref… impeccable !', 3584, 0, '', 1),
(92, 'cecile', 'cecile', 'Denver', 'Cécile', 'Blaise', 13, 3, 1986, 'cecile.blaise1@gmail.com', '0782725256', '9 Rue Claude Violet, 69008 Lyon', 'Sur scène, je me lâche complètement', 'Je me fais peur, parfois', 'En Belgique. J''avais à peine 15 ans (donc en 2001). Beaucoup trop timide dans ce monde de brutes sauvages. Arrêt de 10 ans. Redémarrage au Québec en 2012. Beaucoup mieux :-).', 'En retard. J''ai dû courir. Puis finalement, la plupart n''étaient pas encore là...', 'C''était mieux que de prendre mon copain pour un punching ball.', 'Du relâchement, des amis (ça reste à voir s''ils seront gentils avec moi ^^), des personnages qui ne sont pas moi mais quand même un peu moi (the evil me, mouahaha !!! oups, pardon, je me suis emportée)', 'Quelques mots sur Improcité ? Ok !\r\nQuelques mots\r\n-----------------------\r\nImprocité\r\n\r\nFacile, vous ne m''aurez pas !', 3072, 0, '', 1),
(93, 'blandine', 'blandine', '', 'Blandine', 'Meunier', 29, 3, 1983, 'meunier_blandine@hotmail.com', '0677784780', '31 Quai Pierre Scize\r\n69009 LYON', 'Je cuisine pour les catering.', 'Je chante pas hyper hyper juste.', 'En 2014, après plusieurs années de théâtre plus "classique".', 'En stop, true story!', '', 'C''est un des seuls moments où je peux faire vivre tous les amis qui vivent dans ma tête sans être trop jugée!', 'Fun, cool, swing, feng shui, potes, bières, régie, son, lumières, asso, rencontres et tutti quanto!', 3072, 0, '', 1),
(94, 'guillaume', 'Licorne', 'Licorne', 'Guillaume', 'Schaffauser', 9, 3, 1980, 'guillaume.schaffauser@laposte.net', '0620142225', '175 rue Pasteur\r\n01400 Châtillon sur Chalaronne', 'L''envie de jouer', 'L''envie de (trop) bien faire', '2008, si mes souvenir sont bons!', 'Par hasard; les gens étant tous réunis devant le bâtiment, je me suis dit que ça devait être une distribution de bonbons. Apparemment pas, mais c''est bien aussi!', 'J''ai vu un ami sur scène. Il m''a dit: "viens avec nous!" J''ai répondu:"Tu fournis les rillettes?"\r\nLa réponse étant positive, je les ai rejoints le lendemain.', 'Des trous dans les pantalons.', 'Je n''ai pas de mots assez élogieux en tête...', 3072, 0, '', 1),
(95, 'josselin', 'josselin', 'Josss', 'Josselin', 'Granger', 26, 10, 1978, 'jossssss@gmail.com', '06.35.40.01.48', '64 Rue Boileau', 'Je sais très bien faire le chat  qui miaule en fond de scène.', 'Je perds mes poils.', 'J''ai suivi pendant deux ans les ateliers de la Lilyade, avec notamment une année de Comédie Improvisée', 'J''avais rencontré Improcité dans le cadre d''un match avec Obiwam et connaissais Arnaud de la Lilayde. Les sessions de recrutement ont confirmé l''envie de faire partie de cette troupe.', 'Ca me titillait depuis des années. Un jour, un vieux pote m''a proposé de venir le voir jouer. Quoi ? Mais si lui en fait, alors moi aussi je peux !!', 'De l''énergie, des rencontres, de l''émotion', 'Aucune idée. De quoi parle-t-on ?', 3072, 0, 'admin;selection', 1),
(96, '', '', '', 'Arlo', 'DOUKHAN', 0, 0, 0, 'arloavecunl@yahoo.fr', '0659279115', '', '', '', '', '', '', '', '', 7, 0, '', 1),
(97, '', '', '', 'Pierre-Louis', 'DOLMAZON', 0, 0, 0, 'dolmazon@tiscali.fr', '', '', '', '', '', '', '', '', '', 1, 0, '', 1),
(98, '', '', '', 'Daphné', 'DUJARDIN', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 2, 0, '', 1),
(99, '', '', '', 'Abdelkarim', 'FAREH', 0, 0, 0, 'abdel.fareh@gmail.com', '', '', '', '', '', '', '', '', '', 3, 0, '', 1),
(100, '', '', 'Buck', 'David', 'FUGERAY', 0, 0, 0, 'david_fugeray@yahoo.fr', '', '', '', '', '', '', '', '', '', 7, 0, '', 1),
(101, '', '', '', 'Claire', 'GINDRE', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 3, 0, '', 1),
(102, '', '', '', 'Emmanuel', 'GUILLON', 0, 0, 0, 'Emmanuel.Guillon@pole-technologique.lafarge.com', '', '', '', '', '', '', '', '', '', 6, 0, '', 1),
(103, '', '', '', 'David', 'INES', 0, 0, 0, 'divadness@gmail.com', '', '', '', '', '', '', '', '', '', 3, 0, '', 1),
(104, '', '', '', 'Franck', 'LAVIGNE', 0, 0, 0, 'francklavigne@ecothane.com', '', '', '', '', '', '', '', '', '', 7, 0, '', 1),
(105, '', '', '', 'Patricia', 'LAVIGNE', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 6, 0, '', 1),
(106, '', '', '', 'Sandrine', 'MEYER', 0, 0, 0, 'sandrinemeyer26@gmail.com', '', '', '', '', '', '', '', '', '', 3, 0, '', 1),
(107, '', '', '', 'Xavier', 'SCHON', 0, 0, 0, 'xschon@kawaii-studio.com', '', '', '', '', '', '', '', '', '', 6, 0, '', 1),
(108, '', '', '', 'Maud', 'ZAMBON', 0, 0, 0, 'maudou85@hotmail.com', '', '', '', '', '', '', '', '', '', 7, 0, '', 1),
(109, '', '', '', 'Delphine', 'SALUT', 0, 0, 0, 'delphinesalut@voila.fr', '', '', '', '', '', '', '', '', '', 4, 0, '', 1),
(110, '', '', '', 'Julien', 'PERRIER-DAVID', 0, 0, 0, 'poissjul@hotmail.com', '', '', '', '', '', '', '', '', '', 4, 0, '', 1),
(111, '', '', '', 'Cédric', 'ANGELETTI', 0, 0, 0, 'grogob@yahoo.fr', '', '', '', '', '', '', '', '', '', 4, 0, '', 1),
(112, '', '', '', 'Joël', 'PRUDENT', 0, 0, 0, 'joel.prudent@free.fr', '', '', '', '', '', '', '', '', '', 4, 0, '', 1),
(113, '', '', '', 'Juliette', 'BAL', 0, 0, 0, 'juliettebal@yahoo.fr', '', '', '', '', '', '', '', '', '', 4, 0, '', 1),
(114, 'julie', 'julie', '', 'Julie', 'HERVÉ', 26, 1, 1987, 'juherve@hotmail.fr', '0629612727 ', '2 Rue saint Lazare. 69007 Lyon ', '', '', '2005 (avec pauses!)', '2015', '', 'Souffler et rigoler', 'Fun, fun, and... Fun !', 2048, 0, '', 1),
(115, 'chloe', 'chloe', '', 'Chloé', 'DEVEDEUX', 18, 8, 1989, 'c.devedeux@hotmail.fr', '0760364471', '62a avenue du point du jour\r\n69002 Lyon', 'Joyeuse, passionnée, et les autres seront à découvrir par vous même... ;-)\r\n', 'Parfois stressée, timide, et la suite n est pas belle à dire... ;-)', '2014', 'Par un contact dans ma compagnie sur Besançon \r\nEt arrivée passionnée avec une hâte non dissimulée de jouer et m AMUSER :-)', 'Un premier contact au lycée sur une séance...\r\nPlusieurs troupes de théâtre plus tard, une révélation... Je préfère l improvisation...', 'J oublie tout ... Je suis à fond... Je suis moi, beaucoup d autres... \r\nTous même si je veux...\r\nLa liberté... De faire ce qui me plait ... Dans le cadre mouvant de l improvisation...\r\ncette stimulation toujours plus pétillante de l imagination...\r\nJe n oublie pas non plus les ambiances de doux dingues qu j adore... :-)\r\n', 'C est tout à fait ce qu il me fallait\r\nComme je disais une super équipe de doux dingues... ;-)\r\nAvec des rêves d impro plein la tête ', 2048, 0, 'noselect', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=116;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
