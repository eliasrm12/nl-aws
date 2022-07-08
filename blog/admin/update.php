<?php

session_start();

if (!isset($_SESSION['user'])) {
  header('Location:../login.php');
}

header('Cache-Control: no-cache');

$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . $baseDir;
define('BASE_URL', $baseUrl);

    require_once '../post.php';

    $result = false;


    $post = new Post();
    $datas = $post->getById($_GET['id']);

    if( $_SERVER['REQUEST_METHOD']=='POST'){


            if (!empty($_FILES['image']['tmp_name'])) {

                $imgName = $_FILES['image']['name'];

                $destiny = '../../img/uploads/';

                move_uploaded_file($_FILES['image']['tmp_name'], $destiny . $imgName);


                $post->title = $_POST['textTitle'];
                $post->text = $_POST['content'];
                $post->id = $_GET['id'];
                $post->img = 'img/uploads/' . $imgName;
                $post->update();
                $_POST= '';
                $_FILES='';
                header('Location:'. BASE_URL . 'read.php');
                
            }else{
                $post->title = $_POST['title'];
                $post->text = $_POST['content'];
                $post->id = $_GET['id'];
                $post->img = $datas[0]->img;
                $post->update();
                $_POST= '';
                $_FILES='';
                header('Location:'. BASE_URL . '../index.php');
            }
    }

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../bridge.css">
    <title>Blog</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="../index.php">Back</a>
    </div>
  </nav>

  <div class="container">

<div class="row">

  <div class="col-lg-12">
  <h2>Actualiza el Post</h2>

    <hr>


    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <div class="input-group input-group-lg">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="addon-wrapping">Titulo</span>
                </div>
                <input type="text" class="form-control" name="title" id="title" aria-label="title" aria-describedby="Titulo" value=<?php 
                    echo $datas[0]->title;
                    ?>>
            </div>


            <input type="file" id="image" name="image" accept="image/png, image/jpeg" class="btn btn-secondary btn-sm  mt-3">
            <div class="card mb-3">
            
            <img src="../../<?php echo $datas[0]->img; ?>" alt="" id="img" class="card-img-top img-responsive">

                <textarea name="content" id="content" rows="5" class="form-control"><?php echo $datas[0]->text; ?></textarea>

                <input type="submit" value="Save" class="btn btn-primary btn-lg btn-block ">
            </div>

        </div>
        
    </form>
       
  </div>
  

</div>


</div>
<footer class="py-5">
        <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Natural Love 2019</p>
        </div>
</footer>


    
    <script>
       window.addEventListener('load', init);

        function init(){
        var inputData = document.querySelector('#image');
        inputData.addEventListener('change',leerArchivos);
        }

        function leerArchivos(e){
        var files = e.target.files;
        var reader = new FileReader();
        reader.addEventListener('load', displayFilesInfo);
        for(var i = 0; i<files.length; i++){
            file = files[i];
            if(file.type.match(/image.*/i)){
            reader.readAsDataURL(file);
            }else{
            console.log('Solo se admiten images .png y .jpg')
            }
            

        };
        }

        function displayFilesInfo(e){
        var resultado = e.target.result;
        var imagen = document.querySelector('#img');
        imagen.setAttribute('src', resultado);
        return;
        }


    </script>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>