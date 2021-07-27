<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
   
</div>


<div class="card" style="width: 70%; margin-bottom: 100px">
	<div class="card-body">

		<form method="POST" action="<?php echo base_url('admin/dataJabatan/tambahDataAksi') ?>">

			<div class="form-group">
				<label>Nama Jabatan</label>
				<input type="text" name="nama_jabatan" class="form-control">
				<?php echo form_error('nama_jabatan','<div class="text-small text-danger"></div>') ?>
			</div>

			<button type="submit" class="btn btn-success mb-5">Submit</button>
			
		</form>
	</div>
</div>
</div>