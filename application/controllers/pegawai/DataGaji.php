<?php 	

class DataGaji extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('hak_akses') !='2'){
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
		$this->load->model('penggajianModel');
		$this->load->library('pagination');

		//config
		$config['base_url'] = 'http://localhost/ali/pegawai/dataGaji/index';
		$config['total_rows'] = $this->penggajianModel->countAllDataGajiPegawai();
		$config['per_page'] = 1;

		//get data title dan url
		$data['title'] = "Data Gaji";
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
		$nik=$this->session->userdata('nik');
		$data['gaji'] = $this->penggajianModel->getGajiPegawai($config['per_page'], $data['start'], $nik);
		
		// $data['potongan'] = $this->penggajianModel->get_data('status_kehadiran')->result();
		// $data['gaji'] = $this->db->query("SELECT data_pegawai.nik,data_pegawai.nama_pegawai,data_jabatan.nama_jabatan,data_kehadiran.id_kehadiran,data_kehadiran.tgl_input_absensi, data_kehadiran.lembur, pemetaan_sotk.upah_jam_lembur, pemetaan_sotk.gaji_harian
		// FROM data_pegawai
		// INNER JOIN data_kehadiran ON data_kehadiran.nik=data_pegawai.nik 
		// INNER JOIN pemetaan_sotk ON pemetaan_sotk.id_jabatan=data_pegawai.id_jabatan 
		// INNER JOIN data_jabatan ON data_jabatan.id_jabatan=data_pegawai.id_jabatan
		// INNER JOIN status_kehadiran ON status_kehadiran.id_status = data_kehadiran.id_status
		// 	WHERE data_kehadiran.nik='$nik'
		// 	ORDER BY data_kehadiran.id_kehadiran ASC")->result();
		
		$this->load->view('templates_pegawai/header',$data);
		$this->load->view('templates_pegawai/sidebar');
		$this->load->view('pegawai/dataGaji',$data);
		$this->load->view('templates_pegawai/footer');
	}

	public function cetakSlipGaji()
        {
            $data['title'] = "Cetak Slip Gaji Pegawai";
            $data['potongan'] = $this->penggajianModel->get_data('status_kehadiran')->result();
            if (isset($_GET['nik'], $_GET['tanggal'])) {
				$nik = $_GET['nik'];
				$tgl = $_GET['tanggal'];
			}
			
            $mindt = 0;
		    $maxdt = 0;
		    $maxer = 0;
		    $minxr = 0;
		        if (isset($_GET['date']) && ($_GET['end_date'])) {
			        $mindt = strtotime($_GET['date']) ?? 0;
			        $maxdt = $mindt + 25200;
			        $minxr = strtotime($_GET['end_date']) ?? 0;
			        $maxer = $minxr + 25200;
		}

            $data['print_slip'] = $this->db->query("SELECT data_pegawai.id_pegawai, data_pegawai.nik, data_pegawai.nama_pegawai, 
			data_kehadiran.tgl_input_absensi, data_jabatan.nama_jabatan, data_posisi.jenis_posisi, 
			pemetaan_sotk.upah_jam_lembur, data_kehadiran.lembur, pemetaan_sotk.gaji_harian, data_kehadiran.lembur, 
			pemetaan_sotk.upah_jam_lembur
            FROM data_pegawai 
            INNER JOIN data_kehadiran ON data_kehadiran.nik=data_pegawai.nik 
            INNER JOIN data_posisi ON data_posisi.id_posisi=data_pegawai.id_posisi
            INNER JOIN data_jabatan ON data_jabatan.id_jabatan=data_pegawai.id_jabatan
            INNER JOIN pemetaan_sotk ON pemetaan_sotk.id_jabatan=data_pegawai.id_jabatan
            INNER JOIN status_kehadiran ON data_kehadiran.id_status=status_kehadiran.id_status 
            WHERE data_kehadiran.tgl_input_absensi = $tgl AND data_pegawai.nik='$nik'")->result();
            $data['date'] = $mindt;
            $data['end_date'] = $minxr;
            $this->load->view('templates_admin/header',$data);
		    $this->load->view('pegawai/cetakSlip', $data);
        }
}

 ?>