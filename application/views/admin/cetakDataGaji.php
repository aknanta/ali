<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style type="text/css">
        body{
            font-family: Arial;
            color: black;
        }
    </style>
</head>
<body>
		
	<center>
	<img src="<?php echo base_url('/assets/img/logo.png')?>" style="margin-bottom:20px; widh:170px;height:170px"/>
		<h1>PT. Anugrah Laut Indonesia</h1>
		<h2>Daftar Gaji Pegawai</h2>
	</center>
	<tr>
			<td>Tanggal</td>
			<td>:</td>
			<td><?php echo date('d-M-Y', $date) ?>- <?php echo date('d-m-Y',$end_date) ?></td>
		</tr>
	</table>

		<table class="table table-bordered table-striped">
		<tr>
			<th class="text-center">No</th>
			<th class="text-center">Tanggal</th>
			<th class="text-center">NIK</th>
			<th class="text-center">Nama Pegawai</th>
			<th class="text-center">Jabatan</th>
			<th class="text-center">Gaji Harian </th>
			<th class="text-center">Upah Lembur </th>
			<th class="text-center">Total Gaji</th>
			<th class="text-center">Generate</th>

		</tr>
		<?php $no=1; foreach($cetakGaji as $g) : ?>		
		<tr>
		<?php $upah = $g->upah_jam_lembur * $g->lembur ?>
			<td>GJ-<?php echo $no++ ?></td>
			<td><?= date('d-M-Y',$g->tgl_input_absensi); ?></td>
			<td><?php echo $g->nik ?></td>
			<td><?php echo $g->nama_pegawai ?></td>
			<td><?php echo $g->nama_jabatan ?></td>
			<td>Rp.<?php echo number_format($g->gaji_harian,0,',','.') ?></td>
			<td>Rp.<?php echo number_format($upah,0,',','.') ?></td>
			<td>Rp.<?php echo number_format($g->gaji_harian + $upah,0,',','.') ?></td>
			<td><?php echo $g->payout ?></td>
		</tr>

	<?php endforeach; ?>
	</table>

	<table width="100%">
		<tr>
			<td></td>
			<td width="200px"></td>
			<p>Jakarta, <?php echo date("d M Y") ?> <br> <?= $this->session->userdata('nama_pegawai') ?></p>
			<br>
			<br>
			<p>_______________</p>
		</tr>
	</table>

</body>
</html>


<script type="text/javascript">
	window.print();
</script>