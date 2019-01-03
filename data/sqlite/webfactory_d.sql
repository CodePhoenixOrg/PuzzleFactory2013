-- MySQL dump 10.17  Distrib 10.3.11-MariaDB, for Linux (x86_64)
--
-- Host: mysql    Database: webfactory
-- ------------------------------------------------------
-- Server version	5.7.24
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE="+00:00" */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE="NO_AUTO_VALUE_ON_ZERO,ANSI" */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table "applications"
--

INSERT INTO "applications" VALUES (1,"admin/","modadmin");

--
-- Dumping data for table "blocks"
--

INSERT INTO "blocks" VALUES (1,"1","menu","mainmenu");
INSERT INTO "blocks" VALUES (2,"1","form","members");
INSERT INTO "blocks" VALUES (3,"3","form","newsltr");

--
-- Dumping data for table "bugreport"
--


--
-- Dumping data for table "changelog"
--

INSERT INTO "changelog" VALUES (4,"La base de données a changé","Les Id sont maintenant auto-indexés.\r\nLa table dictionary a notamment changé dans ce sens pour ne plus utiliser un champ alphanumérique.","2012-10-16 00:00:00","1970-01-01 00:01:00",1,1);

--
-- Dumping data for table "db"
--


--
-- Dumping data for table "dictionary"
--

INSERT INTO "dictionary" VALUES (1,"applicat","Applications","Liste des applications","Applications","List of applications","","");
INSERT INTO "dictionary" VALUES (2,"blocks","Blocs","Liste des blocs","Blocks","List of blocks","","");
INSERT INTO "dictionary" VALUES (3,"bugrepor","Bugs","Rapport de bugs","Bugs","Bug reports","","");
INSERT INTO "dictionary" VALUES (4,"changelo","Changements","Notes de changements","Changes","Change log","","");
INSERT INTO "dictionary" VALUES (5,"dictiona","Dictionnaire","","Dictionary","","","");
INSERT INTO "dictionary" VALUES (6,"editor","Editer","Editer les attributs du script","Edit","Edit script attributes","","");
INSERT INTO "dictionary" VALUES (7,"forums","Forums","Forums disponibles","Forums","Available forums","","");
INSERT INTO "dictionary" VALUES (8,"groups","Groupes","Liste des groupes","Groups","List of groups","","");
INSERT INTO "dictionary" VALUES (9,"home","Accueil","Page d'accueil","Home","Home page","","");
INSERT INTO "dictionary" VALUES (10,"members","Accès membres","Gérez votre profil membre","Members area","Manage your data","","");
INSERT INTO "dictionary" VALUES (11,"menus","Menus","Entrées de menus","Menus","Menu items","","");
INSERT INTO "dictionary" VALUES (12,"mkblock","Créer un bloc","Créer un nouveau bloc","Create a block","Create a new block","","");
INSERT INTO "dictionary" VALUES (13,"mkfields","Champs","Champs de la table","Fields","Table fields","","");
INSERT INTO "dictionary" VALUES (14,"mkfile","Fichier","Création du fichier","File","Creation of the file","","");
INSERT INTO "dictionary" VALUES (15,"mkmenu","Créer un menu","Créer une nouvelle entrée de menu afin d'attacher un script externe ou une landing page","Create a menu","Create a new menu item","","");
INSERT INTO "dictionary" VALUES (16,"mkscript","Créer un script","Créer un script à partir d'une table","Create a script","Create a script from a table","","");
INSERT INTO "dictionary" VALUES (17,"pages","Pages","Liste des pages","Pages","List of pages","","");
INSERT INTO "dictionary" VALUES (18,"todo","A faire","Liste des tâches","To do","Tasks to do","","");
INSERT INTO "dictionary" VALUES (45,"images","Images","Liste des images","","",NULL,NULL);

--
-- Dumping data for table "forums"
--

INSERT INTO "forums" VALUES (1,"Nouveau, changé et corrigé","Indications des fonctionalités nouvellement intégrées, des changements effectués sur des fonctionalités existantes, et des corrections de bugs.","2004-02-10 00:00:00","changelog",1);

--
-- Dumping data for table "graph_texts"
--


--
-- Dumping data for table "groups"
--


--
-- Dumping data for table "images"
--

INSERT INTO "images" VALUES (1,"Dummy","CURRENT_DIRECTORY","/images/logo1.png",1);

--
-- Dumping data for table "members"
--

INSERT INTO "members" VALUES (1,"David BLANCHARD","Pas d'adresse","","76000","davidbl@wanadoo.fr","dpjb","1p2+ar","administrator");
INSERT INTO "members" VALUES (2,"Pierre-Yves Le Bihan","Pas d'adresse","","92800","pylb@wanadoo.fr","pylb","K3r1v31","administrator");

--
-- Dumping data for table "menus"
--

INSERT INTO "menus" VALUES (17,"2","pages",17,1,"home","0","utf8");
INSERT INTO "menus" VALUES (18,"1","page",18,0,"menus","0","utf8");
INSERT INTO "menus" VALUES (19,"2","page",19,1,"pages","0","utf8");
INSERT INTO "menus" VALUES (20,"2","page",20,3,"blocks","0","utf8");
INSERT INTO "menus" VALUES (21,"1","page",21,1,"dictiona","0","utf8");
INSERT INTO "menus" VALUES (22,"2","page",22,1,"applicat","0","utf8");
INSERT INTO "menus" VALUES (23,"1","page",23,1,"forums","user","utf8");
INSERT INTO "menus" VALUES (24,"1","page",24,1,"changelo","user","utf8");
INSERT INTO "menus" VALUES (25,"1","page",25,1,"todo","user","utf8");
INSERT INTO "menus" VALUES (26,"1","page",26,1,"bugrepor","user","utf8");
INSERT INTO "menus" VALUES (27,"2","page",27,1,"groups","0","utf8");
INSERT INTO "menus" VALUES (29,"0","page",29,1,"mkscript","user","utf8");
INSERT INTO "menus" VALUES (30,"0","page",30,1,"mkmenu","user","utf8");
INSERT INTO "menus" VALUES (31,"0","page",31,1,"mkblock","user","utf8");
INSERT INTO "menus" VALUES (32,"0","page",32,1,"mkfields","user","utf8");
INSERT INTO "menus" VALUES (33,"0","page",33,1,"mkfile","user","utf8");
INSERT INTO "menus" VALUES (54,"1","page",58,NULL,"images","user","utf8");

--
-- Dumping data for table "newsletter"
--


--
-- Dumping data for table "pages"
--

INSERT INTO "pages" VALUES (17,"home","mkmain.php");
INSERT INTO "pages" VALUES (18,"menus","menus.php");
INSERT INTO "pages" VALUES (19,"pages","pages.php");
INSERT INTO "pages" VALUES (20,"blocks","blocks.php");
INSERT INTO "pages" VALUES (21,"dictiona","dictionary.php");
INSERT INTO "pages" VALUES (22,"applicat","applications.php");
INSERT INTO "pages" VALUES (23,"forums","forums.php");
INSERT INTO "pages" VALUES (24,"changelo","changelog.php");
INSERT INTO "pages" VALUES (25,"todo","todo.php");
INSERT INTO "pages" VALUES (26,"bugrepor","bugreport.php");
INSERT INTO "pages" VALUES (27,"groups","groups.php");
INSERT INTO "pages" VALUES (28,"newslett","newsletter.php");
INSERT INTO "pages" VALUES (29,"mkscript","mkscript.php");
INSERT INTO "pages" VALUES (30,"mkmenu","mkmenu.php");
INSERT INTO "pages" VALUES (31,"mkblock","mkblock.php");
INSERT INTO "pages" VALUES (32,"mkfields","mkfields.php");
INSERT INTO "pages" VALUES (33,"mkfile","mkfile.php");
INSERT INTO "pages" VALUES (58,"images","images.php");

--
-- Dumping data for table "queries"
--

INSERT INTO "queries" VALUES (1,"Select All","SELECT * FROM members",1);

--
-- Dumping data for table "servers"
--


--
-- Dumping data for table "sites"
--


--
-- Dumping data for table "subscribers"
--


--
-- Dumping data for table "texts"
--


--
-- Dumping data for table "todo"
--


--
-- Dumping data for table "users"
--


--
-- Dumping data for table "v_menus"
--

INSERT INTO "v_menus" VALUES (1,17,17,"pages","2","home","mkmain.php","Accueil","Page d'accueil","Home","Home page");
INSERT INTO "v_menus" VALUES (2,18,19,"page","1","pages","pages.php","Pages","Liste des pages","Pages","List of pages");
INSERT INTO "v_menus" VALUES (3,19,19,"page","2","pages","pages.php","Pages","Liste des pages","Pages","List of pages");
INSERT INTO "v_menus" VALUES (4,20,20,"page","2","blocks","blocks.php","Blocs","Liste des blocs","Blocks","List of blocks");
INSERT INTO "v_menus" VALUES (5,21,21,"page","1","dictiona","dictionary.php","Dictionnaire","","Dictionary","");
INSERT INTO "v_menus" VALUES (6,22,22,"page","2","applicat","applications.php","Applications","Liste des applications","Applications","List of applications");
INSERT INTO "v_menus" VALUES (7,23,23,"page","0","forums","forums.php","Forums","Forums disponibles","Forums","Available forums");
INSERT INTO "v_menus" VALUES (8,24,24,"page","1","changelo","changelog.php","Changements","Notes de changements","Changes","Change log");
INSERT INTO "v_menus" VALUES (9,25,25,"page","1","todo","todo.php","A faire","Liste des tâches","To do","Tasks to do");
INSERT INTO "v_menus" VALUES (10,26,26,"page","1","bugrepor","bugreport.php","Bugs","Rapport de bugs","Bugs","Bug reports");
INSERT INTO "v_menus" VALUES (11,27,27,"page","2","groups","groups.php","Groupes","Liste des groupes","Groups","List of groups");
INSERT INTO "v_menus" VALUES (12,29,29,"page","0","mkscript","mkscript.php","Créer un script","Créer un script à partir d'une table","Create a script","Create a script from a table");
INSERT INTO "v_menus" VALUES (13,30,30,"page","0","mkmenu","mkmenu.php","Créer un menu","Créer une nouvelle entrée de menu afin d'attacher un script externe ou une landing page","Create a menu","Create a new menu item");
INSERT INTO "v_menus" VALUES (14,31,31,"page","0","mkblock","mkblock.php","Créer un bloc","Créer un nouveau bloc","Create a block","Create a new block");
INSERT INTO "v_menus" VALUES (15,32,32,"page","0","mkfields","mkfields.php","Champs","Champs de la table","Fields","Table fields");
INSERT INTO "v_menus" VALUES (16,33,33,"page","0","mkfile","mkfile.php","Fichier","Création du fichier","File","Creation of the file");

--
-- Dumping data for table "web_pages"
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-02  2:19:36
