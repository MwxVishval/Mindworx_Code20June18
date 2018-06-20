<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LogsController extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("LogsModel");
    }

    /* This controller is using for display task details */

    public function log() {
        
        $data['result'] = $this->LogsModel->Logs();
        $data['menu'] = '';
        $data['title'] = 'Logs';
        $data['page'] = 'LogsView';
        $this->load->view("common/CommonView", $data);
    }
 
}
