<?php

class LaporanAbsensi extends CI_Controller{

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
        $data['title'] = "Laporan Absensi";
        $this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/filterLaporanAbsensi');
		$this->load->view('templates_admin/footer');
    }

    public function cetakLaporanAbsensi()
    {
        
        $data['title'] = "Cetak Laporan Absensi";

		$startdate = $this->input->get('startdate') ?? 0;
		$enddate = $this->input->get('enddate') ?? 0;

        $data['lap_kehadiran'] = $this->db->query("SELECT data_kehadiran.*, data_pegawai.nama_pegawai, data_pegawai.id_jabatan, data_posisi.jenis_posisi, status_kehadiran.status_kehadiran, data_kehadiran.lembur
        FROM data_kehadiran
        INNER JOIN data_pegawai ON data_kehadiran.nik=data_pegawai.nik
        INNER JOIN data_posisi ON data_kehadiran.id_posisi = data_posisi.id_posisi
        INNER JOIN status_kehadiran ON data_kehadiran.id_status = status_kehadiran.id_status
        WHERE tgl_input_absensi >= '$startdate' AND tgl_input_absensi <= '$enddate' ORDER BY data_kehadiran.tgl_input_absensi ASC")->result();
        $data['startdate'] = $startdate;
		$data['enddate'] = $enddate;
        $this->load->view('templates_admin/header',$data);
		$this->load->view('admin/cetakLaporanAbsensi',$data);
    }
}

?>