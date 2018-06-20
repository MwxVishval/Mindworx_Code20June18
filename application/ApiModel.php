<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ApiModel extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function fse_login($fse_username, $fse_password, $fse_device_id = NULL, $device_OS = NULL, $versioncode = NULL) {

        $this->db->select(QM_FSE_DETAILS . '.*,' . QM_ENTITY . '.entity_color,' . QM_ENTITY . '.entity_secondary_color,' . QM_ENTITY . '.flow,' . QM_ENTITY . '.ent_name');
        $this->db->from(QM_FSE_DETAILS);
        $this->db->join(QM_ENTITY, QM_FSE_DETAILS . '.ent_id = ' . QM_ENTITY . '.id', 'LEFT');
        $this->db->where('fse_status', 1);
        $this->db->where('fse_username', $fse_username);
        $this->db->where('fse_password', $fse_password);
        $query = $this->db->get();
        //echo $this->db->last_query();
        //exit();
        if ($query->num_rows() == 1) {
            $res = $query->row();
            $token = md5($res->id . $fse_password);
            $data = array('fse_token' => $token, 'fse_device_id' => $fse_device_id, 'fse_device_os' => $device_OS, 'versioncode' => $versioncode);
            $this->db->where('id', $res->id);
            $this->db->update('qm_fse_details', $data);

            $ret['TOKEN'] = $token;
            $ret['user_id'] = $res->id;
            $ret['email'] = $res->fse_email;
            $ret['mobile'] = $res->fse_mobile;
            $ret['name'] = $res->fse_name;
            $ret['address'] = $res->fse_address;
            $ret['entityid'] = $res->ent_id;
            $ret['ent_name'] = $res->ent_name;
            $ret['colorCode'] = $res->entity_color;
            $ret['secondary_color'] = $res->entity_secondary_color;
            $ret['flow'] = $res->flow;
            return $ret;
        } else {
            return FALSE;
        }
    }

    public function updatePassword($getdata = NULL) {
        $this->db->select('*');
        $this->db->from(QM_FSE_DETAILS);
        $this->db->where('fse_status', 1);
        $this->db->where('fse_password', trim($getdata['oldPassword']));
        $this->db->where('id', trim($getdata['userId']));
        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() == 1) {
            $res = $query->row();
            $datar['username'] = $res->fse_username;
            $datar['password'] = $getdata['newPassword'];
            $datar['fse_email'] = $res->fse_email;
            $data = array('fse_password' => $getdata['newPassword']);
            $this->db->where('id', $getdata['userId']);
            $this->db->update(QM_FSE_DETAILS, $data);
            return $datar;
        } else {
            return FALSE;
        }
    }

    public function resetPassword($emailid = NULL, $userId = NULL) {
        $this->db->select('*');
        $this->db->from(QM_FSE_DETAILS);
        $this->db->where('fse_status', 1);
        $this->db->where('fse_email', trim($emailid));
        if (!$userId == NULL) {
            $this->db->where('id', trim($userId));
        }
        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() == 1) {
            $res = $query->row();
            $data['username'] = $res->fse_username;
            $id = $res->id;
            $newPass = mt_rand(100000, 999999);
            $datas = array('fse_password' => $newPass);
            $this->db->where('id', $id);
            $this->db->update(QM_FSE_DETAILS, $datas);
            $data['password'] = $newPass;
            return $data;
        } else {
            return FALSE;
        }
    }

    public function emailPassword($data = NULL) {

        $this->db->select('fse_password,fse_email,fse_username');
        $this->db->from(QM_FSE_DETAILS);
        $this->db->where('id', trim($data['userid']));
        $this->db->where('fse_password', trim($data['oldpassword']));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $res = $query->row();
            $datas['username'] = $res->fse_username;
            $datas['password'] = trim($data['newpassword']);
            $datas['emailid'] = $res->fse_email;
            $datau = array('fse_password' => trim($data['newpassword']));
            $this->db->where('id', trim($data['userid']));
            $this->db->update(QM_FSE_DETAILS, $datau);
            if ($this->db->affected_rows() > 0) {
                return $datas;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function fse_token($token, $userid) {

        $this->db->select('id');
        $this->db->from(QM_FSE_DETAILS);
        $this->db->where('fse_status', 1);
        $this->db->where('fse_token', trim($token));
        if ($userid != NULL) {
            $this->db->where('id', trim($userid));
        }
        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() == 1) {
            $res = $query->row();
            return $res->id;
        } else {
            return FALSE;
        }
    }

    public function taskCount($userID = NULL) {
        $this->db->select('count(' . QM_TASK . '.status_id) as total ,' . QM_STATUS_TYPE . '.status_type as type,' . QM_STATUS_TYPE . '.id as statusId');
        $this->db->from(QM_STATUS_TYPE);
        $this->db->join(QM_TASK, QM_STATUS_TYPE . '.id = ' . QM_TASK . '.status_id and ' . QM_TASK . '.task_status=1 and ' . QM_TASK . '.fse_id=' . trim($userID), 'left');
        $this->db->group_by(QM_STATUS_TYPE . '.id');
        $query = $this->db->get();
        return $result = $query->result_array();
    }

    public function taskDetails($task_id = NULL) {
        if ($task_id != NULL) {
            $this->db->select('*,'
                    . QM_TASK_LOCATION . '.task_location as task_location ,'
                    . QM_TASK . '.id as taskid, '
                    . QM_STATUS_TYPE . '.status_type, DATE_FORMAT(' . QM_TASK . '.updated_date,"%Y-%m-%d") AS updated_date,DATE_FORMAT(' . QM_TASK . '.created_date,"%Y-%m-%d") AS created_date,'
                    //. QM_TASK_TYPE . '.integrated_api as api_data, '
                    . QM_TASK_LOCATION . '.geo_km as Google_KM');
            $this->db->from(QM_TASK);
            $this->db->join(QM_TASK_LOCATION, QM_TASK_LOCATION . '.task_id = ' . QM_TASK . '.id', 'left');
            $this->db->join(QM_STATUS_TYPE, QM_STATUS_TYPE . '.id = ' . QM_TASK . '.status_id', 'left');
            $this->db->where(QM_TASK . '.id', $task_id);
            $query = $this->db->get();
            // $this->db->last_query();
            $result = $query->result_array();
            //echo "<pre>";
            // print_r($result);

            $result[0]['id'] = $result[0]['taskid'];
            unset($result[0]['entity_logo']);
            unset($result[0]['customer_document']);
            unset($result[0]['customer_sign']);
            unset($result[0]['servicenow_api_response']);
            unset($result[0]['servicenow_api_request']);
//          unset($result[0]['task_location']);
            unset($result[0]['entity_color']);
            return $result;
        }
    }

    public function statusType() {
        $this->db->select('id , status_type');
        $this->db->from(QM_STATUS_TYPE);
        $this->db->where(QM_STATUS_TYPE . '.status_stat', 1);
        $query = $this->db->get();
        //$this->db->last_query();
        return $result = $query->result_array();
    }

    public function getActionCode($data) {
        $this->db->select('productline');
        $this->db->from(QM_TASK);
        $this->db->where('id', $data['taskid']);
        $query = $this->db->get();
        $ret = $query->row()->productline;

        $this->db->select('*');
        $this->db->from(QM_ACTION_CODE);
        $this->db->where('dependent_value', $ret);
        $querys = $this->db->get();
        return $result = $querys->result_array();
    }

    public function getSectionCode($data) {
        $this->db->select('productline');
        $this->db->from(QM_TASK);
        $this->db->where('id', $data['taskid']);
        $query = $this->db->get();
        $ret = $query->row()->productline;

        $this->db->select('*');
        $this->db->from(QM_SECTION_CODE);
        $this->db->where('dependent_value', $ret);
        $query = $this->db->get();
        return $result = $query->result_array();
    }

    public function getLocationCode($data) {
        $this->db->select('*');
        $this->db->from(QM_LOCATION_CODE);
        $this->db->where('dependent_value', $data['searchKey']);
        $query = $this->db->get();
        return $result = $query->result_array();
    }

    public function getcloseCode($data) {
        $this->db->select('*');
        $this->db->from(QM_CLOSE_CODE);
        // $this->db->where('ent_id', $data['entity_id']);
        $query = $this->db->get();
        return $result = $query->result_array();
    }

    public function taskAssetsGetLike($data) {
        $this->db->select(QM_SERVICE_NOW_ASSETS . '.*');
        $this->db->from(QM_SERVICE_NOW_ASSETS);
        $this->db->join(QM_TASK, QM_SERVICE_NOW_ASSETS . '.task_type = ' . QM_TASK . '.task_type_id');
        $this->db->where(QM_TASK . '.id', $data['task_id']);
        $this->db->like(QM_SERVICE_NOW_ASSETS . '.display_name', $data['keywordSearch'], 'after');
        $this->db->order_by(QM_SERVICE_NOW_ASSETS . '.type', 'ASC');
        $query = $this->db->get();
        //   echo $this->db->last_query();
        return $result = $query->result_array();
    }

    public function completeTaskFeildList($data) {
        $this->db->select('task_complete_fields');
        $this->db->from(QM_ENTITY);
        $this->db->where('id', $data['entity']);
        $query = $this->db->get();
        //$this->db->last_query();
        $result = $query->result();
        $result = json_decode($result[0]->task_complete_fields);
        return $result;
    }

    public function taskListSearch($userID = NULL, $statusType = NULL, $startdate = NULL, $enddate = NULL) {
        $this->db->select('* ,' . QM_TASK . '.id as taskid');
        $this->db->from(QM_TASK);
        $this->db->join(QM_STATUS_TYPE, QM_STATUS_TYPE . '.id = ' . QM_TASK . '.status_id');
        $this->db->where(QM_TASK . '.task_status', 1);
        $this->db->where(QM_TASK . '.fse_id', trim($userID));
        if ($statusType != NULL) {
            $this->db->where(QM_TASK . '.status_id', trim($statusType));
        }
        $this->db->where('date(start_date) BETWEEN "' . date('Y-m-d', strtotime($startdate)) . '" and "' . date('Y-m-d', strtotime($enddate)) . '"');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $result = $query->result_array();
        //$result = $query->result_array();
        //echo "<pre>";
        //print_r($result);
        //exit();
    }

    public function inprogessTaskId($id = NULL) {
        if ($id != NULL) {
            $this->db->select('id');
            $this->db->from(QM_TASK);
            $this->db->where('fse_id', $id);
            $this->db->where('status_id', 5);
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $result = $query->row();
                return $result->id;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function taskList($userID = NULL, $statusType = NULL, $fromdashboard = NULL) {
        $this->db->select('* ,' . QM_TASK . '.id as taskid');
        $this->db->from(QM_TASK);
        $this->db->join(QM_STATUS_TYPE, QM_STATUS_TYPE . '.id = ' . QM_TASK . '.status_id', 'left');
        $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id', 'left');
        // $this->db->join(QM_CALL_STATUS_TYPE, QM_TASK . '.call_status = ' . QM_CALL_STATUS_TYPE . '.id', 'left');
        $this->db->join(QM_TASK_TYPE, QM_TASK . '.task_type_id = ' . QM_TASK_TYPE . '.id', 'left');
        //$this->db->join(QM_CALL_TYPE, QM_TASK . '.call_type = ' . QM_CALL_TYPE . '.id', 'left');
        $this->db->join(QM_PRIORITY, QM_TASK . '.priority = ' . QM_PRIORITY . '.id', 'left');
        $this->db->where(QM_TASK . '.task_status', 1);
        $this->db->where(QM_TASK . '.fse_id', trim($userID));
        if ($fromdashboard == 1) {
            $this->db->where(QM_TASK . '.status_id', trim($statusType));
            //  $this->db->where(QM_TASK . '.created_date BETWEEN DATE_SUB(NOW(), INTERVAL 15 DAY) AND NOW()');
        } else {
            if ($statusType != NULL AND $statusType != 3) {
                $this->db->where(QM_TASK . '.status_id', trim($statusType));
                //     $this->db->where(QM_TASK . '.created_date BETWEEN DATE_SUB(NOW(), INTERVAL 15 DAY) AND NOW()');
            }

            if ($statusType != NULL AND $statusType == 3) {
                $where = '(' . QM_TASK . '.status_id = 3 or ' . QM_TASK . '.status_id = 5)';
                $this->db->where($where);
                //  $this->db->where(QM_TASK . '.created_date BETWEEN DATE_SUB(NOW(), INTERVAL 15 DAY) AND NOW()');
            }
        }

        if ($statusType == 4) {
            $this->db->where(QM_TASK . '.created_date BETWEEN DATE_SUB(NOW(), INTERVAL 15 DAY) AND NOW()');
            $this->db->order_by(QM_TASK . '.updated_date', "DESC");
        } else {
            $this->db->order_by(QM_TASK . '.priority', "ASC");
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        //return $result = $query->result_array();
        $result = $query->result_array();
        // echo "<pre>";
        $i = 0;
        $data = array();
        foreach ($result AS $res) {
            unset($res['customer_sign']);
            unset($res['customer_document']);
            $data[$i] = $res;
            $data[$i]['task_checklist'] = json_decode($res['task_checklist']);
            $i++;
        }
        return $data;
    }

    public function selectDepondOns($taskid = NULL, $keywordSearch = NULL) {

        $this->db->select(QM_EXTRA_ATTR_UPDATE . '.type_values'
        );
        $this->db->from(QM_EXTRA_ATTR_UPDATE);
        $this->db->join(QM_TASK, QM_EXTRA_ATTR_UPDATE . '.task_type = ' . QM_TASK . '.task_type_id', 'left');
        $this->db->where(QM_TASK . '.id', $taskid);
        $this->db->where(QM_EXTRA_ATTR_UPDATE . '.label', $keywordSearch);

        //$this->db->like(QM_EXTRA_ATTR_UPDATE . '.label', $data['keywordSearch'], 'after');
        //$this->db->order_by(QM_EXTRA_ATTR_UPDATE . '.label', 'ASC');

        $query = $this->db->get();
        //    echo $this->db->last_query();
        return $query->result_array();
    }

    public function taskLists($userID = NULL, $statusType = NULL) {

        $this->db->select('* ,' . QM_TASK . '.id as taskid');
        $this->db->from(QM_TASK);
        $this->db->join(QM_STATUS_TYPE, QM_STATUS_TYPE . '.id = ' . QM_TASK . '.status_id');
        $this->db->join(QM_CUSTOMER_DETAILS, QM_CUSTOMER_DETAILS . '.id = ' . QM_TASK . '.customer_id');
        $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id', 'left');
        $this->db->where(QM_TASK . '.task_status', 1);
        $this->db->where(QM_TASK . '.fse_id', trim($userID));
        if ($statusType != NULL) {
            $this->db->where(QM_TASK . '.status_id', trim($statusType));
        }
        $query = $this->db->get();
        $result = $query->result_array();
        $i = 0;
        foreach ($result AS $res) {
            unset($res['customer_sign']);
            unset($res['customer_document']);
            $data[$i] = $res;
            $data[$i]['task_checklist'] = json_decode($res['task_checklist']);
            $i++;
        }
        print_r($data);
        exit;
        //return $data;
        //exit();
    }

    public function fseProfilePic($userID = NULL, $pictureString = NULL) {
        $data = array('fse_photo' => $pictureString);
        $this->db->where('id', $userID);
        $this->db->update(QM_FSE_DETAILS, $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function fseTaskFeedbackCustSign($userID = NULL, $taskid = NULL, $fsefeedback = NULL, $custSign = NULL, $fseRating = NULL) {



        if ($fsefeedback == NULL) {
            $data = array('customer_sign' => $custSign, 'fseRating' => $fseRating);
        } else {
            $data = array('fse_feedback' => $fsefeedback, 'customer_sign' => $custSign, 'fseRating' => $fseRating);
        }

        $this->db->where('fse_id', $userID);
        $this->db->where('id', $taskid);
        $this->db->update(QM_TASK, $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function fseProfileImage($userid) {

        $this->db->select('fse_photo');
        $this->db->from(QM_FSE_DETAILS);
        $this->db->where('fse_status', 1);
        $this->db->where('id', trim($userid));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $res = $query->row();
            header('Content-Type: image/jpeg');
            echo base64_decode($res->fse_photo);
        } else {
            echo 'FALSE';
        }
        exit;
    }

    public function entityColor($entityid) {

        $this->db->select('entity_color');
        $this->db->from(QM_ENTITY);
        $this->db->where('status', 1);
        $this->db->where('id', trim($entityid));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $res = $query->row();
            return $res->entity_color;
        } else {
            return 'FALSE';
        }
    }

    public function customerDocumentImage($getArray = NULL) {
        $this->db->where('task_id', $getArray['task_id']);
        $this->db->where('count', $getArray['count']);
        $query = $this->db->get(QM_TASK_CUSTOMER_DOCUMENT);
        if ($query->num_rows() == 1) {
            $row = $query->row_array();
            header('Content-Type: image/gif');
            echo base64_decode($row['customer_document']);
        } else {
            echo 'FALSE';
        }
        exit();
    }

    public function entityLogoImage($entityid) {

        $this->db->select('entity_logo');
        $this->db->from(QM_ENTITY);
        $this->db->where('status', 1);
        $this->db->where('id', trim($entityid));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $res = $query->row();
            header('Content-Type: image/gif');
            echo base64_decode($res->entity_logo);
        } else {
            echo 'FALSE';
        }
        exit;
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

    public function entityColorCode($entityid) {

        $this->db->select('entity_logo');
        $this->db->from(QM_ENTITY);
        $this->db->where('status', 1);
        $this->db->where('id', trim($entityid));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $res = $query->row();
            header('Content-Type: image/gif');
            // '<img src="data:image/gif;base64,' . $res->entity_logo . '"  height="100" width="100" />';
            echo base64_decode($res->entity_logo);
        } else {
            echo 'FALSE';
        }
        exit;
    }

    public function entityCustomFielsList($id = NULL) {
        $this->db->select('task_field');
        $this->db->from(QM_ENTITY);
        $this->db->where(QM_ENTITY . '.id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() == 1) {
            $res = $query->row();
            $r = json_decode($res->task_field);
            $res = array();
            foreach ($r AS $d) {
                if ($d == 0) {
                    $res[$d] = "task_name";
                    //  $res[$d]['id'] = $d;
                }
                if ($d == 1) {
                    //$res[$d] = "fse_name";
                    // $res[$d]['id'] = $d;
                }
                if ($d == 2) {
                    $res[$d] = "ent_name";
                    // $res[$d]['id'] = $d;
                }
                if ($d == 3) {
                    $res[$d] = "incident_name";
                    //   $res[$d]['id'] = $d;
                }
                if ($d == 4) {
                    $res[$d] = "call_number";
                    //  $res[$d]['id'] = $d;
                }
                if (true) {
                    $res[5] = "status_type";
                    // $res[5]['id'] = "5";
                }
                if ($d == 6) {
                    $res[$d] = "sla_name";
                    //  $res[$d]['id'] = $d;
                }
                if ($d == 7) {
                    $res[$d] = "task_description";
                    //  $res[$d]['id'] = $d;
                }
                if ($d == 8) {
                    $res[$d] = "start_date";
                    //   $res[$d]['id'] = $d;
                }
                if ($d == 9) {
                    $res[$d] = "task_address";
                    //   $res[$d]['id'] = $d;
                }
                if ($d == 10) {
                    $res[$d] = "product_name";
                    //  $res[$d]['id'] = $d;
                }
                if ($d == 11) {
                    $res[$d] = "serial_number";
                    //   $res[$d]['id'] = $d;
                }
                if ($d == 12) {
                    $res[$d] = "product_code";
                    //    $res[$d]['id'] = $d;
                }
                if ($d == 13) {
                    $res[$d] = "task_checklist";
                    //   $res[$d]['id'] = $d;
                }
                if ($d == 14) {
                    $res[$d] = "book_code";
                    //    $res[$d]['id'] = $d;
                }
                if ($d == 15) {
                    $res[$d] = "manual_docket_number";
                    //   $res[$d]['id'] = $d;
                }
                if ($d == 16) {
                    $res[$d] = "customer_contact_person";
                    //   $res[$d]['id'] = $d;
                }
                if ($d == 17) {
                    $res[$d] = "customer_contact_number";
                    //   $res[$d]['id'] = $d;
                }
                if ($d == 18) {
                    $res[$d] = "model";
                    //   $res[$d]['id'] = $d;
                }
                if ($d == 19) {
                    $res[$d] = "problem";
                    //    $res[$d]['id'] = $d;
                }
                if ($d == 20) {
                    $res[$d] = "callstatus_type";
                    //  $res[$d]['id'] = $d;
                }
                if ($d == 21) {
                    $res[$d] = "calltype_type";
                    //   $res[$d]['id'] = $d;
                }
                if ($d == 22) {
                    $res[$d] = "priority_type";
                    //     $res[$d]['id'] = $d;
                }
                if ($d == 23) {
                    $res[$d] = "message";
                    //     $res[$d]['id'] = $d;
                }
                if ($d == 24) {
                    $res[$d] = "comment_charge";
                    //    $res[$d]['id'] = $d;
                }
                if ($d == 25) {
                    $res[$d] = "previous_meter_reading";
                    //    $res[$d]['id'] = $d;
                }
                if ($d == 26) {
                    $res[$d] = "previous_color_reading";
                    //   $res[$d]['id'] = $d;
                }
                if ($d == 27) {
                    $res[$d] = "customer_order_number";
                    //  $res[$d]['id'] = $d;
                }
                if ($d == 28) {
                    $res[$d] = "outstanding_calls";
                    //   $res[$d]['id'] = $d;
                }
                if ($d == 29) {
                    $res[$d] = "customer_name";
                    //  $res[$d]['id'] = $d;
                }
                if ($d == 30) {
                    $res[$d] = "problem1";
                    //    $res[$d]['id'] = $d;
                }
                if ($d == 31) {
                    $res[$d] = "location";
                    //   $res[$d]['id'] = $d;
                }
                if ($d == 33) {
                    $res[33] = "productline";
                    $res[35] = "sn_problem1";
                    $res[36] = "sn_problem2";
                    $res[37] = "sn_location";
                    //   $res[$d]['id'] = $d;
                }
            }
            return $res;
        } else {
            return FALSE;
        }
    }

    public function taskCheckList($task_id = NULL) {
        $this->db->select('*');
        $this->db->from(QM_TASK);
        $this->db->where(QM_TASK . '.task_status', 1);
        $this->db->where(QM_TASK . '.id', trim($task_id));
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() == 1) {
            $res = $query->row();
            if ($res->task_checklist == NULL)
                return json_decode($res->task_checklist);
        } else {
            return FALSE;
        }
    }

    public function updatetaskStatusAccept($taskid = NULL, $statusid = NULL) {

        $data = array('status_id' => 3);
        $this->db->set('updated_date', 'NOW()', FALSE);
        $this->db->where('id', $taskid);
        $this->db->update(QM_TASK, $data);
        return TRUE;
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function updatetaskStatus($taskid = NULL, $statusid = NULL) {

        $data = array('status_id' => $statusid);
        //  $data = array('status_id' => 3);
        $this->db->set('updated_date', 'NOW()', FALSE);
        $this->db->where('id', $taskid);
        $this->db->update(QM_TASK, $data);
        if ($statusid == 4) {
            $Work_completed_time = array('Work_completed_time' => date('Y-m-d H:i:s'));
            $this->db->where('task_id', $taskid);
            $this->db->update(QM_TASK_LOCATION, $Work_completed_time);
            $this->db->select('*');
            $this->db->from(QM_TASK_LOCATION);
            $this->db->where('task_id', $taskid);
            $this->db->limit('1');
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $res = $query->result_array();
                $start_cal = $res[0]['start_to_work_time'];
                $reached_cal = $res[0]['Work_completed_time'];
                $data_time_cal = $this->date_difference($start_cal, $reached_cal);
                $start_to_work_time_cal = array('total_worked_time' => $data_time_cal);
                $this->db->where('task_id', $taskid);
                $this->db->update(QM_TASK_LOCATION, $start_to_work_time_cal);
                //  $this->db->last_query();
            }
        }
        return TRUE;
    }

    public function updatetaskComment($taskid = NULL, $comments = NULL) {

        $data = array('fse_feedback' => $comments);
        $this->db->where('id', $taskid);
        $this->db->update(QM_TASK, $data);
        //echo $this->db->last_query();
        return ($this->db->affected_rows() > 0) ? TRUE : 'Task Name Not Found OR No value Change';
    }

    public function getUpdateTaskStatus($taskid = NULL, $status = NULL, $comment = NULL, $reason = NULL) {
        $data = array('status_id' => $status, 'fse_reason`' => str_replace("#&$", " ", $reason), 'fse_task_comments' => str_replace("#&$", " ", $comment));
        // $data = array('status_id' => 3, 'fse_reason`' => $comment, 'fse_task_comments' => $reason);
        $this->db->where('id', $taskid);
        $this->db->update(QM_TASK, $data);
        //echo $this->db->last_query();
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function taskTimeCalcu($getarray = NULL) {

        if (isset($getarray['geo_km'])) {
            $date = date('Y-m-d H:i:s');
            $geo_km = array('geo_km' => $getarray['geo_km']);
            $this->db->where('task_id', $getarray['task_id']);
            $this->db->update(QM_TASK_LOCATION, $geo_km);
        }

        if (isset($getarray['start_trip'])) {
            $start_time = array('start_time' => date('Y-m-d H:i:s'), 'end_trip_check' => 1);
            $this->db->where('task_id', $getarray['task_id']);
            $this->db->update(QM_TASK_LOCATION, $start_time);
        }


        if (isset($getarray['end_trip'])) {

            $this->db->select('*');
            $this->db->from(QM_TASK_LOCATION);
            $this->db->where('task_id', $getarray['task_id']);
            $this->db->where('end_trip_check', 1);
            $this->db->limit('1');
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $reached_time = array('reached_time' => date('Y-m-d H:i:s'));
                $this->db->where('task_id', $getarray['task_id']);
                $this->db->update(QM_TASK_LOCATION, $reached_time);

                $this->db->select('*');
                $this->db->from(QM_TASK_LOCATION);
                $this->db->where('task_id', $getarray['task_id']);
                $this->db->limit('1');
                $query = $this->db->get();
                if ($query->num_rows() == 1) {
                    $res = $query->result_array();
                    $start_cal = $res[0]['start_time'];
                    $reached_cal = $res[0]['reached_time'];
                    $data_time_cal = $this->date_difference($start_cal, $reached_cal);
                    $start_to_work_time_cal = array('total_travel_time' => $data_time_cal);
                    $this->db->where('task_id', $getarray['task_id']);
                    $this->db->update(QM_TASK_LOCATION, $start_to_work_time_cal);
                }
            } else {
                $start_to_work_time_cal = array('total_travel_time' => "00:00:00");
                $this->db->where('task_id', $getarray['task_id']);
                $this->db->update(QM_TASK_LOCATION, $start_to_work_time_cal);
            }
        }

        if (isset($getarray['onhold'])) {
            $Work_completed_time = array('onhold' => date('Y-m-d H:i:s'));
            $this->db->where('task_id', $getarray['task_id']);
            $this->db->update(QM_TASK_LOCATION, $Work_completed_time);

            $this->db->select('*');
            $this->db->from(QM_TASK_LOCATION);
            $this->db->where('task_id', $getarray['task_id']);
            $this->db->limit('1');
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $res = $query->result_array();
                $start_cal = $res[0]['start_to_work_time'];
                $reached_cal = $res[0]['onhold'];
                $data_time_cal = $this->date_difference($start_cal, $reached_cal);
                $start_to_work_time_cal = array('total_worked_time' => $data_time_cal);
                $this->db->where('task_id', $getarray['task_id']);
                $this->db->update(QM_TASK_LOCATION, $start_to_work_time_cal);
                $this->db->last_query();
            }
        }

        if (isset($getarray['start_work'])) {
            $start_to_work_time = array('start_to_work_time' => date('Y-m-d H:i:s'));
            $this->db->where('task_id', $getarray['task_id']);
            $this->db->update(QM_TASK_LOCATION, $start_to_work_time);
        }

        if (isset($getarray['end_work'])) {
            $Work_completed_time = array('Work_completed_time' => date('Y-m-d H:i:s'));
            $this->db->where('task_id', $getarray['task_id']);
            $this->db->update(QM_TASK_LOCATION, $Work_completed_time);

            $this->db->select('*');
            $this->db->from(QM_TASK_LOCATION);
            $this->db->where('task_id', $getarray['task_id']);
            $this->db->limit('1');
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $res = $query->result_array();
                $start_cal = $res[0]['start_to_work_time'];
                $reached_cal = $res[0]['Work_completed_time'];
                $data_time_cal = $this->date_difference($start_cal, $reached_cal);
                $start_to_work_time_cal = array('total_worked_time' => $data_time_cal);
                $this->db->where('task_id', $getarray['task_id']);
                $this->db->update(QM_TASK_LOCATION, $start_to_work_time_cal);
                $this->db->last_query();
            }
        }
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function date_difference($date1timestamp, $date2timestamp) {

        $t1 = strtotime($date1timestamp);
        $t2 = strtotime($date2timestamp);

        $dtd = new stdClass();
        $dtd->interval = $t2 - $t1;
        $dtd->total_sec = abs($t2 - $t1);
        $dtd->total_min = floor($dtd->total_sec / 60);
        $dtd->total_hour = floor($dtd->total_min / 60);
        $dtd->total_day = floor($dtd->total_hour / 24);

        $dtd->day = $dtd->total_day;
        $dtd->hour = $dtd->total_hour - ($dtd->total_day * 24);
        $dtd->min = $dtd->total_min - ($dtd->total_hour * 60);
        $dtd->sec = $dtd->total_sec - ($dtd->total_min * 60);
        return $time_return = $dtd->hour . ':' . $dtd->min . ":" . $dtd->sec;


        // exit();
        // return $dtd;
        //$datetime1 = new DateTime($date1timestamp); 
        //$datetime2 = new DateTime($date2timestamp);
        //$interval = $datetime1->diff($datetime2);
        //$Interval = $datetime1->format('U') - $datetime2->format('U');
        //$Hours = gmdate("H:i:s", $Interval); 
        //  $Hours = gmdate("H:i:s", $interval);
        // print_r($Hours);
        //  return $Hours;
    }

    public function updateOfflineTask($getarray = NULL) {

        if (isset($getarray['fseComment'])) {
            $fseComment = array('fse_task_comments' => $getarray['fseComment']);
            $this->db->where('id', $getarray['taskid']);
            $this->db->update(QM_TASK, $fseComment);
        }

        if (isset($getarray['customerDocument'])) {
            $customerDocument = array('customer_document' => $getarray['customerDocument']);
            $this->db->where('id', $getarray['taskid']);
            $this->db->update(QM_TASK, $customerDocument);
        }
        if (isset($getarray['customerSignature'])) {
            $customerSignature = array('customer_sign' => $getarray['customerSignature']);
            $this->db->where('id', $getarray['taskid']);
            $this->db->update(QM_TASK, $customerSignature);
        }
        if (isset($getarray['customerFeedback'])) {
            $customerFeedback = array('fse_feedback' => $getarray['customerFeedback']);
            $this->db->where('id', $getarray['taskid']);
            $this->db->update(QM_TASK, $customerFeedback);
        }
        if (isset($getarray['checklist'])) {
            $checklist = array('fse_checklist' => $getarray['checklist']);
            $this->db->where('id', $getarray['taskid']);
            $this->db->update(QM_TASK, $checklist);
        }
        if (isset($getarray['status'])) {
//            $checklist = array('status_id' => $getarray['status']);
//            $this->db->where('id', $getarray['taskid']);
//            $this->db->update(QM_TASK, $checklist);
        }
        if (isset($getarray['customerName'])) {
            $customerName = array('cus_name' => $getarray['customerName']);
            $this->db->where('id', $getarray['customerId']);
            $this->db->update(QM_CUSTOMER_DETAILS, $customerName);
        }
        if (isset($getarray['customerMobile'])) {
            $customerMobile = array('cus_phone' => $getarray['customerMobile']);
            $this->db->where('id', $getarray['customerId']);
            $this->db->update(QM_CUSTOMER_DETAILS, $customerMobile);
        }
        if (isset($getarray['customerAddress'])) {
            $customerAddress = array('cus_address' => $getarray['customerAddress']);
            $this->db->where('id', $getarray['customerId']);
            $this->db->update(QM_CUSTOMER_DETAILS, $customerAddress);
        }
        if (isset($getarray['customerEmail'])) {
            $customerEmail = array('cus_email' => $getarray['customerEmail']);
            $this->db->where('id', $getarray['customerId']);
            $this->db->update(QM_CUSTOMER_DETAILS, $customerEmail);
        }
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function getCustomerDetailTask($taskid = NULL) {

        $this->db->select(QM_CUSTOMER_DETAILS . '.*');
        $this->db->from(QM_TASK);
        $this->db->join(QM_CUSTOMER_DETAILS, QM_CUSTOMER_DETAILS . '.id = ' . QM_TASK . '.customer_id');
        $this->db->where(QM_TASK . '.task_status', 1);
        $this->db->where(QM_TASK . '.id', trim($taskid));
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $result = $query->result_array();
    }

    public function getUpdatedChecklistTask($taskid = NULL) {
        $this->db->select('fse_checklist, task_unchecklist');
        $this->db->from(QM_TASK);
        $this->db->where(QM_TASK . '.task_status', 1);
        $this->db->where(QM_TASK . '.id', trim($taskid));
        $query = $this->db->get();
        return $result = $query->result_array();
    }

    public function updateCustomerDetails($userID = NULL, $getArray = NULL) {

        if (isset($getArray['photo'])) {
            $data = array('cus_name' => $getArray['name'], 'cus_email`' => $getArray['email'], 'cus_phone' => $getArray['mobile'], 'cus_address`' => $getArray['address'], 'fse_photo`' => $getArray['photo']);
        } else {
            $data = array('fse_name' => $getArray['name'], 'fse_email`' => $getArray['email'], 'fse_mobile' => $getArray['mobile'], 'fse_address`' => $getArray['address']);
        }

        $this->db->where('id', $userID);
        $this->db->update(QM_FSE_DETAILS, $data);
        //echo $this->db->last_query();
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function getUpdateTaskAssetsCode($getArray = NULL, $taskid = NULL, $duplication = NULL) {

        $this->db->select('capture_assets');
        $this->db->from(QM_TASK);
        $this->db->where('id', $taskid);
        $query = $this->db->get();
        $server_array = array();
        if ($query->row()->capture_assets != NULL) {
            $server_array = json_decode($query->row()->capture_assets);
        }
        $capture = json_decode($getArray);
        $captures = json_decode($getArray);
        $return_array = array();

        if ($duplication == "no") {
            if (is_array($capture)) {
                $capture = array_merge($capture, $server_array);
                $check_array_s = $check_array = $a = array();
                foreach ($captures as $key => $value) {
                    $check_array[] = $value->ID;
                }
                foreach ($server_array as $k => $v) {
                    $check_array_s[] = $v->ID;
                }
                $results = array_intersect($check_array, $check_array_s);

//                $a = array_unique($check_array);
//                echo "<pre>";
//                print_r($result);
//                print_r($check_array_s);
//                print_r($check_array);
//                echo "</pre>";
//                
                if (count($results) == 0) {
                    $arrayp = array('capture_assets' => json_encode($capture));
                    $this->db->where('id', $taskid);
                    $this->db->update(QM_TASK, $arrayp);
                    //echo $this->db->last_query();
                    $return_array['status'] = TRUE;
                    $return_array['duplication'] = FALSE;
                    ($this->db->affected_rows() > 0) ? TRUE : FALSE;
                } else {
                    $return_array['status'] = FALSE;
                    $return_array['duplication'] = TRUE;
                }
            }
        } else {
            $capture = array_merge($capture, $server_array);
            $arrayp = array('capture_assets' => json_encode($capture));
            $this->db->where('id', $taskid);
            $this->db->update(QM_TASK, $arrayp);
            //echo $this->db->last_query();
            $return_array['status'] = TRUE;
            $return_array['duplication'] = FALSE;
            ($this->db->affected_rows() > 0) ? TRUE : FALSE;
        }
        return $return_array;
    }

    public function selectUpdateTaskAssetscode($taskid = NULL) {
        $this->db->select('capture_assets');
        $this->db->from(QM_TASK);
        $this->db->where('id', $taskid);
        $query = $this->db->get();
        return json_decode($query->row()->capture_assets);
    }

    public function getUpdateTaskCompletedCode($getArray = NULL, $taskid = NULL) {

        //$taskid = $getArray['taskid'];
        unset($getArray['TOKEN']);
        unset($getArray['taskid']);
        $this->db->where('id', $taskid);
        $this->db->update(QM_TASK, $getArray);
        //echo $this->db->last_query();
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function getUpdateTaskCompletedCodeResolution($getArray = NULL) {

        $taskid = $getArray['taskid'];
        unset($getArray['TOKEN']);
        unset($getArray['taskid']);
        $this->db->where('id', $taskid);
        $this->db->update(QM_TASK, $getArray);
        // echo $this->db->last_query();
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function updateTaskCustomerDetails($getArray = NULL) {

        $taskid = $getArray['TaskID'];
        unset($getArray['TOKEN']);
        unset($getArray['TaskID']);
        unset($getArray['o_customer_name']);
        unset($getArray['o_customer_contact_person']);
        unset($getArray['o_customer_contact_number']);
        unset($getArray['o_customerAddress']);
        unset($getArray['customerAddress']);
        unset($getArray['o_task_address']);
        unset($getArray['customer_sign']);
        $this->db->where('id', $taskid);
        $this->db->update(QM_TASK, $getArray);
        //echo $this->db->last_query();
        //  die;
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function updateTaskCustomerDocumentCount($getArray = NULL) {

        $this->db->where('task_id', $getArray['task_id']);
        $this->db->order_by('count', 'DESC');
        $this->db->limit('1');
        $query = $this->db->get(QM_TASK_CUSTOMER_DOCUMENT);
        if ($query->num_rows() == 1) {
            $row = $query->row_array();
            return $row['count'];
        } else {
            return $count = 0;
        }
    }

    public function updateTaskCustomerDocument($getArray = NULL) {

        unset($getArray['TOKEN']);

        $this->db->where('task_id', $getArray['task_id']);
        $this->db->order_by('count', 'DESC');
        $this->db->limit('1');
        $query = $this->db->get(QM_TASK_CUSTOMER_DOCUMENT);
        if ($query->num_rows() == 1) {
            $row = $query->row_array();
            $count = $row['count'];
        } else {
            $count = 0;
        }
        $count = $count + 1;
        $data = array();
        $data['customer_document'] = $getArray['customer_document'];
        $data['task_id'] = $getArray['task_id'];
        $data['count'] = $count;
        $insert_id = $this->InsertData(QM_TASK_CUSTOMER_DOCUMENT, $data);
        if ($insert_id) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function updateCustomerDetailstaskDocument($getArray = NULL) {

        if (isset($getArray['photo'])) {
            $datas = array('customer_document' => $getArray['photo']);
            $this->db->where('id', $getArray['TaskID']);
            $this->db->update(QM_TASK, $datas);
        }
        $data = array('cus_name' => $getArray['name'], 'cus_email`' => $getArray['email'], 'cus_phone' => $getArray['mobile'], 'cus_address`' => $getArray['address']);
        $this->db->where('id', $getArray['custID']);
        $this->db->update(QM_CUSTOMER_DETAILS, $data);
        //echo $this->db->last_query();
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function updateChecklistTask($userID = NULL, $getArray = NULL, $taskid) {
        //$data = array($getArray);
        $this->db->where('id', $taskid);
        $this->db->update(QM_TASK, $getArray);
        //echo $this->db->last_query();
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function getDetailsForTaskCreate() {

        $data['fse'] = $this->getFse();
        $data['project'] = $this->getProject();
        $data['incident'] = $this->getIncident();
        $data['customer'] = $this->getCustomer();
        $data['taskStatusType'] = $this->getStatus();
        $data['SLA'] = $this->getSla();
        $data['branch'] = $this->getBranch();
        $data['TaskType'] = $this->getTasktype();
        return $data;
    }

    public function insertTaskLocation($data) {
        $table = QM_TASK_LOCATION;
        $insert_id = $this->InsertData($table, $data);
        if ($insert_id) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function taskAsset($data) {
        $table = QM_TASK_ASSET;
        unset($data['TOKEN']);
        $datas = array();
        $datas['asset_details'] = json_encode($data['asset_details']);
        $datas['task_id'] = $data['task_id'];
        $insert_id = $this->InsertData($table, $datas);
        if ($insert_id) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    //  $this->ApiModel->fseViewReportPage($userID,'2','TaskList');
    public function fseUiActionReportPage($fse_id = NULL, $page_id = NULL, $page_name = NULL) {

        $this->db->select('ent_id');
        $this->db->from(QM_FSE_DETAILS);
        $this->db->where('id', $fse_id);
        $query = $this->db->get();
        $ent_id = $query->row()->ent_id;

        $table = QM_FSE_ACTION_PAGE;
        $reportInsert['fse_id'] = $fse_id;
        $reportInsert['ent_id'] = $ent_id;
        $reportInsert['page_id'] = $page_id;
        $reportInsert['page_name'] = $page_name;
        $insert_id = $this->InsertData($table, $reportInsert);
        if ($insert_id) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function fseViewReportPage($fse_id = NULL, $page_id = NULL, $page_name = NULL) {

        $this->db->select('ent_id');
        $this->db->from(QM_FSE_DETAILS);
        $this->db->where('id', $fse_id);
        $query = $this->db->get();
        $ent_id = $query->row()->ent_id;

        $table = QM_FSE_VIEW_PAGE;
        $reportInsert['fse_id'] = $fse_id;
        $reportInsert['ent_id'] = $ent_id;
        $reportInsert['page_id'] = $page_id;
        $reportInsert['page_name'] = $page_name;
        $insert_id = $this->InsertData($table, $reportInsert);
        if ($insert_id) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function updateTask($data) {

        $task_log_check = $data;
        $return_result = array();
        $id = trim($data['taskTitle']);
        $this->db->where('task_name', $id);
        $querys = $this->db->get(QM_TASK);
        $count_row = $querys->num_rows();
        if ($count_row == 0) {
            $task_log = array('task_log' => json_encode($task_log_check),
                'task_name' => $id,
                'apiname' => 'Task Update WW APi',
                'api_response' => 'Error: the task does not exist'
            );

            $this->db->insert('qm_task_create_log', $task_log);

            $return_result['msg'] = "The task does not exist";
            $return_result['Status'] = "Failed";
            $return_result['Code'] = 0;
            return $return_result;
        }


        if (isset($data['fseEmail'])) {
            $res = $this->SelectFSE($data['fseEmail'], QM_FSE_DETAILS);
            if ($res == FALSE) {
                $return_result['FSE'] = 'ERROR FSE Mail Not match';
            } else {
                $id = trim($data['taskTitle']);
                $fse_id = $res->id;
                $branch_id = $res->branch_id;
                $ent_id = $res->ent_id;
                $up_data = array('fse_id' => $fse_id,
                    'branch_id' => $branch_id,
                    'ent_id' => $ent_id
                );
                $this->taskUpdateData($up_data, $id, QM_TASK);
                if ($this->db->affected_rows() > 0) {
                    $return_result['FSE'] = 'FSE Updated successfully';
                } else {
                    $return_result['FSE'] = 'No value change';
                }
            }
        }

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
                $return_result['priority'] = array('priority using wrong code .. Use below status Code', 'LOW', 'MEDIUM', 'HIGH', 'CRITICAL', 'PLANING');
            }
            if ($priority != NULL) {

                $d_priority = array('priority' => $priority);

                $this->taskUpdateData($d_priority, $id, QM_TASK);
                if ($this->db->affected_rows() > 0) {
                    $return_result['priority'] = 'Priority Updated successfully';
                } else {
                    $return_result['priority'] = array('No value change');
                }
            }
        }

        if (isset($data['taskStatus'])) {
            $id = trim($data['taskTitle']);
            $up_data = NULL;
            if (trim($data['taskStatus']) == 'Assigned') {
                $up_data = array('status_id' => 1);
            } elseif (trim($data['taskStatus']) == 'Pending') {
                $up_data = array('status_id' => 2);
            } elseif (trim($data['taskStatus']) == 'Accepted') {
                $up_data = array('status_id' => 3);
            } elseif (trim($data['taskStatus']) == 'Completed') {
                $up_data = array('status_id' => 4);
            } elseif (trim($data['taskStatus']) == 'InProgress') {
                $up_data = array('status_id' => 3);
            } elseif (trim($data['taskStatus']) == 'Canceled') {
                $up_data = array('status_id' => 6);
            } elseif (trim($data['taskStatus']) == 'Reject') {
                $up_data = array('status_id' => 7);
            } else {
                $return_result['status'] = array('Status not updated... Use below status Code', 'Assigned', 'Pending', 'Accepted', 'Completed', 'InProgress', 'Canceled', 'Reject');
            }
            if ($up_data != NULL) {

                $this->taskUpdateData($up_data, $id, QM_TASK);
                if ($this->db->affected_rows() > 0) {
                    $return_result['status'] = 'Status Updated successfully';
                } else {
                    $return_result['status'] = array('No value change');
                }
            }
        }

        if (isset($data['taskLocationAddress'])) {
            $up_data = array('task_address' => $data['taskLocationAddress']);
            $this->taskUpdateData($up_data, $id, QM_TASK);
            if ($this->db->affected_rows() > 0) {
                $return_result['taskLocationAddress'] = 'Updated successfully';
            } else {
                $return_result['taskLocationAddress'] = 'No value change';
            }
        }

        if (isset($data['asset'])) {
            $up_data = array('capture_assets' => $data['asset']);
            $this->taskUpdateData($up_data, $id, QM_TASK);
            if ($this->db->affected_rows() > 0) {
                $return_result['capture_assets'] = 'Asset Updated successfully';
            } else {
                $return_result['capture_assets'] = 'No value change';
            }
        }

        if (isset($data['problem1'])) {
            $up_data = array('problem' => $data['problem1']);
            $this->taskUpdateData($up_data, $id, QM_TASK);
            if ($this->db->affected_rows() > 0) {
                $return_result['problem1'] = 'Updated successfully';
            } else {
                $return_result['problem1'] = 'No value change';
            }
        }

        if (isset($data['problem2'])) {
            $up_data = array('problem1' => $data['problem2']);
            $this->taskUpdateData($up_data, $id, QM_TASK);
            if ($this->db->affected_rows() > 0) {
                $return_result['problem2'] = 'Updated successfully';
            } else {
                $return_result['problem2'] = 'No value change';
            }
        }

        if (isset($data['location'])) {
            $up_data = array('location' => $data['location']);
            $this->taskUpdateData($up_data, $id, QM_TASK);
            if ($this->db->affected_rows() > 0) {
                $return_result['location'] = 'Updated successfully';
            } else {
                $return_result['location'] = 'No value change';
            }
        }

        if (isset($data['customerName'])) {
            $up_data = array('task_description' => $data['customerName']);
            $this->taskUpdateData($up_data, $id, QM_TASK);
            if ($this->db->affected_rows() > 0) {
                $return_result['customerName'] = 'Updated successfully';
            } else {
                $return_result['customerName'] = 'No value change';
            }
        }

        if (isset($data['customerEmail'])) {
            $up_data = array('customerEmail' => $data['customerEmail']);
            $this->taskUpdateData($up_data, $id, QM_TASK);
            if ($this->db->affected_rows() > 0) {
                $return_result['customerEmail'] = 'Updated successfully';
            } else {
                $return_result['customerEmail'] = 'No value change';
            }
        }


        if (isset($data['taskDescription'])) {
            $up_data = array('task_description' => $data['taskDescription']);
            $this->taskUpdateData($up_data, $id, QM_TASK);
            if ($this->db->affected_rows() > 0) {
                $return_result['taskDescription'] = 'taskDescription Updated successfully';
            } else {
                $return_result['taskDescription'] = 'No value change';
            }
        }

        if (isset($data['customerMobile'])) {
            $up_data = array('customerMobile' => $data['customerMobile']);
            $this->taskUpdateData($up_data, $id, QM_TASK);
            if ($this->db->affected_rows() > 0) {
                $return_result['customerMobile'] = 'Updated successfully';
            } else {
                $return_result['customerMobile'] = 'No value change';
            }
        }

        if (isset($data['productName'])) {
            $up_data = array('productName' => $data['productName']);
            $this->taskUpdateData($up_data, $id, QM_TASK);
            if ($this->db->affected_rows() > 0) {
                $return_result['productName'] = ' Updated successfully';
            } else {
                $return_result['productName'] = ' No value change';
            }
        }

        if (isset($data['serialNumber'])) {
            $up_data = array('task_description' => $data['serialNumber']);
            $this->taskUpdateData($up_data, $id, QM_TASK);
            if ($this->db->affected_rows() > 0) {
                $return_result['serialNumber'] = 'Updated successfully';
            } else {
                $return_result['serialNumber'] = 'No value change';
            }
        }

        if (isset($data['productCode'])) {
            $up_data = array('productCode' => $data['productCode']);
            $this->taskUpdateData($up_data, $id, QM_TASK);
            if ($this->db->affected_rows() > 0) {
                $return_result['productCode'] = 'Updated successfully';
            } else {
                $return_result['productCode'] = 'No value change';
            }
        }

        $task_log = array('task_log' => json_encode($task_log_check),
            'task_name' => $id,
            'apiname' => 'Task Update WW APi',
            'api_response' => json_encode($return_result)
        );

        $this->db->insert('qm_task_create_log', $task_log);

        $return_results['msg'] = $return_result;
        $return_results['Status'] = "Success";
        $return_results['Code'] = 1;
        return $return_results;
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
        $datas_endocode = json_encode($return_val);
        $task_log = array('task_log' => $datas_endocode, 'task_name' => $error);
        $this->InsertData('qm_task_create_log', $task_log);
        return $return_val;
    }

    public function CreateTask($data) {
        $notification_d = $data;

        $datas_endocode = json_encode($data);
        $task_log = array('task_log' => $datas_endocode);

        $this->InsertData('qm_task_create_log', $task_log);

        if (isset($data['fseEmail'])) {
            $res = $this->SelectFSE($data['fseEmail'], QM_FSE_DETAILS);
            if ($res == FALSE) {
                return 'ERROR FSE Mail Not match';
                $fseDetails = array('fse_name' => $data['fseName'],
                    'fse_username' => $data['fseEmail'],
                    'fse_password' => $data['fseEmail'],
                    'fse_mobile' => $data['fseMobile'],
                    'fse_type_id' => 1,
                    'user_id' => 1,
                    'ent_id' => 1,
                    'fse_email' => $data['fseEmail']);
                // $fse_id = $this->InsertData(QM_FSE_DETAILS, $fseDetails,TRUE);
                //   $branch_id = 0;
                //   $ent_id = 1;
            } else {
                $fse_id = $res->id;
                $branch_id = $res->branch_id;
                $ent_id = $res->ent_id;
                $ent_id = $res->ent_id;
                $ent_id = $res->ent_id;
            }
        } else {
            return 'ERROR FSE Mail Not match';
            // $fse_id = SERVICE_NOW_DEFAULT_FSE_ID;
            //  $branch_id = "";
            // $ent_id = 1;
        }

        if (isset($data['incidentDetails'])) {

            $this->db->select('id');
            $this->db->from(QM_INCIDENT);
            $this->db->where('incident_name', trim($data['incidentDetails']));
            $this->db->order_by('id', 'DESC');
            $this->db->limit('1');
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $i_id = $query->row()->id;
            } else {
                $incdient = array('incident_name' => trim($data['incidentDetails']),
                    'ent_id' => $ent_id,
                    'status_id' => 1
                );
                $i_id = $this->InsertData(QM_INCIDENT, $incdient, TRUE);
            }
        } else {
            $i_id = NULL;
        }

        if (isset($data['sys_id'])) {
            $sys_id = $data['sys_id'];
        } else {
            $sys_id = NULL;
        }

        if (isset($data['customerEmail'])) {
            $customerEmail = $data['customerEmail'];
        } else {
            $customerEmail = NULL;
        }

        if (isset($data['customerMobile'])) {
            $customerMobile = $data['customerMobile'];
        } else {
            $customerMobile = NULL;
        }

        if (isset($data['problem1'])) {
            $problem1 = $data['problem1'];
        } else {
            $problem1 = NULL;
        }

        if (isset($data['problem2'])) {
            $problem2 = $data['problem2'];
        } else {
            $problem2 = NULL;
        }
        if (isset($data['location'])) {
            $location = $data['location'];
        } else {
            $location = NULL;
        }

        if (isset($data['taskStatus'])) {
            $this->db->select('id');
            $this->db->from(QM_STATUS_TYPE);
            $this->db->where('status_type', trim($data['taskStatus']));
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $status_ids = $query->row()->id;
            } else {
                $status_ids = 1;
            }
        } else {
            $status_ids = 1;
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
                return array('priority using wrong code .. Use below status Code', 'LOW', 'MEDIUM', 'HIGH', 'CRITICAL', 'PLANING');
            }
        }



        $task = array('fse_id' => $fse_id,
            'status_id' => $status_ids,
            'task_name' => trim($data['taskTitle']),
            'ent_id' => $ent_id,
            'sn_problem1' => $problem1,
            'sn_problem2' => $problem2,
            'sn_location' => $location,
            'branch_id' => $branch_id,
            'incident_id' => $i_id,
            'web_user_id' => 1,
            'customer_name' => $data['customerName'],
            'task_description' => $data['taskDescription'],
            'task_status' => 1,
            'priority' => $priority,
            'customer_contact_person' => $customerEmail,
            'customer_contact_number' => $customerMobile,
            'task_address' => urldecode($data['taskLocationAddress']),
            'product_name' => $data['productName'],
            'serial_number' => $data['serialNumber'],
            'product_code' => $data['productCode'],
            'productline' => $data['productline'],
            'sla_id' => 1,
            'task_type_id' => 1,
            'sys_id' => $sys_id
        );
        $this->db->select('id');
        $this->db->from(QM_TASK);
        $this->db->where('fse_id', trim($fse_id));
        $this->db->where('task_name', trim($data['taskTitle']));
        $this->db->where('incident_id', trim($i_id));
        $this->db->order_by('id', 'DESC');
        $this->db->limit('1');
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return "'Task Create Failed'... This task already in WorkWide";
        }
        $t_id = $this->InsertData(QM_TASK, $task);
        if ($t_id) {
            $tid = $this->db->insert_id();
        } else {
            return "Task Create Failed";
        }
        $device_type = $this->getFseDeviceType($fse_id);
        if (trim($device_type) == "iOS") {
            $this->send_ios_push($fse_id, $notification_d, $tid);
        } else {
            $this->send_android_push($fse_id, $notification_d, $tid);
        }
        $address_lang = NULL;
        //if (isset($data['googleMapLatitudeLongitude'])) {
        if (isset($data['taskLocationAddress'])) {
            $address_lang = NULL;
            $address = urldecode($data['taskLocationAddress']);
            $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
            $geo = json_decode($geo, true);
            if ($geo['status'] == 'OK') {
                $latitude = $geo['results'][0]['geometry']['location']['lat'];
                $longitude = $geo['results'][0]['geometry']['location']['lng'];
                $address_lang = '(' . $latitude . ', ' . $longitude . ')';
            }
        }
        $loca = array('task_location' => $address_lang, 'task_id' => $tid);
        $this->InsertData(QM_TASK_LOCATION, $loca);
        $return_data['taskid'] = $tid;
        $return_data['message'] = "Task Create Successfully";
        return $return_data;
    }

    public function CreateTasks($data) {
        $notification_d = $data;
        if (isset($data['fseEmail'])) {
            $res = $this->SelectFSE($data['fseEmail'], QM_FSE_DETAILS);
            if ($res == FALSE) {
                return 'ERROR FSE Mail Not match';
                $fseDetails = array('fse_name' => $data['fseName'],
                    'fse_username' => $data['fseEmail'],
                    'fse_password' => $data['fseEmail'],
                    'fse_mobile' => $data['fseMobile'],
                    'fse_type_id' => 1,
                    'user_id' => 1,
                    'ent_id' => 1,
                    'fse_email' => $data['fseEmail']);
                // $fse_id = $this->InsertData(QM_FSE_DETAILS, $fseDetails,TRUE);
                //   $branch_id = 0;
                //   $ent_id = 1;
            } else {
                $fse_id = $res->id;
                $branch_id = $res->branch_id;
                $ent_id = $res->ent_id;
                $ent_id = $res->ent_id;
                $ent_id = $res->ent_id;
            }
        } else {
            return 'ERROR FSE Mail Not match';
            // $fse_id = SERVICE_NOW_DEFAULT_FSE_ID;
            //  $branch_id = "";
            // $ent_id = 1;
        }

        if (isset($data['incidentDetails'])) {
            $incdient = array('incident_name' => $data['incidentDetails'],
                'ent_id' => $ent_id,
                'status_id' => 1
            );
            $i_id = $this->InsertData(QM_INCIDENT, $incdient, TRUE);
        } else {
            $i_id = NULL;
        }

        if (isset($data['customerEmail'])) {
            $customerEmail = $data['customerEmail'];
        } else {
            $customerEmail = NULL;
        }
        if (isset($data['customerMobile'])) {
            $customerMobile = $data['customerMobile'];
        } else {
            $customerMobile = NULL;
        }

        if (isset($data['problem1'])) {
            $problem1 = $data['problem1'];
        } else {
            $problem1 = NULL;
        }

        if (isset($data['problem2'])) {
            $problem2 = $data['problem2'];
        } else {
            $problem2 = NULL;
        }
        if (isset($data['location'])) {
            $location = $data['location'];
        } else {
            $location = NULL;
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
            } elseif (trim($data['priority']) == 'PLANING') {
                $priority = 5;
            } else {
                return array('priority using wrong code .. Use below status Code', 'LOW', 'MEDIUM', 'HIGH', 'CRITICAL', 'PLANING');
            }
        }

        $task = array('fse_id' => $fse_id,
            'status_id' => 1,
            'task_name' => $data['taskTitle'],
            'ent_id' => $ent_id,
            'sn_problem1' => $problem1,
            'sn_problem2' => $problem2,
            'sn_location' => $location,
            'branch_id' => $branch_id,
            'incident_id' => $i_id,
            'web_user_id' => 1,
            'customer_name' => $data['customerName'],
            'task_description' => $data['taskDescription'],
            'task_status' => 1,
            'customer_contact_person' => $customerEmail,
            'customer_contact_number' => $customerMobile,
            'task_address' => $data['taskLocationAddress'],
            'product_name' => $data['productName'],
            'serial_number' => $data['serialNumber'],
            'product_code' => $data['productCode'],
            'productline' => $data['productline'],
            'sla_id' => 1,
            'priority' => $priority,
            'task_type_id' => 1
        );
        $t_id = $this->InsertData(QM_TASK, $task);
        if ($t_id) {
            $tid = $this->db->insert_id();
        } else {
            return "Task Create Failed";
        }
        //if (isset($data['googleMapLatitudeLongitude'])) {
        if (isset($data['taskLocationAddress'])) {
            $address_lang = NULL;
            $address = urldecode($data['taskLocationAddress']);
            $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
            $geo = json_decode($geo, true);
            if ($geo['status'] == 'OK') {
                $latitude = $geo['results'][0]['geometry']['location']['lat'];
                $longitude = $geo['results'][0]['geometry']['location']['lng'];
                $address_lang = '(' . $latitude . ', ' . $longitude . ')';
            }

            $device_type = $this->getFseDeviceType($fse_id);
            if (trim($device_type) == "iOS") {
                $this->send_ios_push($fse_id, $notification_d, $tid);
            } else {
                $this->send_android_push($fse_id, $notification_d, $tid);
            }



            $loca = array('task_location' => $address_lang, 'task_id' => $tid);

            $this->InsertData(QM_TASK_LOCATION, $loca);
        }
        return "Task Create Successfully";
    }

    public function getFseDeviceIDs($id) {
        $this->db->select('fse_device_id');
        $this->db->from(QM_FSE_DETAILS);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function pushNotificationList($id) {
        $this->db->select(
                QM_MOBILE_NOTIFICATION . '.task_id,' .
                QM_MOBILE_NOTIFICATION . '.fse_id,' .
                QM_MOBILE_NOTIFICATION . '.message,' .
                QM_MOBILE_NOTIFICATION . '.title,' .
                QM_MOBILE_NOTIFICATION . '.is_viewed,' .
                QM_MOBILE_NOTIFICATION . '.updated_date,' .
                QM_STATUS_TYPE . '.id as status_id,' .
                QM_STATUS_TYPE . '.status_type as status_types,'
        );
        $this->db->from(QM_MOBILE_NOTIFICATION);
        $this->db->join(QM_TASK, QM_TASK . '.id = ' . QM_MOBILE_NOTIFICATION . '.task_id');
        $this->db->join(QM_STATUS_TYPE, QM_STATUS_TYPE . '.id = ' . QM_TASK . '.status_id');
        $this->db->where(QM_MOBILE_NOTIFICATION . '.fse_id', $id);
        $this->db->order_by(QM_MOBILE_NOTIFICATION . '.id', "DESC");
        $this->db->order_by(QM_MOBILE_NOTIFICATION . '.is_viewed', "DESC");
        //$this->db->group_by(QM_MOBILE_NOTIFICATION . '.is_viewed');
        $this->db->limit(20);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $query->result_array();

        // return $result;

        $data = array();
        if (!empty($result)) {
            foreach ($result as $value) {
                $value['created_date'] = date('Y-m-d', strtotime($value['updated_date']));
                $value['updated_date'] = date('Y-m-d', strtotime($value['updated_date']));
                $data[] = $value;
            }
        }
        return $data;
    }

    public function pushNotificationUnreadCount($id) {
        $this->db->select('*');
        $this->db->from(QM_MOBILE_NOTIFICATION);
        $this->db->where('fse_id', $id);
        $this->db->where('is_viewed', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function UpdateDataGeo($data, $id, $table) {
        $this->db->where('task_id', $id);
        $query = $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    public function productLine() {
        $this->db->select('*');
        $this->db->from(QM_PRODUCT_LINE);
        //$this->db->where('fse_id', $id);
        //$this->db->where('is_viewed', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function pushNotificationViewed($taskid = NULL, $is_viewed = NULL) {
        $data = array('is_viewed' => $is_viewed);
        $this->db->where('task_id', $taskid);
        $this->db->update(QM_MOBILE_NOTIFICATION, $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function pushNotificationRead($fse_id = NULL) {
        $data = array('is_viewed' => 1);
        $this->db->where('fse_id', $fse_id);
        $this->db->update(QM_MOBILE_NOTIFICATION, $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function base64Toimage() {
        $this->db->select('*');
        $this->db->from(QM_TASK_CUSTOMER_DOCUMENT);
        $this->db->where('upload_check !=', 1);
        $this->db->where('image_name', NULL);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function updateImageName($id = NULL, $photoname = NULL) {
        $datas = array('image_name' => $photoname);
        $this->db->where('id', $id);
        $this->db->update(QM_TASK_CUSTOMER_DOCUMENT, $datas);
    }

    public function pushImageToSN() {
        $this->db->select(QM_TASK_CUSTOMER_DOCUMENT . '.id,'
                . QM_TASK_CUSTOMER_DOCUMENT . '.task_id,'
                . QM_TASK_CUSTOMER_DOCUMENT . '.image_name,'
                . QM_TASK_CUSTOMER_DOCUMENT . '.upload_check,'
                . QM_TASK . '.task_name,'
                . QM_TASK . '.sys_id,'
        );
        $this->db->from(QM_TASK_CUSTOMER_DOCUMENT);
        $this->db->join(QM_TASK, QM_TASK_CUSTOMER_DOCUMENT . '.task_id = ' . QM_TASK . '.id', 'LEFT');
        $this->db->where(QM_TASK_CUSTOMER_DOCUMENT . '.upload_check != ', 1);
        $this->db->where(QM_TASK . '.sys_id !=', NULL);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function updateDocumentPushCompleted($id = NULL) {
        $datas = array('upload_check' => 1);
        ;
        $this->db->where('id', $id);
        $this->db->update(QM_TASK_CUSTOMER_DOCUMENT, $datas);
    }

    public function base64ToimageCustomer() {
        $this->db->select('customer_sign , id');
        $this->db->from(QM_TASK);
        $this->db->where('sys_id !=', NULL);
        $this->db->where('customer_sign_upload != ', 1);
        $this->db->where('customer_sign !=', NULL);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function updateCustomerSignPushed($id = NULL) {
        $datas = array('customer_sign_upload' => 1);
        $this->db->where('id', $id);
        $this->db->update(QM_TASK, $datas);
    }

    public function pushCustomerSignToSN() {
        $this->db->select('task_name,sys_id,id,'
        );
        $this->db->from(QM_TASK);
        $this->db->where('customer_sign_upload != ', 1);
        $this->db->where('sys_id !=', NULL);
        $this->db->where('customer_sign !=', NULL);
        $query = $this->db->get();
        return $query->result_array();
    }

    /* chinnarasu */

    public function taskCompleted($id = NULL) {
        $this->db->select(QM_TASK_TYPE . '.task_type,' . QM_TASK_TYPE . '.task_type_description,' . QM_TASK_TYPE . '.integrated_api,' . QM_TASK_TYPE . '.completed_screen_data');
        $this->db->from(QM_TASK_TYPE);

        $this->db->join(QM_TASK, QM_TASK_TYPE . '.id = ' . QM_TASK . '.task_type_id');
        $this->db->where(QM_TASK_TYPE . '.task_type_status', 1);

        if ($id) {
            $this->db->where(QM_TASK . '.id', $id);
        }
        $query = $this->db->get();
        $data = $query->result_array();
        unset($data[0]['integrated_api']);
        unset($data[0]['task_type_description']);
        return $data;
    }

    public function taskOnhold($id = NULL, $tab_type = NULL) {
        $this->db->select(QM_COMMANDS . '.command,');
        $this->db->from(QM_COMMANDS);
        $this->db->join(QM_TASK, QM_COMMANDS . '.task_type = ' . QM_TASK . '.task_type_id', 'LEFT');

        if ($id) {
            $this->db->where(QM_TASK . '.id', $id);
        }

        $this->db->where(QM_COMMANDS . '.task_type_tab_id', $tab_type);
        $query = $this->db->get();

        $data = $query->result_array();
        return $data;
    }

    public function task_list($userID = NULL, $statusType = NULL, $fromdashboard = NULL) {


        $this->db->select(QM_TASK . '.id,'
                . QM_TASK . '.task_name,'
                . QM_TASK . '.task_address,'
                . QM_TASK . '.task_type_id,'
                // . QM_TASK . '.fse_id,'
                . QM_TASK . '.status_id,'
                . QM_TASK . '.created_date,'
                . QM_TASK . '.updated_date,'
                . QM_FSE_DETAILS . '.fse_name,'
                . QM_STATUS_TYPE . '.status_type,'
                . QM_PRIORITY . '.priority_type,'
                . QM_TASK_TYPE . '.integrated_api'
        );
        $this->db->from(QM_TASK);
        $this->db->distinct(QM_TASK . '.id');
        $this->db->join(QM_FSE_DETAILS, QM_TASK . '.fse_id = ' . QM_FSE_DETAILS . '.id', 'LEFT');
        $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id = ' . QM_STATUS_TYPE . '.id', 'LEFT');
        $this->db->join(QM_PRIORITY, QM_TASK . '.priority = ' . QM_PRIORITY . '.id', 'LEFT');
        $this->db->join(QM_TASK_TYPE, QM_TASK . '.task_type_id = ' . QM_TASK_TYPE . '.id', 'left');
        $this->db->where(QM_TASK . '.task_status', 1);
        $this->db->where(QM_TASK . '.fse_id', trim($userID));
        if ($statusType != NULL) {
            $this->db->where(QM_TASK . '.status_id', trim($statusType));
            $this->db->order_by(QM_TASK . '.priority', "ASC");
        } else {
            $where = '(' . QM_TASK . '.status_id = 1 or ' . QM_TASK . '.status_id = 3 or ' . QM_TASK . '.status_id = 5)';
            $this->db->where($where);
            $this->db->order_by(QM_TASK . '.updated_date', "DESC");
        }


        $query = $this->db->get();
        $result = $query->result_array();
        $data = array();
        if (!empty($result)) {
            foreach ($result as $value) {

                //  $a3 = $this->extrafeildValueKey_taskList($value['id']);
                // $a3['category_data'] = extrafeildValueKey($value['id']);
                //$value = array_merge($value, $a3);
                $value['created_date'] = date('Y-m-d', strtotime($value['created_date']));
                $value['updated_date'] = date('Y-m-d', strtotime($value['created_date']));


                $data_api = json_decode($value['integrated_api']);
                if ($value['integrated_api']) {

                    $value['task_type_flow'] = $data_api->allow_for;
                    unset($value['integrated_api']);
                    // unset($value['task_type_flow']);
                }
                $value['OnholdDetails'] = $this->Offline_Onhold($value['task_type_id'], 8);
                $value['rejectDetails'] = $this->Offline_Onhold($value['task_type_id'], 9);
                $value['category_data'] = $this->extrafeildValueKey_taskList($value['id']);
                $a2 = $this->cat_tasklist($value['id']);
                $data[] = array_merge($value, $a2);
            }
        }
        return $data;
    }

    public function extrafeildValueKey_taskList($taskid = NULL) {

        if ($taskid == NULL) {
            return array();
        }

        $this->db->select(
                QM_EXTRA_ATTR_VALUES . '.Extra_attr_Values,'
                . QM_EXTRA_ATTR_DEFINITION . '. Ext_att_name,'
                . QM_EXTRA_ATTR_DEFINITION . '. Task_type_ID,'
                . QM_CATEGORY . '. category,'
                . QM_CATEGORY . '. separate_update_screen,'
                . QM_CATEGORY . '. id'
        );
        $this->db->from(QM_EXTRA_ATTR_VALUES);
        $this->db->join(QM_EXTRA_ATTR_DEFINITION, QM_EXTRA_ATTR_VALUES . '.Extra_attr_Def_id = ' . QM_EXTRA_ATTR_DEFINITION . '.extr_att_id');
        $this->db->join(QM_CATEGORY, QM_CATEGORY . '.id = ' . QM_EXTRA_ATTR_DEFINITION . '.Ext_att_category_id');
        $this->db->where(QM_EXTRA_ATTR_VALUES . '.Task_id', $taskid);
        $this->db->order_by(QM_CATEGORY . '.id', "asc");
        $query = $this->db->get();
        //\echo $this->db->last_query();
        //exit();
//        $result = $query->result_array();
//        $cat_array = $result2 = array();
//        $i = 0;
//        $category_id = 0;
//        foreach ($result as $data) {
//            
//            if ($data['id'] != $category_id) {
//                $i++;
//            }
//            $id = $data['category'];
//            $category_id = $data['id'];
//            $result2[$i][$data['Ext_att_name']] = $data['Extra_attr_Values'];
//            $result2[$i]['Category_name_Tab'] = $id;
//        }
//        
//        $res['category_data'][] = $result2;
//        
//        return $res;


        $result = $query->result_array();
        $cutFieldsKeyValue = array();
        if (!empty($result)) {
            foreach ($result as $value) {
                $cutFieldsKeyValue[$value['Ext_att_name']] = $value['Extra_attr_Values'];
                $cutFieldsKeyValue['Task_type_ID'] = $value['Task_type_ID'];
                $customFields['customFields'] = $cutFieldsKeyValue;
            }
        }
        $result2 = array();
        $result3 = array();
        $i = 0;
        $category_id = 0;
        foreach ($result as $data) {
            if ($data['id'] != $category_id) {
                $i++;
            }
            $id = $data['category'];
            $category_id = $data['id'];
            $id2 = $data['category'];
            //if (isset($result2[$id])) {
            $result2['category' . $i] = $id;
            $result2[$data['Ext_att_name']] = $data['Extra_attr_Values'];
        }

        $data_c = $this->tab_categories($taskid);
        $cat_array1 = array();
        $cat_array2 = array();
        $cat_array3 = array();
        if (!empty($data_c)) {
        foreach ($data_c as $keys => $values) {
            $req = "";
            $cat_array1[$values['id']] = $values['category'];
            $cat_array2[$values['category']] = $values['separate_update_screen'];
            if ($values['separate_update_screen'] == 1) {
                $req = $this->ApiModel->tab_categories_requried_fileds($values['id']);
            } else {
                $req = 0;
            }
            $cat_array3[$values['category']] = $req;
        }}
        $cat_array = array();
        $cat_array['1'] = $cat_array1;
        $cat_array['3'] = $cat_array3;
        $cat_array['2'] = $cat_array2;
        // $result2['category_detail'] = $cat_array;
        $categories = array();
        $categories = $result2;
        $customFields = array();
        // echo "<pre>";
        //print_r($categories);
        //echo "</pre>";
        //exit();
        return $categories;
    } 

    public function cat_tasklist($taskid = NULL) {
        $data = $this->tab_categories($taskid);
        $cat_array1 = array();
        $cat_array2 = array();
        $cat_array3 = array();
        foreach ($data as $key => $value) {
            if ($value['separate_update_screen'] == 1) {
                $req = $this->tab_categories_requried_fileds($value['id']);
            } else {
                $req = 0;
            }
            $cat_array1[$value['id']] = $value['category'];
            $cat_array3[$value['category']] = $req;
            $cat_array2[$value['category']] = $value['separate_update_screen'];
        }
        // $this->ApiModel->update_screen_cat($getArray['taskID']);
        $arry_catss = $cat_array = array();
        $cat_array['1'] = $cat_array1;
        $cat_array['2'] = $cat_array2;
        $cat_array['3'] = $cat_array3;
        //  $cat_array['3'] = $this->ApiModel->update_screen_cat($taskid);
        $arry_cat['category_detail'] = $cat_array;
        return $arry_cat;
    }

    public function taskDetailsGroupCategories($taskID = NULL, $tasktypeid = NULL) {


        $this->db->select(QM_TASK . '.id,'
                . QM_TASK . '.task_name,' . QM_TASK . '.task_address,'
                // . QM_TASK . '.task_type_id,'
                // . QM_TASK . '.fse_id,'
                //  . QM_TASK . '.status_id,'
                . QM_TASK . '.created_date,'
                . QM_FSE_DETAILS . '.fse_name,'
                . QM_STATUS_TYPE . '.status_type,'
                . QM_PRIORITY . '.priority_type,'
                . QM_TASK_TYPE . '.integrated_api'
        );
        $this->db->from(QM_TASK);
        $this->db->distinct(QM_TASK . '.id');
        $this->db->join(QM_FSE_DETAILS, QM_TASK . '.fse_id = ' . QM_FSE_DETAILS . '.id', 'LEFT');
        $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id = ' . QM_STATUS_TYPE . '.id', 'LEFT');
        $this->db->join(QM_PRIORITY, QM_TASK . '.priority = ' . QM_PRIORITY . '.id', 'LEFT');
        $this->db->join(QM_TASK_TYPE, QM_TASK . '.task_type_id = ' . QM_TASK_TYPE . '.id', 'left');
        if ($taskID != NULL) {
            $this->db->where(QM_TASK . '.id', $taskID);
        }
        if ($tasktypeid != NULL) {
            $this->db->where(QM_TASK . '.task_type_id', $tasktypeid);
        }

        $query = $this->db->get();
        $result = $query->result_array();

//        echo $this->db->last_query();
//        exit();

        $data = array();
        $i = 0;

        if (!empty($result)) {
            foreach ($result as $value) {
                $a2 = $this->extrafeildValueKey($value['id']);
                $data = array_merge($value, $a2);
                $i++;
            }
        }
        //unset($data[0]['id']);
        // print_r($data);
        return $data;
    }

    public function extrafeildValueKey($taskid = NULL) {

        if ($taskid == NULL) {
            return array();
        }

        $this->db->select(
                QM_EXTRA_ATTR_VALUES . '.Extra_attr_Values,'
                . QM_EXTRA_ATTR_DEFINITION . '. Ext_att_name,'
                . QM_EXTRA_ATTR_DEFINITION . '. Task_type_ID,'
                . QM_CATEGORY . '. category,'
                . QM_CATEGORY . '. separate_update_screen,'
                . QM_CATEGORY . '. id'
        );
        $this->db->from(QM_EXTRA_ATTR_VALUES);
        $this->db->join(QM_EXTRA_ATTR_DEFINITION, QM_EXTRA_ATTR_VALUES . '.Extra_attr_Def_id = ' . QM_EXTRA_ATTR_DEFINITION . '.extr_att_id');
        $this->db->join(QM_CATEGORY, QM_CATEGORY . '.id = ' . QM_EXTRA_ATTR_DEFINITION . '.Ext_att_category_id');
        $this->db->where(QM_EXTRA_ATTR_VALUES . '.Task_id', $taskid);
        $this->db->order_by(QM_CATEGORY . '.id', "asc");
        $query = $this->db->get();
        //\echo $this->db->last_query();
        //exit();
        $result = $query->result_array();
        $cutFieldsKeyValue = array();
        if (!empty($result)) {
            foreach ($result as $value) {
                $cutFieldsKeyValue[$value['Ext_att_name']] = $value['Extra_attr_Values'];
                $cutFieldsKeyValue['Task_type_ID'] = $value['Task_type_ID'];
                $customFields['customFields'] = $cutFieldsKeyValue;
            }
        }
        $result2 = array();
        $result3 = array();
        $i = 0;
        $category_id = 0;
        foreach ($result as $data) {
            if ($data['id'] != $category_id) {
                $i++;
            }
            $id = $data['category'];
            $category_id = $data['id'];
            $id2 = $data['category'];
            //if (isset($result2[$id])) {
            $result2['category' . $i] = $id;
            $result2[$data['Ext_att_name']] = $data['Extra_attr_Values'];
        }

        $data_c = $this->tab_categories($taskid);
        $cat_array1 = array();
        $cat_array2 = array();
        $cat_array3 = array();
        foreach ($data_c as $keys => $values) {
            $req = "";
            $cat_array1[$values['id']] = $values['category'];
            $cat_array2[$values['category']] = $values['separate_update_screen'];
            if ($value['separate_update_screen'] == 1) {
                $req = $this->ApiModel->tab_categories_requried_fileds($value['id']);
            } else {
                $req = 0;
            }
            $cat_array3[$value['category']] = $req;
        }
        $cat_array = array();
        $cat_array['1'] = $cat_array1;
        $cat_array['3'] = $cat_array3;
        $cat_array['2'] = $cat_array2;
        $result2['category_detail'] = $cat_array;
        $categories = array();
        $categories = $result2;
        $customFields = array();
        // echo "<pre>";
        //print_r($categories);
        //echo "</pre>";
        //exit();
        return $categories;
    }

    public function OfflineAssset($user_id = NULL) {

        $result = $result_in = array();
        $this->db->select('id,task_type_id');
        $this->db->from(QM_TASK);
        $this->db->where('fse_id', $user_id);
        $where = '(status_id= 1 or status_id = 3 or status_id = 5)';
        $this->db->where($where);
        $query = $this->db->get();
        $result['taskDetails'] = $query->result_array();
        $this->db->select('task_type_id');
        $this->db->from(QM_TASK);
        $this->db->where('fse_id', $user_id);
        $where = '(status_id = 1 or status_id = 3 or status_id = 5)';
        $this->db->where($where);
        $this->db->group_by('task_type_id');
        $this->db->order_by('task_type_id', 'desc');
        $query = $this->db->get();
        $result_data = $query->result_array();
        if (!empty($result_data)) {
            $i = 0;
            foreach ($result_data AS $re) {
                $result[$i]['task_type_id'] = $re['task_type_id'];
                $result[$i]['assetsDetails'] = $this->Offline_ASSETS($re['task_type_id']);
                $i++;
            }
            //echo $this->db->last_query();
            return $result;
        }
    }

    public function casorOffline($user_id = NULL) {

        $result = $result_in = array();
        $this->db->select('id,task_type_id');
        $this->db->from(QM_TASK);
        $this->db->where('fse_id', $user_id);
        $where = '(status_id= 1 or status_id = 3 or status_id = 5)';
        $this->db->where($where);
        $query = $this->db->get();
        $result['taskDetails'] = $query->result_array();
        $this->db->select('task_type_id , id');
        $this->db->from(QM_TASK);
        $this->db->where('fse_id', $user_id);
        $where = '(status_id = 1 or status_id = 3 or status_id = 5)';
        $this->db->where($where);
       // $this->db->group_by('task_type_id');
        $this->db->order_by('task_type_id', 'desc');
        $query = $this->db->get();
        $result_data = $query->result_array();
        if (!empty($result_data)) {
            $i = 0;
            foreach ($result_data AS $re) {
                $result[$i]['task_id'] = $re['id'];
                $result[$i]['task_type_id'] = $re['task_type_id'];
                $result[$i]['categoriesDetails'] = $this->Offline_tab_categories($re['task_type_id'],$re['id']);
                $result[$i]['completedScreenDetails'][0] = $this->Offline_CompletedScreen($re['task_type_id']);
                $result[$i]['statusMaskDetails'] = $this->Offline_StatusMask($re['task_type_id']);
               // $result[$i]['assetsDetails'] = $this->Offline_ASSETS($re['task_type_id']);
                $result[$i]['Integration_Status'][0] = $this->Offline_Integration_Status($re['task_type_id']);
                $result[$i]['OnholdDetails'] = $this->Offline_Onhold($re['task_type_id'], 8);
                $result[$i]['rejectDetails'] = $this->Offline_Onhold($re['task_type_id'], 9);
                $i++;
            }

            // echo $this->db->last_query();
            return $result;
        }
    }

    public function Offline_Integration_Status($task_typeid = NULL) {
        $this->db->select('integrated_api');
        $this->db->from(QM_TASK_TYPE);
        $this->db->where('id =', $task_typeid);
        $query = $this->db->get();
        return json_decode($query->row()->integrated_api);
    }

    public function Offline_tab_categories($task_typeid = NULL ,$taskid = NULL) {
        $this->db->select(QM_CATEGORY . '.id,'
                . QM_CATEGORY . '.category,'
                . QM_CATEGORY . '.separate_update_screen'
        );
        $this->db->from(QM_CATEGORY);
        $this->db->where(QM_CATEGORY . '.task_type =', $task_typeid);
        $this->db->where(QM_CATEGORY . '.category_status =', 1);
        $query = $this->db->get();
        $result = $query->result_array();
        $data = array();
        foreach ($result as $r) {

//            echo "<pre>";
//            print_r($r);
//            echo "</pre>";
            $result_array_s = $this->OfflineTaskUpdateScreen($task_typeid, $r['id'],$taskid);
            if (!empty($result_array_s)) {
                $data[] = $this->OfflineTaskUpdateScreen($task_typeid, $r['id'],$taskid);
            }
        }
        return $data;
    }

    public function OfflineTaskUpdateScreen($tasktypeid = NULL, $cat_id = NULL,$taskid) {


//        $this->db->select('post_data');
//        $this->db->from(QM_TASK_UPDATE);
//        $this->db->where('cat_id', trim($cat_id));
//        $this->db->where('task_id', trim($tasktypeid));
//        $this->db->limit('1');
//        $qur = $this->db->get();
//        $post_data = array();
//        if ($qur->num_rows() == 1) {
//            $post_d = json_decode($qur->row()->post_data);
//            foreach ($post_d AS $v) {
//                $post_data[$v->name] = $v->value;
//            }
//        }
        
        
        $this->db->select('Extra_attr_Values');
        $this->db->from(QM_EXTRA_ATTR_VALUES);
        $this->db->where('Extra_attr_Def_id', 27);
        $this->db->where('Task_id', $taskid);
        $this->db->limit('1');
        $que = $this->db->get();
        $product_line = NULL;
        if ($que->num_rows() == 1) {
            $product_line = $que->row()->Extra_attr_Values;
        }
        
        $this->db->select(QM_EXTRA_ATTR_UPDATE . '.*,'
                . QM_CATEGORY . '.category as category,'
                . QM_CATEGORY . '.separate_update_screen,'
                . QM_CATEGORY . '.id as cat_id'
        );
        $this->db->from(QM_EXTRA_ATTR_UPDATE);
        $this->db->join(QM_CATEGORY, QM_EXTRA_ATTR_UPDATE . '.category_id = ' . QM_CATEGORY . '.id', 'LEFT');
        $this->db->where(QM_EXTRA_ATTR_UPDATE . '.task_type =', $tasktypeid);
        $this->db->where(QM_EXTRA_ATTR_UPDATE . '.category_id =', $cat_id);
        $query = $this->db->get();
        $result = $query->result_array();
        $data = array();
        $i = 0;
        foreach ($result as $r) {
            if (isset($post_data[$r['id']])) {
                $post_values = $post_data[$r['id']];
            } else {
                $post_values = "";
            }
            $data[$i]['id'] = $r['id'];
            $data[$i]['label'] = $r['label'];
            $data[$i]['option_type'] = $r['option_type'];
            $data[$i]['type_limit'] = $r['type_limit'];
            $data[$i]['required_status'] = $r['required_status'];
            
            if ($r['option_type'] == "SELECT") {
                $data[$i]['type_values'] = $this->selectOptionValue($r['id'], $product_line, $r['depondid']);
            } else {
                $data[$i]['type_values'] = json_decode($r['type_values']);
            }
            // $data[$i]['type_values'] = json_decode($r['type_values']);
            $data[$i]['depondon'] = $r['depondon'];
            $data[$i]['depondid'] = $r['depondid'];
            $data[$i]['post_values'] = $post_values;
            $data[$i]['category'] = $r['category'];
            $data[$i]['separate_update_screen'] = $r['separate_update_screen'];
            $data[$i]['cat_id'] = $r['cat_id'];
            $i++;
        }
        //  echo $this->db->last_query();
        return $data;
    }

    public function Offline_Onhold($task_typeid = NULL, $tab_id = NULL) {
        $this->db->select('command');
        $this->db->from(QM_COMMANDS);
        $this->db->where('task_type_tab_id =', $tab_id);
        $this->db->where('task_type =', $task_typeid);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function Offline_ASSETS($task_typeid = NULL) {
        $this->db->select('display_name');
        $this->db->from(QM_SERVICE_NOW_ASSETS);
        $this->db->where('task_type =', $task_typeid);
        $this->db->limit('50');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function Offline_StatusMask($task_typeid = NULL) {
        $this->db->select('states_data');
        $this->db->from(QM_TASK_TYPE);
        $this->db->where('id =', $task_typeid);
        $query = $this->db->get();
        return json_decode($query->row()->states_data);
    }

    public function Offline_CompletedScreen($task_typeid = NULL) {
        $this->db->select('completed_screen_data');
        $this->db->from(QM_TASK_TYPE);
        $this->db->where('id =', $task_typeid);
        $query = $this->db->get();
        return json_decode($query->row()->completed_screen_data);
    }

    public function tab_comments($taskid = NULL) {
        $this->db->select(QM_CATEGORY . '.id,' . QM_CATEGORY . '.category,' . QM_CATEGORY . '.separate_update_screen'
        );
        $this->db->from(QM_TASK);
        $this->db->join(QM_CATEGORY, '(' . QM_CATEGORY . '.ent_id = ' . QM_TASK . '.ent_id AND ' . QM_CATEGORY . '.task_type = ' . QM_TASK . '.task_type_id' . ')');

        $this->db->where(QM_TASK . '.id =', $taskid);
        $this->db->where(QM_CATEGORY . '.category_status =', 1);

        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }

    public function update_screen_cat($taskid = NULL) {
        $this->db->select(QM_CATEGORY . '.id,'
                . QM_CATEGORY . '.category,'
                . QM_CATEGORY . '.separate_update_screen,'
                . QM_CATEGORY . '.task_type,'
                . QM_CATEGORY . '.ent_id,'
        );
        $this->db->from(QM_TASK);
        $this->db->join(QM_CATEGORY, '(' . QM_CATEGORY . '.ent_id = ' . QM_TASK . '.ent_id AND ' . QM_CATEGORY . '.task_type = ' . QM_TASK . '.task_type_id' . ')');
        $this->db->where(QM_TASK . '.id =', $taskid);
        $query = $this->db->get();
        //  echo $this->db->last_query();
        $result = $query->result_array();
        $result1 = array();
        if (!empty($result))
            foreach ($result as $key => $value) {
                if ($value['separate_update_screen'] == 0) {
                    $this->db->select(QM_EXTRA_ATTR_UPDATE . '.label,'
                            . QM_EXTRA_ATTR_UPDATE . '.option_type,'
                            . QM_EXTRA_ATTR_UPDATE . '.id,'
                            . QM_EXTRA_ATTR_UPDATE . '.depondon,'
                            . QM_EXTRA_ATTR_UPDATE . '.required_status,'
                            . QM_EXTRA_ATTR_UPDATE . '.type_values,'
                    );
                    $this->db->from(QM_EXTRA_ATTR_UPDATE);
                    //$this->db->join(QM_EXTRA_ATTR_UPDATE_VALUE, QM_EXTRA_ATTR_UPDATE . '.id = ' . QM_EXTRA_ATTR_UPDATE_VALUE . '.update_atr_id', 'LEFT');
                    $this->db->where(QM_EXTRA_ATTR_UPDATE . '.category_id =', $value['id']);
                    $query1 = $this->db->get();

                    if ($query1->num_rows() > 0) {
                        $result1[$value['category']] = $query1->result_array();
                    }
                }
            }
        return $result1;
    }

    public function tab_categories($taskid = NULL) {
        $this->db->select(QM_CATEGORY . '.id,'
                . QM_CATEGORY . '.category,'
                . QM_CATEGORY . '.separate_update_screen'
        );
        $this->db->from(QM_TASK);

        $this->db->join(QM_CATEGORY, '(' . QM_CATEGORY . '.ent_id = ' . QM_TASK . '.ent_id AND ' . QM_CATEGORY . '.task_type = ' . QM_TASK . '.task_type_id' . ')');
        $this->db->join(QM_EXTRA_ATTR_UPDATE, QM_EXTRA_ATTR_UPDATE . '.category_id = ' . QM_CATEGORY . '.id');

        $this->db->where(QM_TASK . '.id =', $taskid);
        //    $this->db->where(QM_CATEGORY . '.category_status =', 1);

        $query = $this->db->get();
        //  echo $this->db->last_query();
        return $query->result_array();
    }

    public function tab_categories_requried_fileds($category_id = NULL) {
        $this->db->select(QM_EXTRA_ATTR_UPDATE . '.id');
        $this->db->from(QM_EXTRA_ATTR_UPDATE);
        $this->db->where('category_id = ', $category_id);
        $this->db->where('required_status = ', 1);
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            return 0;
        } else {
            return 1;
        }
    }

    public function tabcategories_fields($catid = NULL, $taskid = NULL) {

        $query = $this->db->query("SELECT " . QM_EXTRA_ATTR_DEFINITION . ".*," . QM_CATEGORY . ".category,COALESCE((select " . QM_EXTRA_ATTR_VALUES . ".Extra_attr_Values from " . QM_EXTRA_ATTR_VALUES . " where " . QM_EXTRA_ATTR_VALUES . ".Extra_attr_Def_id=" . QM_EXTRA_ATTR_DEFINITION . ".extr_att_id AND " . QM_EXTRA_ATTR_VALUES . ".Task_id=" . $taskid . " limit 1),'') as attri_val FROM " . QM_EXTRA_ATTR_DEFINITION . " JOIN " . QM_CATEGORY . " ON " . QM_CATEGORY . ".id = " . QM_EXTRA_ATTR_DEFINITION . ".Ext_att_category_id WHERE " . QM_EXTRA_ATTR_DEFINITION . ".qm_status_type_id = 1 AND " . QM_CATEGORY . ".id =" . $catid . " AND " . QM_CATEGORY . ".separate_update_screen = 1");



        //$fields_array =array();
        foreach ($query->result() as $key => $value) {

            $fields_array[$key]['extr_att_id'] = $value->extr_att_id;
            $fields_array[$key]['value'] = $value->Ext_att_name;
            $fields_array[$key]['type'] = $value->Ext_att_type;
            $fields_array[$key]['attri_value'] = $value->attri_val;

            //echo '<pre>';
            // print_r($value);
        }



        return $fields_array;
    }

    public function updatetab_catigoriesfield($data = NULL) {

        $query = null; //emptying in case 


        if ($data) {
            $Task_id = $data['taskid'];

            $arr = json_decode($data['postData']);
            $coun_arr = count($arr);
            $i = 1;
            foreach ($arr as $key => $value) {

                //confirmed  to sathish
                $data = array(
                    'Extra_attr_Def_id' => $value->name,
                    'Task_id' => $Task_id
                );
                $query = $this->db->get_where(QM_EXTRA_ATTR_VALUES, $data);

                $count = $query->num_rows(); //counting result from query



                if ($count === 0) {
                    $task_type_id = $this->Select_task_type($Task_id, QM_TASK);
                    $data = array(
                        'Extra_attr_Def_id' => $value->name,
                        'Task_id' => $Task_id,
                        'task_type_id' => $task_type_id,
                        'Extra_attr_Values' => $value->value,
                    );
                    $this->db->insert(QM_EXTRA_ATTR_VALUES, $data);

                    //return TRUE;
                } else {

                    $update_data = array(
                        'Extra_attr_Values' => $value->value
                    );

                    $this->db->where(QM_EXTRA_ATTR_VALUES . '.Extra_attr_Def_id', $value->name);
                    $this->db->where(QM_EXTRA_ATTR_VALUES . '.Task_id', $Task_id);
                    $this->db->update(QM_EXTRA_ATTR_VALUES, $update_data);
                    //echo $this->db->last_query();
                    //return TRUE;
                }
                if ($i++ == $coun_arr) {
                    return 'Successfully Updated';
                }
            }
        } else {
            return FALSE;
        }
    }

    public function updateTaskScreen($taskid = NULL, $cat_id = NULL) {

        $this->db->select(QM_EXTRA_ATTR_UPDATE . '.*,'
                . QM_CATEGORY . '.category as category'
        );
        $this->db->from(QM_EXTRA_ATTR_UPDATE);
        $this->db->join(QM_TASK, QM_TASK . '.task_type_id = ' . QM_EXTRA_ATTR_UPDATE . '.task_type', 'LEFT');
        $this->db->join(QM_CATEGORY, QM_EXTRA_ATTR_UPDATE . '.category_id = ' . QM_CATEGORY . '.id', 'LEFT');
        $this->db->where(QM_TASK . '.id =', $taskid);
        $this->db->where(QM_EXTRA_ATTR_UPDATE . '.category_id =', $cat_id);
        $query = $this->db->get();
        $result = $query->result_array();
        $data = array();
        $i = 0;
        if (empty($result)) {
            return TRUE;
        }

        $this->db->select('Extra_attr_Values');
        $this->db->from(QM_EXTRA_ATTR_VALUES);
        $this->db->where('Extra_attr_Def_id', 27);
        $this->db->where('Task_id', $taskid);
        $this->db->limit('1');
        $que = $this->db->get();
        $product_line = "";
        if ($que->num_rows() == 1) {
            $product_line = $que->row()->Extra_attr_Values;
        }

        foreach ($result as $r) {

            $this->db->select(QM_EXTRA_ATTR_UPDATE_VALUE . '.value');
            $this->db->from(QM_EXTRA_ATTR_UPDATE_VALUE);
            $this->db->where('update_atr_id', $r['id']);
            $this->db->where('cat_id', $cat_id);
            $this->db->where('task_id', $taskid);
            $this->db->order_by(QM_EXTRA_ATTR_UPDATE_VALUE . '.id', 'DESC');
            $this->db->limit('1');
            $querys = $this->db->get();
            if ($querys->num_rows() == 1) {
                $post_values = $querys->row()->value;
            } else {

                $post_values = "";
            }

            $data[$i]['id'] = $r['id'];
            $data[$i]['label'] = $r['label'];
            $data[$i]['option_type'] = $r['option_type'];
            $data[$i]['type_limit'] = $r['type_limit'];
            $data[$i]['required_status'] = $r['required_status'];
            if ($r['option_type'] == "SELECT") {
                $data[$i]['type_values'] = $this->selectOptionValue($r['id'], $product_line, $r['depondid']);
            } else {
                $data[$i]['type_values'] = json_decode($r['type_values']);
            }
            // $data[$i]['type_values'] = json_decode($r['type_values']);
            $data[$i]['depondon'] = $r['depondon'];
            $data[$i]['depondid'] = $r['depondid'];
            $data[$i]['post_values'] = $post_values;
            $data[$i]['category'] = $r['category'];
            $i++;
        }
        //  echo $this->db->last_query();
        return $data;
    }

    public function selectOptionValue($id = NULL, $search = NULL, $depondid = NULL) {

        $this->db->select('option_value');
        $this->db->from(QM_SELECT_VALUE);
        $this->db->where('select_option_id', trim($id));
        if ($depondid != NULL) {
            $this->db->where('depond_value', trim($search));
        }
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $i = 0;
            foreach ($result as $r) {
                $data[$i] = $r['option_value'];
                $i++;
            }
        }
        return $data;
    }

    public function getAutoCompleteSelectOption($id = NULL, $search = NULL) {

        $this->db->select('option_value, depond_value');
        $this->db->from(QM_SELECT_VALUE);
        $this->db->where('select_option_id', trim($id));
        if ($search != NULL) {
            $this->db->where('depond_value', urldecode($search));
        }
        $query = $this->db->get();
        //   echo $this->db->last_query();
        $data = array();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $i = 0;

            if ($search == NULL) {
                foreach ($result as $r) {
                    $data[$i]['option_value'] = $r['option_value'];
                    $data[$i]['depond_value'] = $r['depond_value'];
                    $i++;
                }
            } else {
                foreach ($result as $r) {
                    $data[$i] = $r['option_value'];
                    $i++;
                }
            }
        }
        return $data;
    }

    /* chinnarasu */

    public function updateTaskScreens($taskid = NULL, $cat_id = NULL) {


        $this->db->select('post_data');
        $this->db->from(QM_TASK_UPDATE);
        $this->db->where('cat_id', trim($cat_id));
        $this->db->where('task_id', trim($taskid));
        $this->db->limit('1');
        $qur = $this->db->get();
        $post_data = array();
        if ($qur->num_rows() == 1) {
            $post_d = json_decode($qur->row()->post_data);
            foreach ($post_d AS $v) {
                $post_data[$v->name] = $v->value;
            }
        }
        $this->db->select(QM_EXTRA_ATTR_UPDATE . '.*,'
                . QM_CATEGORY . '.category as category'
        );
        $this->db->from(QM_EXTRA_ATTR_UPDATE);
        $this->db->join(QM_TASK, QM_TASK . '.task_type_id = ' . QM_EXTRA_ATTR_UPDATE . '.task_type', 'LEFT');
        $this->db->join(QM_CATEGORY, QM_EXTRA_ATTR_UPDATE . '.category_id = ' . QM_CATEGORY . '.id', 'LEFT');
        $this->db->where(QM_TASK . '.id =', $taskid);
        $this->db->where(QM_EXTRA_ATTR_UPDATE . '.category_id =', $cat_id);
        $query = $this->db->get();
        $result = $query->result_array();
        $data = array();
        $i = 0;
        foreach ($result as $r) {
            if (isset($post_data[$r['id']])) {
                $post_values = $post_data[$r['id']];
            } else {
                $post_values = "";
            }
            $data[$i]['id'] = $r['id'];
            $data[$i]['label'] = $r['label'];
            $data[$i]['option_type'] = $r['option_type'];
            $data[$i]['type_limit'] = $r['type_limit'];
            $data[$i]['required_status'] = $r['required_status'];
            $data[$i]['type_values'] = json_decode($r['type_values']);
            $data[$i]['post_values'] = $post_values;
            $data[$i]['category'] = $r['category'];
            $i++;
        }
        //  echo $this->db->last_query();
        return $data;
    }

    public function taskStatusAsset($taskid = NULL) {
        $task_type_id = $this->Select_task_type($taskid, QM_TASK);
        $this->db->select('integrated_api');
        $this->db->from(QM_TASK_TYPE);
        $this->db->where('id', trim($task_type_id));
        $this->db->limit('1');
        $qur = $this->db->get();
        $post_data = array();
        if ($qur->num_rows() == 1) {
            $post_d = json_decode($qur->row()->integrated_api);
            return $post_d;
        } else {
            return FALSE;
        }
    }

    public function updateTaskScreenData_old($taskid = NULL, $cat_id = NULL, $data = NULL) {

        $task_type_id = $this->Select_task_type($taskid, QM_TASK);
        $this->db->where('task_id', $taskid);
        $this->db->where('cat_id', $cat_id);
        $this->db->where('task_type_id', $task_type_id);
        $this->db->delete(QM_TASK_UPDATE);

        $data = array(
            'task_id' => $taskid,
            'cat_id' => $cat_id,
            'task_type_id' => $task_type_id,
            'post_data' => $data,
        );
        return $this->db->insert(QM_TASK_UPDATE, $data);
    }

    public function casorOfflineSave($result = NULL) {
        $result = json_decode($result);
        if (empty($result)) {
            return FALSE;
        }

        if (isset($result->id)) {
            $task_id = @$result->id;
            $fse_name = @$result->fse_name;
            $task_type_id = @$result->task_type_id;
            $status_id = @$result->status_id;
            $created_date = @$result->created_date;
            $updated_date = @$result->updated_date;
            $status_type = @$result->status_type;
            $z_Total_time_offline = @$result->z_Total_time_offline;
            $z_offline_signature = @$result->z_offline_signature;
            $z_offline_rating = @$result->z_offline_rating;
            $z_onhold_and_comment = @$result->z_onhold_and_comment;
            $z_reject_and_comment = @$result->z_reject_and_comment;
            $z_Assets_data = @$result->z_Assets_data;
            $z_Total_repair_time_offline = @$r->z_Total_repair_time_offline;
            $z_category_data = json_decode(@$result->z_category_data);
            $update_data = array();
            $update_data['kilometer_travelled'] = $z_Total_time_offline;
            $update_data['status_id'] = $status_id;
            $update_data['updated_date'] = $updated_date;
            $update_data['customer_sign'] = $z_offline_signature;
            $update_data['fseRating'] = $z_offline_rating;
            $update_data['fse_reason'] = $z_onhold_and_comment;
            $update_data['fse_feedback'] = $z_reject_and_comment;
            $update_data['capture_assets'] = $z_Assets_data;
            $this->db->where(QM_TASK . '.id', $task_id);
            $this->db->update(QM_TASK, $update_data);
            $dataoftime = array('total_travel_time' => $z_Total_time_offline,
                'total_worked_time' => $z_Total_repair_time_offline);
            $this->db->where(QM_TASK_LOCATION . '.task_id', $task_id);
            $this->db->update(QM_TASK_LOCATION, $dataoftime);
            $capt['task_table'][$task_id] = $update_data;
            if (!empty($z_category_data)) {
                foreach ($z_category_data as $c) {
                    $this->db->select(QM_EXTRA_ATTR_UPDATE . '.category_id,'
                            . QM_EXTRA_ATTR_UPDATE . '.option_type');
                    $this->db->from(QM_EXTRA_ATTR_UPDATE);
                    $this->db->where('id', $c->name);
                    $querys = $this->db->get();

                    if ($querys->num_rows() == 1) {
                        $category_id = $querys->row()->category_id;
                        $check_option = $querys->row()->option_type;
                    } else {
                        $category_id = "";
                        $check_option = "";
                    }
                    $this->db->where('type_id', $task_type_id);
                    $this->db->where('cat_id', $category_id);
                    $this->db->where('update_atr_id', $c->name);
                    $this->db->where('task_id', $task_id);
                    $this->db->delete(QM_EXTRA_ATTR_UPDATE_VALUE);
                    $data = array();
                    $data['type_id'] = $task_type_id;
                    $data['cat_id'] = $category_id;
                    $data['update_atr_id'] = $c->name;
                    $data['task_id'] = $task_id;
                    $va = $c->value;
                    if ($check_option == "SWITCH") {
                        if ($va == "on") {
                            $va = "YES";
                        } else {
                            $va = "NO";
                        }
                    }
                    $data['value'] = $va;

                    //    $data['value'] = $c->value;
                    $insert_id = $this->InsertData(QM_EXTRA_ATTR_UPDATE_VALUE, $data);
                }
            }
            $this->thirdpartUpatetimeFeedback($task_id);
            $this->thirdpartApiUpdate($task_id);
        } else {
            foreach ($result as $r) {
                $task_id = @$r->id;
                $fse_name = @$r->fse_name;
                $task_type_id = @$r->task_type_id;
                $status_id = @$r->status_id;
                $created_date = @$r->created_date;
                $updated_date = @$r->updated_date;
                $status_type = @$r->status_type;
                $z_Total_time_offline = @$r->z_Total_time_offline;
                $z_category_data = @$r->z_category_data;
                $z_offline_signature = @$r->z_offline_signature;
                $z_offline_rating = @$r->z_offline_rating;
                $z_onhold_and_comment = @$r->z_onhold_and_comment;
                $z_reject_and_comment = @$r->z_reject_and_comment;
                $z_category_data = json_decode(@$r->z_category_data);
                $z_Assets_data = @$r->z_Assets_data;
                $z_Total_repair_time_offline = @$r->z_Total_repair_time_offline;
                $update_data = array();
                $update_data['kilometer_travelled'] = $z_Total_time_offline;
                $update_data['status_id'] = $status_id;
                $update_data['updated_date'] = $updated_date;
                $update_data['customer_sign'] = $z_offline_signature;
                $update_data['fseRating'] = $z_offline_rating;
                $update_data['fse_reason'] = $z_onhold_and_comment;
                $update_data['fse_feedback'] = $z_reject_and_comment;
                $update_data['capture_assets'] = $z_Assets_data;
                $this->db->where(QM_TASK . '.id', $task_id);
                $this->db->update(QM_TASK, $update_data);

                $dataoftime = array('total_travel_time' => $z_Total_time_offline,
                    'total_worked_time' => $z_Total_repair_time_offline);
                $this->db->where(QM_TASK_LOCATION . '.task_id', $task_id);
                $this->db->update(QM_TASK_LOCATION, $dataoftime);

                $capt['task_table'][$task_id] = $update_data;
                if (!empty($z_category_data)) {
                    foreach ($z_category_data as $c) {
                        $this->db->select(QM_EXTRA_ATTR_UPDATE . '.category_id,'
                                . QM_EXTRA_ATTR_UPDATE . '.option_type');
                        $this->db->from(QM_EXTRA_ATTR_UPDATE);
                        $this->db->where('id', $c->name);
                        $querys = $this->db->get();
                        if ($querys->num_rows() == 1) {
                            $check_option = $querys->row()->option_type;
                            $category_id = $querys->row()->category_id;
                        } else {
                            $check_option = "";
                            $category_id = "";
                        }
                        $this->db->where('type_id', $task_type_id);
                        $this->db->where('cat_id', $category_id);
                        $this->db->where('update_atr_id', $c->name);
                        $this->db->where('task_id', $task_id);
                        $this->db->delete(QM_EXTRA_ATTR_UPDATE_VALUE);
                        $data = array();
                        $data['type_id'] = $task_type_id;
                        $data['cat_id'] = $category_id;
                        $data['update_atr_id'] = $c->name;
                        $data['task_id'] = $task_id;
                        $va = $c->value;
                        if ($check_option == "SWITCH") {
                            if ($va == "on") {
                                $va = "YES";
                            } else {
                                $va = "NO";
                            }
                        }
                        $data['value'] = $va;
                        //   $data['value'] = $c->value;
                        $insert_id = $this->InsertData(QM_EXTRA_ATTR_UPDATE_VALUE, $data);
                    }
                }
                $this->thirdpartUpatetimeFeedback($task_id);
                $this->thirdpartApiUpdate($task_id);
            }
        }
        return TRUE;
    }

    public function updateTaskScreenData($taskid = NULL, $cat_id = NULL, $data = NULL) {
        $task_type_id = $this->Select_task_type($taskid, QM_TASK);
        $result = json_decode($data);

//        echo "<pre>";
//        print_r($result);

        if (empty($result)) {
            return FALSE;
        }
        if (!empty($result)) {
            foreach ($result as $c) {
                $this->db->select(QM_EXTRA_ATTR_UPDATE . '.category_id,'
                        . QM_EXTRA_ATTR_UPDATE . '.option_type');
                $this->db->from(QM_EXTRA_ATTR_UPDATE);
                $this->db->where('id', $c->name);
                $querys = $this->db->get();

                if ($querys->num_rows() == 1) {
                    $check_option = $querys->row()->option_type;
                } else {
                    $check_option = "";
                }
                $this->db->where('type_id', $task_type_id);
                $this->db->where('cat_id', $cat_id);
                $this->db->where('update_atr_id', $c->name);
                $this->db->where('task_id', $taskid);
                $this->db->delete(QM_EXTRA_ATTR_UPDATE_VALUE);
                $data = array();
                $data['type_id'] = $task_type_id;
                $data['cat_id'] = $cat_id;
                $data['update_atr_id'] = $c->name;
                $data['task_id'] = $taskid;
                $va = $c->value;
                if ($check_option == "SWITCH") {
                    if ($va == "on") {
                        $va = "YES";
                    } else {
                        $va = "NO";
                    }
                }
                $data['value'] = $va;
                // $data['value'] = $c->value;
                $insert_id = $this->InsertData(QM_EXTRA_ATTR_UPDATE_VALUE, $data);

                //  echo $this->db->last_query();
                //  $capt['update_value_table'][$c->name] = $data;
            }
        }

        return TRUE;
    }

    public function offlineData() {
        $task_id = 11;
        $task_type_id = 11;
        $cat_id = 25;

        $this->db->select('post_data');
        $this->db->from(QM_TASK_UPDATE);
        $this->db->where('id', 3);
        $this->db->limit('1');
        $query = $this->db->get();
        $result = $query->result_array();
        $result = json_decode($result[0]['post_data']);
        echo "<pre>";
        print_r($result);
        if (!empty($result)) {
            foreach ($result as $c) {
                $this->db->select(QM_EXTRA_ATTR_UPDATE . '.category_id');
                $this->db->from(QM_EXTRA_ATTR_UPDATE);
                $this->db->where('id', $c->name);
                $query = $this->db->get();
                $res = $query->row();
                $this->db->where('type_id', $task_type_id);
                $this->db->where('cat_id', $cat_id);
                $this->db->where('update_atr_id', $c->name);
                $this->db->where('task_id', $task_id);
                $this->db->delete(QM_EXTRA_ATTR_UPDATE_VALUE);
                $data = array();
                $data['type_id'] = $task_type_id;
                $data['cat_id'] = $cat_id;
                $data['update_atr_id'] = $c->name;
                $data['task_id'] = $task_id;
                $data['value'] = $c->value;
                $insert_id = $this->InsertData(QM_EXTRA_ATTR_UPDATE_VALUE, $data);
                $capt['update_value_table'][$c->name] = $data;
            }
        }

        print_r($capt);

        echo "</pre>";
    }

    public function offlineDatas() {
        $this->db->select('data');
        $this->db->from(QM_OFFLINE_MOBILE_DATA);
        $this->db->where('id', 98);
        $this->db->limit('1');
        $query = $this->db->get();
        $result = $query->result_array();
        $result = json_decode($result[0]['data']);
        echo "<pre>";
        print_r($result);


        exit();
        $capt = array();

        foreach ($result as $r) {
            echo "<br> ============================== <br>";
            //    print_r($r);

            $task_id = $r->id;
            $fse_name = $r->fse_name;
            $task_type_id = $r->task_type_id;
            $status_id = $r->status_id;
            $created_date = $r->created_date;
            $updated_date = $r->updated_date;
            $status_type = $r->status_type;
            $z_Total_time_offline = $r->z_Total_time_offline;
            $z_category_data = $r->z_category_data;
            $z_offline_signature = $r->z_offline_signature;
            $z_offline_rating = $r->z_offline_rating;
            $z_category_data = json_decode($r->z_category_data);
            $update_data = array();
            $update_data['kilometer_travelled'] = $z_Total_time_offline;
            $update_data['status_id'] = $status_id;
            $update_data['updated_date'] = $updated_date;
            $update_data['customer_sign'] = $z_offline_signature;
            $update_data['fseRating'] = $z_offline_rating;
            $this->db->where(QM_TASK . '.id', $task_id);
            $this->db->update(QM_TASK, $update_data);
            $capt['task_table'][$task_id] = $update_data;
            echo $this->db->last_query();
//            print_r($z_category_data);
            if (!empty($z_category_data)) {
                foreach ($z_category_data as $c) {
                    $this->db->select(QM_EXTRA_ATTR_UPDATE . '.category_id');
                    $this->db->from(QM_EXTRA_ATTR_UPDATE);
                    $this->db->where('id', $c->name);
                    $query = $this->db->get();
                    $res = $query->row();
                    $this->db->where('type_id', $task_type_id);
                    $this->db->where('cat_id', $res->category_id);
                    $this->db->where('update_atr_id', $c->name);
                    $this->db->where('task_id', $task_id);
                    $this->db->delete(QM_EXTRA_ATTR_UPDATE_VALUE);
                    $data = array();
                    $data['type_id'] = $task_type_id;
                    $data['cat_id'] = $res->category_id;
                    $data['update_atr_id'] = $c->name;
                    $data['task_id'] = $task_id;
                    $data['value'] = $c->value;
                    $insert_id = $this->InsertData(QM_EXTRA_ATTR_UPDATE_VALUE, $data);
                    $capt['update_value_table'][$task_id] = $data;
                }
            }
        }

        print_r($capt);

        echo "</pre>";
    }

}
