-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Ven 19 Octobre 2012 à 16:09
-- Version du serveur: 5.5.20
-- Version de PHP: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `webfactory`
--

-- --------------------------------------------------------

--
-- Structure de la table `applications`
--

CREATE TABLE IF NOT EXISTS `applications` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_link` varchar(255) DEFAULT NULL,
  `di_name` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`app_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `applications`
--

INSERT INTO `applications` (`app_id`, `app_link`, `di_name`) VALUES
(1, 'admin/', 'modadmin');

-- --------------------------------------------------------

--
-- Structure de la table `blocks`
--

CREATE TABLE IF NOT EXISTS `blocks` (
  `bl_id` int(11) NOT NULL,
  `bl_column` varchar(1) DEFAULT NULL,
  `bl_type` varchar(4) DEFAULT NULL,
  `di_name` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`bl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocks`
--

INSERT INTO `blocks` (`bl_id`, `bl_column`, `bl_type`, `di_name`) VALUES
(1, '1', 'menu', 'mainmenu'),
(2, '1', 'form', 'members'),
(3, '3', 'form', 'newsltr');

-- --------------------------------------------------------

--
-- Structure de la table `bugreport`
--

CREATE TABLE IF NOT EXISTS `bugreport` (
  `br_id` int(11) NOT NULL AUTO_INCREMENT,
  `br_title` varchar(255) DEFAULT NULL,
  `br_text` mediumtext,
  `br_importance` int(11) DEFAULT NULL,
  `br_status` varchar(8) DEFAULT NULL,
  `br_date` datetime DEFAULT NULL,
  `br_time` datetime DEFAULT NULL,
  `mbr_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`br_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `changelog`
--

CREATE TABLE IF NOT EXISTS `changelog` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_title` varchar(255) DEFAULT NULL,
  `cl_text` mediumtext,
  `cl_date` datetime DEFAULT NULL,
  `cl_time` datetime DEFAULT NULL,
  `fr_id` int(11) DEFAULT NULL,
  `mbr_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `changelog`
--

INSERT INTO `changelog` (`cl_id`, `cl_title`, `cl_text`, `cl_date`, `cl_time`, `fr_id`, `mbr_id`) VALUES
(4, 'La base de données a changé', 'Les Id sont maintenant auto-indexés.\r\nLa table dictionary a notamment changé dans ce sens pour ne plus utiliser un champ alphanumérique.', '2012-10-16 00:00:00', '0000-00-00 00:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `db`
--

CREATE TABLE IF NOT EXISTS `db` (
  `db_id` int(11) NOT NULL AUTO_INCREMENT,
  `db_name` char(15) CHARACTER SET latin1 NOT NULL DEFAULT 'no_name',
  `db_server` int(11) NOT NULL DEFAULT '1',
  `db_site` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`db_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `dictionary`
--

CREATE TABLE IF NOT EXISTS `dictionary` (
  `di_id` int(11) NOT NULL AUTO_INCREMENT,
  `di_name` varchar(8) DEFAULT NULL,
  `di_fr_short` varchar(255) DEFAULT NULL,
  `di_fr_long` mediumtext,
  `di_en_short` varchar(255) DEFAULT NULL,
  `di_en_long` mediumtext,
  `di_ru_short` varchar(255) DEFAULT NULL,
  `di_ru_long` mediumtext,
  PRIMARY KEY (`di_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `dictionary`
--

INSERT INTO `dictionary` (`di_id`, `di_name`, `di_fr_short`, `di_fr_long`, `di_en_short`, `di_en_long`, `di_ru_short`, `di_ru_long`) VALUES
(1, 'applicat', 'Applications', 'Liste des applications', 'Applications', 'List of applications', '', ''),
(2, 'blocks', 'Blocs', 'Liste des blocs', 'Blocks', 'List of blocks', '', ''),
(3, 'bugrepor', 'Bugs', 'Rapport de bugs', 'Bugs', 'Bug reports', '', ''),
(4, 'changelo', 'Changements', 'Notes de changements', 'Changes', 'Change log', '', ''),
(5, 'dictiona', 'Dictionnaire', '', 'Dictionary', '', '', ''),
(6, 'editor', 'Editer', 'Editer les attributs du script', 'Edit', 'Edit script attributes', '', ''),
(7, 'forums', 'Forums', 'Forums disponibles', 'Forums', 'Available forums', '', ''),
(8, 'groups', 'Groupes', 'Liste des groupes', 'Groups', 'List of groups', '', ''),
(9, 'home', 'Accueil', 'Page d''accueil', 'Home', 'Home page', '', ''),
(10, 'members', 'Accès membres', 'Gérez votre profil membre', 'Members area', 'Manage your data', '', ''),
(11, 'menus', 'Menus', 'Entrées de menus', 'Menus', 'Menu items', '', ''),
(12, 'mkblock', 'Créer un bloc', 'Créer un nouveau bloc', 'Create a block', 'Create a new block', '', ''),
(13, 'mkfields', 'Champs', 'Champs de la table', 'Fields', 'Table fields', '', ''),
(14, 'mkfile', 'Fichier', 'Création du fichier', 'File', 'Creation of the file', '', ''),
(15, 'mkmenu', 'Créer un menu', 'Créer une nouvelle entrée de menu', 'Create a menu', 'Create a new menu item', '', ''),
(16, 'mkscript', 'Créer un script', 'Créer un script à partir d''une table', 'Create a script', 'Create a script from a table', '', ''),
(17, 'pages', 'Pages', 'Liste des pages', 'Pages', 'List of pages', '', ''),
(18, 'todo', 'A faire', 'Liste des tâches', 'To do', 'Tasks to do', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `forums`
--

CREATE TABLE IF NOT EXISTS `forums` (
  `fr_id` int(11) NOT NULL,
  `fr_title` varchar(255) DEFAULT NULL,
  `fr_description` mediumtext,
  `fr_date` datetime DEFAULT NULL,
  `fr_table_name` varchar(255) DEFAULT NULL,
  `me_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`fr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `forums`
--

INSERT INTO `forums` (`fr_id`, `fr_title`, `fr_description`, `fr_date`, `fr_table_name`, `me_id`) VALUES
(1, 'Nouveau, changé et corrigé', 'Indications des fonctionalités nouvellement intégrées, des changements effectués sur des fonctionalités existantes, et des corrections de bugs.', '2004-02-10 00:00:00', 'changelog', 1);

-- --------------------------------------------------------

--
-- Structure de la table `graph_texts`
--

CREATE TABLE IF NOT EXISTS `graph_texts` (
  `gt_id` int(11) NOT NULL AUTO_INCREMENT,
  `gt_name` char(15) NOT NULL DEFAULT 'no name',
  `gt_text` char(255) DEFAULT NULL,
  `si_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`gt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `grp_id` int(11) NOT NULL AUTO_INCREMENT,
  `grp_group` varchar(15) DEFAULT NULL,
  `grp_members_priv` varchar(1) DEFAULT NULL,
  `grp_menu_priv` varchar(1) DEFAULT NULL,
  `grp_page_priv` varchar(1) DEFAULT NULL,
  `grp_news_priv` varchar(1) DEFAULT NULL,
  `grp_items_priv` varchar(1) DEFAULT NULL,
  `grp_customers_priv` varchar(1) DEFAULT NULL,
  `grp_products_priv` varchar(1) DEFAULT NULL,
  `grp_calendar_priv` varchar(1) DEFAULT NULL,
  `grp_newsletter_priv` varchar(1) DEFAULT NULL,
  `grp_forum_priv` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`grp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `im_id` int(11) NOT NULL AUTO_INCREMENT,
  `im_name` varchar(15) CHARACTER SET latin1 NOT NULL DEFAULT 'no name',
  `im_dir` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '/',
  `im_url` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'localhost',
  `im_site` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`im_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `mbr_id` int(11) NOT NULL AUTO_INCREMENT,
  `mbr_nom` varchar(50) DEFAULT NULL,
  `mbr_adr1` varchar(50) DEFAULT NULL,
  `mbr_adr2` varchar(50) DEFAULT NULL,
  `mbr_cp` varchar(5) DEFAULT NULL,
  `mbr_email` varchar(50) DEFAULT NULL,
  `mbr_ident` varchar(50) DEFAULT NULL,
  `mbr_mpasse` varchar(50) DEFAULT NULL,
  `grp_group` varchar(13) DEFAULT NULL,
  PRIMARY KEY (`mbr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `members`
--

INSERT INTO `members` (`mbr_id`, `mbr_nom`, `mbr_adr1`, `mbr_adr2`, `mbr_cp`, `mbr_email`, `mbr_ident`, `mbr_mpasse`, `grp_group`) VALUES
(1, 'David BLANCHARD', 'Pas d''adresse', '', '76000', 'davidbl@wanadoo.fr', 'dpjb', '1p2+ar', 'administrator'),
(2, 'Pierre-Yves Le Bihan', 'Pas d''adresse', '', '92800', 'pylb@wanadoo.fr', 'pylb', 'K3r1v31', 'administrator');

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `me_id` int(11) NOT NULL AUTO_INCREMENT,
  `me_level` varchar(1) DEFAULT NULL,
  `me_target` varchar(7) DEFAULT NULL,
  `pa_id` int(11) DEFAULT NULL,
  `bl_id` int(11) DEFAULT NULL,
  `di_name` varchar(8) DEFAULT NULL,
  `grp_group` varchar(13) DEFAULT NULL,
  `me_charset` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`me_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Contenu de la table `menus`
--

INSERT INTO `menus` (`me_id`, `me_level`, `me_target`, `pa_id`, `bl_id`, `di_name`, `grp_group`, `me_charset`) VALUES
(17, '2', 'pages', 17, 1, 'home', '0', 'utf8'),
(18, '2', 'page', 18, 1, 'menus', '0', 'utf8'),
(19, '2', 'page', 19, 1, 'pages', '0', 'utf8'),
(20, '2', 'page', 20, 3, 'blocks', '0', 'utf8'),
(21, '2', 'page', 21, 1, 'dictiona', '0', 'utf8'),
(22, '2', 'page', 22, 1, 'applicat', '0', 'utf8'),
(23, '0', 'page', 23, 1, 'forums', 'user', 'utf8'),
(24, '1', 'page', 24, 1, 'changelo', 'user', 'utf8'),
(25, '1', 'page', 25, 1, 'todo', 'user', 'utf8'),
(26, '1', 'page', 26, 1, 'bugrepor', 'user', 'utf8'),
(27, '2', 'page', 27, 1, 'groups', '0', 'utf8'),
(29, '0', 'page', 29, 1, 'mkscript', 'user', 'utf8'),
(30, '0', 'page', 30, 1, 'mkmenu', 'user', 'utf8'),
(31, '0', 'page', 31, 1, 'mkblock', 'user', 'utf8'),
(32, '0', 'page', 32, 1, 'mkfields', 'user', 'utf8'),
(33, '0', 'page', 33, 1, 'mkfile', 'user', 'utf8');

-- --------------------------------------------------------

--
-- Structure de la table `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `nl_id` int(11) NOT NULL AUTO_INCREMENT,
  `nl_title` varchar(255) DEFAULT NULL,
  `nl_author` varchar(255) DEFAULT NULL,
  `nl_header` mediumtext,
  `nl_image` varchar(255) DEFAULT NULL,
  `nl_comment` varchar(255) DEFAULT NULL,
  `nl_body` mediumtext,
  `nl_links` mediumtext,
  `nl_footer` mediumtext,
  `nl_file` varchar(255) DEFAULT NULL,
  `nl_date` datetime DEFAULT NULL,
  PRIMARY KEY (`nl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `pa_id` int(11) NOT NULL AUTO_INCREMENT,
  `di_name` varchar(8) DEFAULT NULL,
  `pa_filename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Contenu de la table `pages`
--

INSERT INTO `pages` (`pa_id`, `di_name`, `pa_filename`) VALUES
(17, 'home', 'mkmain.php'),
(18, 'menus', 'menus.php'),
(19, 'pages', 'pages.php'),
(20, 'blocks', 'blocks.php'),
(21, 'dictiona', 'dictionary.php'),
(22, 'applicat', 'applications.php'),
(23, 'forums', 'forums.php'),
(24, 'changelo', 'changelog.php'),
(25, 'todo', 'todo.php'),
(26, 'bugrepor', 'bugreport.php'),
(27, 'groups', 'groups.php'),
(28, 'newslett', 'newsletter.php'),
(29, 'mkscript', 'mkscript.php'),
(30, 'mkmenu', 'mkmenu.php'),
(31, 'mkblock', 'mkblock.php'),
(32, 'mkfields', 'mkfields.php'),
(33, 'mkfile', 'mkfile.php');

-- --------------------------------------------------------

--
-- Structure de la table `queries`
--

CREATE TABLE IF NOT EXISTS `queries` (
  `qy_id` int(11) NOT NULL AUTO_INCREMENT,
  `qy_name` varchar(15) CHARACTER SET latin1 NOT NULL DEFAULT 'no name',
  `qy_string` text CHARACTER SET latin1,
  `qy_database` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`qy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `servers`
--

CREATE TABLE IF NOT EXISTS `servers` (
  `se_id` int(11) NOT NULL AUTO_INCREMENT,
  `se_type` tinyint(4) NOT NULL DEFAULT '5',
  `se_host` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'localhost',
  `se_site` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`se_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `sites`
--

CREATE TABLE IF NOT EXISTS `sites` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `si_server_name` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'localhost',
  `si_root_dir` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '/',
  `si_http_url` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'http://localhost',
  `si_ftp_url` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'ftp://localhost',
  `si_perl_bin_dir` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '/usr/bin',
  PRIMARY KEY (`si_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `subscribers`
--

CREATE TABLE IF NOT EXISTS `subscribers` (
  `sub_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sub_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `texts`
--

CREATE TABLE IF NOT EXISTS `texts` (
  `tx_id` int(11) NOT NULL AUTO_INCREMENT,
  `tx_name` varchar(15) CHARACTER SET latin1 NOT NULL DEFAULT 'no name',
  `tx_title` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'none',
  `tx_content` text CHARACTER SET latin1,
  `tx_dir` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '/',
  `tx_url` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'localhost',
  `tx_site` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`tx_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `todo`
--

CREATE TABLE IF NOT EXISTS `todo` (
  `td_id` int(11) NOT NULL AUTO_INCREMENT,
  `td_title` varchar(255) DEFAULT NULL,
  `td_text` mediumtext,
  `td_priority` int(11) DEFAULT NULL,
  `td_expiry` datetime DEFAULT NULL,
  `td_status` varchar(8) DEFAULT NULL,
  `td_date` datetime DEFAULT NULL,
  `td_time` datetime DEFAULT NULL,
  `mbr_id` int(11) DEFAULT NULL,
  `mbr_id2` int(11) DEFAULT NULL,
  PRIMARY KEY (`td_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `us_id` int(11) NOT NULL AUTO_INCREMENT,
  `us_name` char(15) CHARACTER SET latin1 NOT NULL,
  `us_passwd` char(16) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `us_web_pages` char(1) CHARACTER SET latin1 NOT NULL DEFAULT 'Y',
  `us_databases` char(1) CHARACTER SET latin1 NOT NULL DEFAULT 'Y',
  `us_texts` char(1) CHARACTER SET latin1 NOT NULL DEFAULT 'Y',
  `us_images` char(1) CHARACTER SET latin1 NOT NULL DEFAULT 'Y',
  `us_users` char(1) CHARACTER SET latin1 NOT NULL DEFAULT 'N',
  `us_site` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `web_pages`
--

CREATE TABLE IF NOT EXISTS `web_pages` (
  `wb_id` int(11) NOT NULL AUTO_INCREMENT,
  `wb_name` varchar(15) CHARACTER SET latin1 NOT NULL DEFAULT 'no name',
  `wb_type` varchar(5) CHARACTER SET latin1 NOT NULL DEFAULT 'html',
  `wb_dir` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '/',
  `wb_url` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'localhost',
  `wb_site` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`wb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
