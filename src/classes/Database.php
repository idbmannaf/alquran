<?php

namespace App\classes;

class Database {
    public $db;    
    private $hostname = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'al_quran';
    public $table_name = '';

    function __construct()
    {
        $this->open();
    }

    function __destruct()
    {
        //$this->close();
    }

    public function rawQuery($sql)
    {
        return $this->db->query($sql);
    }

    public function open()
    {
        if (!is_object($this->db)) {            
            $conn = new \mysqli($this->hostname,$this->username,$this->password,$this->database,'3306');
            $conn->set_charset('utf8');

            if ($conn->connect_error) {
                error_log('Database connection failed: ' . $conn->connect_error);
                return false;
            }

            $this->db = $conn;
        }
    }
    
    public function close()
    {
        $this->db->close();
        unset($this->db);
    }

    public function escape($v)
    {
        return $this->db->real_escape_string($v);
    }
}
?>