<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CronModel extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function taskStatusCheck() {

        $table = QM_TASK;
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($table . '.status_id', 1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data['result'] = $query->result_array();
        $data['tim'] = $this->getCurrentTime();
        return $data;
    }

    public function taskStatusChange($id) {

        $table = QM_TASK;
        $data['status_id'] = "6";
        return $this->UpdateData($data, $id, $table);
    }

    public function StatusServiceNowChange($id) {

        $table = QM_NOTIFICATION;
        $data['serviceNowStatus'] = "1";
        return $this->UpdateData($data, $id, $table);
    }

    public function getApiUrlPassUser($id) {
        $table = QM_API_SETTING;
        return $this->SelectWhere($id, $table);
    }

    public function StatusServiceNow() {
        $this->db->select(QM_TASK . '.task_name ,' . QM_TASK . '.fse_task_comments,' . QM_NOTIFICATION . '.id');
        $this->db->from(QM_NOTIFICATION);
        $this->db->join(QM_TASK, QM_TASK . '.id = ' . QM_NOTIFICATION . '.task_id');
        $this->db->where(QM_NOTIFICATION . '.serviceNowStatus', 0);
        $this->db->where(QM_TASK . '.task_type_id', 2);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAssetsFromServiceNow() {
        
    }

    public function base64Toimage() {
        $this->db->select('*');
        $this->db->from(QM_TASK_CUSTOMER_DOCUMENT);
        $this->db->where('upload_check', 0);
        $this->db->where('image_name', NULL);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function updateImageName($id = NULL, $photoname = NULL) {
        $datas = array('image_name' => $photoname);
        $this->db->where('id', $id);
        $this->db->update(QM_TASK_CUSTOMER_DOCUMENT, $datas);
    }

    public function updateDocumentPushCompleted($id = NULL) {
        $datas = array('upload_check' => 1);
        ;
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
        $this->db->where('upload_check', 0);
        $this->db->where(QM_TASK . '.sys_id !=', NULL);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function pushCustomerSignToSN() {
        $this->db->select('task_name,sys_id,id,'
        );
        $this->db->from(QM_TASK);
        $this->db->where('customer_sign_upload', 0);
        $this->db->where('sys_id !=', NULL);
        $this->db->where('customer_sign !=', NULL);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function base64ToimageCustomer() {
        $this->db->select('customer_sign , id');
        $this->db->from(QM_TASK);
        $this->db->where('sys_id !=', NULL);
        $this->db->where('customer_sign_upload', 0);
        $this->db->where('customer_sign !=', NULL);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function updateCustomerSignPushed($id = NULL) {
        $datas = array('customer_sign_upload' => 1);
        $this->db->where('id', $id);
        $this->db->update(QM_TASK, $datas);
    }

      public function updated_check_model() {

        $test = array(
            array('task_name' => 1, 'task_description' => 'test2')
        );
        $this->db->trans_start();
        $this->db->update_batch('qm_task', $test, 1);
        $this->db->trans_complete();
    }
    
}
