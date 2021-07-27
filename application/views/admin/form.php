<html>
<head>
	<title>Form Import</title>

	<!-- Load File jquery.min.js yang ada difolder js -->
	<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

	<script>
	$(document).ready(function(){
		// Sembunyikan alert validasi kosong
		$("#kosong").hide();
	});
	</script>
</head>
<body>
	<h3>Form Import</h3>
	<hr>

	<a href="<?php echo base_url("admin/dataImport/export_excel"); ?>">Download Format</a>
	<br>
	<br>

	<!-- Buat sebuah tag form dan arahkan action nya ke controller ini lagi -->
	<form method="post" action="<?php echo base_url("admin/dataImport/form"); ?>" enctype="multipart/form-data">
		<!--
		-- Buat sebuah input type file
		-- class pull-left berfungsi agar file input berada di sebelah kiri
		-->
		<input type="file" name="file">

		<!--
		-- BUat sebuah tombol submit untuk melakukan preview terlebih dahulu data yang akan di import
		-->
		<input type="submit" name="preview" value="Preview">
	</form>

	<?php
	if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
		if(isset($upload_error)){ // Jika proses upload gagal
			echo "<div style='color: red;'>".$upload_error."</div>"; // Muncul pesan error upload
			die; // stop skrip
		}

		// Buat sebuah tag form untuk proses import data ke database
		echo "<form method='post' action='".base_url("admin/dataimport/import")."'>";

		// Buat sebuah div untuk alert validasi kosong

		echo "<table border='1' cellpadding='8'>
		<tr>
			<th colspan='8'>Preview Data</th>
		</tr>
		<tr>
			<th>Nik</th>
			<th>Tanggal input</th>
			<th>ID posisi</th>
			<th>Shift</th>
            <th>Total jam kerja</th>
            <th>Lembur</th>
            <th>ID Status</th>
            <th>Payout</th>
		</tr>";

		$numrow = 1;
		$kosong = 0;
		

		

		// Lakukan perulangan dari data yang ada di excel
		// $sheet adalah variabel yang dikirim dari controller
		foreach($sheet as $row){
			// Ambil data pada excel sesuai Kolom
			$nik = $row['A']; // Ambil data NIS
			$tgl_input_absensi = $row['B'];
			$stt ="";
			$nama_posisi = "";
			if($row['C'] == 21)
			{
				$nama_posisi = "Office";
			} elseif($row['C'] == 22)
			{
				$nama_posisi = "Processing";
			}elseif($row['C'] == 23)
			{
				$nama_posisi = "Pembekuan";
			}elseif($row['C'] == 24)
			{
				$nama_posisi = "Packaging";
			}elseif($row['C'] == 25)
			{
				$nama_posisi = "Support";
			}
			

			if ($row['G'] == 1) {
				$stt = "Tidak Hadir";
			} elseif ($row['G'] == 2) {
				$stt = "Hadir";
			}


			foreach ($user as $d)  {//iki error mergo foreach e ora keceluk
			$id_posisi = $nama_posisi; //iki error
			$shift = $row['D']; // Ambil data alamat
            $total_jam_kerja = $row['E']; // Ambil data alamat
            $lembur = $row['F']; // Ambil data alamat
			$id_status = $stt; //iki error
			$payout = "Belum"; //iki error
			}

			// Cek jika semua data tidak diisi
			if($nik == "" && $tgl_input_absensi == "" && $id_posisi == "" && $shift == "" && $total_jam_kerja == "" && $lembur == "" && $id_status == "" && $payout == "")
			
				continue; 

			if($numrow > 1){
				// Validasi apakah semua data telah diisi
				$nik_td = ( ! empty($nik))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
				$tgl_td = ( ! empty($tgl_input_absensi))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
				$idpos_td = ( ! empty($id_posisi))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
				$shift_td = ( ! empty($shift))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                $total_td = ( ! empty($total_jam_kerja))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
				$lembur_td = ( ! empty($lembur))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
				$idpot_td = ( ! empty($id_status))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
				$pay_td = ( ! empty($payout))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah

				// Jika salah satu data ada yang kosong
				if($nik == "" && $tgl_input_absensi == "" && $id_posisi == "" && $shift == "" && $total_jam_kerja == "" && $lembur == "" && $id_status == "" && $payout == ""){
					$kosong++; // Tambah 1 variabel $kosong
				}

				echo "<tr>";
				echo "<td".$nik_td.">".$nik."</td>";
				echo "<td".$tgl_td.">".$tgl_input_absensi."</td>";
				echo "<td".$idpos_td.">".$id_posisi."</td>";
				echo "<td".$shift_td.">".$shift."</td>";
                echo "<td".$total_td.">".$total_jam_kerja."</td>";
				echo "<td".$lembur_td.">".$lembur."</td>";
				echo "<td".$idpot_td.">".$id_status."</td>";
				echo "<td".$pay_td.">".$payout."</td>";
				echo "</tr>";
			}

			$numrow++; // Tambah 1 setiap kali looping
		}

		echo "</table>";

		// Cek apakah variabel kosong lebih dari 0
		// Jika lebih dari 0, berarti ada data yang masih kosong
		if($kosong > 0){
		?>
			<script>
			$(document).ready(function(){
				// Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
				$("#jumlah_kosong").html('<?php echo $kosong; ?>');

				$("#kosong").show(); // Munculkan alert validasi kosong
			});
			</script>
		<?php
		}else{ // Jika semua data sudah diisi
			echo "<hr>";

			// Buat sebuah tombol untuk mengimport data ke database
			echo "<button type='submit' name='import'>Import</button>";
			echo "<a href='".base_url("admin/dataimport")."'>Cancel</a>";
		}

		echo "</form>";
	}
	?>
</body>
</html>
