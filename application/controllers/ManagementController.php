<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ManagementController extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("ManagementModel");
    }

    public function index() {
        
    }

    /* This controller is using for display entity details */

    public function company() {
        // if (($this->session->userdata('session_data')->is_admin != 1) && ($this->session->userdata('session_data')->entity_admin != $this->session->userdata('session_data')->user_id)) {redirect('dashboard','refresh');}
        // $this->userPermissionCheck(2, 1);
        $data['result'] = $this->ManagementModel->company();
        $data['menu'] = '';
        $data['title'] = 'Company';
        $data['page'] = 'CompanyView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add entity details */

    public function company_add() {
        if ($this->session->userdata('session_data')->is_admin != 1) {
            redirect('dashboard', 'refresh');
        }
        // $this->userPermissionCheck(2, 2);
        $data['Admin_check'] = $this->PermissionCheck(25, 1);
        $data['SuperAdmin_check'] = $this->PermissionCheck(25, 2);
        //var_dump($data);

        $data['ent_type'] = $this->ManagementModel->getuserType();
        if ($this->input->post('submit')) {
            $task_field = json_encode($this->input->post('task_field'));
            $task_complete_fields = json_encode($this->input->post('task_complete_fields'));
            $file = $this->input->post("file");
            $ent_name = $this->input->post("ent_name");
            $ent_address = $this->input->post("ent_address");
            $ent_year = $this->input->post("ent_year");
            $this->form_validation->set_rules('ent_name', 'Entity Name', 'required');
            $this->form_validation->set_rules('ent_address', 'Entity Address', 'required');
            $this->form_validation->set_rules('ent_year', 'Entity Year', 'required');
            if ($this->form_validation->run() == TRUE) {
                $entity_logo = "";
                $insert_data = $this->input->post();
                $name = $_FILES['file']['name'];
                $size = $_FILES['file']['size'];
                $type = $_FILES['file']['type'];
                $tmp_name = $_FILES['file']['tmp_name'];
                if (isset($name)) {
                    if (!empty($name)) {
                        $target_path = DOCUMENT_STORE_PATH . basename($_FILES['file']['name']);
                        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {

                            $im = file_get_contents($target_path);
                            $entity_logo = base64_encode($im);
                            unlink($target_path);
                        }
                    }
                }
                if ($entity_logo == "") {
                    $entity_logo = "/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxMQEQ8OEQ4QEQ0QEA8PDg8PDxAODw8QFRIYFhURExUYKCggGBolGxUWITEhJSkrLi4uFx8zODMsNygtLisBCgoKBQUFDgUFDisZExkrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrK//AABEIAOEA4QMBIgACEQEDEQH/xAAbAAEBAQEBAQEBAAAAAAAAAAAABQQCAwEGB//EADcQAAIBAQQFCwQBBAMAAAAAAAABAhEDBAUxIVFxgbESEzIzQUJSYXKSspGhwdEiFSNi4RSCov/EABQBAQAAAAAAAAAAAAAAAAAAAAD/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwD+yAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD4fQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAPO1tox6UkuJitsUXdjvl+gKBntr7CPbV6o6Sd/dtdbXtiabHDPFLdH9geVriMpaIqn/AKZ5N2kGpvlLzdabyvZWMY9GKXH6nco1VGqrUwM10vqnoeiWrsew1Eu94fT+UNvJ7VsF1xCn8Z5ZcrtW0CoD4nXStK1n0AAAAAAAAAAAAAAAAAAAAAAAHwDLb3+MW1plJZ00L6mKd9tJ6I6PKK0/U5UFK2aeTm6liEEtCSS8lQCXZYdJ6ZOmvtZtsblCPZV65aTQfQAOLS1jHpSS2syWuJxXRTl9kBtFSNa3+cu3kr/H9nlZqema5WjNp1YF8y3u5KelaJ69e08LtiNdE9D8Sy36ignXT2ARrO1nYujWjtTyfmipd7xGaqnp7V2o6trJTVJKq4bCPeLJ2U1SXmmtD2MC4DmDqk/JHQAAAAAAAAAAAAAAAAAAAAczmoptuiWbMNriaXRTfm9CA4srvLnXLkvkqTdXoN9paxjnJIkWt+nLtotUdBmYFW1xOK6MW/N6EY7W/Tl20WqOj7mYJAfW6nw0WdynLu0Wt6Berq7OlWnWuWsDOU8HyntX5JhTwjKe1cAPW83CMtK/jL7MwxnOxdHlqemL2Fo5nBSVGqrUwPC7XyM9GUvC/wAazHiyfKi+ylK7z7ecOa0w0+TzWxnFjfmv4Wi5UcnVaV+wKtnkti4HR52NopJOLqj0AAAAAAAAAAAAAAAAAAADNiPVz3fJEQt4j1c93yREA+xi26JVbyRrs8Nm86R26WcYf1kd/AtgYrPDYrNuX2RqhZRjlFLYhO0Uc5JbWZrTEYLKr2L9gbCdjGUNr4HnaYm+7FLbpMltbyn0nWmXZQDzKeEZT2rgTCnhGU9q4AUQAAPC8XWM81p7Gs/9nuAI1pYTsnyk3TxLLejfcb1zidVRrOmTPW89CfpfAw4P39wFMAAAAAAAAAAAAAAAAAAZsR6ue75IiFvEernu+SIgHUJuLTTo12ns7e0n2yflHRwPlxinOKaqtT2FxKn+gI0LhN9lPUzRDC/FP6IpHwDPZ3GC7tfU6mXFrNJQaSWa0KhvnbRWcora0TcSvEZ8lRdaVbfYBhKeEZT2omFPCMp7V+QKIAAAADyvPQn6XwMOD9/cbrz0J+l8DDg/f3AUwAAAAAAAAAAAAAAAAABmxHq57vkiIW8R6ue75IiAel2teRJSpWnYb54pqg97/Rhu1ly5KNaJlWGHwXY3tYGC0xGbyaWxfs8+VaT8b+tCzCxisopbEegEWNwm+7Ta6HF5urs6Vada5F0nYxlDa+AEwp4RlPbH8kwp4PlPavyBRAAAAAeV56E/S+Bhwfv7jdeehP0vgYcH7+4CmAAAAAAAAAAAAAAAAAAM2I9XPd8kRC3iPVz3fJEQD2uc1GcW9C1laV9s1309lWRbODk1FZs2xwuXbKK2VYGiWJQWSk91DyliuqH1kfY4Wu2b3Kh6xw6C1vfTgBkliU3kordUzW1vKdOU60y1LcWI3OzXcW+r4mTFbJJRailpa0aAJxTwfKe2P5JhTwfKe1fkCiAAAAA8rz0J+l8DDg/f3G68dCfpfAw4P39wFMAAAAAAAAAAAAAAAAAAZsR6ue75IiFvEernu+SIgGjD+sjtfAuH5yPln2bT15No+y0e6TAuuS1r6nDtorvR+qI3/FtH3Jb9B0rhaeH7oCo73Bd9cTBiV5jPkqLrSrehpfc5jhs/8fqeV5usrOlaadQHgU8HyntX5JhTwfKe2IFEAAAAB5XjoT9L4GHB+/uN146E/S+Bhwfv7gKYAAAAAAAAAAAAAAAAAAzYj1c93yRELeI9XPd8kRANGHr+5HfwLh+esrRxaks0anic9UfowK4I/wDUp/4/Q+f1GetfQCyTsYyhtfAzf1C08S+iPG2t5TpynWmQHmU8Hyntj+SYU8Hyntj+QKIAAAADyvPQn6XwMOD9/cbrx0J+l8DDg/f3AUwAAAAAAAAAAAAAAAAD4wM+I9XL/r8kRD65N9p8AAAAAAAAAFPCMp7V+SYEwP0dRU/O8rz+45Xn9wP0VRU/O8rz+45Xn9wL14f8J+l8DDg/f3E/leZ8TA/SAy4c62cd6NQAAAAAAAAAAAAAAAAHHNR8MfahzUfDH2o7AHHNR8MfahzUfDH2o7AHHNR8MfahzUfDH2o7AHHNR8MfahzUfDH2o7AHHNR8MfahzUfDH2o7AHHNR8MfahzUfDH2o7AHHNR8MfahzUfDH2o7AHHNR8MfahzUfDH2o7AHyMUtCSS8lQ+gAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAf/Z";
                }
                $insert_data['entity_logo'] = $entity_logo;
                unset($insert_data['task_field']);
                unset($insert_data['task_complete_fields']);
                $insert_data['task_field'] = $task_field;
                $insert_data['task_complete_fields'] = $task_complete_fields;
                $id = $this->ManagementModel->company_add($insert_data);
                $this->session->set_flashdata('success_msg', 'Successfully added an Entity');
//                redirect('entity');
                $this->session->set_userdata("last_inserted_entity", $id);
                redirect('updateEntity');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Company';
        $data['page'] = 'CompanyAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete entity details */

    public function company_update() {
        $data['Admin_check'] = $this->PermissionCheck(25, 1);
        $data['SuperAdmin_check'] = $this->PermissionCheck(25, 2);
        //if (($this->session->userdata('session_data')->is_admin == 1) || ($this->session->userdata('session_data')->entity_admin == $this->session->userdata('session_data')->user_id)) {redirect('dashboard','refresh');}
        $id = $this->input->post('edit_id');
        if (empty($id)) {
            $id = $this->session->userdata("last_inserted_entity");
        }
        $data['fsetypes'] = $this->ManagementModel->getFSETypes();      
      
       
        if ($this->input->post('submit')) {          
            $this->form_validation->set_rules('ent_name', 'Entity Name', 'required');
            $this->form_validation->set_rules('ent_address', 'Entity Address', 'required');
            $this->form_validation->set_rules('ent_year', 'Entity Year', 'required');
            if ($this->form_validation->run() == TRUE) {
                $entity_logo = "";
                // $data = $this->input->post();
                $insert_data = $this->input->post();
               
                if(isset($insert_data['isadv_mapfunctionality']))
                        $insert_data['isadv_mapfunctionality'] = 1;
                else
                     $insert_data['isadv_mapfunctionality'] = 0;
                if(isset($insert_data['isscheduling']))
                        $insert_data['isscheduling'] = 1;
                else
                     $insert_data['isscheduling'] = 0;
                if(isset($insert_data['isadv_reporting']))
                        $insert_data['isadv_reporting'] = 1;
                else
                     $insert_data['isadv_reporting'] = 0;
                
                $task_field = json_encode($this->input->post('task_field'));
                $task_complete_fields = json_encode($this->input->post('task_complete_fields'));
                $name = $_FILES['file']['name'];
                $size = $_FILES['file']['size'];
                $type = $_FILES['file']['type'];
                $tmp_name = $_FILES['file']['tmp_name'];
                if (isset($name)) {
                    if (!empty($name)) {
                        $target_path = DOCUMENT_STORE_PATH . basename($_FILES['file']['name']);
                        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {

                            $im = file_get_contents($target_path);
                            $entity_logo = base64_encode($im);
                            unlink($target_path);
                        }
                    }
                }
                if ($entity_logo != "") {
                    $insert_data['entity_logo'] = $entity_logo;
                }
                unset($insert_data['task_field']);
                unset($insert_data['task_complete_fields']);
                $insert_data['task_field'] = $task_field;
                $insert_data['task_complete_fields'] = $task_complete_fields;
                $datas = $this->ManagementModel->company_edit($this->input->post('ent_id'), $insert_data);
                $this->session->set_flashdata('success_msg', 'Sucessfully updated an entity');
                $this->session->unset_userdata('last_inserted_entity');
                redirect('entity');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('delete')) {
            $this->userPermissionCheck(2, 4);
            $id = $this->input->post('edit_id');
            $data = array('status' => 0);
            $this->ManagementModel->company_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Sucessfully deleted an entity');
            redirect('entity');
        }
        if ($this->input->post('edit') || $id) {
            $this->userPermissionCheck(2, 3);
            $data['result'] = $this->ManagementModel->company_update($id);
            $data['ent_id'] = $id;
            $data['menu'] = '';
            $data['title'] = 'Company';
            $data['page'] = 'CompanyEditView';
            $this->load->view("common/CommonView", $data);
        }
    }

    public function apiSetting() {

        if ($this->session->userdata('session_data')->is_admin != 1) {
            redirect('dashboard');
        }

        $data['result'] = $this->ManagementModel->apiSetting();
        $data['menu'] = '';
        $data['title'] = 'Api Setting';
        $data['page'] = 'ApiSettingView';
        $this->load->view("common/CommonView", $data);
    }

    public function apiSetting_add() {

        if ($this->session->userdata('session_data')->is_admin != 1) {
            redirect('dashboard');
        }
        $data['ent_type'] = $this->ManagementModel->getEntityType();
        if ($this->input->post('submit')) {


            $this->form_validation->set_rules('ent_id', 'ent_id', 'required|is_unique[qm_api_setting.ent_id]');
            if ($this->form_validation->run() == TRUE) {
                $this->ManagementModel->apiSetting_add($this->input->post());
                $this->session->set_flashdata('success_msg', 'Sucessfully added a branch');
                redirect('apiSetting');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Api Setting';
        $data['page'] = 'ApiSettingAddView';
        $this->load->view("common/CommonView", $data);
    }

    public function apiSetting_update() {

        if ($this->session->userdata('session_data')->is_admin != 1) {
            redirect('dashboard');
        }
        $id = $this->input->post('edit_id');
        $data['ent_id'] = $this->ManagementModel->getEntityType();
        if ($this->input->post('submit')) {
            $ent_id = $this->input->post("ent_id");
            $this->form_validation->set_rules('ent_id', 'ent_id', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                $datas = $this->ManagementModel->apiSetting_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Sucessfully updated a API');
                redirect('apiSetting');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $data['result'] = $this->ManagementModel->apiSetting_update($id);
            $data['menu'] = '';
            $data['title'] = 'Api Setting';
            $data['page'] = 'ApiSettingEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = QM_ENTITY_SETTING;
            $aa = $this->ManagementModel->DeleteData($id, $data);
            $this->session->set_flashdata('note_msg', 'Sucessfully deleted a API');
            redirect('apiSetting');
        }
    }

    /* This controller is using for display branch details */

    public function branch() {

        $this->userPermissionCheck(3, 1);
        $data['result'] = $this->ManagementModel->branch();
        $data['menu'] = '';
        $data['title'] = 'Branch';
        $data['page'] = 'BranchView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add branch details */

    public function branch_add() {

        $this->userPermissionCheck(3, 2);
        $data['ent_type'] = $this->ManagementModel->getEntityType();
        if ($this->input->post('submit')) {

            $branch_name = $this->input->post("branch_name");
            $branch_location = $this->input->post("branch_location");
            $ent_id = $this->input->post("ent_id");
            $this->form_validation->set_rules('branch_name', 'branch_name', 'required');
            $this->form_validation->set_rules('branch_location', 'branch_location', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->ManagementModel->branch_add($this->input->post());
                $this->session->set_flashdata('success_msg', 'Sucessfully added a branch');
                redirect('branch');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Branch';
        $data['page'] = 'BranchAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete branch details */

    public function branch_update() {

        $id = $this->input->post('edit_id');
        $data['ent_id'] = $this->ManagementModel->getEntityType();
        if ($this->input->post('submit')) {
            $branch_name = $this->input->post("branch_name");
            $branch_location = $this->input->post("branch_location");
            $ent_id = $this->input->post("ent_id");
            $this->form_validation->set_rules('branch_name', 'branch_name', 'required');
            $this->form_validation->set_rules('branch_location', 'branch_location', 'required');
            $this->form_validation->set_rules('ent_id', 'ent_id', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                $datas = $this->ManagementModel->branch_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Sucessfully updated a branch');
                redirect('branch');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $this->userPermissionCheck(3, 3);
            $data['result'] = $this->ManagementModel->branch_update($id);
            $data['menu'] = '';
            $data['title'] = 'Branch';
            $data['page'] = 'BranchEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $this->userPermissionCheck(3, 4);
            $id = $this->input->post('edit_id');
            $data = array('branch_status' => 0);
            $aa = $this->ManagementModel->branch_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Sucessfully deleted a branch');
            redirect('branch');
        }
    }

    /* This controller is using for display FSE details */

    public function serviceEngineer() {

        $this->userPermissionCheck(6, 1);
        $data['result'] = $this->ManagementModel->serviceEngineer();
        //var_dump($data['result']);die;
        $data['menu'] = '';
        $data['title'] = 'Service Engineer';
        $data['page'] = 'ServiceEngineerView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add FSE details */

    public function get_fse_type() {
        // $searchTerm = $_GET['term']; 
        //$data['fse_type'] = $this->ManagementModel->getFSETypeBySearchTerm($searchTerm);
        $data['fse_type'] = $this->ManagementModel->getFseTypeAuto();
    }

    function string_sanitize($s) {
        $result = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($s, ENT_QUOTES));
        return $result;
    }

    public function fse_add() {
        $this->userPermissionCheck(6, 2);
        $data['fse_type'] = $this->ManagementModel->getFSEType();
        $data['entity_name'] = $this->ManagementModel->getEntityType();
        $data['branch_name'] = $this->ManagementModel->getBranchype();
        if ($this->input->post('submit')) {
            $fse_name = $this->input->post("fse_name");
            $fse_username = $this->input->post("fse_username");
            $fse_password = $this->input->post("fse_password");
            $fse_type_id = $this->input->post("fse_type_id");
            $fse_email = $this->input->post("fse_email");
            $fse_mobile = $this->input->post("fse_mobile");
            $fse_address = $this->input->post("fse_address");
            $ent_id = $this->input->post('ent_id');
            $branch_id = $this->input->post('branch_id');
            $this->form_validation->set_rules('fse_name', 'FSE Name', 'required|callback_checkFSEName');
            $this->form_validation->set_rules('fse_username', 'FSE UserName', 'required|callback_checkFSEusername');
            $this->form_validation->set_rules('fse_password', 'FSE Password', 'required');
            //$this->form_validation->set_rules('fse_type_id', 'FSE Type', 'required');
            $this->form_validation->set_rules('fse_email', 'FSE Email', 'trim|required|valid_email|callback_checkFSEemail');
            $this->form_validation->set_rules('fse_mobile', 'FSE Mobile', 'required');
            $this->form_validation->set_rules('fse_address', 'FSE Address', 'required');
            if ($this->form_validation->run() == TRUE) {

                $this->ManagementModel->fse_add($this->input->post());
                $fse_details_id = $this->db->insert_id();
                $fse_type_input = $this->input->post("fse_type_id");

                $fse_type_input_arr = explode(',', $fse_type_input);

                $k = count($fse_type_input_arr);
                for ($i = 0; $i < $k; $i++) {
                    $arr[$i] = $this->string_sanitize($fse_type_input_arr[$i]);
                }
                $limit = count($arr);
                for ($i = 0; $i < $limit; $i++) {
                    $fse_inser_array[$i]['fse_details_id'] = $fse_details_id;
                    $fse_inser_array[$i]['fse_type_id'] = $arr[$i];
                }
                foreach ($fse_inser_array as $data) {
                    $this->ManagementModel->fseEngineers_add($data);
                }


                $this->session->set_flashdata('success_msg', 'Successfully added Service Engineer');
                redirect('serviceEngineer');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Service Enginner';
        $data['page'] = 'ServiceAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete FSE details */

    public function fse_update() {
        $id = $this->input->post('edit_id');
        //  $data['fse_type_id'] = $this->ManagementModel->getFSEType();
        $data['entity_name'] = $this->ManagementModel->getEntityType();
        $data['branch_name'] = $this->ManagementModel->getBranchype();
        if ($this->input->post('submit')) {
            $fse_detail_id = $this->input->post('id');
            $fse_name = $this->input->post("fse_name");
            $fse_username = $this->input->post("fse_username");
            $fse_email = $this->input->post("fse_email");
            $fse_mobile = $this->input->post("fse_mobile");
            $fse_address = $this->input->post("fse_address");
            if ($this->input->post('ent_id') != 0) {
                $ent_id = $this->input->post('ent_id');
            }
            if ($this->input->post('branch_id') != 0) {
                $branch_id = $this->input->post('branch_id');
            }
            $this->form_validation->set_rules('fse_name', 'FSE Name', 'required');
            $this->form_validation->set_rules('fse_username', 'FSE UserName', 'required');
            $this->form_validation->set_rules('fse_email', 'FSE Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('fse_mobile', 'FSE Mobile', 'required');
            $this->form_validation->set_rules('fse_address', 'FSE Address', 'required');
            if ($this->form_validation->run() == TRUE) {

                $data = $this->input->post();
                if ($data['optradio'] == 'companyDiv') {
                    $data['branch_id'] = 0;
                } else {
                    $data['ent_id'] = 0;
                }
                $datas = $this->ManagementModel->fse_edit($this->input->post('id'), $data);

                $this->ManagementModel->fseEngineers_delete($fse_detail_id);
                $fse_type_input = $this->input->post("fse_type_id");
                if ($fse_type_input) {

                    $fse_type_input_arr = explode(',', $fse_type_input);

                    $k = count($fse_type_input_arr);
                    for ($i = 0; $i < $k; $i++) {
                        $arr[$i] = $this->string_sanitize($fse_type_input_arr[$i]);
                    }
                    $limit = count($arr);
                    for ($i = 0; $i < $limit; $i++) {
                        $fse_inser_array[$i]['fse_details_id'] = $fse_detail_id;
                        $fse_inser_array[$i]['fse_type_id'] = $arr[$i];
                    }

                    foreach ($fse_inser_array as $data) {
                        $this->ManagementModel->fseEngineers_add($data);
                    }
                }
                $this->session->set_flashdata('success_msg', 'Succesfully updated a service engineer');
                redirect('serviceEngineer');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $this->userPermissionCheck(6, 3);
            $data['result'] = $this->ManagementModel->fse_update($id);
            $data['menu'] = '';
            $data['title'] = 'Service Enginner';
            $data['page'] = 'ServiceEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $this->userPermissionCheck(6, 4);
            $id = $this->input->post('edit_id');
            $data = array('fse_status' => 0);
            $fseDelete = $this->ManagementModel->fse_delete($id);
            $this->session->set_flashdata('note_msg', 'Successfully deleted a service engineer ');
            redirect('serviceEngineer');
        }
        if ($this->input->post('unblock')) {
            $this->userPermissionCheck(6, 3);
            $id = $this->input->post('edit_id');
            $data = array('fse_status' => 1);
            $fseUnblock = $this->ManagementModel->fse_unblock($id, $data);
            $this->session->set_flashdata('note_msg', 'Successfully unblocked a service engineer');
            redirect('serviceEngineer');
        }
        if ($this->input->post('block')) {
            $this->userPermissionCheck(6, 3);
            $id = $this->input->post('edit_id');
            $data = array('fse_status' => 0);
            $fseblock = $this->ManagementModel->fse_block($id, $data);
            $this->session->set_flashdata('note_msg', 'Successfully blocked a service engineer');
            redirect('serviceEngineer');
        }
        if ($this->input->post('resetpassword')) {
            $this->userPermissionCheck(6, 3);
            $data['post_data'] = $this->input->post();
            $data['result'] = $this->ManagementModel->fse_resetpassword($this->input->post('edit_id'));
            $data['menu'] = '';
            $data['title'] = 'FSE Reset Password';
            $data['page'] = 'ResetServicePassword';
            $this->load->view("common/CommonView", $data);
        }
    }

    /* This controller is using for reset FSE password */

    public function resetpassword() {

        if ($this->input->post('Btnsubmit')) {
            $fse_password = $this->input->post("fse_password");
            $this->form_validation->set_rules('fse_password', 'Password', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                $datas = $this->ManagementModel->fsePassword_reset($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Sucessfully reseted the password');
                redirect('serviceEngineer');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $data['result'] = $this->ManagementModel->fseType_update($id);
            $data['menu'] = '';
            $data['title'] = 'FSE Type';
            $data['page'] = 'FSETypeEditView';
            $this->load->view("common/CommonView", $data);
        }
    }

    /* This controller is using for check FSE Email already exists */

    public function checkFSEemail($email) {
        $count = $this->ManagementModel->checkFSEemail($email);
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkFSEemail", 'This email address already exists...');
            return FALSE;
        }
    }

    /* This controller is using for check FSE Username already exists */

    public function checkFSEusername($username) {
        $count = $this->ManagementModel->checkFSEuser($username);
        if ($count == 0) {
            return true;
        } else {
            $this->form_validation->set_message('checkFSEusername', 'This username already exists...');
            return false;
        }
    }

    /* This controller is using for check FSE Name already exists */

    public function checkFSEName($fsename) {
        $count = $this->ManagementModel->checkFSEName($fsename);
        if ($count == 0) {
            return true;
        } else {
            $this->form_validation->set_message('checkFSEName', 'This fse name already exists...');
            return false;
        }
    }

    /* This controller is using for display FSE Type */

    public function fseType() {
        $data['result'] = $this->ManagementModel->fseType();
        $data['menu'] = '';
        $data['title'] = 'FSE Type';
        $data['page'] = 'FSETypeView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add FSE Type */

    public function fseType_add() {
        
        if ($this->input->post('submit')) {
            $fse_type = $this->input->post("fse_type");
            $fse_description = $this->input->post("fse_description");
            // $this->form_validation->set_rules('fse_type', 'FSE Type', 'trim|required|callback_checkFSEType');
            $this->form_validation->set_rules('fse_type_id', 'FSE Type', 'required');
            $this->form_validation->set_rules('fse_description', 'FSE Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->ManagementModel->fseType_add($this->input->post());
                $this->session->set_flashdata('success_msg', 'Successfully created service engineer type');
                redirect('fseType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'FSE Type';
        $data['page'] = 'FSETypeAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete FSE Type */

    public function fseType_update() {
        $id = $this->input->post('edit_id');
        if ($this->input->post('submit')) {
            $fse_type = $this->input->post("fse_type");
            $fse_description = $this->input->post("fse_description");
            $this->form_validation->set_rules('fse_type_id', 'FSE Type', 'required');
            $this->form_validation->set_rules('fse_description', 'FSE Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                $datas = $this->ManagementModel->fseType_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated service engineer type');
                redirect('fseType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $data['result'] = $this->ManagementModel->fseType_update($id);
            $data['menu'] = '';
            $data['title'] = 'FSE Type';
            $data['page'] = 'FSETypeEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('fse_type_status' => 0);
            $assetDelete = $this->ManagementModel->fseType_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Successfully deleted service engineer type');
            redirect('fseType');
        }
    }

    /* This controller is using for check FSE type already exists or not */

    public function checkFSEType($fseType) {
        $count = $this->ManagementModel->checkFSEType($fseType);
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkFSEType", 'This FSE Type already exists...');
            return FALSE;
        }
    }

    /* This controller is using for display customer details */

    public function customer() {
        $data['result'] = $this->ManagementModel->customer();
        $data['menu'] = '';
        $data['title'] = 'Customer';
        $data['page'] = 'CustomerView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add customer details */

    public function customer_add() {
        $data['entity_name'] = $this->ManagementModel->getEntityType();
        $data['branch_name'] = $this->ManagementModel->getBranchype();
        $data['sla_name'] = $this->ManagementModel->getSLAName();
        if ($this->input->post('submit')) {
            $cus_name = $this->input->post("cus_name");
            $cus_username = $this->input->post("cus_username");
            $cus_pass = $this->input->post("cus_pass");
            $cus_cpass = $this->input->post("cus_cpass");
            $cus_email = $this->input->post("cus_email");
            $cus_phone = $this->input->post("cus_phone");
            $cus_address = $this->input->post("cus_address");
            $branch_id = $this->input->post("branch_id");
            $this->form_validation->set_rules('cus_name', 'Customer Name', 'required');
            $this->form_validation->set_rules('cus_username', 'Customer UserName', 'required|callback_checkCustomerUser');
            $this->form_validation->set_rules('cus_pass', 'Customer Password', 'required|min_length[4]|max_length[10]');
            $this->form_validation->set_rules('cus_cpass', 'Customer Confirm Password', 'required|min_length[4]|max_length[10]');
            $this->form_validation->set_rules('cus_email', 'Customer Email', 'trim|required|valid_email|callback_checkCustomeremail');
            $this->form_validation->set_rules('cus_phone', 'Customer Phone', 'required|min_length[9]|max_length[10]');
            $this->form_validation->set_rules('cus_address', 'Customer Address', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->ManagementModel->customer_add($this->input->post());
                $this->session->set_flashdata('success_msg', 'Succesfully created a customer');
                redirect('customer');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Customer';
        $data['page'] = 'CustomerAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete customer details */

    public function customer_update() {
        $id = $this->input->post('edit_id');
        $data['sla_name'] = $this->ManagementModel->getSLAName();
        $data['entity_name'] = $this->ManagementModel->getEntityType();
        $data['branch_name'] = $this->ManagementModel->getBranchype();
        if ($this->input->post('submit')) {
            $cus_name = $this->input->post("cus_name");
            $cus_username = $this->input->post("cus_username");
            $cus_pass = $this->input->post("cus_pass");
            $cus_cpass = $this->input->post("cus_cpass");
            $cus_email = $this->input->post("cus_email");
            $cus_phone = $this->input->post("cus_phone");
            $cus_address = $this->input->post("cus_address");
            $branch_id = $this->input->post("branch_id");
            $this->form_validation->set_rules('cus_name', 'Customer Name', 'required');
            $this->form_validation->set_rules('cus_username', 'Customer UserName', 'required');
            $this->form_validation->set_rules('cus_pass', 'Customer Password', 'required|min_length[4]|max_length[10]');
            $this->form_validation->set_rules('cus_cpass', 'Customer Confirm Password', 'required|min_length[4]|max_length[10]');
            $this->form_validation->set_rules('cus_email', 'Customer Email', 'required');
            $this->form_validation->set_rules('cus_phone', 'Customer Phone', 'required|min_length[9]|max_length[10]');
            $this->form_validation->set_rules('cus_address', 'Customer Address', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                if ($data['optradio'] == 'companyDiv') {
                    $data['branch_id'] = 0;
                } else {
                    $data['ent_id'] = 0;
                }
                $datas = $this->ManagementModel->customer_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated a customer');
                redirect('customer');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $data['result'] = $this->ManagementModel->customer_update($id);
            $data['menu'] = '';
            $data['title'] = 'Customer';
            $data['page'] = 'CustomerEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('cus_status' => 0);
            $aa = $this->ManagementModel->customer_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Successfully deleted a customer');
            redirect('customer');
        }
    }

    /* This controller is using for check Customer Email already exists or not */

    public function checkCustomeremail($email) {
        $count = $this->ManagementModel->checkCustomeremail($email);
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkCustomeremail", 'This email address already exists...');
            return FALSE;
        }
    }

    /* This controller is using for check Customer Username already exists or not */

    public function checkCustomerUser($username) {
        $count = $this->ManagementModel->checkCustomerUser($username);
        if ($count == 0) {
            return true;
        } else {
            $this->form_validation->set_message('checkCustomerUser', 'This username already exists...');
            return false;
        }
    }

    /* This controller is using for display asset details */

    public function asset() {
        $this->userPermissionCheck(4, 1);
        $data['result'] = $this->ManagementModel->asset();
        $data['menu'] = '';
        $data['title'] = 'Asset';
        $data['page'] = 'AssetView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add asset details */

    public function asset_add() {
        $this->userPermissionCheck(4, 2);
        $data['category_type'] = $this->ManagementModel->getAssetCategory();
        $data['branch_name'] = $this->ManagementModel->getBranchype();
        $data['entity_name'] = $this->ManagementModel->getEntityType();
        if ($this->input->post('submit')) {
            $equp_category_id = $this->input->post("equp_category_id");
            $branch_id = $this->input->post("branch_id");
            $equp_name = $this->input->post("equp_name");
            $equp_quantity = $this->input->post("equp_quantity");
            $equp_serial_number = $this->input->post("equp_serial_number");
            $equp_description = $this->input->post("equp_description");
            $this->form_validation->set_rules('equp_category_id', 'Category Name', 'required');
            $this->form_validation->set_rules('equp_name', 'Asset Name', 'trim|required|callback_checkAssetName');
            $this->form_validation->set_rules('equp_quantity', 'Asset Quantity', 'required');
            $this->form_validation->set_rules('equp_serial_number', 'Asset Serial Number', 'required');
            $this->form_validation->set_rules('equp_description', 'Asset Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->ManagementModel->asset_add($this->input->post());
                $this->send_android_push($fse_id);
                $this->session->set_flashdata('success_msg', 'Successfully added an asset ');
                redirect('asset');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Asset';
        $data['page'] = 'AssetAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete asset details */

    public function asset_update() {

        $id = $this->input->post('edit_id');
        $data['branch_name'] = $this->ManagementModel->getBranchype();
        $data['category_type'] = $this->ManagementModel->getAssetCategory();
        $data['entity_name'] = $this->ManagementModel->getEntityType();
        if ($this->input->post('submit')) {
            $equp_category_id = $this->input->post("equp_category_id");
            $equp_name = $this->input->post("equp_name");
            $equp_quantity = $this->input->post("equp_quantity");
            $equp_serial_number = $this->input->post("equp_serial_number");
            $equp_description = $this->input->post("equp_description");
            $this->form_validation->set_rules('equp_category_id', 'Category Name', 'required');
            $this->form_validation->set_rules('equp_name', 'Asset Name', 'required');
            $this->form_validation->set_rules('equp_quantity', 'Asset Quantity', 'required');
            $this->form_validation->set_rules('equp_serial_number', 'Asset Serial Number', 'required');
            $this->form_validation->set_rules('equp_description', 'Asset Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                if ($data['optradio'] == 'companyDiv') {
                    $data['branch_id'] = 0;
                } else {
                    $data['ent_id'] = 0;
                }
                $datas = $this->ManagementModel->asset_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Succesfully updated an asset ');
                redirect('asset');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $this->userPermissionCheck(4, 3);
            $data['result'] = $this->ManagementModel->asset_update($id);
            $data['menu'] = '';
            $data['title'] = 'Asset';
            $data['page'] = 'AssetEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $this->userPermissionCheck(4, 4);
            $id = $this->input->post('edit_id');
            $data = array('equp_status' => 0);
            $assetDelete = $this->ManagementModel->asset_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Successfully deleted an asset');
            redirect('asset');
        }
    }

    /* This controller is using for check asset name already exists or not */

    public function checkAssetName($equp_name) {
        $count = $this->ManagementModel->checkAssetName($equp_name);
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkAssetName", 'This asset name already exists...');
            return FALSE;
        }
    }

    /* This controller is using for display asset Category */

    public function assetcategory() {
        $data['result'] = $this->ManagementModel->assetcategory();
        $data['menu'] = '';
        $data['title'] = 'Asset Category';
        $data['page'] = 'AssetCategoryView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add asset category details */

    public function assetcategory_add() {
        if ($this->input->post('submit')) {
            $equp_category = $this->input->post("equp_category");
            $equp_category_description = $this->input->post("equp_category_description");
            $this->form_validation->set_rules('equp_category', 'Category Name', 'trim|required|callback_checkAssetCategory');
            $this->form_validation->set_rules('equp_category_description', 'Category Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->ManagementModel->assetcategory_add($this->input->post());
                $this->session->set_flashdata('success_msg', 'Successfully created asset category');
                redirect('assetcategory');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Asset Category';
        $data['page'] = 'AssetCategoryAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete asset category details */

    public function assetcategory_update() {
        $id = $this->input->post('edit_id');
        if ($this->input->post('submit')) {
            $equp_category = $this->input->post("equp_category");
            $equp_category_description = $this->input->post("equp_category_description");
            $this->form_validation->set_rules('equp_category', 'Category Name', 'required');
            $this->form_validation->set_rules('equp_category_description', 'Category Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                $datas = $this->ManagementModel->assetcategory_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated category');
                redirect('assetcategory');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $data['result'] = $this->ManagementModel->assetcategory_update($id);
            $data['menu'] = '';
            $data['title'] = 'Asset Category';
            $data['page'] = 'AssetCategoryEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('category_status' => 0);
            $assetDelete = $this->ManagementModel->assetcategory_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Successfully deleted category');
            redirect('assetcategory');
        }
    }

    /* This controller is using for check asset category already exists or not */

    public function checkAssetCategory($equpCategory) {
        $count = $this->ManagementModel->checkAssetCategory($equpCategory);
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkAssetCategory", 'This asset category already exists...');
            return FALSE;
        }
    }

    /* This controller is using for display incident details */

    public function incident() {
        $id = $this->input->post('edit_id');
        $data['result'] = $this->ManagementModel->incident();
        $data['resultTask'] = $this->ManagementModel->incidentTask();
        foreach ($data['result'] as $incident) {
            $data['resultTasks'][$incident['id']] = $this->ManagementModel->incidentTask($incident['id']);
        }
        $data['menu'] = '';
        $data['title'] = 'Incident';
        $data['page'] = 'IncidentView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add incident details */

    public function incident_add() {
        $data['customer_name'] = $this->ManagementModel->getCustomerType();
        $data['entity_name'] = $this->ManagementModel->getEntityType();
        $data['branch_name'] = $this->ManagementModel->getBranchype();
        $data['status_type'] = $this->ManagementModel->getStatusType();
        $data['sla_name'] = $this->ManagementModel->getSLAName();
        $data['zone_name'] = $this->ManagementModel->getZoneName();

        if ($this->input->post('submit')) {
            $incident_name = $this->input->post("incident_name");
            $incident_company_address = $this->input->post("incident_company_address");
            $incident_details = $this->input->post("incident_details");
            //$customer_id = $this->input->post("customer_id");
            $incident_created_date = $this->input->post("incident_created_date");
            $status_id = $this->input->post("status_id");
            /* $sla_id = $this->input->post("sla_id"); */
            $this->form_validation->set_rules('incident_name', 'Incident Name', 'trim|required|callback_checkIncidentName');
            $this->form_validation->set_rules('incident_company_address', 'Incident Company Address', 'required');
            $this->form_validation->set_rules('incident_details', 'Incident Details', 'required');
            // $this->form_validation->set_rules('customer_id', 'Customer', 'required');
            $this->form_validation->set_rules('status_id', 'Status', 'required');
            /* $this->form_validation->set_rules('sla_id', 'SLA', 'required'); */
            if ($this->form_validation->run() == TRUE) {
                $this->ManagementModel->incident_add($this->input->post());
                $this->session->set_flashdata('success_msg', 'Successfully created the incidents');
                redirect('incident');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Incident';
        $data['page'] = 'IncidentAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete incident details */

    public function incident_update() {
        $id = $this->input->post('edit_id');
        $data['customer_id'] = $this->ManagementModel->getCustomerType();
        $data['ent_id'] = $this->ManagementModel->getEntityType();
        $data['branch_name'] = $this->ManagementModel->getBranchype();
        $data['status_type'] = $this->ManagementModel->getStatusType();
        $data['sla_name'] = $this->ManagementModel->getSLAName();
        $data['zone_name'] = $this->ManagementModel->getZoneName();
        if ($this->input->post('submit')) {
            $incident_name = $this->input->post("incident_name");
            $incident_company_address = $this->input->post("incident_company_address");
            $incident_details = $this->input->post("incident_details");
            // $customer_id = $this->input->post("customer_id");
            $status_id = $this->input->post("status_id");
            /* $sla_id = $this->input->post("sla_id"); */
            $this->form_validation->set_rules('incident_name', 'Incident Name', 'required');
            $this->form_validation->set_rules('incident_company_address', 'Incident Company Address', 'required');
            $this->form_validation->set_rules('incident_details', 'Incident Details', 'required');
            // $this->form_validation->set_rules('customer_id', 'Customer', 'required');
            $this->form_validation->set_rules('status_id', 'Status', 'required');
            /* $this->form_validation->set_rules('sla_id', 'SLA', 'required'); */
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                if ($data['optradio'] == 'companyDiv') {
                    $data['branch_id'] = 0;
                } else {
                    $data['ent_id'] = 0;
                }
                $datas = $this->ManagementModel->incident_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated the incident');
                redirect('incident');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $id = $this->input->post('edit_id');
            $data['result'] = $this->ManagementModel->incident_update($id);
            $data['menu'] = '';
            $data['title'] = 'Incident';
            $data['page'] = 'IncidentEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('incident_status' => 0);
            $aa = $this->ManagementModel->incident_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Successfully deleted the incident ');
            redirect('incident');
        }
        if ($this->input->post('close')) {
            $id = $this->input->post('edit_id');
            $data = array('status_id' => 4);
            $aa = $this->ManagementModel->complete_incident($id, $data);
            $sql = $this->db->last_query();
            $this->session->set_flashdata('note_msg', 'Closed successfully !');
            redirect('incident');
        }
    }

    /* This controller is using for check incident name already exists or not */

    public function checkIncidentName($incidentName) {
        $count = $this->ManagementModel->checkIncidentName($incidentName);
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkIncidentName", 'This incident already exists...');
            return FALSE;
        }
    }

    /* This controller is using for display project details */

    public function project() {
        $data['result'] = $this->ManagementModel->project();
        $data['resultTask'] = $this->ManagementModel->projectTask();
        foreach ($data['result'] as $project) {
            $data['resultTasks'][$project['id']] = $this->ManagementModel->projectTask($project['id']);
        }
        $sql = $this->db->last_query();
        $data['menu'] = '';
        $data['title'] = 'Project';
        $data['page'] = 'ProjectView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for get all task details */

    public function getTasks() {
        $id = $this->input->post('pid');
        $data['resultTask'] = $this->ManagementModel->projectTask($id);
        $sql = $data['resultTask'];
        echo json_encode($data);
    }

    /* This controller is using for add project details */

    public function project_add() {
        $data['customer_name'] = $this->ManagementModel->getCustomerType();
        $data['entity_name'] = $this->ManagementModel->getEntityType();
        $data['branch_name'] = $this->ManagementModel->getBranchype();
        $data['status_type'] = $this->ManagementModel->getStatusType();
        $data['zone_name'] = $this->ManagementModel->getZoneName();
        if ($this->input->post('submit')) {
            $proj_name = $this->input->post("proj_name");
            $proj_details = $this->input->post("proj_details");
            $proj_company_address = $this->input->post("proj_company_address");
            $customer_id = $this->input->post("customer_id");
            $proj_created_date = $this->input->post("proj_created_date");
            $status_id = $this->input->post("status_id");
            $this->form_validation->set_rules('proj_name', 'Project Name', 'trim|required|callback_checkProjectName');
            $this->form_validation->set_rules('proj_details', 'Project Details', 'required');
            $this->form_validation->set_rules('proj_company_address', 'Project Company Address', 'required');
            //$this->form_validation->set_rules('customer_id', 'Customer', 'required');
            $this->form_validation->set_rules('proj_created_date', 'Project Created Date', 'required');
            $this->form_validation->set_rules('status_id', 'Status', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->ManagementModel->project_add($this->input->post());
                $this->session->set_flashdata('success_msg', 'Successfully addedd project');
                redirect('project');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Project';
        $data['page'] = 'ProjectAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete project details */

    public function project_update() {
        $id = $this->input->post('edit_id');
        $data['customer_id'] = $this->ManagementModel->getCustomerType();
        $data['ent_id'] = $this->ManagementModel->getEntityType();
        $data['branch_name'] = $this->ManagementModel->getBranchype();
        $data['status_type'] = $this->ManagementModel->getStatusType();
        $data['zone_name'] = $this->ManagementModel->getZoneName();
        if ($this->input->post('submit')) {
            $proj_name = $this->input->post("proj_name");
            $proj_details = $this->input->post("proj_details");
            $proj_company_address = $this->input->post("proj_company_address");
            $customer_id = $this->input->post("customer_id");
            $status_id = $this->input->post("status_id");
            $this->form_validation->set_rules('proj_name', 'Project Name', 'required');
            $this->form_validation->set_rules('proj_details', 'Project Details', 'required');
            $this->form_validation->set_rules('proj_company_address', 'Project Company Address', 'required');
            // $this->form_validation->set_rules('customer_id', 'Customer', 'required');
            $this->form_validation->set_rules('status_id', 'Status', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                if ($data['optradio'] == 'companyDiv') {
                    $data['branch_id'] = 0;
                } else {
                    $data['ent_id'] = 0;
                }
                $datas = $this->ManagementModel->project_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated project');
                redirect('project');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $id = $this->input->post('edit_id');
            $data['result'] = $this->ManagementModel->project_update($id);
            $data['menu'] = '';
            $data['title'] = 'Project';
            $data['page'] = 'ProjectEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('proj_status' => 0);
            $aa = $this->ManagementModel->project_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Successfully deleted project');
            redirect('project');
        }
        if ($this->input->post('close')) {
            $id = $this->input->post('edit_id');
            $data = array('status_id' => 4);
            $aa = $this->ManagementModel->complete_project($id, $data);
            $sql = $this->db->last_query();
            $this->session->set_flashdata('note_msg', 'Closed successfully !');
            redirect('project');
        }
    }

    /* This controller is using for check project name already exists or not */

    public function checkProjectName($projectName) {
        $count = $this->ManagementModel->checkProjectName($projectName);
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkProjectName", 'This project already exists...');
            return FALSE;
        }
    }

    /* This controller is using for display webuser details */

    public function webuser() {
        $data['result'] = $this->ManagementModel->webuser();
        $data['menu'] = '';
        $data['title'] = 'WebUser';
        $data['page'] = 'WebUserView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add webuser details */

    public function webuser_add() {
        $data['user_type'] = $this->ManagementModel->getuserType();
        $data['branch_name'] = $this->ManagementModel->getBranchype();
        $data['entity_name'] = $this->ManagementModel->getEntityType();
        if ($this->input->post('submit')) {

            $web_name = $this->input->post("web_name");
            $web_username = $this->input->post("web_username");
            $web_password = $this->input->post("web_password");
            $web_email = $this->input->post("web_email");
            $web_phone = $this->input->post("web_phone");
            $web_address = $this->input->post("web_address");
            $user_type = $this->input->post("user_type");
            $this->form_validation->set_rules('web_name', 'Web Name', 'required');
            $this->form_validation->set_rules('web_username', 'Web User Name', 'required|callback_checkWebUser');
            $this->form_validation->set_rules('web_password', 'Web Password', 'required|min_length[4]|max_length[10]');
            $this->form_validation->set_rules('web_email', 'Web Email', 'trim|required|valid_email|callback_checkWebemail');
            $this->form_validation->set_rules('web_phone', 'Web Phone', 'required|min_length[9]|max_length[10]');
            $this->form_validation->set_rules('web_address', 'Web Address', 'required');
            $this->form_validation->set_rules('user_type', 'User Type', 'required');
            if ($this->form_validation->run() == TRUE) {
                $add_webuser = $this->input->post();
                $add_webuser['ent_id'] = $this->input->post('ent_id');
                //$add_webuser['created_by_id'] = $this->session->userdata('session_data')->user_id;
                if ($this->session->userdata('session_data')->is_admin == 1) {
                    $entityData['entity_id'] = $this->input->post('ent_id');
                    $entityData['user_id'] = $this->ManagementModel->webuser_add($add_webuser);
                    $this->ManagementModel->entityAdmin($entityData);
                } else {
                    $Entity_user_ids = $this->ManagementModel->webuser_add($add_webuser);
                }

                $this->session->set_flashdata('success_msg', 'Successfully created and logged in with a web user');
                redirect('webuser');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Web User';
        $data['page'] = 'WebUserAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete webuser details */

    public function webuser_update() {
        $id = $this->input->post('edit_id');
        $data['user_type'] = $this->ManagementModel->getuserType();
        $data['entity_name'] = $this->ManagementModel->getEntityType();
        $data['branch_name'] = $this->ManagementModel->getBranchype();
        if ($this->input->post('submit')) {
            $data = $this->input->post();


            $web_name = $this->input->post("web_name");
            $web_username = $this->input->post("web_username");
            $web_password = $this->input->post("web_password");
            $web_email = $this->input->post("web_email");
            $web_phone = $this->input->post("web_phone");
            $web_address = $this->input->post("web_address");
            $user_type = $this->input->post("user_type");
            $userid = $this->input->post('id');
            $this->form_validation->set_rules('web_name', 'Web Name', 'required');
            $this->form_validation->set_rules('web_username', 'Web User Name', 'required');
            $this->form_validation->set_rules('web_password', 'Web Password', 'required|min_length[4]|max_length[10]');
            $this->form_validation->set_rules('web_email', 'Web Email', 'trim|required|valid_email|callback_checkWebemail[' . $this->input->post('id') . ']');
            $this->form_validation->set_rules('web_phone', 'Web Phone', 'required|min_length[9]|max_length[10]');
            $this->form_validation->set_rules('web_address', 'Web Address', 'required');
            if ($this->session->userdata('session_data')->user_id != $userid) {
                $this->form_validation->set_rules('user_type', 'User Type', 'required');
            }


            if ($this->form_validation->run() == TRUE) {
                if (isset($data['optradio'])) {
                    if ($data['optradio'] == 'companyDiv') {
                        $data['branch_id'] = 0;
                    } else {
                        $data['ent_id'] = 0;
                    }
                }

                $datas = $this->ManagementModel->webuser_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated a web user');
                redirect('webuser');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
                redirect('webuser');
            }
        }

        if ($this->input->post('edit')) {
            $data['result'] = $this->ManagementModel->webuser_update($id);
            $data['menu'] = '';
            $data['title'] = 'Web User';
            $data['page'] = 'WebUserEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $aa = $this->ManagementModel->webuser_delete($id);
            $sql = $this->db->last_query();
            $this->session->set_flashdata('note_msg', 'Successfully deleted a web user ');
            redirect('webuser');
        }
        if ($this->input->post('block')) {

            $id = $this->input->post('edit_id');
            $data = array('web_status' => 0);
            $aa = $this->ManagementModel->webuser_edit($id, $data);
            $sql = $this->db->last_query();
            $this->session->set_flashdata('note_msg', 'Successfully Block a web user ');
            redirect('webuser');
        }

        if ($this->input->post('unblock')) {

            $id = $this->input->post('edit_id');
            $data = array('web_status' => 1);
            $aa = $this->ManagementModel->webuser_edit($id, $data);
            $sql = $this->db->last_query();
            $this->session->set_flashdata('note_msg', 'Successfully Unblock a web user ');
            redirect('webuser');
        }

        if ($this->input->post('resetpassword')) {

            $id = $this->input->post('edit_id');
            $data = array('web_status' => 1);
            //$aa = $this->ManagementModel->webuser_edit($id, $data);
            //$sql = $this->db->last_query();
            $this->session->set_flashdata('note_msg', 'Successfully reset password a web user ');
            redirect('webuser');
        }
    }

    /* This controller is using for check web user email already exists or not */

    public function checkWebemail($email = NULL, $id = NULL) {
        $count = $this->ManagementModel->checkWebemail($email, $id);
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkWebemail", 'This email address already exists...');
            return FALSE;
        }
    }

    /* This controller is using for check web user name already exists or not */

    public function checkWebUser($username) {
        $count = $this->ManagementModel->checkWebUser($username);
        if ($count == 0) {
            return true;
        } else {
            $this->form_validation->set_message('checkWebUser', 'This username already exists...');
            return false;
        }
    }

    /* This controller is using for display all user type */

    public function userType() {
        $data['result'] = $this->ManagementModel->userType();
        $data['menu'] = '';
        $data['title'] = 'User Type';
        $data['page'] = 'UserTypeView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add user type details */

    public function userType_add() {
        if ($this->input->post('submit')) {
            $datas['web_user_type'] = $this->input->post('web_user_type');
            $datas['web_user_description'] = $this->input->post('web_user_description');
            $datas['permission_code'] = json_encode($this->input->post('permission_code'));
            $datas['created_by_id'] = $this->session->userdata('session_data')->user_id;
            $datas['submit'] = $this->input->post('submit');
            $web_user_type = $this->input->post("web_user_type");
            $web_user_description = $this->input->post("web_user_description");
            $this->form_validation->set_rules('web_user_type', 'Web User Type', 'trim|required|callback_checkUserType');
            $this->form_validation->set_rules('web_user_description', 'Web User Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->ManagementModel->userType_add($datas);
                $this->session->set_flashdata('success_msg', 'Successfully created user type');
                redirect('userType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['permission'] = $this->permission->user_permission();
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'User Type';
        $data['page'] = 'UserTypeAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete user type details */

    public function userType_update() {
        $id = $this->input->post('edit_id');
        if ($this->input->post('submit')) {

            $web_user_type = $this->input->post("web_user_type");
            $web_user_description = $this->input->post("web_user_description");
            $this->form_validation->set_rules('web_user_type', 'Web User Type', 'required');
            $this->form_validation->set_rules('web_user_description', 'Web User Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data['web_user_type'] = $this->input->post('web_user_type');
                $data['web_user_description'] = $this->input->post('web_user_description');
                $data['permission_code'] = json_encode($this->input->post('permission_code'));
                $data['created_by_id'] = $this->session->userdata('session_data')->user_id;
                $data['submit'] = $this->input->post('submit');
                $datas = $this->ManagementModel->userType_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated user type');
                redirect('userType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $data['result'] = $result = $this->ManagementModel->userType_update($id);
            $data['permission'] = $this->permission->user_permission($result);
            $data['menu'] = '';
            $data['title'] = 'User Type';
            $data['page'] = 'UserTypeEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('web_user_status' => 0);
            $assetDelete = $this->ManagementModel->userType_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Successfully deleted user type');
            redirect('userType');
        }

        if ($this->input->post('copy')) {
            $id = $this->input->post('edit_id');
            $assetDelete = $this->ManagementModel->userType_copy($id);
            $this->session->set_flashdata('success_msg', 'Successfully Copy User type');
            redirect('userType');
        }
    }

    /* This controller is using for check user type already exists or not */

    public function checkUserType($userType) {
        $count = $this->ManagementModel->checkUserType($userType);
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkUserType", 'This user type already exists...');
            return FALSE;
        }
    }

    /* This controller is using for display status type */

    public function statusType() {
        $data['result'] = $this->ManagementModel->statusType();
        $data['menu'] = '';
        $data['title'] = 'Status Type';
        $data['page'] = 'StatusTypeView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add status type */

    public function statusType_add() {
        if ($this->input->post('submit')) {
            $status_type = $this->input->post("status_type");
            $status_description = $this->input->post("status_description");
            //  $this->form_validation->set_rules('status_type', 'Status Type', 'trim|required|callback_checkStatusType');
            $this->form_validation->set_rules('status_type', 'Status Type', 'required');
            $this->form_validation->set_rules('status_description', 'Status Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->ManagementModel->statusType_add($this->input->post());
                $this->session->set_flashdata('success_msg', 'Successfully created status type');
                redirect('statusType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Status Type';
        $data['page'] = 'StatusTypeAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete status type details */

    public function statusType_update() {
        $id = $this->input->post('edit_id');
        if ($this->input->post('submit')) {
            $status_type = $this->input->post("status_type");
            $status_description = $this->input->post("status_description");
            $this->form_validation->set_rules('status_type', 'Status Type', 'required');
            $this->form_validation->set_rules('status_description', 'Status Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                $datas = $this->ManagementModel->statusType_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated status type');
                redirect('statusType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $data['result'] = $this->ManagementModel->statusType_update($id);
            $data['menu'] = '';
            $data['title'] = 'Status Type';
            $data['page'] = 'StatusTypeEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('status_stat' => 0);
            $assetDelete = $this->ManagementModel->statusType_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Deleted successfully !');
            redirect('statusType');
        }
    }

    /* This controller is using for check status type already exists or not */

    public function checkStatusType($statusType) {
        $count = $this->ManagementModel->checkStatusType($statusType);
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkStatusType", 'This status type already exists...');
            return FALSE;
        }
    }

    /* This controller is using for display call status type */

    public function callstatusType() {
        $data['result'] = $this->ManagementModel->callstatusType();
        $data['menu'] = '';
        $data['title'] = 'Call Status Type';
        $data['page'] = 'CallStatusTypeView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add call status type */

    public function callstatusType_add() {
        if ($this->input->post('submit')) {
            $callstatus_type = $this->input->post("callstatus_type");
            $callstatus_description = $this->input->post("callstatus_description");
            //$this->form_validation->set_rules('callstatus_type', 'Call Status Type', 'trim|required|callback_checkCallStatusType');
            $this->form_validation->set_rules('callstatus_type', 'Call Status Type', 'required');
            $this->form_validation->set_rules('callstatus_description', 'Call Status Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->ManagementModel->callstatusType_add($this->input->post());
                $this->session->set_flashdata('success_msg', 'Successfully created call status type');
                redirect('callstatusType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Call Status Type';
        $data['page'] = 'CallStatusTypeAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete call status type details */

    public function callstatusType_update() {
        $id = $this->input->post('edit_id');
        if ($this->input->post('submit')) {
            $status_type = $this->input->post("callstatus_type");
            $status_description = $this->input->post("callstatus_description");
            $this->form_validation->set_rules('callstatus_type', 'Call Status Type', 'required');
            $this->form_validation->set_rules('callstatus_description', 'Call Status Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                $datas = $this->ManagementModel->callstatusType_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated call status type');
                redirect('callstatusType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $data['result'] = $this->ManagementModel->callstatusType_update($id);
            $data['menu'] = '';
            $data['title'] = 'Call Status Type';
            $data['page'] = 'CallStatusTypeEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('callstatus_stat' => 0);
            $callStatusTypeDelete = $this->ManagementModel->callstatusType_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Deleted successfully !');
            redirect('callstatusType');
        }
    }

    /* This controller is using for check status type already exists or not */

    public function checkCallStatusType($callstatusType) {
        $count = $this->ManagementModel->checkCallStatusType($callstatusType);
        //print_r($count); die;
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkCallStatusType", 'This call status type already exists...');
            return FALSE;
        }
    }

    /* This controller is using for display call status type */

    public function callType() {
        $data['result'] = $this->ManagementModel->callType();
        $data['menu'] = '';
        $data['title'] = 'Call Type';
        $data['page'] = 'CallTypeView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add call status type */

    public function callType_add() {
        if ($this->input->post('submit')) {
            $calltype_type = $this->input->post("calltype_type");
            $calltype_description = $this->input->post("calltype_description");
            //$this->form_validation->set_rules('calltype_type', 'Call Type', 'trim|required|callback_checkCallType');
            $this->form_validation->set_rules('calltype_type', 'Call Type', 'required');
            $this->form_validation->set_rules('calltype_description', 'Call Type Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->ManagementModel->callType_add($this->input->post());
                $this->session->set_flashdata('success_msg', 'Successfully created call type');
                redirect('callType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Call Type';
        $data['page'] = 'CallTypeAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete call status type details */

    public function callType_update() {
        $id = $this->input->post('edit_id');
        if ($this->input->post('submit')) {
            $calltype_type = $this->input->post("calltype_type");
            $calltype_description = $this->input->post("calltype_description");
            $this->form_validation->set_rules('calltype_type', 'Call Type', 'required');
            $this->form_validation->set_rules('calltype_description', 'Call Type Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                $datas = $this->ManagementModel->callType_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated call type');
                redirect('callType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $data['result'] = $this->ManagementModel->callType_update($id);
            $data['menu'] = '';
            $data['title'] = 'Call Type';
            $data['page'] = 'CallTypeEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('calltype_stat' => 0);
            $callStatusTypeDelete = $this->ManagementModel->callType_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Deleted successfully !');
            redirect('callType');
        }
    }

    /* This controller is using for check status type already exists or not */

    public function checkCallType($callType) {
        $count = $this->ManagementModel->checkCallType($callType);
        //print_r($count); die;
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkCallType", 'This call type already exists...');
            return FALSE;
        }
    }

    /* This controller is using for display priority type */

    public function priorityType() {
        $data['result'] = $this->ManagementModel->priorityType();
        $data['menu'] = '';
        $data['title'] = 'Priority Type';
        $data['page'] = 'PriorityTypeView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add call status type */

    public function priorityType_add() {
        if ($this->input->post('submit')) {
            $priority_type = $this->input->post("priority_type");
            $priority_description = $this->input->post("priority_description");
            //$this->form_validation->set_rules('priority_type', 'Priority Type', 'trim|required|callback_checkPriorityType');
            $this->form_validation->set_rules('priority_type', 'Priority Type', 'required');
            $this->form_validation->set_rules('priority_description', 'Priority Type Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->ManagementModel->priorityType_add($this->input->post());
                $this->session->set_flashdata('success_msg', 'Successfully created priority type');
                redirect('priorityType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Priority Type';
        $data['page'] = 'PriorityTypeAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete call status type details */

    public function priorityType_update() {
        $id = $this->input->post('edit_id');
        if ($this->input->post('submit')) {
            $priority_type = $this->input->post("priority_type");
            $priority_description = $this->input->post("priority_description");
            $this->form_validation->set_rules('priority_type', 'Priority Type', 'required');
            $this->form_validation->set_rules('priority_description', 'Priority Type Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                $datas = $this->ManagementModel->priorityType_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated priority type');
                redirect('priorityType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $data['result'] = $this->ManagementModel->priorityType_update($id);
            $data['menu'] = '';
            $data['title'] = 'Priority Type';
            $data['page'] = 'PriorityTypeEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('priority_stat' => 0);
            $callStatusTypeDelete = $this->ManagementModel->priorityType_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Deleted successfully !');
            redirect('priorityType');
        }
    }

    /* This controller is using for check status type already exists or not */

    public function checkPriorityType($priorityType) {
        $count = $this->ManagementModel->checkPriorityType($priorityType);
        //print_r($count); die;
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkPriorityType", 'This priority type already exists...');
            return FALSE;
        }
    }

    /* This controller is using for display SLA details */

    public function sla() {
        $data['result'] = $this->ManagementModel->sla();
        $data['menu'] = '';
        $data['title'] = 'SLA';
        $data['page'] = 'SLAView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add SLA details */

    public function sla_add() {
        //$data['customer_name'] = $this->ManagementModel->getCustomerType();
        $data['branch_name'] = $this->ManagementModel->getBranchype();
        $data['entity_name'] = $this->ManagementModel->getEntityType();
        if ($this->input->post('submit')) {
            $sla_name = $this->input->post("sla_name");
            $sla_details = $this->input->post("sla_details");
            $sla_amount = $this->input->post("sla_amount");
            $this->form_validation->set_rules('sla_name', 'SLA Name', 'trim|required|callback_checkSLAName');
            $this->form_validation->set_rules('sla_details', 'SLA Details', 'required');
            $this->form_validation->set_rules('sla_time_hours', 'SLA Time', 'required');
            if ($this->form_validation->run() == TRUE) {
                $insertdata = array();
                $insertdata = $this->input->post();
                if ($this->input->post('optradio') == 'branchDiv') {
                    $insertdata['ent_id'] = $this->ManagementModel->branchToEntity($this->input->post('branch_id'));
                }
                $this->ManagementModel->sla_add($insertdata);
                $this->session->set_flashdata('success_msg', 'Sucessfully created the SLA');
                redirect('sla');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['menu'] = '';
        $data['title'] = 'SLA';
        $data['page'] = 'SLAAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete SLA details */

    public function sla_update() {
        $id = $this->input->post('edit_id');
        $data['branch_name'] = $this->ManagementModel->getBranchype();
        $data['entity_name'] = $this->ManagementModel->getEntityType();
        if ($this->input->post('submit')) {
            $sla_name = $this->input->post("sla_name");
            $sla_details = $this->input->post("sla_details");
            $this->form_validation->set_rules('sla_name', 'SLA Name', 'required');
            $this->form_validation->set_rules('sla_details', 'SLA Details', 'required');
            $this->form_validation->set_rules('sla_time_hours', 'SLA Time', 'required');
            if ($this->form_validation->run() == TRUE) {
                $datas = $this->ManagementModel->sla_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated the SLA');
                redirect('sla');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $data['result'] = $this->ManagementModel->sla_update($id);
            $data['menu'] = '';
            $data['title'] = 'SLA';
            $data['page'] = 'SLAEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('sla_status' => 0);
            $datas = $this->ManagementModel->sla_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Successfully deleted the SLA');
            redirect('sla');
        }
    }

    /* This controller is using for check SLA name already exists or not */

    public function checkSLAName($slaname) {
        $count = $this->ManagementModel->userSetting($slaname);
        if ($count == 0) {
            return true;
        } else {
            $this->form_validation->set_message('checkSLAName', 'This SLA name already exists...');
            return false;
        }
    }

    public function userSetting() {
        $data['result'] = $this->ManagementModel->userSetting();
        $data['menu'] = '';
        $data['title'] = 'setting';
        $data['page'] = 'SettingView';


        if ($this->input->post('submits')) {
            $sla_name = $this->input->post("web_name");
            $sla_details = $this->input->post("web_password");
            $this->form_validation->set_rules('sla_name', 'SLA Name', 'required');
            $this->form_validation->set_rules('sla_details', 'SLA Details', 'required');
            $this->form_validation->set_rules('sla_time_hours', 'SLA Time', 'required');
            if ($this->form_validation->run() == TRUE) {
                $datas = $this->ManagementModel->sla_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated the SLA');
                redirect('sla');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $this->load->view("common/CommonView", $data);
    }

}
