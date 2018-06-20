<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('Data', 'data');
        $this->load->library('session');
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->load->library('Permission', 'permission');
        $this->load->model("MY_Model");
        $valid = $this->session->userdata('session_data');
        if (isset($valid)) {
            if ($valid->user_id == NULL && $valid->user_type == NULL) {
                redirect('/', 'refresh');
            }
        } else {
            redirect('/', 'refresh');
        }

//        echo "<pre>"; 
//         print_r($this->session->userdata('session_data'));
//        echo "</pre>"; 
    }

    public function userPermissionCheck($pageId = NULL, $optionId = NULL) {
        if ($pageId != NULL && $optionId != NULL) {
            $valid = $this->session->userdata('session_data');
            $arrays = $this->MY_Model->getWebUserType($valid->user_type);
            $checkvalue = $pageId . "#" . $optionId;
            if (in_array($checkvalue, json_decode($arrays->permission_code))) {
                
            } else {
                redirect('accessDenied', 'refresh');
            }
//            echo "<pre>";
//            print_r($arrays);
//            print_r(json_decode($arrays->permission_code));
//            echo "</pre>";
        } else {
            //redirect('/','refresh');
        }
    }
    
      public function PermissionCheck($pageId = NULL, $optionId = NULL) {
        if ($pageId != NULL && $optionId != NULL) {
            $valid = $this->session->userdata('session_data');
            $arrays = $this->MY_Model->getWebUserType($valid->user_type);
            $checkvalue = $pageId . "#" . $optionId;
            if (in_array($checkvalue, json_decode($arrays->permission_code))) {
                return true;
            } else {
                return false;
            }
//            echo "<pre>";
//            print_r($arrays);
//            print_r(json_decode($arrays->permission_code));
//            echo "</pre>";
        } else {
            //redirect('/','refresh');
        }
    }

    public function is_admin_check() {
        $is_admin = $this->session->userdata('session_data')->is_admin;
        if ($is_admin == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function entity_admin_check() {
        $entity_admin = $this->session->userdata('session_data')->entity_admin;
        $user_id = $this->session->userdata('session_data')->user_id;
        if ($entity_admin == $user_id) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function profileImageWeb() {
        $ent_id = $this->session->userdata('session_data')->ent_id;
        if ($ent_id != NULL && $ent_id != 0) {
            return $this->MY_Model->webLogoLoad($ent_id);
        }
    }

    public function userPermissionMenu($pageId = NULL, $optionId = NULL) {
        if ($pageId != NULL && $optionId != NULL) {
            $valid = $this->session->userdata('session_data');
            $arrays = $this->MY_Model->getWebUserType($valid->user_type);
            $checkvalue = $pageId . "#" . $optionId;
            if (in_array($checkvalue, json_decode($arrays->permission_code))) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            //redirect('/','refresh');
        }
    }
    
    public function userPermissionMenus($pageId = NULL, $optionId = NULL) {
        
                return FALSE;
            
        
    }
    
    
    
    public function gettasktypeHeader(){
        return $data =  $this->MY_Model->gettasktypeHeaderModel();
      echo "<pre>";
      print_r($data);
      echo "</pre>";
      
      
    }
            
    

    function send_android_push($fseid = NULL, $insert = NULL, $taskId = NULL) {
       // echo "test";
        if ($fseid == NULL) {
            // return;
        }
        if ($insert == NULL) {
            // return;
        }
        if ($taskId == NULL) {
            //return;
        }
        $registrationIds = $this->MY_Model->getFseDeviceID($fseid);
             
        if (isset($insert['status_id'])) {
            $status_id = $insert['status_id'];
        } else {
            $status_id = 1;
        }
        $device_token = $registrationIds->fse_device_id;
        $status_types = $this->MY_Model->getGoogleStatustypes($status_id);
        if (isset($status_types->status_type)) {
            $status_types = $status_types->status_type;
        } else {
            $status_types = "Assgin";
        }
        if (isset($insert['task_address'])) {
            $task_address = $insert['task_address'];
        } else {
            $task_address = "";
        }
        if (isset($insert['task_name'])) {
            $task_name = $insert['task_name'];
        } else {
            $task_name = "New Task";
        }
        $registrationIds = $registrationIds->fse_device_id;
        $status_types = $this->MY_Model->getGoogleStatustypes($status_id);
        $status_types = $status_types->status_type;
        $message = "Task Name " . $task_name . '. Task Status ' . $status_types . '. Task Address ' . $task_address;

        $table = QM_MOBILE_NOTIFICATION;
        $data = array('task_id' => $taskId,
            'fse_id' => $fseid,
            'message' => $message,
            'title' => $task_name,
            'status_types' => $status_types,
            'status_id' => $status_id
        );

        $this->MY_Model->InsertPushNotification($table, $data, $taskId);

        $msg = array
            (
            'body' => "Task Name " . $task_name . '. Task Status ' . $status_types . '. Task Address ' . $task_address,
            'title' => $insert['task_name'],
            'taskId' => $taskId,
            'status_types' => $status_types,
            'status_id' => $insert['status_id'],
            'icon' => 'myicon', /* Default Icon */
            'sound' => 'mySound'/* Default sound */
        );

        $fields = array
            (
            'to' => $registrationIds,
            'notification' => $msg
        );


        $headers = array
            (
            'Authorization: key=' . ANDROID_API_ACCESS_KEY_FOR_PUSH_NOTIFICATION,
            'Content-Type: application/json'
        );
         
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
    }

    //Android push notification
    public function send_ios_push($fseid = NULL, $insert = NULL, $taskId = NULL) {

        if ($fseid == NULL) {
            return;
        }
        if ($insert == NULL) {
            return;
        }
        if ($taskId == NULL) {
            return;
        }
        $registrationIds = ($this->MY_Model->getFseDeviceID($fseid));
        if (!isset($registrationIds->fse_device_id)) {
            return;
        }
        if (isset($insert['status_id'])) {
            $status_id = $insert['status_id'];
        } else {
            $status_id = 1;
        }
        $device_token = $registrationIds->fse_device_id;
        $status_types = $this->MY_Model->getGoogleStatustypes($status_id);
        if (isset($status_types->status_type)) {
            $status_types = $status_types->status_type;
        } else {
            $status_types = "Assgin";
        }
        if (isset($insert['task_address'])) {
            $task_address = $insert['task_description'];
        } else {
            $task_address = "New Task";
        }
        if (isset($insert['task_name'])) {
            $task_name = $insert['task_name'];
        } else {
            $task_name = "New Task";
        }
        $message = "Task Name " . $task_name . '. Task Status ' . $status_types . '. Task Address ' . $task_address;
        $table = QM_MOBILE_NOTIFICATION;
        $data = array('task_id' => $taskId,
            'fse_id' => $fseid,
            'message' => $message,
            'title' => $task_name,
            'status_types' => $status_types,
            'status_id' => $status_id
        );
        $this->MY_Model->InsertPushNotification($table, $data, $taskId);
        // $this->MY_Model->InsertData($table, $data);
        // Put your private key's passphrase here:
        $passphrase = 'cgvak123';

        ////////////////////////////////////////////////////////////////////////////////
        $dirName = dirname(__FILE__);
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $dirName . '/Certificates.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        // Open a connection to the APNS server

        $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

//    $fp = stream_socket_client(
//        'ssl://gateway.push.apple.com:2195', $err,
//        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

        //echo 'Connected to APNS' . PHP_EOL;
        // Create the payload body
        /* $body['aps'] = array(
          'alert' => $message,
          'sound' => 'default'
          ); */

        $body = array(
            'aps' => array(
                'alert' => $message,
                'sound' => 'default'
            ),
            'status_types' => $status_types,
            'status_id' => $status_id,
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
