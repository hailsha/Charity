<?php
    $request_method = $_SERVER["REQUEST_METHOD"];
    $today = date("Y-m-d");
    $timestamp = date("Y-m-d H:i:s");
    $file_name = dirname(__FILE__) . "/" . $request_method . "_" . "WebHookEvent_" . $today . ".log";
    $file_namewebhook = dirname(__FILE__) . "/" . $request_method . "_" . "webhookresponse_" . $today . ".log";

    $data = array();
    $data["time_stamp"] = $timestamp;
    
    if ($request_method === "GET") {
      foreach ($_GET as $key => $value) {
        $line = $key . " : " . $value."<br>";
        $data[$key] = $value;
      }
      $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
      echo $json;
      file_put_contents($file_name, PHP_EOL . serialize($data), FILE_APPEND);
      header(':', true, 200);
      header('X-PHP-Response-Code: 200', true, 200);
    } 
    elseif ($request_method === "POST") {
      $incoming = explode("=", file_get_contents("php://input"));
      file_put_contents($file_namewebhook, print_r($incoming, true));
      foreach ($incoming as $key => $value) {
        $line = $key . " : " . $value;
        $data[$key] = $value;
        $arr = json_decode($value,true);
        $status = $arr["status"];
        if($status == "PROCESSED"){
            $invoiceid = $arr["invoiceid"];
            $amount = $arr["amount"];
            $names = array("trees_WebHookEvent.log", "children_WebHookEvent.log","students_WebHookEvent.log");
            $f_name = "";
            $array = array();
            foreach ($names as $name) {
                $f_name = dirname(__FILE__) . "/". $name;
                $array = explode("==>", file_get_contents($f_name));
                if($array[0] == $invoiceid){
                    file_put_contents($file_name, $f_name."==>".$invoiceid."==>".$status."==>".$amount.PHP_EOL, FILE_APPEND);
                    break;
                }
            }
            if($array[2]=="PENDING"){
                $array[2] = $status;
                $total = floatval($amount)+floatval($array[6]);
                file_put_contents($f_name, $array[0]."==>".$array[1]."==>".$status."==>".$array[3]."==>".$array[4]."==>".$array[5]."==>".$total.PHP_EOL);
            }
        }   
      }
      header(':', true, 200);
      header('X-PHP-Response-Code: 200', true, 200);
    } 
    elseif ($request_method === "PUT") {
      $incoming = explode("=", file_get_contents("php://input"));
      foreach ($incoming as $key => $value) {
        $line = $key . " : " . $value;
        $data[$key] = $value;
      }
      $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
      echo $json;
      file_put_contents($file_name, PHP_EOL . serialize($data), FILE_APPEND);
      header(':', true, 200);
      header('X-PHP-Response-Code: 200', true, 200);
    } 
    else {
      $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
      echo $json;
      file_put_contents($file_name, PHP_EOL . serialize($data), FILE_APPEND);
      header(':', true, 404);
      header('X-PHP-Response-Code: 404', true, 404);
    }
?>
