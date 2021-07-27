<?php 

class DataAbsensi extends CI_Controller{

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
		$data['title'] = "Data Absensi Pegawai";
		$startdate = $this->input->get('startdate') ?? 0;
		$enddate = $this->input->get('enddate') ?? 0;
		//$idPosisi = $this->input->get('q',TRUE);
		$this->load->model('penggajianModel');
		$this->load->library('pagination');

		$config['base_url'] = 'http://localhost/ali/admin/dataAbsensi/index';
		$config['total_rows'] = $this->penggajianModel->countGaji();
		$config['per_page'] = 10;

		$data['title'] = "Data Pegawai";
		$data['start'] = $this->uri->segment(4);

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
		$this->pagination->initialize($config);
		$data['absensi'] = $this->penggajianModel->get_limit_data($config['per_page'], $data['start'], array($startdate,$enddate));	
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/dataAbsensi',$data);
		$this->load->view('templates_admin/footer');
	}

	public function inputAbsensi()
	{
		if($this->input->post('submit', TRUE) == 'submit') {
			
			$post = $this->input->post();

			 foreach ($post['tgl_input_absensi'] as $key => $value) {
				if($post['tgl_input_absensi'][$key] !='' || $post['nik'][$key] !='')
				{
					$simpan[] = array(

						'tgl_input_absensi' 		 => intval($post['tgl_input_absensi'][$key]),
						'nik'  			 			 => $post['nik'][$key],
						'id_posisi'		 			 => $post['id_posisi'][$key],
						'shift'     	             => $post['shift'][$key],
						'total_jam_kerja'            => $post['total_jam_kerja'][$key],
						'lembur'     	             => $post['lembur'][$key],
						'id_status'				 	 => $post['id_status'][$key],
					);	
				}
			}
			
			$this->penggajianModel->insert_batch('data_kehadiran',$simpan);
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data Berhasil Di Tambahkan</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button>
			</div>');
		
		}
		$mindt = 0 ;
		$maxdt = 0;
		if (isset($_GET['date'])) {
			$mindt = strtotime($_GET['date']);
			$maxdt = $mindt + 25200;
		}
		$data['title'] = "Form Input Absensi";
		$data['posisi_kerja'] = $this->penggajianModel->get_data('data_posisi')->result();
		$data['potongan'] = $this->penggajianModel->get_data('status_kehadiran')->result();
		$data['input_absensi'] = $this->db->query("SELECT data_pegawai.*, data_jabatan.nama_jabatan FROM data_pegawai
			INNER JOIN data_jabatan ON data_pegawai.id_jabatan=data_jabatan.id_jabatan			
			WHERE NOT EXISTS (SELECT * FROM data_kehadiran  WHERE data_pegawai.nik=data_kehadiran.nik AND tgl_input_absensi >= '$mindt' AND tgl_input_absensi <= '$maxdt') ORDER BY data_pegawai.nama_pegawai ASC")->result();
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/formInputAbsensi',$data);
		$this->load->view('templates_admin/footer');
	}
}
 ?>