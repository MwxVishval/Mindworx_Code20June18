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

    public function WebInsertPushNotification($task_id = NULL, $data = NULL, $status_id = NULL) {

        $this->db->delete(QM_NOTIFICATION, array('task_id' => $task_id));

        $data = array(
            'user_id' => $this->session->userdata('session_data')->user_id,
            'task_id' => $task_id,
            'description  ' => $data,
            'status_id' => $status_id
        );


        $this->db->insert(QM_NOTIFICATION, $data);
        $insertId = FALSE;
        if ($insertId) {
            return $this->db->insert_id();
        } else {
            return $this->db->affected_rows();
        }
    }

    public function InsertPushNotification($table, $data, $task_id = NULL) {

        $this->db->delete($table, array('task_id' => $task_id));
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

    public function Select_task_type($id, $table) {
        $this->db->select('task_type_id');
        $this->db->from($table);
        $this->db->where('id', $id);
        //$query = $this->db->get();
        return $this->db->get()->row()->task_type_id;
        //return $query->result_array();
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

    public function getTask_autocomplete($keyword) {
        $table = QM_TASK_TYPE;
        $this->db->select('id,task_type,task_type_status');
        $this->db->from($table);
        $this->db->where(QM_TASK_TYPE . '.task_type_status', 1);
        $this->db->like('task_type', $keyword, 'after');
        $query = $this->db->get();
        $result = $query->result_array();
        $data = array();
        //  print_r($result);
        if (!empty($result)) {
            $i = 0;
            foreach ($result as $r) {
                $data[$i]['value'] = $r['id'];
                $data[$i]['label'] = $r['task_type'];
                $i++;
            }
            echo json_encode($data);
        }
    }

    public function getFse_autocomplete($keyword) {
        $table = QM_FSE_DETAILS;
        $this->db->select('id,fse_name,fse_status');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_FSE_DETAILS . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_FSE_DETAILS . '.fse_status', 1);
        $this->db->like('fse_name', $keyword, 'after');
        $query = $this->db->get();
        $result = $query->result_array();
        $data = array();
        //  print_r($result);
        if (!empty($result)) {
            $i = 0;
            foreach ($result as $r) {
                $data[$i]['value'] = $r['id'];
                $data[$i]['label'] = $r['fse_name'];
                $i++;
            }
            echo json_encode($data);
        }
    }

    public function getIncident_autocomplete($keyword) {
        $table = QM_INCIDENT;
        $this->db->select('id,incident_name,incident_status');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_INCIDENT . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_INCIDENT . '.incident_status', 1);
        $this->db->like('incident_name', $keyword, 'after');
        $query = $this->db->get();
        $result = $query->result_array();
        $data = array();
        if (!empty($result)) {
            $i = 0;
            foreach ($result as $r) {
                $data[$i]['value'] = $r['id'];
                $data[$i]['label'] = $r['incident_name'];
                $i++;
            }
            echo json_encode($data);
        }
    }

    public function getProject_autocomplete($keyword) {
        $table = QM_PROJECT;
        $this->db->select('id,proj_name,proj_status');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_PROJECT . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_PROJECT . '.proj_status', 1);
        $this->db->like('proj_name', $keyword, 'after');
        $query = $this->db->get();
        $result = $query->result_array();
        // print_r($result);
        //echo $this->db->last_query();
        $data = array();
        if (!empty($result)) {
            $i = 0;
            foreach ($result as $r) {
                $data[$i]['value'] = $r['id'];
                $data[$i]['label'] = $r['proj_name'];
                $i++;
            }
            echo json_encode($data);
        }
    }

    public function productline_autocomplete($keyword) {
        $table = QM_PRODUCT_LINE;
        $this->db->select('value');
        $this->db->from($table);
        $this->db->like('value', $keyword, 'after');
        $query = $this->db->get();
        $result = $query->result_array();
        $data = array();
        if (!empty($result)) {
            foreach ($result as $r) {
                $data[] = $r['value'];
            }
            echo json_encode($data);
        }
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
        $this->db->where(QM_TASK . '.id', trim($data));
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

    public function gettasktypeHeaderModel() {

        $this->db->select(QM_TASK_TYPE . '.id,'
                . QM_ENTITY . '.ent_name,'
                . QM_TASK_TYPE . '.task_type');
        $this->db->from(QM_TASK_TYPE);
        $this->db->join(QM_ENTITY, QM_TASK_TYPE . '.ent_id = ' . QM_ENTITY . '.id', 'LEFT');
        //$this->db->where(QM_TASK . '.id', $id);

        $query = $this->db->get();
        return $query->result_array();
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

    public function thirdpartApiUpdate($task_id = NULL) {
        
        $final_data = array();
        $this->db->select('task_type_id,task_name, status_id');
        $this->db->from(QM_TASK);
        $this->db->where('id', $task_id);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return $final_data;
        }
        $ret = $query->row();
        $task_type_id = $ret->task_type_id;
        $task_name = $ret->task_name;
        $status_id = $ret->status_id;

        $final_data['u_task_name'] = $task_name;
        $this->db->select('integrated_api , states_data');
        $this->db->from(QM_TASK_TYPE);
        $this->db->where('id', $task_type_id);
        $query1 = $this->db->get();
        if ($query1->num_rows() == 0) {
            return $final_data;
        }
        $result1 = $query1->row();
        $integrated_api = $result1->integrated_api;
        $integrated_api = json_decode($integrated_api);
        $update_check = $integrated_api->update;
        if ($update_check == 0) {
            return $final_data['api_setting_qmobility_yeson'] = 0;
        } else {
            $final_data['api_setting_qmobility_yeson'] = 1;
        }

        $states_data = $result1->states_data;
        $states_data = json_decode($states_data);
        $task_status = "";
        if ($status_id == 1) {
            $task_status = $states_data->assigned;
        }
        if ($status_id == 2) {
            $task_status = $states_data->onhold;
        }
        if ($status_id == 3) {
            $task_status = $states_data->accepted;
        }
        if ($status_id == 4) {
            $task_status = $states_data->resolved;
        }
        if ($status_id == 5) {
            $task_status = $states_data->inprogress;
        }
        if ($status_id == 6) {
            $task_status = $states_data->rejected;
        }
        if ($status_id == 7) {
            $task_status = $states_data->rejected;
        }
        $final_data['u_status_id'] = $task_status;
        $this->db->select('API_Method_Name as method,API_End_point as url,API_User_name as username,API_Password as password,API_Key as key');
        $this->db->from(API_SETTINGS);
        $this->db->where('qm_task_type_id', $task_type_id);
        $this->db->where('API_Task_Type_id', 3);
        $query2 = $this->db->get();
        if ($query2->num_rows() == 0) {
            return $final_data;
        }
        $result2 = $query2->result_array();
        $final_data['api_setting_qmobility'] = $result2[0];

        $this->db->select('id ,map_data');
        $this->db->from(QM_EXTRA_ATTR_UPDATE);
        $this->db->where('task_type', $task_type_id);
        $querys = $this->db->get();
        if ($querys->num_rows() == 0) {
            return $final_data;
        }
        $result = $querys->result_array();
        foreach ($result as $value) {
            $this->db->select('value');
            $this->db->from(QM_EXTRA_ATTR_UPDATE_VALUE);
            $this->db->where('task_id', $task_id);
            $this->db->where('update_atr_id', $value['id']);
            $this->db->limit('1');
            $this->db->order_by('id', 'DESC');
            $quer = $this->db->get();
            if ($quer->num_rows() > 0) {
                $r = $quer->row();
                $update_data = $r->value;
            } else {
                $update_data = "";
            }
            if ($update_data != "") {
                if ($value['map_data'] != "") {
                    $final_data[$value['map_data']] = $update_data;
                }
            }
        }

        $final_data_json = json_encode($final_data);

        //  return $final_data;
        $method = $final_data['api_setting_qmobility']['method'];
        $url = $final_data['api_setting_qmobility']['url'];
        $username = $final_data['api_setting_qmobility']['username'];
        $password = $final_data['api_setting_qmobility']['password'];

        if ($method == "GET") {
            $method_o = "GET";
        } else {
            $method_o = "POST";
        }

        unset($final_data['api_setting_qmobility_yeson']);
        unset($final_data['api_setting_qmobility']);


        $data_string = json_encode($final_data);
        
         $task_log = array(
            'task_log' => "",
            'api_response' => "",
            'task_name' => $data_string,
            'apiname' => "Request data LOG"
        );
       // $this->InsertData('qm_task_create_log', $task_log);
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method_o);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $result = json_encode(curl_exec($ch));
       
        $task_log = array(
            'task_log' => str_replace(array('%', '_'), array('\\%', '\\_'), $final_data_json),
            'api_response' => str_replace(array('%', '_'), array('\\%', '\\_'), $data_string),
            'task_name' => $final_data['u_task_name'],
            'apiname' => $result
        );
      //  $this->InsertData('qm_task_create_log', $task_log);

        return TRUE;
        // return $final_data;
    }

    public function thirdpartApiUpdateStatus($task_id = NULL) {

        $final_data = array();
        $this->db->select('task_type_id,task_name, status_id');
        $this->db->from(QM_TASK);
        $this->db->where('id', $task_id);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return $final_data;
        }
        $ret = $query->row();
        $task_type_id = $ret->task_type_id;
        $task_name = $ret->task_name;
        $status_id = $ret->status_id;

        $final_data['u_task_name'] = $task_name;
        $this->db->select('integrated_api , states_data');
        $this->db->from(QM_TASK_TYPE);
        $this->db->where('id', $task_type_id);
        $query1 = $this->db->get();
        if ($query1->num_rows() == 0) {
            return $final_data;
        }
        $result1 = $query1->row();
        $integrated_api = $result1->integrated_api;
        $integrated_api = json_decode($integrated_api);
        $update_check = $integrated_api->update;
        if ($update_check == 0) {
            return $final_data['api_setting_qmobility_yeson'] = 0;
        } else {
            $final_data['api_setting_qmobility_yeson'] = 1;
        }

        $states_data = $result1->states_data;
        $states_data = json_decode($states_data);
        $task_status = "";
        if ($status_id == 1) {
            $task_status = $states_data->assigned;
        }
        if ($status_id == 2) {
            $task_status = $states_data->onhold;
        }
        if ($status_id == 3) {
            $task_status = $states_data->accepted;
        }
        if ($status_id == 4) {
            $task_status = $states_data->resolved;
        }
        if ($status_id == 5) {
            $task_status = $states_data->inprogress;
        }
        if ($status_id == 6) {
            $task_status = $states_data->rejected;
        }
        if ($status_id == 7) {
            $task_status = $states_data->rejected;
        }
        $final_data['u_status_id'] = $task_status;
        $this->db->select('API_Method_Name as method,API_End_point as url,API_User_name as username,API_Password as password,API_Key as key');
        $this->db->from(API_SETTINGS);
        $this->db->where('qm_task_type_id', $task_type_id);
        $this->db->where('API_Task_Type_id', 3);
        $query2 = $this->db->get();
        if ($query2->num_rows() == 0) {
            return $final_data;
        }
        $result2 = $query2->result_array();
        $final_data['api_setting_qmobility'] = $result2[0];
        $final_data_json = json_encode($final_data);
        //  return $final_data;
        $method = $final_data['api_setting_qmobility']['method'];
        $url = $final_data['api_setting_qmobility']['url'];
        $username = $final_data['api_setting_qmobility']['username'];
        $password = $final_data['api_setting_qmobility']['password'];

        if ($method == "GET") {
            $method_o = "GET";
        } else {
            $method_o = "POST";
        }

        unset($final_data['api_setting_qmobility_yeson']);
        unset($final_data['api_setting_qmobility']);


        $data_string = json_encode($final_data);
        $task_log = array(
            'task_log' => "",
            'api_response' => "",
            'task_name' => $data_string,
            'apiname' => "Request data LOG"
        );
      //  $this->InsertData('qm_task_create_log', $task_log);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method_o);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $result = json_encode(curl_exec($ch));
//        $result = "ok";
        $task_log = array('taskname' => $final_data['u_task_name'],
            'api_name' => "UPDATE STATUS ONLY",
            'qmobility_json' => $final_data_json,
            'request_json' => $data_string,
            'response_data' => $result
        );
        //$this->InsertData(QM_THIRDPARTY_API_LOG, $task_log);

       
         $task_log = array(
            'task_log' => $str = str_replace(array('%', '_'), array('\\%', '\\_'), $final_data_json),
            'api_response' => str_replace(array('%', '_'), array('\\%', '\\_'), $data_string),
            'task_name' => $final_data['u_task_name'],
            'apiname' => $result
        );
       // $this->InsertData('qm_task_create_log', $task_log);

        return TRUE;
        // return $final_data;
    }

    public function thirdpartWebDataUpdate($task_id = NULL) {

        $final_data = array();
        $this->db->select('task_type_id,task_name, status_id');
        $this->db->from(QM_TASK);
        $this->db->where('id', $task_id);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return $final_data;
        }
        $ret = $query->row();
        $task_type_id = $ret->task_type_id;
        $task_name = $ret->task_name;
        $status_id = $ret->status_id;

        $final_data['u_task_name'] = $task_name;
        $this->db->select('integrated_api , states_data');
        $this->db->from(QM_TASK_TYPE);
        $this->db->where('id', $task_type_id);
        $query1 = $this->db->get();
        if ($query1->num_rows() == 0) {
            return $final_data;
        }
        $result1 = $query1->row();
        $integrated_api = $result1->integrated_api;
        $integrated_api = json_decode($integrated_api);
        $update_check = $integrated_api->update;
        if ($update_check == 0) {
            return $final_data['api_setting_qmobility_yeson'] = 0;
        } else {
            $final_data['api_setting_qmobility_yeson'] = 1;
        }

        $states_data = $result1->states_data;
        $states_data = json_decode($states_data);
        $task_status = "";
        if ($status_id == 1) {
            $task_status = $states_data->assigned;
        }
        if ($status_id == 2) {
            $task_status = $states_data->onhold;
        }
        if ($status_id == 3) {
            $task_status = $states_data->accepted;
        }
        if ($status_id == 4) {
            $task_status = $states_data->resolved;
        }
        if ($status_id == 5) {
            $task_status = $states_data->inprogress;
        }
        if ($status_id == 6) {
            $task_status = $states_data->rejected;
        }
        if ($status_id == 7) {
            $task_status = $states_data->rejected;
        }
        $final_data['u_status_id'] = $task_status;
        $this->db->select('API_Method_Name as method,API_End_point as url,API_User_name as username,API_Password as password,API_Key as key');
        $this->db->from(API_SETTINGS);
        $this->db->where('qm_task_type_id', $task_type_id);
        $this->db->where('API_Task_Type_id', 3);
        $query2 = $this->db->get();
        if ($query2->num_rows() == 0) {
            return $final_data;
        }
        $result2 = $query2->result_array();
        $final_data['api_setting_qmobility'] = $result2[0];

        $final_data_json = json_encode($final_data);

        //  return $final_data;
        $method = $final_data['api_setting_qmobility']['method'];
        $url = $final_data['api_setting_qmobility']['url'];
        $username = $final_data['api_setting_qmobility']['username'];
        $password = $final_data['api_setting_qmobility']['password'];

        if ($method == "GET") {
            $method_o = "GET";
        } else {
            $method_o = "POST";
        }

        unset($final_data['api_setting_qmobility_yeson']);
        unset($final_data['api_setting_qmobility']);


        $data_string = json_encode($final_data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method_o);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $result = json_encode(curl_exec($ch));
        $task_log = array('taskname' => $final_data['u_task_name'],
            'api_name' => "TASK WEB DATA UPDATE",
            'qmobility_json' => $final_data_json,
            'request_json' => $data_string,
            'response_data' => $result
        );
        //$this->InsertData(QM_THIRDPARTY_API_LOG, $task_log);
        return TRUE;
    }

    public function thirdpartUpatetimeFeedback($task_id = NULL) {

        $final_data = array();
        $this->db->select('task_type_id,task_name, status_id');
        $this->db->from(QM_TASK);
        $this->db->where('id', $task_id);
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return $final_data;
        }
        $ret = $query->row();
        $task_type_id = $ret->task_type_id;
        $task_name = $ret->task_name;
        $status_id = $ret->status_id;

        $final_data['u_task_name'] = $task_name;
        $this->db->select('integrated_api , states_data');
        $this->db->from(QM_TASK_TYPE);
        $this->db->where('id', $task_type_id);
        $query1 = $this->db->get();
        if ($query1->num_rows() == 0) {
            return $final_data;
        }
        $result1 = $query1->row();
        $integrated_api = $result1->integrated_api;
        $integrated_api = json_decode($integrated_api);
        $update_check = $integrated_api->update;
        if ($update_check == 0) {
            return $final_data['api_setting_qmobility_yeson'] = 0;
        } else {
            $final_data['api_setting_qmobility_yeson'] = 1;
        }

        $states_data = $result1->states_data;
        $states_data = json_decode($states_data);
        $task_status = "";
        if ($status_id == 1) {
            $task_status = $states_data->assigned;
        }
        if ($status_id == 2) {
            $task_status = $states_data->onhold;
        }
        if ($status_id == 3) {
            $task_status = $states_data->accepted;
        }
        if ($status_id == 4) {
            $task_status = $states_data->resolved;
        }
        if ($status_id == 5) {
            $task_status = $states_data->inprogress;
        }
        if ($status_id == 6) {
            $task_status = $states_data->rejected;
        }
        if ($status_id == 7) {
            $task_status = $states_data->rejected;
        }
        $final_data['u_status_id'] = $task_status;
        $this->db->select('API_Method_Name as method,API_End_point as url,API_User_name as username,API_Password as password,API_Key as key');
        $this->db->from(API_SETTINGS);
        $this->db->where('qm_task_type_id', $task_type_id);
        $this->db->where('API_Task_Type_id', 3);
        $query2 = $this->db->get();

        if ($query2->num_rows() == 0) {
            return $final_data;
        }
        $result2 = $query2->result_array();
        $final_data['api_setting_qmobility'] = $result2[0];

        $final_data_json = json_encode($final_data);

        //  return $final_data;
        $method = $final_data['api_setting_qmobility']['method'];
        $url = $final_data['api_setting_qmobility']['url'];
        $username = $final_data['api_setting_qmobility']['username'];
        $password = $final_data['api_setting_qmobility']['password'];

        if ($method == "GET") {
            $method_o = "GET";
        } else {
            $method_o = "POST";
        }

        $this->db->select("capture_assets,fse_checklist,task_checklist,task_unchecklist,fse_task_comments,fse_reason,fse_feedback,fseRating");
        $this->db->from(QM_TASK);
        $this->db->where('id', $task_id);
        $tquery = $this->db->get();
        $asset = array();
        if ($tquery->num_rows() == 1) {
            $tresult = $tquery->result_array();
            $final_data['u_fse_checklist'] = $tresult[0]['fse_checklist'];
            $final_data['u_fse_feedback'] = $tresult[0]['fse_feedback'];
            $final_data['u_task_unchecklist'] = $tresult[0]['task_unchecklist'];
            $final_data['u_task_checklist'] = $tresult[0]['task_checklist'];
            $asset['parts'] = json_decode($tresult[0]['capture_assets']);
            $final_data['u_capture_assets'] = $asset;
        }

        $this->db->select("total_travel_time,total_worked_time,geo_km");
        $this->db->from(QM_TASK_LOCATION);
        $this->db->where('task_id', $task_id);
        $this->db->order_by('id', 'DESC');
        $this->db->limit('1');
        $lquery = $this->db->get();

        if ($lquery->num_rows() == 1) {
            $lresult = $lquery->result_array();
            $final_data['u_repair_time'] = $lresult[0]['total_worked_time'];
            $final_data['u_travel_time'] = $lresult[0]['total_travel_time'];
            $final_data['u_calculated_distance'] = $lresult[0]['geo_km'];
        }

        unset($final_data['api_setting_qmobility_yeson']);
        unset($final_data['api_setting_qmobility']);

        $data_string = json_encode($final_data);
        $task_log = array(
            'task_log' => "",
            'api_response' => "",
            'task_name' => $data_string,
            'apiname' => "Request data LOG"
        );
      //  $this->InsertData('qm_task_create_log', $task_log);
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method_o);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $result = json_encode(curl_exec($ch));
        
        $task_log = array(
            'task_log' => $str = str_replace(array('%', '_'), array('\\%', '\\_'), $final_data_json),
            'api_response' => str_replace(array('%', '_'), array('\\%', '\\_'), $data_string),
            'task_name' => $final_data['u_task_name'],
            'apiname' => $result
        );
        
      // $this->InsertData('qm_task_create_log', $task_log);
       return TRUE;
    }
}

?>
