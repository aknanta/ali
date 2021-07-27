<?php
class GenerateModel extends CI_model{
	
    const table = "data_generate";

	public function get_data(){
		return $this->db->get($this->table);
	}

	public function insert_data($data){
		$this->db->insert("data_generate",$data);
	}

	public function update_data($data, $where){
		$this->db->update($this->table, $data, $where);
	}

	public function delete_data($where){
		$this->db->where($where);
		$this->db->delete($this->table);
	}

	public function insert_batch($table = null, $data = array())
	{
		$jumlah = count($data);
		if($jumlah > 0)
		{
			$this->db->insert_batch($table, $data);
		}
	}
	public function detailGenerate($id)
	{
		return $this->db->query('SELECT data_pegawai.nik,data_pegawai.nama_pegawai,data_jabatan.nama_jabatan, data_posisi.jenis_posisi, sum(pemetaan_sotk.gaji_harian), sum(pemetaan_sotk.lembur), data_kehadiran.payout, data_kehadiran.tgl_input_absensi, data_kehadiran.id_status
			FROM data_pegawai
			INNER JOIN data_kehadiran ON data_kehadiran.nik=data_pegawai.nik 
			INNER JOIN pemetaan_sotk ON pemetaan_sotk.id_jabatan=data_pegawai.id_jabatan 
			INNER JOIN data_jabatan ON data_jabatan.id_jabatan=data_pegawai.id_jabatan
			INNER JOIN data_posisi ON data_posisi.id_posisi=data_kehadiran.id_posisi
			WHERE
  			/* Greater or equal to the start of last month */
  			data_kehadiran.tgl_input_absensi >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 1 MONTH)), INTERVAL 1 DAY) and
  			/* Smaller or equal than one month ago */
  			data_kehadiran.tgl_input_absensi <= DATE_SUB(NOW(), INTERVAL 1 MONTH) AND data_kehadiran.id_status = "2" GROUP BY nik');
	}
}

?>