<?php 

class PenggajianModel extends CI_model{
	
	public function get_data($table){
		return $this->db->get($table);
	}

	public function insert_data($data,$table){
		$this->db->insert($table,$data);
	}

	public function update_data($table, $data, $where){
		$this->db->update($table, $data, $where);
	}

	public function delete_data($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}

	public function insert_batch($table = null, $data = array())
	{
		$jumlah = count($data);
		if($jumlah > 0)
		{
			$this->db->insert_batch($table, $data);
		}
	}
	public function cek_login()
	{
		$username	= set_value('username');
		$password	= set_value('password');
		$result		= $this->db->where('username',$username)
								->where('password',md5($password))
								->limit(1)
								->get('data_pegawai');
		if($result->num_rows()>0){
			return $result->row();
		}else{
			return FALSE;
		}
	}

	//pagination data pegawai
	public function getPegawai($limit, $start)
	{
		$this->db->select('data_pegawai.* , data_posisi.jenis_posisi, data_jabatan.nama_jabatan');
		$this->db->from('data_pegawai');
		$this->db->join('data_posisi', 'data_posisi.id_posisi = data_pegawai.id_posisi');
		$this->db->join('data_jabatan', 'data_jabatan.id_jabatan = data_pegawai.id_jabatan');
		$this->db->order_by('data_pegawai.nama_pegawai ASC');
		$this->db->limit($limit, $start);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function countAllDataPegawai()
	{
		return $this->db->query('SELECT data_pegawai.*, data_jabatan.nama_jabatan, data_posisi.jenis_posisi
		FROM data_pegawai JOIN data_jabatan ON data_pegawai.id_jabatan = data_jabatan.id_jabatan
		JOIN data_posisi ON data_pegawai.id_posisi = data_posisi.id_posisi')->num_rows();
	}

	//pagination data pemetaan
	public function getPemetaanSOTK($limit, $start)
	{
		$this->db->select('pemetaan_sotk.* , data_posisi.jenis_posisi, data_jabatan.nama_jabatan');
		$this->db->from('pemetaan_sotk');
		$this->db->join('data_posisi', 'data_posisi.id_posisi = pemetaan_sotk.id_posisi');
		$this->db->join('data_jabatan', 'data_jabatan.id_jabatan = pemetaan_sotk.id_jabatan');
		$this->db->limit($limit, $start);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function countAllDataPemetaanSOTK()
	{
		return $this->db->query('SELECT pemetaan_sotk.*, data_jabatan.nama_jabatan, data_posisi.jenis_posisi
		FROM pemetaan_sotk JOIN data_jabatan ON pemetaan_sotk.id_jabatan = data_jabatan.id_jabatan
		JOIN data_posisi ON pemetaan_sotk.id_posisi = data_posisi.id_posisi')->num_rows();
	}

	//pagination data gaji
	public function getDataPenggajian($limit, $start = 0, $daterange)
	{
		$this->db->select('data_pegawai.nik,data_pegawai.nama_pegawai,data_jabatan.nama_jabatan, data_posisi.jenis_posisi, pemetaan_sotk.gaji_harian, data_kehadiran.payout, data_kehadiran.tgl_input_absensi, pemetaan_sotk.upah_jam_lembur, data_kehadiran.lembur');
		$this->db->from('data_pegawai');
		$this->db->join('data_kehadiran', 'data_kehadiran.nik=data_pegawai.nik');
		$this->db->join('pemetaan_sotk', 'pemetaan_sotk.id_jabatan=data_pegawai.id_jabatan');
		$this->db->join('data_jabatan', 'data_jabatan.id_jabatan=data_pegawai.id_jabatan');
		$this->db->join('data_posisi', 'data_posisi.id_posisi=data_kehadiran.id_posisi');
		$this->db->where('tgl_input_absensi >=', $daterange[0]);
		$this->db->where('tgl_input_absensi <=', $daterange[1]);
		$this->db->where('data_kehadiran.id_status != "1"');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
	}

	public function countAllDataGaji()
	{
		$this->db->select('data_pegawai.nik,data_pegawai.nama_pegawai,data_jabatan.nama_jabatan, data_posisi.jenis_posisi, pemetaan_sotk.gaji_harian, data_kehadiran.payout, data_kehadiran.tgl_input_absensi');
		$this->db->from('data_pegawai');
		$this->db->join('data_kehadiran', 'data_kehadiran.nik=data_pegawai.nik');
		$this->db->join('pemetaan_sotk', 'pemetaan_sotk.id_jabatan=data_pegawai.id_jabatan ');
		$this->db->join('data_jabatan', 'data_jabatan.id_jabatan=data_pegawai.id_jabatan');
		$this->db->join('data_posisi', 'data_posisi.id_posisi=data_kehadiran.id_posisi');
		$query = $this->db->get();
		return $query->num_rows();
	}

	//pagination data absensi
	public function get_limit_data($limit,$start = 0, $daterange)
	{
		$this->db->select('data_kehadiran. *, data_pegawai.nama_pegawai, data_pegawai.id_jabatan, data_posisi.jenis_posisi, status_kehadiran.status_kehadiran');
		$this->db->from('data_kehadiran');
		$this->db->join('data_pegawai', 'data_kehadiran.nik=data_pegawai.nik');
		$this->db->join('data_posisi', 'data_kehadiran.id_posisi = data_posisi.id_posisi');
		$this->db->join('status_kehadiran', 'data_kehadiran.id_status = status_kehadiran.id_status');
		$this->db->where('tgl_input_absensi >=', $daterange[0]);
		$this->db->where('tgl_input_absensi <=', $daterange[1]);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
	}
	public function countGaji()
	{
		$this->db->select('data_kehadiran. *, data_pegawai.nama_pegawai, data_pegawai.id_jabatan, data_posisi.jenis_posisi, status_kehadiran.status_kehadiran');
		$this->db->from('data_kehadiran');
		$this->db->join('data_pegawai', 'data_kehadiran.nik=data_pegawai.nik');
		$this->db->join('data_posisi', 'data_kehadiran.id_posisi = data_posisi.id_posisi');
		$this->db->join('status_kehadiran', 'data_kehadiran.id_status = status_kehadiran.id_status');
		$query = $this->db->get();
		return $query->num_rows();
	}

	//pagination data jabatan

	public function getJabatan($limit, $start)
	{
		return $this->db->get('data_jabatan', $limit, $start)->result_array();
	}

	public function countAllData()
	{
		return $this->db->get('data_jabatan')->num_rows();
	}

	//pagination data posisi

	public function getPosisi($limit, $start)
	{
		return $this->db->get('data_posisi', $limit, $start)->result_array();
	}

	public function countAllDataPosisi()
	{
		return $this->db->get('data_posisi')->num_rows();
	}

	//pagination halaman pegawai data gaji
	public function getGajiPegawai($limit, $start, $nik)
	{
		$this->db->select('data_pegawai.nik,data_pegawai.nama_pegawai,data_jabatan.nama_jabatan,data_kehadiran.id_kehadiran,data_kehadiran.tgl_input_absensi, data_kehadiran.lembur, pemetaan_sotk.upah_jam_lembur, pemetaan_sotk.gaji_harian');
		$this->db->from('data_pegawai');
		$this->db->join('data_kehadiran', 'data_kehadiran.nik=data_pegawai.nik');
		$this->db->join('pemetaan_sotk', 'pemetaan_sotk.id_jabatan = data_pegawai.id_jabatan');
		$this->db->join('status_kehadiran', 'data_kehadiran.id_status = status_kehadiran.id_status');
		$this->db->join('data_jabatan', 'data_jabatan.id_jabatan = data_pegawai.id_jabatan');
		$this->db->where('data_kehadiran.nik =', $nik);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
	}
	public function countAllDataGajiPegawai()
	{
		return $this->db->query("SELECT data_pegawai.nik,data_pegawai.nama_pegawai,data_jabatan.nama_jabatan,data_kehadiran.id_kehadiran,data_kehadiran.tgl_input_absensi, data_kehadiran.lembur, pemetaan_sotk.upah_jam_lembur, pemetaan_sotk.gaji_harian
		FROM data_pegawai
		INNER JOIN data_kehadiran ON data_kehadiran.nik=data_pegawai.nik 
		INNER JOIN pemetaan_sotk ON pemetaan_sotk.id_jabatan=data_pegawai.id_jabatan 
		INNER JOIN data_jabatan ON data_jabatan.id_jabatan=data_pegawai.id_jabatan
		INNER JOIN status_kehadiran ON status_kehadiran.id_status = data_kehadiran.id_status")->num_rows();
	}
}

 ?>