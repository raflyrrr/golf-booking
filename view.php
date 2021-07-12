<script src='jquery-3.3.1.min.js' type='text/javascript'></script>

	<input type='hidden' id='sort' value='asc'>
	<div class="table-responsive" style="width: 90%;">
		<table class="table table-bordered table-striped" id='empTable' >
			<thead><tr>
			<th><span onclick='sortTable("tgl");'>Tanggal</span></th>
				<th><span onclick='sortTable("username");'>Username</span></th>
				<th ><span onclick='sortTable("phonenum");'>No. Telepon</span></th>
				<th><span onclick='sortTable("start");'>Mulai</span></th>
				<th><span onclick='sortTable("end");'>Selesai</span></th>
				<th><span onclick='sortTable("duration");'>Durasi</span></th>
				<th><span onclick='sortTable("fieldnum");'>Nama Lapangan</span></th>
				<th><span onclick='sortTable("price");'>Harga</span></th>
				<th><span onclick='sortTable("price");'>Status</span></th>
				<th>Aksi</th>
			</tr></thead>
			<?php
			include "dbConnect.php";
			

			if(isset($_POST['search']) && $_POST['search'] == true){ 
				$param = '%'.mysqli_real_escape_string($db_connection, $keyword).'%';
				
				$sql = mysqli_query($db_connection, "SELECT * FROM transaksi WHERE username LIKE '".$param."' OR tgl LIKE '".$param."' OR tipe LIKE '".$param."' OR phonenum like '".$param."'");
				
				$sql2 = mysqli_query($db_connection, "SELECT COUNT(*) AS jumlah FROM transaksi WHERE username LIKE '".$param."' OR tgl LIKE '".$param."' OR tipe LIKE '".$param."' OR phonenum like '".$param."'");
				$get_jumlah = mysqli_fetch_array($sql2);
				$sql3 = mysqli_query($db_connection, "SELECT sum(price) as total from transaksi WHERE username LIKE '".$param."' OR tgl LIKE '".$param."' OR tipe LIKE '".$param."' OR phonenum like '".$param."'");
				$data2 = mysqli_fetch_array($sql3);

				$sqlacc = mysqli_query($db_connection, "SELECT COUNT(*) AS jumlahaccept FROM transaksi where status ='Accepted' AND username LIKE '".$param."' OR tgl LIKE '".$param."' OR tipe LIKE '".$param."' OR phonenum like '".$param."'");
				$get_sqlacc = mysqli_fetch_array($sqlacc);
			}else{ 
				$sql = mysqli_query($db_connection, "select * from transaksi order by tgl desc");
				
				$sql2 = mysqli_query($db_connection, "SELECT COUNT(*) AS jumlah FROM transaksi");
				$get_jumlah = mysqli_fetch_array($sql2);

				$sql3 = mysqli_query($db_connection, "select sum(price) as total from transaksi");
				$data2 = mysqli_fetch_array($sql3);

				$sqlacc = mysqli_query($db_connection, "SELECT COUNT(*) AS jumlahaccept FROM transaksi where status ='Accepted'");
				$get_sqlacc = mysqli_fetch_array($sqlacc);
			}
			
			while($data = mysqli_fetch_array($sql)){ 
				?>
					<tbody><tr>
						<td class="align-middle"><?php echo $data['tgl']; ?></td>
						<td class="align-middle"><?php echo $data['username']; ?></td>
						<td class="align-middle"><?php echo $data['phonenum']; ?></td>
						<td class="align-middle"><?php echo $data['start']; ?>.00</td>
						<td class="align-middle"><?php echo $data['end']; ?>.00</td>
						<td class="align-middle"><?php echo $data['duration']; ?> Jam</td>
						<td class="align-middle"><?php echo $data['fieldnum']; ?></td>
						<td class="align-middle">Rp. <?php echo number_format( $data['price']) ?></td>
						<td class="align-middle"><?php echo $data['status']; ?></td>
						<td><a href="delete.php?transnum=<?php echo $data['transnum']; ?>" class="btn btn-danger">Delete</a></td>
					</tr></tbody>
				<?php
				}
				?>

			</table>
			Total data = <?php echo $get_jumlah['jumlah']; ?> data ditemukan. (<?php echo $get_sqlacc['jumlahaccept']; ?> accepted)<br>
			Total pemasukan = Rp. <?php echo number_format( $data2['total'] )?>
	</div>
<script>
        function sortTable(columnName){
            
            var sort = $("#sort").val();
            $.ajax({
                url:'fetch_details.php',
                type:'post',
                data:{columnName:columnName,sort:sort},
                success: function(response){
            
                    $("#empTable tr:not(:first)").remove();
                    
                    $("#empTable").append(response);
                    if(sort == "asc"){
                        $("#sort").val("desc");
                    }else{
                        $("#sort").val("asc");
                    }
                                
                }
            });
        }
    </script>