<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
   
</div>

<?php echo $this->session->flashdata('pesan')?>
<div class="card mb-3">
  <div class="card-header bg-primary text-white">
    Filter Data Gaji Pegawai PT. Anugrah Laut Indonesia
  </div>
  
  <div class="card-body">

 	<form class="form-inline">
	 <div class="form-group mb-2">
   			Dari Tanggal: <input class="form-control datepicker" data-provide="datepicker" type="text" name="startdate" id="date" style="margin-right: 10px; margin-left: 10px;" autocomplete="off">
			   Sampai Tanggal: <input class="form-control datepicker" data-provide="datepicker" type="text" name="enddate" id="end_date" style="margin-right: 10px; margin-left: 10px;" autocomplete="off">
   		</div>
	
    	<button type="submit" class="btn btn-primary mb-2 ml-auto"><i class="fas fa-eye"></i>Tampilkan Data</button>

    	<?php if(count($gaji) > 0) { ?>
    		<!-- <a href="<?php 
				//echo base_url('admin/dataPenggajian/cetakgaji?bulan='.$bulan),'&tahun='.$tahun; 
				//echo base_url('admin/dataPenggajian/cetakgaji?startdate='.$_GET['startdate'].'&enddate='.$_GET['enddate']);
			?>" class="btn btn-success mb-2 ml-3"><i class="fas fa-print"></i>Cetak Daftar Gaji</a> -->
    		<a href="<?php 
				//echo base_url('admin/dataPenggajian/cetakgaji?bulan='.$bulan),'&tahun='.$tahun; 
				echo base_url('admin/dataPenggajian/generate?startdate='.$_GET['startdate'].'&enddate='.$_GET['enddate']);
			?>" class="btn btn-success mb-2 ml-3"><i class="fas fa-print"></i>Generate Gaji</a>
			
    	  <?php }else{ ?>	
    	  	<!-- <button type="button" class="btn btn-success mb-2 ml-3" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-print"></i>Cetak Daftar Gaji

			</button> -->
    	  <?php } ?>
		<!-- <button class="btn btn-success mb-2 ml-3" id="print">Cetak Daftar Gaji</button> -->
    </form>

  </div>
</div>

<!-- <div class="alert alert-info">
	Menampilkan Data Gaji Pegawai Tanggal : <?= date('d-M-Y', $date) ?>
</div> -->

<?php 
$jml_data = count($gaji);
if($jml_data > 0) { ?>

<div class="table-responsive">
	<table class="table table-bordered table-striped">
		<tr>
			<th class="text-center">No</th>
			<th class="text-center">Tanggal</th>
			<th class="text-center">NIK</th>
			<th class="text-center">Nama Pegawai</th>
			<th class="text-center">Jabatan</th>
			<th class="text-center">Posisi Kerja</th>
			<th class="text-center">Upah Lembur</th>
			<th class="text-center">Gaji Harian</th>
			<th class="text-center">Total Gaji</th>
			<th class="text-center">Generate</th>
		</tr>

		<?php foreach($gaji as $g) : ?>
			<?php $total_lembur = $g->upah_jam_lembur * $g->lembur ?>
		<tr>
			<td><?php echo ++$start ?></td>
			<td><?= $g->tgl_input_absensi ?></td>
			<td><?php echo $g->nik ?></td>
			<td><?php echo $g->nama_pegawai ?></td>
			<td><?php echo $g->nama_jabatan ?></td>
			<td><?php echo $g->jenis_posisi ?></td>
			<td>Rp.<?php echo number_format($total_lembur,0,',','.') ?></td>
			<td>Rp.<?php echo number_format($g->gaji_harian,0,',','.') ?></td>
			<td>Rp.<?php echo number_format($g->gaji_harian + $total_lembur,0,',','.') ?></td>
			<td><?php echo $g->payout ?></td>
		</tr>

	<?php endforeach; ?>
	</table>
	<?php echo $this->pagination->create_links()?>
</div>

<?php }else{ ?>
    <span class="badge badge-danger"><i class="fas fa-info-circle"></i> Data Gaji Masih Kosong, Silahkan Input Data Kehadiran Pada Tanggal Yang Anda Pilih! </span>
  <?php } ?>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Informasi</h5>
      </div>
      <div class="modal-body">
       Informasi Data Gaji Masih Kosong, Silahkan Absensi Terlebih Dahulu Pada Tanggal Yang Anda Pilih!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}
var dp;
window.addEventListener('load', function() {
	console.log('load fired');
	$(document).ready(function() {
		dp = $('.datepicker').datepicker({
			//format: 'yyyy-mm-dd',
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true,
		});
		dp.val(getParameterByName('date'))
		// $('#showData').submit(function (ev) {
		// 	ev.preventDefault();
		// 	window.location.href = "/ali/admin/dataAbsensi";
		// });
	});
	$('#print').on('click', function() {
		window.location.href = "";
	});
});
</script>