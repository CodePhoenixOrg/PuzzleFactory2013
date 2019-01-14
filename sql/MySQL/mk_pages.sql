INSERT INTO `ipuzzle`.`pz_pages` (`di_name`, `pa_filename`) VALUES ('home', 'mkmain.php');
INSERT INTO `ipuzzle`.`pz_pages` (`di_name`, `pa_filename`) VALUES ('menus', 'menus.php');
INSERT INTO `ipuzzle`.`pz_pages` (`di_name`, `pa_filename`) VALUES ('pages', 'pages.php');
INSERT INTO `ipuzzle`.`pz_pages` (`di_name`, `pa_filename`) VALUES ('blocks', 'blocks.php');
INSERT INTO `ipuzzle`.`pz_pages` (`di_name`, `pa_filename`) VALUES ('dictiona', 'dictionary.php');
INSERT INTO `ipuzzle`.`pz_pages` (`di_name`, `pa_filename`) VALUES ('applicat', 'applications.php');
INSERT INTO `ipuzzle`.`pz_pages` (`di_name`, `pa_filename`) VALUES ('changelo', 'changelog.php');
INSERT INTO `ipuzzle`.`pz_pages` (`di_name`, `pa_filename`) VALUES ('todo', 'todo.php');
INSERT INTO `ipuzzle`.`pz_pages` (`di_name`, `pa_filename`) VALUES ('bugrepor', 'bugreport.php');
INSERT INTO `ipuzzle`.`pz_pages` (`di_name`, `pa_filename`) VALUES ('groups', 'groups.php');
INSERT INTO `ipuzzle`.`pz_pages` (`di_name`, `pa_filename`) VALUES ('mkscript', 'mkscript.php');
INSERT INTO `ipuzzle`.`pz_pages` (`di_name`, `pa_filename`) VALUES ('mkmenu', 'mkmenu.php');
INSERT INTO `ipuzzle`.`pz_pages` (`di_name`, `pa_filename`) VALUES ('mkblock', 'mkblock.php');
INSERT INTO `ipuzzle`.`pz_pages` (`di_name`, `pa_filename`) VALUES ('mkfields', 'mkfields.php');
INSERT INTO `ipuzzle`.`pz_pages` (`di_name`, `pa_filename`) VALUES ('mkfile', 'mkfile.php');

UPDATE pz_menus m,
    pz_pages p 
SET 
    m.pa_id = p.pa_id
WHERE
    m.di_name = p.di_name
