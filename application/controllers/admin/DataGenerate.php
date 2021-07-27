<?php
class DataGenerate extends CI_Controller{
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
        $data['title'] = "Data Generate Gaji Pegawai";

        $startdate = $this->input->get('startdate') ?? 0;
		$enddate = $this->input->get('enddate') ?? 0;

        $data["generate"] = $this->db->query("SELECT data_generate.id_generate, data_generate.id_pegawai, data_generate.nama_generate, data_generate.tgl_awal, data_generate.tgl_akhir,
            data_generate.isTerbayarkan, data_generate.empPembayar, data_pegawai.username
            FROM data_generate
            INNER JOIN data_pegawai ON data_generate.id_pegawai = data_pegawai.id_pegawai
			WHERE data_generate.tgl_awal >= '$startdate' AND data_generate.tgl_akhir <= '$enddate'
            ORDER BY data_generate.tgl_awal ASC
        ")->result();

        
        $this->load->view('templates_admin/header',$data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/dataGenerate',$data);
        $this->load->view('templates_admin/footer');

    }


    public function gaji($startdate,$enddate)
	{
		$data['gaji'] = $this->db->query("SELECT data_pegawai.nik,
											data_pegawai.nama_pegawai,
											data_jabatan.nama_jabatan, 
											data_posisi.jenis_posisi, 
											pemetaan_sotk.gaji_harian,
											pemetaan_sotk.upah_jam_lembur,
											data_kehadiran.payout,
                                            data_kehadiran.lembur,
											data_kehadiran.tgl_input_absensi
											FROM data_pegawai
											INNER JOIN data_kehadiran ON data_kehadiran.nik=data_pegawai.nik 
											INNER JOIN pemetaan_sotk ON pemetaan_sotk.id_jabatan=data_pegawai.id_jabatan 
											INNER JOIN data_jabatan ON data_jabatan.id_jabatan=data_pegawai.id_jabatan
											INNER JOIN data_posisi ON data_posisi.id_posisi=data_kehadiran.id_posisi
											WHERE tgl_input_absensi >= '$startdate' AND tgl_input_absensi <= '$enddate' 
											AND data_kehadiran.id_status != '1'
											ORDER BY data_kehadiran.tgl_input_absensi ASC")->result();
		$this->load->view('admin/dataGenerateGaji',$data);
	}
    public function updateNamaPembayar()
    {
        if (isset($_POST['idGenerate'])) {
            $id = $_POST['idGenerate'];
            $name = $_POST['namaPembayar'];
            $update = $this->db->query("UPDATE data_generate SET empPembayar = '$name', isTerbayarkan = 1 WHERE id_generate = '$id'");

    		redirect(base_url('admin/DataGenerate'));
        }
    }

}