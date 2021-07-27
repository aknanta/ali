<?php 
class SlipGaji extends CI_Controller{

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
            $data['title'] = "Filter Slip Gaji Pegawai";

            $startdate = $this->input->get('startdate') ?? 0;
			$enddate = $this->input->get('enddate') ?? 0;

            $data['pegawai'] = $this->penggajianModel->get_data('data_pegawai')->result();
            $data['startdate'] = $startdate;
			$data['enddate'] = $enddate;
            $this->load->view('templates_admin/header',$data);
		    $this->load->view('templates_admin/sidebar');
		    $this->load->view('admin/filterSlipGaji', $data);
		    $this->load->view('templates_admin/footer');
        }

        public function cetakSlipGaji()
        {
            $data['title'] = "Cetak Slip Gaji Pegawai";
            $data['potongan'] = $this->penggajianModel->get_data('status_kehadiran')->result();
            $nama = $this->input->get('nama_pegawai');

			$startdate = $this->input->get('startdate') ?? 0;
			$enddate = $this->input->get('enddate') ?? 0;
            

            $data['print_slip'] = $this->db->query("SELECT data_pegawai.nik, data_pegawai.nama_pegawai, data_kehadiran.tgl_input_absensi, data_jabatan.nama_jabatan, data_posisi.jenis_posisi, pemetaan_sotk.upah_jam_lembur, data_kehadiran.lembur, pemetaan_sotk.gaji_harian, data_kehadiran.lembur, pemetaan_sotk.upah_jam_lembur
            FROM data_pegawai 
            INNER JOIN data_kehadiran ON data_kehadiran.nik=data_pegawai.nik 
            INNER JOIN data_posisi ON data_posisi.id_posisi=data_pegawai.id_posisi
            INNER JOIN data_jabatan ON data_jabatan.id_jabatan=data_pegawai.id_jabatan
            INNER JOIN pemetaan_sotk ON pemetaan_sotk.id_jabatan=data_pegawai.id_jabatan
            INNER JOIN status_kehadiran ON data_kehadiran.id_status=status_kehadiran.id_status 
            WHERE tgl_input_absensi >= '$startdate' AND tgl_input_absensi <= '$enddate' AND
            data_pegawai.nama_pegawai='$nama'")->result();
            $data['startdate'] = $startdate;
			$data['enddate'] = $enddate;
            $this->load->view('templates_admin/header',$data);
		    $this->load->view('admin/cetakSlipGaji', $data);
        }
}
?>