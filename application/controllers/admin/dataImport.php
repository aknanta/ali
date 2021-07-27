<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DataImport extends CI_Controller
{
	private $filename = "import_data"; // Kita tentukan nama filenya

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
		$this->load->model('absenModel');
		$this->load->model('excelModel');
	}

	public function index()
	{
		$data['absen'] = $this->absenModel->view();
		$this->load->view('admin/view', $data);
	}

	public function form()
	{

		$data = array(); // Buat variabel $data sebagai array

		if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
			// lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
			$upload = $this->absenModel->upload_file($this->filename);

			if ($upload['result'] == "success") { // Jika proses upload sukses
				// Load plugin PHPExcel nya
				include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('excel/' . $this->filename . '.xlsx'); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

				// Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
				// Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
				$data['sheet'] = $sheet;
				$data['user'] = $this->excelModel->preview_excel();
			} else { // Jika proses upload gagal
				$data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
			}
		}

		$this->load->view('admin/form', $data);
	}

	public function import()
	{
		// Load plugin PHPExcel nya
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('excel/' . $this->filename . '.xlsx'); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

		// Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
		$data = array();
		$userData = $this->excelModel->data_excel();
		// $posisi = array();
		// $potongan = array();
		$payout = array();
		foreach ($userData as $d) {
			// $potongan = $d->id_status;
			$payout = "Belum";
			// $posisi = $d->id_posisi;
		}

		$numrow = 1;
		foreach ($sheet as $row) {
			// Cek $numrow apakah lebih dari 1
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport
			if ($numrow > 1) {

				// Kita push (add) array data ke variabel data
				array_push($data, array(
					'nik' => $row['A'], // Insert data nis dari kolom A di excel
					'tgl_input_absensi' => $row['B'], // Insert data nama dari kolom B di excel
					'id_posisi' => $row['C'], // Insert data jenis kelamin dari kolom C di excel
					'shift' => $row['D'],
					'total_jam_kerja' => $row['E'],
					'lembur' => $row['F'],
					'id_status' => $row['G'],
					'payout' => $payout,
				));
			}

			$numrow++; // Tambah 1 setiap kali looping
		}

		// Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
		$this->absenModel->insert_multiple($data);

		redirect("admin/DataAbsensi"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}

	public function export_excel()
	{
		$excelObj = new Spreadsheet;

		$excelObj->getProperties()->setCreator("shakila");
		$excelObj->getProperties()->setLastModifiedBy("shakila");
		$excelObj->getProperties()->setTitle("Data Absensi");
		$excelObj->getProperties()->setSubject("");
		$excelObj->getProperties()->setDescription("");

		$excelObj->setActiveSheetIndex(0);

		$excelObj->getActiveSheet()->setCellValue("A1", "NIK");
		$excelObj->getActiveSheet()->setCellValue("B1", "Tanggal Input Absensi");
		$excelObj->getActiveSheet()->setCellValue("C1", "ID Posisi");
		$excelObj->getActiveSheet()->setCellValue("D1", "Shift");
		$excelObj->getActiveSheet()->setCellValue("E1", "Total Jam Kerja");
		$excelObj->getActiveSheet()->setCellValue("F1", "Lembur");
		$excelObj->getActiveSheet()->setCellValue("G1", "ID Status");

		// $excelObj->getActiveSheet()->getStyle("A2")->getNumberFormat()->setFormatCode('#,##0.00');
		$excelObj->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excelObj->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excelObj->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excelObj->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excelObj->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excelObj->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$excelObj->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

		$baris = 2;
		$absen = $this->excelModel->data_excel();

		foreach ($absen as $d) {
			$excelObj->getActiveSheet()->setCellValue('A' . $baris, $d->nik);
			$excelObj->getActiveSheet()->setCellValue('B' . $baris, "");
			$excelObj->getActiveSheet()->setCellValue('C' . $baris, "");
			$excelObj->getActiveSheet()->setCellValue('D' . $baris, "");
			$excelObj->getActiveSheet()->setCellValue('E' . $baris, "");
			$excelObj->getActiveSheet()->setCellValue('F' . $baris, "");
			$excelObj->getActiveSheet()->setCellValue('G' . $baris, "");

			$baris++;
		}

		$fn = "Data Absensi " . date("d-m-Y") . ".xlsx";

		$excelObj->getActiveSheet()->setTitle("Data Absensi");

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename = "' . $fn . '"');
		header('Cache-Control: max-age = 0');

		$writer = new Xlsx($excelObj);
		$writer->save('php://output');

		exit;
	}
}
