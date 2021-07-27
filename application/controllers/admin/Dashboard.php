<?php 

class Dashboard extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('hak_akses') !='1'){
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
		$pegawai = $this->db->query("SELECT * FROM data_pegawai");
		$jabatan = $this->db->query("SELECT * FROM data_jabatan");
		$posisi_kerja = $this->db->query("SELECT * FROM data_posisi");
		$kehadiran = $this->db->query("SELECT * FROM data_kehadiran");
		$data['pegawai']=$pegawai->num_rows();
		$data['jabatan']=$jabatan->num_rows();
		$data['posisi_kerja']=$posisi_kerja->num_rows();
		$data['kehadiran']=$kehadiran->num_rows();
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/dashboard',$data);
		$this->load->view('templates_admin/footer');
	}
}

 ?>