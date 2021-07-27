<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
   
</div>

<div class="card" style="width: 70%; margin-bottom: 100px">
	<div class="card-body">

		<?php foreach ($pegawai as $p) : ?>

		<form method="POST" action="<?php echo base_url('admin/DataPegawai/updateDataAksi') ?>" enctype="multipart/form-data">
			
			<div class="form-group">
				<label>NIK</label>
				<input type="hidden" name="id_pegawai" class="form-control" value="<?php echo $p->id_pegawai ?>">
				<input type="number" name="nik" class="form-control" value="<?php echo $p->nik ?>">
				<?php echo form_error('nik','<div class="text-small text-danger"></div>') ?>
			</div>

			<div class="form-group">
				<label>Username</label>
				<input type="text" name="username" class="form-control" value="<?php echo $p->username ?>">
				<?php echo form_error('username','<div class="text-small text-danger"></div>') ?>
			</div>
			<div class="form-group">
				<label>Nama Pegawai</label>
				<input type="text" name="nama_pegawai" class="form-control" value="<?php echo $p->nama_pegawai ?>">
				<?php echo form_error('nama_pegawai','<div class="text-small text-danger"></div>') ?>
			</div>

			<div class="form-group">
				<label>Alamat Pegawai</label>
				<input type="text" name="alamat_peg" class="form-control" value="<?php echo $p->alamat_peg ?>">
				<?php echo form_error('alamat_peg','<div class="text-small text-danger"></div>') ?>
			</div>

			<div class="form-group">
				<label>Posisi Kerja</label>
				<select name="id_posisi" class="form-control">
				<?php foreach ($posisi_kerja as $pk) : ?>
								<?php if ($pk->id_posisi == $p->id_posisi) : ?>
									<option value="<?php echo $pk->id_posisi ?>" selected><?php echo $pk->jenis_posisi ?></option>
								<?php else : ?>
									<option value="<?php echo $pk->id_posisi ?>"><?php echo $pk->jenis_posisi ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
			</select>
			<?php echo form_error('posisi_kerja','<div class="text-small text-danger"></div>') ?>
			</div>

			<div class="form-group">
				<label>Jabatan</label>
				<select name="id_jabatan" class="form-control">
				<?php foreach ($jabatan as $j) : ?>
								<?php if ($j->id_jabatan == $p->id_jabatan) : ?>
									<option value="<?php echo $j->id_jabatan ?>" selected><?php echo $j->nama_jabatan ?></option>
								<?php else : ?>
									<option value="<?php echo $j->id_jabatan ?>"><?php echo $j->nama_jabatan ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
			</select>
			<?php echo form_error('jabatan','<div class="text-small text-danger"></div>') ?>
			</div>

			<div class="form-group">
				<label>Tanggal Masuk</label>
				<input type="date" name="tanggal_masuk" class="form-control" value="<?php echo $p->tanggal_masuk ?>">
				<?php echo form_error('tanggal_masuk','<div class="text-small text-danger"></div>') ?>
			</div>

			<div class="form-group">
				<label>Hak Akses</label>
				<select name="hak_akses" class="form-control">
					<option value="<?= $p->hak_akses ?>">
						<?php if ($p->hak_akses=='1'):?>
							<td>Admin</td>
						<?php elseif($p->hak_akses=='2'): ?>
							<td>Pegawai</td>
						<?php else: ?>
							<td>Manager</td>
						<?php endif; ?>
						
					</option>
					<option value="1">Admin</option>
					<option value="2">Pegawai</option>
					<option value="3">Manager</option>
				</select>
			</div>
			<button type="submit" class="btn btn-primary">Simpan</button>

		</form>

	<?php endforeach; ?>
		
	</div>
</div>

</div>