<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
</div>

<div class="card mb-3">
  <div class="card-header bg-primary text-white">
    Filter Data Absensi Pegawai PT. Anugrah Laut Indonesia
  </div>
  <div class="card-body">
 	<form class="form-inline" id="showData">	 
	 	<div class="form-group mb-2">
   			Dari Tanggal: <input class="form-control datepicker" data-provide="datepicker" type="text" name="startdate" id="date" style="margin-right: 10px; margin-left: 10px;">
			   Sampai Tanggal: <input class="form-control datepicker" data-provide="datepicker" type="text" name="enddate" id="end_date" style="margin-right: 10px; margin-left: 10px;">
   		</div>
		   <!-- Posisi: <select name="posisi" id="posisi" class="form-control">
					<option value="">-SELECT-</option>
				   <?php foreach($posisi as $p) :?>
					<option value="<?= $p->id_posisi ?>"><?= $p->jenis_posisi ?></option>
					
					<?php endforeach ?>
			   </select> -->

    	<button type="submit" class="btn btn-primary mb-2 ml-auto"><i class="fas fa-eye"></i>Tampilkan Data</button>
		<a class="btn btn-primary mb-2 ml-2" href="<?php echo base_url("admin/dataimport/form"); ?>">Import Data</a><br><br>
    </form>
  </div>
</div>

<?php 
$jml_data = count($absensi);
if($jml_data > 0) { ?>

<table class="table table-bordered table-striped">
	<tr>
		<td class="text-center">No</td>
		<td class="text-center">Tgl Absensi</td>
		<td class="text-center">NIK</td>
		<td class="text-center">Nama Pegawai</td>
		<td class="text-center">Posisi Kerja Hari ini</td>
		<td class="text-center">Shift</td>
		<td class="text-center">Lembur</td>
		<td class="text-center">Total Jam Kerja</td>
		<td class="text-center">Status Kehadiran</td>
	</tr>

	<?php foreach($absensi as $a) : ?>
		<tr>
			<td><?php echo ++$start ?></td>
			<td><?= $a->tgl_input_absensi ?></td>
			<td><?php echo $a->nik ?></td>
			<td><?php echo $a->nama_pegawai ?></td>
			<td><?php echo $a->jenis_posisi ?></td>
			<td><?php echo $a->shift ?></td>
			<td><?php echo $a->lembur ?></td>
			<td><?php echo $a->total_jam_kerja ?></td>
			<td><?php echo $a->status_kehadiran ?></td>
		</tr>
	<?php endforeach; ?>
</table>

<?= $this->pagination->create_links() ?>

<?php }else{ ?>
    <span class="badge badge-danger"><i class="fas fa-info-circle"></i> Data Masih Kosong, Silahkan Input Data Kehadiran Pada Tanggal Yang Anda Pilih! </span>
  <?php } ?>

</div>

<script>
var dp;
window.addEventListener('load', function() {
	console.log('load fired');
	$(document).ready(function() {
		dp = $('.datepicker').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true,
		});
	});
});
</script>