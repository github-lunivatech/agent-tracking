<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

/**
 * @author Anib
 * @package Huh
 */
class Leave extends Util
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isUserLoggedIn')) {
            $this->notLoginRedirect();
        }
        // if ($this->session->userdata('loggedInRole') == 'Visitor') {
        //     redirect('crmerror/page_not_found', 'refresh');
        // }
    }

    public function leaveReq()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Leave Request';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'leave/leave_request';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/css/fileUpload.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/js/leave/leave_request.js',
        );

        $datae = array(
            'Id' => $this->session->userdata('loggedInEmpId'),
            'Name' => ''
        );
        $list = $this->GetlistOfLeaveHead()->LeaveHead;
        $list2 = $this->GetListOfLeaveTypes()->LeaveType;

        $list3 = $this->GetLeaveDetailsByEmployeeId($datae)->EmpLeaveDetails;

        $lists = array(
            'head' => $list,
            'type' => $list2,
            'headEx' => $list3
        );
        $data['content'] = $lists;

        $this->load->view('base', $data);
    }

    public function leaveApplicationByEmp()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('leave_type', 'Leave Type', 'required');
        $this->form_validation->set_rules('leave_period', 'Leave Period', 'required');
        $this->form_validation->set_rules('startDate', 'Start Date', 'required');
        $this->form_validation->set_rules('endDate', 'End Date', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('leave/leaveReq');
        } else {
            $today = new DateTime();
            $startDate = new DateTime($this->input->post('startDate'));
            $endDate = new DateTime($this->input->post('endDate'));
            $data = array(
                "LAId" => $this->input->post('laid') != null ? (int)$this->input->post('laid') : 0,
                "EmployeeId" => $this->input->post('eid') != null ? (int)$this->input->post('eid') : $this->session->userdata('loggedInEmpId'),
                "LeaveSettingId" => (int)$this->input->post('leave_type'), //changed type is causal
                "LeaveTypeId" => (int)$this->input->post('leave_period'), // full time period
                "StartDate" => $startDate->format('c'),
                "EndDate" => $endDate->format('c'),
                "EntryDate" => $this->input->post('ent_date') != null ? $this->input->post('ent_date') : $today->format('c'),
                "Remarks" => $this->input->post('reason'),
                "LeaveStatus" => $this->input->post('lstat') != null ? $this->input->post('lstat') : 0,
                "ApprovedBy" => $this->input->post('approved_by') != null ? $this->input->post('approved_by') : 1,
                "ApprovedDate" => $this->input->post('approved_date') != null ? $this->input->post('approved_date') : $today->format('c'),
                "AttachementFile" => $this->input->post('leave_attachment') != null ? $this->input->post('leave_attachment') : '',
            );

            $laid = $this->LeaveApplicationByEmployee($data);

            $reData['li'] = $laid;
            if ($laid > 0) {
                $session_msg = 'Successfully applied for leave.';
                if ((int)$this->input->post('laid') != 0) {
                    $session_msg = 'Successfully Edited leave.';
                }
                $this->session->set_flashdata('success', $session_msg);
                // echo json_encode($reData);
                redirect('leave/leaveManage');
            } else {
                $session_msg = 'Error when applying for leave. Please try again later';
                if ((int)$this->input->post('laid') != 0) {
                    $session_msg = 'Error when editing. Please try again.';
                }
                $this->session->set_flashdata('error', $session_msg);
                // echo json_encode($reData);
                redirect('leave/leaveReq');
            }
        }
    }

    public function getleavehead()
    {
        $list = $this->GetlistOfLeaveHead();
    }

    public function leaveSettings()
    {
        // InsertUpdateLeaveSettings
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Leave Settings';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'leave/leave_setting';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/allSubDis.js',
        );

        $leaveGroup = $this->GetListOfLeaveGroupType('')->LeaveType;
        $leaveHead = $this->GetlistOfLeaveHead()->LeaveHead;
        $leaveType = $this->GetListOfLeaveTypes()->LeaveType;
        $data['leaveTypes'] = array(
            'lGroup' => $leaveGroup,
            'lHead' => $leaveHead,
            'llType' => $leaveType
        );

        $this->load->view('base', $data);
    }

    public function insertedSet()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('leave_type', 'Leave Type', 'required');
        $this->form_validation->set_rules('leave_count', 'Leave Count', 'required');
        $this->form_validation->set_rules('leave_group', 'Leave Group', 'required');
        $this->form_validation->set_rules('leave_head', 'Leave Head', 'required');

        if ($this->form_validation->run() != FALSE) {
            $today = new DateTime();
            $datae = array(
                "LId" => $this->input->post('lid') ?? 0,
                "LeaveType" => $this->input->post('leave_type'),
                "LeaveCount" => $this->input->post('leave_count'),
                "LeaveGroupId" => $this->input->post('leave_group'),
                "UserId" => $this->input->post('userid') ?? $this->session->userdata('loggedInUserId'),
                "EntryDate" => $today->format('c'),
                "LeaveHeadId" => $this->input->post('leave_head'),
            );
            $leid = $this->InsertUpdateLeaveSettings($datae);
            if ($leid > 0) {
                $data['content'] = $leid;
                $this->session->set_flashdata('success', 'Success');
            } else {
                $this->session->set_flashdata('error', 'error');
            }
        }

        redirect('leave/leaveSettings', 'refresh');
    }

    public function ajaxGetLeaveDetails()
    {
        $data = array(
            "Id" => $this->input->post('eid') != null ? $this->input->post('eid') : $this->session->userdata('loggedInEmpId'),
            "Name" => $this->input->post(''),
        );
        $headid = $this->input->post('da');
        $newArr = array();
        $list = $this->GetLeaveDetailsByEmployeeId($data)->EmpLeaveDetails;
        foreach ($list as $value) {
            if ($value->LeaveHeadId == $headid) {
                array_push($newArr, $value->Available);
            }
        }
        echo json_encode($newArr);
    }

    public function viewLeave()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Leave Request';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'leave/leave_view';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/js/leave/leave_view.js',
        );

        $datae = array(
            "Id" => $this->input->post('eid') != null ? $this->input->post('eid') : $this->session->userdata('loggedInEmpId'),
            "Name" => $this->input->post(''),
        );
        $list = $this->GetLeaveDetailsByEmployeeId($datae)->EmpLeaveDetails;

        // EmpLeaveDetails
        $data['content'] = $list;
        $this->load->view('base', $data);
    }

    public function viewAppLeave()
    {
        //admin or approver only cant be viewed by users or employee
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Leave Approve';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'leave/leave_approve';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/leave/leave_view.js',
        );

        // $this->load->library('form_validation');
        // if($this->form_validation->run() != FALSE){
        $appid = $this->input->post('eid');
        $datae = array(
            "Id" => 8, //$appid,
            "Name" => $this->input->post(''),
        );
        $list = $this->GetLeaveRequestedToBeApprovedByApprover($datae)->LeaveRequest;


        $this->load->view('base', $data);
    }

    public function approveLeave()
    {
        //this is leave approve reject cancel page for admin or approvers
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Leave Request';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'leave/approve_leaves';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/css/fileUpload.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/leave/leave_request.js',
        );

        $list = $this->GetlistOfLeaveHead()->LeaveHead;
        $list2 = $this->GetListOfLeaveTypes()->LeaveType;
        $lists = array(
            'head' => $list,
            'type' => $list2
        );
        $data['content'] = $lists;

        $this->load->view('base', $data);
    }

    public function editLeave()
    {
        //edit leave from here for every user
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Leave Request';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'leave/approve_leaves';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/css/fileUpload.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/js/leave/leave_request.js',
        );

        $list = $this->GetlistOfLeaveHead()->LeaveHead;
        $list2 = $this->GetListOfLeaveTypes()->LeaveType;

        $lists = array(
            'head' => $list,
            'type' => $list2
        );
        $data['content'] = $lists;

        $this->load->view('base', $data);
    }

    public function viewReqLev()
    {
        //view own leaves of employee leaves by admin
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Leave Request';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'leave/view_req_leave';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/js/leave/view_req_leave.js',
        );

        $datae = array(
            "Id" => $this->input->post('emid') != null ? $this->input->post('emid') : $this->session->userdata('loggedInEmpId'),
            "Name" => $this->input->post(''),
        );
        $leaveReq = $this->GetLeaveRequestedByEmployeeId($datae)->LeaveRequest;
        $data['content'] = $leaveReq;

        $this->load->view('base', $data);
    }

    public function cancelLeave()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('leave_type', 'Leave Type', 'required');
        $this->form_validation->set_rules('leave_period', 'Leave Period', 'required');
        $this->form_validation->set_rules('startDate', 'Start Date', 'required');
        $this->form_validation->set_rules('endDate', 'End Date', 'required');

        if ($this->form_validation->run() != FALSE) {
            $this->load->view('leave/leave_manage');
        } else {
            $today = new DateTime();
            $startDate = new DateTime($this->input->post('startDate'));
            $endDate = new DateTime($this->input->post('endDate'));
            $data = array(
                "LAId" => $this->input->post('laid') != null ? (int)$this->input->post('laid') : 0,
                "EmployeeId" => $this->input->post('eid') != null ? (int)$this->input->post('eid') : $this->session->userdata('loggedInEmpId'),
                "LeaveSettingId" => (int)$this->input->post('leave_type'), //changed type is causal
                "LeaveTypeId" => (int)$this->input->post('leave_period'), // full time period
                "StartDate" => $startDate->format('c'),
                "EndDate" => $endDate->format('c'),
                "EntryDate" => $this->input->post('ent_date') != null ? $this->input->post('ent_date') : $today->format('c'),
                "Remarks" => 'cancelled',
                "LeaveStatus" => 3,
                "ApprovedBy" => $this->input->post('approved_by') != null ? $this->input->post('approved_by') : 1,
                "ApprovedDate" => $this->input->post('approved_date') != null ? $this->input->post('approved_date') : $today->format('c'),
                "AttachementFile" => $this->input->post('leave_attachment') != null ? $this->input->post('leave_attachment') : '',
            );
            $laid = $this->LeaveApplicationByEmployee($data, true);
            $reData['li'] = $laid;
            if ($laid > 0) {
                $session_msg = 'Successfully Cancelled leave.';
                $this->session->set_flashdata('success', $session_msg);
                $reData['rm'] = $session_msg;
                echo json_encode($reData);
            } else {
                $session_msg = 'Error when cancelling for leave. Please try again later';
                $this->session->set_flashdata('error', $session_msg);
                $reData['rm'] = $session_msg;
                echo json_encode($reData);
            }
        }
    }

    public function leaveManage()
    {
        $isFiltered = isset($_GET['filt']);

        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Leave management';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'leave/leave_manage';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/js/leave/leave_manage.js',
            'assets/js/holiday/holiday_get.js',
        );

        $datae = array(
            "Id" => $this->input->post('emid') != null ? $this->input->post('emid') : $this->session->userdata('loggedInEmpId'),
            "Name" => $this->input->post(''),
        );

        $leaveReq = array();
        $leaveEnt = array();
        if (!$isFiltered) {
            //leave days you requested
            $leaveReq = $this->ajaxLeaveRequestedByEmpId($datae);
            //leaves remaining to you
            $leaveEnt = $this->GetLeaveDetailsByEmployeeId($datae)->EmpLeaveDetails;
        }

        //always show
        $leavePen = $this->ajaxLeaveApproveForThis($datae)['Pending'];
        $leaveApp = $this->ajaxLeaveApproveForThis($datae)['Approved'];

        $leaveStat = $this->hardCodeStat();

        $leaveDetails = array(
            'leaveReq' => $leaveReq,
            'leaveEnt' => $leaveEnt,
            'leavePen' => $leavePen,
            'leaveApp' => $leaveApp,
            'leaveStat' => $leaveStat,
            'isFiltered' => $isFiltered
        );
        $data['content'] = $leaveDetails;

        $this->load->view('base', $data);
    }

    public function ajaxLeaveRequestedByEmpId($datae)
    {
        $leaveReq = $this->GetLeaveRequestedByEmployeeId($datae)->LeaveRequest;
        $oldArr = array();
        foreach ($leaveReq as $value) {
            $newArr = array();
            foreach ($value as $val) {
                array_push($newArr, $val);
            }
            if ($value->AttachementFile != '') {
                $newArr[11] = $this->readServiceINI('API')['middleware'] . $value->AttachementFile;
            }
            array_push($oldArr, $newArr);
        }
        return $oldArr;
    }

    public function ajaxLeaveApproveForThis($datae)
    {
        $leavePen = $this->GetLeaveRequestedToBeApprovedByApprover($datae)->LeaveRequest;
        $oldArr = array(
            'Pending' => array(),
            'Approved' => array(),
        );

        foreach ($leavePen as $key => $value) {
            $newArr = array();
            if ($value->LeaveStatus == 'Pending') {
                foreach ($value as $val) {
                    array_push($newArr, $val);
                }
                if ($value->AttachementFile != '') {
                    $newArr[11] = $this->readServiceINI('API')['middleware'] . $value->AttachementFile;
                }
                array_push($oldArr['Pending'], $newArr);
            } elseif ($value->LeaveStatus == 'Approved') {
                foreach ($value as $val) {
                    array_push($newArr, $val);
                }
                if ($value->AttachementFile != '') {
                    $newArr[11] = $this->readServiceINI('API')['middleware'] . $value->AttachementFile;
                }
                array_push($oldArr['Approved'], $newArr);
            }
        }
        return $oldArr;
    }

    // public func

    public function ajaxCancelLeave()
    {
        $laid = (int) $this->input->post('laid');
        if ($laid != 0 && $laid != '') {
            $today = new DateTime();
            $startDate = new DateTime($this->input->post('startDate'));
            $endDate = new DateTime($this->input->post('endDate'));
            $data = array(
                "LAId" => $this->input->post('laid') != null ? (int)$this->input->post('laid') : 0,
                "EmployeeId" => $this->input->post('eid') != null ? (int)$this->input->post('eid') : $this->session->userdata('loggedInEmpId'),
                "LeaveSettingId" => (int)$this->input->post('leave_type'), //changed type is causal
                "LeaveTypeId" => (int)$this->input->post('leave_period'), // full time period
                "StartDate" => $startDate->format('c'),
                "EndDate" => $endDate->format('c'),
                "EntryDate" => $this->input->post('ent_date') != null ? $this->input->post('ent_date') : $today->format('c'),
                "Remarks" => 'cancelled',
                "LeaveStatus" => 3,
                "ApprovedBy" => $this->input->post('approved_by') != null ? $this->input->post('approved_by') : 1,
                "ApprovedDate" => $this->input->post('approved_date') != null ? $this->input->post('approved_date') : $today->format('c'),
                "AttachementFile" => $this->input->post('leave_attachment') != null ? $this->input->post('leave_attachment') : '',
            );

            $laid = $this->LeaveApplicationByEmployee($data, true);
            $reData['li'] = $laid;
            if ($laid > 0) {
                $session_msg = 'Successfully Cancelled leave.';
                $this->session->set_flashdata('success', $session_msg);
                $reData['rm'] = $session_msg;
                echo json_encode($reData);
            } else {
                $session_msg = 'Error when cancelling for leave. Please try again later';
                $this->session->set_flashdata('error', $session_msg);
                $reData['rm'] = $session_msg;
                echo json_encode($reData);
            }
        } else {
            echo '{"rm":"Error No id"}';
        }
    }

    public function ajaxLeaveApplicationByEmp()
    {
        // ajaxGetLeaveDetails here days needs to be calculated to know when the leave days are finished
        if ($this->input->post('totalDays') > 7) {
            echo '{"li": 0}';
            return;
        }
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('leave_type', 'Leave Type', 'required');
        $this->form_validation->set_rules('leave_period', 'Leave Period', 'required');
        $this->form_validation->set_rules('startDate', 'Start Date', 'required');
        $this->form_validation->set_rules('endDate', 'End Date', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('leave/leaveReq');
        } else {
            //added as there is eid in there
            $eid = null;
            if ($this->input->post('eeid') != null) {
                $eid = crmDecryptWithParameter($this->input->post('eeid'))[0]['eid'];
            }
            $laide = $this->input->post('laid');
            if ($this->input->post('did') != null) {
                $laide = crmDecryptWithParameter($this->input->post('did'))[0]['did'];
            }
            $today = new DateTime();
            $startDate = new DateTime($this->input->post('startDate'));
            $endDate = new DateTime($this->input->post('endDate'));
            $data = array(
                "LAId" => $laide != null ? (int)$laide : 0,
                "EmployeeId" => $eid != null ? (int)$eid : $this->session->userdata('loggedInEmpId'),
                "LeaveSettingId" => (int)$this->input->post('leave_type'), //changed type is causal
                "LeaveTypeId" => (int)$this->input->post('leave_period'), // full time period
                "StartDate" => $startDate->format('c'),
                "EndDate" => $endDate->format('c'),
                "EntryDate" => $this->input->post('ent_date') != null ? $this->input->post('ent_date') : $today->format('c'),
                "Remarks" => $this->input->post('reason'),
                "LeaveStatus" => $this->input->post('lstat') != null ? $this->input->post('lstat') : 0,
                "ApprovedBy" => $this->input->post('approved_by') != null ? $this->input->post('approved_by') : 1,
                "ApprovedDate" => $this->input->post('approved_date') != null ? $this->input->post('approved_date') : $today->format('c'),
                "AttachementFile" => $this->input->post('leave_attachment') != null ? $this->input->post('leave_attachment') : '',
            );
            // var_dump($data);exit;
            // $laid = $laide+1;
            // var_dump(($data));
            $laid = $this->LeaveApplicationByEmployee($data);
            // if($this->input->post('did') != null){
            //     var_dump(crmDecryptWithParameter($this->input->post('did')));
            // }
            // $laid = 1;   
            $reData['li'] = $laid;
            if ($laid > 0) {
                $session_msg = 'Successfully applied for leave. You will be notified when it gets approved.';
                if ((int)$this->input->post('laid') != 0) {
                    $session_msg = 'Successfully Edited leave.';
                }
                $this->session->set_flashdata('success', $session_msg);
                $reData['lis'] = crmEncryptUrlParameter('did=' . $laid);
                echo json_encode($reData);
                // var_dump($data);
            } else {
                $session_msg = 'Error when applying for leave. Please try again later';
                if ((int)$this->input->post('laid') != 0) {
                    $session_msg = 'Error when editing. Please try again.';
                }
                $this->session->set_flashdata('error', $session_msg);
                echo json_encode($reData);
            }
        }
    }

    public function ChangeLeaveStatus()
    {
        $serviceUrl = $this->readServiceINI('API')['middleware'];

        $fullData = $this->input->post('full');
        $laid = (int) $fullData[0];
        if ($laid != 0 && $laid != '') {
            $today = new DateTime();
            $startDate = new DateTime($fullData[4]);
            $endDate = new DateTime($fullData[5]);

            $exploder = '';
            if ($fullData[11] != '') {
                $exploder = explode($serviceUrl, $fullData[11])[1];
            }
            $data = array(
                "LAId" => $laid,
                "EmployeeId" => $fullData[1] != null ? (int)$fullData[1] : $this->session->userdata('loggedInEmpId'),
                "LeaveSettingId" => (int)$fullData[2], //changed type is causal
                "LeaveTypeId" => (int)$fullData[3], // full time period
                "StartDate" => $startDate->format('c'),
                "EndDate" => $endDate->format('c'),
                "EntryDate" => $fullData[6] != null ? $fullData[6] : $today->format('c'),
                "Remarks" => $this->input->post('leave_changerem'),
                "LeaveStatus" => $this->input->post('pend_stat') != null ? $this->input->post('pend_stat') : 0,
                "ApprovedBy" => $this->input->post('approved_by') != null ? $this->input->post('approved_by') : $this->session->userdata('loggedInEmpId'), //only when approved here
                "ApprovedDate" => $this->input->post('approved_date') != null ? $this->input->post('approved_date') : $today->format('c'), //only today as approved date
                "AttachementFile" => $exploder != null ? $exploder : '',
            );
            $laid = $this->LeaveApplicationByEmployee($data, true);
            $reData['li'] = $laid;
            if ($laid > 0) {
                $session_msg = 'Successfully Leave Status Changed.';
                $this->session->set_flashdata('success', $session_msg);
                $reData['rm'] = $session_msg;
                echo json_encode($reData);
            } else {
                $session_msg = 'Error when changing status for leave. Please try again later';
                $this->session->set_flashdata('error', $session_msg);
                $reData['rm'] = $session_msg;
                echo json_encode($reData);
            }
        } else {
            echo '{"rm":"Error No id"}';
        }
    }

    public function ajax_get_noti()
    {
        $data = array(
            'Id' => $this->session->userdata('loggedInEmpId'),
            'Name' => ''
        );
        $retNot = $this->ajaxLeaveApproveForThis($data)['Pending'];
        echo json_encode($retNot);
    }

    //for leave use rx
    public function AjaxUploadLeaveAttachment()
    {
        $attachFile = $_FILES['leave_attachment'];
        $did = crmDecryptWithParameter($_POST['did'])[0]['did'];

        // if(empty($attachFile)){
        if ($_FILES['leave_attachment']['name'] == '') {
            echo json_encode(['error' => 'No files are available']);
            return;
        }
        $data = array(
            'did' => $did,
            'filename' => 'Leave Attachment',
            '' => new cURLFile(
                $attachFile['tmp_name'],
                $attachFile['type'],
                $attachFile['name']
            ),
        );
        // echo '{"filename":"/UploadeFiles/1/1_02032021162759.png"}';
        // exit;
        $upFile = $this->uploadAttachment($data, true);
        echo $upFile;
    }

    public function leaveGroup()
    {
        if ($this->session->userdata('loggedInRole') == 'Employee') {
            redirect('crmerror/no_permission', 'refresh');
            return;
        }
        $eid = 0;
        if (isset($_GET['from']) && isset($_GET['q'])) {
            $eid = crmDecryptWithParameter($_GET['q'])[0]['eid'];
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Leave Request';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'leave/leave_group';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            // 'assets/css/fileUpload.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            // 'assets/toastr/sweetalert2@10.js',
            'assets/js/leave/leave_group.js',
        );

        $leaveGroup = $this->GetListOfLeaveGroupType('')->LeaveType;

        $leaveGId = array();
        if ($eid != 0) {
            $leaveGId = $this->GetLeaveGroupByEmpId($eid)->EmpLeaveGroup;
        } else {
            $leaveGId = $this->GetLeaveGroupByEmpId($this->session->userdata('loggedInEmpId'))->EmpLeaveGroup;
        }
        $newL = array();

        foreach ($leaveGId as $value) {
            $nL = array();
            foreach ($value as $val) {
                array_push($nL, $val);
            }
            array_push($newL, $nL);
        }

        $lists = array(
            'lGroup' => $leaveGroup,
            'oldLeave' => $newL
        );
        $data['content'] = $lists;

        $this->load->view('base', $data);
    }

    public function insertUpdateLeaveGroup()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('leave_group', 'Leave Group', 'required');
        $this->form_validation->set_rules('start_period', 'Start Period', 'required');
        $this->form_validation->set_rules('end_period', 'End Period', 'required');
        $this->form_validation->set_rules('isactive', 'Is Active', 'required');

        $today = new DateTime();
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('leave/leave_group');
        } else {
            $pSt = new DateTime($this->input->post('start_period'));
            $eSt = new DateTime($this->input->post('end_period'));
            $elid = 0;
            $empid = 0;
            $ent_date = $this->input->post('ent_date');
            if ($this->input->post('eeff')) {
                $ef = crmDecryptWithParameter($this->input->post('eeff'))[0];
                if (isset($ef['elid'])) {
                    $elid = (int)$ef['elid'];
                }
                if (isset($ef['ent_date'])) {
                    $ent_date = $ef['ent_date'];
                }
                $empid = (int)$ef['eid'];
            }

            $data = array(
                "ELId" => $elid != 0 ? $elid : 0,
                "EmployeeId" => $empid != 0 ? $empid : $this->session->userdata('loggedInEmpId'),
                "LeaveGroupId" => (int)$this->input->post('leave_group'),
                "Periodstart" => $pSt->format('c'),
                "EndPeriod" => $eSt->format('c'),
                "IsActive" => (int)$this->input->post('isactive') == 1 ? true : false,
                "UserId" => $this->input->post('user_id') != null ? $this->input->post('user_id') : $this->session->userdata('loggedInEmpId'),
                "EntryDate" => $ent_date != null ? $ent_date : $today->format('c'),
            );
            // var_dump($data);exit;
            $elid = $this->AssignEmployeeToLeaveGroup($data);
            if ($elid > 0) {
                $session_msg = 'Successfully Assigned Leave Group.';
                if ((int)$this->input->post('elid') != 0) {
                    $session_msg = 'Successfully Edited assigned leave group.';
                }
                $this->session->set_flashdata('success', $session_msg);
                redirect('leave/leaveManage');
            } else {
                $session_msg = 'Error when assigning leave group. Please try again later';
                if ((int)$this->input->post('elid') != 0) {
                    $session_msg = 'Error when editing. Please try again.';
                }
                $this->session->set_flashdata('error', $session_msg);
                redirect('leave/leaveGroup');
            }
        }
    }

    public function ajaxLeaveGroup()
    {
        $elid = (int)crmDecryptWithParameter($this->input->post('a'))[0]['elid'];
        $list = $this->GetLeaveGroupOfEmployeeById($elid)->EmpLeave;
        $lArr = array();
        foreach ($list as $value) {
            $nArr = array();
            foreach ($value as $val) {
                $nArr[] = $val;
            }
            array_push($lArr, $nArr);
        }
        echo json_encode($lArr[0]);
    }

    public function sendStatusEmail()
    {
        $this->load->config('email');
        $this->load->library('email');

        $from = $this->config->item('smtp_user');
        $to = $this->input->post('toer');

        $receiverName = 'Sir/Madam';

        $senderName = '';
        if ($senderName == '') {
            $senderName = $this->session->userdata('loggedInUsername');
        }


        $subject = $this->input->post('subject');
        $mbody = $this->input->post('mbody');

        $attachment = $this->input->post('leave_attachment');

        $reason = $this->input->post('reason');
        $reason2 = $this->input->post('leave_changerem');
        $acReson = '';
        if ($reason != null) {
            $acReson = $reason;
        } elseif ($reason2 != null) {
            $acReson = $reason2;
        }

        //loop here for efficency
        $fromWho = $this->input->post('from');
        // if($fromWho == 'Approver'){
        //     $to = crmDecryptWithParameter($to[0])[0]['applEmail'];
        // }else{
        //     $receiverName = crmDecryptWithParameter($to[0])[0]['apprName'];
        // }

        $message = '';

        $ser = $this->readServiceINI('API')['middleware'];

        $this->email->set_newline("\r\n");
        $this->email->from($from);

        if ($fromWho == 'Approver') {
            $to = crmDecryptWithParameter($to[0])[0]['applEmail'];
            $message = '<table cellpadding="8" cellspacing="0" style="padding:0;width:100%!important;background:#ffffff;margin:0;background-color:#ffffff" border="0">
                        <tbody>
                        <tr>
                        <td valign="top">
                        <table cellpadding="0" cellspacing="0" style="border-radius:4px;border:1px #dceaf5 solid" border="0" align="center">
                        <tbody>
                        <tr>
                        <td colspan="3" height="6"></td>
                        </tr>
                        <tr>
                        <td>
                        <table cellpadding="0" cellspacing="0" style="line-height:25px" border="0" align="center">
                        <tbody><tr><td colspan="3" height="30"></td></tr>
                        <tr>
                        <td width="36"></td>
                        <td width="454" align="left" style="color:#444444;border-collapse:collapse;font-size:11pt;font-family:proxima_nova,&#39;Open Sans&#39;,&#39;Lucida Grande&#39;,&#39;Segoe UI&#39;,Arial,Verdana,&#39;Lucida Sans Unicode&#39;,Tahoma,&#39;Sans Serif&#39;;max-width:454px" valign="top">
                        Dear ' . $receiverName . ',<br>
                        ' . $mbody . '<br>
                        ' . $acReson . '<br>
                        Please follow the link for verification <a href="' . base_url('leave/leaveManage#pele') . '" target="_blank">Click Here</a>
                        <br>Thank You for understanding,<br>
                        ' . $senderName . ' <br><br>
                        <small><i><strong>This mail is auto generated by Luniva.</strong></i></small>
                        </td>
                        <td width = "36"></td>
                        </tr>
                        <tr><td colspan = "3" height = "36"></td></tr>
                        </tbody>
                        </table>
                        </td>
                        </tr>
                        </tbody>
                        </table>
                        <table cellpadding = "0" cellspacing = "0" align = "center" border = "0">
                        <tbody>
                        <tr>
                        <td height = "10"></td>
                        </tr>
                        <tr>
                        <td style = "padding:0;border-collapse:collapse">
                        <table cellpadding = "0" cellspacing = "0" align = "center" border = "0">
                        <tbody>
                        <tr style = "color:#a8b9c6;font-size:11px;">
                        <td width = "auto" align = "right"> &copy; ' . date("Y") . ' Luniva Clinic</td>
                        </tr>
                        </tbody>
                        </table>
                        </td>
                        </tr>
                        </tbody>
                        </table>
                        </td>
                        </tr>
                        </tbody>
                        </table>';

            $this->email->to($to);
        } else {
            $approverEmail = array();
            foreach ($to as  $value) {
                //here when there are more email
                array_push($approverEmail, crmDecryptWithParameter($value)[0]['apprEmail']);

                $message = '<table cellpadding="8" cellspacing="0" style="padding:0;width:100%!important;background:#ffffff;margin:0;background-color:#ffffff" border="0">
                            <tbody>
                            <tr>
                            <td valign="top">
                            <table cellpadding="0" cellspacing="0" style="border-radius:4px;border:1px #dceaf5 solid" border="0" align="center">
                            <tbody>
                            <tr>
                            <td colspan="3" height="6"></td>
                            </tr>
                            <tr>
                            <td>
                            <table cellpadding="0" cellspacing="0" style="line-height:25px" border="0" align="center">
                            <tbody><tr><td colspan="3" height="30"></td></tr>
                            <tr>
                            <td width="36"></td>
                            <td width="454" align="left" style="color:#444444;border-collapse:collapse;font-size:11pt;font-family:proxima_nova,&#39;Open Sans&#39;,&#39;Lucida Grande&#39;,&#39;Segoe UI&#39;,Arial,Verdana,&#39;Lucida Sans Unicode&#39;,Tahoma,&#39;Sans Serif&#39;;max-width:454px" valign="top">
                            Dear ' . crmDecryptWithParameter($value)[0]['apprName'] . ',<br>
                            ' . $mbody . '<br>
                            ' . $acReson . '<br>
                            Please follow the link for verification <a href="' . base_url('leave/leaveManage') . '" target="_blank">Click Here</a>
                            <br>Thank You for understanding,<br>
                            ' . $senderName . ' <br><br>
                            <small><i><strong>This mail is auto generated by Luniva.</strong></i></small>
                            </td>
                            <td width = "36"></td>
                            </tr>
                            <tr><td colspan = "3" height = "36"></td></tr>
                            </tbody>
                            </table>
                            </td>
                            </tr>
                            </tbody>
                            </table>
                            <table cellpadding = "0" cellspacing = "0" align = "center" border = "0">
                            <tbody>
                            <tr>
                            <td height = "10"></td>
                            </tr>
                            <tr>
                            <td style = "padding:0;border-collapse:collapse">
                            <table cellpadding = "0" cellspacing = "0" align = "center" border = "0">
                            <tbody>
                            <tr style = "color:#a8b9c6;font-size:11px;">
                            <td width = "auto" align = "right"> &copy; ' . date("Y") . ' Luniva Clinic</td>
                            </tr>
                            </tbody>
                            </table>
                            </td>
                            </tr>
                            </tbody>
                            </table>
                            </td>
                            </tr>
                            </tbody>
                            </table>';
            }
            $this->email->to($approverEmail);
        }
        $this->email->subject($subject);
        $this->email->message($message);

        if ($attachment != null || $attachment != '') {
            $this->email->attach($ser . $attachment);
        }

        if ($this->email->send()) {
            echo json_encode(['sent' => 'Email Sent']);
        } else {
            echo $this->email->print_debugger();
        }
    }

    public function ajaxGetEmailDetails()
    {
        $empid = $this->input->post('empid') != null ? $this->input->post('empid') : $this->session->userdata('loggedInEmpId');
        $list = $this->GetApproverSenderEmailForNotification($empid)->EmpLeaveGroup;
        $newLi = array();

        foreach ($list as $value) {
            $encData['urlPram'] = crmEncryptUrlParameter(
                'applEmail=' . $value->ApplicantEmail .
                    '&apprEmail=' . $value->ApproverEmail .
                    '&apprName=' . $value->ApproverName
            );
            array_push($newLi, $encData);
        }

        echo json_encode($newLi);
    }
}
