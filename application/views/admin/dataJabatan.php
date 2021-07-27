<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
   
</div>

<div class="card" style=" margin-bottom: 100px">
	<div class="card-body">

<a class="btn btn-sm btn-success mb-3" href="<?php echo base_url ('admin/dataJabatan/tambahData') ?>"><i class="fas fa-plus"></i> Tambah Data</a>
<?php echo $this->session->flashdata('pesan') ?>
<table class="table table-bordered table-striped mt-2">
	<tr>
		<th class="text-center">No</th>
		<th class="text-center">Nama Jabatan</th>
		<th class="text-center">Action</th>
	</tr>
	
	<?php $no=1; foreach($jabatan as $j) : ?>
		<tr>
			<td><?php echo ++$start ?></td>
			<td><?php echo $j['nama_jabatan'] ?></td>	
			<td>
				<center>
					<a class="btn btn-sm btn-primary" href="<?php echo base_url ('admin/dataJabatan/updateData/'.$j['id_jabatan']) ?>"><i class="fas fa-edit"></i></a>
					<a onclick="return confirm('Yakin Ingin Menghapus')" class="btn btn-sm btn-danger disabled" href="<?php echo base_url ('admin/dataJabatan/deleteData/'.$j['id_jabatan']) ?>"><i class="fas fa-trash"></i></a>
				</center>
			</td>
		</tr>
	<?php endforeach; ?>

</table>
<?= $this->pagination->create_links() ?>

</div>