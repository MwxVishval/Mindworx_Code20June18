<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class TaskController extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("TaskModel");
    }

    /* This controller is using for display task details */

    public function taskList() {

        if ($this->input->post('submit')) {
            $session_data = $this->session->userdata('session_data');
            $session_data->task_type_id = $this->input->post('tasktypeid');
            $session_data->start_date_search = $this->input->post('start_date');
            $session_data->end_date_search = $this->input->post('end_date');
            $this->session->set_userdata('session_data', $session_data);
        }


        $start_date = $this->session->userdata('session_data')->start_date_search;
        $end_date = $this->session->userdata('session_data')->end_date_search;
        $tasktypeid = $this->session->userdata('session_data')->task_type_id;

        $start_date = "2018-01-06 11:48:44";
        $end_date == "2018-02-06 11:48:44";
        $tasktypeid == "1";

        if ($start_date == "" || $end_date == "" || $tasktypeid == "") {
            redirect('task');
        }
        $data['entityFeilds'] = $this->TaskModel->entityFeilds();
        $data['result'] = $this->TaskModel->taskCustFieldReport(NULL, $tasktypeid, $start_date, $end_date);
        $data['menu'] = '';
        $data['title'] = 'Task';
        $data['page'] = 'TaskView';
        $this->load->view("common/CommonView", $data);
    }

    public function alltasks() {

        $data['entityFeilds'] = $this->TaskModel->entityFeilds();
        $data['result'] = $this->TaskModel->taskListReport();
        $data['menu'] = '';
        $data['title'] = 'Task';
        $data['page'] = 'TaskListView';
        $this->load->view("common/CommonView", $data);
    }

    public function task() {
        $data['result'] = $this->TaskModel->gettasktypeHeaderModel();
        $data['menu'] = '';
        $data['title'] = 'Task';
        $data['page'] = 'TaskSearchView';
        $this->load->view("common/CommonView", $data);
    }

    public function getTask_autocomplete_c() {
        $keyword = $this->input->post('term');
        $this->TaskModel->getTask_autocomplete($keyword);
    }

    public function getFse_autocomplete_c() {
        $keyword = $this->input->post('term');
        $this->TaskModel->getFse_autocomplete($keyword);
    }

    public function getIncident_autocomplete_c() {
        $keyword = $this->input->post('term');
        $this->TaskModel->getIncident_autocomplete($keyword);
    }

    public function getProject_autocomplete_c() {
        $keyword = $this->input->post('term');
        $this->TaskModel->getProject_autocomplete($keyword);
    }

    public function productline_autocomplete_c() {
        $keyword = $this->input->post('term');
        $this->TaskModel->productline_autocomplete($keyword);
    }

    public function settasktype() {
        $id = $this->input->post('id');
        $session_data = $this->session->userdata('session_data');
        $session_data->task_type_id = $id;
        $session_data->form_submit_check = 1;
        $this->session->set_userdata('session_data', $session_data);
        return TRUE;
    }

    /* This controller is using for add task details */

    public function addTask() {
        $valid = $this->session->userdata('session_data');
        if ($valid->task_type_id == "") {
            redirect('task', 'refresh');
        }
       
        if ($valid->form_submit_check != 1) {
            redirect('task', 'refresh');
        }
        $task_type = $valid->task_type_id;
        //echo $task_type;
       
        $data['entityid'] = $this->TaskModel->entityid();
        $data['entitycreateFilds'] = $this->TaskModel->taskcreateFields();
        $data['result'] = $this->TaskModel->typeDetails();
        $data['entityFeilds'] = $this->TaskModel->entityFeilds();
        $data['menu'] = '';
        $data['title'] = 'Task';
        $data['page'] = 'AddTaskView';

        if ($this->input->post('submit')) {
            
            $value_post = $this->input->post();  
               if (isset($value_post['task_address'])) {
                $address_lang = NULL;
                $address = urldecode($this->input->post('task_address'));
                $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
                $geo = json_decode($geo, true);
                if ($geo['status'] == 'OK') {
                    $latitude = $geo['results'][0]['geometry']['location']['lat'];
                    $longitude = $geo['results'][0]['geometry']['location']['lng'];
                    $taskLocation = '(' . $latitude . ', ' . $longitude . ')';
                } else {
                    $taskLocation = $this->input->post('task_location');
                }
            }
            
            if($this->input->post('auto_routecheck') == 'on' && $this->input->post('fse_id') == '')
            {
               $fse_id =$this->TaskModel->getAutoFse($task_type,$taskLocation) ; 
                                 
            }
            else
            $fse_id = $this->input->post('fse_id');            

            $session_data = $this->session->userdata('session_data');
            $session_data->form_submit_check = 0;
            $this->session->set_userdata('session_data', $session_data);

            $this->form_validation->set_rules('task_name', 'Task Name', 'trim|required|callback_checkTaskName');
            $this->form_validation->set_rules('fse_id', 'FSE Name', 'required');
            $this->form_validation->set_rules('status_id', 'Status', 'required');
            $this->form_validation->set_rules('priority', 'priority', 'required');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
            $this->form_validation->set_rules('task_address', 'Task Address', 'required');
            $this->form_validation->set_rules('task_location', 'Task Location', 'required');
            
            $ins_data = $this->input->post(); 
            
            
            $task_name = $this->input->post('task_name');
            $statusid = $this->input->post('status_id');
            $ins_data['fse_id']=$fse_id;
            $taskID = $this->TaskModel->insertTaskCust($ins_data);
          
            $this->TaskModel->insertTaskExtraFields($ins_data, $taskID);
          
       
            $this->session->set_flashdata('success_msg', 'Successfully create task');
            $taskLocation = NULL;
         
            $data = array(
                'task_id' => $taskID,
                'start_time' => '',
                'task_location' => $taskLocation
            );
            $device_type = $this->TaskModel->getFseDeviceType($fse_id);
            if (trim($device_type) == "iOS") {
               // $this->send_ios_push($fse_id, $this->input->post(), $taskID);
            } else {
               // $this->send_android_push($fse_id, $this->input->post(), $taskID);
            }
            $this->TaskModel->insertTaskLocation($data);             
            $this->TaskModel->WebInsertPushNotification($taskID, $task_name, $statusid);
             
            redirect('tasklist');
        }
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete task details  */

    public function updateTask() {
        $id = $this->input->post('edit_id');
        $task_location = $this->input->post('task_location');
        $data['results'] = $this->TaskModel->typeDetails();
        $data['entityFeilds'] = $this->TaskModel->entityFeilds();
        if ($this->input->post('submit')) {
            //     $this->session->set_flashdata('success_msg', 'Successfully updated task');
            //     redirect('task');
            $session_data = $this->session->userdata('session_data');
            $session_data->form_submit_check = 0;
            $this->session->set_userdata('session_data', $session_data);

            $fse_id = $this->input->post('fse_id');
            $task_id = $this->input->post('task_id');
            $task_name = $this->input->post('task_name');
            $statusid = $this->input->post('status_id');
            $insert['task_name'] = $this->input->post('task_name');
            $insert['fse_id'] = $this->input->post('fse_id');
            $insert['status_id'] = $this->input->post('status_id');
            $insert['priority'] = $this->input->post('priority');
            $insert['start_date'] = date('Y-m-d H:i:s', strtotime($this->input->post('start_date')));
            $insert['task_address'] = $this->input->post('task_address');
            $taskLocation = $this->input->post('task_location');
            if ($task_location == "") {
                $address_lang = NULL;
                $address = urldecode($this->input->post('task_address'));
                $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
                $geo = json_decode($geo, true);
                if ($geo['status'] == 'OK') {
                    $latitude = $geo['results'][0]['geometry']['location']['lat'];
                    $longitude = $geo['results'][0]['geometry']['location']['lng'];
                    $taskLocation = '(' . $latitude . ', ' . $longitude . ')';
                } else {
                    $taskLocation = $this->input->post('task_location');
                }
            }
            $datas = $this->TaskModel->editTask($task_id, $insert);
            $datas = $this->TaskModel->updateExtAtturTask($this->input->post());
            $this->TaskModel->editTaskLocation($task_id, $taskLocation);
            $device_type = $this->TaskModel->getFseDeviceType($fse_id);
            if (trim($device_type) == "iOS") {
                $this->send_ios_push($fse_id, $this->input->post(), $task_id);
            } else {
                $this->send_android_push($fse_id, $this->input->post(), $task_id);
            }
            $this->TaskModel->WebInsertPushNotification($task_id, $task_name, $statusid);
            //$sql = $this->db->last_query();
            $this->session->set_flashdata('success_msg', 'Successfully updated task');
            redirect('tasklist');
        }

        if ($this->input->post('updateView')) {
            // $data['results'] = $this->TaskModel->typeDetails();
            $id = $this->input->post('edit_id');
            if ($id == NULL) {
                redirect('tasklist');
            }
            $data['task_details'] = $this->TaskModel->DetailViewTaskDetails($id);
            $data['results'] = $this->TaskModel->updateTaskScreen($id);
            $data['customer_document'] = $this->TaskModel->updateTaskScreenimage($id);
            $data['menu'] = '';
            $data['title'] = 'Task Update View';
            $data['page'] = 'TaskUpdateView';
            $this->load->view("common/CommonView", $data);
        }

        if ($this->input->post('edit')) {

            $session_data = $this->session->userdata('session_data');
            $session_data->form_submit_check = 1;
            $this->session->set_userdata('session_data', $session_data);
            $valid = $this->session->userdata('session_data');
            if ($valid->form_submit_check != 1) {
                redirect('task', 'refresh');
            }
            $id = $this->input->post('edit_id');
            $data['entitycreateFilds'] = $this->TaskModel->taskCustFieldupdate($id);
            $data['resultset'] = $this->TaskModel->typeDetails();
            $data['entityFeilds'] = $this->TaskModel->entityFeilds();
            $data['results'] = $this->TaskModel->typeDetails();
            $data['result'] = $plcode = $this->TaskModel->updateTask($id);
            $data['resultLoc'] = $this->TaskModel->updateTaskLocation($id);
            $data['entityFeilds'] = $this->TaskModel->entityFeilds();
            $data['menu'] = '';
            $data['title'] = 'Task';
            $data['page'] = 'TaskEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data['entityFeilds'] = $this->TaskModel->entityFeilds();
            $data = array('task_status' => 0);
            $aa = $this->TaskModel->editTask($id, $data);
            $sql = $this->db->last_query();
            $this->session->set_flashdata('note_msg', 'Successfully deleted task');
            redirect('task');
        }
        if ($this->input->post('assign')) {
            $data['results'] = $this->TaskModel->typeDetails();
            $data['result'] = $this->TaskModel->updateTask($id);
            $data['resultLoc'] = $this->TaskModel->updateTaskLocation($id);
            $data['entityFeilds'] = $this->TaskModel->entityFeilds();
            $this->session->set_flashdata('note_msg', 'Successfully Assigned tasks');
            $data['menu'] = '';
            $data['title'] = 'Task';
            $data['page'] = 'TaskEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('reassign')) {
            $data['results'] = $this->TaskModel->typeDetails();
            $data['result'] = $this->TaskModel->updateTask($id);
            $data['resultLoc'] = $this->TaskModel->updateTaskLocation($id);
            $data['entityFeilds'] = $this->TaskModel->entityFeilds();
            $this->session->set_flashdata('note_msg', 'Successfully Reassigned tasks');
            $data['menu'] = '';
            $data['title'] = 'Task';
            $data['page'] = 'TaskEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('cancel')) {
            $id = $this->input->post('edit_id');
            $data = array('status_id' => 6);
            $aa = $this->TaskModel->cancelTask($id, $data);
            $sql = $this->db->last_query();
            $this->session->set_flashdata('note_msg', 'Successfully Canceled task');
            redirect('task');
        }
    }

    /* This controller is using for check task name already exists or not */

    public function checkTaskName($task_name) {
        $count = $this->TaskModel->checkTaskName($task_name);
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkTaskName", 'This task name already exists...');
            return FALSE;
        }
    }

    /* This controller is using for display task type */

    public function taskType() {
        $data['result'] = $this->TaskModel->taskType();
        $data['menu'] = '';
        $data['title'] = 'Task Type';
        $data['page'] = 'TaskTypeView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add task type */

    public function taskType_add() {
        if ($this->input->post('submit')) {
            $task_type = $this->input->post("task_type");
            $task_type_description = $this->input->post("task_type_description");
            $this->form_validation->set_rules('task_type', 'Task Type', 'trim|required|callback_checkTaskType');
            $this->form_validation->set_rules('task_type_description', 'Task Type Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->TaskModel->taskType_add($this->input->post());
                $this->session->set_flashdata('success_msg', 'Successfully created task type');
                redirect('taskType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Task Type';
        $data['page'] = 'TaskTypeAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete task type details */

    public function taskType_update() {
        $id = $this->input->post('edit_id');
        if ($this->input->post('submit')) {
            $task_type = $this->input->post("task_type");
            $task_type_description = $this->input->post("task_type_description");
            $this->form_validation->set_rules('task_type', 'Task Type', 'required');
            $this->form_validation->set_rules('task_type_description', 'Task Type Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                $datas = $this->TaskModel->taskType_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated task type');
                redirect('taskType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        if ($this->input->post('edit')) {
            $data['result'] = $this->TaskModel->taskType_update($id);
            $data['menu'] = '';
            $data['title'] = 'Task Type';
            $data['page'] = 'TaskTypeEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('task_type_status' => 0);
            $assetDelete = $this->TaskModel->taskType_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Successfully deleted task type');
            redirect('taskType');
        }
    }

    /* This controller is using for check task type already exists or not  */

    public function checkTaskType($task_type) {
        $count = $this->TaskModel->checkTaskType($task_type);
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkTaskType", 'This task type already exists...');
            return FALSE;
        }
    }

    public function problemOne() {
        $productline = $this->input->post('productline');
        $data = $this->TaskModel->problemOneModel($productline);
//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        echo '<option value="">Select</option>';
        foreach ($data as $value) {
            echo '<option value="' . $value['value'] . '">' . $value['value'] . '</option>';
        }
    }

    public function actionCode() {
        $productline = $this->input->post('productline');
        $data = $this->TaskModel->actionCodeModel($productline);
//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        echo '<option value="">Select</option>';
        foreach ($data as $value) {
            echo '<option value="' . $value['value'] . '">' . $value['value'] . '</option>';
        }
    }

    public function sectionCode() {
        $productline = $this->input->post('productline');
        $data = $this->TaskModel->sectionCodeModel($productline);
//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        echo '<option value="">Select</option>';
        foreach ($data as $value) {
            echo '<option value="' . $value['value'] . '">' . $value['value'] . '</option>';
        }
    }

    public function problemTwo() {
        $productline = $this->input->post('sn_problem1');
        $data = $this->TaskModel->problemTwoModel($productline);
//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        echo '<option value="">Select</option>';
        foreach ($data as $value) {
            echo '<option value="' . $value['value'] . '">' . $value['value'] . '</option>';
        }
    }

    public function snLocation() {
        $productline = $this->input->post('sn_problem2');
        $data = $this->TaskModel->snLocationModel($productline);
        echo '<option value="">Select</option>';
        foreach ($data as $value) {
            echo '<option value="' . $value['value'] . '">' . $value['value'] . '</option>';
        }
    }

    public function locationCode() {
        $productline = $this->input->post('section_code');
        $data = $this->TaskModel->locationCodeModel($productline);
        echo '<option value="">Select</option>';
        foreach ($data as $value) {
            echo '<option value="' . $value['value'] . '">' . $value['value'] . '</option>';
        }
    }

    public function form_test() {

        $data['results'] = $this->TaskModel->updateTaskScreen(124);

        echo "<pre>";

        print_r($data);

        $data['menu'] = '';
        $data['title'] = 'Task';
        $data['page'] = 'form';
        //$this->load->view("common/CommonView", $data);
        // $this->load->view("form");
    }
    
    
    public function maptest()
    {
       //$this->TaskModel->get_tasklocation();   
        $data['divid']= $this->input->post('id');
        $data['title'] = 'Task Type';
        $data['page'] = 'googlemaptest';
        $this->load->view("googlemaptest", $data);
    }
    public function loadmap()
    { 
        $taskid=$this->input->post('taskid');
        $data['showmap'] =$this->TaskModel->get_tasklocation();
        $data['title'] = 'Task Type';
        $data['page'] = 'googlemaptest';
        $data['divID']=$this->input->post('id');
        $this->load->view("googlemaptest",$data);
        
    }
    
    public function  taskdetail()
    {   
            if($this->input->post('id')){
                 $id= $this->input->post('id');
            }  else {
                 $id= $this->input->get('id');
            }
            if($this->input->post('tasktypeid')){
                 $tasktypeid= $this->input->post('tasktypeid');
            }  else {
                 $tasktypeid= $this->input->get('tasktypeid');
            }
            
            
             $data['document'] = $this->TaskModel->getDocuments($id); // ok 
            $data['category'] = $this->TaskModel->getCategories($tasktypeid);
            $data['assets'] = $this->TaskModel->getAssets($tasktypeid);
            $data['complete'] = $this->TaskModel->getComplete($id);
            $data['tasklocation'] = $this->TaskModel->gettasklocation($id);
           // print_r($data['tasklocation']); exit();
            $d['result'][]=$data;
            $this->load->view("taskdetailpanel",$d);
            
    }
}
