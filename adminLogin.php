<?php
include "dbConnect.php";

session_start();
if (!empty($_SESSION['inputAdmin'])) {
    header("location: adminHome.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Lets Golf</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="res/css/style.css">
</head>

<body id="LoginAdminForm">
    <header>
        <nav class="container navbar navbar-expand-lg navbar-light sticky-top">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="adminLogin.php">Admin</a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <br><br>
        <h1 class="form-heading">Lets Golf</h1>
        <div class="login-form">
            <div class="main-div">
                <div class="panel">
                </div>
                <form action="adminLogin.php" method="post">

                    <div class="form-group">
                        <input type="text" class="form-control" name="inputAdmin" placeholder="Username" style="width:50%" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="inputPassword" placeholder="Password" style="width:50%" required>
                    </div>

                    <button type="submit" name="adminLogin" class="btn btn-primary">Login</button>

                </form>
            </div>
        </div>

        <?php
        if (isset($_POST['adminLogin'])) {
            $inputAdmin = $_POST['inputAdmin'];
            $inputPassword = $_POST['inputPassword'];
            echo $inputAdmin;
            $query = "select password from customer where username = '$inputAdmin' and role='admin'";
            $query_run = mysqli_query($db_connection, $query);
            $num_rows = mysqli_num_rows($query_run);
            if ($num_rows > 0) {
                $data = mysqli_fetch_assoc($query_run);
                if ($inputPassword == $data['password']) {
                    session_start();
                    $_SESSION['inputAdmin'] = $inputAdmin;
                    header("location:adminHome.php");
                } else {
                    echo  '<div class="alert alert-danger mt-3" role="alert">
                Password yang anda masukkan salah
            </div>';
                }
            } else {
                echo '<div class="alert alert-danger mt-3" role="alert">
            User tidak ditemukan
        </div>';
            }
        }

        ?>
    </div>
    <?php include ('footer.php')?>
</body>

</html>