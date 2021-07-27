<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
   
</div>

<div class="card mb-3">
  <div class="card-header bg-primary text-white">
    Filter Data Generate Gaji Pegawai PT. Anugrah Laut Indonesia
  </div>
  <div class="card-body">

 	<form class="form-inline">
	 <div class="form-group mb-2">
   			Dari Tanggal: <input class="form-control datepicker" data-provide="datepicker" type="text" name="startdate" id="date" style="margin-right: 10px; margin-left: 10px;" autocomplete="off">
			   Sampai Tanggal: <input class="form-control datepicker" data-provide="datepicker" type="text" name="enddate" id="end_date" style="margin-right: 10px; margin-left: 10px;" autocomplete="off">
   		</div>
	
    	<button type="submit" class="btn btn-primary mb-2 ml-auto"><i class="fas fa-eye"></i>Tampilkan Data</button>

		<!-- <button class="btn btn-success mb-2 ml-3" id="print">Cetak Daftar Gaji</button> -->
    </form>

  </div>
</div>

<!-- <div class="alert alert-info">
	Menampilkan Data Gaji Pegawai Tanggal : <?= date('d-M-Y', $date) ?>
</div> -->

<?php 
$jml_data = count($generate);
if($jml_data > 0) { ?>
<div id="div-konten">
<div class="table-responsive">
	<table class="table table-bordered table-striped">
		<tr>
			<th class="text-center">No</th>
			<th class="text-center">Nama</th>
			<th class="text-center">Tanggal Awal</th>
			<th class="text-center">Tanggal Akhir</th>
			<th class="text-center">Terbayarkan</th>
			<th class="text-center">Nama Admin</th>
			<th class="text-center">Dibayar Oleh</th>
			<th class="text-center">Action</th>
		</tr>

		<?php
		/* $status_kehadiran=0; foreach ($potongan as $p) {
			$status_kehadiran=intval($p->jml_potongan);
		}
		$attend = 0;
		$potongan = 0;
		//var_dump($potongan); die();
		foreach ($gaji as $g) {
			if ($g -> status_kehadiran == "Tidak Hadir")
				$attend++;
				$potongan = $attend * $status_kehadiran;
		}
		*/
		
		
		?>
		<?php $no=1; foreach($generate as $g) : ?>
		<tr>
			<td><?php echo $no++ ?></td>
			<td><?php echo $g->nama_generate ?></td>
			<td><?= $g->tgl_awal ?></td>
			<td><?= $g->tgl_akhir ?></td>
			<td><?= $g->isTerbayarkan ? "Sudah" : "Belum" ?></td>
			<td><?= $g->username ?></td>
			<td><?= $g->empPembayar != null ? $g->empPembayar:"-" ?></td>
			<td>
				<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="showModalGenerate(<?= $g->id_generate?>)"><i class="fas fa-edit"></i></button>
				<a class='btn btn-primary btn-xs detail-link' href="<?php echo base_url('admin/DataGenerate/gaji/'.$g->tgl_awal.'/'.$g->tgl_akhir.'');?>"> <i class='ace-icon fas fa-search-plus'></i></a>
			</td>
		</tr>

	<?php endforeach; ?>
	</table>
</div>
</div>
<div id="div-detail">
</div>
<?php }else{ ?>
    <span class="badge badge-danger"><i class="fas fa-info-circle"></i> Data Generate Masih Kosong, Silahkan Input Data Gaji Pada Tanggal Yang Anda Pilih! </span>
  <?php } ?>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Informasi</h5>
      </div>
      <form action="<?=base_url('admin/DataGenerate/updateNamaPembayar')?>" method="post">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <span>Nama Pembayar</span>
                    <input type="hidden" name="idGenerate" id="idGenerate">
                    <input type="text" class="form-control" name="namaPembayar" id="namaPembayar" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
      
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

function showModalGenerate(id){
    $("#idGenerate").val(id);
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

$('.detail-link').click(function(e) {
	e.preventDefault();
	$.ajax({
		type: "GET",
		url: $(this).attr('href'),
		beforeSend: function() {
			OpenDetail();
			$('#div-detail').html("<div class='text-center'><img src='<?php echo base_url('assets/img/loader.gif') ?>'></div>");
		},
		success: function(data) {
			$('#div-detail').html(data);
		}
	});
});

function OpenDetail(){
	$('#div-konten').hide();
	$('#div-button').hide();
	$('#div-detail').show();
}
function CloseDetail(){
	$('#div-konten').show();
	$('#div-button').show();
	$('#div-detail').hide();
}
</script>