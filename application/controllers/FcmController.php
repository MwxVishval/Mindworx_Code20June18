<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FcmController extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("FcmModel");
        
    }

    public function index() {
        
        $data['menu'] = '';
        $data['title'] = 'Report';
        $data['page'] = 'ReportView';
        $this->load->view("FcmView", $data);
    }
}
