<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

class User extends Util
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isUserLoggedIn')) {
            $this->notLoginRedirect();
        }
        if (!in_array("show roles", $this->session->userdata('allowedRights'))) {
            redirect('crmerror/page_not_found', 'refresh');
        }
    }

    public function add_user_details()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Add Right Details';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'user/add_rights_det';

        $data['page']['styles'] = array(
            // 'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            // 'assets/datatable/buttons/css/buttons.dataTables.min.css',
            // 'assets/datatable-responsive/css/responsive.dataTables.css',
            // 'assets/select2/select2.min.css'
        );

        $data['page']['scripts'] = array(
            // 'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatable/js/jquery.dataTables.min.js',
            // 'assets/datatable/buttons/js/dataTables.buttons.min.js',
            // 'assets/datatable/buttons/js/buttons.print.min.js',
            // 'assets/select2/select2.full.min.js',
            // 'assets/toastr/sweetalert2@10.js',
            // 'assets/js/complain/viewTracks.js',
            'assets/js/user/view_edit_right.js',
        );

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('user_right', 'User Right', 'required');

        if ($this->form_validation->run() != FALSE) {
            $insertData = array(
                "RId" => (int) $this->input->post('roId'),
                "UserRight" => $this->input->post('user_right'),
                "RightDescription" => $this->input->post('right_description'),
            );
            $roId = $this->InsertUpdateRightDetails($insertData);
            if ($roId > 0) {
                $this->session->set_flashdata('success', 'Success');
            } else {
                $this->session->set_flashdata('error', 'Error');
            }
            redirect('user/add_user_details', 'refresh');
        }

        $listRight = $this->GetListOfRights('')->GetListOfRights;
        $data['content'] = $listRight;

        $this->load->view('base', $data);
    }

    public function insertRightsForRole()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('right_id', 'User Right', 'required');
        $this->form_validation->set_rules('role_id', 'User Role', 'required');

        if ($this->form_validation->run() != FALSE) {
            $data = array(
                "RDId" => $this->input->post('rdid'),
                "RightId" => $this->input->post('right_id'),
                "RoleId" => $this->input->post('role_id'),
                "IsAcive" => $this->input->post('isactive') != null ? true : false,
            );
            $rdid = $this->InsertUpdateRightsForRole($data);
            if ($rdid > 0) {
                $this->session->set_flashdata('success', 'Successfully inserted');
            } else {
                $this->session->set_flashdata('error', ' Not inserted. Please try again');
            }
        } else {
            $this->session->set_flashdata('error', ' Fields not satisfied');
        }
        redirect('user/add_rolesRights', 'refresh');
    }

    public function add_rolesRights()
    {
        $urlParam = crmDecryptUrlParameter()[0];
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Add Rights Roles';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'user/add_right_role';

        $data['page']['styles'] = array();

        $data['page']['scripts'] = array(
            'assets/js/user/add_right_role.js',
        );

        $rightRole = $this->GetRightDetailsByRoleId('', $urlParam['rid'])->GetRightDetailsByRoleId;

        $roleData = array(
            "Id" => $urlParam['rid'],
            "Name" => ""
        );
        $roleName = $this->GetlistOfRoles($roleData)->ROleList;
        $roler = '';
        foreach ($roleName as $value) {
            if($value->RId == $urlParam['rid'])
                $roler = $value->RightName;
        }

        $data['content'] = array(
            'roleName' => $rightRole,
            'roleId' => $urlParam['rid'],
            'roleNameSee' => $roler
        );

        $this->load->view('base', $data);
    }

    public function view_rolesRights()
    {
        $urlParam = crmDecryptUrlParameter()[0];
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Add Rights Roles';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'user/view_rolesRights';

        $data['page']['styles'] = array();

        $data['page']['scripts'] = array(
            'assets/js/user/add_right_role.js',
        );

        $rightRole = $this->GetRightDetailsByRoleId('', $urlParam['rid'])->GetRightDetailsByRoleId;

        $data['content'] = array(
            'roleName' => $rightRole,
            'roleId' => $urlParam['rid'],
            'roleNameSee' => $urlParam['rolena']
        );

        $this->load->view('base', $data);
    }

    public function viewUserRoles()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Add Rights Roles';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'user/viewUserRoles';

        $data['page']['styles'] = array();

        $data['page']['scripts'] = array();

        $roleData = array(
            "Id" => 0,
            "Name" => ""
        );
        $roleName = $this->GetlistOfRoles($roleData)->ROleList;

        $data['content'] = array(
            'roleName' => $roleName,
        );

        $this->load->view('base', $data);
    }

    public function ajaxRegisterRole()
    {
        $rdider = 0;
        $rdid = $this->input->post('rdid');
        $checker = $this->input->post('checked');
        $rolerId = 0;
        foreach ($rdid as $key => $value) {
            $rdDec = crmDecryptWithParameter($value)[0];
            $data = array(
                "RDId" => (int)$rdDec['rdid'],
                "RightId" => (int)$rdDec['rightId'],
                "RoleId" => (int)$rdDec['roleId'],
                "IsActive" => (bool)$checker[$key + 1],
            );
            $rdider = $this->InsertUpdateRightsForRole($data);
            $rolerId = $rdDec['roleId'];
        }
        if ($rdider > 0) {
            $this->session->set_flashdata('success', 'Successfully updated');
            redirect('user/viewUserRoles', 'refresh');
        } else {
            $this->session->set_flashdata('error', ' Not updated. Please try again');
            redirect('user/add_rolesRights?q=' . crmEncryptUrlParameter('rid=' . $rolerId), 'refresh');
        }
    }

    public function ajaxGetListRights()
    {
        $rightRole = $this->GetListOfRights('')->GetListOfRights;
        echo json_encode($rightRole);
    }

    /**
     * new roles
     * show employees
     * show leave
     * show salary
     * show notice
     * show roster
     * show roles
     * show complain
     * show product
     * show crm
     * show attendance
     * show performance
     * show vacancy
     * show visitor
     * show dashboard
     * show profile
     * leave settings
     * add/edit
     * give performance rev
     * show own salary
     * add complain
     * show sales
     * show customer
     * create login
     * add new rights
     * update rights
     * employee assign
     * register employee
     */
}
