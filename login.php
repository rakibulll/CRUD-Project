<?php
session_start();
$errMsg = '';
if (
    isset($_POST['login']) &&
    isset($_POST['email']) &&
    isset($_POST['password'])
) {
    //prevent HTML/CSS/JS injection
    $_POST['email'] = htmlspecialchars($_POST['email']);
    $_POST['password'] = htmlspecialchars($_POST['password']);
    if ($_POST['email'] == 'admin@admin.com' && $_POST['password'] == 'admin') {
        $_SESSION['email'] = 'admin@admin.com';
        $_POST['role'] = 'admin';
        header("Location:display_list.php");
    } elseif (
        $_POST['email'] == 'user@user.com' &&
        $_POST['password'] == 'user'
    ) {
        $_SESSION['email'] = 'user@user.com';
        $_POST['role'] = 'user';
        header("Location:display_list.php");
    } else {
        require 'database/database.php';
        $pdo = Database::connect();
        $sql = 'SELECT * FROM persons ' . ' WHERE email = ? ' . ' LIMIT 1';
        $query = $pdo->prepare($sql);
        $query->execute(array($_POST['email']));
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $password = $_POST['password'];
            $password_hash_db = $result['password_hash'];
            $password_salt_db = $result['password_salt'];
            $password_hash = MD5($password . $password_salt_db);
            if (!strcmp($password_hash, $password_hash_db)) {
                $_SESSION['email'] = $result['email'];
                header("Location:display_list.php");
            } else {
                $errMsg = "Login Failed: Wrong email / password";
            }
        } else {
            $errMsg = "Login Failed: Wrong email / password";
        }
    }
}
?>

<DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Crud Applet</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    
    <body>
       
        <div class="jumbotron jumbotron-fluid">
         <div class="container">
            <h1 class="display-4">Crud Applet with Login</h1>
         </div>
        </div>
        <div  class="container">
            <h2>Login</h2>
            <form action="" method="post">
            
            <p style="color: red;"><?php echo $errMsg; ?></p>
            
            <input type="text" class="form-control" name='email' placeholder="Email" required autofocus /> <br />
            
            <input type="password" class="form-control" name="password" placeholder="Password" required  /> <br />
            

            <button class="btn btn-lg btn-primary btn-block" type ="submit" name="login" >Login</button> 
            <button class="btn btn-lg btn-secondary btn-block" onClick="window.location.href='register.php';" type ="button" name="Register" >Register</button>
        </form>
                     <a href="https://github.com/rakibulll/CRUD-Project">Github Source Code</a>

        </div>
       
    </body>
<?php include_once "layout_footer.php"; ?>
