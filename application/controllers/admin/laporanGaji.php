<?php 

class LaporanGaji extends CI_Controller{

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
		$data['title'] = "Laporan Gaji Pegawai";
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/filterLaporanGaji');
		$this->load->view('templates_admin/footer');
	}

	public function cetakLaporanGaji()
	{
		$data['title'] = "Cetak Laporan Gaji Pegawai";

		$startdate = $this->input->get('startdate') ?? 0;
		$enddate = $this->input->get('enddate') ?? 0;
        
		$data['potongan'] = $this->penggajianModel->get_data('status_kehadiran')->result();
		$data['cetakGaji'] = $this->db->query("SELECT data_pegawai.nik,data_pegawai.nama_pegawai,data_jabatan.nama_jabatan, pemetaan_sotk.gaji_harian, data_kehadiran.tgl_input_absensi, data_kehadiran.payout, data_kehadiran.lembur, pemetaan_sotk.upah_jam_lembur
		FROM data_pegawai
		INNER JOIN data_kehadiran ON data_kehadiran.nik=data_pegawai.nik 
		INNER JOIN pemetaan_sotk ON pemetaan_sotk.id_jabatan=data_pegawai.id_jabatan 
		INNER JOIN data_jabatan ON data_jabatan.id_jabatan=data_pegawai.id_jabatan
		WHERE tgl_input_absensi >= '$startdate' AND tgl_input_absensi <= '$enddate' ORDER BY data_kehadiran.tgl_input_absensi ASC")->result();
		$data['startdate'] = $startdate;
		$data['enddate'] = $enddate;
		$this->load->view('templates_admin/header',$data);
		$this->load->view('admin/cetakLaporanGaji',$data);
	}
}

 ?>