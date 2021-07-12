<!DOCTYPE html>
<?php
include "dbConnect.php";
session_start();
if (empty($_SESSION['inputAdmin'])) {
    header("location: adminLogin.php");
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
            <h1>Daftar Lapangan</h1>
            <br>
            <a href="adminAddField.php" class="btn btn-success mb-3">Add</a>
            <?php if (isset($_POST['submit'])) { ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Berhasil</strong> <?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?>
                </div>
            <?php } ?>
            <div class="table-responsive" style="width:90%">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Lapangan</th>
                            <th>Gambar</th>
                            <th>Harga Pagi</th>
                            <th>Harga Sore-Malam</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <?php $query = "select * from field;";
                    $query_run = mysqli_query($db_connection, $query);
                    while ($row = mysqli_fetch_assoc($query_run)) {
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo $row['fieldnum']; ?></td>
                                <td><?php echo "<img src='fieldimages/" . $row['gambar'] . "' height='130' width='150' />"; ?></td>
                                <td>Rp. <?php echo number_format($row['harga']) ?></td>
                                <td>Rp. <?php echo number_format($row['hargamalam'])  ?></td>
                                <td><a href="adminEditPrice.php?fieldnum=<?php echo $row['fieldnum']; ?>" class="btn btn-primary">Edit </a>
                                    <a href="deleteField.php?fieldnum=<?php echo $row['fieldnum']; ?>" class="btn btn-danger">Delete </a>
                                </td>
                            </tr>
                        </tbody><?php } ?>
                </table>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <?php include('footer.php') ?>
</body>

</html>