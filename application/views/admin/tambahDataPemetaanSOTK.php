<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
   
</div>

<div class="card" style="width: 70%; margin-bottom: 100px">
	<div class="card-body">

		<form method="POST" action="<?php echo base_url('admin/PemetaanSOTK/tambahDataAksi') ?>" enctype="multipart/form-data">
		<div class="form-group">
				<label>Jabatan</label>
				<select name="id_jabatan" class="form-control">
				<option value="">== Pilih Jenis Jabatan ==</option>
				<?php foreach($jabatan as $j) : ?>
				<option value="<?php echo $j->id_jabatan ?>"><?php echo $j->nama_jabatan ?></option>
			<?php endforeach; ?>
			</select>
			<?php echo form_error('jabatan','<div class="text-small text-danger"></div>') ?>
			</div>
			
			<div class="form-group">
				<label>Posisi Kerja</label>
				<select name="id_posisi" class="form-control">
				<option value="">== Pilih Posisi Kerja ==</option>
			<?php foreach($posisi_kerja as $pk) : ?>
				<option value="<?php echo $pk->id_posisi ?>"><?php echo $pk->jenis_posisi ?></option>
			<?php endforeach; ?>
			</select>
			<?php echo form_error('posisi_kerja','<div class="text-small text-danger"></div>') ?>
			</div>

			<div class="form-group">
				<label>Upah Jam Lembur</label>
				<input type="number" name="upah_jam_lembur" class="form-control">
				<?php echo form_error('upah_jam_lembur','<div class="text-small text-danger"></div>') ?>
			</div>

		<div class="form-group">
				<label>Gaji Harian</label>
				<input type="number" name="gaji_harian" class="form-control">
				<?php echo form_error('gaji_harian','<div class="text-small text-danger"></div>') ?>
			</div>
			<button type="submit" class="btn btn-primary">Simpan</button>

		</form>
		
	</div>
</div>

</div>