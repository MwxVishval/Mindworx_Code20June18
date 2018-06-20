<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ReportController extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("ReportModel");
    }

    /* This controller is using for search different options for report generation */

    public function index() {
        $data['branch_name'] = $this->ReportModel->getBranchype();
        $data['proj_name'] = $this->ReportModel->getProjectName();
        $data['ent_name'] = $this->ReportModel->getEntityName();
        $data['incident_name'] = $this->ReportModel->getIncidentName();
        $data['fse_name'] = $this->ReportModel->getFSEName();
        $data['entityFeilds'] = $this->ReportModel->entityFeilds();
        $data['menu'] = '';
        $data['title'] = 'Report';
        $data['page'] = 'ReportView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for generate report based on search */

    public function generate_report() {
        
        if ($this->input->post('submit')) {
            $start_date = $this->input->post("start_date");
            $end_date = $this->input->post("end_date");
            $ent_id = $this->input->post("ent_id");
            $branch_id = $this->input->post("branch_id");
            $proj_id = $this->input->post("proj_id");
            $incident_id = $this->input->post("incident_id");
            $fse_id = $this->input->post("fse_id");
            
            $data = array('start_date' => $start_date, 'end_date' => $end_date, 'ent_id' => $ent_id, 'branch_id' => $branch_id, 'project_id' => $proj_id, '	incident_id' => $incident_id, 'fse_id' => $fse_id);
            $data['entityFeilds'] = $this->ReportModel->entityFeilds();
            $data['result'] = $this->ReportModel->report($this->input->post());
            $data['menu'] = '';
            $data['title'] = 'Report List';
            $data['page'] = 'ReportList';
            $this->load->view("common/CommonView", $data);
        }
    }
    
    public function generate_reportUiAction() {
            $data['result'] = $this->ReportModel->reportUiAction();
            $data['menu'] = '';
            $data['title'] = 'Report UI Action';
            $data['page'] = 'ReportUiActionView';
            $this->load->view("common/CommonView", $data);
        
    }
    
    public function generate_reportUiLoad() {
            $data['result'] = $this->ReportModel->reportUiload();
            $data['menu'] = '';
            $data['title'] = 'Report UI Action';
            $data['page'] = 'ReportUiLoadView';
            $this->load->view("common/CommonView", $data);
        
    }
    

}
