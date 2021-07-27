<?php 
$jml_data = count($gaji);
if($jml_data > 0) { ?>
<b>DATA GAJI YANG SUDAH DI GENERATE</b>
<div class="table-responsive">
	<table class="table table-bordered table-striped">
		
		<tr>
			<th class="text-center">No</th>
			<th class="text-center">Tanggal Gaji</th>
			<th class="text-center">NIK</th>
			<th class="text-center">Nama</th>
			<th class="text-center">Posisi Kerja</th>
			<th class="text-center">Gaji Harian</th>
			<th class="text-center">Upah Lembur</th>
			<th class="text-center">Total Gaji</th>
		</tr>
		<?php
		$no=1;
		foreach($gaji as $g) : ?>
		<?php $total_lembur = $g->upah_jam_lembur * $g->lembur ?>
		<tr>
			<td class="text-center"><?php echo $no++ ?></td>
			<td class="text-center"><?php echo date('d-M-Y',strtotime($g->tgl_input_absensi)); ?></td>
			<td class="text-center"><?php echo $g->nik ?></td>
			<td class="text-center"><?php echo $g->nama_pegawai ?></td>
			<td class="text-center"><?php echo $g->jenis_posisi ?></td>
			<td class="text-center">Rp.<?php echo number_format($g->gaji_harian,0,',','.') ?></td>
			<td class="text-center">Rp.<?php echo number_format($total_lembur,0,',','.') ?></td>
			<td class="text-center">Rp.<?php echo number_format(($g->gaji_harian+$total_lembur),0,',','.') ?></td>
		</tr>
	<?php endforeach; ?>
	</table>

</div>
<?php } ?>
<button style="margin-top:10px;" onclick="CloseDetail()" class="btn btn-md btn-danger">
	<i class="fas fa-ban"></i> Close
</button>