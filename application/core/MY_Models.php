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

    public function UpdateData($data, $id, $table) {
        $this->db->where('id', $id);
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

    public function getFse() {
        $table = "QM_FSE_DETAILS";
        $this->db->select('id,fse_name,fse_status');
        $this->db->from($table);
        $this->db->where('QM_FSE_DETAILS.fse_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getProject() {
        $table = "QM_PROJECT";
        $this->db->select('id,proj_name,proj_status');
        $this->db->from($table);
        $this->db->where('QM_PROJECT.proj_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getIncident() {
        $table = "QM_INCIDENT";
        $this->db->select('id,incident_name,incident_status');
        $this->db->from($table);
        $this->db->where('QM_INCIDENT.incident_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
     public function getCustomer() {
        $table = "QM_CUSTOMER_DETAILS";
        $this->db->select('id,cus_name,cus_status');
        $this->db->from($table);
        $this->db->where('QM_CUSTOMER_DETAILS.cus_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getStatus() {
        $table = "QM_STATUS_TYPE"; 
        $this->db->select('id,status_type');
        $this->db->from($table);
        $this->db->where('QM_STATUS_TYPE.status_stat', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getSla() {
        $table = "QM_SLA";
        $this->db->select('id,sla_name,sla_status');
        $this->db->from($table);
        $this->db->where('QM_SLA.sla_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getBranch() {
        $table = "QM_BRANCH";
        $this->db->select('id,branch_name,branch_status');
        $this->db->from($table);
        $this->db->where('QM_BRANCH.branch_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getTasktype() {
        $table = "QM_TASK_TYPE";
        $this->db->select('id,task_type');
        $this->db->from($table);
        $query = $this->db->get();
        return $query->result_array();
    }
   
     public function getTask() {
        $table = "QM_TASK";
        $this->db->select('id,task_name,task_status');
        $this->db->from($table);
        $this->db->where('QM_TASK.task_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>