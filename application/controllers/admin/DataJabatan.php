<?php 

class DataJabatan extends CI_Controller{

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
		$config['base_url'] = 'http://localhost/ali/admin/dataJabatan/index';
		$config['total_rows'] = $this->penggajianModel->countAllData();
		$config['per_page'] = 10;

		//get data title dan url
		$data['title'] = "Data Jabatan";
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
		$data['jabatan'] = $this->penggajianModel->getJabatan($config['per_page'], $data['start']);
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/dataJabatan',$data);
		$this->load->view('templates_admin/footer');
	}

	public function tambahData()
	{
		$data['title'] = "Tambah Data Jabatan";
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/tambahDataJabatan',$data);
		$this->load->view('templates_admin/footer');
	}

	public function tambahDataAksi()
	{
		$this->_rules();

		if($this->form_validation->run() == FALSE) {
			$this->tambahData();
		}else{
			$nama_jabatan		= $this->input->post('nama_jabatan');
			$data = array(
				'nama_jabatan' => $nama_jabatan,
			);
			$this->penggajianModel->insert_data($data,'data_jabatan');
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data Berhasil Di Tambahkan</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('admin/dataJabatan');

		}
	}

	public function updateData($id)
	{
		$where = array('id_jabatan' => $id);
		$data['jabatan'] = $this->db->query("SELECT * FROM data_jabatan WHERE id_jabatan='$id'")->result();
		$data['title'] = "Updata Data Jabatan";
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/updateDataJabatan',$data);
		$this->load->view('templates_admin/footer');
	}

	public function updateDataAksi()
	{
		$this->_rules();

		if($this->form_validation->run() == FALSE) {
			$this->updateData();
		}else{
			$id 				= $this->input->post('id_jabatan');
			$nama_jabatan		= $this->input->post('nama_jabatan');

			$data = array(
				'nama_jabatan' => $nama_jabatan,
			);

			$where = array(
				'id_jabatan' => $id
			);

			$this->penggajianModel->update_Data('data_jabatan',$data,$where);
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data Berhasil Di Update</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('admin/dataJabatan');

		}
	}

	public function _rules()
	{
		$this->form_validation->set_rules('nama_jabatan','nama jabatan','required');
	}

	public function deleteData($id)
	{
		$where = array('id_jabatan' => $id);
		$this->penggajianModel->delete_data($where, 'data_jabatan');

		$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data Berhasil Di Hapus</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('admin/dataJabatan');
	}
}

 ?>