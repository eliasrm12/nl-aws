<?php
require_once 'connection.php';
class Login extends Connection
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $table;
    private $pdo;

    public function __construct(){
        $this->table = 'users';
        $this->pdo = parent::conexion();
    }


    public function getById($email){

        try{
            $stm = $this->pdo->prepare("SELECT * FROM $this->table WHERE email=?");
            $stm->execute(array($email));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }catch(PDOExeption $e){
            echo $e->getMessage();
        }
    }
}

$login = new Login();



if( $_SERVER['REQUEST_METHOD']=='POST'){
    $email = $_POST['user'];

    $password = $_POST['password'];
    

    $consulta = $login->getById($email);

    if($consulta[0]->email == $email && password_verify($password ,$consulta[0]->password)){

        session_start();
        $_SESSION['user'] = $_POST['user'];
        header('Location:index.php');
    }else{
        header('Location:login.php');
    }
    
}
// <?php echo '<h1>Hola Mundo</h1>' . password_hash(1234, PASSWORD_DEFAULT); ?>

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#deebe1">
    <link rel="shortcut icon" href="../img/natural-love.ico">
    <link rel="stylesheet" href="../bridge.css">
    <title>Login CMS Natural Love</title>

    <style>

        body{
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            font-family: 'nunito';
            background: url(../img/bg_login.png) no-repeat center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
        }
    

    /*
        https://www.chromium.org/developers/design-documents/create-amazing-password-forms
    */
    
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Login</h1>
        <form action="login.php" class="login-form" method="post">
            <div class="text-box">
                <label for="user"></label>
                <input type="text" id="user" name="user" value="" placeholder="Username">
                <div class="under"></div>
            </div>
        
            <div class="text-box">
                <label for="password"></label>
                <input type="password" name="password" id="password" value="" placeholder="Password">
                <div class="under"></div>
            </div>
            <input type="submit" class="btn" value="Login">
        </form>
    </div>
</body>
</html>