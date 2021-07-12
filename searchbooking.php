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
        background:linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url("assets/img/golfbg.jpg") no-repeat fixed center;
        background-size: 100%;
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
    

    <?PHP
    $date=$_GET['date'];
    $field=$_GET['field'];
    $time = strtotime($date);
    $now = date('Y-m-d');
    $newformat = date('l\, F jS Y',$time);
    $day = floor(($time - time())/86400);
    if($day+1 <0 || $day+1 > 7 ){
        header("location:home.php");
    }else{
        echo'<div class="container mt-5 mb-1">';
        echo'<h1><font color="white">Hasil Pencarian</font></h1>';

        echo '
        <div class = row style="max-width:55%">
            <div class="col-md-6 border-right">
            <p  style="display:inline;"><font color="white">'.$newformat.'</font></p>
            </div>
            <div class="col-md-6">
            <p class = "ml-2 mt-2" style="display:inline;"><font color="white">Lapangan '.$field.'</font></p>
            </div>
        </div>';
        
        
        echo '<h4 class = "mt-4 mb-3"><font color="white">Waktu Tersedia</font></h4>';
        echo '<div class="container row mt-1" style="max-width:100%;">';
        //echo $date;
        for($x=7; $x<=23; $x++){
            $available=true;
            $query = "select * from booking where tgl = '$date' and field='$field';";
            $query_run = mysqli_query($db_connection,$query);
            while($row = mysqli_fetch_assoc($query_run)){
                if($row['start'] <= $x && $x < $row['end']){
                    $available = false;
                }
            }
                
            if ($available){
                echo'
                <div class="card  mr-4 mb-2 " style="width:120px;">
                    <div class="card-body">
                        <h5 class="card-title mt-2 text-center">'.$x.'.00 - '. ($x+1) .'.00</h5>
                    </div>
                </div>';  
            } else{
                echo'<div class="card mr-4 mb-2 bg-secondary" style="width:120px;">
                        <div class="card-body dark">
                            <h5 class="card-title mt-2 text-center">'.$x.'.00 - '. ($x+1) .'.00</h5>
                        </div>
                    </div>';
                }
                
            }
            ?>
            </div>      
            <h4 class = "mt-3"><font color="white">Pilih waktu sewa lapangan</font></h4>
            <div class="mt-3 mb-1" style="max-width: 60%">
                <form method="post">
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <input type="number" min=7 max=23  name="start_time" class="form-control"  placeholder="Waktu Mulai" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <input type="number" min=1 max=5 name = "duration" class="form-control"  placeholder="Durasi (Jam)" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success mb-2" name="book"><font color="white">Booking sekarang!</font></button>           
                        </div>  
                    </div>
                </form>
            </div>

            <?php
            }?>

    <!-- modal -->
    <div class="modal fade" id="exampleModal" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Order Summary</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $start_time;?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal end -->

    
    
    <?php
    if(isset($_POST['book'])){
        $start_time = $_POST["start_time"];
        $duration = $_POST["duration"];
        $end_time = $start_time + $duration;
        $conflict = false;
        $query = "select * from booking where tgl = '$date' and field='$field';";
        $query_run = mysqli_query($db_connection,$query);
        while($row = mysqli_fetch_assoc($query_run)){
            if( ($start_time <= $row['start'] && $end_time >= $row['end']) || ($start_time>=$row['start'] && $start_time<$row['end']) || ($end_time>$row['start'] && $end_time<=$row['end']) ){
                $conflict = true;
            }
        }
        if($conflict){
                echo'
                <div class="alert alert-danger mt-3 mb-1" style="max-width: 80%" role="alert">
                <h5 class="alert-heading">Waktu tidak tersedia</h5>
                Masukkan waktu yang tersedia
                </div>
                ';
        }else{
                //echo '<script>$("#exampleModal").modal()</script>';
                ?>
                <h4 class = "mt-5" style="color: white;">Ringkasan Pemesanan</h4>
                <form method = "post" class="mt-3 mb-1" style="max-width: 60%">
                    <div class="form-group row">
                        <?php
                        $username = $_SESSION["username"];
                        $query = "select name from customer where username = '$username'";
                        $query_run = mysqli_query($db_connection,$query);
                        $row = mysqli_fetch_assoc($query_run);
                        $name = $row['name'] 
                        ?>
                        <label for="staticEmail" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" value=": <?php echo $name;?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="inputPassword" value=": <?php echo $newformat;?>">
                            </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Nama Lapangan</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="inputPassword" value=": <?php echo $field;?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Waktu Mulai</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="inputPassword" value=": <?php echo $start_time.'.00 - '.$end_time.'.00';?> WIB">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Durasi</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext " id="inputPassword" value=": <?php echo $duration.' Jam';?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Total Harga</label>
                        <div class="col-sm-10">
                            <?php
                             $queryHarga = "select * from field where harga and fieldnum = '$field';";
                             $query_run = mysqli_query($db_connection,$queryHarga);
                             while($row = mysqli_fetch_assoc($query_run)){
                                
                             
                            $price=0;
                            $price_count = $start_time;
                            $day_num = date('N',$time);
                            for($x=0;$x<$duration;$x++){
                                if($price_count+1>=8 && $price_count<14){
                                    if($field){
                                        if ($day_num>=1){
                                            $price = $price + $row['harga'];
                                        }
                                    }
                                }else{
                                    if($field){
                                        if ($day_num>=1){
                                            $price = $price + $row['hargamalam'];
                                        }
                                    }
                                }
                                $price_count=$price_count+1;
                            }}
                            ?>
                            <input type="text" readonly class="form-control-plaintext font-weight-bold" id="inputPassword" value=": Rp. <?php echo number_format($price) ?>">
                        </div> 
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <?php
                            $_SESSION['date'] = $date;
                            $_SESSION['field'] = $field;
                            $_SESSION["duration"] = $duration ;
                            $_SESSION["price"] = $price;
                            $_SESSION["start_time"] = $start_time;
                            ?>
                            <a href=book.php><button type="button" class="btn btn-success mb-5" name="confirm">Konfirmasi</button></a>           
                        </div>  
                    </div>

                </form>
                <?php
                if(isset($_POST['confirm'])){
                    $query = "  insert into booking (tgl,start,end,duration,username,fieldnum) values 
                                ('$date',$start_time,$end_time,$duration,$username,'$field');";
                    $query_run = mysqli_query($db_connection,$query);
                    if($query_run){
                        echo 'Sukses booking';
                    }else{
                        echo "Terjadi beberapa kesalahan, coba lagi!";
                    }
                }

            }
        
        
        
    }  
    ?>

    
    
</body>
</html>