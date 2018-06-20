<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class TPServicesModel extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function errorlogs($postArray, $keyArray, $error) {
        $a = 0;
        $b = 0;
        $c = 0;
        $return_val = array();
        $return_val['Request Value'] = $postArray;
        $return_val['Required Value'] = $keyArray;
        if ((!empty($postArray)) && (!empty($keyArray))) {
            foreach ($postArray as $key => $value) {
                if (array_key_exists($key, $keyArray)) {
                    if ($keyArray[$key] == 'required') {
                        if (trim($postArray[$key]) == "") {
                            $return_val['Field_Value_Empty'][$b] = $key;
                            $b++;
                        }
                    }
                } else {
                    $return_val['Wrong_Fields'][$a] = $key;
                    $a++;
                }
            }
        } else {
            $return_val['Request'] = 'Passing empty request';
        }
        if ((!empty($postArray)) && (!empty($keyArray))) {
            foreach ($keyArray as $key => $value) {
                if (!array_key_exists($key, $postArray)) {
                    if ($keyArray[$key] == 'required') {
                        $return_val['Missing_Fields'][$c] = $key;
                    }
                }
                $c++;
            }
        }
        return $return_val;
    }

    public function updateTask($data) {

        $insert_condition = TRUE;
        $error_result = array();
        $ent_id = NULL;
        $task_id = NULL;
        if (isset($data['task_name'])) {

            $task_name = $data['task_name'];
            $this->db->select('id');
            $this->db->from(QM_TASK);
            $this->db->where('task_name', trim($task_name));
            $this->db->order_by('id', 'DESC');
            $this->db->limit('1');
            $query = $this->db->get();
            //echo $this->db->last_query();
            if ($query->num_rows() == 1) {
                $task_id = $query->row()->id;
            } else {
                $insert_condition = FALSE;
                $error_result['taskStatus'] = "Task not exist in ww";
            }
        } else {
            $insert_condition = FALSE;
            $error_result['task_name'] = "required";
        }

        if (isset($data['fseEmail'])) {
            $res = $this->SelectFSE($data['fseEmail'], QM_FSE_DETAILS);
            if ($res == FALSE) {
                $insert_condition = FALSE;
                $error_result['fseEmail'] = "FSE Mail Not match";
            } else {
                $fse_id = $res->id;
                $ent_id = $res->ent_id;
                $data = array('fse_id' => $fse_id, 'ent_id' => $ent_id);
                $this->db->where('id', $task_id);
                $this->db->update(QM_TASK, $data);
            }
        }

        $priority = NULL;
        if (isset($data['priority'])) {

            $priority = NULL;
            if (trim($data['priority']) == 'LOW') {
                $priority = 4;
            } elseif (trim($data['priority']) == 'MEDIUM') {
                $priority = 3;
            } elseif (trim($data['priority']) == 'HIGH') {
                $priority = 2;
            } elseif (trim($data['priority']) == 'CRITICAL') {
                $priority = 1;
            } elseif (trim($data['priority']) == 'PLANNING') {
                $priority = 1;
            } else {
                $insert_condition = FALSE;
                $error_result['priority'] = array('priority using wrong code .. Use below status Code', 'LOW', 'MEDIUM', 'HIGH', 'CRITICAL', 'PLANING');
            }

            $data = array('fse_id' => $fse_id, 'ent_id' => $ent_id);
            $this->db->where('id', $task_id);
            $this->db->update(QM_TASK, $data);
        }

        if (isset($data['taskStatus'])) {
            $this->db->select('id');
            $this->db->from(QM_STATUS_TYPE);
            $this->db->where('status_type', urldecode($data['taskStatus']));
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $status_ids = $query->row()->id;
                $data = array('status_id' => $status_ids);
                $this->db->where('id', $task_id);
                $this->db->update(QM_TASK, $data);
            } else {
                $insert_condition = FALSE;
                $error_result['taskStatus'] = "Error! Status not match";
            }
        }

        $address_lang = NULL;
        if (isset($data['taskLocationAddress'])) {
            $address = urldecode($data['taskLocationAddress']);
            $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
            $geo = json_decode($geo, true);
            if ($geo['status'] == 'OK') {
                $latitude = $geo['results'][0]['geometry']['location']['lat'];
                $longitude = $geo['results'][0]['geometry']['location']['lng'];
                $address_lang = '(' . $latitude . ', ' . $longitude . ')';
            }
            $data = array('task_location' => $address_lang);
            $this->db->where('task_id', $task_id);
            $this->db->update(QM_TASK_LOCATION, $data);
        }

        if (isset($data['sys_id'])) {
            $sys_id = $data['sys_id'];
        } else {
            $sys_id = NULL;
        }

        //print_r(($data));
        unset($data['apiKey']);
        unset($data['fseEmail']);
        unset($data['task_name']);
        unset($data['priority']);
        unset($data['taskStatus']);
        unset($data['taskLocationAddress']);
        unset($data['taskType']);

        $ext_atr = array();
        $atte_id = 0;
        foreach ($data AS $key => $value) {
            $this->db->select('extr_att_id');
            $this->db->from(QM_EXTRA_ATTR_DEFINITION);
            $this->db->where('Task_type_ID', trim($taskType));
            $this->db->where('Ext_att_name', trim($key));
            $this->db->limit('1');
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $atr_id = $query->row()->extr_att_id;
                $ext_atr[$atr_id] = $value;
            } else {
                // $insert_condition = FALSE;
                //  $error_result['Cust Fields'] = "Error! Cust fields are not match";
                //$error_result['Cust Fields'] = $key;
                $atte_id++;
            }
        }
        if (!empty($ext_atr)) {
            foreach ($ext_atr AS $key => $value) {
                $data = array(
                    'Extra_attr_Values' => $value,
                );
                $data = array('task_location' => $address_lang);
                $this->db->where('Task_id', $task_id);
                $this->db->where('Extra_attr_Def_id', $key);
                $this->db->where('task_type_id', $taskType);
                $this->db->update(QM_EXTRA_ATTR_VALUES, $data);
            }
        }
        $error_result['Task Create'] = "'task updated API CALL'";
        return $error_result;
    }

    public function getFseDeviceType($id = NULL) {
        if ($id != NULL) {
            $table = QM_FSE_DETAILS;
            $this->db->select('fse_device_os');
            $this->db->from($table);
            $this->db->where(QM_FSE_DETAILS . '.id', $id);
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $result = $query->row();
                return $result->fse_device_os;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

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
        $this->InsertPushNotification($table, $data, $taskId);
        $passphrase = 'cgvak123';

        $dirName = dirname(__FILE__);
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $dirName . '/Certificates.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            //exit("Failed to connect: $err $errstr" . PHP_EOL);
        $body = array(
            'aps' => array(
                'alert' => $message,
                'sound' => 'default'
            ),
            'status_types' => $status_types,
            'status_id' => $status_id,
        );
        $payload = json_encode($body);
        $msg = chr(0) . pack('n', 32) . pack('H*', $device_token) . pack('n', strlen($payload)) . $payload;
        $result = fwrite($fp, $msg, strlen($msg));
        fclose($fp);
    }

    public function send_android_push($fseid = NULL, $insert = NULL, $taskId = NULL) {
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
        $status_types = $this->getGoogleStatustypes($status_id);
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

        $this->InsertPushNotification($table, $data, $taskId);

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

    public function CreateTask($data) {

        $insert_condition = TRUE;
        $error_result = array();
        $ent_id = NULL;
        if (isset($data['fseEmail'])) {
            $res = $this->SelectFSE($data['fseEmail'], QM_FSE_DETAILS);
            if ($res == FALSE) {
                $insert_condition = FALSE;
                $error_result['fseEmail'] = "FSE Mail Not match";
            } else {
                $fse_id = $res->id;
                $ent_id = $res->ent_id;
            }
        } else {
            $insert_condition = FALSE;
            $error_result['fseEmail'] = "required";
        }

        if (isset($data['task_name'])) {
            $task_name = $data['task_name'];
        } else {
            $insert_condition = FALSE;
            $error_result['task_name'] = "required";
        }

        $priority = NULL;
        if (isset($data['priority'])) {

            $priority = NULL;
            if (trim($data['priority']) == 'LOW') {
                $priority = 4;
            } elseif (trim($data['priority']) == 'MEDIUM') {
                $priority = 3;
            } elseif (trim($data['priority']) == 'HIGH') {
                $priority = 2;
            } elseif (trim($data['priority']) == 'CRITICAL') {
                $priority = 1;
            } elseif (trim($data['priority']) == 'PLANNING') {
                $priority = 1;
            } else {
                $insert_condition = FALSE;
                $error_result['priority'] = array('priority using wrong code .. Use below status Code', 'LOW', 'MEDIUM', 'HIGH', 'CRITICAL', 'PLANING');
            }
        } else {
            $insert_condition = FALSE;
            $error_result['priority'] = "required";
        }
        if (isset($data['taskStatus'])) {
            $this->db->select('id');
            $this->db->from(QM_STATUS_TYPE);
            $this->db->where('status_type', urldecode($data['taskStatus']));
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $status_ids = $query->row()->id;
            } else {
                $insert_condition = FALSE;
                $error_result['taskStatus'] = "Error! Status not match";
            }
        } else {
            $insert_condition = FALSE;
            $error_result['taskStatus'] = "required";
        }
        $taskType = NULL;
        if (isset($data['taskType'])) {
            $this->db->select('id');
            $this->db->from(QM_TASK_TYPE);
            $this->db->where('id', $data['taskType']);
            $this->db->where('ent_id', $ent_id);
            $query = $this->db->get();
            // echo  $this->db->last_query();
            if ($query->num_rows() == 1) {
                $taskType = $query->row()->id;
            } else {
                $insert_condition = FALSE;
                $error_result['fseEmail'] = "Error! FSE not match for this Entity";
            }
        } else {
            $insert_condition = FALSE;
            $error_result['taskType'] = "required";
        }

        $address_lang = NULL;
        if (isset($data['taskLocationAddress'])) {
            $address = urldecode($data['taskLocationAddress']);
            $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
            $geo = json_decode($geo, true);
            if ($geo['status'] == 'OK') {
                $latitude = $geo['results'][0]['geometry']['location']['lat'];
                $longitude = $geo['results'][0]['geometry']['location']['lng'];
                $address_lang = '(' . $latitude . ', ' . $longitude . ')';
            }
        } else {
            $insert_condition = FALSE;
            $error_result['taskLocationAddress'] = "required";
        }

        if (isset($data['sys_id'])) {
            $sys_id = $data['sys_id'];
        } else {
            $sys_id = NULL;
        }





        //print_r(($data));
        unset($data['apiKey']);
        unset($data['fseEmail']);
        unset($data['task_name']);
        unset($data['priority']);
        unset($data['taskStatus']);
        unset($data['taskLocationAddress']);
        unset($data['taskType']);

        $ext_atr = array();
        $atte_id = 0;
        foreach ($data AS $key => $value) {
            $this->db->select('extr_att_id');
            $this->db->from(QM_EXTRA_ATTR_DEFINITION);
            $this->db->where('Task_type_ID', trim($taskType));
            $this->db->where('Ext_att_name', trim($key));
            $this->db->limit('1');
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $atr_id = $query->row()->extr_att_id;
                $ext_atr[$atr_id] = $value;
            } else {
                // $insert_condition = FALSE;
                $error_result['Cust Fields'] = "Error! Cust fields are not match";
                //$error_result['Cust Fields'] = $key;
                $atte_id++;
            }
        }
        if ($insert_condition == TRUE) {
            $task_insert = array(
                'task_type_id' => $taskType,
                'fse_id' => $fse_id,
                'task_name' => trim($task_name),
                'status_id' => $status_ids,
                'priority' => $priority,
                'task_address' => urldecode($address),
                'ent_id' => $ent_id,
                'sys_id' => $sys_id
            );


            $this->db->select('id');
            $this->db->from(QM_TASK);
            $this->db->where('fse_id', trim($fse_id));
            $this->db->where('task_name', trim($task_name));
            $this->db->limit('1');
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $insert_condition = FALSE;
                $error_result['Task Create'] = "'Task Create Failed'... This task already in WorkWide'";
            } else {
                $tid = $this->InsertData(QM_TASK, $task_insert);
                if ($tid) {
                    $lsatInsertId = $this->db->insert_id();

                    $device_type = $this->getFseDeviceType($fse_id);
                    if (trim($device_type) == "iOS") {
                        $this->send_ios_push($fse_id, $task_insert, $lsatInsertId);
                    } else {
                        $this->send_android_push($fse_id, $task_insert, $lsatInsertId);
                    }
                    $loca = array('task_location' => $address_lang, 'task_id' => $lsatInsertId);
                    $this->InsertData(QM_TASK_LOCATION, $loca);
                    if (!empty($ext_atr)) {
                        foreach ($ext_atr AS $key => $value) {
                            $data = array(
                                'Extra_attr_Def_id' => $key,
                                'Task_id' => $lsatInsertId,
                                'task_type_id' => $taskType,
                                'Extra_attr_Values' => $value,
                            );
                            $this->db->insert(QM_EXTRA_ATTR_VALUES, $data);
                        }
                    }
                    $error_result['Task Create'] = "'Task Created'... ";
                } else {
                    $error_result['Task Create'] = "'Task Create Failed'... ";
                }
            }
        } else {
            $error_result['Task Create'] = "'Task Create Failed'... ";
        }
        return $error_result;
    }

    public function gettasktypeIdUsingAPIkey($key = NULL) {

        $this->db->select('qm_task_type_id');
        $this->db->from(API_SETTINGS);
        $this->db->where('API_Key', trim($key));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row()->qm_task_type_id;
        } else {
            return FALSE;
        }
    }

    public function get_taskFelidsbyTaskType($task_type_id = NULL) {
        $this->db->select(
                QM_EXTRA_ATTR_DEFINITION . '. Ext_att_name,'
                . QM_EXTRA_ATTR_DEFINITION . '. Task_type_ID,'
                . QM_EXTRA_ATTR_DEFINITION . '. extr_att_id,'
                . QM_EXTRA_ATTR_DEFINITION . '. Ext_att_type,'
                . QM_CATEGORY . '. category,'
                . QM_CATEGORY . '. separate_update_screen,'
                . QM_CATEGORY . '. id '
        );
        $this->db->from(QM_EXTRA_ATTR_DEFINITION);
        $this->db->join(QM_CATEGORY, QM_CATEGORY . '.id = ' . QM_EXTRA_ATTR_DEFINITION . '.Ext_att_category_id');
        $this->db->where(QM_EXTRA_ATTR_DEFINITION . '.Task_type_ID', $task_type_id);
        $this->db->order_by(QM_CATEGORY . '.id', "asc");
        $query = $this->db->get();
        return $result = $query->result_array();

        echo "<pre>";
        print_r($result);
        echo "</pre>";
    }

    public function array_cam_postdata($getdata = NULL, $systemdata = NULL) {

        unset($getdata['apiKey']);

        $condition = TRUE;

        $sys_data = array();
        if (!empty($systemdata)) {
            foreach ($systemdata as $key => $sys_res) {
                $sys_data[] = $sys_res['Ext_att_name'];
            }
        }
        $data_show = array("fseEmail", "task_name", "priority", "taskStatus", "taskLocationAddress");
        $final_sys_data = array_merge($data_show, $sys_data);
        $missing_fields = array();
        $extra_fields = array();
        if (!empty($final_sys_data) && !empty($getdata)) {
            foreach ($final_sys_data as $fsd) {
                if (!isset($getdata[$fsd])) {
                    $missing_fields[] = $fsd;
                    //  $condition = FALSE;
                }
            }
            foreach ($getdata as $key => $value) {
                if (!in_array($key, $final_sys_data)) {
                    $extra_fields[] = $key;
                    // $condition = FALSE;
                }
            }
        }

        $result = array();

        if ($condition == TRUE) {
            return $result = "ARRAY_MACHED";
        } else {
            $result['missing_fields'] = $missing_fields;
            $result['extra_fields'] = $extra_fields;
            return $result;
        }
    }

    public function tp_error($data, $insertId = TRUE) {
        $this->db->insert(QM_TP_LOGS, $data);
        if ($insertId) {
            return $this->db->insert_id();
        } else {
            return $this->db->affected_rows();
        }
    }

}
