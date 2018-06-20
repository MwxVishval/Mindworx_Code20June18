<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_helper {

  
    
    public function ios_push_notification() {
        
    }
    
       
    function send_ios_push_test() {
//    $dirName = dirname(__FILE__);
//        echo readfile($dirName .'/Certificates.pem');
//        exit;
    // Put your device token here (without spaces):
    $device_token = 'c190a8eaec6a865b6d7b8e0f8327de20f471b5601aada83f92edeb4158077ff5';    
    $message = "test Qmobility";
    $hurdle_id="1";
    $reminder_id = "1";
    $is_viewed = "1";
    // Put your private key's passphrase here:
    $passphrase = 'cgvak123';    

    ////////////////////////////////////////////////////////////////////////////////
    $dirName = dirname(__FILE__);
    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', $dirName .'/Certificates.pem');
    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

    // Open a connection to the APNS server
    
    $fp = stream_socket_client(
        'ssl://gateway.sandbox.push.apple.com:2195', $err,
        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
     
//    $fp = stream_socket_client(
//        'ssl://gateway.push.apple.com:2195', $err,
//        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

    if (!$fp)
        exit("Failed to connect: $err $errstr" . PHP_EOL);

    //echo 'Connected to APNS' . PHP_EOL;

    // Create the payload body
    /*$body['aps'] = array(
        'alert' => $message,
        'sound' => 'default'
        );*/

    $body = array(
        'aps' => array(
            'alert' => $message,
            'sound' => 'default'
        ),
        'task_id' => $hurdle_id,
        'is_viewed' => $is_viewed
    );

    // Encode the payload as JSON
    $payload = json_encode($body);

    // Build the binary notification
    $msg = chr(0) . pack('n', 32) . pack('H*', $device_token) . pack('n', strlen($payload)) . $payload;

    // Send it to the server
    $result = fwrite($fp, $msg, strlen($msg));
    
    
 //   print_r($payload);

//    if (!$result)
//        echo 'Message not delivered' . PHP_EOL;
//    else
//        echo 'Message successfully delivered' . PHP_EOL;

    // Close the connection to the server
    fclose($fp);
}

function send_ios_push($fseid = NULL,$insert = NULL, $taskId = NULL) {
    
    $registrationIds = ($this->MY_Model->getFseDeviceID($fseid));
    $registrationIds = $registrationIds->fse_device_id;
    $status_types =  $this->MY_Model->getGoogleStatustypes($insert['status_id']);
    $status_types = $status_types->status_type;
    
    $message = "Task Description ".$insert['task_description'].'. Task Status '.$status_types.'. Task Address '.$insert['task_address'];
        
    // Put your private key's passphrase here:
    $passphrase = 'cgvak123';    

    ////////////////////////////////////////////////////////////////////////////////
    $dirName = dirname(__FILE__);
    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', $dirName .'/Certificates.pem');
    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

    // Open a connection to the APNS server
    
    $fp = stream_socket_client(
        'ssl://gateway.sandbox.push.apple.com:2195', $err,
        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
     
//    $fp = stream_socket_client(
//        'ssl://gateway.push.apple.com:2195', $err,
//        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

    if (!$fp)
        exit("Failed to connect: $err $errstr" . PHP_EOL);

    //echo 'Connected to APNS' . PHP_EOL;

    // Create the payload body
    /*$body['aps'] = array(
        'alert' => $message,
        'sound' => 'default'
        );*/

    $body = array(
        'aps' => array(
            'alert' => $message,
            'sound' => 'default'
        ),
        'status_types' => $status_types,
        'status_id' => $insert['status_id'],
    );

    // Encode the payload as JSON
    $payload = json_encode($body);

    // Build the binary notification
    $msg = chr(0) . pack('n', 32) . pack('H*', $device_token) . pack('n', strlen($payload)) . $payload;

    // Send it to the server
    $result = fwrite($fp, $msg, strlen($msg));
    
    
 //   print_r($payload);

//    if (!$result)
//        echo 'Message not delivered' . PHP_EOL;
//    else
//        echo 'Message successfully delivered' . PHP_EOL;

    // Close the connection to the server
    fclose($fp);
}


}
