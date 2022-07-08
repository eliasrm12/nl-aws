<?php

session_start();

if (!isset($_SESSION['user'])) {
  header('Location:../login.php');
}


    header('Cache-Control: no-cache');
    require_once '../post.php';

    $baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    $baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . $baseDir;
    define('BASE_URL', $baseUrl);

    $post = new Post();
    $datas = $post->getById($_GET['id']);
    
    if( $_SERVER['REQUEST_METHOD']=='GET'){

        $imgName = $datas[0]->img;

        $destiny = '../../';

        unlink($destiny . $imgName);

        $post->delete($_GET['id']);
        header('Location:'. BASE_URL . '../index.php');
    }
?>