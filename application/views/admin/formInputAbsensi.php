<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
</div>

<div class="card mb-3">
  <div class="card-header bg-primary text-white">
    Input Absensi Pegawai PT. Anugrah Laut Indonesia
  </div>
  <div class="card-body">
<form method="POST" class="form-inline">
    <div class="form-group mb-2">
      <input class="form-control datepicker" data-provide="datepicker" type="text" name="date" style="display: none">
    </div>
<button class="btn btn-success mb-3" type="submit" name="submit" value="submit">Simpan</button>
  <!-- <form class="form-inline" id="showData">
    <div class="form-group mb-2">
      <input class="form-control datepicker" data-provide="datepicker" type="text" name="date">
    </div>

    <button type="submit" class="btn btn-primary mb-2 ml-auto"><i class="fas fa-eye"></i>Generate</button>
  </form> -->

  </div>
</div>

<?php 
  $mindt = /*strtotime('now')*/ 0 ;
  $maxdt = 0;
  if (isset($_GET['date'])) {
    $mindt = strtotime($_GET['date']);
    $maxdt = $mindt + 25200;
  }

 ?>


<table class="table table-bordered table-striped table-responsive">
  <tr>
    <td class="text-center">No</td>
    <td class="text-center">NIK</td>
    <td class="text-center">Nama Pegawai</td>
    <td class="text-center">Jabatan</td>
    <td class="text-center">Tgl Absensi</td>
    <td class="text-center">Posisi Kerja Hari Ini</td>
    <td class="text-center">Shift</td>
    <td class="text-center">Total Jam Kerja</td>
    <td class="text-center">Lembur</td>
    <td class="text-center">Status Kehadiran</td>

    
  </tr>

  <?php $no=1; foreach($input_absensi as $a) : ?>
    <tr>
    <div class="col-xs-2">
      <input type="hidden" name="tgl_input_absensi[]" class="form-control" value="<?php echo $mindt ?>" >
      </div>
      <input type="hidden" name="nik[]" class="form-control" value="<?php echo $a->nik ?>">
      <input type="hidden" name="nama_pegawai[]" class="form-control" value="<?php echo $a->nama_pegawai ?>">
      <input type="hidden" name="nama_jabatan[]" class="form-control" value="<?php echo $a->nama_jabatan ?>">
      <td><?php echo $no++ ?></td>
      <td><?php echo $a->nik ?></td>
      <td><?php echo $a->nama_pegawai ?></td>
      <td><?php echo $a->nama_jabatan ?></td>
      
      <td><input class="form-control datepicker" data-provide="datepicker" type="text" name="date" disabled></td>

      
      <td>
        <select name="id_posisi[]" class="form-control">
          <?php foreach($posisi_kerja as $pk) : ?>
          <option value="<?= $pk->id_posisi ?>"><?= $pk->jenis_posisi ?></option>
          <?php endforeach; ?>
        </select>
      </td>
      <td>
        <select name="shift[]" class="form-control">
          <option value="pagi">pagi</option>
          <option value="sore">sore</option>
        </select>
      </td>
      <td><input type="number" name="total_jam_kerja[]" class="form-control"></td>
      <td><input type="number" name="lembur[]" class="form-control"></td>
      <td><select name="id_status[]" class="form-control">
          <?php foreach($potongan as $p) : ?>
          <option value="<?= $p->id_status ?>"><?= $p->status_kehadiran ?></option>
          <?php endforeach; ?>
        </select></td>
    </tr>
  <?php endforeach; ?>
</table><br><br><br><br>
</form>

</div>
<script>
// var dp;
// $(document).ready(function() {
//     dp = $('.datepicker').datepicker({
//         format: 'yyyy-mm-dd',
//         autoclose: true,
//         todayHighlight: true,
//     });
// 	// $('#showData').submit(function (ev) {
// 	// 	ev.preventDefault();
// 	// 	window.location.href = "/ali/admin/dataAbsensi";
// 	// });
// });
function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}

window.addEventListener('load', function() {
	console.log('load fired');
	$(document).ready(function() {
		var dp = $('.datepicker').datepicker({
			//format: 'yyyy-mm-dd',
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,
		});
    dp.val(findGetParameter('date'))
		// $('#showData').submit(function (ev) {
		// 	ev.preventDefault();
		// 	window.location.href = "/ali/admin/dataAbsensi";
		// });
	});
});
</script>

<style>
  
.table > tbody > tr > td {
	width: 120px;
}
.table > tbody > tr > td input {
	width: 120px !important;
}

</style>