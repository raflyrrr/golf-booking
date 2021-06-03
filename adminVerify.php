<!DOCTYPE html>
<?php
session_start();
if (empty($_SESSION['inputAdmin'])) {
	header("location: adminLogin.php");
}
?>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Lets Golf</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

	<link rel="stylesheet" href="res/css/style.css">

	<style>
		.align-middle {
			vertical-align: middle !important;
		}
	</style>
</head>

<body>
	<div class="site-content">
		<header>
			<nav class="navbar navbar-expand-lg navbar-light sticky-top">
				<a href="adminHome.php" class="nav-brand ml-3 mr-5">
					<h4>Lets Golf</h4>
				</a>
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="adminVerify.php" style="margin-right:20px">Verifikasi</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="adminTransaction.php" style="margin-right:20px">Transaksi</a>
					</li>
					<li class="nav-item">
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
			<h1>Verifikasi Booking</h1>
			<br>
			<?php
			include "dbConnect.php";
			$sql = mysqli_query($db_connection, "SELECT * FROM verifikasi order by tgl desc");

			$sql2 = mysqli_query($db_connection, "SELECT COUNT(*) AS jumlah FROM verifikasi");
			$get_jumlah = mysqli_fetch_array($sql2);
			?>
			<?php echo $get_jumlah['jumlah']; ?> data(s) waiting for confirmation.<br><br>


			<input type='hidden' id='sort' value='asc'>
			<div class="table-responsive" style="width:90%">
				<table class="table table-bordered table-striped" id='empTable'>
					<thead>
						<tr>
							<th><span onclick='sortTable("username");'>Username</span></th>
							<th><span onclick='sortTable("phonenum");'>Nomor Telepon</span></th>
							<th><span onclick='sortTable("tgl");'>Tanggal</span></th>
							<th><span onclick='sortTable("start");'>Mulai</span></th>
							<th><span onclick='sortTable("end");'>Selesai</span></th>
							<th><span onclick='sortTable("duration");'>Durasi</span></th>
							<th><span onclick='sortTable("fieldnum");'>No. Lapangan</span></th>
							<th>Aksi</th>
						</tr>
					</thead>
					<?php
					while ($data = mysqli_fetch_array($sql)) {
					?>
						<tbody>
							<tr>
								<td class="align-middle"><?php echo $data['username']; ?></td>
								<td class="align-middle"><?php echo $data['phonenum']; ?></td>
								<td class="align-middle"><?php echo $data['tgl']; ?></td>
								<td class="align-middle"><?php echo $data['start']; ?>.00</td>
								<td class="align-middle"><?php echo $data['end']; ?>.00</td>
								<td class="align-middle"><?php echo $data['duration']; ?> Jam</td>
								<td class="align-middle"><?php echo $data['fieldnum']; ?></td>
								<td><a href="responseAccept.php?transnum=<?php echo $data['transnum']; ?>" class="btn btn-success">Accept</a>
									<a href="responseReject.php?transnum=<?php echo $data['transnum']; ?>" class="btn btn-danger">Reject</a>
								</td>
							</tr>
						</tbody>
					<?php
					}
					?>
				</table>
			</div>

		</div>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/ajax.js"></script>
	<script>
		function sortTable(columnName) {

			var sort = $("#sort").val();
			$.ajax({
				url: 'verif_fetch_details.php',
				type: 'post',
				data: {
					columnName: columnName,
					sort: sort
				},
				success: function(response) {

					$("#empTable tr:not(:first)").remove();

					$("#empTable").append(response);
					if (sort == "asc") {
						$("#sort").val("desc");
					} else {
						$("#sort").val("asc");
					}

				}
			});
		}
	</script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <?php include ('footer.php')?>
</body>

</html>