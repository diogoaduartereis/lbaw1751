<?php

namespace App\Http\Controllers;

class dbcon {

    public static $started = false;
    public static $dbconn;

    public static function getDB() {
        if (!self::$started) {
            self::$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=pg!fcp");
            self::$started = true;
        }
        return self::$dbconn;
    }

}
