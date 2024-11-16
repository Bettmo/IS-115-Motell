<?php

require_once '../config/database.php';

class Model
{
    protected $db;

    /**
     * Constructor: Initializes the database connection.
     */
    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Execute a raw SQL query with optional parameters.
     *
     * @param string $query The SQL query to execute.
     * @param array $params Optional. Parameters to bind to the query.
     * @return mixed The result of the query (e.g., PDOStatement or false on failure).
     */
    protected function query($query, $params = [])
    {
        $stmt = $this->db->prepare($query);
        if ($stmt->execute($params)) {
            return $stmt;
        }
        return false;
    }

    /**
     * Fetch all rows from a query.
     *
     * @param string $query The SQL query.
     * @param array $params Optional. Parameters to bind to the query.
     * @return array The fetched rows as an associative array.
     */
    protected function fetchAll($query, $params = [])
    {
        $stmt = $this->query($query, $params);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    /**
     * Fetch a single row from a query.
     *
     * @param string $query The SQL query.
     * @param array $params Optional. Parameters to bind to the query.
     * @return array|false The fetched row as an associative array, or false if none found.
     */
    protected function fetch($query, $params = [])
    {
        $stmt = $this->query($query, $params);
        return $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
    }

    /**
     * Insert data into a table.
     *
     * @param string $table The table name.
     * @param array $data An associative array of column => value pairs.
     * @return bool True on success, false on failure.
     */
    protected function insert($table, $data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        return $this->query($query, array_values($data));
    }

    /**
     * Update data in a table.
     *
     * @param string $table The table name.
     * @param array $data An associative array of column => value pairs.
     * @param string $where The WHERE clause (e.g., "id = ?").
     * @param array $whereParams Parameters for the WHERE clause.
     * @return bool True on success, false on failure.
     */
    protected function update($table, $data, $where, $whereParams = [])
    {
        $setClause = implode(',', array_map(fn($col) => "$col = ?", array_keys($data)));
        $query = "UPDATE $table SET $setClause WHERE $where";
        return $this->query($query, array_merge(array_values($data), $whereParams));
    }

    /**
     * Delete data from a table.
     *
     * @param string $table The table name.
     * @param string $where The WHERE clause (e.g., "id = ?").
     * @param array $whereParams Parameters for the WHERE clause.
     * @return bool True on success, false on failure.
     */
    protected function delete($table, $where, $whereParams = [])
    {
        $query = "DELETE FROM $table WHERE $where";
        return $this->query($query, $whereParams);
    }
}
