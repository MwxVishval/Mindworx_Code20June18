<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ReportModel extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function getBranchype() {
        //$query = $this->db->query("SELECT id,branch_name FROM " . QM_BRANCH . " WHERE branch_status=1");

        $table = QM_BRANCH;
        $this->db->select('id,branch_name,branch_status');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_BRANCH . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_BRANCH . '.branch_status', 1);
        $query = $this->db->get();
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

    public function getProjectName() {
        //$query = $this->db->query("SELECT id,proj_name FROM " . QM_PROJECT . " WHERE proj_status=1");
        $table = QM_PROJECT;
        $this->db->select('id,proj_name,proj_status');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_PROJECT . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_PROJECT . '.proj_status', 1);
        $query = $this->db->get();
        $result = $query->result();
        $id = array(
            ''
        );
        $proj_name = array(
            '--Select--'
        );
        for ($i = 0; $i < count($result); $i++) {
            array_push($id, $result[$i]->id);
            array_push($proj_name, $result[$i]->proj_name);
        }
        return array_combine($id, $proj_name);
    }

    public function getEntityName() {
        //$query = $this->db->query("SELECT id,ent_name FROM " . QM_ENTITY . " WHERE status=1");
        $table = QM_ENTITY;
        $this->db->select('id,ent_name,status');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_ENTITY . '.id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_ENTITY . '.status', 1);
        $query = $this->db->get();
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

    public function getIncidentName() {
        //$query = $this->db->query("SELECT id,incident_name FROM " . QM_INCIDENT . " WHERE incident_status=1");
        $table = QM_INCIDENT;
        $this->db->select('id,incident_name,incident_status');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_INCIDENT . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_INCIDENT . '.incident_status', 1);
        $query = $this->db->get();
        $result = $query->result();
        $id = array(
            ''
        );
        $incident_name = array(
            '--Select--'
        );
        for ($i = 0; $i < count($result); $i++) {
            array_push($id, $result[$i]->id);
            array_push($incident_name, $result[$i]->incident_name);
        }
        return array_combine($id, $incident_name);
    }

    public function getFSEName() {
        // $query = $this->db->query("SELECT id,fse_name FROM " . QM_FSE_DETAILS . " WHERE fse_status=1");

        $table = QM_FSE_DETAILS;
        $this->db->select('id,fse_name,fse_status');
        $this->db->from($table);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_FSE_DETAILS . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_FSE_DETAILS . '.fse_status', 1);
        $query = $this->db->get();
        $result = $query->result();
        $id = array(
            ''
        );
        $fse_name = array(
            '--Select--'
        );
        for ($i = 0; $i < count($result); $i++) {
            array_push($id, $result[$i]->id);
            array_push($fse_name, $result[$i]->fse_name);
        }
        return array_combine($id, $fse_name);
    }

    public function report($data) {

        $this->db->select(QM_PROJECT . '.id as project_id,'
                . QM_INCIDENT . '.id as incident_id,'
                . QM_TASK . '.*,'
                . QM_TASK . '.id,'
                . QM_TASK . '.fse_id,'
                . QM_TASK . '.task_type_id,'
                . QM_TASK . '.task_name,'
                . QM_TASK . '.branch_id,'
                . QM_TASK . '.project_id,'
                . QM_TASK . '.incident_id,'
                . QM_TASK . '.customer_id,'
                . QM_TASK . '.web_user_id,'
                . QM_TASK . '.task_description,'
                . QM_TASK . '.start_date,'
                . QM_TASK . '.end_date,'
                . QM_TASK . '.status_id,'
                . QM_TASK . '.sla_id,'
                . QM_TASK . '.fse_feedback,'
                . QM_TASK . '.customer_sign,'
                . QM_TASK . '.task_status,'
                . QM_TASK . '.task_address,'
                . QM_TASK . '.product_name,'
                . QM_TASK . '.serial_number,'
                . QM_TASK . '.product_code,'
                . QM_TASK . '.book_code,'
                . QM_TASK . '.manual_docket_number,'
                . QM_TASK . '.call_number,'
                . QM_TASK . '.customer_name,'
                . QM_TASK . '.customer_contact_person,'
                . QM_TASK . '.customer_contact_number,'
                . QM_TASK . '.model,'
                . QM_TASK . '.problem,'
                . QM_TASK . '.message,'
                . QM_TASK . '.comment_charge,'
                . QM_TASK . '.previous_meter_reading,'
                . QM_TASK . '.previous_color_reading,'
                . QM_TASK . '.outstanding_calls,'
                . QM_TASK . '.created_date,'
                . QM_FSE_DETAILS . '.fse_name,'
                . QM_STATUS_TYPE . '.status_type,'
                . QM_BRANCH . '.branch_name,'
                . QM_ENTITY . '.ent_name,'
                . QM_TASK_LOCATION . '.task_location,'
                . QM_SLA . '.sla_name,'
                . QM_TASK_TYPE . '.task_type,'
                . QM_PROJECT . '.proj_name,'
                . QM_INCIDENT . '.incident_name,'
                . QM_CALL_STATUS_TYPE . '.callstatus_type,'
                . QM_CALL_TYPE . '.calltype_type, '
                . QM_PRIORITY . '.priority_type');
        $this->db->from(QM_TASK);
        $this->db->join(QM_FSE_DETAILS, QM_TASK . '.fse_id = ' . QM_FSE_DETAILS . '.id', 'LEFT');
        $this->db->join(QM_TASK_TYPE, QM_TASK . '.task_type_id = ' . QM_TASK_TYPE . '.id', 'LEFT');
        $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id = ' . QM_STATUS_TYPE . '.id', 'LEFT');
        $this->db->join(QM_BRANCH, QM_TASK . '.ent_id = ' . QM_BRANCH . '.id', 'LEFT');
        $this->db->join(QM_ENTITY, QM_TASK . '.branch_id = ' . QM_ENTITY . '.id', 'LEFT');
        $this->db->join(QM_PROJECT, QM_TASK . '.project_id = ' . QM_PROJECT . '.id', 'LEFT');
        $this->db->join(QM_INCIDENT, QM_TASK . '.incident_id = ' . QM_INCIDENT . '.id', 'LEFT');

        $this->db->join(QM_CALL_STATUS_TYPE, QM_TASK . '.call_status = ' . QM_CALL_STATUS_TYPE . '.id', 'LEFT');
        $this->db->join(QM_CALL_TYPE, QM_TASK . '.call_type = ' . QM_CALL_TYPE . '.id', 'LEFT');
        $this->db->join(QM_PRIORITY, QM_TASK . '.priority = ' . QM_PRIORITY . '.id', 'LEFT');

        //$this->db->join(QM_CUSTOMER_DETAILS, QM_TASK . '.customer_id = ' . QM_CUSTOMER_DETAILS . '.id', 'LEFT');
        $this->db->join(QM_SLA, QM_TASK . '.sla_id = ' . QM_SLA . '.id', 'LEFT');
        $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id', 'LEFT');
        $this->db->order_by(QM_TASK . '.id', 'DESC');
        $this->db->where(QM_TASK . '.task_status', 1);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_TASK . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->where(QM_TASK . '.start_date>=', date('Y-m-d H:i:s', strtotime($data['start_date'])));
        $this->db->where(QM_TASK . '.start_date<=', date('Y-m-d H:i:s', strtotime($data['end_date'])));
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_TASK . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        if (($data['ent_id'] != '') || ($data['ent_id'] != 0)) {
            $this->db->where(QM_TASK . '.ent_id', $data['ent_id']);
        }
        if (($data['branch_id'] != '') || ($data['branch_id'] != 0)) {
            $this->db->where(QM_TASK . '.branch_id', $data['branch_id']);
        }
        if (($data['proj_id'] != '') || ($data['proj_id'] != 0)) {
            $this->db->where(QM_TASK . '.project_id', $data['proj_id']);
        }
        if (($data['incident_id'] != '') || ($data['incident_id'] != 0)) {
            $this->db->where(QM_TASK . '.incident_id', $data['incident_id']);
        }
        if (($data['fse_id'] != '') || ($data['fse_id'] != 0)) {
            $this->db->where(QM_TASK . '.fse_id', $data['fse_id']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function reports($data) {

        $this->db->select('*');
        $this->db->from(QM_TASK);
        // $this->db->join(QM_BRANCH, QM_BRANCH . '.dd = ' . QM_TASK . '.branch_id');
        // $this->db->join(QM_CUSTOMER_DETAILS, QM_CUSTOMER_DETAILS . '.id = ' . QM_TASK . '.customer_id', 'left');
        // $this->db->join(QM_ENTITY, QM_ENTITY . '.dd = ' . QM_TASK . '.id');
        // $this->db->join(QM_ASSET_CATEGORY, QM_ASSET_CATEGORY . '.id = ' . QM_TASK . '.id');
        $this->db->join(QM_FSE_DETAILS, QM_FSE_DETAILS . '.id = ' . QM_TASK . '.fse_id', 'left');
        $this->db->join(QM_TASK_TYPE, QM_TASK . '.task_type_id = ' . QM_TASK_TYPE . '.id', 'left');
        //$this->db->join(QM_FSE_TYPE, QM_FSE_TYPE . '.id = ' . QM_TASK . '.id');
        $this->db->join(QM_ENTITY, QM_ENTITY . '.id = ' . QM_TASK . '.ent_id', 'left');
        $this->db->join(QM_BRANCH, QM_BRANCH . '.id = ' . QM_TASK . '.branch_id', 'left');
        $this->db->join(QM_INCIDENT, QM_INCIDENT . '.id = ' . QM_TASK . '.incident_id', 'left');
        $this->db->join(QM_PROJECT, QM_PROJECT . '.id = ' . QM_TASK . '.project_id', 'left');
        $this->db->join(QM_SLA, QM_SLA . '.id = ' . QM_TASK . '.sla_id', 'left');
        $this->db->join(QM_STATUS_TYPE, QM_STATUS_TYPE . '.id = ' . QM_TASK . '.status_id', 'left');
        $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id');
        /* $this->db->join(QM_TASK_TYPE, QM_TASK_TYPE . '.id = ' . QM_TASK . '.task_type_id', 'left'); */

        // $this->db->order_by(QM_USER_PERMISSION . '.id', 'DESC');
        // $this->db->where(QM_USER_PERMISSION . '.permission_status', 1); $data['start_date']
        $this->db->where(QM_TASK . '.start_date>=', date('Y-m-d H:i:s', strtotime($data['start_date'])));
        $this->db->where(QM_TASK . '.start_date<=', date('Y-m-d H:i:s', strtotime($data['end_date'])));
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_TASK . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        if (($data['ent_id'] != '') || ($data['ent_id'] != 0)) {
            $this->db->where(QM_TASK . '.ent_id', $data['ent_id']);
        }
        if (($data['branch_id'] != '') || ($data['branch_id'] != 0)) {
            $this->db->where(QM_TASK . '.branch_id', $data['branch_id']);
        }
        if (($data['proj_id'] != '') || ($data['proj_id'] != 0)) {
            $this->db->where(QM_TASK . '.project_id', $data['proj_id']);
        }
        if (($data['incident_id'] != '') || ($data['incident_id'] != 0)) {
            $this->db->where(QM_TASK . '.incident_id', $data['incident_id']);
        }
        if (($data['fse_id'] != '') || ($data['fse_id'] != 0)) {
            $this->db->where(QM_TASK . '.fse_id', $data['fse_id']);
        }

        /* $this->db->where(QM_TASK . '.ent_id', $data['ent_id']);		
          $this->db->where(QM_TASK . '.branch_id', $data['branch_id']);
          $this->db->where(QM_TASK . '.project_id', $data['proj_id']);
          $this->db->where(QM_TASK . '.incident_id', $data['incident_id']);
          $this->db->where(QM_TASK . '.fse_id', $data['fse_id']); */
        $query = $this->db->get();
        // $sql = $this->db->last_query();
        // print_r($sql);
        return $query->result_array();
    }

    public function reportUiAction() {
        $this->db->select('*');
        $this->db->from(QM_FSE_ACTION_PAGE);
        $this->db->join(QM_FSE_DETAILS, QM_FSE_DETAILS . '.id = ' . QM_FSE_ACTION_PAGE . '.fse_id');
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_FSE_ACTION_PAGE . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->order_by(QM_FSE_ACTION_PAGE . '.id', 'DESC');
        $this->db->limit(100);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function reportUiload() {
        $this->db->select('*');
        $this->db->from(QM_FSE_VIEW_PAGE);
        $this->db->join(QM_FSE_DETAILS, QM_FSE_DETAILS . '.id = ' . QM_FSE_VIEW_PAGE . '.fse_id');
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_FSE_VIEW_PAGE . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->order_by(QM_FSE_VIEW_PAGE . '.id', 'DESC');
        $this->db->limit(100);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function entityFeilds() {
        if ($this->session->userdata('session_data')->is_admin == 1) {
            $s = 0;
            $e = 29;
            $r = array();
            while ($s <= $e) {
                array_push($r, $s);
                $s++;
            }
            return json_encode($r);
        }
        $id = $this->session->userdata('session_data')->ent_id;
        $this->db->select(QM_ENTITY . '.task_field');
        $this->db->from(QM_ENTITY);
        $this->db->where(QM_ENTITY . '.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $res = $query->result_array();
            return$res[0]['task_field'];
        } else {
            return FALSE;
        }
    }

}
