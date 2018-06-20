<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;


class ApiUpdate extends REST_Controller {
    function __construct() {
        parent::__construct();
     
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 500; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model("ApiUpdateModel");
        $keyArray = array();
        $postArray = array();
    }

    public function index_get() {
       
      

        return TRUE;


    }


    public function taskdata_get($task_id = NULL, $update_id = NULL)
    {
    	$getArray = $this->get();
        $keyArray['task_id'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional 

    	$task_id = $getArray['task_id'];
    	$data =  $this->ApiUpdateModel->taskTypeid($task_id,$update_id);

    	 if ($data != FALSE) {
                 $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            }
             else {
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } 
              $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
    }
    
    
    public function taskupdateThridparty_get()
    {
    	$getArray = $this->get();
                
        if (isset($getArray['task_id'])) {
              $task_id = $getArray['task_id'];
        }else{
            echo "task id missing";
            exit();
        }
        
    	$data[] =  $this->ApiUpdateModel->thirdpartApiUpdate($task_id);
        $data[] =  $this->ApiUpdateModel->thirdpartApiUpdateStatus($task_id);
    	 if ($data != FALSE) {
                 $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            }
             else {
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } 
              $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
    }
}
