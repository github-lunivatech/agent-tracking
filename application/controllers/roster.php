<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

class Roster extends Util
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isUserLoggedIn')) {
            $this->notLoginRedirect();
        }
        if ($this->session->userdata('loggedInRole') == 'Visitor') {
            redirect('crmerror/page_not_found', 'refresh');
        }
    }

    public function roster_add()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Add Notice';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'dutyroster/roster_add';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/moment.min.js',
            'assets/daterangepicker-master/daterangepicker.js',
            // 'assets/toastr/sweetalert2@10.js',
            'assets/js/roster/roster_add.js'
        );

        $comDet = $this->GetCompanyDetails()->CompanyName;
        $da = array(
            "Id" => $comDet[0]->CId,
            "Name" => ''
        );
        $department = $this->GetDepartmentByCompanyId($da)->DepartmentLst;
        $data['depart'] = $department;

        $weekList = $this->hardCodedWeekSel();
        $data['week'] = $weekList;

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('jobId', 'Job Id', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['roster'] = array();
        } else {
            $list = $this->GetDutyShiftList('')->Shiftlist;
            $list2 = $this->GetDepartmentWiseEmployeeForDutyRoaster($this->input->post('jobId'))->DepartmentWiseEmployeeLst;

            // $list3 = $this->GetDepartmentWiseDutyShiftOfEmployeeAndDate('', $this->input->post('jobId'), '2021-08-08', '2021-08-14')->DepartmentWiseDutyRoaster;
            // var_dump($list3);exit;

            $data['shift'] = $list;
            $data['roster'] = $list2;
        }
        $this->load->view('base', $data);
    }

    public function insertRoster()
    {
        $today = new DateTime();
        $ent_date = $today->format('c');
        $empid = $this->input->post('ed');
        $eid = null;

        if ($empid != null) {
            $eid = crmDecryptWithParameter($empid)[0]['eid'];
        }

        if ($eid != null) {
            $data = array(
                "DRId" => $this->input->post('drid') ?? 0,
                "EmplyeeId" => (int)$eid,
                "DutyDate" => $this->input->post('dater'),
                "ShiftId" => (int)$this->input->post('val'),
                "UserId" => $this->input->post('userid') ?? $this->session->userdata('loggedInUserId'),
                "EntryDate" => $ent_date ?? $today->format('c'),
            );
            // var_dump($data);
            // exit;
            $drid = $this->InsertUdpateDutyRoasterofEmployee($data);
            if($drid > 0) {
                echo json_encode(array('drid' => $drid));
            }else{
                echo json_encode(array('drid' => 0));
            }
        } else {
            echo json_encode(array('drid' => 0));
        }
    }

    public function roster_view()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View Roster';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'dutyroster/roster_view';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/moment.min.js',
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/roster/roster_view.js'
        );

        $comDet = $this->GetCompanyDetails()->CompanyName;
        $da = array(
            "Id" => $comDet[0]->CId,
            "Name" => ''
        );
        $department = $this->GetDepartmentByCompanyId($da)->DepartmentLst;
        $data['depart'] = $department;

        $weekList = $this->hardCodedWeekSel();
        $data['week'] = $weekList;

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('jobId', 'Job Id', 'required');
        $this->form_validation->set_rules('from', 'From', 'required');
        $this->form_validation->set_rules('to', 'To', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['roster'] = array();
        } else {
            $list = $this->GetDutyShiftList('')->Shiftlist;

            $list3 = $this->GetDepartmentWiseDutyShiftOfEmployeeAndDate('', $this->input->post('jobId'), $this->input->post('from'), $this->input->post('to'))->DepartmentWiseDutyRoaster;

            $data['shift'] = $list;
            $data['roster'] = $list3;
        }
        $this->load->view('base', $data);
    }

    public function ajaxShift() {
        $list3 = $this->GetDepartmentWiseDutyShiftOfEmployeeAndDate('', $this->input->post('jobId'), $this->input->post('from'), $this->input->post('to'))->DepartmentWiseDutyRoaster;
        echo json_encode($list3);
    }
}
