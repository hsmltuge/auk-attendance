<?php
//require_once 'classes/config.php';
class db {
    // The database connection
    protected static $connection;
    private $_host = "localhost", $_user="root", $_pass='Password', $_db='AukAttandance';
    /**
     * Connect to the database
     *
     * @return bool false on failure / mysqli MySQLi object instance on success
     */
    public function connect() {
        // Try and connect to the database
        if (!isset(self::$connection)) {
            // Load configuration as an array. Use the actual location of your configuration file
            self::$connection = new mysqli($this->_host, $this->_user, $this->_pass, $this->_db);
        }

        // If connection was not successful, handle the error
        if (self::$connection === false) {
            // Handle error - notify administrator, log to a file, show an error screen, etc.
            return false;
        }
        return self::$connection;
    }
    
   
    /**
     * Query the database
     *
     * @param $query The query string
     * @return mixed The result of the mysqli::query() function
     */
    public function query($query) {
        // Connect to the database
        $connection = $this->connect();
        // Query the database
        $result = $connection->query($query);
        // Connect to the database
        return $result;
    }
	 public function multi($query) {
        // Connect to the database
        $connection = $this->connect();
        // Query the database
        $result = $connection->multi_query($query);
        // Connect to the database
        return $result;
    }
    /**
     * Fetch rows from the database (SELECT query)
     *
     * @param $query The query string
     * @return bool False on failure / array Database rows on success
     */
    public function select($query) {
        $rows = array();
        $result = $this->query($query);
        if ($result === false) {
            return false;
        }
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $result->free();
        return $rows;
    }

    /**
     * Fetch the last error from the database
     *
     * @return string Database error message
     */
    public function error() {
        $connection = $this->connect();
        return $connection->error;
    }

    /**
     * Quote and escape value for use in a database query
     *
     * @param string $value The value to be quoted and escaped
     * @return string The quoted and escaped string
     */
    public function quote($value) {
        $connection = $this->connect();
        return trim($connection->escape_string($value));
    }

    /**
     * Deletion of entry
     *
     */
    public function delete_entry($table_name, $entry_column, $entry_id)
    {
        $result = $this->query("DELETE FROM $table_name WHERE $entry_column = '{$entry_id}'");
        return $result;
    }

    public function update_entry($table_name, $entry_column, $data, $where_column, $value_where)
    {
        $result = $this->query("UPDATE  $table_name SET $entry_column= '$data' WHERE $where_column = '{$value_where}'");
        return $result;
    }

    /**
     * Quote and escape value for use in a database query
     *
     * @param string $value The value to be quoted and escaped
     * @return string The quoted and escaped string
     */
    public function close() {
        return self::$connection->close();
    }
    

}

