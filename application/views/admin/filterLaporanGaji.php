<div class="container-fluid">

<div class="card mx-auto" style="width: 35%" >
	<div class="card-header bg-primary text-white text-center">
		Filter Laporan Gaji Pegawai
	</div>

	<form method="GET" action="<?php echo base_url('admin/laporanGaji/cetakLaporanGaji') ?>">
	<div class="card-body">
		<div class="form-group row">
		Tanggal<input class="form-control datepicker" data-provide="datepicker" type="text" name="startdate" id="date" autocomplete="off">
		</div>
		<div class="form-group row">
		Sampai<input class="form-control datepicker" data-provide="datepicker" type="text" name="enddate" id="end_date" autocomplete="off">
		</div>
		<button style="width: 100%" type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Cetak Laporan Gaji</button>
	</div>
</div>
</form>
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
});
</script>

</div>