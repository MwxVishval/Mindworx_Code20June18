<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class EntitySettingController extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("EntitySettingModel");
    }

    public function index() {

        $data['menu'] = '';
        $data['title'] = 'Categories';
        $data['page'] = 'CategoriesView';

        $this->load->view("common/CommonView", $data);
    }

    public function category() {

        $data['result'] = $this->EntitySettingModel->getCategory();
        $data['menu'] = '';
        $data['title'] = 'Categories';
        $data['page'] = 'CategoryView';
        $this->load->view("common/CommonView", $data);
    }

    public function category_add() {
        if ($this->input->post('submit')) {
            $ent_id = $this->input->post("ent_id");
            $category = $this->input->post("category");
            $this->form_validation->set_rules('ent_id', 'Entity', 'trim|required');
            $this->form_validation->set_rules('category', 'Category', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->EntitySettingModel->category_add($this->input->post());
                $this->session->set_flashdata('success_msg', 'Successfully created Category');
                redirect('category');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $this->load->model('ManagementModel');
        $data['result'] = $this->ManagementModel->company();
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Categories';
        $data['page'] = 'CategoryAddView';
        $this->load->view("common/CommonView", $data);
    }

    public function category_update() {
        $id = $this->input->post('edit_id');
        if ($this->input->post('submit')) {
            $ent_id = $this->input->post("ent_id");
            $category = $this->input->post("category");
            $this->form_validation->set_rules('ent_id', 'Entity', 'required');
            $this->form_validation->set_rules('category', 'Category', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                $datas = $this->EntitySettingModel->category_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated category');
                redirect('category');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        if ($this->input->post('edit')) {
            $data['result'] = $this->EntitySettingModel->category_update($id);
            $this->load->model('ManagementModel');
            $data['entities'] = $this->ManagementModel->company();
            $data['menu'] = '';
            $data['title'] = 'Categories';
            $data['page'] = 'CategoryEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('category_status' => 0);
            $assetDelete = $this->EntitySettingModel->category_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Successfully deleted category');
            redirect('category');
        }
    }

    public function task_sheet() {
        $ent_id = $this->input->post("ent_id");
        if (isset($ent_id)) {
            $data['menu'] = '';
            $data['title'] = 'Task Sheet';
            $data['page'] = 'TaskSheet';
            $data['ent_id'] = $this->input->post("ent_id");
            $this->load->view("common/CommonView", $data);
        } else {
            redirect('entity');
        }
    }

    public function add_category() {
        $data = array();
        $category = $this->input->post("category");
        $ent_id = $this->input->post("ent_id");
        $task_type = $this->input->post("task_type");
        if (isset($category) && isset($ent_id)) {
            $categoryData = array();
            $categoryData['category'] = $category;
            $categoryData['ent_id'] = $ent_id;
            $categoryData['task_type'] = $task_type;
            $isUnique = $this->EntitySettingModel->checkUnique(QM_CATEGORY, $categoryData);
            if ($isUnique) {
                $data['error'] = 'Category name is already existed!';
            } else {
                $categoryData['id'] = $this->EntitySettingModel->category_add($categoryData);
                $categoryData['success'] = 'Category has been added successfully!';
                $data = $categoryData;
            }
        } else {
            $data['error'] = 'Something went wrong! Please try again!';
        }

        echo json_encode($data);
    }

    public function add_fsetype() {
        $data = array();
        $fse_type_id = $this->input->post("fse_type_id");
        $ent_id = $this->input->post("ent_id");
        $task_type = $this->input->post("task_type");

        $fse_type_Data = array();
        $fse_type_Data['fse_type_id'] = $fse_type_id;
        $fse_type_Data['ent_id'] = $ent_id;
        $fse_type_Data['isactive'] = 1;
        $fse_type_Data['task_type'] = $task_type;
        $fse_type_Data['id'] = $this->EntitySettingModel->fsetype_add($fse_type_Data);
    }

    public function get_category() {
        $data = array();
        $ent_id = $this->input->get('ent_id');
        if (isset($ent_id)) {
            $data['result'] = $this->EntitySettingModel->getCategory($ent_id);
        } else {
            $data['error'] = 'Something went wrong! Please try again!';
        }

        echo json_encode($data);
    }

    public function update_category() {
        $data = array();
        $cat_id = $this->input->post('cat_id');
        $remove_status = $this->input->post('rem');
        $separate_update_screen = $this->input->post('separate_update_screen');
        if (isset($cat_id) && isset($separate_update_screen)) {
            $catData = array();
            if (isset($remove_status) && !empty($remove_status)) {
                $catData['category_status'] = 0;
            } else {
                $catData['separate_update_screen'] = $separate_update_screen;
            }
            $this->EntitySettingModel->category_edit($cat_id, $catData);
            if (isset($remove_status) && !empty($remove_status)) {
                $data['success'] = 'Category has been deleted successfully!';
            } else {
                $data['success'] = 'Category has been updated successfully!';
            }
        } else {
            $data['error'] = 'Something went wrong! Please try again!';
        }

        echo json_encode($data);
    }

    public function update_fsetype() {
        $data = array();
        $fse_type_id = $this->input->post('fse_type_id');
        $ent_id = $this->input->post('ent_id');
        $task_type = $this->input->post('task_type');

        $fseData['isactive'] = 0;

        $this->EntitySettingModel->update_fsetype($fse_type_id, $ent_id, $task_type, $fseData);
    }

    /*     * ***********  ChinnaRasu  ************ */

    public function create_not_integrated() {

        $ent_id = $this->input->post('ent_id');
        if (!empty($ent_id)) {
            $data = array(
                'ent_id' => $this->input->post('ent_id'),
                'Ext_att_name' => $this->input->post('label'),
                'Ext_att_type' => $this->input->post('field_type'),
                'Ext_att_size' => $this->input->post('limit'),
                'Ext_att_category_id' => $this->input->post('category'),
//                'Extra_attr_control' => $this->input->post('create_attri_control'),
                'Task_type_ID' => $this->input->post('task_id'),
                'extra_attr_option' => $this->input->post('value'),
                'dependent_value' => $this->input->post('dependent_value'),
                'qm_status_type_id' => 1
            );

            $data_check = array(
                'ent_id' => $this->input->post('ent_id'),
                'Ext_att_name' => $this->input->post('label'),
                //     'Ext_att_type' => $this->input->post('field_type'),
                //     'Ext_att_size' => $this->input->post('limit'),
                //    'Ext_att_category_id' => $this->input->post('category'),
//                'Extra_attr_control' => $this->input->post('create_attri_control'),
                'Task_type_ID' => $this->input->post('task_id'),
                'qm_status_type_id' => 1
            );

            $check = $this->EntitySettingModel->checkUnique(QM_EXTRA_ATTR_DEFINITION, $data_check);
            if ($check == FALSE) {
                $data['extr_att_id'] = $this->EntitySettingModel->create_not_integrated($data);
                $data['success'] = 'Label has been added successfully!';
            } else {
                $data['error'] = 'Already exits in field list!';
            }
        } else {
            $data['error'] = 'Something went wrong! Please try again!';
        }

        echo json_encode($data);
    }

    public function create_integrated() {

        $ent_id = $this->input->post('ent_id');
        if (!empty($ent_id)) {

            if ($this->input->post('tab_id') == 2) {

                $str = md5($this->input->post('task_type_id') . $this->input->post('ent_id') . $this->input->post('tab_id') . date('m/d/Y h:i:s a', time()));
                $data_show = array(
                    "apiKey" => $str,
                    "fseEmail" => "fseemail@mail.com",
                    "task_name" => "fixing Example",
                    "priority" => "HIGH",
                    "taskStatus" => "Assigned",
                    "taskLocationAddress" => "Full address",
                );
                $field = array();
                $qm_task_type_id = $this->input->post('task_type_id');
                $field_list = $this->EntitySettingModel->get_taskFelidsbyTaskType($qm_task_type_id);
                if (!empty($field_list)) {
                    foreach ($field_list as $data_result) {
                        $field[$data_result['Ext_att_name']] = $data_result['Ext_att_name'] . ' example_data';
                    }
                }
                $api_url = "Request URL (REST API) = " . base_url() . "TPServices/CreateTask";
                $sample_request = "  Sample JSON Request = " . json_encode(array_merge($data_show, $field));
                $method_data = $api_url . $sample_request;
                $API_Key = $str;
            } else {
                $method_data = $this->input->post('method');
                $API_Key = $this->input->post('api_key');
            }


            $data = array(
                'ent_id' => $this->input->post('ent_id'),
                'API_Method_Name' => $method_data,
                'API_End_point' => $this->input->post('endpoint'),
                'API_User_name' => $this->input->post('username'),
                'API_Password' => $this->input->post('password'),
//                'API_XML_File' => $this->input->post('xml_file'),
                'API_Task_Type_id' => $this->input->post('tab_id'),
                'Run_mode' => $this->input->post('api'),
                'API_Key' => $API_Key,
                'qm_task_type_id' => $this->input->post('task_type_id'),
            );
            $api_exist = $this->EntitySettingModel->create_integrated_already_exist($data);

            if ($api_exist == FALSE) {
                $data['extr_att_id'] = $this->EntitySettingModel->create_integrated($data);
            } else {
                $data['extr_att_id'] = $this->EntitySettingModel->update_integrated($data, $api_exist);
            }

            $data['success'] = 'Api has been added successfully!';
        } else {
            $data['error'] = 'Something went wrong! Please try again!';
        }
        echo json_encode($data);
    }

    public function create_not_integrated_data() {
        $ent_id = $this->input->post('ent_id');


        $data = $this->EntitySettingModel->create_not_integrated_data($ent_id);
        echo json_encode($data);
    }

    public function create_not_integrated_delete() {
        $delete_id = $this->input->post('id');

        $data = array(
            'qm_status_type_id' => 0
        );

        $data = $this->EntitySettingModel->create_not_integrated_delete($delete_id, $data);

        echo 'success';
    }

    public function create_integrated_delete() {
        $delete_id = $this->input->post('id');
        $data = $this->EntitySettingModel->create_integrated_delete($delete_id);

        echo 'success';
    }

    public function api_setting_save() {

        $map_fields = $this->input->post('map_fields');
        $end_point_control = $this->input->post('end_point_control');
        $api_settings_id = $this->input->post('api_settings_id');
        $Ent_id = $this->input->post('Ent_id');
        $Task_Type_id = $this->input->post('Task_Type_id');

        if ((!empty($map_fields)) && (!empty($end_point_control)) && (!empty($api_settings_id))) {
            $data = array(
                'API_Field' => $this->input->post('map_fields'),
                'End_Point' => $this->input->post('end_point_control'),
                'API_Settings_API_Settings_ID' => $this->input->post('api_settings_id'),
                'Ent_id' => $this->input->post('Ent_id'),
                'API_Task_Type_id' => $this->input->post('Task_Type_id')
            );
            $data['id'] = $this->EntitySettingModel->api_setting_save($data);
            $data['success'] = "successfully!";
        } else {
            $data['error'] = "Fail";
        }

        echo json_encode($data);
    }

    /*     * ***********  ChinnaRasu  ************ */

    public function add_asset() {
        $data = array();
        $ent_id = $this->input->post("ent_id");
        $task_type = $this->input->post("task_type");
        $display_name = $this->input->post("display_name");
        $type = $this->input->post("type");
        $description = $this->input->post("description");
        if (isset($ent_id) && isset($display_name) && isset($type) && isset($description)) {
            $assetData = array();
            $assetData['ent_id'] = $ent_id;
            $assetData['task_type'] = $task_type;
            $assetData['type'] = $type;
            $assetData['description'] = $description;
            $assetData['display_name'] = $display_name;
            $assetData['id'] = $this->EntitySettingModel->asset_add($assetData);
            $assetData['success'] = "Asset has been added successfully!";
            $data = $assetData;
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }
        echo json_encode($data);
    }

    public function getTabDetails() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        if (isset($ent_id)) {
            $tabs = $this->EntitySettingModel->getTaskType($ent_id);
            $tabDetails = array();
            foreach ($tabs as $tab) {
                $tabDetails[] = array(
                    'id' => $tab['id'],
                    'task_type' => $tab['task_type'],
                    'task_type_description' => $tab['task_type_description'],
                    'integrated_api' => json_decode($tab['integrated_api']),
                    'completed_screen' => json_decode($tab['completed_screen_data']),
                    'states_data' => json_decode($tab['states_data']),
                );
            }

            $data['task_type'] = $tabDetails;
            $data['categories'] = $this->EntitySettingModel->getCategory($ent_id);
            $data['getUpdateTabDepondOn'] = $this->EntitySettingModel->getUpdateTabDepondOn($ent_id);
            $data['create'] = $this->EntitySettingModel->create_not_integrated_data($ent_id);
            $apiData = $this->EntitySettingModel->create_integrated_data($ent_id);

            $data['api_data'] = $this->groupTabData($apiData, 'apiData');
            $integrateData = $this->EntitySettingModel->create_integrated_data_list($ent_id);
            $data['integrateData'] = $this->groupTabData($integrateData, 'integrateData');
            $tmp = $this->EntitySettingModel->getUpdateIntegrateData($ent_id);
            $updateintegrateData = array();
            foreach ($tmp as $value) {
                $type_value = json_decode($value['type_values']);
                $api_data = json_decode($value['api_data']);

                if ($value['required_status'] == 1) {
                    $required_status = "Yes";
                } else {
                    $required_status = "No";
                }

                if ($value['depondon'] == NULL) {
                    $depondon = "";
                } else {
                    $depondon = $value['depondon'];
                }

                $updateintegrateData[] = array(
                    'id' => $value['id'],
                    'task_type' => $value['task_type'],
                    'label' => $value['label'],
                    'option_type' => $value['option_type'],
                    'type_limit' => $value['type_limit'],
                    'category' => $value['category'],
                    'depondon' => $depondon,
                    'required_status' => $required_status,
                    'type_values' => (!empty($type_value)) ? implode(',', $type_value) : '',
                    'endpoint' => (!empty($api_data)) ? $api_data->endpoint : '',
                    'map_data' => $value['map_data']
                );
            }
            $data['updateintegrateData'] = $updateintegrateData;
            $data['assets'] = $this->EntitySettingModel->getAssets($ent_id);


            foreach ($tabDetails as $k => $tabdata) {
                $allfsetypes[$k]['task_type'] = $tabdata['id'];
                $allfsetypes[$k]['taskbylist'] = $this->EntitySettingModel->getEnityFSETypesByTaskType($ent_id, $tabdata['id']);
            }
            $data['allfsetypes'] = $allfsetypes;
            $data['fse_type_id'] = $this->EntitySettingModel->getEnityFSETypes($ent_id);
            $commands = $this->EntitySettingModel->getCommands($ent_id);
            $data['commands'] = $this->groupTabData($commands, 'commandData');
            $data['success'] = 'success';
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }
        echo json_encode($data);
    }

    function deleteElement($element, &$array) {
        $index = array_search($element, $array);
        if ($index !== false) {
            unset($array[$index]);
        }
    }

    public function getsbOneList() {

        $task_type = $this->input->post('task_type');
        $allfsetypes = $this->EntitySettingModel->getFSETypes();
        $fse_type_id = $this->EntitySettingModel->getEnityFSETypesByTaskType($task_type);
        foreach ($allfsetypes as $i => $data2) {
            foreach ($fse_type_id as $k => $data1) {
                if ($data2['id'] == $data1['fse_type_id']) {
                    unset($allfsetypes[$i]);
                }
            }
        }
        $allfsetypes1 = array_values($allfsetypes);
        $data['allfsetypes'] = $allfsetypes1;
        $data['allfsetypes_cnt'] = count($allfsetypes);
        echo json_encode($data);
    }

    private function groupTabData($data = array(), $process = NULL) {
        $returnData = array();
        $defaultIndex = '';
        if ($process == 'apiData') {
            $defaultIndex = 'API_Task_Type_id';
        } elseif ($process == 'integrateData') {
            $defaultIndex = 'task_type_tab_id';
        } elseif ($process == 'commandData') {
            $defaultIndex = 'task_type_tab_id';
        } else {
            return false;
            exit;
        }
        foreach ($data as $value) {
            $index = '';
            if ($value[$defaultIndex] == 2) {
                $index = 'create';
            } else if ($value[$defaultIndex] == 3) {
                $index = 'update';
            } else if ($value[$defaultIndex] == 5) {
                $index = 'assets';
            } else if ($value[$defaultIndex] == 8) {
                $index = 'onhold';
            } else if ($value[$defaultIndex] == 9) {
                $index = 'reject';
            } else if ($value[$defaultIndex] == 10) {
                $index = 'engineertype';            
            } else if ($value[$defaultIndex] == 11) {
                $index = 'taskreport';
            }
            if ($process == 'apiData') {
                $returnData[$index][] = array(
                    'API_Settings_ID' => $value['API_Settings_ID'],
                    'API_Method_Name' => $value['API_Method_Name'],
                    'API_End_point' => $value['API_End_point'],
                    'API_User_name' => $value['API_User_name'],
                    'API_Password' => $value['API_Password'],
//                    'API_XML_File' => $value['API_XML_File'],
                    'API_Key' => $value['API_Key'],
                    'API_Task_Type_id' => $value['API_Task_Type_id'],
                    'qm_task_type_id' => $value['qm_task_type_id'],
                );
            } elseif ($process == 'integrateData') {
                $returnData[$index][] = array(
                    'API_Mapping_Id' => $value['API_Mapping_Id'],
                    'API_Field' => $value['API_Field'],
                    'MapTo' => $value['MapTo'],
                    'End_Point' => $value['End_Point'],
                    'API_Settings_API_Settings_ID' => $value['API_Settings_API_Settings_ID'],
                    'task_type' => $value['task_type'],
                    'task_type_tab_id' => $value['task_type_tab_id'],
                );
            } elseif ($process == 'commandData') {
                $returnData[$index][] = array(
                    'id' => $value['id'],
                    'task_type' => $value['task_type'],
                    'task_type_tab_id' => $value['task_type_tab_id'],
                    'command' => $value['command']
                );
            }
        }

        return $returnData;
    }

    public function add_task_type() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        $taskName = $this->input->post('task_type_name');
        if (isset($ent_id) && isset($taskName)) {
            $taskData = array();
            $taskData['ent_id'] = $ent_id;
            $taskData['task_type'] = $taskName;
            $isUnique = $this->EntitySettingModel->checkUnique(QM_TASK_TYPE, $taskData);
            if ($isUnique) {
                $data['error'] = "Task type name is already existed";
            } else {
                $integrated_api = array(
                    'create' => 0,
                    'update' => 0,
                    'asset' => 0,
                    'asset_status' => 0,
                    'allow_for' => 0,
                    'onhold' => 0,
                    'onhold_comment' => 0,
                    'reject' => 0,
                    'reject_comment' => 0
                );
                $completed_screen = array(
                    'signature' => 0,
                    'ratings' => 0,
                    'comments' => 0
                );
                $states_data = array(
                    'assigned' => 'Assigned',
                    'accepted' => 'Accepted',
                    'rejected' => 'Rejected',
                    'inprogress' => 'Inprogress',
                    'onhold' => 'Onhold',
                    'resolved' => 'Resolved'
                );
                $taskData['integrated_api'] = json_encode($integrated_api);
                $taskData['completed_screen_data'] = json_encode($completed_screen);
                $taskData['states_data'] = json_encode($states_data);
                $taskData['id'] = $entity_id = $this->EntitySettingModel->taskType_add($taskData);
                $datafsetypes = $this->EntitySettingModel->getFSETypes();
                foreach ($datafsetypes as $k => $data) {
                    $insertdatafsetypes[$k]['fse_type_id'] = $data['id'];
                    $insertdatafsetypes[$k]['ent_id'] = $entity_id;
                    $insertdatafsetypes[$k]['isactive'] = 0;
                }

                foreach ($insertdatafsetypes as $data) {
                    $this->EntitySettingModel->addEntityFSETypes($data);
                }
                unset($taskData['integrated_api']);
                unset($taskData['states_data']);
                $taskData['integrated_api'] = $integrated_api;
                $taskData['states_data'] = $states_data;
                $data = $taskData;
            }
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }
        echo json_encode($data);
    }

    public function remove_task_type() {
        $data = array();
        $task_id = $this->input->post('task_id');
        if (isset($task_id)) {
            $taskData = array();
            $taskData['task_type_status'] = 0;
            $this->EntitySettingModel->taskType_update($task_id, $taskData);
            $data['success'] = "Task type has been deleted successfully!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function remove_asset() {
        $data = array();
        $asset_id = $this->input->post('asset_id');
        if (isset($asset_id)) {
            $this->EntitySettingModel->asset_update($asset_id);
            $data['success'] = 'Asset has been removed successfully!';
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function upload_csv() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        if (isset($_FILES) && isset($ent_id)) {
            $ent_id = $this->input->post('ent_id');
            $task_type = $this->input->post('task_type');

            $file = fopen($_FILES[0]['tmp_name'], 'r');
            $bulkData = array();
            while (($assetData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $bulkData[] = array(
                    'ent_id' => $ent_id,
                    'task_type' => $task_type,
                    'type' => $assetData[0],
                    'u_is_serialised' => $assetData[1],
                    'display_name' => $assetData[2]
                );
            }
            fclose($file);
            $insertId = $this->EntitySettingModel->bulk_add(QM_SERVICE_NOW_ASSETS, $bulkData);
            if (!empty($insertId)) {
                $startCount = $insertId['first_id'];
                $count = $insertId['row_count'] + $startCount;
                foreach ($bulkData as $value) {
                    $data['data'][] = array(
                        'id' => $startCount,
                        'ent_id' => $value['ent_id'],
                        'task_type' => $value['task_type'],
                        'type' => $value['type'],
                        'u_is_serialised' => $value['u_is_serialised'],
                        'description' => $value['display_name'],
                        'display_name' => $value['display_name'],
                        'start' => $startCount,
                        'count' => $count
                    );
                    if ($count >= $startCount) {
                        $startCount++;
                    } else {
                        break;
                    }
                }
            }
            $data['success'] = 'Asset has been added successfully!';
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function update_task_type() {
        $data = array();
        $task_id = $this->input->post('task_id');
        $type = $this->input->post('type');
        $value = $this->input->post('value');
        if (isset($task_id) && isset($type) && isset($value)) {
            $row = $this->EntitySettingModel->getTaskType('', $task_id);
            $integrated_api = json_decode($row[0]['integrated_api']);
            $update_api = array();
            foreach ($integrated_api as $key => $api) {
                if ($key == $type) {
                    $update_api[$key] = $value;
                } else {
                    $update_api[$key] = $api;
                }
            }
            $taskData = array(
                'integrated_api' => json_encode($update_api)
            );
            $this->EntitySettingModel->taskType_update($task_id, $taskData);
            $data['success'] = strtoupper($type) . " integrated api settings has been updated successfully!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function add_map_fields() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        $api = $this->input->post('api');
        $text = $this->input->post('text');
        $end_point = $this->input->post('end_point');
        $api_id = $this->input->post('api_id');
        $task_type = $this->input->post('task_type');
        $task_type_tab = $this->input->post('task_type_tab');
        if (isset($end_point) && isset($api) && isset($text) && isset($end_point) && isset($api_id) && isset($task_type)) {
            $mapData = array(
                'ent_id' => $ent_id,
                'API_Field' => $api,
                'MapTo' => $text,
                'End_Point' => $end_point,
                'API_Settings_API_Settings_ID' => $api_id,
                'task_type' => $task_type,
                'task_type_tab_id' => $task_type_tab
            );
            $data = $mapData;
            $data['API_Mapping_Id'] = $this->EntitySettingModel->mapFields_add($mapData);
            $data['success'] = 'Mapping fields has been added successfully!';
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }
        echo json_encode($data);
    }

    public function remove_map_fields() {
        $data = array();
        $mapId = $this->input->post('map_id');
        if (isset($mapId)) {
            $this->EntitySettingModel->mapFields_remove($mapId);
            $data['success'] = 'Mapping fields has been deleted successfully!';
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function update_complete_screen() {
        $data = array();
        $task_id = $this->input->post('task_type');
        $type = $this->input->post('type');
        $value = $this->input->post('value');
        if (isset($task_id) && isset($type) && isset($value)) {
            $row = $this->EntitySettingModel->getTaskType('', $task_id);
            $completed_screen_data = json_decode($row[0]['completed_screen_data']);
            $update_data = array();
            foreach ($completed_screen_data as $key => $screenValue) {
                if ($key == $type) {
                    $update_data[$key] = $value;
                } else {
                    $update_data[$key] = $screenValue;
                }
            }
            $taskData = array(
                'completed_screen_data' => json_encode($update_data)
            );
            $this->EntitySettingModel->taskType_update($task_id, $taskData);
            $data['success'] = "Completed screen features has been updated!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function addCommands() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        $task_type = $this->input->post('task_type');
        $tab_id = $this->input->post('tab_id');
        $command = $this->input->post('command');
        if (isset($ent_id) && isset($task_type) && isset($tab_id) && isset($command)) {
            $commandData = array(
                'ent_id' => $ent_id,
                'task_type' => $task_type,
                'task_type_tab_id' => $tab_id,
                'command' => $command
            );

            $check_condition = $this->EntitySettingModel->checkUnique(QM_COMMANDS, $commandData);
            if ($check_condition == false) {
                $this->EntitySettingModel->addCommands($commandData);
                $data['success'] = "Command has been added successfully";
            } else {
                $data['error'] = "Already exits! Please try again!";
            }
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function deleteCommands() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        $task_type = $this->input->post('task_type');
        $tab_id = $this->input->post('tab_id');
        $command = $this->input->post('command');
        if (isset($ent_id) && isset($task_type) && isset($tab_id) && isset($command)) {
            $commandData = array(
                'ent_id' => $ent_id,
                'task_type' => $task_type,
                'task_type_tab_id' => $tab_id,
                'command' => $command
            );
            $this->EntitySettingModel->deleteCommands($commandData);
            $data['success'] = "Command has been added successfully";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function update_states() {
        $data = array();
        $task_id = $this->input->post('task_type');
        $assigned = $this->input->post('assigned');
        $accepted = $this->input->post('accepted');
        $rejected = $this->input->post('rejected');
        $inprogress = $this->input->post('inprogress');
        $onhold = $this->input->post('onhold');
        $resolved = $this->input->post('resolved');

        if (isset($task_id) && isset($assigned)) {
            $states_data = array(
                'assigned' => $assigned,
                'accepted' => $accepted,
                'rejected' => $rejected,
                'inprogress' => $inprogress,
                'onhold' => $onhold,
                'resolved' => $resolved
            );
            $taskData = array(
                'states_data' => json_encode($states_data)
            );
            $this->EntitySettingModel->taskType_update($task_id, $taskData);
            $data['success'] = "States has been updated!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function updateIntegrateData() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        $task_type = $this->input->post('task_type');
        $label = $this->input->post('label');
        $type = $this->input->post('type');
        $limit = $this->input->post('limit');
        $category = $this->input->post('category');
        $required = $this->input->post('required');
        $value = json_decode($this->input->post('value'));
        $depon = json_decode($this->input->post('depon'));
        $depond_on = $this->input->post('depond_on');
        if (isset($ent_id)) {


            if ($type == "SELECT") {
                $tabData = array(
                    'ent_id' => $ent_id,
                    'task_type' => $task_type,
                    'label' => $label,
                    'option_type' => $type,
                    'type_limit' => $limit,
                    'category_id' => $category,
                    'required_status' => $required,
                );
            } else {
                $tabData = array(
                    'ent_id' => $ent_id,
                    'task_type' => $task_type,
                    'label' => $label,
                    'option_type' => $type,
                    'type_limit' => $limit,
                    'category_id' => $category,
                    'depondon' => $depond_on,
                    'required_status' => $required,
                    'type_values' => json_encode($value)
                );
            }

            $success_res = $tabData_check = array(
                'ent_id' => $ent_id,
                'task_type' => $task_type,
                'label' => $label,
                'category_id' => $category,
            );

            $data_check = $this->EntitySettingModel->checkUnique(QM_EXTRA_ATTR_UPDATE, $tabData_check);
            if ($data_check == FALSE) {
                $data['id'] = $update_id = $this->EntitySettingModel->addUpdateIntegrateData($tabData);
                if ($type == "SELECT") {
                    $this->EntitySettingModel->updateIntegrateselectdata($update_id, $task_type, $value, $depon);
                }
                $data['getUpdateTabDepondOn'] = $this->EntitySettingModel->getUpdateTabDepondOn($ent_id);
                $data['success'] = "Data has been added successfully!";
            } else {
                $data['error'] = "Field name already in list";
            }
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function deleteIntegrateData() {
        $data = array();
        $id = $this->input->post('id');
        if (isset($id)) {
            $this->EntitySettingModel->deleteIntegrateData($id);
            $data['success'] = "Data has been deleted successfully!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }


        echo json_encode($data);
    }

    public function updateApiData() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        $task_type = $this->input->post('task_type');
        $label = $this->input->post('label');
        $type = $this->input->post('type');
        $limit = $this->input->post('limit');
        $category = $this->input->post('category');
        $required = $this->input->post('required');
        $method = $this->input->post('method');
        $endpoint = $this->input->post('endpoint');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if (isset($ent_id)) {
            $apiData = array(
                'method' => $method,
                'endpoint' => $endpoint,
                'username' => $username,
                'password' => $password
            );

            $tabData = array(
                'ent_id' => $ent_id,
                'task_type' => $task_type,
                'label' => $label,
                'option_type' => $type,
                'type_limit' => $limit,
                'category_id' => $category,
                'required_status' => $required,
                'api_data' => json_encode($apiData)
            );
            $data['id'] = $this->EntitySettingModel->addUpdateIntegrateData($tabData);
            $data['success'] = "Data has been added successfully!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function updateIntegrateMapData() {
        $data = array();
        $id = $this->input->post('id');
        $value = $this->input->post('value');

        if (isset($id) && isset($value)) {
            $mapData = array(
                'map_data' => $value
            );
            $this->EntitySettingModel->updateIntegrateMapData($id, $mapData);
            $data['success'] = "Data has been update successfully!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function test() {
        $this->EntitySettingModel->get_taskFelidsbyTaskType(8);
    }

}
