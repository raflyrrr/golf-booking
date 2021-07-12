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
        background:linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),  url("assets/img/golfbg.jpg") no-repeat ;
        background-size: 100%;
        background-attachment: fixed;
    }   
</style>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</head>
<body>
    <header>
       <?php include ('navbar.php') ?>
    </header>
    <div class="container mt-5 mb-1">
        <h3>Pemesanan yang sedang berlangsung</h3>
    </div>

    <div class="mb-5">

    <?php
    $username = $_SESSION["username"];
    $now = date('Y-m-d');
    $query = "select * from booking where username = '$username' and status = 'Waiting for Confirmation' order by datecreated desc";
    $query_run = mysqli_query($db_connection,$query);
    while($row = mysqli_fetch_assoc($query_run)){
        $transnum = $row['transnum'];
        $tgl = $row['tgl'];
        $price = $row['price'];
        $status = $row['status'];
        $start_time = $row['start'];
        $duration = $row['duration'];
        $end_time = $start_time+$duration;
        $datecreated = $row['datecreated'];

        $created = strtotime($datecreated); 
        $createdformat = date('d M, h.i a',$created);

        $date = strtotime($tgl);
        $now = date('Y-m-d');
        $newformat = date('l\, F jS Y',$date);

        ?> 
        <!-- modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Batalkan pemesanan</h5>
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
                    <a href="cancelbooking.php?transnum=<?php echo $transnum?>"><button type="button" class="btn btn-primary">Yes</button></a>
                </div>
                </div>
            </div>
        </div>

        <div class="container card shadow-sm mt-4 mb-1" style="width: 1100px; max-width: 100%">
            <div class="card-body">
                <h6 class="card-title">OrderID: <?php echo $transnum?></h6>
                <h4> <?php echo $newformat?> </h4>
                <p class = "text-muted"><?php echo $status?></p> 
                <p>Rp. <?php echo number_format($price)?>  </p>        
                <a href="bookingdetail.php?transnum=<?php echo $transnum;?>"class="card-link"><i class="material-icons">more_horiz</i> Rincian</a> 
                <a href="" class="card-link text-danger" data-toggle="modal" data-target="#exampleModal"> Batalkan pemesanan</a>    
            </div>
            <div class="card-footer text-right">
                    <small class="text-muted"><?php echo $createdformat?></small>
            </div>
        </div>
        <?php
    }
    ?>
    </div>
    
</body>
</html>