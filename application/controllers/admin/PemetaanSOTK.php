<?php 

class pemetaanSOTK extends CI_Controller{

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
		$this->load->model('penggajianModel');
		$this->load->library('pagination');

		//config
		$config['base_url'] = 'http://localhost/ali/admin/pemetaanSOTK/index';
		$config['total_rows'] = $this->penggajianModel->countAllDataPemetaanSOTK();
		$config['per_page'] = 10;

		//get data title dan url
		$data['title'] = "Pemetaan SOTK";
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
		$data['pemetaansotk'] = $this->penggajianModel->getPemetaanSOTK($config['per_page'], $data['start']);
		// $data['pemetaansotk'] = $this->db->query('SELECT pemetaan_sotk.*, data_jabatan.nama_jabatan, data_posisi.jenis_posisi
		//  FROM pemetaan_sotk JOIN data_jabatan ON pemetaan_sotk.id_jabatan = data_jabatan.id_jabatan
		//  JOIN data_posisi ON pemetaan_sotk.id_posisi = data_posisi.id_posisi')->result();
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/pemetaanSOTK',$data);
		$this->load->view('templates_admin/footer');
	}

	public function tambahData()
	{
		$data['title'] = "Pemetaan SOTK";
		$data['posisi_kerja'] = $this->penggajianModel->get_data('data_posisi')->result();
		$data['jabatan'] = $this->penggajianModel->get_data('data_jabatan')->result();
		$this->load->view('templates_admin/header',$data);	
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/tambahDataPemetaanSOTK',$data);
		$this->load->view('templates_admin/footer');

	}

	public function tambahDataAksi()
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->tambahData();
		}else{
			$id_jabatan 		 = $this->input->post('id_jabatan');
			$id_posisi		     = $this->input->post('id_posisi');
			$gaji_harian		 = $this->input->post('gaji_harian');
			$upah_jam_lembur	 = $this->input->post('upah_jam_lembur');
			
			
				}
			
			$data = array(
				'id_jabatan'				=> $id_jabatan,
				'id_posisi'		     		=> $id_posisi,
				'gaji_harian'				=> $gaji_harian,
				'upah_jam_lembur'			=> $upah_jam_lembur,
			);

			$this->penggajianModel->insert_data($data,'pemetaan_sotk');
			$data['jabatan'] = $this->penggajianModel->get_data('data_jabatan');
			$data['posisi_kerja'] = $this->penggajianModel->get_data('data_posisi');
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data Berhasil Di Tambahkan</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('admin/pemetaanSOTK');
		}

		public function updateData($id)
		{
			$where = array('id_pemetaan' => $id);
			$data['title'] = 'Update Data Pemetaan SOTK';
			$data['pemetaansotk'] = $this->db->query("SELECT * FROM pemetaan_sotk WHERE id_pemetaan='$id'")->result();
			$this->load->view('templates_admin/header',$data);
			$this->load->view('templates_admin/sidebar');
			$this->load->view('admin/UpdateDataPemetaanSOTK',$data);
			$this->load->view('templates_admin/footer');
		}
	
		public function updateDataAksi()
		{
			$this->_rules();
	
			if ($this->form_validation->run() == FALSE) {
				$this->updateData();
			}else{
				$id					= $this->input->post('id_pemetaan');
				$jabatan			= $this->input->post('jabatan');
				$posisi_kerja	 	= $this->input->post('posisi_kerja');
				$gaji_harian		= $this->input->post('gaji_harian');
				$upah_jam_lembur	= $this->input->post('upah_jam_lembur');
			}
				$data = array(
					'gaji_harian'			=> $gaji_harian,
					'upah_jam_lembur'		=> $upah_jam_lembur,
				);
	
				$where = array(
					'id_pemetaan'  => $id
				);
	
				$this->penggajianModel->update_data('pemetaan_sotk',$data,$where);
				$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data Berhasil Di Update</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				</div>');
				redirect('admin/pemetaanSOTK');
			}
	
	public function _rules()
	{

		$this->form_validation->set_rules('upah_jam_lembur','upah jam lembur','required');
		$this->form_validation->set_rules('gaji_harian','gaji harian','required');
		
	}

	public function deleteData($id)
	{
		$where = array('id_pemetaan' => $id);
		$this->penggajianModel->delete_data($where, 'pemetaan_sotk');
		$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data Berhasil Di Hapus</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('admin/pemetaanSOTK');
	}
}

 ?>