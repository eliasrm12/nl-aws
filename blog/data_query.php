
<?php

header('Cache-Control: no-cache');

require_once 'post.php';

$post = new Post();

$consulta = $post->getAll();

//print_r($consulta);

if($_SERVER['REQUEST_METHOD']=='GET'){
    $data = [];

    foreach($consulta as $value){
        array_push($data, ["name" => $value->title, "img" => $value->img, "datos" => $value->text]);
    }

    echo json_encode($data);
}
