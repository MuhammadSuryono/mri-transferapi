<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);


class Api_Bca
{

	var $CI;
	public function __construct($params = array())
	{
		$this->CI = &get_instance();
		$this->CI->load->helper('url');
		$this->CI->config->item('base_url');
		$this->CI->load->database();
	}
	protected $settings = array(

		//'main_url' => 'https://api.klikbca.com:443', // Change When Your Apps is Live
		'main_url' => 'https://devapi.klikbca.com:9443', // Change When Your Apps is Live
		//'client_id' => '75d795xx-4e32-47bf-8dce-48fef9a7fxxx', // Fill With Your Client ID
		//'client_secret' => 'e9223xxx-02b0-4090-8562-a20be7cd8xxx', // Fill With Your Client Secret ID
		//'api_key' => 'f65b8exx-1ae0-495e-8410-8e4c174bfxxx', // Fill With Your API Key ex f65b8e4b-1ae0-495e-8410-8e4c174bfb94
		//'api_secret' => '6a8fcxx-4478-46de-8c08-1260b3430xxx', // Fill With Your API Secret Key
		//'corporate_id' => 'BCAAPI', // Fill With Your Corporate ID. BCAAPI2016 is Sandbox ID
		//'account_number' => '4593xxxxxx', // Fill With Your Account Number. 0201245680 is Sandbox Account
		//'channelid' => '95051', //Channel Identification Number (Ex: 95051 for KlikBCA Bisnis)
		'credentialid' => 'BCAAPI' //Your Channel Identity (ex: Your KlikBCA Bisnis CorporateID)

	);



	//mendapatkan accsess token
	public function getToken($client_id, $client_secret)
	{
		// $client_id = $this->settings['client_id'];
		// $client_secret = $this->settings['client_secret'];
		$main_url = $this->settings['main_url'];
		$encode = base64_encode($client_id . ':' . $client_secret);

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $main_url . "/api/oauth/token",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "grant_type=client_credentials&undefined=",
			CURLOPT_HTTPHEADER => array(
				"Authorization: Basic " . $encode,
				"Content-Type: application/x-www-form-urlencoded"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		// curl_setopt($curl, CURLINFO_HEADER_OUT, true);//info header
		// $response = curl_exec($curl);
		// $info = curl_getinfo($curl);
		// $err = curl_error($curl);
		// curl_close($curl);
		// print_r($info['request_header']);
		// print_r($data);
		// print_r($response);
		// print_r($decode);
		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$result = json_decode($response, TRUE);
			$decode = $result['access_token'];
			return $decode;
			//print_r($decode);
		}
	}
	//function infomation balance account
	public function getInfobal($decode, $apikey, $api_secret, $corporate_id, $account_number)
	{
		//$apikey = $this->settings['api_key'];
		// $secretkey = $this->settings['api_secret'];
		$main_url = $this->settings['main_url'];
		// $corporate_id = $this->settings['corporate_id'];
		// $account_number = $this->settings['account_number'];
		$token = $decode;

		date_default_timezone_set("Asia/Jakarta");
		$waktu = date('Y-m-d\TH:i:s.000P');
		$signature = 'GET:' . "/banking/v3/corporates/" . $corporate_id . "/accounts/" . $account_number . ":" . $token . ":" . hash('sha256', '') . ":" . $waktu;
		$signfinal = hash_hmac('sha256', $signature, $api_secret);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $main_url . "/banking/v3/corporates/" . $corporate_id . "/accounts/" . $account_number,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer " . $token,
				"Content-Type: application/json",
				//"Origin: mri.com", //example.com
				"X-BCA-Key:" . $apikey,
				"X-BCA-Timestamp:" . $waktu,
				"X-BCA-Signature:" . $signfinal
			),
		));
		curl_setopt($curl, CURLINFO_HEADER_OUT, true); //info header
		$response = curl_exec($curl);
		$info = curl_getinfo($curl);
		$err = curl_error($curl);
		curl_close($curl);
		print_r($info['request_header']);
		// print_r($data);
		print_r($response);

		// var_dump('here');
		// die;

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$result = json_decode($response, TRUE);
			$saldo = $result['AccountDetailDataSuccess'][0]['AvailableBalance'];

			if ($saldo) {
				$data = array(
					"saldo" => $saldo,
					"rekening" => $account_number,
					"datetime" => $waktu,
				);
			}

			$this->CI->db->insert('saldo', $data);
		}
	}
	//funtion fund transfer (sesama bca)
	public function getTransfer($decode, $norek, $jumlah, $transfer_req_id, $berita_transfer, $apikey, $saldo_awal, $api_secret, $corporate_id, $account_number)
	{


		//$apikey = $this->settings['api_key'];
		// $secretkey = $this->settings['api_secret'];
		$main_url = $this->settings['main_url'];
		// $corporate_id = $this->settings['corporate_id'];
		// $account_number = $this->settings['account_number'];
		$token = $decode;
		date_default_timezone_set("Asia/Jakarta");
		$waktu = date('Y-m-d\TH:i:s.000P');
		$transactiondate = date('Y-m-d');
		$referenceiddate = date('Ymd');
		$referenceid = $referenceiddate . '/' . $transfer_req_id;
		$saldo_akhir = $saldo_awal - $jumlah;

		$var = array(
			'Amount' => number_format((float)$jumlah, 2, '.', ''),
			'BeneficiaryAccountNumber' => strtolower(str_replace(' ', '', $norek)),
			'CorporateID' => strtolower(str_replace(' ', '', $corporate_id)),
			'CurrencyCode' => 'idr',
			'ReferenceID' => strtolower(str_replace(' ', '', $referenceid)),
			'Remark1' => strtolower(str_replace(' ', '', 'MRI Transfer')),
			'Remark2' => strtolower(str_replace(' ', '', $berita_transfer)),
			'SourceAccountNumber' => strtolower(str_replace(' ', '', $account_number)),
			'TransactionDate' => strtolower(str_replace(' ', '', $transactiondate)),
			'TransactionID' => strtolower(str_replace(',', '', $transfer_req_id)),

		);
		$data = json_encode($var, JSON_UNESCAPED_SLASHES);
		$signature = 'POST:' . "/banking/corporates/transfers" . ":" . $token . ":" . hash('sha256', $data) . ":" . $waktu;
		$signfinal = hash_hmac('sha256', $signature, $api_secret);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $main_url . "/banking/corporates/transfers",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer " . $token,
				"Content-Type: application/json",
				//"Origin: mri.com", //example.com
				"X-BCA-Key:" . $apikey,
				"X-BCA-Timestamp:" . $waktu,
				"X-BCA-Signature:" . $signfinal
			),

		));

		var_dump("POST " . $main_url . "/banking/corporates/transfers");
		echo '<br>';
		var_dump("Authorization: Bearer " . $token);
		echo '<br>';
		var_dump("Content-Type: application/json");
		echo '<br>';
		var_dump("X-BCA-Key:" . $apikey);
		echo '<br>';
		var_dump("X-BCA-Timestamp:" . $waktu);
		echo '<br>';
		var_dump("X-BCA-Signature:" . $signfinal);
		echo '<br>';
		var_dump($data);
		echo '<br>';
		var_dump('Response:');
		echo '<br>';
		// die;


		$response = curl_exec($curl);
		print_r($response);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$result = json_decode($response, TRUE);
			$TransactionID = $result['TransactionID'];
			/*print_r($result);*/
			if ($TransactionID > '0') {
				$TransactionID = $result['TransactionID'];
				$Status = $result['Status'];
				$this->CI->db->set('hasil_transfer', '2');
				$this->CI->db->set('ket_transfer', $Status);
				$this->CI->db->set('saldo_awal', $saldo_awal);
				$this->CI->db->set('saldo_akhir', $saldo_akhir);
				$this->CI->db->where('transfer_req_id', $TransactionID);
				$this->CI->db->update('data_transfer');

				$db_bridge = $this->CI->load->database('db2', TRUE);
				$db_bridge->set('hasil_transfer', '2');
				$db_bridge->set('ket_transfer', $Status);
				$db_bridge->where('transfer_req_id', $TransactionID);
				$db_bridge->update('data_transfer');
			} else {
				$Status = $result['ErrorMessage']['Indonesian'];
				$this->CI->db->set('ket_transfer', $Status);
				$this->CI->db->set('hasil_transfer', '3');
				$this->CI->db->where('transfer_req_id', $transfer_req_id);
				$this->CI->db->update('data_transfer');

				$db_bridge = $this->CI->load->database('db2', TRUE);
				$db_bridge->set('hasil_transfer', '3');
				$db_bridge->set('ket_transfer', $Status);
				$db_bridge->where('transfer_req_id', $transfer_req_id);
				$db_bridge->update('data_transfer');
			}
		}
	}

	//funtion fund transfer (antar bank)
	public function getDomTransfer($decode, $norek, $jumlah, $transfer_req_id, $pemilik_rekening, $kode_bank, $berita_transfer, $apikey, $saldo_awal, $biaya, $api_secret, $corporate_id, $account_number, $channelid, $credentialid, $email_pemilik_rekening)
	{
		//$apikey = $this->settings['api_key'];
		// $secretkey = $this->settings['api_secret'];
		$main_url = $this->settings['main_url'];
		// $corporate_id = $this->settings['corporate_id'];
		// $account_number = $this->settings['account_number'];
		// $channelid = $this->settings['channelid'];
		// $credentialid = $this->settings['credentialid'];
		$token = $decode;
		date_default_timezone_set("Asia/Jakarta");
		$waktu = date('Y-m-d\TH:i:s.000P');
		$transactiondate = date('Y-m-d');
		$referenceiddate = date('Ymd');
		$referenceid = $referenceiddate . '/' . $transfer_req_id;
		$saldo_akhir = $saldo_awal - $jumlah - $biaya;

		$var = array(
			'transaction_id' => str_replace(' ', '', $transfer_req_id),
			'transaction_date' => str_replace(' ', '', $transactiondate),
			'source_account_number' => str_replace(' ', '', $account_number), // ex 0201245680
			'beneficiary_account_number' => str_replace(' ', '', $norek), //Account number to be credited (Destination) ex 0201245501
			'beneficiary_bank_code' => str_replace(' ', '', $kode_bank), //Bank Code of account to be credited (destination) ex BRONINJA
			'beneficiary_name' => strtolower(str_replace(' ', '', $pemilik_rekening)), //Account name to be credited (destination)
			'amount' => number_format((float)$jumlah, 2, '.', ''),
			'transfer_type' => 'LLG', //LLG or RTG
			'beneficiary_cust_type' => str_replace(' ', '', '1'), //1 = Personal 2 = Corporate 3 = Government
			'beneficiary_cust_residence' => str_replace(' ', '', '1'), //1 = Resident 2 = Non Resident
			'currency_code' => 'IDR',
			'remark1' => strtolower(str_replace(' ', '', 'MRI Transfer')),
			'remark2' => strtolower(str_replace(' ', '', $berita_transfer)),
			'beneficiary_email' => $email_pemilik_rekening
			// 'CorporateID' => str_replace(' ', '', 'BCAAPI2016'),
			// 'ReferenceID' => strtolower(str_replace(' ', '', $referenceid)),
		);

		// $var = array(
		// 	'Amount' => number_format((float)$jumlah, 2, '.', ''),
		// 	'BeneficiaryAccountNumber' => str_replace(' ', '', $norek), //Account number to be credited (Destination) ex 0201245501
		// 	'BeneficiaryBankCode' => str_replace(' ', '', $kode_bank), //Bank Code of account to be credited (destination) ex BRONINJA
		// 	'BeneficiaryCustResidence' => str_replace(' ', '', '1'), //1 = Resident 2 = Non Resident
		// 	'BeneficiaryCustType' => str_replace(' ', '', '1'), //1 = Personal 2 = Corporate 3 = Government
		// 	'BeneficiaryName' => strtolower(str_replace(' ', '', $pemilik_rekening)), //Account name to be credited (destination)
		// 	// 'CorporateID' => str_replace(' ', '', 'BCAAPI2016'),
		// 	'CurrencyCode' => 'IDR',
		// 	'ReferenceID' => strtolower(str_replace(' ', '', $referenceid)),
		// 	'Remark1' => strtolower(str_replace(' ', '', 'MRI Transfer')),
		// 	'Remark2' => strtolower(str_replace(' ', '', $berita_transfer)),
		// 	'SourceAccountNumber' => str_replace(' ', '', $account_number), // ex 0201245680
		// 	'TransactionDate' => str_replace(' ', '', $transactiondate),
		// 	'TransactionID' => str_replace(' ', '', $transfer_req_id),
		// 	'TransferType' => 'LLG', //LLG or RTG
		// );

		$data = json_encode($var, JSON_UNESCAPED_SLASHES);
		$signature = 'POST:' . "/banking/corporates/transfers/v2/domestic" . ":" . $token . ":" . hash('sha256', $data) . ":" . $waktu;
		$signfinal = hash_hmac('sha256', $signature, $api_secret);

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $main_url . "/banking/corporates/transfers/v2/domestic",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer " . $token,
				"Content-Type: application/json",
				//"Origin: mri.com", //example.com
				"X-BCA-Key:" . $apikey,
				"X-BCA-Timestamp:" . $waktu,
				"X-BCA-Signature:" . $signfinal,
				"channel-id: " . $channelid,
				"credential-id: " . $credentialid
			),

		));
		var_dump("POST " . $main_url . "/banking/corporates/transfers/v2/domestic");
		echo '<br>';
		var_dump("Authorization: Bearer " . $token);
		echo '<br>';
		var_dump("Content-Type: application/json");
		echo '<br>';
		var_dump("X-BCA-Key:" . $apikey);
		echo '<br>';
		var_dump("X-BCA-Timestamp:" . $waktu);
		echo '<br>';
		var_dump("X-BCA-Signature:" . $signfinal);
		echo '<br>';
		var_dump("channel-id: " . $channelid);
		echo '<br>';
		var_dump("credential-id: " . $credentialid);
		echo '<br>';
		var_dump($data);
		echo '<br>';
		var_dump('Response:');
		echo '<br>';
		// die;

		$response = curl_exec($curl);
		print_r($response);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$result = json_decode($response, TRUE);
			var_dump($result);
			// die;
			$TransactionID = $result['transaction_id'];
			/*print_r($result);*/
			if ($TransactionID > '0') {
				$TransactionID = $result['transaction_id'];
				$Status = $result['filler_ppu_no'];
				$this->CI->db->set('hasil_transfer', '2');
				$this->CI->db->set('ket_transfer', $Status);
				$this->CI->db->set('saldo_awal', $saldo_awal);
				$this->CI->db->set('saldo_akhir', $saldo_akhir);
				$this->CI->db->where('transfer_req_id', $TransactionID);
				$this->CI->db->update('data_transfer');

				$db_bridge = $this->CI->load->database('db2', TRUE);
				$db_bridge->set('hasil_transfer', '2');
				$db_bridge->set('ket_transfer', $Status);
				$db_bridge->where('transfer_req_id', $TransactionID);
				$db_bridge->update('data_transfer');

				return 1;
			} else {
				$Status = $result['ErrorMessage']['Indonesian'];
				$this->CI->db->set('ket_transfer', $Status);
				$this->CI->db->set('hasil_transfer', '3');
				$this->CI->db->where('transfer_req_id', $transfer_req_id);
				$this->CI->db->update('data_transfer');

				$db_bridge = $this->CI->load->database('db2', TRUE);
				$db_bridge->set('hasil_transfer', '3');
				$db_bridge->set('ket_transfer', $Status);
				$db_bridge->where('transfer_req_id', $transfer_req_id);
				$db_bridge->update('data_transfer');

				return 0;
			}
		}
	}
}
