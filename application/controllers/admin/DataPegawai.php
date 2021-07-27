<?php 

class dataPegawai extends CI_Controller{
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
		$config['base_url'] = 'http://localhost/ali/admin/dataPegawai/index';
		$config['total_rows'] = $this->penggajianModel->countAllDataPegawai();
		$config['per_page'] = 10;

		//get data title dan url
		$data['title'] = "Data Pegawai";
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
		$data['pegawai'] = $this->penggajianModel->getPegawai($config['per_page'], $data['start']);
		// $data['pegawai'] = $this->db->query('SELECT data_pegawai.*, data_jabatan.nama_jabatan, data_posisi.jenis_posisi
		// FROM data_pegawai JOIN data_jabatan ON data_pegawai.id_jabatan = data_jabatan.id_jabatan
		// JOIN data_posisi ON data_pegawai.id_posisi = data_posisi.id_posisi')->result();
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/dataPegawai',$data);
		$this->load->view('templates_admin/footer');
	}

	public function tambahData()
	{
		$data['title'] = "Tambah Data Pegawai";
		$data['posisi_kerja'] = $this->penggajianModel->get_data('data_posisi')->result();
		$data['jabatan'] = $this->penggajianModel->get_data('data_jabatan')->result();
		$this->load->view('templates_admin/header',$data);	
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/formTambahPegawai',$data);
		$this->load->view('templates_admin/footer');

	}

	public function tambahDataAksi()
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->tambahData();
			
			$nik			 = $this->input->post('nik');
			$nama_pegawai	 = $this->input->post('nama_pegawai');
			$alamat_peg		 = $this->input->post('alamat_peg');
			$id_posisi	 	 = $this->input->post('id_posisi');
			$tanggal_masuk	 = $this->input->post('tanggal_masuk');
			$id_jabatan	 	 = $this->input->post('id_jabatan');
			// $status			 = $this->input->post('status');
			$hak_akses		 = $this->input->post('hak_akses');
			$username		 = $this->input->post('username');
			$password		 = md5($this->input->post('password'));
		}else{
				}
			
			$data = array(
				'nik'				=> $nik,
				'nama_pegawai'		=> $nama_pegawai,
				'alamat_peg'		=> $alamat_peg,
				'id_posisi'			=> $id_posisi,
				'id_jabatan'		=> $id_jabatan,
				'tanggal_masuk'		=> $tanggal_masuk,
				// 'status'			=> $status,
				'hak_akses'			=> $hak_akses,
				'username'			=> $username,
				'password'			=> $password,
			);

			$this->penggajianModel->insert_data($data,'data_pegawai');
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data Berhasil Di Tambahkan</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('admin/dataPegawai');
		}

	public function updateData($id)
	{
		$where = array('id_pegawai' => $id);
		$data['title'] = 'Update Data Pegawai';
		$data['jabatan'] = $this->penggajianModel->get_data('data_jabatan')->result();
		$data['posisi_kerja'] = $this->penggajianModel->get_data('data_posisi')->result();
		$data['pegawai'] = $this->db->query("SELECT * FROM data_pegawai WHERE id_pegawai='$id'")->result();
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/formUpdatePegawai',$data);
		$this->load->view('templates_admin/footer');
	}

	public function updateDataAksi()
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->updateData($id);
		
			$id			     = $this->input->post('id_pegawai');
			$nik			 = $this->input->post('nik');
			$nama_pegawai	 = $this->input->post('nama_pegawai');
			$alamat_peg		 = $this->input->post('alamat_peg');
			$id_posisi	 	 = $this->input->post('id_posisi');
			$tanggal_masuk	 = $this->input->post('tanggal_masuk');
			$id_jabatan		 = $this->input->post('id_jabatan');
			// $status			 = $this->input->post('status');
			$hak_akses		 = $this->input->post('hak_akses');
			$username		 = $this->input->post('username');
			//$password		 = md5($this->input->post('password'));
		}else{
		}
			$data = array(
				'nik'				=> $nik,
				'nama_pegawai'		=> $nama_pegawai,
				'alamat_peg'		=> $alamat_peg,
				'id_posisi'			=> $id_posisi,
				'id_jabatan'		=> $id_jabatan,
				'tanggal_masuk'		=> $tanggal_masuk,
				// 'status'			=> $status,
				'hak_akses'			=> $hak_akses,
				'username'			=> $username,
				//'password'			=> $password,
			);

			$where = array(
				'id_pegawai'  => $id,
			);

			$this->penggajianModel->update_data('data_pegawai',$data,$where);
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data Berhasil Di Update</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('admin/dataPegawai');
		}
	
	public function _rules()
	{
		$this->form_validation->set_rules('nik','NIK','required');
		$this->form_validation->set_rules('nama_pegawai','Nama Pegawai','required');
		$this->form_validation->set_rules('alamat_peg','Alamat Pegawai','required');
		$this->form_validation->set_rules('jenis_posisi','Posisi Kerja','required');
		$this->form_validation->set_rules('nama_jabatan','jabatan','required');
		$this->form_validation->set_rules('tanggal_masuk','tanggal masuk','required');
		// $this->form_validation->set_rules('status','status','required');
	}

	public function deleteData($id)
	{
		$where = array('id_pegawai' => $id);
		$this->penggajianModel->delete_data($where, 'data_pegawai');
		$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data Berhasil Di Hapus</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('admin/dataPegawai');
	}
}

 ?>