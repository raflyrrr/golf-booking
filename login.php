<?php
$db_connection = mysqli_connect("127.0.0.1", "root","", "letsgolf");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Lets Golf</title>
    <style>
    body { 
        background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url("res/img/golfbg.jpg") no-repeat ;
        background-size: 100%;
    }   
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="res/css/style.css">     
    
</head>
<body>
    <header>
        <?php include('navbar.php'); ?>
       
    </header>
    <div class="container mt-5">
        <h1 class="form-heading">Login</h1>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" name="username" required>
                </div>

                <div class="form-group">
                     <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>

                <p><font color="white"><strong>Belum punya akun? </strong></font><a href = "signup.php"><font color="green"><strong>Daftar</strong></font></a></p>

                <button type="submit" name = "login" class="btn btn-success"><font>Login</font></button>
            </form>
    

    <?php
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = "select password from customer where username = '$username'";
        $query_run = mysqli_query($db_connection,$query);
        $num_rows = mysqli_num_rows($query_run);
        if($num_rows>0){
            $data = mysqli_fetch_assoc($query_run);
            if(password_verify($password, $data['password'])){
                session_start();
                $_SESSION['username'] = $username;
                header("location:home.php");
            }else{
                echo '<div class="alert alert-danger mt-3" role="alert">
                Password yang anda masukkan salah
            </div>';              
            }

        }else{
            echo '<div class="alert alert-danger mt-3" role="alert">
            User tidak ditemukan
        </div>';
        }
    }

    ?>
   
   </div> 


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <?php include('footer.php'); ?>
</body>

</html>