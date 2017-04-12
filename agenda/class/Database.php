<?php
class Database
{
    protected static $db;

    private function __construct()
    {
        $db_usuario = "dcsoft";
        $db_senha = "cadRArugaY785uBu";

        try
        {
            self::$db = new PDO("mysql:host=host; dbname=database", $db_usuario, $db_senha);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->exec('SET NAMES utf8');
        }
        catch (PDOException $e)
        {
            die("Connection Error: " . $e->getMessage());
        }
    }

    public static function conect()
    {
        if (!self::$db) {
            new Database();
        }
        return self::$db;
    }
}