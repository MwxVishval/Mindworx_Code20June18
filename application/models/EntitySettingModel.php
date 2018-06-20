<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class EntitySettingModel extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function getBranchype() {
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

    public function getFSETypes() {

        if ($this->session->userdata('session_data')->is_admin != 1) {
            $where = "ent_id = " . $this->session->userdata('session_data')->ent_id . " AND fse_type_status=1";
        } else {
            $where = "fse_type_status=1";
        }
        $query = $this->db->query("SELECT id,fse_type FROM " . QM_FSE_TYPE . " WHERE " . $where);
        $result = $query->result_array();
        // var_dump($result);
        return $result;
    }

    public function getEnityFSETypes($ent_id) {
        $where = QM_ENTITY_FSE_TYPE . ".ent_id = " . $ent_id . " AND isactive=1";
        $this->db->select(QM_ENTITY_FSE_TYPE . '.id,' . QM_ENTITY_FSE_TYPE . '.fse_type_id,' . QM_ENTITY_FSE_TYPE . '.ent_id,' . QM_ENTITY_FSE_TYPE . '.task_type,' . QM_FSE_TYPE . '.fse_type,');
        $this->db->from(QM_ENTITY_FSE_TYPE);
        $this->db->join(QM_FSE_TYPE, QM_ENTITY_FSE_TYPE . '.fse_type_id=' . QM_FSE_TYPE . '.id');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getEnityFSETypesByTaskType($ent_id,$task_type) {
        $where = QM_ENTITY_FSE_TYPE . ".ent_id = " . $ent_id .  " AND ". QM_ENTITY_FSE_TYPE .".task_type = " . $task_type . " AND isactive=1";
        $this->db->select(QM_ENTITY_FSE_TYPE . '.id,' . QM_ENTITY_FSE_TYPE . '.fse_type_id,' . QM_ENTITY_FSE_TYPE . '.ent_id,' . QM_ENTITY_FSE_TYPE . '.task_type,' );
        $this->db->from(QM_ENTITY_FSE_TYPE);
        $this->db->join(QM_FSE_TYPE, QM_ENTITY_FSE_TYPE . '.fse_type_id=' . QM_FSE_TYPE . '.id');
        $this->db->where($where);
        $query = $this->db->get();
        $obj= $query->result_array();
        $allfsetypes1 = $this->getFSETypes();
         foreach ($allfsetypes1 as $i => $data2) {
                foreach ($obj as $k => $data1) {
                    if ($data2['id'] == $data1['fse_type_id']) {
                        unset($allfsetypes1[$i]);
                    }
                }
            }
             $allfsetypes1 = array_values($allfsetypes1);
            return $allfsetypes1;
    }

    public function getCategory($ent_id = NULL) {
        $this->db->select(QM_CATEGORY . '.id,' . QM_CATEGORY . '.ent_id,' . QM_CATEGORY . '.category,' . QM_ENTITY . '.ent_name,');
        $this->db->from(QM_CATEGORY);
        $this->db->join(QM_ENTITY, QM_CATEGORY . '.ent_id=' . QM_ENTITY . '.id');
        $this->db->order_by(QM_CATEGORY . '.id', 'DESC');
        $this->db->where(QM_CATEGORY . '.category_status', 1);
        if ($ent_id) {
            $this->db->select(QM_CATEGORY . '.task_type');
            $this->db->select(QM_CATEGORY . '.separate_update_screen');
            $this->db->where(QM_CATEGORY . '.ent_id', $ent_id);
            $this->db->join(QM_TASK_TYPE, QM_TASK_TYPE . '.id = ' . QM_CATEGORY . '.task_type');
            $this->db->where(QM_TASK_TYPE . '.task_type_status', 1);
        }
        $query = $this->db->get();
        // var_dump($query->result_array());
        return $query->result_array();
    }

    public function getUpdateTabDepondOn($ent_id = NULL) {
        $this->db->select(QM_EXTRA_ATTR_UPDATE . '.id,'
                . QM_EXTRA_ATTR_UPDATE . '.ent_id,'
                . QM_SELECT_VALUE . '.option_value AS label,'
                . QM_EXTRA_ATTR_UPDATE . '.task_type,'
                . QM_ENTITY . '.ent_name,');
        $this->db->from(QM_EXTRA_ATTR_UPDATE);
        $this->db->join(QM_ENTITY, QM_EXTRA_ATTR_UPDATE . '.ent_id=' . QM_ENTITY . '.id');
        $this->db->join(QM_SELECT_VALUE, QM_EXTRA_ATTR_UPDATE . '.id=' . QM_SELECT_VALUE . '.select_option_id', 'RIGHT');
        $this->db->order_by(QM_EXTRA_ATTR_UPDATE . '.id', 'DESC');
        $this->db->where(QM_EXTRA_ATTR_UPDATE . '.ent_id', $ent_id);
        $this->db->where(QM_EXTRA_ATTR_UPDATE . '.option_type', "SELECT");
        $this->db->order_by(QM_EXTRA_ATTR_UPDATE . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getUpdateTabDepondOn_old($ent_id = NULL) {
        $this->db->select(QM_EXTRA_ATTR_UPDATE . '.id,' . QM_EXTRA_ATTR_UPDATE . '.ent_id,' . QM_EXTRA_ATTR_UPDATE . '.label,' . QM_EXTRA_ATTR_UPDATE . '.task_type,' . QM_ENTITY . '.ent_name,');
        $this->db->from(QM_EXTRA_ATTR_UPDATE);
        $this->db->join(QM_ENTITY, QM_EXTRA_ATTR_UPDATE . '.ent_id=' . QM_ENTITY . '.id');
        $this->db->order_by(QM_EXTRA_ATTR_UPDATE . '.id', 'DESC');
        $this->db->where(QM_EXTRA_ATTR_UPDATE . '.ent_id', $ent_id);
        $this->db->where(QM_EXTRA_ATTR_UPDATE . '.option_type', "SELECT");
        $this->db->order_by(QM_EXTRA_ATTR_UPDATE . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function category_add($data) {
        $table = QM_CATEGORY;
        unset($data['submit']);
        $check = $this->InsertData($table, $data);
        return $this->db->insert_id();
    }

    public function fsetype_add($data) {
        $table = QM_ENTITY_FSE_TYPE;
        unset($data['submit']);
        $check = $this->InsertData($table, $data);
        return $this->db->insert_id();
    }

    public function category_update($id) {
        $table = QM_CATEGORY;
        return $this->SelectWhere($id, $table);
    }

    public function category_edit($id, $data) {
        $table = QM_CATEGORY;
        unset($data['id']);
        unset($data['submit']);
        if (isset($data['category_status']) && $data['category_status'] == 0) {
            $query = $this->db->select(QM_EXTRA_ATTR_DEFINITION . '.extr_att_id');
            $query = $this->db->from(QM_EXTRA_ATTR_DEFINITION);
            $query = $this->db->where(QM_EXTRA_ATTR_DEFINITION . '.qm_status_type_id', 1);
            $query = $this->db->where(QM_EXTRA_ATTR_DEFINITION . '.Ext_att_category_id', $id);
            $query = $this->db->get();

            $result = array();
            foreach ($query->result_array() as $row) {
                $result[] = $row['extr_att_id'];
            }

            if (!empty($result)) {
                $tmp = implode(',', $result);
                $this->db->where_in('API_Field', $result);
                $this->db->delete(API_MAPPING);
            }
            $query = $this->db->delete(QM_EXTRA_ATTR_DEFINITION, array('Ext_att_category_id' => $id));
        }

        return $this->UpdateData($data, $id, $table);
    }

    public function update_fsetype($fse_type_id, $ent_id, $task_type, $fseData) {
        $table = QM_ENTITY_FSE_TYPE;

        $query = $this->db->select(QM_ENTITY_FSE_TYPE . '.id');
        $query = $this->db->from(QM_ENTITY_FSE_TYPE);
        $query = $this->db->where(QM_ENTITY_FSE_TYPE . '.fse_type_id', $fse_type_id);
        $query = $this->db->where(QM_ENTITY_FSE_TYPE . '.ent_id', $ent_id);
        $query = $this->db->where(QM_ENTITY_FSE_TYPE . '.task_type', $task_type);
        $query = $this->db->get();

        $result = array();
        foreach ($query->result_array() as $row) {
            $id = $row['id'];
        }

        return $this->UpdateData($fseData, $id, $table);
    }

    /*     * ***********  ChinnaRasu  ************ */

    public function create_not_integrated_data($data) {
        $query = $this->db->select(QM_EXTRA_ATTR_DEFINITION . '.Ext_att_category_id ,'
                . QM_EXTRA_ATTR_DEFINITION . '.Ext_att_name, '
                . QM_EXTRA_ATTR_DEFINITION . '.Ext_att_size, '
                . QM_EXTRA_ATTR_DEFINITION . '.Ext_att_type, '
                . QM_EXTRA_ATTR_DEFINITION . '.Extra_attr_Category_extr_att_cat_id, '
                . QM_EXTRA_ATTR_DEFINITION . '.Extra_attr_control, '
                . QM_EXTRA_ATTR_DEFINITION . '.Task_type_ID, '
                . QM_EXTRA_ATTR_DEFINITION . '.dependent_value, '
                . QM_EXTRA_ATTR_DEFINITION . '.ent_id, '
                . QM_EXTRA_ATTR_DEFINITION . '.extr_att_id, '
                . QM_EXTRA_ATTR_DEFINITION . '.qm_entity_id, '
                . QM_EXTRA_ATTR_DEFINITION . '.qm_status_type_id, '
                // . QM_EXTRA_ATTR_DEFINITION . '.*, '
                . QM_CATEGORY . '.category');
        $query = $this->db->from(QM_EXTRA_ATTR_DEFINITION);

        $query = $this->db->join(QM_CATEGORY, QM_CATEGORY . '.id = ' . QM_EXTRA_ATTR_DEFINITION . '.Ext_att_category_id');

        $query = $this->db->where(QM_EXTRA_ATTR_DEFINITION . '.qm_status_type_id', 1);
        $query = $this->db->where(QM_EXTRA_ATTR_DEFINITION . '.ent_id', $data);
        $query = $this->db->get();


        $data = array();
        $i = 0;
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach ($result as $r) {
                $data[$i] = $r;
                $data[$i]['extra_attr_option'] = '[]';
                $i++;
            }
        }

        return $data;
    }

    public function create_integrated_data($data) {
        $query = $this->db->select(API_SETTINGS . '.*');
        $query = $this->db->from(API_SETTINGS);


        $query = $this->db->where(API_SETTINGS . '.ent_id', $data);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function create_not_integrated($data) {
        $table = QM_EXTRA_ATTR_DEFINITION;
        $this->InsertData($table, $data);
        return $this->db->insert_id();
    }

    public function create_integrated($data) {
        $table = API_SETTINGS;
        $this->InsertData($table, $data);
        return $this->db->insert_id();
    }

    public function updateIntegrateselectdata($update_id = NULL, $task_type = NULL, $value = NULL, $depon = NULL) {
        $table = QM_SELECT_VALUE;

        foreach ($value as $k => $v) {
            $data = array(
                'task_type_id' => $task_type,
                'select_option_id' => $update_id,
                'option_value' => $v,
                'depond_value' => $depon[$k]
            );
            $this->InsertData($table, $data);
        }


        //return $this->db->insert_id();
    }

    public function update_integrated($data, $id) {
        $table = API_SETTINGS;
        $this->db->where('API_Settings_ID', $id);
        $query = $this->db->update($table, $data);
        return $id;
    }

    public function create_integrated_already_exist($data) {

        $this->db->select('API_Settings_ID');
        $this->db->from(API_SETTINGS);
        $this->db->where('ent_id', $data['ent_id']);
        $this->db->where('API_Task_Type_id', $data['API_Task_Type_id']);
        $this->db->where('qm_task_type_id', $data['qm_task_type_id']);
        $query = $this->db->get();
        // echo  $this->db->last_query();
        if ($query->num_rows() == 1) {
            return $query->row()->API_Settings_ID;
        } else {
            return FALSE;
        }
    }

    public function create_not_integrated_delete($id, $data) {
        $table = QM_EXTRA_ATTR_DEFINITION;

        $query = $this->db->delete(API_MAPPING, array('API_Field' => $id));

        $this->db->where('extr_att_id', $id);
//        $this->db->update($table, $data);
        $this->db->delete($table);
    }

    public function create_integrated_delete($id) {
        $table = API_MAPPING;

        $this->db->where($table . '.API_Mapping_Id ', $id);
        $this->db->delete($table);
    }

    public function api_setting_save($data) {
        $table = API_MAPPING;

        $this->InsertData($table, $data);
        return $this->db->insert_id();
    }

    public function create_integrated_data_list($data) {
        $query = $this->db->select(API_MAPPING . '.*');
        $query = $this->db->from(API_MAPPING);


        $query = $this->db->where(API_MAPPING . '.ent_id', $data);

        $this->db->join(QM_TASK_TYPE, QM_TASK_TYPE . '.id = ' . API_MAPPING . '.task_type');
        $this->db->where(API_MAPPING . '.ent_id', $data);
        $this->db->where(QM_TASK_TYPE . '.task_type_status', 1);
        $query = $this->db->get();

        return $query->result_array();
    }

    /*     * ***********  ChinnaRasu  ************ */

    public function asset_add($data) {
        $table = QM_SERVICE_NOW_ASSETS;

        $this->InsertData($table, $data);
        return $this->db->insert_id();
    }

    public function getAssets($ent_id = NULL) {
        $this->db->select(QM_SERVICE_NOW_ASSETS . '.*');
        $this->db->from(QM_SERVICE_NOW_ASSETS);
        if ($ent_id) {
            $query = $this->db->join(QM_TASK_TYPE, QM_TASK_TYPE . '.id = ' . QM_SERVICE_NOW_ASSETS . '.task_type');
            $this->db->where(QM_SERVICE_NOW_ASSETS . '.ent_id', $ent_id);
            $this->db->where(QM_TASK_TYPE . '.task_type_status', 1);
        }
        $this->db->order_by('id', 'ASC');
        $this->db->limit('10');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getEngineerTypes($ent_id = NULL) {
        $this->db->select(QM_SERVICE_NOW_ASSETS . '.*');
        $this->db->from(QM_SERVICE_NOW_ASSETS);
        if ($ent_id) {
            $query = $this->db->join(QM_TASK_TYPE, QM_TASK_TYPE . '.id = ' . QM_SERVICE_NOW_ASSETS . '.task_type');
            $this->db->where(QM_SERVICE_NOW_ASSETS . '.ent_id', $ent_id);
            $this->db->where(QM_TASK_TYPE . '.task_type_status', 1);
        }
        $this->db->order_by('id', 'ASC');
        $this->db->limit('10');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function addEntityFSETypes($data) {
        $table = QM_ENTITY_FSE_TYPE;

        $this->InsertData($table, $data);
        return $this->db->insert_id();
    }

    public function taskType_add($data) {
        $table = QM_TASK_TYPE;

        $this->InsertData($table, $data);
        return $this->db->insert_id();
    }

    public function getTaskType($ent_id = NULL, $id = NULL) {
        $this->db->select('id, task_type, task_type_description, integrated_api, completed_screen_data, states_data');
        $this->db->from(QM_TASK_TYPE);
        $this->db->where(QM_TASK_TYPE . '.task_type_status', 1);
        if ($ent_id) {
            $this->db->where(QM_TASK_TYPE . '.ent_id', $ent_id);
        }
        if ($id) {
            $this->db->where(QM_TASK_TYPE . '.id', $id);
        }
        $query = $this->db->get();

        return $query->result_array();
    }

    public function taskType_update($id, $data) {
        $table = QM_TASK_TYPE;
        return $this->UpdateData($data, $id, $table);
    }

    public function asset_update($id) {
        $table = QM_SERVICE_NOW_ASSETS;
        return $this->DeleteData($id, $table);
    }

    public function bulk_add($table, $data) {
        $this->db->insert_batch($table, $data);
        if ($this->db->affected_rows() > 0) {
            $returnData = array(
                'first_id' => $this->db->insert_id(),
                'row_count' => $this->db->affected_rows() - 1,
            );
            return $returnData;
        } else {
            return 0;
        }
    }

    public function mapFields_add($data) {
        $table = API_MAPPING;

        $this->InsertData($table, $data);
        return $this->db->insert_id();
    }

    public function mapFields_remove($id) {
        $table = API_MAPPING;

        $this->db->delete($table, array('API_Mapping_Id' => $id));
        $this->db->last_query();
        return $this->db->affected_rows();
    }

    public function deleteCommands($data) {
        $table = QM_COMMANDS;
        $this->db->where($table . '.ent_id ', $data['ent_id']);
        $this->db->where($table . '.task_type ', $data['task_type']);
        $this->db->where($table . '.task_type_tab_id ', $data['task_type_tab_id']);
        $this->db->where($table . '.command ', $data['command']);
        $this->db->delete($table);
    }

    public function addCommands($data) {
        $table = QM_COMMANDS;
        $this->InsertData($table, $data);

        return $this->db->insert_id();
    }

    public function getCommands($ent_id = NULL) {
        $this->db->select(QM_COMMANDS . '.*');
        $this->db->from(QM_COMMANDS);
        if ($ent_id) {
            $query = $this->db->join(QM_TASK_TYPE, QM_TASK_TYPE . '.id = ' . QM_COMMANDS . '.task_type');
            $this->db->where(QM_COMMANDS . '.ent_id', $ent_id);
            $this->db->where(QM_TASK_TYPE . '.task_type_status', 1);
        }
        $query = $this->db->get();

        return $query->result_array();
    }

    public function checkUnique($table = NULL, $data = array()) {
        $query = $this->db->get_where($table, $data);
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addUpdateIntegrateData($data) {
        $table = QM_EXTRA_ATTR_UPDATE;
        $this->InsertData($table, $data);

        return $this->db->insert_id();
    }

    public function getUpdateIntegrateData($ent_id = NULL) {



        $this->db->select(
                //  QM_EXTRA_ATTR_UPDATE . '.*,'
                QM_EXTRA_ATTR_UPDATE . '.id,'
                . QM_EXTRA_ATTR_UPDATE . '.ent_id,'
                . QM_EXTRA_ATTR_UPDATE . '.task_type,'
                . QM_EXTRA_ATTR_UPDATE . '.label,'
                . QM_EXTRA_ATTR_UPDATE . '.option_type,'
                . QM_EXTRA_ATTR_UPDATE . '.depondon,'
                . QM_EXTRA_ATTR_UPDATE . '.type_limit,'
                . QM_EXTRA_ATTR_UPDATE . '.category_id,'
                . QM_EXTRA_ATTR_UPDATE . '.required_status,'
                // . QM_EXTRA_ATTR_UPDATE . '.type_values,'
                . QM_EXTRA_ATTR_UPDATE . '.api_data,'
                . QM_EXTRA_ATTR_UPDATE . '.map_data,'
                . QM_EXTRA_ATTR_UPDATE . '.created_date,'
                . QM_CATEGORY . '.category');
        $this->db->from(QM_EXTRA_ATTR_UPDATE);
        $query = $this->db->join(QM_CATEGORY, QM_CATEGORY . '.id = ' . QM_EXTRA_ATTR_UPDATE . '.category_id');
        if ($ent_id) {
            $query = $this->db->join(QM_TASK_TYPE, QM_TASK_TYPE . '.id = ' . QM_EXTRA_ATTR_UPDATE . '.task_type');
            $this->db->where(QM_EXTRA_ATTR_UPDATE . '.ent_id', $ent_id);
            $this->db->where(QM_TASK_TYPE . '.task_type_status', 1);
        }
        $query = $this->db->get();
        $data = array();
        $i = 0;
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach ($result as $r) {
                $data[$i] = $r;
                $data[$i]['type_values'] = '[]';
                $i++;
            }
        }
        return $data;
        // return $query->result_array();
    }

    public function deleteIntegrateData($id) {
        $table = QM_EXTRA_ATTR_UPDATE;

        return $this->DeleteData($id, $table);
    }

    public function updateIntegrateMapData($id, $data) {
        $table = QM_EXTRA_ATTR_UPDATE;
        return $this->UpdateData($data, $id, $table);
    }

    public function get_taskFelidsbyTaskType($task_type_id = NULL) {
        $this->db->select(
                QM_EXTRA_ATTR_DEFINITION . '. Ext_att_name,'
                . QM_EXTRA_ATTR_DEFINITION . '. Task_type_ID,'
                . QM_EXTRA_ATTR_DEFINITION . '. extr_att_id,'
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

}
