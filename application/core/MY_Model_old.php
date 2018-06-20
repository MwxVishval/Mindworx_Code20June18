<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('Data', 'data');
        $this->load->library('session');
        $this->load->helper('url');
    }

    /*     * **************** Save data ************* */

    public function InsertData($table, $data, $insertId = FALSE) {
        $this->db->insert($table, $data);
        if ($insertId) {
            return $this->db->insert_id();
        } else {
            return $this->db->affected_rows();
        }
    }

    public function InsertPushNotification($table, $data, $task_id = NULL) {

        $this->db->delete($table, array('task_id' => $task_id));
//        echo $this->db->last_query();
//        die();
//        
//        
        $this->db->insert($table, $data);
        $insertId = FALSE;
        if ($insertId) {
            return $this->db->insert_id();
        } else {
            return $this->db->affected_rows();
        }
    }

    public function UpdateData($data, $id, $table) {
        $this->db->where('id', $id);
        $query = $this->db->update($table, $data);
        return $this->db->affected_rows();
    }
    
    public function taskUpdateData($data, $id, $table) {
        $this->db->where('task_name', $id);
        $query = $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    public function DeleteData($id, $table) {
        $this->db->delete($table, array('id' => $id));
        $this->db->last_query();
        return $this->db->affected_rows();
    }

    public function SelectWhere($id, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function SelectFSE($id, $table) {
        $this->db->select('id, ent_id ,branch_id, fse_device_os	, fse_device_id');
        $this->db->from($table);
        $this->db->where('fse_email', trim($id));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function getFse() {
        $table = QM_FSE_DETAILS;
        $this->db->select('id,fse_name,fse_status');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_FSE_DETAILS . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_FSE_DETAILS . '.fse_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
     public function closeCodeModel() {
        $this->db->select('close_code');
        $this->db->from(QM_CLOSE_CODE);
        //$this->db->where('dependent_value', $value);
        $query = $this->db->get();
        
        //echo $this->db->last_query();
        return $query->result_array();
    }

    public function getProject() {
        $table = QM_PROJECT;
        $this->db->select('id,proj_name,proj_status');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_PROJECT . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_PROJECT . '.proj_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getIncident() {
        $table = QM_INCIDENT;
        $this->db->select('id,incident_name,incident_status');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_INCIDENT . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_INCIDENT . '.incident_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCustomer() {
        $table = QM_CUSTOMER_DETAILS;
        $this->db->select('id,cus_name,cus_status');
        $this->db->from($table);
        $this->db->where(QM_CUSTOMER_DETAILS . '.cus_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getStatus() {
        $table = QM_STATUS_TYPE;
        $this->db->select('id,status_type');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            //  $this->db->where(QM_STATUS_TYPE . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_STATUS_TYPE . '.status_stat', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getSla() {
        $table = QM_SLA;
        $this->db->select('id,sla_name,sla_status');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_SLA . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_SLA . '.sla_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getBranch() {
        $table = QM_BRANCH;
        $this->db->select('id,branch_name,branch_status');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_BRANCH . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_BRANCH . '.branch_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getEntity() {
        $table = QM_ENTITY;
        $this->db->select('id,ent_name,status');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_ENTITY . '.id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_ENTITY . '.status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getTasktype() {
        $table = QM_TASK_TYPE;
        $this->db->select('id,task_type,task_type_status');
        $this->db->from($table);

        $this->db->where(QM_TASK_TYPE . '.task_type_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCallStatus() {
        $table = QM_CALL_STATUS_TYPE;
        $this->db->select('id,callstatus_type');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_CALL_STATUS_TYPE . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_CALL_STATUS_TYPE . '.callstatus_stat', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCallType() {
        $table = QM_CALL_TYPE;
        $this->db->select('id,calltype_type');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_CALL_TYPE . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_CALL_TYPE . '.calltype_stat', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getPriority() {
        $table = QM_PRIORITY;
        $this->db->select('id,priority_type');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
          //  $this->db->where(QM_PRIORITY . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_PRIORITY . '.priority_stat', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function productline() {
        $table = QM_PRODUCT_LINE;
        $this->db->select('value');
        $this->db->from($table);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getTask() {
        $table = QM_TASK;
        $this->db->select('id,task_name,task_status');
        $this->db->from($table);
        $this->db->where(QM_TASK . '.task_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getWebUserType($id = NULL) {
        if ($id != NULL) {
            $table = QM_WEB_USER_TYPE;
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where(QM_WEB_USER_TYPE . '.id', $id);
            $query = $this->db->get();
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function getCurrentTime() {
        $query = $this->db->query('SELECT NOW() as date_time');
        $res = $query->row();
        return $res->date_time;
    }

    public function getGoogleStatustypes($id) {
        $this->db->select('status_type');
        $this->db->from(QM_STATUS_TYPE);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getFseDeviceID($id) {
        $this->db->select('fse_device_id');
        $this->db->from(QM_FSE_DETAILS);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function serviceNowTaskUpdate($data) {
        
        $this->db->select('*');
        $this->db->from(QM_TASK);
        $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id = ' . QM_STATUS_TYPE . '.id', 'LEFT');
        $this->db->join(QM_PRIORITY, QM_TASK . '.priority = ' . QM_PRIORITY . '.id', 'LEFT');
        $this->db->join(QM_CALL_TYPE, QM_TASK . '.call_type = ' . QM_CALL_TYPE . '.id', 'LEFT');
        $this->db->join(QM_CALL_STATUS_TYPE, QM_TASK . '.call_status = ' . QM_CALL_STATUS_TYPE . '.id', 'LEFT');
        $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id', 'LEFT');
        $this->db->where(QM_TASK.'.id', trim($data));
        $query = $this->db->get();
        return $result = $query->row();
    }

    public function getZoneName() {
        $table = QM_ZONE;
        $this->db->select('zone_id,zone_name');
        $this->db->from($table);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function webLogoLoad($id) {
        $this->db->select('entity_logo');
        $this->db->from(QM_ENTITY);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->entity_logo;
        } else {
            return FALSE;
        }
    }

    public function branchToEntity($id = NULL) {
        $this->db->select('ent_id');
        $this->db->from(QM_BRANCH);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->ent_id;
        } else {
            return FALSE;
        }
    }
    
    public function serviceNowAndroidPushNotification($arraydata = NULL) {
        
        $message = "Task Description " . $task_description . '. Task Status ' . $status_types . '. Task Address ' . $task_address;
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
            'body' => "Task Description " . $insert['task_description'] . '. Task Status ' . $status_types . '. Task Address ' . $insert['task_address'],
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

//        echo $result;
//        exit();
    
    }
    
     function send_android_push($fseid = NULL, $insert = NULL, $taskId = NULL) {
         
                  //exit();
         
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
        $registrationIds = $this->getFseDeviceID($fseid);

        //print_r($registrationIds->fse_device_id);


        if (isset($registrationIds->fse_device_id)) {
            $registrationIdss = $registrationIds->fse_device_id;
            if ($registrationIdss == "") {
                
            }
        } else {
            return;
        }
        if (isset($insert['status_id'])) {
            $status_id = $insert['status_id'];
        } else {
            $status_id = 1;
        }
        $device_token = $registrationIds->fse_device_id;
        $status_types = $this->getGoogleStatustypes($status_id);
        if (isset($status_types->status_type)) {
            $status_types = $status_types->status_type;
        } else {
            $status_types = "Assigned";
        }
        if (isset($insert['taskDescription'])) {
            $task_description = $insert['taskDescription'];
        } else {
            $task_description = "New Task";
        }
        if (isset($insert['taskLocationAddress'])) {
            $task_address = $insert['taskLocationAddress'];
        } else {
            $task_address = "New Task";
        }
        if (isset($insert['taskTitle'])) {
            $task_name = $insert['taskTitle'];
        } else {
            $task_name = "New Task";
        }


        $registrationIds = $registrationIds->fse_device_id;
        $status_types = $this->getGoogleStatustypes($status_id);
        $status_types = $status_types->status_type;
        $message = "Task Description " . $task_description . '. Task Status ' . $status_types . '. Task Address ' . $task_address;

        $table = QM_MOBILE_NOTIFICATION;
        $data = array('task_id' => $taskId,
            'fse_id' => $fseid,
            'message' => $message,
            'title' => $task_name,
            'status_types' => $status_types,
            'status_id' => $status_id
        );

        $this->InsertPushNotification($table, $data, $taskId);

        $msg = array
            (
            'body' => "Task Description " . $task_description . '. Task Status ' . $status_types . '. Task Address ' . $task_address,
            'title' => $task_name,
            'taskId' => $taskId,
            'status_types' => $status_types,
            'status_id' => $status_types,
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

//        echo $result;
//        exit();
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
        $registrationIds = ($this->getFseDeviceID($fseid));
        if (!isset($registrationIds->fse_device_id)) {
            return;
        }
        if (isset($insert['status_id'])) {
            $status_id = $insert['status_id'];
        } else {
            $status_id = 1;
        }
        $device_token = $registrationIds->fse_device_id;
        $status_types = $this->getGoogleStatustypes($status_id);
        if (isset($status_types->status_type)) {
            $status_types = $status_types->status_type;
        } else {
            $status_types = "Assigned";
        }
        if (isset($insert['task_description'])) {
            $task_description = $insert['taskDescription'];
        } else {
            $task_description = "New Task";
        }
        if (isset($insert['taskLocationAddress'])) {
            $task_address = $insert['taskLocationAddress'];
        } else {
            $task_address = "New Task";
        }
        if (isset($insert['taskTitle'])) {
            $task_name = $insert['taskTitle'];
        } else {
            $task_name = "New Task";
        }
        $message = "Task Description " . $task_description . '. Task Status ' . $status_types . '. Task Address ' . $task_address;
        $table = QM_MOBILE_NOTIFICATION;
        $data = array('task_id' => $taskId,
            'fse_id' => $fseid,
            'message' => $message,
            'title' => $task_name,
            'status_types' => $status_types,
            'status_id' => $status_id
        );
        $this->InsertPushNotification($table, $data, $taskId);
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

?>