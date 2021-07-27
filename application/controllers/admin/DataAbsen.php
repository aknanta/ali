<?php 

class DataAbsen extends CI_Controller{
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
    public function index($timezone = 'Asia/Jakarta')
	{
		$data['title'] = "Data Absensi Pegawai";
		$mindt = 0;
		$maxdt = 0;
		if (isset($_GET['date'])){
			$mindt = strtotime($_GET['date']) ?? 0;
			$maxdt = $mindt + 25200;
		}
		$data['absensi'] = $this->db->query("SELECT data_kehadiran.*, data_pegawai.nama_pegawai, data_pegawai.id_jabatan, data_posisi.jenis_posisi, status_kehadiran.status_kehadiran
			FROM data_kehadiran
			INNER JOIN data_pegawai ON data_kehadiran.nik=data_pegawai.nik
			INNER JOIN data_posisi ON data_kehadiran.id_posisi = data_posisi.id_posisi
			INNER JOIN status_kehadiran ON data_kehadiran.id_status = status_kehadiran.id_status
			WHERE tgl_input_absensi >= $mindt AND tgl_input_absensi <= $maxdt
			ORDER BY data_pegawai.nama_pegawai ASC")->result();
		$data['date'] = $mindt;
		
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/dataAbsen',$data);
		$this->load->view('templates_admin/footer');
		$this->load->library('pagination');
		$config['base_url'] = 'http://example.com/index.php/test/page/';
	}

    public function inputAbsen()
	{
		if($this->input->post('submit', TRUE) == 'submit') {
			
			$post = $this->input->post();

			 foreach ($post['tgl_input_absensi'] as $key => $value) {
				if($post['tgl_input_absensi'][$key] !='' || $post['nik'][$key] !='')
				{
					$parsedDate = date('Y-m-d', intval($post['tgl_input_absensi'][$key]));
					$simpan[] = array(

						'tgl_input_absensi' 		 => $parsedDate,
						'nik'  			 			 => $post['nik'][$key],
						'id_posisi'		 			 => $post['id_posisi'][$key],
						'shift'     	             => $post['shift'][$key],
						'total_jam_kerja'            => $post['total_jam_kerja'][$key],
						'lembur'     	             => $post['lembur'][$key],
						'id_status'			 		 => $post['id_status'][$key],
					);	
				}
			}
			//var_dump(strtotime($post['date']), $post['date'], $post['tgl_input_absensi']);
			$this->penggajianModel->insert_batch('data_kehadiran',$simpan);
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data Berhasil Di Tambahkan</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('admin/DataAbsen');
		}
		$mindt = /*strtotime('now')*/ 0 ;
		$maxdt = 0;
		if (isset($_GET['date'])) {
			$mindt = strtotime($_GET['date']);
			$maxdt = $mindt + 25200;
		}
		$data['title'] = "Form Input Absensi";
		$data['posisi_kerja'] = $this->penggajianModel->get_data('data_posisi')->result();
		$data['potongan'] = $this->penggajianModel->get_data('status_kehadiran')->result();
		$data['input_absensi'] = $this->db->query(
			"SELECT data_pegawai.*, data_jabatan.nama_jabatan
			FROM data_pegawai
			INNER JOIN data_jabatan ON data_pegawai.id_jabatan=data_jabatan.id_jabatan			
			-- WHERE NOT EXISTS (SELECT * FROM data_kehadiran  WHERE data_pegawai.nik=data_kehadiran.nik AND tgl_input_absensi >= '$mindt' AND tgl_input_absensi <= '$maxdt') 
			ORDER BY data_pegawai.nama_pegawai ASC")->result();
			//var_dump($data['input_absensi']); die();
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/formInputAbsensi',$data);
		$this->load->view('templates_admin/footer');
	}
}
?>