<?php
$db_connection = mysqli_connect("127.0.0.1", "root","", "letsgolf");
session_start();
if(empty($_SESSION['username'])){
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
        background:linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url("res/img/golfbg.jpg") no-repeat ;
        background-size: 100%;
        background-attachment: fixed;
    }   
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="res/css/style.css">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <?php include ('navbar.php') ?>
    </header>

    <div class="container mt-5 mb-1">
        <h3>Riwayat Booking</h3>
    </div>

    <!-- <div class="card shadow-sm mt-3 ml-4 mb-1" style="width: 900px; max-width: 90%">
        <div class="card-body">
            <div class="row">
                <div class="col ">
                    <h4> Day, DD MM YYYY </h4>
                    <p class = "text-muted">Status</p>
                    xx.00 - xy.00   

                </div>
                <div class="col text-right">
                <a href="bookingdetail.php?transnum=<?php echo $transnum;?>"class="card-link"><i class="material-icons">more_horiz</i> Detail</a> 
                </div>
            </div>
        </div>
    </div> -->

    <div class="mb-5">

    <?php
    $username = $_SESSION["username"];
    $now = date('Y-m-d');
    $query = "select * from booking where username = '$username' order by datecreated desc";
    $query_run = mysqli_query($db_connection,$query);
    while($row = mysqli_fetch_assoc($query_run)){
        $transnum = $row['transnum'];
        $tgl = $row['tgl'];
        $price = $row['price'];
        $status = $row['status'];
        $start_time = $row['start'];
        $duration = $row['duration'];
        $end_time = $start_time+$duration;

        $date = strtotime($tgl);
        $now = date('Y-m-d');
        $newformat = date('l\, F jS Y',$date);

        ?> 
        <div class="container card shadow-sm mt-3 mb-1" style="width: 1100px; max-width: 100%">
            <div class="card-body">
                <div class="row">
                    <div class="col ">
                        <h4> <?php echo $newformat?> </h4>
                        <p class = "text-muted"><?php echo $status?></p>
                        <!-- <h6><?php echo $start_time.'.00 - '.$end_time.'.00'?></h6> -->
                    </div>
                    <div class="col text-right">
                    <a href="bookingdetail.php?transnum=<?php echo $transnum;?>"class="card-link"><i class="material-icons">more_horiz</i> Rincian</a> 
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    </div>
</body>
</html>