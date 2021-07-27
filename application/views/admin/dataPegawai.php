<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
   
</div>

<div class="card" style="margin-bottom: 100px">
	<div class="card-body">

<?php echo $this->session->flashdata('pesan') ?>

<a class="mb-2 mt-2 btn btn-sm btn-success" href="<?php echo base_url('admin/dataPegawai/tambahData') ?>"><i class="fas fa-plus"></i>Tambah Pegawai</a>

<table class="table table-striped table-bordered">
	<tr>
		<th class="text-center">No</th>
		<th class="text-center">NIK</th>
		<th class="text-center">Nama Pegawai</th>
		<th class="text-center">Alamat Pegawai</th>
		<th class="text-center">Posisi Kerja</th>
		<th class="text-center">Jabatan</th>
		<th class="text-center">Tanggal Masuk</th>
		<!-- <th class="text-center">Status</th> -->
		<th class="text-center">Hak Akses</th>
		<th class="text-center">Action</th>
	</tr>

	<?php  foreach($pegawai as $p) : ?>
	<tr>
		<td><?php echo ++$start ?></td>
		<td><?php echo $p['nik'] ?></td>
		<td><?php echo $p['nama_pegawai'] ?></td>
		<td><?php echo $p['alamat_peg'] ?></td>
		<td><?php echo $p['jenis_posisi'] ?></td>
		<td><?= $p['nama_jabatan'] ?></td>
		<td><?php echo $p['tanggal_masuk'] ?></td>
			
			<?php if($p['hak_akses']=='1'): ?>
				<td>Admin</td>
			<?php elseif($p['hak_akses']=='2'): ?>
				<td>Pegawai</td>
			<?php else: ?>
				<td>Manager</td>
			<?php endif; ?>
		<td>
				<center>
					<a class="btn btn-sm btn-primary" href="<?php echo base_url ('admin/dataPegawai/updateData/'.$p['id_pegawai']) ?>"><i class="fas fa-edit"></i></a>
					<a onclick="return confirm('Yakin Ingin Menghapus')" class="btn btn-sm btn-danger disabled" href="<?php echo base_url ('admin/dataPegawai/deleteData/'.$p['id_pegawai']) ?>"><i class="fas fa-trash"></i></a>
				</center>
			</td>
	</tr>
	<?php endforeach; ?>
</table>

<?php echo $this->pagination->create_links()?>

</div>