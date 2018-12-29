<?php
/*
 * Copyright (C) 2016 David Blanchard
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY, without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class iPuzzleLibrary {

    public static function mount() {

        $filenames = [ 
            "const.php",
            //"style.php",
            "db.php",
            "dico.php",
            "source.php",
            "framed_blocks.php",
            "db_controls.php",
            "pdf.php",
            "db_pieces.php",
            //"init.php",
            "menus.php",
            "splash.php",
            //"empty_file.php",
            "mail.php",
            "diary.php",
            "scripts.php",
            "calendar.php",
            "misc.php",
            "controls.php",
            "mkscripts.php",
            "analyser.php",
            "db_graphs.php",
            "design.php",
            "blocks.php"
        ];

        foreach ($filenames as $filename) {
            include __DIR__ . "/ipz_" . $filename;
        }
   
    }
}

iPuzzleLibrary::mount();
