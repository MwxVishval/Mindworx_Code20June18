<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FcmModel extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function report() {
        $this->db->select('*');
        $this->db->from(QM_TASK);
        // $this->db->join(QM_BRANCH, QM_BRANCH . '.dd = ' . QM_TASK . '.branch_id');
        $this->db->join(QM_CUSTOMER_DETAILS, QM_CUSTOMER_DETAILS . '.id = ' . QM_TASK . '.customer_id');
        // $this->db->join(QM_ENTITY, QM_ENTITY . '.dd = ' . QM_TASK . '.id');
        // $this->db->join(QM_ASSET_CATEGORY, QM_ASSET_CATEGORY . '.id = ' . QM_TASK . '.id');
        $this->db->join(QM_FSE_DETAILS, QM_FSE_DETAILS . '.id = ' . QM_TASK . '.fse_id');
        //$this->db->join(QM_FSE_TYPE, QM_FSE_TYPE . '.id = ' . QM_TASK . '.id');
        $this->db->join(QM_INCIDENT, QM_INCIDENT . '.id = ' . QM_TASK . '.incident_id');
        $this->db->join(QM_PROJECT, QM_PROJECT . '.id = ' . QM_TASK . '.project_id');
        $this->db->join(QM_SLA, QM_SLA . '.id = ' . QM_TASK . '.sla_id');
        $this->db->join(QM_STATUS_TYPE, QM_STATUS_TYPE . '.id = ' . QM_TASK . '.status_id');
        // $this->db->order_by(QM_USER_PERMISSION . '.id', 'DESC');
       // $this->db->where(QM_USER_PERMISSION . '.permission_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
}
