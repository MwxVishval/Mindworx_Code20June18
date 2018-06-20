<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class WorkOrderModel extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function workOrder() {

        $query = $this->db->select(QM_WORK_ORDER.'.id,'.QM_WORK_ORDER.'.task_id,'.QM_WORK_ORDER.'.customer_id,'.QM_WORK_ORDER.'.work_order_description,'.QM_WORK_ORDER.'.work_order_status,'.QM_WORK_ORDER.'.status_id,'.QM_WORK_ORDER.'.start_date,'.QM_WORK_ORDER.'.end_date,'.QM_TASK.'.task_name,'.QM_CUSTOMER_DETAILS.'.cus_name,'.QM_STATUS_TYPE.'.status_type');
//        $query = $this->db->select('QM_TASK.id,QM_PROJECT.id as project_id, QM_INCIDENT.id as incident_id');
        $query = $this->db->from(QM_WORK_ORDER);
		
		 $query = $this->db->join(QM_TASK, QM_WORK_ORDER.'.task_id = '.QM_TASK.'.id');
        $query = $this->db->join(QM_STATUS_TYPE, QM_WORK_ORDER.'.status_id = '.QM_STATUS_TYPE.'.id');
        /*$query = $this->db->join(QM_PROJECT, QM_WORK_ORDER.'.project_id = '.QM_PROJECT.'.id','LEFT');
        $query = $this->db->join(QM_INCIDENT, QM_WORK_ORDER.'.incident_id = '.QM_INCIDENT.'.id','LEFT');*/
        $query = $this->db->join(QM_CUSTOMER_DETAILS, QM_WORK_ORDER.'.customer_id = '.QM_CUSTOMER_DETAILS.'.id');
		$query =$this->db->where(QM_WORK_ORDER.'.work_order_status', 1);
        $query = $this->db->get();
        return $query->result_array();
        return $data;
    }
	
	 

    public function typeDetails() {
       $data['getStatus']=$this->getStatus();
       $data['getTask']=$this->getTask();
	   $data['getProject']=$this->getProject();
       $data['getIncident']=$this->getIncident();
       $data['getCustomer']=$this->getCustomer();
       return $data;
    }
	

    
    public function insertWorkOrder($data) {
       $table = QM_WORK_ORDER;
       $insert_id = $this->InsertData($table, $data,TRUE);
       $session_data = $this->session->userdata('session_data');
       $session_data->last_insert_id = $insert_id;
    }
    
     public function updateWorkOrder($id) {
        $table = QM_WORK_ORDER;
        $sql = $this->db->last_query();
		//print_r($sql); die;
        return $this->SelectWhere($id, $table);
    }

    public function editWorkOrder($id, $data) {
        $table = QM_WORK_ORDER;
        unset($data['id']);
		unset($data['optradio']);
        unset($data['submit']);
        return $this->UpdateData($data, $id, $table);
    }

}
