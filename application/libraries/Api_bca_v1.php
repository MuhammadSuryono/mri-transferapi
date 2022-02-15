<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);


class Api_Bca{

	var $CI;
    public function __construct($params = array())
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->config->item('base_url');
        $this->CI->load->database();


    }
	protected $settings = array(

	 	'main_url' => 'https://devapi.klikbca.com:443', // Change When Your Apps is Live
		'client_id' => 'b095ac9d-2d21-42a3-a70c-4781f4570704', // Fill With Your Client ID
		'client_secret' => 'bedd1f8d-3bd6-4d4a-8cb4-e61db41691c9', // Fill With Your Client Secret ID
		//'api_key' => 'f65b8e4b-1ae0-495e-8410-8e4c174bfb94', // Fill With Your API Key ex f65b8e4b-1ae0-495e-8410-8e4c174bfb94
		'api_secret' => '5e636b16-df7f-4a53-afbe-497e6fe07edc', // Fill With Your API Secret Key
		'corporate_id' => 'h2hauto008', // Fill With Your Corporate ID. BCAAPI2016 is Sandbox ID
		'account_number' => '0201245680', // Fill With Your Account Number. 0201245680 is Sandbox Account
		'channelid' => '95051', //Channel Identification Number (Ex: 95051 for KlikBCA Bisnis)
		'credentialid' => 'BCAAPI' //Your Channel Identity (ex: Your KlikBCA Bisnis CorporateID)

	 	);



	//mendapatkan accsess token
	public function getToken(){
		$client_id = $this->settings['client_id'];
        $client_secret = $this->settings['client_secret'];
        $main_url = $this->settings['main_url'];
		$encode = base64_encode($client_id.':'.$client_secret);

		$curl = curl_init();
		 			curl_setopt_array($curl, array(
		 			CURLOPT_URL => $main_url."/api/oauth/token",
		 			CURLOPT_RETURNTRANSFER => true,
		 			CURLOPT_ENCODING => "",
				 	CURLOPT_MAXREDIRS => 10,
				 	CURLOPT_TIMEOUT => 30,
				 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				 	CURLOPT_CUSTOMREQUEST => "POST",
				 	CURLOPT_POSTFIELDS => "grant_type=client_credentials&undefined=",
				 	CURLOPT_HTTPHEADER => array(
				 		"Authorization: Basic ".$encode,
				 		"Content-Type: application/x-www-form-urlencoded" ),
				 	));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) { echo "cURL Error #:" . $err;
		} else {
		$result=json_decode($response, TRUE);
		$decode = $result['access_token'];
		return $decode;
		}
	}
	//function infomation balance account
	public function getInfobal($decode, $apikey){
		//$apikey = $this->settings['api_key'];
		$secretkey = $this->settings['api_secret'];
		$main_url = $this->settings['main_url'];
		$corporate_id = $this->settings['corporate_id'];
		$account_number = $this->settings['account_number'];
		$token=$decode;
		date_default_timezone_set("Asia/Jakarta");
		$waktu=date('Y-m-d\TH:i:s.000P');
		$signature='GET:'."/banking/v3/corporates/".$corporate_id."/accounts/".$account_number.":".$token.":".hash('sha256', '').":".$waktu;
		$signfinal=hash_hmac('sha256', $signature, $secretkey);
		$curl = curl_init();
		curl_setopt_array($curl, array(
		 	CURLOPT_URL => $main_url."/banking/v3/corporates/".$corporate_id."/accounts/".$account_number,
		 	CURLOPT_RETURNTRANSFER => true,
		 	CURLOPT_ENCODING => "",
		 	CURLOPT_MAXREDIRS => 10,
		 	CURLOPT_TIMEOUT => 30,
		 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		 	CURLOPT_CUSTOMREQUEST => "GET",
		 	CURLOPT_HTTPHEADER => array(
		 		"Authorization: Bearer ".$token,
		 		"Content-Type: application/json",
		 		"Origin: mri.com", //example.com
		 		"X-BCA-Key:".$apikey,
		 		"X-BCA-Timestamp:".$waktu,
		 		"X-BCA-Signature:".$signfinal ),
		 	));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$result=json_decode($response,TRUE);
			$saldo = $result['AccountDetailDataSuccess'][0]['AvailableBalance'];

		   	$data = array(
		       "saldo" => $saldo,
		       "datetime" => $waktu,
			   );

			$this->CI->db->insert('saldo', $data);
		}
	}
	//funtion fund transfer (sesama bca)
	public function getTransfer($decode, $norek, $jumlah, $transfer_req_id, $berita_transfer, $apikey){


		//$apikey = $this->settings['api_key'];
		$secretkey = $this->settings['api_secret'];
		$main_url = $this->settings['main_url'];
		$corporate_id = $this->settings['corporate_id'];
		$account_number = $this->settings['account_number'];
		$token=$decode;
		date_default_timezone_set("Asia/Jakarta");
		$waktu=date('Y-m-d\TH:i:s.000P');
		$transactiondate=date('Y-m-d');
		$var = array(
				'Amount' => $jumlah,
				'BeneficiaryAccountNumber' => str_replace(' ', '', $norek),
				'CorporateID' => str_replace(' ', '', $corporate_id),
		        'CurrencyCode' => 'IDR',
		        'ReferenceID' => str_replace(' ', '', '12345/PO/2019'),
		        'Remark1' => str_replace(' ', '', 'MRI Transfer'),
		        'Remark2' => str_replace(' ', '', $berita_transfer),
		        'SourceAccountNumber' => str_replace(' ', '', $account_number),
		        'TransactionDate' => str_replace(' ', '', $transactiondate),
		        'TransactionID' => str_replace(' ', '', $transfer_req_id),

			);
		$data = json_encode($var, JSON_UNESCAPED_SLASHES);
		$signature='POST:'."/banking/corporates/transfers".":".$token.":".hash('sha256', $data).":".$waktu;
		$signfinal=hash_hmac('sha256', $signature, $secretkey);
		$curl = curl_init();
		curl_setopt_array($curl, array(
		 	CURLOPT_URL => $main_url."/banking/corporates/transfers",
		 	CURLOPT_RETURNTRANSFER => true,
		 	CURLOPT_ENCODING => "",
		 	CURLOPT_MAXREDIRS => 10,
		 	CURLOPT_TIMEOUT => 30,
		 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		 	CURLOPT_CUSTOMREQUEST => "POST",
		 	CURLOPT_POSTFIELDS => $data,
		 	CURLOPT_HTTPHEADER => array(
		 		"Authorization: Bearer ".$token,
		 		"Content-Type: application/json",
		 		"Origin: mri.com", //example.com
		 		"X-BCA-Key:".$apikey,
		 		"X-BCA-Timestamp:".$waktu,
		 		"X-BCA-Signature:".$signfinal ),

		 	));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$result=json_decode($response,TRUE);
			$TransactionID = $result['TransactionID'];
			/*print_r($result);*/
			if($TransactionID > '0'){
				$TransactionID = $result['TransactionID'];
				$Status = $result['Status'];
				$this->CI->db->set('hasil_transfer', '2');
			   	$this->CI->db->set('ket_transfer', $Status);
			   	$this->CI->db->where('transfer_req_id', $TransactionID);
			   	$this->CI->db->update('data_transfer');
			}else{
				$Status = $result['ErrorMessage']['Indonesian'];
			   	$this->CI->db->set('ket_transfer', $Status);
			   	$this->CI->db->set('transfer_type', '2');
			   	$this->CI->db->where('transfer_req_id', $transfer_req_id);
			   	$this->CI->db->update('data_transfer');
			}


		}
	}

	//funtion fund transfer (antar bank)
	public function getDomTransfer($decode, $norek, $jumlah, $transfer_req_id, $pemilik_rekening, $kode_bank, $berita_transfer, $apikey){
		//$apikey = $this->settings['api_key'];
		$secretkey = $this->settings['api_secret'];
		$main_url = $this->settings['main_url'];
		$corporate_id = $this->settings['corporate_id'];
		$account_number = $this->settings['account_number'];
		$channelid = $this->settings['channelid'];
		$credentialid = $this->settings['credentialid'];
		$token=$decode;
		date_default_timezone_set("Asia/Jakarta");
		$waktu=date('Y-m-d\TH:i:s.000P');
		$transactiondate='2018-05-03';
		$var = array(
				'Amount' => $jumlah,
				'BeneficiaryAccountNumber' => str_replace(' ', '', $norek),//Account number to be credited (Destination) ex 0201245501
				'BeneficiaryBankCode' => str_replace(' ', '', $kode_bank),//Bank Code of account to be credited (destination) ex BRONINJA
				'BeneficiaryCustResidence' => str_replace(' ', '', '1'),//1 = Resident 2 = Non Resident
				'BeneficiaryCustType' => str_replace(' ', '', '1'),//1 = Personal 2 = Corporate 3 = Government
				'BeneficiaryName' => str_replace(' ', '', $pemilik_rekening),//Account name to be credited (destination)
				// 'CorporateID' => str_replace(' ', '', 'BCAAPI2016'),
		        'CurrencyCode' => 'IDR',
		        'ReferenceID' => str_replace(' ', '', '12345/PO/2016'),
		        'Remark1' => str_replace(' ', '', 'MRI Transfer'),
		        'Remark2' => str_replace(' ', '', $berita_transfer),
		        'SourceAccountNumber' => str_replace(' ', '', '0201245680'),// ex 0201245680
		        'TransactionDate' => str_replace(' ', '', $transactiondate),
		        'TransactionID' => str_replace(' ', '', '00000001'),
		        'TransferType' => str_replace(' ', '', 'LLG'),//LLG or RTG

			);
		$data = json_encode($var, JSON_UNESCAPED_SLASHES);
		$signature='POST:'."/banking/corporates/transfers/domestic".":".$token.":".hash('sha256', $data).":".$waktu;
		$signfinal=hash_hmac('sha256', $signature, $secretkey);
		$curl = curl_init();
		curl_setopt_array($curl, array(
		 	CURLOPT_URL => $main_url."/banking/corporates/transfers/domestic",
		 	CURLOPT_RETURNTRANSFER => true,
		 	CURLOPT_ENCODING => "",
		 	CURLOPT_MAXREDIRS => 10,
		 	CURLOPT_TIMEOUT => 30,
		 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		 	CURLOPT_CUSTOMREQUEST => "POST",
		 	CURLOPT_POSTFIELDS => $data,
		 	CURLOPT_HTTPHEADER => array(
		 		"Authorization: Bearer ".$token,
		 		"Content-Type: application/json",
		 		"Origin: mri.com", //example.com
		 		"X-BCA-Key:".$apikey,
		 		"X-BCA-Timestamp:".$waktu,
		 		"X-BCA-Signature:".$signfinal,
			 	"ChannelID:".$channelid,
				"CredentialID:".$credentialid ),

		 	));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$result=json_decode($response,TRUE);
			$TransactionID = $result['TransactionID'];
			/*print_r($result);*/
			if($TransactionID > '0'){
				$TransactionID = $result['TransactionID'];
				$Status = $result['Status'];
				$this->CI->db->set('hasil_transfer', '2');
			   	$this->CI->db->set('ket_transfer', $Status);
			   	$this->CI->db->where('transfer_req_id', $TransactionID);
			   	$this->CI->db->update('data_transfer');
			}else{
				$Status = $result['ErrorMessage']['Indonesian'];
			   	$this->CI->db->set('ket_transfer', $Status);
			   	$this->CI->db->set('transfer_type', '2');
			   	$this->CI->db->where('transfer_req_id', $transfer_req_id);
			   	$this->CI->db->update('data_transfer');
			}





		}
	}




}
