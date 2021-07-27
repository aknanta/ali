<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
   
</div>


<div class="card" style="width: 70%; margin-bottom: 100px">
	<div class="card-body">

		<?php foreach ($posisi_kerja as $pk): ?>
		<form method="POST" action="<?php echo base_url('admin/dataPosisi/updateDataAksi') ?>">

			<div class="form-group">
				<label>Nama Jabatan</label>
				<select name="jabatan" class="form-control">
				<option value="<?php echo $pk->jabatan ?>"><?php echo $pk->jabatan ?></option>
				<?php foreach($posisi_kerja as $pk) : ?>
				<option value="<?php echo $j->nama_jabatan ?>"><?php echo $j->nama_jabatan ?></option>
			<?php endforeach; ?>
			</select>
			<?php echo form_error('jabatan','<div class="text-small text-danger"></div>') ?>
			</div>

            <div class="form-group">
				<label>Jenis Posisi</label>
				<input type="hidden" name="id_posisi" class="form-control" value="<?php echo $pk->id_posisi ?>">
				<input type="text" name="jenis_posisi" class="form-control" value="<?php echo $pk->jenis_posisi ?>">
				<?php echo form_error('jenis_posisi','<div class="text-small text-danger"></div>') ?>
			</div>

            <div class="form-group">
				<label>Gaji Harian</label>
				<input type="number" name="gaji_harian" class="form-control" value="<?php echo $pk->gaji_harian ?>">
				<?php echo form_error('gaji_pokok','<div class="text-small text-danger"></div>') ?>
			</div>

			<div class="form-group">
				<label>Gaji Pokok</label>
				<input type="number" name="gaji_pokok" class="form-control" value="<?php echo $pk->gaji_pokok ?>">
				<?php echo form_error('gaji_pokok','<div class="text-small text-danger"></div>') ?>
			</div>

			<div class="form-group">
				<label>Tunjangan Transportasi</label>
				<input type="number" name="tj_transport" class="form-control" value="<?php echo $pk->tj_transport ?>">
				<?php echo form_error('tj_transport','<div class="text-small text-danger"></div>') ?>
			</div>

			<div class="form-group">
				<label>Uang Makan</label>
				<input type="number" name="uang_makan" class="form-control" value="<?php echo $pk->uang_makan ?>">
				<?php echo form_error('uang_makan','<div class="text-small text-danger"></div>') ?>
			</div>

            <div class="form-group">
				<label>Gaji PerJam Lembur</label>
				<input type="number" name="gaji_jam_lembur" class="form-control" value="<?php echo $pk->gaji_jam_lembur ?>">
				<?php echo form_error('gaji_jam_lembur','<div class="text-small text-danger"></div>') ?>
			</div>

			<button type="submit" class="btn btn-success mb-5">Update</button>
			
		</form>
	<?php endforeach; ?>
	</div>
</div>
</div>