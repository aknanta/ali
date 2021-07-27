<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
   
</div>

<table class="table table-striped table-bordered">
	<tr>
		<th>Tanggal</th>
		<th>Gaji Harian</th>
		<th>Upah Jam Lembur</th>
		<th>Total Gaji</th>
		<th>Cetak Slip Gaji</th>
	</tr>
		<?php $no=1; foreach($gaji as $g) : ?>
			<?php $upah = $g->upah_jam_lembur * $g->lembur ?>
	<tr>
		<td><?php echo $g->tgl_input_absensi ?></td>
		<td>Rp. <?php echo number_format($g->gaji_harian,0,',','.') ?></td>
		<td>Rp. <?php echo number_format($upah,0,',','.') ?></td>
		<td>Rp. <?php echo number_format($g->gaji_harian+$upah,0,',','.') ?></td>
		<td>
			<center>
				<a class="btn btn-sm btn-primary" href="<?php echo base_url("pegawai/DataGaji/cetakSlipGaji?nik=$g->nik&tanggal=$g->tgl_input_absensi") ?>"><i class="fas fa-print"></i></a>
			</center>
		</td>
	</tr>
<?php endforeach; ?>
</table>
<?php echo $this->pagination->create_links()?>
</div>