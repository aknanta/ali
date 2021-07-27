<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ExcelModel extends CI_Model
{
    public function data_excel()
    {
        $results = array();
        $query = $this->db->query('SELECT nik FROM data_pegawai');
        // $query = $this->db->query('SELECT data_kehadiran.*, status_kehadiran.*, data_posisi.* , data_pegawai.nik
        // FROM data_kehadiran
        // INNER JOIN data_pegawai ON 
        // INNER JOIN status_kehadiran ON data_kehadiran.id_status=status_kehadiran.id_status 
        // INNER JOIN data_posisi ON data_kehadiran.id_posisi=data_posisi.id_posisi');

        if ($query->num_rows() > 0) {
            $results = $query->result();
        }
        return $results;
    }

    public function preview_excel()
    {
        $results = array();
        $query = $this->db->query('SELECT data_kehadiran.*, status_kehadiran.*, data_posisi.* 
        FROM data_kehadiran
        INNER JOIN status_kehadiran ON data_kehadiran.id_status=status_kehadiran.id_status 
        INNER JOIN data_posisi ON data_kehadiran.id_posisi=data_posisi.id_posisi');

        if ($query->num_rows() > 0) {
            $results = $query->result();
        }
        return $results;
    }
}
