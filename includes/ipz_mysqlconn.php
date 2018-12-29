<?php
define("CONNECT", "connect");
define("DISCONNECT", "disconnect");

function connection($c, $d, $cs = null)
{
    $host="mysql";
    $user="root";
    $passwd="demo";
    $dbname=$d;

    $dsn = "mysql:dbname=$dbname;host=$host";
    try {
        if ($c == CONNECT) {
            $cs = new PDO($dsn, $user, $passwd, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NUM]);
            //$cs = new mysqli($host, $user, $passwd, $dbname);
            //$cs->set_charset("utf8");
        } elseif ($c == DISCONNECT && $cs !== null) {
            $cs->close();
        }   
            
    }
    catch(\PDOException $ex) {
        die("Connection failed: " . $e->getMessage());
    }
    return $cs;
}
