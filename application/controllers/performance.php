<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

class Performance extends Util
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

    public function create_lookup()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Create Lookup';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'performance/create_lookup';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
        );

        $this->load->view('base', $data);
    }

    public function createLookup()
    {
        $today = new DateTime();
        $ent_date = $today->format('c');

        $data = array(
            "RId" => $this->input->post('rid') ?? 0,
            "TitleMetrics" => $this->input->post('title'),
            "MetricsDescription" => $this->input->post('met_desc'),
            "MaxPoint" => $this->input->post('max_point'),
            "PassPoint" => $this->input->post('pass_point'),
            "UserId" => $this->input->post('userid') ?? $this->session->userdata('loggedInUserId'),
            "EntryDate" => $ent_date ?? $today->format('c'),
            "IsActive" => $this->input->post('is_active') != null ? true : false,
        );

        $reid = $this->InsertUpdateReviewMetricLookup($data);
        if ($reid > 0) {
            $this->session->set_flashdata('success', 'Metric Lookup added');
        } else {
            $this->session->set_flashdata('error', 'Metric Lookup not added. Please try again');
        }
        redirect('performance/create_lookup', 'refresh');
    }

    public function create_performance()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Create Performance';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'performance/create_performance';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/performance/create_performance.js'
        );

        $comDet = $this->GetCompanyDetails()->CompanyName;
        $da = array(
            "Id" => $comDet[0]->CId,
            "Name" => ''
        );
        $department = $this->GetDepartmentByCompanyId($da)->DepartmentLst;
        $data['depart'] = $department;

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('jobId', 'Job Id', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['emp_list'] = array();
            $data['rev_ti'] = array();
        } else {
            $list2 = $this->GetDepartmentWiseEmployeeForDutyRoaster($this->input->post('jobId'))->DepartmentWiseEmployeeLst;
            $data['emp_list'] = $list2;
            $data['rev_ti'] = $this->GetListOfReviewTitle('')->ReviewDetails;
        }

        $this->load->view('base', $data);
    }

    public function giveReview()
    {
        $today = new DateTime();
        $ent_date = $today->format('c');
        $givePoint = $this->input->post('give_point');
        if ($givePoint[0] != null && $this->input->post('fromDate')[0] != null && $this->input->post('toDate')[0] != null && $this->input->post('empId')[0] != null) {
            $rdid = 0;
            foreach ($givePoint as $key => $value) {
                $reviewId = crmDecryptWithParameter($this->input->post('revTi')[$key])[0]['rid'];
                $empId = crmDecryptWithParameter($this->input->post('empId')[0])[0]['eid'];
                $data = array(
                    "RDId" => $this->input->post('rdid') ?? 0,
                    "ReviewId" => (int)$reviewId,
                    "ReviewPoint" => $value,
                    "ReviewGivenBy" => $this->input->post('empid') ?? $this->session->userdata('loggedInEmpId'),
                    "ReviewDateFrom" => $this->input->post('fromDate'),
                    "ReviewDateTo" => $this->input->post('toDate'),
                    "EmployeeId" => (int)$empId,
                    "EntryDate" => $ent_date ?? $today->format('c'),
                );
                $rdid = $this->InsertUpdatePerformanceReviewOfEmployee($data);
            };
            echo json_encode(array('no_id' => 0, 'retI' => $rdid));
        } else {
            echo json_encode(array('no_id' => 'fields not satisfied'));
        }
    }

    public function viewPerformance()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View Performance';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'performance/view_performance';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatable/js/jquery.dataTables.min.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/js/performance/view_performance.js'
        );

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('jobId', 'Job Id', 'required');
        $this->form_validation->set_rules('from', 'From', 'required');
        $this->form_validation->set_rules('to', 'To', 'required');

        $data['retData'] = 0;
        $data['perRev'] = array();

        $data['rev_ti'] = $this->GetListOfReviewTitle('')->ReviewDetails;

        if ($this->form_validation->run() == FALSE) {
        } else {
            $average = 0;
            $allData = 0;

            $list = $this->GetPerformanceReviewByEmployeeIdandDate(
                '',
                $this->input->post('jobId'),
                $this->input->post('from'),
                $this->input->post('to')
            )->ReviewDetails;

            foreach ($list as $key => $value) {
                $average++;
            }
            if ($allData != 0 && $average != 0) {
                $averageMedian = $allData / $average;
                $data['retData'] = number_format((float)$averageMedian, 2, '.', '');
            }
            $data['perRev'] = $list;
        }
        $this->load->view('base', $data);
    }

    public function viewPerformanceGraph()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Performance Graph';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'performance/viewpergraph';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            // 'assets/datatable/css/jquery.dataTables.css',
            // 'assets/datatable-responsive/css/responsive.dataTables.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            // 'assets/datatable/js/jquery.dataTables.js',
            // 'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/chart.js/dist/Chart.min.js',
            'assets/js/performance/viewpergraph.js'
        );

        $this->load->view('base', $data);
    }

    public function ajaxReview()
    {
        $list = $this->GetPerformanceReviewByEmployeeIdandDate(
            '',
            $this->input->post('jobId'), //customerId
            $this->input->post('from'),
            $this->input->post('to')
        )->ReviewDetails;

        $listArray = array(
            'Communication' => array(),
            'Behaviour' => array(),
            'Problem Solving' => array(),
            'Attendance' => array(),
            'Soft Skills' => array(),
            'Coding' => array(),
        );

        // var_dump($list);

        $xDet = array();
        foreach ($list as $key => $value) {
            if (!isset($xDet[$value->Reviewer])) {
                $xDet[$value->Reviewer] = array();
            }

            $ps = 'Problem Solving';
            $ss = 'Soft Skills';
            array_push(
                $xDet[$value->Reviewer],
                array(
                    $value->Communication,
                    $value->Behaviour,
                    $value->$ps,
                    $value->Attendance,
                    $value->$ss,
                    $value->Coding
                )
            );
            // array_push($listArray['Communication'], $value->Communication);
            // array_push($listArray['Behaviour'], $value->Behaviour);
            // $ps = 'Problem Solving';
            // array_push($listArray[$ps], $value->$ps);
            // array_push($listArray['Attendance'], $value->Attendance);
            // $ss = 'Soft Skills';
            // array_push($listArray[$ss], $value->$ss);
            // array_push($listArray['Coding'], $value->Coding);
        }
        // var_dump($listArray);
        echo json_encode(array($listArray, $xDet));
    }
}
