<?php 

class DataPosisi extends CI_Controller{

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
		$config['base_url'] = 'http://localhost/ali/admin/dataPosisi/index';
		$config['total_rows'] = $this->penggajianModel->countAllDataPosisi();
		$config['per_page'] = 10;

		//get data title dan url
		$data['title'] = "Data Posisi";
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
		$data['posisi_kerja'] = $this->penggajianModel->getPosisi($config['per_page'], $data['start']);
		// $data['posisi_kerja'] = $this->penggajianModel->get_data('data_posisi')->result();
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/dataPosisi',$data);
		$this->load->view('templates_admin/footer');
	}

	public function tambahData()
	{
		$data['title'] = "Tambah Data Posisi Kerja";
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/tambahDataPosisi',$data);
		$this->load->view('templates_admin/footer');
	}

	public function tambahDataAksi()
	{
		$this->_rules();

		if($this->form_validation->run() == FALSE) {
			$this->tambahData();
		}else{
            $jenis_posisi       = $this->input->post('jenis_posisi');
			$data = array(
                'jenis_posisi'      => $jenis_posisi,
			);
			$this->penggajianModel->insert_data($data,'data_posisi');
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data Berhasil Di Tambahkan</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('admin/dataPosisi');

		}
	}

	public function updateData($id)
	{
		$where = array('id_posisi' => $id);
		$data['posisi_kerja'] = $this->db->query("SELECT * FROM data_posisi WHERE id_posisi='$id'")->result();
		$data['title'] = "Update Data Posisi";
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/updateDataPosisi',$data);
		$this->load->view('templates_admin/footer');
	}

	public function updateDataAksi()
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->updateData();
		}else{
			$id 				= $this->input->post('id_posisi');
            $jenis_posisi       = $this->input->post('jenis_posisi');

			$data = array(
                'jenis_posisi'     => $jenis_posisi,
			);

			$where = array(
				'id_posisi' => $id
			);

			$this->penggajianModel->update_Data('data_posisi',$data,$where);
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data Berhasil Di Update</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('admin/dataPosisi');

		}
	}

	public function _rules()
	{
        $this->form_validation->set_rules('jenis_posisi','jenis posisi','required');
	}

	public function deleteData($id)
	{
		$where = array('id_posisi' => $id);
		$this->penggajianModel->delete_data($where, 'data_posisi');

		$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data Berhasil Di Hapus</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('admin/dataPosisi');
	}
}

 ?>