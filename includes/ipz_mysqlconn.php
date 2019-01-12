<?php

use \Puzzle\Data\Connection;
use \Puzzle\Data\Driver;

function connection($c, $d, $cs = null)
{
    $host="mysql";
    $user="root";
    $passwd="demo";
    $dbname=$d;

    try {
        if ($c == CONNECT) {

            $cs = new Connection(Driver::MYSQL, $dbname, $host, $user, $passwd);
            // debugLog("CONNECTION::Driver::MYSQL, $dbname, $host, $user, $passwd", $cs);            
            $cs->open();
        } elseif ($c == DISCONNECT && $cs !== null) {
            //$cs->close();
            unset($cs);
        }   
            
    }
    catch(\PDOException $ex) {
        die("Connection failed: " . $ex->getMessage());
    }
    return $cs;
}
