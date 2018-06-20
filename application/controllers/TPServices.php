<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class TPServices extends REST_Controller {

    function __construct() {
        parent::__construct();
        $keyArray = array();
        $postArray = array();
        $this->load->model("TPServicesModel");
    }

    public function index_get() {
        $message = [
            'message' => 'Invalid method',
            'status' => 'Failed',
            'code' => '0',
        ];
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function index_post() {
        $message = [
            'message' => 'Invalid method',
            'status' => 'Failed',
            'code' => '0',
        ];
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function checkPost($postArray = NULL, $keyArray = NULL) {
        $return_val = 'TRUE';
        if ((!empty($postArray)) && (!empty($keyArray))) {
            foreach ($postArray as $key => $value) {
                if (array_key_exists($key, $keyArray)) {
                    if ($keyArray[$key] == 'required') {
                        if (trim($postArray[$key]) == "") {
                            $return_val = 'FALSE';
                        }
                    }
                } else {
                    $return_val = 'FALSE';
                }
            }
        } else {
            $return_val = 'FALSE';
        }
        foreach ($keyArray AS $k => $v) {
            if (!array_key_exists($k, $postArray)) {
                if ($keyArray[$k] != "optional") {
                    $return_val = 'FALSE';
                }
            }
        }
        return $return_val;
    }

    public function CreateTask_get() {
        
        $getArray = $this->post();
        $data = array();
        if (count($getArray) == 0) {
            $inputJSON = file_get_contents('php://input');
            $getArray = json_decode($inputJSON, TRUE);
        }
        if (count($getArray) == 0) {
            $getArray = array();
        }
        if (isset($getArray['apiKey'])) {
            $task_type_id = $this->TPServicesModel->gettasktypeIdUsingAPIkey($getArray['apiKey']);
            if ($task_type_id != FALSE) {
                $result = $this->TPServicesModel->get_taskFelidsbyTaskType($task_type_id);
                $check = $this->TPServicesModel->array_cam_postdata($getArray, $result);
                if ($check == "ARRAY_MACHED") {
                    $data = $this->TPServicesModel->CreateTask(array_merge($getArray,array('taskType'=>$task_type_id)));
                } else {
                    $data = $check;
                }
            } else {
                $data = "Wrong API Key";
            }
        } else {
            $data = "Wrong JSON Format...! API Key Field Missing";
        }
        $message = [
            'message' => 'Task Create API ',
            'report' => $data,
            'status' => 'Success',
            'code' => '1',
        ];
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function CreateTask_post() {
        
        $getArray = $this->post();
        $data = array();
        if (count($getArray) == 0) {
            $inputJSON = file_get_contents('php://input');
            $getArray = json_decode($inputJSON, TRUE);
        }
        if (count($getArray) == 0) {
            $getArray = array();
        }
        if (isset($getArray['apiKey'])) {
            $task_type_id = $this->TPServicesModel->gettasktypeIdUsingAPIkey($getArray['apiKey']);
            if ($task_type_id != FALSE) {
                $result = $this->TPServicesModel->get_taskFelidsbyTaskType($task_type_id);
                $check = $this->TPServicesModel->array_cam_postdata($getArray, $result);
                if ($check == "ARRAY_MACHED") {
                    $data = $this->TPServicesModel->CreateTask(array_merge($getArray,array('taskType'=>$task_type_id)));
                } else {
                    $data = $check;
                }
            } else {
                $data = "Wrong API Key";
            }
        } else {
            $data = "Wrong JSON Format...! API Key Field Missing";
        }
        $message = [
            'message' => 'Task Create API ',
            'report' => $data,
            'status' => 'Success',
            'code' => '1',
        ];
        
        $insert_array = array(
            'task_log' => json_encode($getArray), 
            'api_response'=> json_encode($data), 
            'task_name'=> "Create API", 
            'apiname'=> 'Thirdy party Create API' 
        );
        $this->TPServicesModel->tp_error($insert_array);
        
        $this->set_response($message, REST_Controller::HTTP_OK);
    }
    
    
    public function updateTask_post() {
        
        $getArray = $this->post();
        $data = array();
        if (count($getArray) == 0) {
            $inputJSON = file_get_contents('php://input');
            $getArray = json_decode($inputJSON, TRUE);
        }
        if (count($getArray) == 0) {
            $getArray = array();
        }
        if (isset($getArray['apiKey'])) {
            $task_type_id = $this->TPServicesModel->gettasktypeIdUsingAPIkey($getArray['apiKey']);
            if ($task_type_id != FALSE) {
                $result = $this->TPServicesModel->get_taskFelidsbyTaskType($task_type_id);
                $check = $this->TPServicesModel->array_cam_postdata($getArray, $result);
                if ($check == "ARRAY_MACHED") {
                    $data = $this->TPServicesModel->updateTask(array_merge($getArray,array('taskType'=>$task_type_id)));
                } else {
                    $data = $check;
                }
            } else {
                $data = "Wrong API Key";
            }
        } else {
            $data = "Wrong JSON Format...! API Key Field Missing";
        }
        $message = [
            'message' => 'Task Update API ',
            'report' => $data,
            'status' => 'Success',
            'code' => '1',
        ];
        
        $insert_array = array(
            'task_log' => json_encode($getArray), 
            'api_response'=> json_encode($data), 
            'task_name'=> "Create API", 
            'apiname'=> 'Thirdy party update API' 
        );
        $this->TPServicesModel->tp_error($insert_array);
        
        $this->set_response($message, REST_Controller::HTTP_OK);
    }
    

    public function postdata_get() {
       
        $data_stringss = '{  
   "apiKey":"15b161c581df5c366dfcdb269a075d7b",
   "fseEmail":"Sathish90@gmail.com",
   "task_name":"17April Task 3sss",
   "priority":"HIGH",
   "taskStatus":"Assigned",
   "taskLocationAddress":"Full address",
   "customer type":"customer type example_data",
   "Customer Name":"Customer Name example_data",
   "FSE Phone":"FSE Phone example_data",
   "Checker Names":"Checker Name example_data",
   "Cherker phone":"Cherker phone example_data",
   "Comments":"Comments example_data",
   "Select option":"Select option example_data",
   "Checking":"Checking example_data"
}';

        $data_string = '{  
    "apiKey":"15b161c581df5c366dfcdb269a075d7b",
    "fseEmail":"Sathish90@gmail.com",
    "task_name":"fixing Example 11xzdsfds11xdvf",
    "priority":"HIGH",
    "taskStatus":"Assigned",
    "taskLocationAddress":"Full address",
    "customer type":"customer type example_data",
    "Customer Name":"Customer Name example_data",
    "FSE Phone":"FSE Phone example_data",
    "Checker Name":"Checker Name example_data",
    "Cherker phone":"Cherker phone example_data",
    "Comments":"Comments example_data",
    "Select option":"Select option example_data",
    "Checking":"Checking example_data"
}';
        
        
        // $data_string = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://202.129.196.133/Qmobility3/TPServices/CreateTask");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'Content-Length: ' . strlen($data_string)
        ));

        $output = curl_exec($ch);

        echo "<pre>";



        if ($output === FALSE) {
            die(curl_error($ch));
        }
        echo($output);

        curl_close($ch);
    }
    
    public function feedback_get(){
       
        $this->TPServicesModel->thirdpartUpatetimeFeedback(136343);
        
    }
    
    public function getlocation()
    {
        print_r($_POST);        exit(); 
    }
}
