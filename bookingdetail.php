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
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url("assets/img/golfbg.jpg") no-repeat;
            background-size: 100%;
            background-attachment: fixed;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</head>

<body>

    <header>
        <?php include('navbar.php') ?>
    </header>

    <?php
    $username = $_SESSION['username'];
    $query = "select name from customer where username = '$username'";
    $query_run = mysqli_query($db_connection, $query);
    $row = mysqli_fetch_assoc($query_run);
    $name = $row['name'];

    $transnum = $_GET['transnum'];
    $query = "select * from booking where transnum = $transnum";
    $query_run = mysqli_query($db_connection, $query);
    $row = mysqli_fetch_assoc($query_run);
    $tgl = $row['tgl'];
    $start_time = $row['start'];
    $duration = $row['duration'];
    $end_time = $start_time + $duration;
    $field = $row['field'];
    $price = $row['price'];
    $status = $row['status'];
    $datecreated = $row['datecreated'];

    $created = strtotime($datecreated);
    $createdformat = date('d M, h.i a', $created);

    $date = strtotime($tgl);
    $now = date('Y-m-d');
    $newformat = date('l\, F jS Y', $date);

    ?>

    <!-- <p class = "mt-3 ml-4 mb-1">OrderID:</p>
    <p class = "mt-3 ml-4">Booking for:</p>
    <h3 class = "mt-3 ml-4 mb-1">day, MM DD YYYY</h2> -->

    <div class="container card shadow-sm mt-4" style="width:900px; max-width: 90%">
        <div class="card-body">
            <div class=border-bottom>
                <div class="row">
                    <div class="col ">
                        <h3>Rincian Booking</h3>
                    </div>
                    <div class="col  card-title">
                        <p class="text-right"><?php echo $createdformat; ?></p>
                        <p class="text-right">OrderID: <?php echo $transnum ?></p>
                    </div>
                </div>
            </div>

            <div class="border-bottom mt-3 mb-3">
                <div class="mb-3">
                    <p class="text-muted">Order By</p>
                    <h4><?php echo $name; ?></h4>
                    <?php echo $username; ?>
                </div>
            </div>

            <div class="border-bottom mt-3 mb-1">
                <div class="mb-4">
                    <p class="text-muted">Rincian Pemesanan:</p>
                    <p class="card-title">Tanggal Booking:</p>
                    <h4 class="mb-3"><?php echo $newformat; ?></h4>
                    <p class="card-title">Waktu Booking:</p>
                    <h6 class="mb-3"><?php echo $start_time; ?>.00 - <?php echo $end_time; ?>.00</h6>
                    <p class="card-title">Durasi Booking:</p>

                    <h6 class="mb-3"><?php echo $duration ?> Jam</h6>
                    <p class="card-title">Nama Lapangan:</p>

                    <h6 class="mb-3"><?php echo $field ?></h6>
                    <p class="card-title">Status:</p>

                    <h6 class="mb-3"><?php echo $status ?></h6>
                </div>
            </div>

            <div class="mt-3 mb-1">
                <div class="mb-1">
                    <p class="text-muted">Total Harga:</p>
                    <h4>Rp. <?php echo number_format($price); ?></h4>
                </div>
            </div>
        </div>

        <!-- modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Batalkan Pemesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin?<br>
                        Anda tidak dapat membatalkan tindakan ini
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <a href="cancelbooking.php?transnum=<?php echo $transnum ?>"><button type="button" class="btn btn-primary">Yes</button></a>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if ($status == "Waiting for Confirmation" && $tgl >= $now) {
        ?>

            <div class="container mb-2">
                <div class="mb-1">
                    Untuk pembayaran silahkan dapat transfer di rekening dibawah ini :
                    <br>
                    <br>
                    <img src="assets/img/bca.svg" width="80px" class="mr-3">Bank BCA
                    <br>
                    <p class="mt-2">No. Rekening 012345-123-123-123 atas nama <span class="norek">Lets Golf</span></p>
                </div>
                <div class="mt-4 mb-4">
                    <a href="https://api.whatsapp.com/send?phone=6289653455762&text=Halo%2C%20saya%20ingin%20mengkonfirmasi%20pembayaran%20dengan%20Order%20id%3A%20<?php echo $transnum ?>%2C%20Username%3A%20<?php echo $username ?>%2C%20Total%20pembayaran%3A%20Rp.<?php echo $price ?>" class="btn btn-success" target="_blank"><i class="fab fa-whatsapp"></i> Konfirmasi Pembayaran</a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                        Batalkan Pemesanan
                    </button>
                </div>
            </div>
    </div>

<?php

        }
?>

<?Php //echo(time_elapsed_string($datecreated));




?>



</body>

</html>