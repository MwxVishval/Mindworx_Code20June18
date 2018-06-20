<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DashBoardModel extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->model("DashBoardModel");
    }

    public function getCustomerType() {
        $query = $this->db->query("SELECT id,cus_name FROM " . QM_CUSTOMER_DETAILS . " WHERE cus_status=1");
        $result = $query->result();
        $id = array(
            ''
        );
        $cus_name = array(
            '--Select--'
        );
        for ($i = 0; $i < count($result); $i++) {
            array_push($id, $result[$i]->id);
            array_push($cus_name, $result[$i]->cus_name);
        }
        return array_combine($id, $cus_name);
    }

    public function getBranchype() {
        $query = $this->db->query("SELECT id,branch_name FROM " . QM_BRANCH . " WHERE branch_status=1");
        $result = $query->result();
        $id = array(
            ''
        );
        $branch_name = array(
            '--Select--'
        );
        for ($i = 0; $i < count($result); $i++) {
            array_push($id, $result[$i]->id);
            array_push($branch_name, $result[$i]->branch_name);
        }
        return array_combine($id, $branch_name);
    }

    public function newTaskCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_TASK . '.status_id) as totalnewTask');
        $query = $this->db->from(QM_TASK);
        // $query = $this->db->join(QM_STATUS_TYPE, QM_TASK.'.status_id = '.QM_STATUS_TYPE.'.id');
        // $this->db->order_by(QM_TASK.'.id','DESC');
        $query = $this->db->where(QM_TASK . '.status_id', 1);
        $query = $this->db->where(QM_TASK . '.task_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function newIncidentCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_INCIDENT . '.status_id) as totalnewIncident');
        $query = $this->db->from(QM_INCIDENT);
        $query = $this->db->join(QM_STATUS_TYPE, QM_INCIDENT . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_INCIDENT . '.id', 'DESC');
        $query = $this->db->where(QM_INCIDENT . '.status_id', 1);
        $query = $this->db->where(QM_INCIDENT . '.incident_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function newProjectCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_PROJECT . '.status_id) as totalnewProject');
        $query = $this->db->from(QM_PROJECT);
        $query = $this->db->join(QM_STATUS_TYPE, QM_PROJECT . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_PROJECT . '.id', 'DESC');
        $query = $this->db->where(QM_PROJECT . '.status_id', 1);
        $query = $this->db->where(QM_PROJECT . '.proj_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function pendingTaskCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_TASK . '.status_id) as totalpendingTask');
        $query = $this->db->from(QM_TASK);
        $query = $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_TASK . '.id', 'DESC');
        $query = $this->db->where(QM_TASK . '.status_id', 2);
        $query = $this->db->where(QM_TASK . '.task_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function pendingIncidentCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_INCIDENT . '.status_id) as totalpendingIncident');
        $query = $this->db->from(QM_INCIDENT);
        $query = $this->db->join(QM_STATUS_TYPE, QM_INCIDENT . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_INCIDENT . '.id', 'DESC');
        $query = $this->db->where(QM_INCIDENT . '.status_id', 2);
        $query = $this->db->where(QM_INCIDENT . '.incident_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function pendingProjectCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_PROJECT . '.status_id) as totalpendingProject');
        $query = $this->db->from(QM_PROJECT);
        $query = $this->db->join(QM_STATUS_TYPE, QM_PROJECT . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_PROJECT . '.id', 'DESC');
        $query = $this->db->where(QM_PROJECT . '.status_id', 2);
        $query = $this->db->where(QM_PROJECT . '.proj_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function progressTaskCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_TASK . '.status_id) as totalprogressTask');
        $query = $this->db->from(QM_TASK);
        $query = $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_TASK . '.id', 'DESC');
        $query = $this->db->where(QM_TASK . '.status_id', 3);
        $query = $this->db->where(QM_TASK . '.task_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function progressIncidentCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_INCIDENT . '.status_id) as totalprogressIncident');
        $query = $this->db->from(QM_INCIDENT);
        $query = $this->db->join(QM_STATUS_TYPE, QM_INCIDENT . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_INCIDENT . '.id', 'DESC');
        $query = $this->db->where(QM_INCIDENT . '.status_id', 3);
        $query = $this->db->where(QM_INCIDENT . '.incident_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function progressProjectCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_PROJECT . '.status_id) as totalprogressProject');
        $query = $this->db->from(QM_PROJECT);
        $query = $this->db->join(QM_STATUS_TYPE, QM_PROJECT . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_PROJECT . '.id', 'DESC');
        $query = $this->db->where(QM_PROJECT . '.status_id', 3);
        $query = $this->db->where(QM_PROJECT . '.proj_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function completedTaskCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_TASK . '.status_id) as totalcompletedTask');
        $query = $this->db->from(QM_TASK);
        $query = $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_TASK . '.id', 'DESC');
        $query = $this->db->where(QM_TASK . '.status_id', 4);
        $query = $this->db->where(QM_TASK . '.task_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function completedIncidentCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_INCIDENT . '.status_id) as totalcompletedIncident');
        $query = $this->db->from(QM_INCIDENT);
        $query = $this->db->join(QM_STATUS_TYPE, QM_INCIDENT . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_INCIDENT . '.id', 'DESC');
        $query = $this->db->where(QM_INCIDENT . '.status_id', 4);
        $query = $this->db->where(QM_INCIDENT . '.incident_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function completedProjectCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_PROJECT . '.status_id) as totalcompletedProject');
        $query = $this->db->from(QM_PROJECT);
        $query = $this->db->join(QM_STATUS_TYPE, QM_PROJECT . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_PROJECT . '.id', 'DESC');
        $query = $this->db->where(QM_PROJECT . '.status_id', 4);
        $query = $this->db->where(QM_PROJECT . '.proj_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function failedTaskCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_TASK . '.status_id) as totalfailedTask');
        $query = $this->db->from(QM_TASK);
        $query = $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_TASK . '.id', 'DESC');
        $query = $this->db->where(QM_TASK . '.status_id', 5);
        $query = $this->db->where(QM_TASK . '.task_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function failedIncidentCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_INCIDENT . '.status_id) as totalfailedIncident');
        $query = $this->db->from(QM_INCIDENT);
        $query = $this->db->join(QM_STATUS_TYPE, QM_INCIDENT . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_INCIDENT . '.id', 'DESC');
        $query = $this->db->where(QM_INCIDENT . '.status_id', 5);
        $query = $this->db->where(QM_INCIDENT . '.incident_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function failedProjectCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_PROJECT . '.status_id) as totalfailedProject');
        $query = $this->db->from(QM_PROJECT);
        $query = $this->db->join(QM_STATUS_TYPE, QM_PROJECT . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_PROJECT . '.id', 'DESC');
        $query = $this->db->where(QM_PROJECT . '.status_id', 5);
        $query = $this->db->where(QM_PROJECT . '.proj_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cancelledTaskCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_TASK . '.status_id) as totalcancelledTask');
        $query = $this->db->from(QM_TASK);
        $query = $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_TASK . '.id', 'DESC');
        $query = $this->db->where(QM_TASK . '.status_id', 6);
        $query = $this->db->where(QM_TASK . '.task_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cancelledIncidentCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_INCIDENT . '.status_id) as totalcancelledIncident');
        $query = $this->db->from(QM_INCIDENT);
        $query = $this->db->join(QM_STATUS_TYPE, QM_INCIDENT . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_INCIDENT . '.id', 'DESC');
        $query = $this->db->where(QM_INCIDENT . '.status_id', 6);
        $query = $this->db->where(QM_INCIDENT . '.incident_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cancelledProjectCount() {
        /* $query = $this->db->select(QM_BRANCH.'.id,'.QM_BRANCH.'.ent_id,'.QM_ENTITY.'.ent_name,'.QM_BRANCH.'.branch_name,'.QM_BRANCH.'.branch_location'); */
        $this->db->select('count(' . QM_PROJECT . '.status_id) as totalcancelledProject');
        $query = $this->db->from(QM_PROJECT);
        $query = $this->db->join(QM_STATUS_TYPE, QM_PROJECT . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->order_by(QM_PROJECT . '.id', 'DESC');
        $query = $this->db->where(QM_PROJECT . '.status_id', 6);
        $query = $this->db->where(QM_PROJECT . '.proj_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

}
