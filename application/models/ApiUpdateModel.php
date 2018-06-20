<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ApiUpdateModel extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function taskTypeid($task_id = NULL, $update_id = NULL) {

        $this->db->select('task_type_id,');
        $this->db->from(QM_TASK);
        $this->db->where('id = ', $task_id);
        $query = $this->db->get();
        $ret = $query->row();
        $task_type_id = $ret->task_type_id;
        $data = $this->testDetails($task_type_id, $task_id);
        return $data;
    }

    public function testDetails($task_type_id = NULL, $task_id = NULL) {
        if ($task_type_id == NULL) {
            return array();
        }
        $this->db->select(
                API_MAPPING . '.API_Field  ,' . QM_EXTRA_ATTR_DEFINITION . '.extr_att_id,' . QM_EXTRA_ATTR_VALUES . '.Extra_attr_Values,');
        $this->db->from(API_MAPPING);
        $this->db->join(QM_EXTRA_ATTR_DEFINITION, API_MAPPING . '.API_Field = ' . QM_EXTRA_ATTR_DEFINITION . '.Ext_att_name', 'LEFT');
        $this->db->join(QM_EXTRA_ATTR_VALUES, QM_EXTRA_ATTR_VALUES . '.Extra_attr_Def_id = ' . QM_EXTRA_ATTR_DEFINITION . '.extr_att_id', 'LEFT');
        $this->db->where(API_MAPPING . '.task_type', $task_type_id);
        $this->db->where(QM_EXTRA_ATTR_VALUES . '.Task_id', $task_id);
        $this->db->where(API_MAPPING . '.task_type_tab_id', "3");
        $query = $this->db->get();
        $result = $query->result_array();
        $cutFieldsKeyValue = array();
        foreach ($result as $key => $value) {
            $cutFieldsKeyValue[$value['API_Field']] = $value['Extra_attr_Values'];
        }
        return $cutFieldsKeyValue;
    }

    public function updata_map_data($task_id = NULL) {
        
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
        
        $final_data['wheretoupdate'] = $task_name; 
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
        if($update_check == 0){
         return $final_data['api_setting_qmobility_yeson'] = 0;   
        }else{
          $final_data['api_setting_qmobility_yeson'] = 1;  
        }
        
        $states_data = $result1->states_data;
        $states_data = json_decode($states_data);
        $task_status = "";
        if($status_id == 1){$task_status = $states_data->assigned;}
        if($status_id == 2){$task_status = $states_data->onhold;}
        if($status_id == 3){$task_status = $states_data->accepted;}
        if($status_id == 4){$task_status = $states_data->resolved;}
        if($status_id == 5){$task_status = $states_data->inprogress;}
        if($status_id == 6){$task_status = $states_data->rejected;}
        if($status_id == 7){$task_status = $states_data->rejected;}
        $final_data['status'] = $task_status;
        $this->db->select('API_Method_Name as method,API_End_point as url,API_User_name as username,API_Password as password,API_Key as key');
        $this->db->from(API_SETTINGS);
        $this->db->where('qm_task_type_id', $task_type_id);
        $this->db->where('API_Task_Type_id', 3);
        $query2 = $this->db->get();
        if ($query2->num_rows() == 0) {
            return $final_data;
        }
        $result2 = $query2->result_array();
        $final_data['api_setting_qmobility']['api_details'] = $result2[0];
        
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
            if ($value['map_data'] != "") {
                $final_data[$value['map_data']] = $update_data;
            }
        }
        return $final_data;
    }
}

?>