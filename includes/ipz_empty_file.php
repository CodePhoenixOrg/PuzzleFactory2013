<?php   
/*
iPuzzle.WebPieces
Copyright (C) 2004 David Blanchard

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

	include_once("menus.php");
	switch ($lg) {
	case "fr":
		echo "Ce fichier a été auto-généré, car il n'a pas été trouvé.<br>";
		echo "Il devra être remplacé.<br>";
	break;
	case "en":
		echo "This file has been auto-generated because it has not been found.<br>";
		echo "You will have to replace it.<br>";
	break;
	}
	//echo "id='$id'<br>";
	//$filename=retreive_page($id, $lg);
	//echo $filename[1];
?>
