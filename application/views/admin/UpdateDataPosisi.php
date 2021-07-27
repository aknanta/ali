<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
   
</div>


<div class="card" style="width: 70%; margin-bottom: 100px">
	<div class="card-body">

		<?php foreach ($posisi_kerja as $pk): ?>
		<form method="POST" action="<?php echo base_url('admin/dataPosisi/updateDataAksi') ?>">

			<div class="form-group">
				<label>Nama Posisi</label>
				<input type="hidden" name="id_posisi" class="form-control" value="<?php echo $pk->id_posisi ?>">
				<input type="text" name="jenis_posisi" class="form-control" value="<?php echo $pk->jenis_posisi ?>">
				<?php echo form_error('jenis_posisi','<div class="text-small text-danger"></div>') ?>
			</div>

			<button type="submit" class="btn btn-success mb-5">Update</button>
			
		</form>
	<?php endforeach; ?>
	</div>
</div>
</div>