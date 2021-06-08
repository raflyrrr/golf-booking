<?php
$db_connection = mysqli_connect("127.0.0.1", "root", "", "letsgolf");

session_start();
if (!empty($_SESSION['username'])) {
    header("location: home.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lets Golf</title>
    <style class="bg">
        body {
            background: url("assets/img/golfbg.jpg") no-repeat fixed center;
            position: relative;
            background-size: 100%;

        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <?php include('navbar.php'); ?>

</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <?php $query = "select * from field;";
            $query_run = mysqli_query($db_connection, $query);
            while ($row = mysqli_fetch_assoc($query_run)) {

            ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <img src="fieldimages/<?php echo $row['gambar'] ?>" class="card-img-top">
                        <div class="card-body">
                            <h5>Lapangan <?php echo $row['fieldnum'] ?></h5>
                            <p>Harga: Rp. <?php echo number_format( $row['harga'])?></p>
                            <a href="home.php" class="btn btn-success">Booking sekarang!</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>