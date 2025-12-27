<?php

namespace Config;
use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    private function __construct() {}

    public static function getConnection(): PDO
    {

        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    $_ENV['DATABASE_URL'],
                    $_ENV['DATABASE_USER'],
                    $_ENV['DATABASE_PASSWORD'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die("Erreur connexion BD : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
