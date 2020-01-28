<?php

namespace App;

class App
{
    // This $db property has common
    // value through all App objects
    public static $db;

    public static $session;

    public function __construct()
    {
        session_start();
        // Inside class, static variables
        // are accessed with self::$static_variable_name
        self::$db = new \Core\FileDB(DB_FILE);
        self::$session = new \Core\Session();
//        self::$db->load();
    }



//    public function __destruct()
//    {
//        self::$db->save();
//    }
}