<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transfer extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Transfer_model");
		$this->load->model("Token_model");
		$this->load->helper('form');
		$this->load->library('session');
	}


	public function listtransfer()
	{
		$data['getalltransfer'] = $this->Transfer_model->antridatatrf();
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('transfer/listtransfer', $data);
		$this->load->view('template/footer');
	}

	public function otorisasi()
	{
		$keyword1 = $this->input->get('start_date');
		$keyword2 = $this->input->get('end_date');
		$data['getallotorisasi'] = $this->Transfer_model->gettrfotorisasi($keyword1, $keyword2);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('transfer/otorisasi', $data);
		$this->load->view('template/footer');
	}

	public function prosesotorisasi()
	{
		$transfer_id = $_POST['transfer_id'];
		$ses_nama = $this->session->userdata('ses_nama');

		if ($transfer_id) {
			$this->Transfer_model->otorisasi($transfer_id, $ses_nama);
			redirect('transfer/otorisasi');
		} else {
			$this->session->set_flashdata('flash', 'Pilih data yang akan di otorisasi!!');
			redirect('transfer/otorisasi');
		}
	}

	public function transfermanual()
	{
		error_reporting(0);
		$keterangantrans = $_GET['keterangantrans'];
		$start_date = $_GET['start_date'];
		$end_date = $_GET['end_date'];



		//Do real escaping here

		$query = "data_transfer.transfer_type ='2' and data_transfer.hasil_transfer ='1' and
	   			((data_transfer.jumlah <= jenis_pembayaran.max_transfer and data_transfer.terotorisasi ='2') or
	   			(data_transfer.jumlah > jenis_pembayaran.max_transfer and data_transfer.terotorisasi ='1'))";
		$conditions = array();

		if (!empty($start_date)) {
			$conditions[] = "jadwal_transfer>='$start_date'";
		}
		if (!empty($end_date)) {
			$conditions[] = "jadwal_transfer<='$end_date'";
		}
		if (!empty($keterangantrans)) {
			$conditions[] = "ket_transfer='$keterangantrans'";
		}

		$sql = $query;
		if (count($conditions) > 0) {
			$sql .= " and " . implode(' AND ', $conditions);
		}

		$bagianWhere = $sql;
		$data['gettrfmanual'] = $this->Transfer_model->gettrfmanual($bagianWhere);
		$data['kettransfer'] = $this->Transfer_model->getkettrf();
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('transfer/transfermanual', $data);
		$this->load->view('template/footer');
	}

	public function prosestrfmanual() //belum selesai//
	{

		$transfer_id = $_POST['transfer_id'];
		$ses_nama = $this->session->userdata('ses_nama');
		$this->Transfer_model->prosestrfmanual($transfer_id, $ses_nama);
?>
		<script>
			window.location = history.go(-1);
		</script>

<?php
	}

	public function laporantransfer()
	{
		error_reporting(0);
		$start_date = $_GET['start_date'];
		$end_date = $_GET['end_date'];
		$kettrf = $_GET['kettrf'];
		$trftype = $_GET['trftype'];


		//Do real escaping here


		$conditions = array();

		if (!empty($start_date)) {
			$conditions[] = "jadwal_transfer>='$start_date'";
		}
		if (!empty($end_date)) {
			$conditions[] = "jadwal_transfer<='$end_date'";
		}
		if (!empty($kettrf)) {
			$conditions[] = "ket_transfer='$kettrf'";
		}
		if (!empty($trftype)) {
			$conditions[] = "transfer_type='$trftype'";
		}


		if (count($conditions) > 0) {
			$sql .= implode(' AND ', $conditions);
		}

		$bagianWhere = $sql;


		$data['kettrf'] = $this->Transfer_model->carikettransfer();
		$data['gettrflap'] = $this->Transfer_model->gettrflap($bagianWhere);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('transfer/laporantransfer', $data);
		$this->load->view('template/footer');
	}

	public function exporttransfer()
	{
		// Load plugin PHPExcel nya
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php'; //copy plugin phpexcel ke controler/third_party

		// Panggil class PHPExcel nya
		$excel = new PHPExcel();

		// Settingan awal fil excel
		$excel->getProperties()->setCreator('MRI Transfer')
			->setLastModifiedBy('MRI Transfer')
			->setTitle("Data Transfer")
			->setSubject("Transfer")
			->setDescription("Laporan Data Transfer")
			->setKeywords("Data Transfer");

		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Data Transfer"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A1:P1'); // Set Merge Cell pada kolom A1 sampai E1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "transfer_id"); // Set kolom A3 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "transfer_req_id"); // Set kolom B3 dengan tulisan "NIS"
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "transfer_type"); // Set kolom C3 dengan tulisan "NAMA"
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "jenis_pembayaran_id"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "keterangan"); // Set kolom E3 dengan tulisan "ALAMAT"
		$excel->setActiveSheetIndex(0)->setCellValue('F3', "waktu_request");
		$excel->setActiveSheetIndex(0)->setCellValue('G3', "jadwal_transfer");
		$excel->setActiveSheetIndex(0)->setCellValue('H3', "norek");
		$excel->setActiveSheetIndex(0)->setCellValue('I3', "pemilik_rekening");
		$excel->setActiveSheetIndex(0)->setCellValue('J3', "bank");
		$excel->setActiveSheetIndex(0)->setCellValue('K3', "kode_bank");
		$excel->setActiveSheetIndex(0)->setCellValue('L3', "berita_transfer");
		$excel->setActiveSheetIndex(0)->setCellValue('M3', "jumlah");
		$excel->setActiveSheetIndex(0)->setCellValue('N3', "terotorisasi");
		$excel->setActiveSheetIndex(0)->setCellValue('O3', "hasil_transfer");
		$excel->setActiveSheetIndex(0)->setCellValue('P3', "ket_transfer");

		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);

		// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
		error_reporting(0);
		$start_date = $_GET['start_date'];
		$end_date = $_GET['end_date'];
		$kettrf = $_GET['kettrf'];
		$trftype = $_GET['trftype'];


		//Do real escaping here


		$conditions = array();

		if (!empty($start_date)) {
			$conditions[] = "jadwal_transfer>='$start_date'";
		}
		if (!empty($end_date)) {
			$conditions[] = "jadwal_transfer<='$end_date'";
		}
		if (!empty($kettrf)) {
			$conditions[] = "ket_transfer='$kettrf'";
		}
		if (!empty($trftype)) {
			$conditions[] = "transfer_type='$trftype'";
		}


		if (count($conditions) > 0) {
			$sql .= implode(' AND ', $conditions);
		}

		$bagianWhere = $sql;
		$transfer = $this->Transfer_model->gettrflap($bagianWhere);

		//$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach ($transfer as $data) { // Lakukan looping pada variabel siswa
			//$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $data->transfer_id); // Set kolom A3 dengan tulisan "NO"
			$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->transfer_req_id); // Set kolom B3 dengan tulisan "NIS"
			$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->transfer_type); // Set kolom C3 dengan tulisan "NAMA"
			$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->jenis_pembayaran_id); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
			$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->keterangan); // Set kolom E3 dengan tulisan "ALAMAT"
			$excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->waktu_request);
			$excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->jadwal_transfer);
			$excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->norek);
			$excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->pemilik_rekening);
			$excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->bank);
			$excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->kode_bank);
			$excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data->berita_transfer);
			$excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data->jumlah);
			$excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data->terotorisasi);
			$excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data->hasil_transfer);
			$excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $data->ket_transfer);


			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);
			$numrow++; // Tambah 1 setiap kali looping
		}

		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(15); // Set width kolom
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Laporan Data Transfer");
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data Transfer.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');

		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}


	//API BCA

	public function getToken()
	{
		$apikey = $this->session->userdata('token');
		$api_secret = $this->session->userdata('api_secret');
		$d = $this->Token_model->gettoken();
		foreach ($d->result() as $d) {
			$tokendb = $d->token;
			$api_secret_db = $d->api_secret;
			$client_id = $d->client_id;
			$client_secret = $d->client_secret;
		}
		if (password_verify($apikey, $tokendb) && password_verify($api_secret, $api_secret_db)) {
			$this->load->library('Api_Bca');
			$this->api_bca->getToken($client_id, $client_secret);
		} else {
			$this->session->set_flashdata('flash', 'Key BCA Is Not Valid');
			redirect('token/sessiontoken');
		}
	}

	public function Infobal()
	{
		$saldo = $this->Transfer_model->getinfobal();
		if ($saldo) {
			$data['infobal'] = $saldo;
		}
		$summary = $this->Transfer_model->summarydatatrf();
		if ($summary) {
			$data['sumdatatrf'] = $summary;
		}
		$list = $this->Transfer_model->antridatatrf();
		if ($list) {
			$data['listantri'] = $list;
		}
		$this->load->view('overview', $data);
	}

	public function getInfobal()
	{
		$apikey = $this->session->userdata('token');
		$api_secret = $this->session->userdata('api_secret');
		$d = $this->Token_model->gettoken();
		foreach ($d->result() as $d) {
			$tokendb = $d->token;
			$api_secret_db = $d->api_secret;
			$client_id = $d->client_id;
			$client_secret = $d->client_secret;
		}
		if (password_verify($apikey, $tokendb) && password_verify($api_secret, $api_secret_db)) {
			$this->load->library('Api_Bca');
			$this->api_bca->getToken($client_id, $client_secret);
			$saldo = $this->api_bca->getInfobal($decode, $apikey, $api_secret);
			// redirect('transfer/infobal');
		} else {
			$this->session->set_flashdata('flash', 'Key BCA Is Not Valid');
			redirect('token/sessiontoken');
		}
	}

	public function reloadInfobal()
	{
		$apikey = $this->session->userdata('token');
		$api_secret = $this->session->userdata('api_secret');
		$d = $this->Token_model->gettoken();
		foreach ($d->result() as $d) {
			$tokendb = $d->token;
			$api_secret_db = $d->api_secret;
		}
		if (password_verify($apikey, $tokendb) && password_verify($api_secret, $api_secret_db)) {
			$this->load->library('Api_Bca');
			$decode = $this->api_bca->getToken();
			$saldo = $this->api_bca->getInfobal($decode, $apikey, $api_secret);
		} else {
			$this->session->set_flashdata('flash', 'Key BCA Is Not Valid');
			redirect('token/sessiontoken');
		}
	}

	public function getTransfer()
	{
		$api_secret = $this->session->userdata('api_secret');
		$apikey = $this->session->userdata('token');
		$d = $this->Token_model->gettoken();
		foreach ($d->result() as $d) {
			$tokendb = $d->token;
			$api_secret_db = $d->api_secret;
			$client_id = $d->client_id;
			$client_secret = $d->client_secret;
		}
		//cek Session KEY BCA
		if (password_verify($apikey, $tokendb)  && password_verify($api_secret, $api_secret_db)) {
			//cek jumlah data di transfer
			$cek_data = $this->Transfer_model->getdatatrf();
			if ($cek_data->num_rows() > 0) {
				//cek total transfer <= saldo di database
				$d = $this->Transfer_model->getdatatrf();
				foreach ($d->result() as $d) {
					$jumlah[] = $d->jumlah;
				}
				$total_trf = array_sum($jumlah);

				$q = $this->Transfer_model->getinfobal();
				$saldo_db = $q['saldo'];

				$kurang = $total_trf - $saldo_db;

				if ($total_trf <= $saldo_db) {

					$this->load->library('Api_Bca');
					$data = $this->Transfer_model->getdatatrf();
					foreach ($data->result() as $data) {
						$transfer_req_id = $data->transfer_req_id;
						$source_account = $data->source_account;
						$referenceid = $data->referenceid;
						$transfer_type = $data->transfer_type;
						$jenis_pembayaran_id = $data->jenis_pembayaran_id;
						$keterangan = $data->keterangan;
						$waktu_request = $data->waktu_request;
						$jadwal_transfer = $data->jadwal_transfer;
						$norek = $data->norek;
						$pemilik_rekening = $data->pemilik_rekening;
						$bank = $data->bank;
						$kode_bank = $data->kode_bank;
						$berita_transfer = $data->berita_transfer;
						$jumlah = $data->jumlah;

						//transfer auto dan scheduler
						if ($transfer_type == '1' or $transfer_type == '3') {
							//transfer sesama bank bca
							if ($kode_bank == '014') {

								$decode = $this->api_bca->getToken($client_id, $client_secret);
								$result = $this->api_bca->getTransfer($source_account, $decode, $norek, $jumlah, $transfer_req_id, $berita_transfer, $apikey, $referenceid, $api_secret);
								/*$reloadInfobal = $this->reloadInfobal();
						    		echo "<script>window.close();</script>";*/
								//transfer selain bank bca
							} else {
								$decode = $this->api_bca->getToken($client_id, $client_secret);
								$result = $this->api_bca->getDomTransfer($source_account, $decode, $norek, $jumlah, $transfer_req_id, $pemilik_rekening, $kode_bank, $berita_transfer, $apikey, $referenceid, $api_secret);
								/*$reloadInfobal = $this->reloadInfobal();
									echo "<script>window.close();</script>";*/
							}
						}
					}
				} else { //saldo keseluruhan tidak cukup
					$data = $this->Transfer_model->getdatatrf();
					foreach ($data->result() as $data) {
						$transfer_req_id = $data->transfer_req_id;
						$ket_transfer = "Saldo Tidak Cukup";
						$update = $this->Transfer_model->updatestatusdatatrf($transfer_req_id, $ket_transfer);
					}

					$dataemail = $this->Transfer_model->getemailadmin();
					foreach ($dataemail as $key) {
						$message = 'Informasi System MRI Transfer, <br>
				        			Saldo tidak mencukup untuk transfer. <br>
				        			Saldo saat ini = Rp. ' . number_format($saldo_db) . ' <br> 
				        			Total dibutuhkan = Rp. ' . number_format($total_trf) . ' <br>
				        			Kekurangan Rp. ' . number_format($kurang) . '<br>
				        			Jika sudah di TOP UP mohon untuk di refresh Query Saldo di Dashboard. <br><br>
				        			Salam, <br><br>
				        			MRI Transfer';

						$email = $key['user_login'];
						$ci = get_instance();
						$ci->load->library('email');
						$config['protocol'] = "smtp";
						$config['smtp_host'] = "ssl://smtp.gmail.com";
						$config['smtp_port'] = "465";
						$config['smtp_user'] = "mteguhh12@gmail.com"; //ganti dengan email pengirim
						$config['smtp_pass'] = "12Desember1994"; //ganti dengan password pengirim
						$config['charset'] = "utf-8";
						$config['mailtype'] = "html";
						$config['newline'] = "\r\n";
						$ci->email->initialize($config);
						$ci->email->from('mteguhh12@gmail.com', 'Teguh'); //ganti dengan email pengirim
						$ci->email->to($email);
						$ci->email->subject('MRI Transfer Failed : Saldo kurang');
						$ci->email->message($message);
						if ($this->email->send()) {
							echo "<script>window.close();</script>";
						}
					}
				}
			}
		} else { //Session KEY BCA Invalid
			$data = $this->Transfer_model->getdatatrf();
			foreach ($data->result() as $data) {
				$transfer_req_id = $data->transfer_req_id;
				$ket_transfer = "Session KEY BCA Invalid";
				$update = $this->Transfer_model->updatestatusdatatrf($transfer_req_id, $ket_transfer);
			}

			$dataemail = $this->Transfer_model->getemailadmin();
			foreach ($dataemail as $key) {
				$message = 'Session KEY BCA tidak terdaftar, <br><br>
				        			Salam, <br><br>
				        			MRI Transfer';

				$email = $key['user_login'];
				$ci = get_instance();
				$ci->load->library('email');
				$config['protocol'] = "smtp";
				$config['smtp_host'] = "ssl://smtp.gmail.com";
				$config['smtp_port'] = "465";
				$config['smtp_user'] = "mteguhh12@gmail.com"; //ganti dengan email pengirim
				$config['smtp_pass'] = "12Desember1994"; //ganti dengan password pengirim
				$config['charset'] = "utf-8";
				$config['mailtype'] = "html";
				$config['newline'] = "\r\n";
				$ci->email->initialize($config);
				$ci->email->from('mteguhh12@gmail.com', 'Teguh'); //ganti dengan email pengirim
				$ci->email->to($email);
				$ci->email->subject('MRI Transfer Failed : Session KEY BCA Invalid');
				$ci->email->message($message);
				if ($this->email->send()) {
					echo "<script>window.close();</script>";
				}
			}
		}
		echo "<script>window.close();</script>";
	}

	//ambil data transfer scheduler
	public function getinsertdatatrf()
	{

		$datadb1 = $this->Transfer_model->getdatabasepertama();
		$transfer_req_id = $datadb1['transfer_req_id'];


		$data_trf = $this->Transfer_model->getdatabasekedua($transfer_req_id);
		if ($data_trf->num_rows() > 0) {
			foreach ($data_trf->result_array() as $key) {
				$data = array(
					'transfer_req_id' => $key['transfer_req_id'],
					'transfer_type' => $key['transfer_type'],
					'jenis_pembayaran_id' => $key['jenis_pembayaran_id'],
					'keterangan' => $key['keterangan'],
					'waktu_request' => $key['waktu_request'],
					'jadwal_transfer' => $key['jadwal_transfer'],
					'norek' => $key['norek'],
					'pemilik_rekening' => $key['pemilik_rekening'],
					'bank' => $key['bank'],
					'kode_bank' => $key['kode_bank'],
					'berita_transfer' => $key['berita_transfer'],
					'jumlah' => $key['jumlah'],
					'terotorisasi' => $key['terotorisasi'],
					'hasil_transfer' => '1',
					'ket_transfer' => 'Antri'
				);
				$this->Transfer_model->insnewdatatrf($data);
				echo "<script>window.close();</script>";
			}
		} else {
			echo "<script>window.close();</script>";
		}
	}

	public function backupdatatrf()
	{
		$backup_data = $this->Transfer_model->backupdatatrf();

		if ($backup_data) {
			$this->Transfer_model->deldatatrf();
			echo "<script>window.close();</script>";
		} else {
			echo "<script>window.close();</script>";
		}
	}
}
