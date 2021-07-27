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
   		 	<input class="form-control datepicker" data-provide="datepicker" type="text" name="date" id="date" autocomplete="off">
   		</div>
    	<a href="#" class="btn btn-success mb-2 ml-3" onclick="
			window.location.href = '<?php echo base_url('admin/dataAbsen/inputAbsen') ?>?date=' + document.getElementById('date').value;
		"><i class="fas fa-plus"></i>Input Kehadiran</a>
    </form>
  </div>
</div>


<!-- <div class="alert alert-info">
	Menampilkan Data Kehadiran Pegawai Bulan : <span class="font-weight-bold"><?php echo $bulan ?></span> Tahun : <span class="font-weight-bold"><?php echo $tahun ?></span>
</div> -->



</div>

<script>
var dp;
window.addEventListener('load', function() {
	console.log('load fired');
	$(document).ready(function() {
		dp = $('.datepicker').datepicker({
			//format: 'yyyy-mm-dd',
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,
		});
		// $('#showData').submit(function (ev) {
		// 	ev.preventDefault();
		// 	window.location.href = "/ali/admin/dataAbsensi";
		// });
	});
});
</script>