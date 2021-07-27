<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
   
</div>

<div class="card" style=" margin-bottom: 100px">
	<div class="card-body">

<a class="btn btn-sm btn-success mb-3" href="<?php echo base_url ('admin/dataPosisi/tambahData') ?>"><i class="fas fa-plus"></i> Tambah Data</a>
<?php echo $this->session->flashdata('pesan') ?>
<table class="table table-bordered table-striped mt-2">
	<tr>
		<th class="text-center">No</th>
        <th class="text-center">Jenis Posisi</th>
		<th class="text-center">Action</th>
	</tr>
	
	<?php foreach($posisi_kerja as $pk) : ?>
		<tr>
			<td><?php echo ++$start ?></td>
            <td><?php echo $pk['jenis_posisi'] ?></td>
			<td>
				<center>
					<a class="btn btn-sm btn-primary" href="<?php echo base_url ('admin/dataPosisi/updateData/'.$pk['id_posisi']) ?>"><i class="fas fa-edit"></i></a>
					<a onclick="return confirm('Yakin Ingin Menghapus')" class="btn btn-sm btn-danger disabled" href="<?php echo base_url ('admin/dataPosisi/deleteData/'.$pk['id_posisi']) ?>"><i class="fas fa-trash"></i></a>
				</center>
			</td>
		</tr>
	<?php endforeach; ?>

</table>
<?php echo $this->pagination->create_links()?>
</div>