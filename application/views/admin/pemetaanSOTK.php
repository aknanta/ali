<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
   
</div>

<div class="card" style=" margin-bottom: 100px">
	<div class="card-body">

<a class="btn btn-sm btn-success mb-3" href="<?php echo base_url ('admin/pemetaanSOTK/tambahData') ?>"><i class="fas fa-plus"></i> Tambah Data</a>
<?php echo $this->session->flashdata('pesan') ?>
<table class="table table-bordered table-striped mt-2">
	<tr>
		<th class="text-center">No</th>
		<th class="text-center">Nama Jabatan</th>
        <th class="text-center">Jenis Posisi</th>
        <th class="text-center">Upah Jam Lembur</th>
		<th class="text-center">Gaji Harian</th>
		<th class="text-center">Action</th>
	</tr>
	
	<?php foreach($pemetaansotk as $sotk) : ?>
		<tr>
			<td><?php echo ++$start ?></td>
            <td><?php echo $sotk['nama_jabatan']?></td>
			<td><?php echo $sotk['jenis_posisi']?></td>
            <td>Rp. <?php echo number_format($sotk['upah_jam_lembur'],0,',','.') ?></td>
			<td>Rp. <?php echo number_format($sotk['gaji_harian'],0,',','.') ?></td>
		
			<td>
				<center>
					<a class="btn btn-sm btn-primary" href="<?php echo base_url ('admin/pemetaanSOTK/updateData/'.$sotk['id_pemetaan']) ?>"><i class="fas fa-edit"></i></a>
					<a onclick="return confirm('Yakin Ingin Menghapus')" class="btn btn-sm btn-danger disabled" href="<?php echo base_url ('admin/pemetaanSOTK/deleteData/'.$sotk['id_pemetaan']) ?>"><i class="fas fa-trash"></i></a>
				</center>
			</td>
		</tr>
	<?php endforeach; ?>

</table>

<?php echo $this->pagination->create_links()?>

</div>