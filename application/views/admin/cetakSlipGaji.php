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
		<h4>Daftar Slip Gaji Pegawai</h4>
        <hr>
	</center>
    <?php $no=1; foreach($print_slip as $ps) : ?>
    <table>
        <tr>
            <td>Nama Pegawai</td>
            <td>:</td>
            <td><?= $ps->nama_pegawai ?></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td><?= $ps->nik ?></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td><?= $ps->nama_jabatan ?></td>
        </tr>
        <tr>
            <td>Posisi</td>
            <td>:</td>
            <td><?= $ps->jenis_posisi ?></td>
        </tr>
    </table>
        <?php $upah = $ps->upah_jam_lembur * $ps->lembur ?>
    <table class="table table-striped table-bordered mt-3">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Gajian</th>
            <th class="text-center">Upah Lembur </th>
            <th class="text-center">Total Gaji</th>
        </tr>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= date('d-M-Y',strtotime($ps->tgl_input_absensi)); ?></td>
            <td>Rp.<?php echo number_format($ps->gaji_harian,0,',','.') ?></td>
            <td>Rp.<?php echo number_format($upah,0,',','.') ?></td>
			<td>Rp.<?php echo number_format($ps->gaji_harian + $upah,0,',','.') ?></td>

        </tr>
    </table>
    <table width="100%">
        <tr>
            <td></td>
            <td>
                <p>Pegawai</p>
                <br>
                <br>
                <p class="font-weight-bold"><?= $ps->nama_pegawai ?></p>
            </td>
            <td width="200px">
                <p>Jakarta, <?= date("d M Y") ?> <br> Finance,</p>
                <br>
                <br>
                <p>__________________________________</p>
            </td>
        </tr>
    </table>
    <?php endforeach; ?>
</body>
</html>
<script type="text/javascript">
    window.print();
</script>