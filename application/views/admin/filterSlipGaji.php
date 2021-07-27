<div class="container-fluid">

<div class="card mx-auto" style="width: 35%" >
	<div class="card-header bg-primary text-white text-center">
		Filter Slip Gaji
	</div>

	<form method="GET" action="<?php echo base_url('admin/slipGaji/cetakSlipGaji'); ?>">
	<div class="card-body">
		<div class="form-group row">
		Tanggal<input class="form-control datepicker" data-provide="datepicker" type="text" name="startdate" id="date" autocomplete="off">
		</div>
		<div class="form-group row">
		Sampai<input class="form-control datepicker" data-provide="datepicker" type="text" name="enddate" id="end_date" autocomplete="off">
		</div>

        <div class="form-group row">
			<label for="inputPassword" class="col-sm-7 ">Nama Pegawai</label>
			<div class="col-sm-17" >
				<select class="form-control" name="nama_pegawai">
   				<option value="">---- Pilih Pegawai ----</option>
                <?php foreach($pegawai as $p) : ?>
                    <option value="<?= $p->nama_pegawai ?>"><?= $p->nama_pegawai ?></option>
                <?php endforeach; ?>
   			</select>
			</div>
		</div>

		<button style="width: 100%" type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Cetak Slip Gaji</button>
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