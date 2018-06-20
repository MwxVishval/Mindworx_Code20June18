<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AssetController extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("CronModel");
    }

    public function index() {
        
    }

    public function assetsFromServiceNow() {

        try {
            $login = SERVICE_NOW_USERNAME;
            $password = SERVICE_NOW_PASSWORD;
            $url = QUINTICA_PRODUCTION_URL . "/api/qsal/get_table_size/asset";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
            $result = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($result);
            $end_count = $data->result;
            // $end_count = $end_count/2;
            // $end_count = $end_count+1000;
            $task_log = array('task_log' => 'Assets synchronization',
                'task_name' => 'Crontab',
                'apiname' => 'Assets From ServiceNow',
                'api_response' => date("h:i:sa")
            );
            //   $this->CronModel->InsertData('qm_task_create_log', $task_log);

            $txt = date("h:i:sa") . " Time of log\n";
            $myfile = fopen(ERROR_LOG_PATH . "assetsLogs.txt", "a");
            fwrite($myfile, $txt);
            fclose($myfile);
            $start_count = 0;
            $condition = TRUE;
            $login = SERVICE_NOW_USERNAME;
            $password = SERVICE_NOW_PASSWORD;
            $this->db->truncate(QM_SERVICE_NOW_ASSETS);
            while ($start_count <= $end_count) {
                try {
                    $i = 0;
                    $url = QUINTICA_PRODUCTION_URL . "/api/now/v1/table/cmdb_model?sysparm_query=ORDERBYsys_id&sysparm_view=workwide&sysparm_limit=5000&sysparm_offset=" . $org_start_count;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $data = json_decode($result);
                    if (isset($data->status)) {
                        if ($data->status == "failure") {
                            $condition = FALSE;
                        }
                    } else {
                        $condition = TRUE;
                    }
                    $main_array = $data->result;
                    $insert = array();
                    foreach ($main_array AS $d) {
                        $insert['type'] = $d->type;
                        $insert['u_is_serialised'] = $d->u_is_serialised;
                        $insert['description'] = $d->description;
                        $insert['display_name'] = trim($d->display_name);
                        $this->CronModel->InsertData(QM_SERVICE_NOW_ASSETS, $insert);
                        $insert = array();
                        $i++;
                    }

                    $bettween = $start_count;
                    $start_count = $start_count + 5000;
                    $org_start_count = $start_count+1;
                    $txt = $bettween . ' to  ' . $start_count . " ---- Offset --- \n";
                    $txt.= $i . " ---- Total count between offset --- \n";
                    if ($condition == FALSE) {
                        $txt.= " ---- End point return failure --- \n";
                    }
                    $txt.= " ----------------------------------------- \n\n";
                    $myfile = fopen(ERROR_LOG_PATH . "assetsLogs.txt", "a");
                    fwrite($myfile, $txt);
                    fclose($myfile);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function assetsFromServiceNow_two() {

        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        $url = QUINTICA_PRODUCTION_URL . "/api/qsal/get_table_size/asset";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result);
        $end_count = $data->result;
        $task_log = array('task_log' => 'Assets synchronization',
            'task_name' => 'Crontab',
            'apiname' => 'Assets From ServiceNow',
            'api_response' => date("h:i:sa")
        );
        $this->CronModel->InsertData('qm_task_create_log', $task_log);

        $txt = date("h:i:sa") . " Time of log\n";
        $myfile = fopen(ERROR_LOG_PATH . "assetsLogs.txt", "a");
        fwrite($myfile, $txt);
        fclose($myfile);
        $start_count = $end_count / 2;
        $end_count = $end_count + 1000;
        $condition = TRUE;
        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        //  $this->db->truncate(QM_SERVICE_NOW_ASSETS);
        while ($start_count <= $end_count) {
            $i = 0;
            $url = QUINTICA_PRODUCTION_URL . "/api/now/v1/table/cmdb_model?sysparm_query=ORDERBYsys_id&sysparm_view=workwide&sysparm_limit=1000&sysparm_offset=" . $start_count;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
            $result = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($result);
            if (isset($data->status)) {
                if ($data->status == "failure") {
                    $condition = FALSE;
                }
            } else {
                $condition = TRUE;
            }
            $main_array = $data->result;
            $insert = array();
            foreach ($main_array AS $d) {
                $insert['type'] = $d->type;
                $insert['u_is_serialised'] = $d->u_is_serialised;
                $insert['description'] = $d->description;
                $insert['display_name'] = trim($d->display_name);
                $this->CronModel->InsertData(QM_SERVICE_NOW_ASSETS, $insert);
                $insert = array();
                $i++;
            }

            $bettween = $start_count;
            $start_count = $start_count + 1000;

            $txt = $bettween . ' to  ' . $start_count . " ---- Offset --- \n";
            $txt.= $i . " ---- Total count between offset --- \n";
            if ($condition == FALSE) {
                $txt.= " ---- End point return failure --- \n";
            }
            $txt.= " ----------------------------------------- \n\n";
            $myfile = fopen(ERROR_LOG_PATH . "assetsLogs.txt", "a");
            fwrite($myfile, $txt);
            fclose($myfile);
        }
    }

}
