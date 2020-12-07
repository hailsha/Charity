<?php
	@session_start();
	function cleanupMobilePhone($phone_num, $c, $country_code)
	{
		$default_country_code  = '251';
		$phone_num = preg_replace("/\([0-9]+?\)/", "", $phone_num);
		$phone_num = preg_replace("/[^0-9]/", "", $phone_num);
		$phone_num = ltrim($phone_num, '0');
		$pfx = $default_country_code;
		if ( !preg_match('/^'.$pfx.'/', $phone_num)  ) {
			$phone_num = $pfx.$phone_num;
		}
		return "+".$phone_num;
	}
    function getToken($method, $url, $data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        $result = curl_exec($curl);
        
        curl_close($curl);
        return $result;
    }
    function generateToken($crede){
        $url = "https://api.hellocash.net/authenticate";
        $get_api = getToken('POST', $url, json_encode($crede));
        $token_response = json_decode($get_api, true);
        if(isset($token_response['token'])) {
            $_SESSION['token'] = $token_response['token'];
        }
        return $token_response['token']; 
    }
    function sendRequest($method, $url, $data,$token){
        $curl = curl_init();
        switch ($method){
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "DELETE":
                break;
            default:
                break;
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization:Bearer '.$token
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    function checkBalance($token,$amount){
        $transaction_datas = array();
        $url = "https://api.hellocash.net/accounts";
        $make_transaction = sendRequest('GET', $url, json_encode($transaction_datas),$token);
        $trans_response = json_decode($make_transaction, true);
        if(isset($trans_response[0]['id'])) {
            if($trans_response[0]['balance'] < $amount)
                return false;
            else
                return true;
        } 
        else 
        {
            return false;
        }
    }
    function createInvoice($transaction_data,$token,$full_name,$donation_type,$file_name)   
    {

        $url = "https://api.hellocash.net/invoices";
        $request_transaction = sendRequest('POST', $url, json_encode($transaction_data),$token);
        $request_response = json_decode($request_transaction, true);


        if(isset($request_response['id'])) {
            $array = array();
            $array = explode("==>", file_get_contents($file_name));
            $total = $array[6];
            file_put_contents($file_name, $request_response["id"]."==>".$request_response["code"]."==>".$request_response["status"]."==>".$request_response["from"]."==>".$request_response["fromname"]."==>".$request_response["amount"]."==>".$total);
            return true;
        } 
        else 
        {
            return false;
        }

    }
    function getTotal($file_name){
        $array = array();
        $array = explode("==>", file_get_contents(dirname(__FILE__) . "/" .$file_name));
        $total = floatval($array[6]);
        return $total;
    }
?>