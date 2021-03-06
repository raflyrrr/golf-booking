<?php
$db_connection = mysqli_connect("127.0.0.1", "root", "", "letsgolf");

session_start();
if (empty($_SESSION['username'])) {
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Lets Golf</title>
    <style class="img-fluid">
        body {
            background:linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url("assets/img/golfbg.jpg") no-repeat fixed center;
            background-size: 100%;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

    <header>
        <?php include ('navbar.php') ?>
    </header>


    <div class="container mt-5 mb-1">
        <h1>
            <font color="white">Booking</font>
        </h1>
        <p>
            <font color="white">Cari Lapangan yang tersedia</font>
        </p>


        <form action="home.php" method="POST" class="form-inline">
            <div class="form-group mb-2">
                <input type="date" class="form-control" name="date" required>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <div class="form-group">
                    <select name="field" class="form-control" required>      
                    <?php $query = "select fieldnum from field;";
                    $query_run = mysqli_query($db_connection, $query);
                    while ($row = mysqli_fetch_assoc($query_run)) {
                    ?>               
                      <option value="<?php echo $row['fieldnum']; ?>">Lapangan <?php echo $row['fieldnum'] ?> </option>     
                      <?php }?>                 
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-success mb-2" name="date_search">
                <font color="white">Search!</font>
            </button>
        </form>
    

    <?PHP
    if (isset($_POST['date_search'])) {
        $field = $_POST['field'];
        $date = $_POST['date'];
        $time = strtotime($date);
        $now = date('Y-m-d');
        $newformat = date('l\, F jS Y', $time);

        $day = floor(($time - time()) / 86400);
        if ($day + 1 < 0 || $day + 1 > 7) {
            echo '
            <div class="alert alert-danger mt-3 mb-1" style="max-width: 50%" role="alert">
            <h5 class="alert-heading">Tanggal tidak tersedia</h5>
            Harap masukkan tanggal dalam 7 hari ke depan dari hari ini!
            </div>
            ';
        } else {
            header("location: searchbooking.php?date=" . $date . "&field=" . $field);
        }
        echo '</div>';
    }
    ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>


</html>