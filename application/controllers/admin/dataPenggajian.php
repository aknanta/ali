<?php 

class DataPenggajian extends CI_Controller{

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
        $this->load->model('GenerateModel');
    }


	public function index()
	{
		$startdate = $this->input->get('startdate') ?? 0;
		$enddate = $this->input->get('enddate') ?? 0;
		$this->load->model('penggajianModel');
		$this->load->library('pagination');

		//config
		$config['base_url'] = 'http://localhost/ali/admin/dataPenggajian/index';
		$config['total_rows'] = $this->penggajianModel->countAllDataGaji();
		$config['per_page'] = 10;

		//get data title dan url
		$data['title'] = "Data Gaji Pegawai";
		$data['start'] = $this->uri->segment(4);

		//styling
		$config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</ul></nav>';

		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = array('class' => 'page-link');

		//initialize
		$this->pagination->initialize($config);
		$data['gaji'] = $this->penggajianModel->getDataPenggajian($config['per_page'], $data['start'], array($startdate, $enddate));
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/dataGaji',$data);
		$this->load->view('templates_admin/footer');
	}

	public function cetakGaji() {
		$data['title'] = "Cetak Data Gaji Pegawai";
		$mindt = /*strtotime('now')*/ 0 ;
		$maxdt = 0;
		$maxer = 0;
		$minxr = 0;
		if (isset($_GET['date']) && ($_GET['end_date'])) {
			$mindt = strtotime($_GET['date']) ?? 0;
			$maxdt = $mindt + 25200;
			$minxr = strtotime($_GET['end_date']) ?? 0;
			$maxer = $minxr + 25200;
		}
		// if ((isset($_GET['bulan']) && $_GET['bulan']!='') && (isset($_GET['tahun']) && $_GET['tahun']!='')){
		// 	$bulan = $_GET['bulan'];
		// 	$tahun = $_GET['tahun'];
		// 	$bulantahun = $bulan.$tahun;
		// }else{
		// 	$bulan = date('m');
		// 	$tahun = date('Y');
		// 	$bulantahun = $bulan.$tahun;
		// }
			$data['cetakGaji'] = $this->db->query("SELECT data_pegawai.nik,data_pegawai.nama_pegawai,data_jabatan.nama_jabatan, pemetaan_sotk.gaji_harian, pemetaan_sotk.upah_jam_lembur, data_kehadiran.lembur, data_kehadiran.payout, data_kehadiran.tgl_input_absensi
			FROM data_pegawai
			INNER JOIN data_kehadiran ON data_kehadiran.nik=data_pegawai.nik 
			INNER JOIN pemetaan_sotk ON pemetaan_sotk.id_jabatan=data_pegawai.id_jabatan 
			INNER JOIN data_jabatan ON data_jabatan.id_jabatan=data_pegawai.id_jabatan
			
			WHERE tgl_input_absensi >= $mindt AND tgl_input_absensi <= $maxer  ORDER BY data_kehadiran.tgl_input_absensi ASC")->result();
			$data['date'] = $mindt;
			$data['end_date'] = $minxr;
			$this->load->view('templates_admin/header',$data);
			$this->load->view('admin/cetakDataGaji',$data);
	}

	public function generate()
	{
		$startdate = $this->input->get('startdate') ?? 0;
		$enddate = $this->input->get('enddate') ?? 0;
		
		$this->penggajianModel->update_data('data_kehadiran', [
			'payout' => 'Sudah'
			], "tgl_input_absensi >= '$startdate' AND tgl_input_absensi <= '$enddate'");
		$this->GenerateModel->insert_data([
			"nama_generate" => "Hasil Generate " . $_GET['startdate'] . " s/d " . $_GET['enddate'],
			"tgl_awal" => $startdate,
			"tgl_akhir" => $enddate,
			"isTerbayarkan" => FALSE,
			"id_pegawai" => $this->session->userdata('id_pegawai')
		]);

		redirect(base_url('admin/dataPenggajian?startdate='.$_GET['startdate'].'&enddate='.$_GET['enddate']));	
	}
}
 ?>