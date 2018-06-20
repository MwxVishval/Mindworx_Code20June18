<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ManagementModel extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function login($username, $password) {
        $query = $this->db->query('SELECT * FROM ' . QM_WEB_ACCESS . ' WHERE web_username = "' . $username . '"  AND web_password = "' . $password . '";');
        if ($query->num_rows() == 1) {
            $row = $query->row_array();
            $session_data = $this->data;
            $session_data->user_id = $row['id'];
            $session_data->name = $row['web_name'];
            $session_data->branch_id = $row['branch_id'];
            $session_data->user_type = $row['user_type'];
            $session_data->email = $row['web_email'];
            $session_data->ent_id = $row['ent_id'];
            $this->session->set_userdata('session_data', $session_data);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Check Username and Password !!!');
            redirect('/');
        }
    }

    public function company_add($data) {
        $table = QM_ENTITY;
        unset($data['submit']);
        $data['user_id'] = $this->session->userdata('session_data')->user_id;
        return $this->InsertData($table, $data, TRUE);
        /* if ($check == 1) {
          redirect('entity');
          } */
    }

    public function entityAdmin($data) {
        $table = QM_USER_ASSIGN_ENTITY;
        $data['created_by'] = $this->session->userdata('session_data')->user_id;
        return $this->InsertData($table, $data, TRUE);
        /* if ($check == 1) {
          redirect('entity');
          } */
    }

    public function company_update($id) {
        $table = QM_ENTITY;
        return $this->SelectWhere($id, $table);
    }

    public function company_edit($id, $data) {
        $table = QM_ENTITY;
        unset($data['ent_id']);
        unset($data['submit']);
        return $this->UpdateData($data, $id, $table);
    }

    public function getuserType() {
        $this->db->select('id,web_user_type');
        $this->db->from(QM_WEB_USER_TYPE);
        $this->db->where(QM_WEB_USER_TYPE . '.web_user_status', 1);
        $this->db->order_by(QM_WEB_USER_TYPE . '.id', 'DESC');
        if ($this->session->userdata('session_data')->is_admin == 1) {
            // $where = QM_WEB_ACCESS . ".ent_id =" . $this->session->userdata('session_data')->ent_id;
            //$this->db->where($where);
        } elseif ($this->session->userdata('session_data')->is_entity_admin == 1) {
            $this->db->where(QM_WEB_USER_TYPE . ".ent_id =" . $this->session->userdata('session_data')->ent_id);
        } else {
            $this->db->where(QM_WEB_USER_TYPE . ".created_by_id =" . $this->session->userdata('session_data')->user_id);
        }
        $query = $this->db->get();
        $result = $query->result();
        $id = array('');
        $web_user_type = array(
            '--Select--'
        );
        for ($i = 0; $i < count($result); $i++) {
            array_push($id, $result[$i]->id);
            array_push($web_user_type, $result[$i]->web_user_type);
        }
        return array_combine($id, $web_user_type);
    }

    public function getuserTypes() {
        $query = $this->db->query("SELECT id,web_user_type FROM " . QM_WEB_USER_TYPE . " WHERE web_user_status=1 AND created_by_id = " . $this->session->userdata('session_data')->user_id);
        $result = $query->result();
        $id = array('');
        $web_user_type = array(
            '--Select--'
        );
        for ($i = 0; $i < count($result); $i++) {
            array_push($id, $result[$i]->id);
            array_push($web_user_type, $result[$i]->web_user_type);
        }
        return array_combine($id, $web_user_type);
    }

    public function getEntityType() {

        if ($this->session->userdata('session_data')->is_admin != 1) {
            $where = "id = " . $this->session->userdata('session_data')->ent_id . " AND status=1";
        } else {
            $where = "status=1";
        }
        $query = $this->db->query("SELECT id,ent_name FROM " . QM_ENTITY . " WHERE " . $where);
        $result = $query->result();
        $id = array(
            ''
        );
        $ent_name = array(
            '--Select--'
        );
        for ($i = 0; $i < count($result); $i++) {
            array_push($id, $result[$i]->id);
            array_push($ent_name, $result[$i]->ent_name);
        }
        return array_combine($id, $ent_name);
    }

    public function getSLAName() {

        $query = $this->db->query("SELECT id,sla_name FROM " . QM_SLA . " WHERE sla_status=1");
        $result = $query->result();
        $id = array(
            ''
        );
        $sla_name = array(
            '--Select--'
        );
        for ($i = 0; $i < count($result); $i++) {
            array_push($id, $result[$i]->id);
            array_push($sla_name, $result[$i]->sla_name);
        }
        return array_combine($id, $sla_name);
    }

    public function getStatusType() {

        if ($this->session->userdata('session_data')->is_admin != 1) {
            //   $where = "ent_id = " . $this->session->userdata('session_data')->ent_id . " AND status_stat=1";
            $where = "status_stat=1";
        } else {
            $where = "status_stat=1";
        }
        $query = $this->db->query("SELECT id,status_type FROM " . QM_STATUS_TYPE . " WHERE " . $where);
        $result = $query->result();
        $id = array(
            ''
        );
        $status_type = array(
            '--Select--'
        );
        for ($i = 0; $i < count($result); $i++) {
            array_push($id, $result[$i]->id);
            array_push($status_type, $result[$i]->status_type);
        }
        return array_combine($id, $status_type);
    }

    public function getCustomerType() {

        $query = $this->db->query("SELECT id,cus_name FROM " . QM_CUSTOMER_DETAILS . " WHERE cus_status=1");
        $result = $query->result();
        $id = array(
            ''
        );
        $cus_name = array(
            '--Select--'
        );
        for ($i = 0; $i < count($result); $i++) {
            array_push($id, $result[$i]->id);
            array_push($cus_name, $result[$i]->cus_name);
        }
        return array_combine($id, $cus_name);
    }

    public function getFSETypes() {

        if ($this->session->userdata('session_data')->is_admin != 1) {
            $where = "ent_id = " . $this->session->userdata('session_data')->ent_id . " AND fse_type_status=1";
        } else {
            $where = "fse_type_status=1";
        }
        $query = $this->db->query("SELECT id,fse_type FROM " . QM_FSE_TYPE . " WHERE " . $where);
        $result = $query->result_array();        
        return $result;
    }

    public function getFSEType() {

        if ($this->session->userdata('session_data')->is_admin != 1) {
            $where = "ent_id = " . $this->session->userdata('session_data')->ent_id . " AND fse_type_status=1";
        } else {
            $where = "fse_type_status=1";
        }
        $query = $this->db->query("SELECT id,fse_type FROM " . QM_FSE_TYPE . " WHERE " . $where);
        $result = $query->result();
        $id = array(
            ''
        );
        $fse_type = array(
            '--Select--'
        );
        for ($i = 0; $i < count($result); $i++) {
            array_push($id, $result[$i]->id);
            array_push($fse_type, $result[$i]->fse_type);
        }
        return array_combine($id, $fse_type);
    }

    public function getFSETypeBySearchTerm($searchTerm) {

        if ($this->session->userdata('session_data')->is_admin != 1) {
            $where = "ent_id = " . $this->session->userdata('session_data')->ent_id . " AND fse_type_status=1" .
                    " fase_type LIKE " % ".$searchTerm." % "";
        } else {
            $where = "fse_type_status=1 and fse_type like '%" . $searchTerm . "%'";
        }
        $query = $this->db->query("SELECT id,fse_type FROM " . QM_FSE_TYPE . " WHERE " . $where);


        foreach ($query->result_array() as $k => $row) {
            $row_set[$k]['label'] = htmlentities(stripslashes($row['fse_type']));
            $row_set[$k]['key'] = htmlentities(stripslashes($row['id']));
        }

        echo json_encode($row_set);
    }

    public function getFseTypeAuto() {

        if ($this->session->userdata('session_data')->is_admin != 1) {
            $where = "ent_id = " . $this->session->userdata('session_data')->ent_id . " AND fse_type_status=1";
        } else {
            $where = "fse_type_status=1 ";
        }
        $query = $this->db->query("SELECT id,fse_type FROM " . QM_FSE_TYPE . " WHERE " . $where);


        foreach ($query->result_array() as $k => $row) {
            $row_set[$k]['id'] = htmlentities(stripslashes($row['id']));
            $row_set[$k]['name'] = htmlentities(stripslashes($row['fse_type']));
        }

        echo json_encode($row_set);
    }

    public function getBranchype() {

        if ($this->session->userdata('session_data')->is_admin != 1) {
            $where = "ent_id = " . $this->session->userdata('session_data')->ent_id . " AND branch_status=1";
        } else {
            $where = "branch_status=1";
        }
        $query = $this->db->query("SELECT id,branch_name FROM " . QM_BRANCH . " WHERE " . $where);
        $result = $query->result();
        $id = array(
            ''
        );
        $branch_name = array(
            '--Select--'
        );
        for ($i = 0; $i < count($result); $i++) {
            array_push($id, $result[$i]->id);
            array_push($branch_name, $result[$i]->branch_name);
        }
        return array_combine($id, $branch_name);
    }

    public function getZoneName() {
        $query = $this->db->query("SELECT zone_id,zone_name FROM " . QM_ZONE);
        $result = $query->result();
        $zone_id = array(
            ''
        );
        $zone_name = array(
            '--Select--'
        );
        for ($i = 0; $i < count($result); $i++) {
            array_push($zone_id, $result[$i]->zone_id);
            array_push($zone_name, $result[$i]->zone_name);
        }
        return array_combine($zone_id, $zone_name);
    }

    public function getAssetCategory() {
        $query = $this->db->query("SELECT id,equp_category  FROM " . QM_ASSET_CATEGORY . " WHERE category_status=1");
        $result = $query->result();
        $id = array(
            ''
        );
        $equp_category = array(
            '--Select--'
        );
        for ($i = 0; $i < count($result); $i++) {
            array_push($id, $result[$i]->id);
            array_push($equp_category, $result[$i]->equp_category);
        }
        return array_combine($id, $equp_category);
    }

    public function company() {
        // $query = $this->db->query("SELECT * FROM " . QM_ENTITY . " WHERE status=1 ORDER BY ent_name ASC;");
        $this->db->select('*');
        $this->db->from(QM_ENTITY);
        $this->db->where(QM_ENTITY . '.status', 1);
        if ($this->session->userdata('session_data')->is_admin == 1) {
            
        } elseif ($this->session->userdata('session_data')->entity_admin == $this->session->userdata('session_data')->user_id) {
            $this->db->where(QM_ENTITY . '.id', $this->session->userdata('session_data')->ent_id);
        } else {
            return FALSE;
        }
        $this->db->order_by(QM_ENTITY . '.ent_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function apiSetting() {
        $this->db->select(QM_API_SETTING . '.*,' . QM_ENTITY . '.ent_name');
        $this->db->from(QM_API_SETTING);
        $this->db->join(QM_ENTITY, QM_API_SETTING . '.ent_id = ' . QM_ENTITY . '.id');
        $this->db->order_by(QM_API_SETTING . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function apiSetting_add($data) {
        $table = QM_API_SETTING;
        unset($data['submit']);
        $check = $this->InsertData($table, $data);
    }

    public function apiSetting_update($id) {
        $table = QM_API_SETTING;
        return $this->SelectWhere($id, $table);
    }

    public function apiSetting_edit($id, $data) {
        $table = QM_API_SETTING;
        unset($data['id']);
        unset($data['submit']);
        return $this->UpdateData($data, $id, $table);
    }

    public function branch_add($data) {
        $table = QM_BRANCH;
        unset($data['branch_id']);
        unset($data['submit']);
        $data['user_id'] = $this->session->userdata('session_data')->user_id;
        $check = $this->InsertData($table, $data);
        /* if ($check == 1) {
          redirect('branch');
          } */
    }

    public function branch() {
        $this->db->select(QM_BRANCH . '.id,' . QM_BRANCH . '.ent_id,' . QM_ENTITY . '.ent_name,' . QM_BRANCH . '.branch_name,' . QM_BRANCH . '.branch_location');
        $this->db->from(QM_BRANCH);
        $this->db->join(QM_ENTITY, QM_BRANCH . '.ent_id = ' . QM_ENTITY . '.id');
        $this->db->order_by(QM_BRANCH . '.id', 'DESC');
        $this->db->where(QM_BRANCH . '.branch_status', 1);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_BRANCH . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function branch_update($id) {
        $table = QM_BRANCH;
        return $this->SelectWhere($id, $table);
    }

    public function branch_edit($id, $data) {
        $table = QM_BRANCH;
        unset($data['id']);
        unset($data['submit']);
        return $this->UpdateData($data, $id, $table);
    }
    
    
     public function getFselist($id) {
        $table = QM_FSE_DETAILS_ENGINEERS;
        $query = $this->db->select(QM_FSE_TYPE . '.fse_type');
        $query = $this->db->from(QM_FSE_DETAILS_ENGINEERS);
        $query =  $this->db->join(QM_FSE_TYPE, QM_FSE_DETAILS_ENGINEERS . '.fse_type_id = ' . QM_FSE_TYPE . '.id');
        $query = $this->db->where(QM_FSE_DETAILS_ENGINEERS . '.fse_details_id = ' . $id);
        $query = $this->db->get();
        $obj = $query->result_array();
        if($obj){
        $n = count($obj);
        for ($i = 0; $i < $n; $i++) {
            $string[$i] = implode(',', $obj[$i]);
        }
        $string_version = implode(',', $string);

        return $string_version;
        }
        else 
            return "";
    }

    public function serviceEngineer() {
        $this->db->select(QM_FSE_DETAILS . '.id,' .  QM_FSE_DETAILS . '.fse_name,' . QM_FSE_DETAILS . '.fse_username,' . QM_FSE_DETAILS . '.fse_password,' . QM_FSE_DETAILS . '.user_id,' . QM_FSE_DETAILS . '.fse_email,' . QM_FSE_DETAILS . '.fse_mobile,' . QM_FSE_DETAILS . '.fse_address,' . QM_FSE_DETAILS . '.fse_status,' . QM_FSE_DETAILS . '.ent_id,' . QM_FSE_DETAILS . '.branch_id,' . QM_ENTITY . '.ent_name,' . QM_BRANCH . '.branch_name,' );
        $this->db->from(QM_FSE_DETAILS);
        $this->db->join(QM_ENTITY, QM_FSE_DETAILS . '.ent_id = ' . QM_ENTITY . '.id', 'LEFT');
        $this->db->join(QM_BRANCH, QM_FSE_DETAILS . '.branch_id = ' . QM_BRANCH . '.id', 'LEFT');
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_FSE_DETAILS . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_FSE_DETAILS . '.fse_status', 1);
        $this->db->order_by(QM_FSE_DETAILS . '.id', 'DESC');
        $query = $this->db->get();
        $obj = $query->result_array();
        foreach($obj as $k => $data)
        {
            $obj[$k]['fse_type']=$this->getFselist($data['id']);
        }
       return $obj;
       // var_dump($obj);die;
    }


//    public function serviceEngineer() {
//        $this->db->select(QM_FSE_DETAILS . '.id,' . QM_FSE_DETAILS . '.fse_type_id,' . QM_FSE_DETAILS . '.fse_name,' . QM_FSE_DETAILS . '.fse_username,' . QM_FSE_DETAILS . '.fse_password,' . QM_FSE_DETAILS . '.user_id,' . QM_FSE_DETAILS . '.fse_email,' . QM_FSE_DETAILS . '.fse_mobile,' . QM_FSE_DETAILS . '.fse_address,' . QM_FSE_DETAILS . '.fse_status,' . QM_FSE_DETAILS . '.ent_id,' . QM_FSE_DETAILS . '.branch_id,' . QM_ENTITY . '.ent_name,' . QM_BRANCH . '.branch_name,' . QM_FSE_TYPE . '.fse_type');
//        $this->db->from(QM_FSE_DETAILS);
//        $this->db->join(QM_FSE_TYPE, QM_FSE_DETAILS . '.fse_type_id = ' . QM_FSE_TYPE . '.id');
//        $this->db->join(QM_ENTITY, QM_FSE_DETAILS . '.ent_id = ' . QM_ENTITY . '.id', 'LEFT');
//        $this->db->join(QM_BRANCH, QM_FSE_DETAILS . '.branch_id = ' . QM_BRANCH . '.id', 'LEFT');
//        if ($this->session->userdata('session_data')->is_admin != 1) {
//            $this->db->where(QM_FSE_DETAILS . '.ent_id', $this->session->userdata('session_data')->ent_id);
//        }
//        $this->db->where(QM_FSE_DETAILS . '.fse_status', 1);
//        $this->db->order_by(QM_FSE_DETAILS . '.id', 'DESC');
//        $query = $this->db->get();
//        return $query->result_array();
//    }

    public function fse_add($data) {
        $table = QM_FSE_DETAILS;
        if ($data['optradio'] == 'branchDiv') {
            $data['ent_id'] = $this->branchToEntity($data['branch_id']);
        }
        unset($data['service_id']);
        unset($data['fse_type_id']);
        unset($data['fse_type']);
        unset($data['submit']);
        unset($data['fse_cpassword']);
        unset($data['optradio']);
        $data['fse_photo'] = 'iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAMAAADDpiTIAAADAFBMV
EUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAACzMPSIAAAA/3RSTlMAAQIDBAUGBwgJCgsMDQ4PEBESExQVFhcYGRobHB0eHyAhIiMkJ
SYnKCkqKywtLi8wMTIzNDU2Nzg5Ojs8PT4/QEFCQ0RFRkdISUpLTE1OT1BRUlNUVVZXWFlaW1xd
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';
        $data['user_id'] = $this->session->userdata('session_data')->user_id;

        $check = $this->InsertData($table, $data);

        /* if ($check == 1) {
          redirect('serviceEngineer');
          } */
    }
    
    public function fseEngineers_delete($id) {
        $this->db->where('fse_details_id', $id);
        return $this->db->delete(QM_FSE_DETAILS_ENGINEERS);
    }

    public function fseEngineers_add($data) {
        $table = QM_FSE_DETAILS_ENGINEERS;
        $check = $this->InsertData($table, $data);
        //     echo $this->db->last_query();die;
    }

    public function getenginerrslist($id) {
        $table = QM_FSE_DETAILS_ENGINEERS;
        $query = $this->db->select(QM_FSE_DETAILS_ENGINEERS . '.fse_type_id,');
        $query = $this->db->from(QM_FSE_DETAILS_ENGINEERS);
        $query = $this->db->where(QM_FSE_DETAILS_ENGINEERS . '.fse_details_id = ' . $id);
        $query = $this->db->get();
        $obj = $query->result_array();
        if ($obj){
        $n = count($obj);
        for ($i = 0; $i < $n; $i++) {
            $string[$i] = implode(',', $obj[$i]);
        }
        $string_version = implode(',', $string);

        return $string_version;
        }else 
            return "";
    }

    public function fse_update($id) {
        $table = QM_FSE_DETAILS;
//        return $this->SelectWhere($id, $table);        
        $query = $this->db->select(QM_FSE_DETAILS . '.*,');
        $query = $this->db->from(QM_FSE_DETAILS);
        $query = $this->db->where(QM_FSE_DETAILS . '.id = ' . $id);
        $query = $this->db->get();
        $obj = $query->result_array();
        foreach ($obj as $k => $data) {
            $obj[$k]['fse_list'] = $this->getenginerrslist($data['id']);
        }
      
        return $obj;
    }

    public function fse_edit($id, $data) {
        $table = QM_FSE_DETAILS;
        //print_r($data); die;
        if ($data['optradio'] == 'branchDiv') {
            $data['ent_id'] = $this->branchToEntity($data['branch_id']);
        }
        unset($data['id']);
        unset($data['submit']);
        unset($data['fse_cpassword']);
        unset($data['optradio']);

        return $this->UpdateData($data, $id, $table);
        $sql = $this->db->last_query();
    }

    function checkFSEemail($email) {
        $result = $this->db->get_where(QM_FSE_DETAILS, array(
                    'fse_email' => $email
                ))->result_array();

        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function checkFSEuser($username) {
        $result = $this->db->get_where(QM_FSE_DETAILS, array(
                    'fse_username' => $username
                ))->result_array();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function checkFSEName($fsename) {
        $result = $this->db->get_where(QM_FSE_DETAILS, array(
                    'fse_name' => $fsename
                ))->result_array();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function fse_delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete(QM_FSE_DETAILS);
    }

    public function fse_unblock($id, $data) {
        $table = QM_FSE_DETAILS;
        unset($data['id']);
        unset($data['submit']);
        return $this->UpdateData($data, $id, $table);
        $sql = $this->db->last_query();
    }

    public function fse_block($id, $data) {
        $table = QM_FSE_DETAILS;
        unset($data['id']);
        unset($data['submit']);
        return $this->UpdateData($data, $id, $table);
        $sql = $this->db->last_query();
    }

    public function fse_resetpassword($id) {
        $this->db->select('*');
        $this->db->from(QM_FSE_DETAILS);
        $this->db->where('id', $id);
        $query = $this->db->get();
        /* foreach ($query->result() as $my_info) {
          $db_password = $my_info->password;
          $db_id = $my_info->user_id;
          } */
        $sql = $this->db->last_query();
        $newPassword = $this->input->post('fse_new_password');
        $id = $this->input->post('id');
        echo $newPassword;
        echo $id;
        //echo $fixed_password; 
        /* $this->db->where('user_id', $db_id);
          $this->db->update('tbl_usrs', $fixed_password); */
        /* $this->db->set('password', $fixed_password); //value that used to update column  
          $this->db->where('user_id', $db_id); //which row want to upgrade
          $this->db->update('tbl_usrs');  //
          $sql = $this->db->last_query();
          $updatePass = $query->result_array();
          print_r($sql);
          //echo $db_password;
          //echo $db_id;
          //echo $sql;
          //print_r($this->input->post('opassword'));
          /*if(($this->input->post('opassword',$db_password) == $db_password) && ($this->input->post('npassword') != '') && ($this->input->post('cpassword') != ''))
          {
          $fixed_password = $this->input->post('npassword');
          //echo $fixed_password;
          /*$this->db->where('user_id', $db_id);
          $this->db->update('tbl_usrs', $fixed_password); */
        /* $this->db->set('password', $fixed_password); //value that used to update column  
          $this->db->where('user_id', $db_id); //which row want to upgrade
          $this->db->update('tbl_usrs');  //
          $sql = $this->db->last_query();
          $updatePass = $query->result_array();
          return $updatePass;
          } */
    }

    public function fseType() {
        $this->db->select(QM_FSE_TYPE . '.id,' . QM_FSE_TYPE . '.fse_type,' . QM_FSE_TYPE . '.fse_description');
        $this->db->from(QM_FSE_TYPE);
        $this->db->where(QM_FSE_TYPE . '.fse_type_status', 1);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_FSE_TYPE . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->order_by(QM_FSE_TYPE . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function fseType_add($data) {
        $table = QM_FSE_TYPE;
        unset($data['user_id']);
        unset($data['submit']);
        $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        $check = $this->InsertData($table, $data);
        /* if ($check == 1) {
          redirect('asset');
          } */
    }

    public function fseType_update($id) {
        $table = QM_FSE_TYPE;
        return $this->SelectWhere($id, $table);
    }

    function checkFSEType($fseType) {
        $result = $this->db->get_where(QM_FSE_TYPE, array(
                    'fse_type' => $fseType
                ))->result_array();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function fsePassword_reset($id, $data) {
        $table = QM_FSE_DETAILS;
        //print_r($data); die;
        $this->load->library('email');
        $this->email->from(TO_EMAIL);
        $this->email->to($data['fse_email']);
        $this->email->subject('Qmobility Password Reset');
        $message = $this->load->view('email/resetadminPassword', $data, TRUE);
        $this->email->message($message);
        $this->email->send();
        unset($data['id']);
        unset($data['fse_confirm_password']);
        unset($data['fse_email']);
        unset($data['fse_username']);
        unset($data['Btnsubmit']);
        //print_r($data); die;
        return $this->UpdateData($data, $id, $table);
    }

    public function fseType_edit($id, $data) {
        $table = QM_FSE_TYPE;
        unset($data['id']);
        unset($data['submit']);
        $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        return $this->UpdateData($data, $id, $table);
    }

    public function customer() {
        $query = $this->db->select(QM_CUSTOMER_DETAILS . '.id,' . QM_CUSTOMER_DETAILS . '.ent_id,' . QM_CUSTOMER_DETAILS . '.branch_id,' . QM_CUSTOMER_DETAILS . '.cus_name,' . QM_CUSTOMER_DETAILS . '.cus_username,' . QM_CUSTOMER_DETAILS . '.cus_pass,' . QM_CUSTOMER_DETAILS . '.cus_email,' . QM_CUSTOMER_DETAILS . '.cus_phone,' . QM_CUSTOMER_DETAILS . '.cus_address,' . QM_BRANCH . '.branch_name');
        $query = $this->db->from(QM_CUSTOMER_DETAILS);
        $query = $this->db->join(QM_ENTITY, QM_CUSTOMER_DETAILS . '.ent_id = ' . QM_ENTITY . '.id', 'LEFT');
        $query = $this->db->join(QM_BRANCH, QM_CUSTOMER_DETAILS . '.branch_id = ' . QM_BRANCH . '.id', 'LEFT');
        $query = $this->db->where(QM_CUSTOMER_DETAILS . '.cus_status', 1);
        $this->db->order_by(QM_CUSTOMER_DETAILS . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function customer_add($data) {
        $table = QM_CUSTOMER_DETAILS;
        unset($data['service_id']);
        unset($data['submit']);
        unset($data['cus_cpass']);
        unset($data['optradio']);
        $data['user_id'] = $this->session->userdata('session_data')->user_id;
        $check = $this->InsertData($table, $data);
        /* if ($check == 1) {
          redirect('customer');
          } */
    }

    public function customer_update($id) {
        $table = QM_CUSTOMER_DETAILS;
        return $this->SelectWhere($id, $table);
    }

    public function customer_edit($id, $data) {
        $table = QM_CUSTOMER_DETAILS;
        unset($data['id']);
        unset($data['submit']);
        unset($data['cus_cpass']);
        unset($data['optradio']);
        return $this->UpdateData($data, $id, $table);
    }

    function checkCustomeremail($email) {
        $result = $this->db->get_where(QM_CUSTOMER_DETAILS, array(
                    'cus_email' => $email
                ))->result_array();

        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function checkCustomerUser($username) {
        $result = $this->db->get_where(QM_CUSTOMER_DETAILS, array(
                    'cus_username' => $username
                ))->result_array();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function asset() {
        $query = $this->db->select(QM_ASSET . '.id,' . QM_ASSET . '.equp_category_id,' . QM_ASSET . '.ent_id,' . QM_ASSET . '.branch_id,' . QM_ASSET . '.equp_name,' . QM_ASSET . '.equp_quantity,' . QM_ASSET . '.equp_serial_number,' . QM_ASSET . '.equp_description,' . QM_ASSET_CATEGORY . '.equp_category,' . QM_ENTITY . '.ent_name,' . QM_BRANCH . '.branch_name');
        $query = $this->db->from(QM_ASSET);
        $query = $this->db->join(QM_ASSET_CATEGORY, QM_ASSET . '.equp_category_id = ' . QM_ASSET_CATEGORY . '.id');
        $query = $this->db->join(QM_BRANCH, QM_ASSET . '.branch_id = ' . QM_BRANCH . '.id', 'LEFT');
        $query = $this->db->join(QM_ENTITY, QM_ASSET . '.ent_id = ' . QM_ENTITY . '.id', 'LEFT');
        $this->db->order_by(QM_ASSET . '.id', 'DESC');
        $query = $this->db->where(QM_ASSET . '.equp_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function asset_add($data) {
        $table = QM_ASSET;
        unset($data['optradio']);
        unset($data['submit']);
        $data['user_id'] = $this->session->userdata('session_data')->user_id;
        $check = $this->InsertData($table, $data);
        /* if ($check == 1) {
          redirect('asset');
          } */
    }

    public function asset_update($id) {
        $table = QM_ASSET;
        return $this->SelectWhere($id, $table);
    }

    public function asset_edit($id, $data) {

        $table = QM_ASSET;
        unset($data['id']);
        unset($data['submit']);
        unset($data['optradio']);
        return $this->UpdateData($data, $id, $table);
    }

    function checkAssetName($equp_name) {
        $result = $this->db->get_where(QM_ASSET, array(
                    'equp_name' => $equp_name
                ))->result_array();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function assetcategory() {
        $query = $this->db->select(QM_ASSET_CATEGORY . '.id,' . QM_ASSET_CATEGORY . '.equp_category,' . QM_ASSET_CATEGORY . '.equp_category_description');
        $query = $this->db->from(QM_ASSET_CATEGORY);
        $query = $this->db->where(QM_ASSET_CATEGORY . '.category_status', 1);
        $this->db->order_by(QM_ASSET_CATEGORY . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function assetcategory_add($data) {
        $table = QM_ASSET_CATEGORY;
        unset($data['user_id']);
        unset($data['submit']);
        $check = $this->InsertData($table, $data);
        /* if ($check == 1) {
          redirect('asset');
          } */
    }

    public function assetcategory_update($id) {
        $table = QM_ASSET_CATEGORY;
        return $this->SelectWhere($id, $table);
    }

    public function assetcategory_edit($id, $data) {
        $table = QM_ASSET_CATEGORY;
        unset($data['id']);
        unset($data['submit']);
        return $this->UpdateData($data, $id, $table);
    }

    function checkAssetCategory($equpCategory) {
        $result = $this->db->get_where(QM_ASSET_CATEGORY, array(
                    'equp_category' => $equpCategory
                ))->result_array();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function statusType() {
        $query = $this->db->select(QM_STATUS_TYPE . '.id,' . QM_STATUS_TYPE . '.status_type,' . QM_STATUS_TYPE . '.status_description');
        $query = $this->db->from(QM_STATUS_TYPE);
        $this->db->order_by(QM_STATUS_TYPE . '.id', 'DESC');
        $query = $this->db->where(QM_STATUS_TYPE . '.status_stat', 1);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_STATUS_TYPE . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function statusType_add($data) {
        $table = QM_STATUS_TYPE;
        unset($data['user_id']);
        unset($data['submit']);
        $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        $check = $this->InsertData($table, $data);
        /* if ($check == 1) {
          redirect('asset');
          } */
    }

    public function statusType_update($id) {
        $table = QM_STATUS_TYPE;
        return $this->SelectWhere($id, $table);
    }

    public function statusType_edit($id, $data) {
        $table = QM_STATUS_TYPE;
        unset($data['id']);
        unset($data['submit']);
        $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        return $this->UpdateData($data, $id, $table);
    }

    function checkStatusType($statusType) {
        $result = $this->db->get_where(QM_STATUS_TYPE, array(
                    'status_type' => $statusType
                ))->result_array();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function callstatusType() {
        $query = $this->db->select(QM_CALL_STATUS_TYPE . '.id,' . QM_CALL_STATUS_TYPE . '.callstatus_type,' . QM_CALL_STATUS_TYPE . '.callstatus_description');
        $query = $this->db->from(QM_CALL_STATUS_TYPE);
        $this->db->order_by(QM_CALL_STATUS_TYPE . '.id', 'DESC');
        $query = $this->db->where(QM_CALL_STATUS_TYPE . '.callstatus_stat', 1);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_CALL_STATUS_TYPE . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function callstatusType_add($data) {
        $table = QM_CALL_STATUS_TYPE;
        unset($data['user_id']);
        unset($data['submit']);
        $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        $check = $this->InsertData($table, $data);
        /* if ($check == 1) {
          redirect('asset');
          } */
    }

    public function callstatusType_update($id) {
        $table = QM_CALL_STATUS_TYPE;
        return $this->SelectWhere($id, $table);
    }

    public function callstatusType_edit($id, $data) {
        $table = QM_CALL_STATUS_TYPE;
        unset($data['id']);
        unset($data['submit']);
        $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        return $this->UpdateData($data, $id, $table);
    }

    function checkCallStatusType($callstatusType) {
        $result = $this->db->get_where(QM_CALL_STATUS_TYPE, array(
                    'callstatus_type' => $callstatusType
                ))->result_array();
        $str = $this->db->last_query();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function callType() {
        $query = $this->db->select(QM_CALL_TYPE . '.id,' . QM_CALL_TYPE . '.calltype_type,' . QM_CALL_TYPE . '.calltype_description');
        $query = $this->db->from(QM_CALL_TYPE);
        $this->db->order_by(QM_CALL_TYPE . '.id', 'DESC');
        $query = $this->db->where(QM_CALL_TYPE . '.calltype_stat', 1);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_CALL_TYPE . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function callType_add($data) {
        $table = QM_CALL_TYPE;
        unset($data['user_id']);
        unset($data['submit']);
        $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        $check = $this->InsertData($table, $data);
        /* if ($check == 1) {
          redirect('asset');
          } */
    }

    public function callType_update($id) {
        $table = QM_CALL_TYPE;
        return $this->SelectWhere($id, $table);
    }

    public function callType_edit($id, $data) {
        $table = QM_CALL_TYPE;
        unset($data['id']);
        unset($data['submit']);
        $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        return $this->UpdateData($data, $id, $table);
    }

    function checkCallType($callsType) {
        $result = $this->db->get_where(QM_CALL_TYPE, array(
                    'calltype_type' => $callsType
                ))->result_array();
        $str = $this->db->last_query();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function priorityType() {
        $query = $this->db->select(QM_PRIORITY . '.id,' . QM_PRIORITY . '.priority_type,' . QM_PRIORITY . '.priority_description');
        $query = $this->db->from(QM_PRIORITY);
        $this->db->order_by(QM_PRIORITY . '.id', 'DESC');
        $query = $this->db->where(QM_PRIORITY . '.priority_stat', 1);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            //  $this->db->where(QM_PRIORITY . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function priorityType_add($data) {
        $table = QM_PRIORITY;
        unset($data['user_id']);
        unset($data['submit']);
        $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        $check = $this->InsertData($table, $data);
        /* if ($check == 1) {
          redirect('asset');
          } */
    }

    public function priorityType_update($id) {
        $table = QM_PRIORITY;
        return $this->SelectWhere($id, $table);
    }

    public function priorityType_edit($id, $data) {
        $table = QM_PRIORITY;
        unset($data['id']);
        unset($data['submit']);
        $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        return $this->UpdateData($data, $id, $table);
    }

    function checkPriorityType($priorityType) {
        $result = $this->db->get_where(QM_PRIORITY, array(
                    'priority_type' => $priorityType
                ))->result_array();
        $str = $this->db->last_query();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function incident() {
        $query = $this->db->select(QM_INCIDENT . '.id,' . QM_INCIDENT . '.customer_id,' . QM_INCIDENT . '.ent_id,' . QM_INCIDENT . '.incident_name,' . QM_INCIDENT . '.incident_created_date,' . QM_STATUS_TYPE . '.status_type,' . QM_ENTITY . '.ent_name');
        $query = $this->db->from(QM_INCIDENT);
        // $query = $this->db->join(QM_CUSTOMER_DETAILS, QM_INCIDENT . '.customer_id = ' . QM_CUSTOMER_DETAILS . '.id');
        $query = $this->db->join(QM_BRANCH, QM_INCIDENT . '.branch_id = ' . QM_BRANCH . '.id', 'LEFT');
        $query = $this->db->join(QM_ENTITY, QM_INCIDENT . '.ent_id = ' . QM_ENTITY . '.id', 'LEFT');
        $query = $this->db->join(QM_STATUS_TYPE, QM_INCIDENT . '.status_id =' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_INCIDENT . '.id', 'DESC');
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_INCIDENT . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $query = $this->db->where(QM_INCIDENT . '.incident_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function incident_add($data) {
        if ($data['optradio'] == 'branchDiv') {
            $data['ent_id'] = $this->branchToEntity($data['branch_id']);
        }
        $table = QM_INCIDENT;
        unset($data['submit']);
        unset($data['optradio']);
        if ($data['ent_id'] == '') {
            $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        }
        $data['user_id'] = $this->session->userdata('session_data')->user_id;
        $check = $this->InsertData($table, $data);
    }

    public function incident_update($id) {
        $table = QM_INCIDENT;
        $sql = $this->db->last_query();
        return $this->SelectWhere($id, $table);
    }

    public function incident_edit($id, $data) {
        if ($data['optradio'] == 'branchDiv') {
            $data['ent_id'] = $this->branchToEntity($data['branch_id']);
        }
        $table = QM_INCIDENT;
        unset($data['id']);
        unset($data['submit']);
        unset($data['optradio']);
        return $this->UpdateData($data, $id, $table);
    }

    public function complete_incident($id, $data) {
        $table = QM_INCIDENT;
        unset($data['id']);
        unset($data['submit']);
        $sql = $this->db->last_query();
        return $this->UpdateData($data, $id, $table);
    }

    function checkIncidentName($incident) {
        $result = $this->db->get_where(QM_INCIDENT, array(
                    'incident_name' => $incident
                ))->result_array();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function project() {
        $query = $this->db->select(QM_PROJECT . '.id,' . QM_PROJECT . '.customer_id,' . QM_PROJECT . '.ent_id,' . QM_PROJECT . '.proj_name,' . QM_PROJECT . '.proj_created_date,' . QM_STATUS_TYPE . '.status_type,' . QM_ENTITY . '.ent_name');
        $query = $this->db->from(QM_PROJECT);
        //$query = $this->db->join(QM_CUSTOMER_DETAILS, QM_PROJECT . '.customer_id =' . QM_CUSTOMER_DETAILS . '.id', 'LEFT');
        $query = $this->db->join(QM_BRANCH, QM_PROJECT . '.branch_id = ' . QM_BRANCH . '.id', 'LEFT');
        $query = $this->db->join(QM_ENTITY, QM_PROJECT . '.ent_id = ' . QM_ENTITY . '.id', 'LEFT');
        $query = $this->db->join(QM_STATUS_TYPE, QM_PROJECT . '.status_id =' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_PROJECT . '.id', 'DESC');

        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_PROJECT . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }

        $query = $this->db->where(QM_PROJECT . '.proj_status', 1);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function projectTask($pid = '') {
        $query = $this->db->select(QM_TASK . '.id,' . QM_TASK . '.task_name,' . QM_TASK . '.task_address,' . QM_TASK . '.assign_date,' . QM_FSE_DETAILS . '.id as fse_id,' . QM_TASK_TYPE . '.task_type,' . QM_STATUS_TYPE . '.status_type,' . QM_PROJECT . '.proj_name,' . QM_FSE_DETAILS . '.fse_name,' . QM_TASK . '.project_id as pid');
        $query = $this->db->from(QM_TASK);
        $query = $this->db->join(QM_PROJECT, QM_TASK . '.project_id =' . QM_PROJECT . '.id');
        $query = $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id =' . QM_STATUS_TYPE . '.id');
        $query = $this->db->join(QM_TASK_TYPE, QM_TASK . '.task_type_id =' . QM_TASK_TYPE . '.id');
        $query = $this->db->join(QM_FSE_DETAILS, QM_TASK . '.fse_id = ' . QM_FSE_DETAILS . '.id');
        $this->db->order_by(QM_TASK . '.id', 'DESC');
        $query = $this->db->where(QM_TASK . '.task_status', 1);
        $query = $this->db->where(QM_TASK . '.project_id', $pid);
        $query = $this->db->get();
        $sql = $this->db->last_query();
        //print_r($sql);
        return $query->result_array();
        //return $sql;
    }

    public function incidentTask($incid = '') {
        $query = $this->db->select(QM_TASK . '.id,' . QM_TASK . '.task_name,' . QM_TASK . '.task_address,' . QM_TASK . '.assign_date,' . QM_FSE_DETAILS . '.id as fse_id,' . QM_TASK_TYPE . '.task_type,' . QM_STATUS_TYPE . '.status_type,' . QM_INCIDENT . '.incident_name,' . QM_FSE_DETAILS . '.fse_name,' . QM_TASK . '.incident_id as incid');
        $query = $this->db->from(QM_TASK);
        $query = $this->db->join(QM_INCIDENT, QM_TASK . '.incident_id =' . QM_INCIDENT . '.id');
        $query = $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id =' . QM_STATUS_TYPE . '.id');
        $query = $this->db->join(QM_TASK_TYPE, QM_TASK . '.task_type_id =' . QM_TASK_TYPE . '.id');
        $query = $this->db->join(QM_FSE_DETAILS, QM_TASK . '.fse_id = ' . QM_FSE_DETAILS . '.id');
        $this->db->order_by(QM_TASK . '.id', 'DESC');
        $query = $this->db->where(QM_TASK . '.task_status', 1);
        $query = $this->db->where(QM_TASK . '.incident_id', $incid);
        $query = $this->db->get();
        $sql = $this->db->last_query();
        //print_r($sql);
        return $query->result_array();
        //return $sql;
    }

    public function project_add($data) {

        if ($data['optradio'] == 'branchDiv') {
            $data['ent_id'] = $this->branchToEntity($data['branch_id']);
        }
        $table = QM_PROJECT;
        unset($data['submit']);
        unset($data['optradio']);


        $data['user_id'] = $this->session->userdata('session_data')->user_id;
        if ($data['ent_id'] == '') {
            $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        }

        $check = $this->InsertData($table, $data);
        /* if ($check == 1) {
          redirect('project');
          } */
    }

    public function project_update($id) {
        $table = QM_PROJECT;
        return $this->SelectWhere($id, $table);
    }

    public function project_edit($id, $data) {
        if ($data['optradio'] == 'branchDiv') {
            $data['ent_id'] = $this->branchToEntity($data['branch_id']);
        }
        $table = QM_PROJECT;
        unset($data['id']);
        unset($data['submit']);
        unset($data['optradio']);
        if ($data['ent_id'] == '') {
            $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        }
        return $this->UpdateData($data, $id, $table);
    }

    public function complete_project($id, $data) {
        $table = QM_PROJECT;
        unset($data['id']);
        unset($data['submit']);
        $sql = $this->db->last_query();
        return $this->UpdateData($data, $id, $table);
    }

    function checkProjectName($project) {
        $result = $this->db->get_where(QM_PROJECT, array(
                    'proj_name' => $project
                ))->result_array();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function webuser() {
        $this->db->select(QM_WEB_ACCESS . '.id,' . QM_WEB_ACCESS . '.user_type,' . QM_WEB_ACCESS . '.ent_id,' . QM_WEB_ACCESS . '.branch_id,' . QM_WEB_ACCESS . '.web_name,' . QM_WEB_ACCESS . '.web_username,' . QM_WEB_ACCESS . '.web_email,' . QM_WEB_ACCESS . '.web_phone,' . QM_WEB_USER_TYPE . '.web_user_type,' . QM_ENTITY . '.ent_name,' . QM_BRANCH . '.branch_name, ' . QM_WEB_ACCESS . '.web_status');
        $this->db->from(QM_WEB_ACCESS);
        $this->db->join(QM_WEB_USER_TYPE, QM_WEB_ACCESS . '.user_type = ' . QM_WEB_USER_TYPE . '.id');
        $this->db->join(QM_BRANCH, QM_WEB_ACCESS . '.branch_id = ' . QM_BRANCH . '.id', 'LEFT');
        $this->db->join(QM_ENTITY, QM_WEB_ACCESS . '.ent_id = ' . QM_ENTITY . '.id', 'LEFT');
        // $this->db->where(QM_WEB_ACCESS . '.web_status', 1);
        if ($this->session->userdata('session_data')->is_admin == 1) {
            // $where = QM_WEB_ACCESS . ".ent_id =" . $this->session->userdata('session_data')->ent_id;
            //$this->db->where($where);
        } elseif ($this->session->userdata('session_data')->is_entity_admin == 1) {
            $this->db->where(QM_WEB_ACCESS . ".ent_id =" . $this->session->userdata('session_data')->ent_id);
        } else {
            $this->db->where(QM_WEB_ACCESS . ".created_by_id =" . $this->session->userdata('session_data')->user_id);
            $this->db->or_where(QM_WEB_ACCESS . ".id =" . $this->session->userdata('session_data')->user_id);
        }
        $this->db->order_by(QM_WEB_ACCESS . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function webuser_add($data) {
        if ($data['optradio'] == 'branchDiv') {
            $data['ent_id'] = $this->branchToEntity($data['branch_id']);
        }
        $table = QM_WEB_ACCESS;
        unset($data['submit']);
        unset($data['web_cpassword']);
        unset($data['optradio']);
        $data['entity_admin'] = $this->session->userdata('session_data')->entity_admin;
        $data['created_by_id'] = $this->session->userdata('session_data')->user_id;
        $this->InsertData($table, $data);
        return $this->db->insert_id();
    }

    public function webuser_update($id) {
        $table = QM_WEB_ACCESS;
        return $this->SelectWhere($id, $table);
    }

    public function webuser_edit($id, $data) {

        if (isset($data['optradio'])) {
            if ($data['optradio'] == 'branchDiv') {
                $data['ent_id'] = $this->branchToEntity($data['branch_id']);
            }
        }
        $table = QM_WEB_ACCESS;
        unset($data['id']);
        unset($data['submit']);
        unset($data['web_cpassword']);
        unset($data['optradio']);
        $data['created_by_id'] = $this->session->userdata('session_data')->user_id;
        if ($this->session->userdata('session_data')->entity_admin != NULL) {
            $data['entity_admin'] = $this->session->userdata('session_data')->entity_admin;
        }
        return $this->UpdateData($data, $id, $table);
    }

    public function webuser_delete($id) {


        return $this->DeleteData($id, QM_WEB_ACCESS);
    }

    function checkWebemails($email) {
        $result = $this->db->get_where(QM_WEB_ACCESS, array(
                    'web_email' => $email
                ))->result_array();

        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function checkWebemail($email, $id) {
        $this->db->select('id');
        $this->db->from(QM_WEB_ACCESS);
        $this->db->where('web_email', $email);
        if ($id != NULL) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function checkWebUser($username) {
        $result = $this->db->get_where(QM_WEB_ACCESS, array(
                    'web_username' => $username
                ))->result_array();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function userType() {
        $query = $this->db->select(QM_WEB_USER_TYPE . '.id,' . QM_WEB_USER_TYPE . '.web_user_type,' . QM_WEB_USER_TYPE . '.web_user_description');
        $query = $this->db->from(QM_WEB_USER_TYPE);
        $this->db->order_by(QM_WEB_USER_TYPE . '.id', 'DESC');
        if ($this->session->userdata('session_data')->is_admin == 1) {
            
        } elseif ($this->session->userdata('session_data')->is_entity_admin == 1) {
            $this->db->where(QM_WEB_USER_TYPE . ".ent_id =" . $this->session->userdata('session_data')->ent_id);
        } else {
            $this->db->where(QM_WEB_USER_TYPE . ".created_by_id =" . $this->session->userdata('session_data')->user_id);
        }
        $query = $this->db->where(QM_WEB_USER_TYPE . '.web_user_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function userType_add($data) {
        $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        $table = QM_WEB_USER_TYPE;
        unset($data['user_id']);
        unset($data['submit']);
        $check = $this->InsertData($table, $data);
        /* if ($check == 1) {
          redirect('asset');
          } */
    }

    public function userType_update($id) {
        $table = QM_WEB_USER_TYPE;
        return $this->SelectWhere($id, $table);
    }

    public function userType_edit($id, $data) {
        $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        $table = QM_WEB_USER_TYPE;
        unset($data['id']);
        unset($data['submit']);
        return $this->UpdateData($data, $id, $table);
    }

    function checkUserType($userType) {
        $result = $this->db->get_where(QM_WEB_USER_TYPE, array(
                    'web_user_type' => $userType
                ))->result_array();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function sla() {
        $query = $this->db->select(QM_SLA . '.id,' . QM_SLA . '.branch_id,' . QM_SLA . '.ent_id,' . QM_SLA . '.sla_name,' . QM_SLA . '.sla_details,' . QM_SLA . '.sla_time,' . QM_ENTITY . '.ent_name,' . QM_BRANCH . '.branch_name');
        $query = $this->db->from(QM_SLA);
        /* $query = $this->db->join(QM_CUSTOMER_DETAILS, QM_SLA.'.cus_id = '.QM_CUSTOMER_DETAILS.'.id'); */
        $query = $this->db->join(QM_BRANCH, QM_SLA . '.branch_id = ' . QM_BRANCH . '.id', 'LEFT');
        $query = $this->db->join(QM_ENTITY, QM_SLA . '.ent_id = ' . QM_ENTITY . '.id', 'LEFT');
        $this->db->order_by(QM_SLA . '.id', 'DESC');
        $query = $this->db->where(QM_SLA . '.sla_status', 1);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_SLA . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function sla_add($data) {
        $data['sla_week'] = $this->input->post('sla_week');
        $sla_week = $this->input->post('sla_week');
        if (count($sla_week) > 0) {
            $sla_week = json_encode(implode(",", $sla_week));
        } else {
            $sla_week = '';
        }

        $data['sla_week'] = $sla_week;
        $table = QM_SLA;
        unset($data['submit']);
        unset($data['optradio']);
        $data['user_id'] = $this->session->userdata('session_data')->user_id;
        $check = $this->InsertData($table, $data);
    }

    public function sla_update($id) {
        $table = QM_SLA;
        $sql = $this->db->last_query();
        return $this->SelectWhere($id, $table);
    }

    public function sla_edit($id, $data) {
        $data['sla_week'] = $this->input->post('sla_week');
        $sla_week = $this->input->post('sla_week');
        if (count($sla_week) > 0) {
            $sla_week = json_encode(implode(",", $sla_week));
        } else {
            $sla_week = '';
        }

        $data = array(
            'optradio' => $this->input->post('optradio'),
            'branch_id' => $this->input->post('branch_id'),
            'ent_id' => $this->input->post('ent_id'),
            'sla_name' => $this->input->post('sla_name'),
            'sla_details' => $this->input->post('sla_details'),
            'sla_amount' => $this->input->post('sla_amount'),
            'sla_time' => $this->input->post('sla_time'),
            'sla_time_hours' => $this->input->post('sla_time_hours'),
            'sla_week' => $sla_week,
        );

        if ($data['optradio'] == 'companyDiv') {
            $data['branch_id'] = 0;
        } else {
            $data['ent_id'] = $this->branchToEntity($data['branch_id']);
        }
        //print_r($data); die;
        $table = QM_SLA;
        unset($data['id']);
        unset($data['submit']);
        unset($data['optradio']);
        return $this->UpdateData($data, $id, $table);
    }

    function checkSLAName($slaname) {
        $result = $this->db->get_where(QM_SLA, array(
                    'sla_name' => $slaname
                ))->result_array();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function userType_copy($id = NULL) {
        $query = "insert into " . QM_WEB_USER_TYPE . "(ent_id, web_user_type, permission_code, web_user_description, web_user_status, created_by_id)
                  select ent_id, web_user_type, permission_code, web_user_description, web_user_status, created_by_id from " . QM_WEB_USER_TYPE . " where id = " . $id . ";";
        $this->db->query($query);
        return $this->db->insert_id();
    }

    function userSetting() {
        $userid = $this->session->userdata('session_data')->user_id;
        $this->db->select('web_name, web_password, web_email, web_phone,	web_address');
        $this->db->from(QM_WEB_ACCESS);
        $this->db->where(QM_WEB_ACCESS . '.id', $userid);
        $query = $this->db->get();
        return $query->row();
    }

}
