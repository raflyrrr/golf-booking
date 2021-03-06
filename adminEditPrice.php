<!DOCTYPE html>
<?php
include "dbConnect.php";
session_start();
if (empty($_SESSION['inputAdmin'])) {
    header("location: adminLogin.php");
}


if (isset($_POST['submit'])) {
    $fieldnum = $_POST['fieldnum'];
    $harga = $_POST['harga'];
    $hargamalam = $_POST['hargamalam'];
    $gambar = $_FILES['gambar']['name'];
    $id = $_GET['fieldnum'];
    $dir = "fieldimages/";
    if (!is_dir($dir)) {
        mkdir("fieldimages/");
    }

    move_uploaded_file($_FILES["gambar"]["tmp_name"], "fieldimages/" . $_FILES["gambar"]["name"]);
    $sql = mysqli_query($db_connection, "update field set fieldnum='$fieldnum',harga='$harga',hargamalam='$hargamalam',gambar='$gambar' where fieldnum='$id'");
    $_SESSION['msg'] = "memperbarui data";
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lets Golf</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="site-content">
        <header>
            <nav class="navbar navbar-expand-lg navbar-light sticky-top">
                <a href="adminHome.php" class="nav-brand ml-3 mr-5">
                    <h4>Lets Golf</h4>
                </a>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="adminVerify.php" style="margin-right:20px">Verifikasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminTransaction.php" style="margin-right:20px">Transaksi</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="adminField.php" style="margin-right:20px">Daftar Lapangan</a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto mr-3">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Admin
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="adminLogout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>

        <div class="landing-text ml-5 mt-3">
            <h1>Edit Lapangan</h1>
            <?php if (isset($_POST['submit'])) { ?>
                <div class="alert alert-success col-md-3 mt-4">
                    <button type="button" class="close" data-dismiss="alert">??</button>
                    <strong>Berhasil</strong> <?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?>
                </div>
            <?php } ?>
            <form class="mt-5" method="post" enctype="multipart/form-data">
                <?php
                $id = $_GET['fieldnum'];
                $query = "select * from field where fieldnum = '$id';";
                $query_run = mysqli_query($db_connection, $query);
                while ($row = mysqli_fetch_assoc($query_run)) {
                ?>
                    <div class="control-group">
                        <label class="control-label" for="basicinput">Nama Lapangan</label>
                        <div class="controls">
                            <input type="text" name="fieldnum" required value="<?php echo $row['fieldnum'] ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label mt-3" for="basicinput">Harga Pagi</label>
                        <div class="controls">
                            <input type="text" name="harga" required value="<?php echo $row['harga'] ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label mt-3" for="basicinput">Harga Sore-Malam</label>
                        <div class="controls">
                            <input type="text" name="hargamalam" required value="<?php echo $row['hargamalam'] ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label mt-3" for="basicinput">Gambar</label>
                        <div class="controls">
                            <img src="fieldimages/<?php echo $row['gambar'] ?>" style="width:250px;"><br><br>
                            <input type="file" name="gambar" required>
                        </div>
                    </div>

                <?php } ?>
                <div class="control-group mb-5">
                    <div class="controls">
                        <a href="adminField.php" class="btn btn-primary mt-3" role="button">Kembali</a>
                        <button type="submit" name="submit" class="btn btn-success mt-3">Perbarui</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <?php include ('footer.php')?>
</body>

</html>