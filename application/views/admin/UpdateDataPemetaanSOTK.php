<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
   
</div>


<div class="card" style="width: 70%; margin-bottom: 100px">
	<div class="card-body">

		<?php foreach ($pemetaansotk as $sotk): ?>
		<form method="POST" action="<?php echo base_url('admin/pemetaanSOTK/updateDataAksi') ?>"  enctype="multipart/form-data">


			<div class="form-group">
				<label>Upah Jam Lembur</label>
				<input type="hidden" name="id_pemetaan" value="<?php echo $sotk->id_pemetaan ?>">
				<input type="number" name="upah_jam_lembur" class="form-control" value="<?php echo $sotk->upah_jam_lembur ?>">
				<?php echo form_error('upah_jam_lembur','<div class="text-small text-danger"></div>') ?>
			</div>

            <div class="form-group">
				<label>Gaji Harian</label>
				<input type="number" name="gaji_harian" class="form-control" value="<?php echo $sotk->gaji_harian ?>">
				<?php echo form_error('gaji_harian','<div class="text-small text-danger"></div>') ?>
			</div>

			<button type="submit" class="btn btn-success mb-5">Update</button>
			
		</form>
	<?php endforeach; ?>
	</div>
</div>
</div>