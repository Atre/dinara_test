<?php

class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $pwd = 'BCdDwsd1db6';
    private $db = 'horoscope';

    private $mysql;
    private static $instance;

    private function __construct() {
        $this->mysql = mysqli_connect($this->host, $this->user, $this->pwd, $this->db) or die ("No database connection :(");

    }
    private function __clone() {}

    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function addToDb($date, $signId, $text) {
        // If exist - return id
        $query = "SELECT id FROM daily_horoscopes WHERE sign_id = '$signId' AND date = '$date'";
        $res = mysqli_query($this->mysql, $query);
        if(mysqli_num_rows($res) > 0) {
            return mysqli_fetch_assoc($res)['id'];
        }
        // if no - insert and create id
        else {
            $query = "INSERT INTO daily_horoscopes (text, date, sign_id) VALUES ('$text', '$date', $signId)";
            $res = mysqli_query($this->mysql, $query);
            return(mysqli_insert_id($this->mysql));
        }
    }

    public function takeFromDb($id) {
        $query = "SELECT text FROM daily_horoscopes WHERE id = '$id'";
        $res = mysqli_query($this->mysql, $query);
        if(mysqli_num_rows($res) > 0) {
            return mysqli_fetch_assoc($res)['text'];
        }
        else {
            return false;
        }
    }
} 