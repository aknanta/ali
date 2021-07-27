<?php 	

class Dashboard extends CI_Controller{

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
		$data['title'] = "Dashboard";
		$id=$this->session->userdata('id_pegawai');
		$data['pegawai'] = $this->db->query("SELECT data_pegawai.nama_pegawai,data_jabatan.nama_jabatan,data_pegawai.tanggal_masuk,data_pegawai.status 
		FROM data_pegawai
		INNER JOIN data_jabatan ON data_pegawai.id_jabatan=data_jabatan.id_jabatan
		WHERE id_pegawai='$id'")->result();
		$this->load->view('templates_manager/header',$data);
		$this->load->view('templates_manager/sidebar');
		$this->load->view('manager/dashboard',$data);
		$this->load->view('templates_manager/footer');
	}

    

}

 ?>