<?php

class Database
{
    // Store the PDO instance
    private static $db = null;

    /**
     * Get the database connection.
     *
     * @return PDO The database connection instance.
     */
    public static function getConnection()
    {
        // If the connection is not already established, create it
        if (self::$db === null) {
            // Load configuration
            $config = require __DIR__ . '/config.php';
            $dbConfig = $config['db'];

            // Create DSN (Data Source Name)
            $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['name']};charset={$dbConfig['charset']}";

            try {
                // Create the PDO instance
                self::$db = new PDO($dsn, $dbConfig['user'], $dbConfig['password']);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions on errors
                self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Fetch as associative array by default
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        // Return the PDO instance
        return self::$db;
    }
}
