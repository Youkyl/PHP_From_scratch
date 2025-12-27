<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                $config = require __DIR__ . '/../../config/config.php';

                self::$instance = new PDO(
                    "mysql:host={$config['DB_HOST']};dbname={$config['DB_NAME']};charset=utf8",
                    $config['DB_USER'],
                    $config['DB_PASS'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]
                );
            } catch (PDOException $e) {
                die("Erreur base de données : " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}