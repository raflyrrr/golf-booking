<?php
$db_connection = mysqli_connect("127.0.0.1", "root","", "letsgolf");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar - Lets Golf</title>
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
        <h1 class="form-heading">Daftar</h1>
        <form action="signup.php" method="POST">
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" required>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
              </div>
              
             <div class="form-group">
                  <input type="tel" class="form-control" name="phonenum" placeholder="Nomor Telepon" required>
              </div>

             <div class="form-group">
                   <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>

             <div class="form-group">
                 <input type="password" class="form-control" name="repeatpass"  placeholder="Ulangi Password" required>
             </div>

              <p><font color="white"><strong>Sudah punya akun? </strong></font><a href = "login.php"><font color="white"><strong>Login</strong></font></a></p>
                    

              <button type="Sign Up" name="signup" class="btn btn-success"><font color="white">Daftar</font></button>
          </form>                    
    <div>

    <?php
        if(isset($_POST['signup'])){
            $name = $_POST['name'];
            $username = $_POST['username'];
            $phonenum = $_POST['phonenum'];
            $password = $_POST['password'];
            $repeatpass = $_POST['repeatpass'];
            if($repeatpass == $password){
                $query = "select * from customer where username = '$username'";
                $query_run = mysqli_query($db_connection,$query);
                $num_rows = mysqli_num_rows($query_run);
                if(!($num_rows>0)){
                    $query = "select * from customer where phonenum = '$phonenum';";
                    $query_run=mysqli_query($db_connection,$query);
                    $num_rows=mysqli_num_rows($query_run);
                    if(!($num_rows>0)){
                        $hash_pass = password_hash($password,PASSWORD_DEFAULT);
                        $query = "insert into customer (name,username,phonenum,password) values ('$name','$username','$phonenum','$hash_pass')";
                        $query_run=mysqli_query($db_connection,$query);
                        if($query_run){
                            echo'
                                <div class="alert alert-success mt-3" role="alert">
                                    Akun berhasil dibuat!
                                    Silahkan <a href="login.php" class="alert-link">Login</a>
                                </div>
                                ';
                        }else{
                            echo '
                                <div class="alert alert-danger mt-3" role="alert">
                                    Ada yang tidak beres, coba lagi 
                                </div>
                                ';
                        }
                    }else{
                        echo '
                            <div class="alert alert-danger mt-3" role="alert">
                                Nomor telepon sudah digunakan, gunakan nomor telepon lain
                            </div>
                            ';
                    }
                }else{
                    echo '
                        <div class="alert alert-danger mt-3" role="alert">
                            Username sudah digunakan, gunakan username lain
                        </div>
                        ';
                }

            }else{
                echo 
                    '<div class="alert alert-danger mt-3" role="alert">
                        Password tidak cocok, harap periksa password anda
                    </div>';
            }
        }
    ?>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <?php include('footer.php'); ?>
</body>
</html>