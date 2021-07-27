<?php 	

class DataAbsensi extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('hak_akses') !='3'){
			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Login terlebih dahulu</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('welcome/login');
		}
	}

	public function index()
	{
		$data['title'] = "Data Absensi Pegawai";

		$mindt = 0 ;
		$maxdt = 0;
		$maxer = 0;
		$minxr = 0;
		$idPosisi = "";
		$query = "";

		if (isset($_GET['posisi'])) {
			$idPosisi = $_GET['posisi'];
 
		}
		if (isset($_GET['date']) && ($_GET['end_date'])) {
			$mindt = strtotime($_GET['date']) ?? 0;
			$maxdt = $mindt + 25200;
			$minxr = strtotime($_GET['end_date']) ?? 0;
			$maxer = $minxr + 25200;
		}

		if ($idPosisi != "") {
			$query ="SELECT data_kehadiran.*, data_pegawai.nama_pegawai, data_pegawai.id_jabatan, data_posisi.jenis_posisi, status_kehadiran.status_kehadiran
					FROM data_kehadiran
					INNER JOIN data_pegawai ON data_kehadiran.nik=data_pegawai.nik
					INNER JOIN data_posisi ON data_kehadiran.id_posisi = data_posisi.id_posisi
					INNER JOIN status_kehadiran ON data_kehadiran.id_status = status_kehadiran.id_status
					WHERE tgl_input_absensi >= $mindt AND tgl_input_absensi <= $maxer AND data_kehadiran.id_posisi = '$idPosisi'
					ORDER BY data_kehadiran.tgl_input_absensi ASC";
		}else{
			$query ="SELECT data_kehadiran.*, data_pegawai.nama_pegawai, data_pegawai.id_jabatan, data_posisi.jenis_posisi, status_kehadiran.status_kehadiran
			FROM data_kehadiran
			INNER JOIN data_pegawai ON data_kehadiran.nik=data_pegawai.nik
			INNER JOIN data_posisi ON data_kehadiran.id_posisi = data_posisi.id_posisi
			INNER JOIN status_kehadiran ON data_kehadiran.id_status = status_kehadiran.id_status
			WHERE tgl_input_absensi >= $mindt AND tgl_input_absensi <= $maxer
			ORDER BY data_kehadiran.tgl_input_absensi ASC";
		}	
 
		$data['posisi'] = $this->db->query("SELECT * FROM data_posisi")->result();
 
		$data['absensi'] = $this->db->query($query)->result();
		$data['date'] = $mindt;
		$data['end_date'] = $minxr;
 
		$this->load->view('templates_manager/header',$data);
		$this->load->view('templates_manager/sidebar');
		$this->load->view('manager/DataAbsensi',$data);
		$this->load->view('templates_manager/footer');
	}
}

 ?>