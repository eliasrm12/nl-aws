
<?php

  session_start();

  if (!isset($_SESSION['user'])) {
    header('Location:login.php');
  }

header('Cache-Control: no-cache');

require_once 'post.php';

$post = new Post();

$datas = $post->getAll();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="bridge.css">
    <title>Blog</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container ">
      <div class="d-flex justify-content-between">
        <a class="navbar-brand" href="../">Natural Love</a>
        <a class="navbar-brand" href="./admin/create.php">Crear Nuevo Post</a>
        <a class="navbar-brand" href="./close_session.php">Sing out</a>
      </div>
    </div>
  </nav>


  <div class="container">

<div class="row">
<h2>Lista de Posts</h2>

<?php   foreach($datas as $data): ?>

  <div class="col-lg-12">

    <h2 class="col-md-12"><?php echo $data->title ?></h2>

    <hr>

    <div class="card mb-3">
            

        <img src="../<?php echo $data->img; ?> "alt='' id="img" class="card-img-top img-responsive">

        <div class="card-body">
            <pre class="lead"><?php echo $data->text;?></pre>
        </div>
        <hr>

        <div class="card-body d-flex justify-content-between">
        <a class="btn btn-success w-50" href="admin/update.php?id=<?php echo $data->id ?>">Edit</a>

        <a class="btn btn-danger  w-50" href="admin/delete.php?id=<?php echo $data->id ?>">Delete</a>
        </div>
    </div>
    
       
  </div>

</div>
<?php endforeach; ?>



</div>

<footer class="py-5">
    <div class="container">
    <p class="m-0 text-center text-white">Copyright &copy; Natural Love 2019</p>
    </div>
</footer>


    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
