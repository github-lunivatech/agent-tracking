<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

class Complain extends Util
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isUserLoggedIn')) {
            $this->notLoginRedirect();
        }
        if (!in_array("show complain", $this->getAllowedRights())) {
            redirect('crmerror/page_not_found', 'refresh');
            return;
        }
    }

    public function add_complain()
    {
        if (!in_array("add complain", $this->getAllowedRights())) {
            redirect('crmerror/page_not_found', 'refresh');
            return;
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Complain';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'complain/add_complain';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/js/allSubDis.js',
            'assets/js/complain/addComplain.js',
        );

        $urlPram = [];

        if (isset($_GET['q'])) {
            $urlPram = crmDecryptUrlParameter()[0];
        }

        $cusDet = $this->GetCustomerDetails('', 0)->CustomerDetails;
        $proDet = $this->GetProductDetails('', 0)->productDetails;
        $cType = $this->GetChangeReqeustType('')->GetChangeReqeustType;
        $priType = $this->GetListOfComplainPrority('')->GetListOfComplainPrority;
        $complainType = $this->GetComplainType('')->GetComplainType;

        $da = array(
            "Id" => 0,
            "Name" => ""
        );
        $empDet = $this->GetListOfEmployeeDetailsById($da)->EmpDetail;
        $data['cpDet'] = array(
            'cus' => $cusDet,
            'pro' => $proDet,
            'emp' => $empDet,
            'allDa' => $urlPram,
            'ctyp' => $cType,
            'pTy' => $priType,
            'comType' => $complainType
        );

        $this->load->view('base', $data);
    }

    public function insertComplaint()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('comp_code', 'Code', 'required');
        $this->form_validation->set_rules('prod_id', 'Product', 'required');
        $this->form_validation->set_rules('cust_id', 'Customer', 'required');
        $this->form_validation->set_rules('comp_type', 'Type', 'required');
        $this->form_validation->set_rules('comp_stat', 'Status', 'required');
        $this->form_validation->set_rules('comp_by', 'By', 'required');

        if ($this->form_validation->run() != FALSE) {
            $comp_date = new DateTime($this->input->post('comp_date'));
            $cccid = 0;
            $hider = $this->input->post('hider');
            if ($hider != null) {
                $cccid = (int)crmDecryptWithParameter($hider)[0]['cid'];
            }
            $cusIdd = $this->input->post('cust_id');
            $data = array(
                "CId" => $cccid,
                "ComplainCode" => $this->input->post('comp_code'),
                "CustomerId" => (int)$cusIdd,
                "ProductId" => (int)$this->input->post('prod_id'),
                "ComplainType" => (int)$this->input->post('comp_type'),
                "ComplainDetails" => $this->input->post('comp_det'),
                "ComplainBy" => $this->input->post('comp_by'),
                "ComplainDate" => $comp_date->format('c'),
                "ComplainStatus" => (int)$this->input->post('comp_stat'),
                "UserId" => $this->input->post('userid') ?? $this->session->userdata('loggedInUserId'),
                "PriorityType" => (int) $this->input->post('proi_type')
            );
            $coid = $this->InsertUpdateCustomerComplaintDetails($data);
            if ($coid > 0) {
                echo json_encode(array('coid' => $coid, 'msg' => 'Success', 'coo' => crmEncryptUrlParameter('CId=' . $coid . '&CustomerId=' . $cusIdd.'&fromDate='.$comp_date->format('c'))));
                // $this->session->set_flashdata('success', 'Success');
            } else {
                echo json_encode(array('coid' => $coid, 'msg' => 'Error'));
                // $this->session->set_flashdata('error', 'Error');
            }
        } else {
            echo json_encode(array('coid' => 0, 'msg' => 'Fields Not Satisfied'));
            // $this->session->set_flashdata('error', 'Fields Not Satisfied');
        }

        // redirect('complain/add_complain', 'refresh');
    }

    public function viewComplains()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View Complain';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'complain/viewComplains';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatable/js/jquery.dataTables.min.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/js/complain/viewComplains.js',
        );

        $cusDet = $this->GetCustomerDetails('', 0)->CustomerDetails;
        $data['cus'] = $cusDet;

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('custId', 'Customer Id', 'required');

        if ($this->form_validation->run() != FALSE) {
            $list = $this->GetCustomerWiseComplainDetails('', $this->input->post('custId'))->ComplaintList;
            $data['content'] = $list;
        }

        $this->load->view('base', $data);
    }

    public function add_complain_track()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Add Complain Track';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'complain/add_complain_track';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/allSubDis.js',
        );

        $urlPram = [];
        $isEdit = false;
        if (isset($_GET['q'])) {
            $urlPram = crmDecryptUrlParameter()[0];
        }

        $cType = $this->hardCodedReqType()['chgStat'];

        $da = array(
            "Id" => 0,
            "Name" => ""
        );
        $empDet = $this->GetListOfEmployeeDetailsById($da)->EmpDetail;

        $data['cpDet'] = array(
            'emp' => $empDet,
            'allDa' => $urlPram,
            'ctyp' => $cType,
            'isEdit' => $isEdit
        );

        $this->load->view('base', $data);
    }

    public function viewTracks()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View Tracks';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'complain/viewTracks';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable/buttons/css/buttons.dataTables.min.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
            'assets/select2/select2.min.css'

        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatable/js/jquery.dataTables.min.js',
            'assets/datatable/buttons/js/dataTables.buttons.min.js',
            'assets/datatable/buttons/js/buttons.print.min.js',
            'assets/select2/select2.full.min.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/js/complain/viewTracks.js',
        );

        $cusDet = $this->GetCustomerDetails('', 0)->CustomerDetails;
        $data['cus'] = $cusDet;
        $cType = $this->GetChangeReqeustType('')->GetChangeReqeustType;
        $data['ctyp'] = $cType;
        $reqType = $this->hardCodedReqType();
        $data['reqType'] = $reqType['chgStat'];
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('custId', 'Customer Id', 'required');

        if ($this->form_validation->run() != FALSE) {
            $fil = $this->input->post('custId');
            $dataa = array(
                'id' => $this->input->post('ider') != null ? $this->input->post('ider') : 0,
                'filter' => $fil,
                'from' => $this->input->post('fromDate'),
                'to' => $this->input->post('toDate')
            );
            $list = $this->GetComplainStatusByFilter($dataa);
            if ($list != null) {
                $list = $list->GetComplainStatusByFilter;
            }
            $data['content'] = $list;
        }

        $this->load->view('base', $data);
    }

    public function insertComplainTrackRecord()
    {
        $urlPar = '';
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('complain_id', 'Complain', 'required');
        $this->form_validation->set_rules('emp_id', 'Employee', 'required');
        $this->form_validation->set_rules('comp_stat', 'Status', 'required');

        if ($this->form_validation->run() != FALSE) {
            $today = new DateTime();
            $entId = $this->input->post('userid') ?? $this->session->userdata('loggedInUserId');
            $entName = $this->session->userdata('loggedInUsername');
            $comStat = $this->input->post('comp_stat');
            $comIder = $this->input->post('complain_id');
            $data = array(
                "CTId" => $this->input->post('ctid') ?? 0,
                "ComplainId" => $comIder,
                "EmployeeId" => $this->input->post('emp_id'),
                "ComplainStatus" => $comStat,
                "EmployeeRemarks" => $entName . ': ' . $this->input->post('emp_rem'),
                "EntryDate" => $today->format('c'),
                "EnterBy" => $entId,
            );
            $ctid = $this->InsertUpdateComplainTrackRecord($data);
            if ($ctid > 0) {
                $this->session->set_flashdata('success', 'Success');
            } else {
                $this->session->set_flashdata('error', 'Error');
                $urlPar = '?q='.crmEncryptUrlParameter('CId='.$comIder.'&ComplainStatus='.$comStat);            
                redirect('complain/add_complain_track'.$urlPar, 'refresh');
                return;
            }
        } else {
            $this->session->set_flashdata('error', 'Fields not satisfied');
        }
        // complainProfile
        redirect('complain/viewTracks'.$urlPar, 'refresh');
    }

    public function ajaxGetEmployee()
    {
        $da = array(
            "Id" => 0,
            "Name" => ""
        );
        $empDet = $this->GetListOfEmployeeDetailsById($da)->EmpDetail;
        echo json_encode($empDet);
    }

    public function ajaxGetCustomerDetails()
    {
        $list = $this->GetCustomerDetails('', 0)->CustomerDetails;
        echo json_encode($list);
    }

    public function ajaxChangeStat()
    {
        $list = $this->GetChangeStaus('')->GetChangeStaus;
        echo json_encode($list);
    }

    public function ajaxProducts()
    {
        $list = $this->GetProductDetails('', 0)->productDetails;
        echo json_encode($list);
    }

    public function ajaxGetComType()
    {
        $complainType = $this->GetComplainType('')->GetComplainType;
        echo json_encode($complainType);
    }

    public function ajaxPriority() {
        $priType = $this->GetListOfComplainPrority('')->GetListOfComplainPrority;
        echo json_encode($priType);
    }

    public function complainProfile()
    {
        $allData = [];
        $urlPar = '';
        $listData = [];
        if (isset($_GET['q'])) {
            $urlPram = crmDecryptUrlParameter()[0];
            $allDatas = $this->GetCustomerWiseComplainDetails('', $urlPram['CustomerId'])->ComplaintList;
            foreach ($allDatas as $key => $value) {
                if ($urlPram['CId'] == $value->CId) {
                    $allData = $value;
                    $urlPar = crmEncryptUrlParameter(
                        'CId=' . $value->CId .
                            '&ComplainCode=' . $value->ComplainCode .
                            '&CustomerId=' . $value->CustomerId .
                            '&ProductId=' . $value->ProductId .
                            '&ComplainType=' . $value->ComplainType .
                            '&ComplainDetails=' . $value->ComplainDetails .
                            '&ComplainBy=' . $value->ComplainBy .
                            '&ComplainDate=' . $value->ComplainDate .
                            '&ComplainStatus=' . $value->ComplainStatus .
                            '&UserId=' . $value->UserId
                    );
                }
            }
            $expDate = explode('T', $urlPram['fromDate'])[0];
            $dataa = array(
                'id' => $urlPram['CId'],
                'filter' => 'complainid',
                'from' => $expDate,
                'to' => $expDate
            );
            $listData = $this->GetComplainStatusByFilter($dataa)->GetComplainStatusByFilter;
        }

        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Complain Profile';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'complain/complainProfile';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/js/complain/complainProfile.js'
        );

        $data['content'] = array(
            'aData' => $allData,
            'urlPar' => $urlPar,
            'filterTable' => $listData
        );

        $reqType = $this->hardCodedReqType();
        $data['reqType'] = $reqType['chgStat'];

        $this->load->view('base', $data);
    }

    public function ajaxUpdateComplainStatus()
    {
        $cid = crmDecryptWithParameter($this->input->post('comp_stat_id'))[0];
        $prevCom = '';
        if ($cid['prevCom'] != '')
            $prevCom = $cid['prevCom'] . '<br/> ';
        $today = new DateTime();
        $userId = $this->input->post('userid') ?? $this->session->userdata('loggedInUserId');
        $entName = $this->session->userdata('loggedInUsername');
        $data = array(
            'complainId' => $cid['cid'],
            'status' => $this->input->post('comp_stat_comment'),
            'userid' => $userId,
            'entrydate' => explode('T', $today->format('c'))[0],
            'remarks' => $prevCom . ' ' . $entName . ': ' . $this->input->post('remarks_comment'),
        );
        $coid = $this->UpdateComplainStatusByComplainId($data);
        if ($coid == true) {
            echo json_encode(array('coid' => $coid, 'msg' => 'Success'));
        } else {
            echo json_encode(array('coid' => 0, 'msg' => 'Error'));
        }
    }
}
