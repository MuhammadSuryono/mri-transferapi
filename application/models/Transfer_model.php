<?php

class Transfer_model extends CI_model
{

	public function gettransfer()
	{

		// $this->db->select('*');
		// $this->db->from('data_transfer');
		// $this->db->join('jenis_pembayaran', 'data_transfer.jenis_pembayaran_id=jenis_pembayaran.jenispembayaranid');
		// $this->db->where('data_transfer.hasil_transfer', 1);
		// $this->db->where('data_transfer.jadwal_transfer >=', DATE_SUB(NOW(), INTERVAL 5 MINUTE));
		// $this->db->order_by('data_transfer.transfer_id', 'ASC');

		$query = $this->db->query("SELECT *
										FROM data_transfer a
										JOIN jenis_pembayaran b ON a.jenis_pembayaran_id = b.jenispembayaranid
										WHERE a.hasil_transfer = 1 AND a.jadwal_transfer >= DATE_SUB(NOW(), INTERVAL 90 MINUTE) AND a.transfer_type != 2
										ORDER BY a.transfer_id ASC
										");

		return $query->result_array();
	}

	public function summarydatatrf()
	{
		$this->db->select("count(transfer_req_id) as trx , sum(jumlah) as total");
		$this->db->from('data_transfer');
		$this->db->where('hasil_transfer', '1');
		$this->db->where('ket_transfer', 'Antri');
		return $this->db->get()->row_array();
	}

	public function antridatatrf()
	{
		$this->db->select('*');
		$this->db->from('data_transfer');
		$this->db->join('jenis_pembayaran', 'data_transfer.jenis_pembayaran_id=jenis_pembayaran.jenispembayaranid');
		$this->db->where('hasil_transfer', '3');
		$this->db->order_by('transfer_id');
		return $this->db->get()->result_array();
	}

	public function antridatatrfdashboard()
	{
		$this->db->select('*');
		$this->db->from('data_transfer');
		$this->db->join('jenis_pembayaran', 'data_transfer.jenis_pembayaran_id=jenis_pembayaran.jenispembayaranid');
		$this->db->where('hasil_transfer', '1');
		$this->db->where('ket_transfer', 'Antri');
		$this->db->order_by('transfer_id');
		return $this->db->get()->result_array();
	}

	public function gettrfotorisasi($keyword1, $keyword2)
	{

		$this->db->select('*');
		$this->db->from('data_transfer');
		$this->db->join('jenis_pembayaran', 'data_transfer.jenis_pembayaran_id=jenis_pembayaran.jenispembayaranid');
		if (!empty($keyword1)) {
			$this->db->where("data_transfer.jumlah > jenis_pembayaran.max_transfer AND data_transfer.terotorisasi='2' AND
							  data_transfer.jadwal_transfer between '$keyword1' AND '$keyword2'");
		} else {
			$this->db->where("data_transfer.jumlah > jenis_pembayaran.max_transfer AND data_transfer.terotorisasi='2'");
		}
		$this->db->order_by('data_transfer.transfer_id', 'ASC');
		return $this->db->get()->result();
	}

	public function otorisasi($transfer_id, $ses_nama)
	{
		date_default_timezone_set('asia/bangkok');
		$this->db->set('terotorisasi', '1');
		$this->db->set('nm_otorisasi', $ses_nama);
		$this->db->set('jadwal_transfer', date('Y-m-d H:i:s', time() + 60));
		$this->db->where_in('transfer_id', $transfer_id);
		$this->db->update('data_transfer');
	}

	public function gettrfmanual($bagianWhere)
	{

		$this->db->select('*');
		$this->db->from('data_transfer');
		$this->db->join('jenis_pembayaran', 'data_transfer.jenis_pembayaran_id=jenis_pembayaran.jenispembayaranid');
		$this->db->where($bagianWhere);
		$this->db->order_by('data_transfer.transfer_id', 'ASC');
		return $this->db->get()->result();
	}

	public function prosestrfmanual($transfer_id, $ses_nama) //proses transfer auto belum selesai//
	{
		date_default_timezone_set("Asia/Jakarta");
		$this->db->set('nm_manual', $ses_nama);
		$this->db->set('ket_transfer', 'Antri');
		$this->db->set('transfer_type', '3');
		$this->db->set('jadwal_transfer', date('Y-m-d H:i:s', time() + 60));
		$this->db->where_in('transfer_id', $transfer_id);
		$this->db->update('data_transfer');
	}

	public function getkettrf()
	{
		$query = $this->db->query("SELECT ket_transfer
									FROM data_transfer
									WHERE ket_transfer !='Success' AND transfer_type ='2'
									GROUP BY ket_transfer
									ORDER BY ket_transfer ASC");
		return $query->result_array();
	}

	public function gettrflap($bagianWhere)
	{

		$this->db->select('*');
		$this->db->from('data_transfer');
		$this->db->join('jenis_pembayaran', 'data_transfer.jenis_pembayaran_id=jenis_pembayaran.jenispembayaranid');
		if (!empty($bagianWhere)) {
			$this->db->where($bagianWhere);
		}
		$this->db->order_by('data_transfer.transfer_id', 'ASC');
		return $this->db->get()->result();
	}

	public function getinfobal()
	{
		$this->db->select('*');
		$this->db->from('saldo');
		$this->db->order_by('datetime', 'desc');
		$this->db->limit('1');
		return $this->db->get()->row_array();
	}

	public function getInfoBalance()
	{
		$this->db->select('*');
		$this->db->from('saldo');
		$this->db->order_by('datetime', 'desc');
		$this->db->limit('1');
		return $this->db->get()->row_array();
	}

	public function updtsaldoawal()
	{
		$this->db->set('saldo_awal', $saldo_db);
		$this->db->where_in('transfer_req', $transfer_req);
		$this->db->update('data_transfer');
	}

	public function updtsaldakhir()
	{
		$this->db->set('saldo_akhir', $saldo_db);
		$this->db->where_in('transfer_req', $transfer_req);
		$this->db->update('data_transfer');
	}

	public function getDataKas()
	{
		$dbDevelop = $this->load->database('db_develop', TRUE);
		$dbDevelop->select('*');
		$dbDevelop->where('type_kas', 'mri-pall');
		return $dbDevelop->get('kas')->result_array();
	}

	public function getSaldoKas($rekeingSumber)
	{
		$this->db->select('*');
		$this->db->from('saldo');
		$this->db->where('rekening', $rekeingSumber);
		$this->db->order_by('datetime', 'desc');
		$this->db->limit('1');
		return $this->db->get()->row();
	}

	public function dataTransfer($rekening)
	{
		$query = $this->db->query(
			"SELECT * FROM `data_transfer` JOIN `jenis_pembayaran` on
	   		`data_transfer`.`jenis_pembayaran_id`=`jenis_pembayaran`.`jenispembayaranid` WHERE
            `data_transfer`.`rekening_sumber` = '$rekening' AND
	   		(`data_transfer`.`jadwal_transfer` <= NOW() AND `data_transfer`.`jadwal_transfer` >= DATE_SUB(NOW(), INTERVAL 90 MINUTE)) AND
	   		`data_transfer`.`hasil_transfer`= '1' AND
			((`data_transfer`.`jumlah` <= `jenis_pembayaran`.`max_transfer` AND `data_transfer`.`terotorisasi` ='2') OR
	   		(`data_transfer`.`jumlah` > `jenis_pembayaran`.`max_transfer` AND `data_transfer`.`terotorisasi` ='1'))"
		);

		return $query->result();
	}

	public function dataTransferInNomorRekening($rekening)
	{
		$query = $this->db->query(
			"SELECT * FROM `data_transfer` JOIN `jenis_pembayaran` on
	   		`data_transfer`.`jenis_pembayaran_id`=`jenis_pembayaran`.`jenispembayaranid` WHERE
            `data_transfer`.`rekening_sumber` IN $rekening AND
	   		(`data_transfer`.`jadwal_transfer` <= NOW() AND `data_transfer`.`jadwal_transfer` >= DATE_SUB(NOW(), INTERVAL 90 MINUTE)) AND
	   		`data_transfer`.`hasil_transfer`= '1' AND
			((`data_transfer`.`jumlah` <= `jenis_pembayaran`.`max_transfer` AND `data_transfer`.`terotorisasi` ='2') OR
	   		(`data_transfer`.`jumlah` > `jenis_pembayaran`.`max_transfer` AND `data_transfer`.`terotorisasi` ='1'))"
		);

		return $query->result();
	}

	public function getdatatrf()
	{
		$query = $this->db->query(
			"SELECT * FROM `data_transfer` JOIN `jenis_pembayaran` on
	   		`data_transfer`.`jenis_pembayaran_id`=`jenis_pembayaran`.`jenispembayaranid` WHERE
	   		(`data_transfer`.`jadwal_transfer` <= NOW() AND `data_transfer`.`jadwal_transfer` >= DATE_SUB(NOW(), INTERVAL 90 MINUTE)) AND
	   		`data_transfer`.`hasil_transfer`= '1' AND
			((`data_transfer`.`jumlah` <= `jenis_pembayaran`.`max_transfer` AND `data_transfer`.`terotorisasi` ='2') OR
	   		(`data_transfer`.`jumlah` > `jenis_pembayaran`.`max_transfer` AND `data_transfer`.`terotorisasi` ='1'))"
		);
		return $query;
	}

	public function getDataTransferBridge($transfer_req_id)
	{
		$dbBridge = $this->load->database('db2', TRUE);
		$data = $dbBridge->select('*')->where('transfer_req_id', $transfer_req_id)->order_by('transfer_req_id',"desc")->limit(1)->get('data_transfer')->row();
		return $data;
	}

	public function updatestatusdatatrf($transfer_req_id, $ket_transfer)
	{
		date_default_timezone_set("Asia/Jakarta");
		if ($ket_transfer == 'Session KEY BCA Invalid') {
			$this->db->set('jadwal_transfer', date('Y-m-d H:i:s', time() + 60 * 5));
		} else {
			$this->db->set('transfer_type', '2');
		}
		$this->db->set('ket_transfer', $ket_transfer);
		$this->db->where_in('transfer_req_id', $transfer_req_id);
		$this->db->update('data_transfer');
	}

	public function getdatadomtrf()
	{
		$this->db->select('*');
		$this->db->from('data_transfer');
		$this->db->where('kode_bank !=', '014');
		$this->db->where('hasil_transfer', '1');
		return $this->db->get()->result_array();
	}

	public function carikettransfer()
	{
		$query = $this->db->query("SELECT ket_transfer
									FROM data_transfer
									WHERE ket_transfer !='Success'
									GROUP BY ket_transfer
									ORDER BY ket_transfer ASC");
		return $query->result_array();
	}

	public function getemailadmin()
	{
		$this->db->select('user_login');
		$this->db->from('user');
		$this->db->where('roleid', '1');
		return $this->db->get()->result_array();
	}

	//ambil data transfer scheduler
	public function getdatabasepertama()
	{

		$this->db->select_max('transfer_id');
		$this->db->from('data_transfer');
		return $this->db->get()->row_array();
	}


	public function getdatabasekedua()
	{
		$db2 = $this->load->database('db2', TRUE);
		$db2->select('*');
		$db2->from('data_transfer');
		$db2->where('hasil_transfer', 1);
		$db2->where('ket_transfer', 'Antri');
		$db2->where('jadwal_transfer IS NOT NULL', null, false);
		$query = $db2->get();
		return $query;

		/*$db2->query("INSERT INTO `mri_transfer`.`data_transfer` (
						transfer_req_id,transfer_type,jenis_pembayaran_id,keterangan,waktu_request,
						jadwal_transfer,norek,pemilik_rekening,bank,kode_bank,berita_transfer,jumlah,
						terotorisasi,hasil_transfer,ket_transfer
					)
					select
					transfer_req_id,transfer_type,jenis_pembayaran_id,keterangan,waktu_request,
					jadwal_transfer,norek,pemilik_rekening,bank,kode_bank,berita_transfer,
					jumlah,terotorisasi,'1','Pending'
					from `mritransferapi`.`data_transfer`
					WHERE `mritransferapi`.`data_transfer`");*/
	}

	public function insnewdatatrf($data)
	{

		$this->db->insert('data_transfer', $data);
	}

	//backup data transfer
	public function backupdatatrf()
	{

		$query = $this->db->query("INSERT INTO archieve_transfer SELECT * FROM data_transfer WHERE waktu_request < DATE_SUB(NOW(), INTERVAL 3 MONTH)");
		return $query;
	}

	public function deldatatrf()
	{

		$query = $this->db->query("DELETE FROM data_transfer WHERE waktu_request < DATE_SUB(NOW(), INTERVAL 3 MONTH)");
		return $query;
	}

	public function checkByStatus($id)
	{
		$query = $this->db->query("SELECT * FROM data_transfer WHERE transfer_id='$id'");
		return $query->row_array();
	}

	public function updateDataTransfer($id, $data)
	{
		$this->db->where('transfer_id', $id);
		$this->db->update('data_transfer', $data);
	}

	public function updateStatusBpu($noid, $jadwal_transfer = '', $jenis_project = '')
	{
		$db_budget = $this->load->database('db_budget', TRUE);
		$db_develop = $this->load->database('db_develop', TRUE);
		$db_jay = $this->load->database('db_jay', TRUE);
		$db_b2 = $this->load->database('db_b2', TRUE);
		// $date = date('Y-m-d', $jadwal_transfer);
		$dt = new DateTime($jadwal_transfer);
		$date = $dt->format('Y-m-d');

		if ($jenis_project == 'B1' || $jenis_project == 'B2') {
			$firstCode = 'KKP' . date('m') . '-BCA-';
		} else if ($jenis_project == 'Rutin' || $jenis_project == "Non Rutin") {
			$firstCode = 'KKNP' . date('m') . '-BCA-';
		} else if ($jenis_project == 'Uang Muka') {
			$firstCode = 'KKUM' . date('m') . '-BCA-';
		}
		$db_budget->select("count(*) as count");
		$db_budget->from('bpu');
		$db_budget->like('novoucher', $firstCode);
		$result = $db_budget->get()->row_array();
		$secondCode = date('y') . sprintf('%04d', $result['count'] + 1);

		$fullCode = $firstCode . $secondCode;

		$this->db->select('*');
		$this->db->from('data_transfer');
		$this->db->where('noid_bpu', $noid);
		$resultTransfer = $this->db->get()->row_array();

		$db_budget->reset_query();

		$db_budget->select('*');
		$db_budget->from('rekening');
		$db_budget->where('rekening', $resultTransfer['rekening_sumber']);
		$resultRekening = $db_budget->get()->row_array();

		$db_budget->reset_query();

		$db_budget->select('*');
		$db_budget->from('bpu');
		$db_budget->where('noid', $noid);
		$resultBpu = $db_budget->get()->row_array();

		$db_develop->select('*');
		$db_develop->from('umo_biaya_kode');
		$db_develop->where('biaya_kode_id', $resultBpu['umo_biaya_kode_id']);
		$resultBiayaKode = $db_develop->get()->row_array();
		$db_develop->reset_query();

		$data = [
			'biaya_nomor' => $fullCode,
			'biaya_tanggal' => $date,
			'biaya_keterangan' => $resultTransfer['berita_transfer'],
			'biaya_total' => $resultTransfer['jumlah'],
			'biaya_check' => 0,
			'biaya_kas' => $resultRekening['no'],
			'biaya_status' => 0
		];


		$db_develop->insert('umo_biaya', $data);
		$db_develop->reset_query();

		$query = $db_develop->query("SELECT * FROM umo_biaya ORDER BY biaya_id DESC LIMIT 1");
		$resultUmoBiaya = $query->row_array();

		$data = [
			'biaya_detail_kode' => $resultBiayaKode['biaya_kode_kode'],
			'biaya_detail_rekening' => $resultBiayaKode['biaya_kode_nama'],
			'biaya_detail_nilai' => $resultTransfer['jumlah'],
			'biaya_detail_ref_id' => $resultUmoBiaya['biaya_id']
		];

		$db_develop->insert('umo_biaya_detail', $data);

		$db_budget->reset_query();

		$db_budget->set('status', 'Telah Di Bayar');
		$db_budget->set('tglcair', $date);
		$db_budget->set('novoucher', $fullCode);
		$db_budget->where('noid', $noid);

		$db_jay->set('status_pembayaran', 3);
		$db_jay->where('noid_bpu', $noid);
		$db_jay->update('field_pembayaran');

		$db_b2->set('status_pembayaran_id', 3);
		$db_b2->where('bpu_noid', $noid);
		$db_b2->update('pembayaran_interviewers');

		$db_b2->reset_query();

		$db_b2->set('status_pembayaran_id', 3);
		$db_b2->where('bpu_noid', $noid);
		$db_b2->update('pembayaran_tls');

		return $db_budget->update('bpu');
	}

	public function getRekening()
	{
		// $this->db->select('*');
		// $this->db->from('db_budget.rekening');
		$db_develop = $this->load->database('db_develop', TRUE);
		$db_develop->from('kas');
		$db_develop->where('stat', 'MRI');
		// $db_develop->leftJoin($this->db . '.saldo', 'saldo.rekening = rekening.rekening');
		return $db_develop->get()->result_array();
	}

	public function getJenisBudget($noid)
	{
		$db_budget = $this->load->database('db_budget', TRUE);
		$db_budget->select('*');
		$db_budget->from('bpu');
		$db_budget->where('noid', $noid);
		return $db_budget->get()->row_array();
	}
}
