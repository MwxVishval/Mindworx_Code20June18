<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class WorkOrderController extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("WorkOrderModel");
    }

    /* This controller is using for display work order details */

    public function workOrder() {
        $data['result'] = $this->WorkOrderModel->workOrder();
        $data['menu'] = '';
        $data['title'] = 'Work Order';
        $data['page'] = 'WorkOrderView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add work order details */

    public function addWorkOrder() {
        $data['result'] = $this->WorkOrderModel->typeDetails();
        $data['menu'] = '';
        $data['title'] = 'Work Order';
        $data['page'] = 'WorkOrderAddView';
        if ($this->input->post('submit')) {
            $insert = array();
            $insert['task_id'] = $this->input->post('task_id');
            $insert['work_order_description'] = $this->input->post('work_order_description');
            $insert['customer_id'] = $this->input->post('customer_id');
            $insert['status_id'] = $this->input->post('status_id');
            $insert['start_date'] = $this->input->post('start_date');
            $insert['end_date'] = $this->input->post('end_date');
            $this->WorkOrderModel->insertWorkOrder($insert);
            $this->session->set_flashdata('success_msg', 'Added successfully !');
            redirect('workOrder');
        }

        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete work order details */

    public function updateWorkOrder() {
        $id = $this->input->post('edit_id');
        $data['results'] = $this->WorkOrderModel->typeDetails();
        if ($this->input->post('submit')) {
            $insert['task_id'] = $this->input->post('task_id');
            $insert['work_order_description'] = $this->input->post('work_order_description');
            $insert['customer_id'] = $this->input->post('customer_id');
            $insert['status_id'] = $this->input->post('status_id');
            $insert['start_date'] = $this->input->post('start_date');
            $insert['end_date'] = $this->input->post('end_date');
            $this->form_validation->set_rules('task_id', 'Task Name', 'required');
            $this->form_validation->set_rules('work_order_description', 'Work Order Description', 'required');
            $this->form_validation->set_rules('status_id', 'Status', 'required');

            if ($this->form_validation->run() == TRUE) {
                $insert = $this->input->post();
                $datas = $this->WorkOrderModel->editWorkOrder($this->input->post('id'), $insert);
                $sql = $this->db->last_query();
                $this->session->set_flashdata('success_msg', 'Updated successfully !');
                redirect('workOrder');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }

        if ($this->input->post('edit')) {
            $data['result'] = $this->WorkOrderModel->updateWorkOrder($id);
            $sql = $this->db->last_query();
            $data['menu'] = '';
            $data['title'] = 'Web User';
            $data['page'] = 'WorkOrderEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('work_order_status' => 0);
            $aa = $this->WorkOrderModel->editWorkOrder($id, $data);
            $sql = $this->db->last_query();
            $this->session->set_flashdata('note_msg', 'Deleted successfully !');
            redirect('workOrder');
        }
    }

}
