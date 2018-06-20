<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ApiSetting extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("CronModel");
    }

    public function index() {
        $this->CloseCodeServiceNow();
        $this->LocationCodeServiceNow();
        $this->SectionCodeServiceNow();
        $this->ActionCodeServiceNow();
        $this->LocationServiceNow();
        $this->problemTwoServiceNow();
        $this->problemOneServiceNow();
        $this->productLineServiceNow();
     //   $this->assetsFromServiceNow();
        return TRUE;
    }

    public function getAssetsFromServiceNow($id = NULL) {
        $result_url = $this->CronModel->getApiUrlPassUser($id);
        if (!empty($result_url)) {
            $login = trim($result_url[0]['as_username']);
            $password = trim($result_url[0]['as_password']);
            $url = trim($result_url[0]['as_endpointurl']);
            $ent_id = $result_url[0]['ent_id'];

            $login = SERVICE_NOW_USERNAME;
            $password = SERVICE_NOW_PASSWORD;
            $url = QUINTICA_PRODUCTION_URL . '/api/now/v1/table/cmdb_model?sysparm_view=workwide';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
            $result = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($result);
            $main_array = $data->result;
            $insert = array();

            foreach ($main_array AS $d) {
                $querys = NULL;
                $count_row = NULL;
                $this->db->where('display_name', trim($d->display_name));
                $this->db->where('ent_id', $ent_id);
                $querys = $this->db->get(QM_SERVICE_NOW_ASSETS);
                $count_row = $querys->num_rows();
                if ($count_row == 0) {
                    $insert['ent_id'] = $ent_id;
                    $insert['type'] = $d->type;
                    $insert['u_is_serialised'] = $d->u_is_serialised;
                    $insert['description'] = $d->description;
                    $insert['display_name'] = trim($d->display_name);
                    $this->CronModel->InsertData(QM_SERVICE_NOW_ASSETS, $insert);
                    $insert = array();
                }
            }
        }
    }

    public function getActionCodeFromServiceNow($id = NULL) {

        $result_url = $this->CronModel->getApiUrlPassUser($id);
        if (!empty($result_url)) {
            $login = trim($result_url[0]['a_username']);
            $password = trim($result_url[0]['a_password']);
            $url = trim($result_url[0]['a_endpointurl']);
            $ent_id = $result_url[0]['ent_id'];

            $login = SERVICE_NOW_USERNAME;
            $password = SERVICE_NOW_PASSWORD;
            $url = QUINTICA_PRODUCTION_URL . '/api/now/table/sys_choice?sysparm_query=name=incident&inactive=false&element=u_action_code&ORDERBYsequence';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
            $result = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($result);
            $main_array = $data->result;
            $insert = array();
            foreach ($main_array AS $d) {
                $querys = NULL;
                $count_row = NULL;
                $this->db->where('action_code', trim($d->value));
                $this->db->where('ent_id', $ent_id);
                $querys = $this->db->get(QM_ACTION_CODE);
                $count_row = $querys->num_rows();
                if ($count_row == 0) {
                    $insert['ent_id'] = $ent_id;
                    $insert['action_code'] = trim($d->value);
                    $this->CronModel->InsertData(QM_ACTION_CODE, $insert);
                    $insert = array();
                }
            }
        }
    }

    public function getCloseCodeFromServiceNow($id = NULL) {

        $result_url = $this->CronModel->getApiUrlPassUser($id);
        if (!empty($result_url)) {
            $login = trim($result_url[0]['c_username']);
            $password = trim($result_url[0]['c_password']);
            $url = trim($result_url[0]['c_endpointurl']);
            $ent_id = $result_url[0]['ent_id'];
            $login = SERVICE_NOW_USERNAME;
            $password = SERVICE_NOW_PASSWORD;
            $url = QUINTICA_PRODUCTION_URL . '/api/now/table/sys_choice?sysparm_query=name=incident&inactive=false&element=close_code&ORDERBYsequence';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
            $result = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($result);
            $main_array = $data->result;
            $insert = array();
            foreach ($main_array AS $d) {
                $querys = NULL;
                $count_row = NULL;
                $this->db->where('close_code', trim($d->value));
                $this->db->where('ent_id', $ent_id);
                $querys = $this->db->get(QM_CLOSE_CODE);
                $count_row = $querys->num_rows();
                if ($count_row == 0) {

                    $insert['ent_id'] = $ent_id;
                    $insert['close_code'] = trim($d->value);
                    $this->CronModel->InsertData(QM_CLOSE_CODE, $insert);
                    $insert = array();
                }
            }
        }
    }

    public function getSectionCodeFromServiceNow($id = NULL) {

        $result_url = $this->CronModel->getApiUrlPassUser($id);
        if (!empty($result_url)) {
            $login = trim($result_url[0]['s_username']);
            $password = trim($result_url[0]['s_password']);
            $url = trim($result_url[0]['s_endpointurl']);
            $ent_id = $result_url[0]['ent_id'];
            $login = SERVICE_NOW_USERNAME;
            $password = SERVICE_NOW_PASSWORD;
            $url = QUINTICA_PRODUCTION_URL . '/api/now/table/sys_choice?sysparm_query=name=incident&inactive=false&element=u_section_code&ORDERBYsequence';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
            $result = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($result);
            $main_array = $data->result;
            $insert = array();
            foreach ($main_array AS $d) {
                $querys = NULL;
                $count_row = NULL;
                $this->db->where('section_code', trim($d->value));
                $this->db->where('ent_id', $ent_id);
                $querys = $this->db->get(QM_SECTION_CODE);
                $count_row = $querys->num_rows();
                if ($count_row == 0) {
                    $insert['ent_id'] = $ent_id;
                    $insert['section_code'] = trim($d->value);
                    $this->CronModel->InsertData(QM_SECTION_CODE, $insert);
                    $insert = array();
                }
            }
        }
    }

    public function getLocationCodeFromServiceNow($id = NULL) {

        $result_url = $this->CronModel->getApiUrlPassUser($id);
        if (!empty($result_url)) {
            $login = trim($result_url[0]['l_username']);
            $password = trim($result_url[0]['l_password']);
            $url = trim($result_url[0]['l_endpointurl']);
            $ent_id = $result_url[0]['ent_id'];
            $login = SERVICE_NOW_USERNAME;
            $password = SERVICE_NOW_PASSWORD;
            $url = QUINTICA_PRODUCTION_URL . '/api/now/table/sys_choice?sysparm_query=name=incident&inactive=false&element=u_loaction_code&ORDERBYsequence';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
            $result = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($result);
            $main_array = $data->result;
            $insert = array();
            foreach ($main_array AS $d) {
                $querys = NULL;
                $count_row = NULL;
                $this->db->where('location_code', trim($d->value));
                $this->db->where('ent_id', $ent_id);
                $querys = $this->db->get(QM_LOCATION_CODE);
                $count_row = $querys->num_rows();
                if ($count_row == 0) {
                    $insert['ent_id'] = $ent_id;
                    $insert['location_code'] = trim($d->value);
                    $this->CronModel->InsertData(QM_LOCATION_CODE, $insert);
                    $insert = array();
                }
            }
        }
        
    }

    public function productLineServiceNow() {
        
        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        $url = QUINTICA_PRODUCTION_URL . '/api/now/v1/table/sys_choice?sysparm_query=elementINu_product_line&sysparm_fields=dependent_value,element,label';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result)->result;
        $insert = array();
        foreach ($data AS $d) {
            $querys = NULL;
            $count_row = NULL;
            $this->db->where('value', trim($d->label));
            $querys = $this->db->get(QM_PRODUCT_LINE);
            $count_row = $querys->num_rows();
            if (TRUE) {
                $insert['value'] = trim($d->label);
                $this->CronModel->InsertData(QM_PRODUCT_LINE, $insert);
                $insert = array();
            }
        }
        
    }

    public function problemOneServiceNow() {
        
        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        $url = QUINTICA_PRODUCTION_URL . '/api/now/v1/table/sys_choice?sysparm_query=elementINu_tier_1&sysparm_fields=value,dependent_value,label,element';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result)->result;
        $insert = array();
        foreach ($data AS $d) {
            $querys = NULL;
            $count_row = NULL;
            $this->db->where('value', trim($d->label));
            $this->db->where('dependent_value', trim($d->dependent_value));
            $querys = $this->db->get(QM_PROBLEM_ONE);
            $count_row = $querys->num_rows();
            if ($count_row == 0) {
                $insert['value'] = trim($d->label);
                $insert['dependent_value'] = trim($d->dependent_value);
                $this->CronModel->InsertData(QM_PROBLEM_ONE, $insert);
                $insert = array();
            }
        }
        
    }

    public function problemTwoServiceNow() {
        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        $url = QUINTICA_PRODUCTION_URL . '/api/now/table/u_segmented_pal_codes?sysparm_fields=u_product_line,u_problem_2,u_problem_1&sysparm_query=u_incident_request=I';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result)->result;
        $insert = array();
        foreach ($data AS $d) {
            $querys = NULL;
            $count_row = NULL;
            $this->db->where('value', trim($d->u_problem_2));
            $this->db->where('dependent_value', trim($d->u_problem_1));
            $querys = $this->db->get(QM_PROBLEM_TWO);
            $count_row = $querys->num_rows();
            if ($count_row == 0) {
                $insert['value'] = trim($d->u_problem_2);
                $insert['dependent_value'] = trim($d->u_problem_1);
                $this->CronModel->InsertData(QM_PROBLEM_TWO, $insert);
                $insert = array();
            }
        }
    }

    public function LocationServiceNow() {
        
        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        $url = QUINTICA_PRODUCTION_URL . '/api/now/v1/table/sys_choice?sysparm_query=elementINu_problem_code_2&sysparm_fields=value,dependent_value,label,element';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result)->result;
        $insert = array();
        foreach ($data AS $d) {
            $querys = NULL;
            $count_row = NULL;
            $this->db->where('value', trim($d->label));
            $this->db->where('dependent_value', trim($d->dependent_value));
            $querys = $this->db->get(QM_SN_LOCATION);
            $count_row = $querys->num_rows();
            if ($count_row == 0) {
                $insert['value'] = trim($d->label);
                $insert['dependent_value'] = trim($d->dependent_value);
                $this->CronModel->InsertData(QM_SN_LOCATION, $insert);
                $insert = array();
            }
        }
    }

    public function ActionCodeServiceNow() {
        
        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        $url = QUINTICA_PRODUCTION_URL . '/api/now/v1/table/sys_choice?sysparm_query=elementINu_action_code&sysparm_fields=value,dependent_value,label,element';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result)->result;
        $insert = array();
        foreach ($data AS $d) {
            $querys = NULL;
            $count_row = NULL;
            $this->db->where('value', trim($d->label));
            $this->db->where('dependent_value', trim($d->dependent_value));
            $querys = $this->db->get(QM_ACTION_CODE);
            $count_row = $querys->num_rows();
            if ($count_row == 0) {
                $insert['value'] = trim($d->label);
                $insert['dependent_value'] = trim($d->dependent_value);
                $this->CronModel->InsertData(QM_ACTION_CODE, $insert);
                $insert = array();
            }
        }
        
    }

    public function SectionCodeServiceNow() {
        
        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        $url = QUINTICA_PRODUCTION_URL . '/api/now/v1/table/sys_choice?sysparm_query=elementINu_section_code&sysparm_fields=value,dependent_value,label,element';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result)->result;
        $insert = array();
        foreach ($data AS $d) {
            $querys = NULL;
            $count_row = NULL;
            $this->db->where('value', trim($d->label));
            $this->db->where('dependent_value', trim($d->dependent_value));
            $querys = $this->db->get(QM_SECTION_CODE);
            $count_row = $querys->num_rows();
            if ($count_row == 0) {
                $insert['value'] = trim($d->label);
                $insert['dependent_value'] = trim($d->dependent_value);
                $this->CronModel->InsertData(QM_SECTION_CODE, $insert);
                $insert = array();
            }
        }
        
    }

    public function LocationCodeServiceNow() {
        
        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        $url = QUINTICA_PRODUCTION_URL . '/api/now/v1/table/sys_choice?sysparm_query=elementINu_loaction_code&sysparm_fields=value,dependent_value,label,element';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result)->result;
        $insert = array();
        foreach ($data AS $d) {
            $querys = NULL;
            $count_row = NULL;
            $this->db->where('value', trim($d->label));
            $this->db->where('dependent_value', trim($d->dependent_value));
            $querys = $this->db->get(QM_LOCATION_CODE);
            $count_row = $querys->num_rows();
            if ($count_row == 0) {
                $insert['value'] = trim($d->label);
                $insert['dependent_value'] = trim($d->dependent_value);
                $this->CronModel->InsertData(QM_LOCATION_CODE, $insert);
                $insert = array();
            }
        }
        
    }

    public function CloseCodeServiceNow() {
        
        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        $url = QUINTICA_PRODUCTION_URL . '/api/qsal/get_close_codes?sysparm_fields=value,label,element';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result);
        if(isset($data->error)){return;}
        $insert = array();
        foreach ($data AS $d) {
            $querys = NULL;
            $count_row = NULL;
            $this->db->where('value', trim($d->label));
            $this->db->where('dependent_value', trim($d->dependent_value));
            $querys = $this->db->get(QM_LOCATION_CODE);
            $count_row = $querys->num_rows();
            if ($count_row == 0) {
                $insert['value'] = trim($d->label);
                $insert['dependent_value'] = trim($d->dependent_value);
                $this->CronModel->InsertData(QM_LOCATION_CODE, $insert);
                $insert = array();
            }
        }
        
    }

    public function assetsFromServiceNow() {

        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        $url = QUINTICA_PRODUCTION_URL . '/api/now/v1/table/cmdb_model?sysparm_view=workwide';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result);
        $main_array = $data->result;
        $insert = array();
        foreach ($main_array AS $d) {
            $querys = NULL;
            $count_row = NULL;
            $this->db->where('display_name', trim($d->display_name));
            $querys = $this->db->get(QM_SERVICE_NOW_ASSETS);
            $count_row = $querys->num_rows();
            if ($count_row == 0) {
                $insert['type'] = $d->type;
                $insert['u_is_serialised'] = $d->u_is_serialised;
                $insert['description'] = $d->description;
                $insert['display_name'] = trim($d->display_name);
                $this->CronModel->InsertData(QM_SERVICE_NOW_ASSETS, $insert);
                $insert = array();
            }
        }
        
    }

    public function index_OLD() {
        $id = $this->input->post('id');
        $ent_id = $this->input->post('ent_id');
        $this->getAssetsFromServiceNow($id);
        $this->getActionCodeFromServiceNow($id);
        $this->getCloseCodeFromServiceNow($id);
        $this->getSectionCodeFromServiceNow($id);
        $this->getLocationCodeFromServiceNow($id);
        return TRUE;
    }

    public function assetsCount() {

        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        $url = 'https://quinticanashuadev.service-now.com/api/qsal/get_table_size';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result);
        
        echo "<pre>";
        
        print_r($data);
        
        exit();
        
        
        $main_array = $data->result;
        $insert = array();
        foreach ($main_array AS $d) {
            $querys = NULL;
            $count_row = NULL;
            $this->db->where('display_name', trim($d->display_name));
            $querys = $this->db->get(QM_SERVICE_NOW_ASSETS);
            $count_row = $querys->num_rows();
            if ($count_row == 0) {
                $insert['type'] = $d->type;
                $insert['u_is_serialised'] = $d->u_is_serialised;
                $insert['description'] = $d->description;
                $insert['display_name'] = trim($d->display_name);
                $this->CronModel->InsertData(QM_SERVICE_NOW_ASSETS, $insert);
                $insert = array();
            }
        }
    }
    
}
