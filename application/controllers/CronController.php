<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CronController extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model("CronModel");
    }

    public function index() {

        $task_log = array('task_log' => 'Start synchronization',
            'task_name' => 'Crontab Start',
            'apiname' => 'Crontab',
            'api_response' => date("h:i:sa")
        );
        $this->CronModel->InsertData('qm_task_create_log', $task_log);

        // $this->CloseCodeServiceNow();
        $this->LocationCodeServiceNow();
        $this->SectionCodeServiceNow();
        $this->ActionCodeServiceNow();
        $this->LocationServiceNow();
        $this->problemTwoServiceNow();
        $this->problemOneServiceNow();
        $this->productLineServiceNow();

        $task_logs = array('task_log' => 'Completed synchronization',
            'task_name' => 'Crontab Stop',
            'apiname' => 'Crontab',
            'api_response' => date("h:i:sa")
        );
        $this->CronModel->InsertData('qm_task_create_log', $task_logs);
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
        if (isset($data->error)) {
            return;
        }
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

}
