<?php

class Connection{
    private $driver = 'mysql';
    private $host = 'localhost';
    private $dbName = 'nl';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8';

    protected function conexion(){
        try {
            $pdo = new PDO("{$this->driver}:host={$this->host};dbname={$this->dbName};charset={$this->charset}",$this->user,$this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    
}

//  id10147197_blognatural
//  id10147197_root
//  Sxlvxa

//  id10812711_dbblog
//  id10812711_dbroot
//  123456