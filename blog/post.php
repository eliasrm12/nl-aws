<?php

include_once 'crud.php';

class Post extends Crud{
    private $id;
    private $title;
    private $test;
    private $img;

    const TABLE = 'posts';
    
    private $pdo;

    public function __construct(){

        parent::__construct(self::TABLE);
        $this->pdo = parent::conexion();

    }

    public function __set($title,$value){
        $this->$title = $value;
    }

    public function __get($title){
        return $this->$title;
    }

    public function create(){
        $stm = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (title, text, img) VALUES (?,?,?)");
        $stm->execute(array($this->title, $this->text, $this->img));
    }

    public function update(){

        $stm = $this->pdo->prepare("UPDATE " . self::TABLE . " SET title=?, text=?, img=? WHERE id=?");
        $stm->execute(array($this->title, $this->text, $this->img, $this->id));

    }

}

?>