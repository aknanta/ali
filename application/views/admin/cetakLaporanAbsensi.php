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
		<h3>PT. ANUGRAH LAUT INDONESIA</h3>
		<h4>Daftar Laporan Absensi Pegawai</h4>
        <hr>
	</center>
    <table>
		<tr>
			<td>Dari tanggal</td>
			<td></td>
			<td><?php echo date('d M Y', strtotime($startdate)); ?> Sampai : <?php echo date('d M Y', strtotime($enddate)) ?></td>
		</tr>
	</table>
    <br>


    <table class="table table-bordered table-striped">
        <tr>
            <th>No</th>
            <th>Tgl Absen</th>
            <th>NIK</th>
            <th>Nama Pegawai</th>
            <th>Posisi Kerja Hari Ini</th>
            <th>Shift</th>
            <th>Total Jam Kerja</th>
            <th>Lembur</th>
        </tr>
       <?php $no=1; foreach($lap_kehadiran as $l) : ?>	
        <tr>
            <td><?= $no++ ?></td>
            <td><?= date('d-M-Y',strtotime($l->tgl_input_absensi)); ?></td>
            <td><?= $l->nik ?></td>
            <td><?= $l->nama_pegawai ?></td>
            <td><?= $l->jenis_posisi ?></td>
            <td><?= $l->shift ?></td>
            <td><?= $l->total_jam_kerja ?></td>
            <td><?= $l->lembur ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <table width="100%">
		<tr>
			<td></td>
			<td width="200px"></td>
			<p>Jakarta, <?php echo date("d M Y") ?> <br></p>
			<br>
			<br>
			<p>_______________</p>
            <?= $this->session->userdata('nama_pegawai') ?> 
		</tr>
	</table>
</body>
</html>

<script type="text/javascript">
    window.print();
</script>