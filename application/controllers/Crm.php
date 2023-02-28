<?php

use React\Stream\DuplexStreamInterface;

defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

class Crm extends Util
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

    public function add_det()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer Details';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'crm/add_det';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/crm/add_det.js',
            'assets/js/allSubDis.js'
        );

        $cStat = $this->GetCustomerStatus('')->GetCustomerStatus; //hardCodedUserStat()['cStat'];
        $data['cStats'] = $cStat;

        $cState = $this->GetStates('')->GetStates;
        $data['cState'] = $cState;

        $cType = $this->GetCustomerType('')->GetCustomerType;
        $data['cTypes'] = $cType;

        if (isset($_GET['q'])) {
            $urlPram = crmDecryptUrlParameter()[0];
            $GetCustomerDetails = $this->GetCustomerDetails('', $urlPram['cid'])->CustomerDetails;
            $data['content'] = $GetCustomerDetails;
        }

        $this->load->view('base', $data);
    }

    public function ajaxGetDistrict()
    {
        $dList = $this->GetDistrictsByStateId('', $this->input->post('dist'))->GetDistrictsByStateId;
        echo json_encode($dList);
    }

    public function ajaxGetMun()
    {
        $mList = $this->GetMunicipalitiesByDistrictId('', $this->input->post('muni'))->GetMunicipalitiesByDistrictId;
        echo json_encode($mList);
    }

    public function insertCustomerDetails()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('cust_name', 'Name', 'required');
        $this->form_validation->set_rules('cust_stat', 'Status', 'required');

        $today = new DateTime();

        $ccid = 0;
        $ent_date = $today->format('c');

        $hider = $this->input->post('hider');
        if ($hider != null) {
            $hider = crmDecryptWithParameter($hider);
            $ccid = $hider[0]['cid'];
            $ent_date = $hider[0]['ent_date'];
        }

        $url = $ccid != 0 ? 'crm/add_det?q=' . crmEncryptUrlParameter('cid=' . $ccid) : 'crm/add_det';

        if ($this->form_validation->run() != FALSE) {

            $data = array(
                "CId" => $ccid,
                "CustomerName" => $this->input->post('cust_name'),
                "CustomerStateId" => $this->input->post('cust_state'),
                "CustomerDistrictId" => $this->input->post('cust_district'),
                "CustomerMunicipilityId" => $this->input->post('cust_municipality'),
                "CustomerWardNo" => $this->input->post('cust_ward'),
                "CustomerAddress" => $this->input->post('cust_address'),
                "CustomerContactNumber" => $this->input->post('cust_contact'),
                "CustomerEmailId" => $this->input->post('cust_email'),
                "CustomerWebSite" => $this->input->post('cust_website'),
                "CustomerTypeId" => $this->input->post('cust_type'),
                "UserId" => $this->input->post('userid') ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                "EntryDate" => $ent_date,
                "IsActive" => $this->input->post('isactive') != null ? true : false,
                "CustomerStatus" => $this->input->post('cust_stat'),
                "Remarks" => $this->input->post('remarks'),
            );

            $cid = $this->InsertUpdateCustomerDetails($data);
            if ($cid > 0) {
                $this->session->set_flashdata('success', 'Customer Details Saved');
                $url = $ccid != 0 ? 'crm/viewProfile?q=' . crmEncryptUrlParameter('cid=' . $ccid) : 'crm/add_det';
            } else {
                $this->session->set_flashdata('error', 'Customer Details Not Saved');
            }
        } else {
            $this->session->set_flashdata('error', 'Fields not satisfied');
        }
        redirect($url, 'refresh');
    }

    public function view_det()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View Customer Details';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'crm/view_det';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/js/crm/crmdatatable.js'
        );

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('customerId', 'Customer Id', 'required');

        $data['CustId'] = $this->GetCustomerDetails('', 0)->CustomerDetails;

        if ($this->form_validation->run() != FALSE) {
            $custId = $this->input->post('customerId');
            $GetCustomerDetails = $this->GetCustomerDetails('', $custId)->CustomerDetails;

            $data['content'] = $GetCustomerDetails;
        }

        $this->load->view('base', $data);
    }

    public function viewProfile()
    {
        $urlPram = crmDecryptUrlParameter()[0];
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View Customer Profile';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'crm/view_cust_pro';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/crm/viewProfile.js'
        );

        $GetCustomerDetails = $this->GetCustomerDetails('', $urlPram['cid'])->CustomerDetails;
        $GetSocialMediaLinkByCustomerId = $this->GetSocialMediaLinkByCustomerId('', $urlPram['cid'])->customerSocialMediaDetails;
        $GetCustomerContactPersonDetails = $this->GetCustomerContactPersonDetails('', $urlPram['cid'])->CustomerContactPersonDetails;
        $GetCustomerAssignedToEmployee = $this->GetCustomerAssignedToEmployee('', $urlPram['cid'])->CustomerAssignedToEmployee;
        $GetCustomerChangeRequestDetails = $this->GetCustomerChangeRequestDetails('', $urlPram['cid'])->CustomerChangeRequestDetails;
        $GetCustomerProductLeadDetails = $this->GetCustomerProductLeadDetails('', $urlPram['cid'])->CustomerWiseProductLeadt;
        $getPayDetails = $this->retCustDet($urlPram['cid']);

        $reqType = $this->hardCodedReqType();

        $datae = array(
            'Id' => 0,
            'Name' => ''
        );
        $emDet = $this->GetListOfEmployeeDetailsById($datae)->EmpDetail;

        $uStat = $this->GetAssignedEmployeeStatus('')->GetAssignedEmployeeStatus; //hardCodedUserStat()['uStat'];

        $projDet = $this->GetProductDetails('', 0)->productDetails;

        $cStat = $this->GetCustomerStatus('')->GetCustomerStatus;

        $mList = $this->GetSocialMediaList('')->GetSocialMediaListB;

        $data['content'] = array(
            'customerDet' => $GetCustomerDetails,
            'customerSocial' => $GetSocialMediaLinkByCustomerId,
            'customerContact' => $GetCustomerContactPersonDetails,
            'customerAssigned' => $GetCustomerAssignedToEmployee,
            'customerChange' => $GetCustomerChangeRequestDetails,
            'customerLead' => $GetCustomerProductLeadDetails,
            'reqType' => $reqType,
            'emDet' => $emDet,
            'uStat' => $uStat,
            'projDet' => $projDet,
            'cStat' => $cStat,
            'mList' => $mList,
            'csfToken' => $this->getToken(),
            'payDet' => $getPayDetails
        );

        $this->load->view('base', $data);
    }

    public function addSocialMedia()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('media_id', 'media Type', 'required');
        $this->form_validation->set_rules('media_link', 'Media Link', 'required');

        $custRet = $this->input->post('cust_id');

        $custId = crmDecryptWithParameter($custRet)[0]['cid'];

        $url = 'crm/viewProfile?q=' . crmEncryptUrlParameter('cid=' . $custId);

        $postedToken = $this->input->post('csftoken');
        if (!empty($postedToken)) {
            if ($this->isTokenValid($postedToken)) {

                if ($this->form_validation->run() != FALSE) {

                    $today = new DateTime();

                    $ent_date = $today->format('c');

                    $hider = $this->input->post('cust_hider');
                    $cssid = 0;
                    if ($hider != null) {
                        $hider = crmDecryptWithParameter($hider)[0];
                        $cssid = $hider['CSId'];
                        $ent_date = $hider['ent_date'];
                    }

                    $data = array(
                        "CSId" => $cssid,
                        "SocialMediaTypeId" => $this->input->post('media_id'),
                        "SocialMediaLink" => $this->input->post('media_link'),
                        "EntryDate" => $ent_date,
                        "UserId" => $this->input->post('userid') ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                        "CustomerId" => $custId,
                    );
                    $csid = $this->InsertUpdateCustomerSocailMedia($data);
                    if ($csid > 0) {
                        $this->session->set_flashdata('success', 'Social Media Details Saved');
                    } else {
                        $this->session->set_flashdata('error', 'Social Media Details Not Saved');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Invalid Fields');
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid Details');
            }
        } else {
            $this->session->set_flashdata('error', 'Empty Details');
        }

        redirect($url, 'refresh');
    }

    public function addContactPerson()
    {

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('cont_per_name', 'Name', 'required');
        $this->form_validation->set_rules('cont_per_num', 'Number', 'required');
        $this->form_validation->set_rules('cont_per_email', 'Email', 'required');
        $this->form_validation->set_rules('cont_per_des', 'Description', 'required');

        $custRet = $this->input->post('concust_id');

        $custId = crmDecryptWithParameter($custRet)[0]['cid'];

        $url = 'crm/viewProfile?q=' . crmEncryptUrlParameter('cid=' . $custId);

        if ($this->form_validation->run() != FALSE) {

            $today = new DateTime();

            $ent_date = $today->format('c');

            $custHider = $this->input->post('concust_hider');
            $cppid = 0;
            if ($custHider != null) {
                $alDet = crmDecryptWithParameter($custHider)[0];
                $cppid = $alDet['CPId'];
                $ent_date = $alDet['ent_date'];
            }

            $data = array(
                "CPId" => (int)$cppid,
                "CustomerId" => (int)$custId,
                "ContactPersonName" => $this->input->post('cont_per_name'),
                "ContactPersonNumber" => $this->input->post('cont_per_num'),
                "ContactpersonEmail" => $this->input->post('cont_per_email'),
                "ContactPersonDesignation" => $this->input->post('cont_per_des'),
                "EntryDate" => $ent_date,
                "UserId" => $this->input->post('userid') ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                "IsActive" => $this->input->post('isactive') != null ? true : false,
            );
            $csid = $this->InsertUpdateCustomerContactPerson($data);
            if ($csid > 0) {
                $this->session->set_flashdata('success', 'Contact Person Details Saved');
            } else {
                $this->session->set_flashdata('error', 'Contact Person Details Not Saved');
            }
        } else {
            $this->session->set_flashdata('error', 'Contact Person Details Not Saved');
        }
        redirect($url, 'refresh');
    }

    public function addCustomerAssign()
    {

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('cust_userid', 'User', 'required');
        $this->form_validation->set_rules('cust_user_stat', 'Status', 'required');

        $custRet = $this->input->post('assigncust_id');
        $custId = crmDecryptWithParameter($custRet)[0]['cid'];

        $url = 'crm/viewProfile?q=' . crmEncryptUrlParameter('cid=' . $custId);

        if ($this->form_validation->run() != FALSE) {

            $today = new DateTime();

            $ent_date = $today->format('c');

            $custHider = $this->input->post('csf');
            $cppid = 0;
            if ($custHider != null) {
                $alDet = crmDecryptWithParameter($custHider)[0];
                $cppid = $alDet['CAId'];
                $ent_date = $alDet['ent_date'];
            }

            $data = array(
                "CAId" => (int) $cppid,
                "CustomerId" => $custId,
                "UserId" => $this->input->post('cust_userid'),
                "UsertStatus" => $this->input->post('cust_user_stat'),
                "Remarks" => $this->input->post('cust_remarks'),
                "EnterBy" => $this->input->post('userid') ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                "IsActive" => $this->input->post('isactive') != null ? true : false,
                "EntryDate" => $ent_date,
            );
            $csid = $this->InsertUpdateEmployeeAssignedToCustomer($data);
            if ($csid > 0) {
                $this->session->set_flashdata('success', 'Employee Assigned Customer Details Saved');
            } else {
                $this->session->set_flashdata('error', 'Employee Assigned Customer Details Not Saved');
            }
        } else {
            $this->session->set_flashdata('error', 'Employee Assigned Customer Details Not Saved');
        }
        redirect($url, 'refresh');
    }

    public function addChangeReq()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Add Change Request';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'crm/addChangeReq';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/crm/addChangeReq.js'
        );

        $datae = array(
            'Id' => 0,
            'Name' => ''
        );
        $emDet = $this->GetListOfEmployeeDetailsById($datae)->EmpDetail;

        // $reqType = $this->hardCodedReqType();
        $reqType = $this->GetChangeReqeustType('')->GetChangeReqeustType;

        $chgStat = $this->GetChangeStaus('')->GetChangeStaus;

        $projectDet = $this->GetProductDetails('', 0)->productDetails;

        $isData = array();
        if (isset($_GET['e'])) {
            $qer = crmDecryptWithParameter($_GET['q'])[0];
            $GetCustomerChangeRequestDetails = $this->GetCustomerChangeRequestDetails('', $qer['cid'])->CustomerChangeRequestDetails;
            $isData = $GetCustomerChangeRequestDetails[$qer['key']];
        }

        $data['content'] = array(
            // 'cid' => $cid
            'emDet' => $emDet,
            'reqType' => $reqType,
            'chgStat' => $chgStat,
            'isData' => $isData,
            'pDet' => $projectDet
        );

        $this->load->view('base', $data);
    }

    public function addCustomerChange()
    {
        $today = new DateTime();

        $ent_date = $today->format('c');

        $custIder = $this->input->post('customer_id');

        $custId = crmDecryptWithParameter($custIder)[0]['cid'];

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('change_number', 'Change Number', 'required');
        $this->form_validation->set_rules('project_id', 'project id', 'required');
        $this->form_validation->set_rules('customer_id', 'customer id', 'required');

        $cid = 0;

        $hider = $this->input->post('hider');
        $ccid = 0;
        if ($hider != null) {
            $ced = crmDecryptWithParameter($hider)[0];
            $ccid = $ced['ccid'];
            $ent_date = $ced['ent_date'];
        }

        $url = 'crm/addChangeReq?q=' . crmEncryptUrlParameter('cid=' . $custId);

        //here valid and calculate
        $aTime = $this->input->post('analysis_time');
        $dTime = $this->input->post('design_time');
        $devTime = $this->input->post('develop_time');
        $tTime = $this->input->post('test_time');
        $ttTime = 0;
        if (is_numeric($aTime) && is_numeric($dTime) && is_numeric($devTime) && is_numeric($tTime)) {
            $ttTime = $aTime + $dTime + $devTime + $tTime;
        } else {
            $this->session->set_flashdata('error', 'Time Not Entered. Please try again');
            redirect($url, 'refresh');
            return;
        }
        //here valid and calculate

        if ($this->form_validation->run() != FALSE) {
            $data = array(
                "CId" => $ccid,
                "ChangeNumber" => $this->input->post('change_number'),
                "ProjectId" => (int)$this->input->post('project_id'),
                "RequestedBy" => $this->input->post('requested_by'),
                "PresentedTo" => (int)$this->input->post('presented_to'),
                "RequestDate" => $this->input->post('request_date'),
                "RequestType" => (int)$this->input->post('request_type'),
                "CustomerId" => (int)$custId,
                "ChangeName" => $this->input->post('change_name'),
                "ChangeDescription" => $this->input->post('change_desc'),
                "ResonForChange" => $this->input->post('reason_change'),
                "EffectOnOrgnization" => $this->input->post('effect_on_org'),
                "EffectOnSchedule" => $this->input->post('effect_on_sch'),
                "AnalysisTime" => $aTime,
                "AnalysisCost" => (float)$this->input->post('analysis_cost'),
                "DesignTime" => $dTime,
                "DesignCost" => (float)$this->input->post('design_cost'),
                "DevelopmentTime" => $devTime,
                "DevelopmentCost" => (float)$this->input->post('develop_cost'),
                "TestingTime" => $tTime,
                "TestingCost" => (float)$this->input->post('test_cost'),
                "TotalTentativeTime" => $ttTime,
                "TotalTentativeCost" => (float)$this->input->post('total_tent_cost'),
                "TentativeDateOfSubmission" => $this->input->post('tent_date_sub'),
                "ProjectManger" => (int)$this->input->post('project_man'),
                "EntryDate" => $ent_date,
                "Note" => $this->input->post('note'),
                "ChangeStatus" => (int)$this->input->post('change_stat'),
                "CompletedDate" => $this->input->post('complete_date'),
                "UserId" => $this->input->post('userid') ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
            );
            $cid = $this->InsertUpdateCustomerChangeRequest($data);
        }
        if ($cid > 0) {
            $this->session->set_flashdata('success', 'Change Request Saved');
            $url = 'crm/viewProfile?q=' . crmEncryptUrlParameter('cid=' . $custId);
        } else {
            $this->session->set_flashdata('error', 'Change Request Not Saved. Please try again');
        }
        redirect($url, 'refresh');
    }

    public function printChange()
    {
        $datae = array(
            'Id' => 0,
            'Name' => ''
        );
        $emDet = $this->GetListOfEmployeeDetailsById($datae)->EmpDetail;

        $rMan = '';
        $rFou = false;
        $ppMan = '';
        $ppFou = false;
        $pMan = '';
        $pFou = false;
        $uMan = '';
        $uFou = false;
        $cid = crmDecryptUrlParameter()[0];
        $GetCustomerChangeRequestDetails = $this->GetCustomerChangeRequestDetails('', $cid['cid'])->CustomerChangeRequestDetails[$cid['key']];
        foreach ($emDet as $key => $value) {

            if ($rFou == false && $value->EId == $GetCustomerChangeRequestDetails->RequestedBy) {
                $rMan = $value->EmployeeName;
                $rFou = true;
            }

            if ($ppFou == false && $value->EId == $GetCustomerChangeRequestDetails->PresentedTo) {
                $ppMan = $value->EmployeeName;
                $ppFou = true;
            }

            if ($pFou == false && $value->EId == $GetCustomerChangeRequestDetails->ProjectManger) {
                $pMan = $value->EmployeeName;
                $pFou = true;
            }

            if ($uFou == false && $value->LoginId == $GetCustomerChangeRequestDetails->UserId) {
                $uMan = $value->EmployeeName;
                $uFou = true;
            }
        }
        $GetCompanyDetails = $this->GetCompanyDetails('')->CompanyName;
        $this->load->view('crm/print_change', array(
            'customerChange' => $GetCustomerChangeRequestDetails,
            'cDet' => $GetCompanyDetails[0],
            'rMan' => $rMan,
            'ppMan' => $ppMan,
            'pMan' => $pMan,
            'uMan' => $uMan,
        ));
    }

    public function addProductLead()
    {
        // $today = new DateTime();

        // $ent_date = $today->format('c');

        $custIder = $this->input->post('prodd_id');

        $custId = crmDecryptWithParameter($custIder)[0]['cid'];

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('pro_project_id', 'project id', 'required');
        $this->form_validation->set_rules('pro_lead_stat', 'Stat', 'required');
        $this->form_validation->set_rules('pro_amount', 'Amount', 'required');
        $this->form_validation->set_rules('pro_proba', 'Probabilty', 'required');

        $url = 'crm/viewProfile?q=' . crmEncryptUrlParameter('cid=' . $custId);

        if ($this->form_validation->run() != FALSE) {

            $llid = 0;
            $aDat = $this->input->post('csff');
            if ($aDat != null) {
                $llid = crmDecryptWithParameter($aDat)[0]['LId'];
            }

            $data = array(
                "LId" => (int)$llid,
                "CustomerId" => (int)$custId,
                "ProjectId" => (int)$this->input->post('pro_project_id'),
                "LeadStatus" => (int)$this->input->post('pro_lead_stat'),
                "Amount" => (float)$this->input->post('pro_amount'),
                "Probability" => (int)$this->input->post('pro_proba'),
                "LeadClosedDate" => $this->input->post('pro_lead_close_date'),
                "Remarks" => $this->input->post('pro_remarks'),
                "AttachmentsLink" => $this->input->post('pro_attach_link') ?? '',
                "UserId" => $this->input->post('userid') ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
            );
            $lid = $this->InsertUpdateCustomerProductLead($data);
            if ($lid > 0) {
                $this->session->set_flashdata('success', 'Product Lead Details Saved');
            } else {
                $this->session->set_flashdata('error', 'Product Lead Details Not Saved');
            }
        } else {
            $this->session->set_flashdata('error', 'Fields not satisfied');
        }
        redirect($url, 'refresh');
    }

    public function addsalesgoal()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Sales Goal';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'crm/addsalesgoal';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/crm/addsalesgoal.js',
            'assets/js/allSubDis.js'
        );

        $gGoal = $this->GetGoalStatus('')->GetGoalStatus;
        $projectDet = $this->GetProductDetails('', 0)->productDetails;

        $data['gGoals'] = $gGoal;
        $data['projectDet'] = $projectDet;

        if (isset($_GET['q'])) {
            $selDet = crmDecryptUrlParameter()[0];
            $data['content'] = $selDet;
        }

        $this->load->view('base', $data);
    }

    public function salesGoal()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('date_from', 'Date From', 'required');
        $this->form_validation->set_rules('date_to', 'Date To', 'required');
        $this->form_validation->set_rules('project_id', 'Project', 'required');
        $this->form_validation->set_rules('target_goal', 'Target Goal', 'required');
        $this->form_validation->set_rules('goal_status', 'Goal Status', 'required');

        $hider = $this->input->post('hider');
        $ggid = 0;
        if ($hider != null) {
            $ggid = crmDecryptWithParameter($hider)[0]['GId'];
        }

        if ($this->form_validation->run() != FALSE) {
            $data = array(
                "GId" => $ggid,
                "DateFrom" => $this->input->post('date_from'),
                "DateTo" => $this->input->post('date_to'),
                "ProjectId" => $this->input->post('project_id'),
                "TargetGoal" => $this->input->post('target_goal'),
                "UserId" => $this->input->post('userid') ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                "GoalStatus" => $this->input->post('goal_status'),
                "IsActive" => $this->input->post('is_active') != null ? true : false,
                "Remarks" => $this->input->post('remarks'),
            );
            $gid = $this->InsertUpdateProjectWiseSalesGoal($data);
            if ($gid > 0) {
                $this->session->set_flashdata('success', 'Sales Goal Details Saved');
            } else {
                $this->session->set_flashdata('error', 'Sales Goal Details Not Saved');
            }
        } else {
            $this->session->set_flashdata('error', 'Fields not satisfied');
        }
        $url = 'crm/addsalesgoal';
        redirect($url, 'refresh');
    }

    public function viewsalesgoal()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Sales Goal';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'crm/viewsalesgoal';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/js/crm/crmdatatable.js'
        );

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('customerId', 'Project', 'required');

        $pDet = $this->GetProductDetails('', 0)->productDetails;
        $data['pDet'] = $pDet;

        if ($this->form_validation->run() != FALSE) {
            $salesDet = $this->GetProjectWiseSalesGoal('', $this->input->post('customerId'))->salesGoad;
            $data['content'] = $salesDet;
        }

        $this->load->view('base', $data);
    }

    public function viewprolead()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Product Lead';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'crm/viewproductlead';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/js/crm/crmdatatable.js'
        );

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('customerId', 'Project', 'required');

        $pDet = $this->GetProductDetails('', 0)->productDetails;
        $data['pDet'] = $pDet;

        if ($this->form_validation->run() != FALSE) {
            $salesDet = $this->GetProjectWiseCustomerLead('', $this->input->post('customerId'))->ProjectWiseCustomerLead;
            $data['content'] = $salesDet;
        }

        $this->load->view('base', $data);
    }

    public function viewsalesgraph()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Sales Graph';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'crm/viewsalesgraph';

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
            'assets/js/crm/viewsalesgraph.js'
        );

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('fromDate', 'From Date', 'required');
        $this->form_validation->set_rules('toDate', 'To Date', 'required');

        $pDet = $this->GetProductDetails('', 0)->productDetails;
        $data['pDet'] = $pDet;

        if ($this->form_validation->run() != FALSE) {
        }

        $this->load->view('base', $data);
    }

    public function sendEmailAttach()
    {
        $fileHere = $this->input->post('fileHere');
        $ema = $this->sendEmailWithAttachment('Change Request', 'Please check the attachment', $fileHere);
        var_dump($ema);
    }

    public function payDetails()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Complain';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'crm/addPayDet';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/allSubDis.js',
        );

        $data['isEdit'] = false;

        $proDet = $this->GetProductDetails('', 0)->productDetails;
        $data['cpDet'] = array(
            'pro' => $proDet,
        );

        $crmEnc = crmDecryptUrlParameter()[0];
        if (isset($crmEnc['proid'])) {
            $data['isEdit'] = true;
            $data['allData'] = $crmEnc;
        }
        // var_dump($data);exit;

        $this->load->view('base', $data);
    }

    public function insertPayDet()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('hider', 'Customer Id', 'required');
        $this->form_validation->set_rules('prod_id', 'Product Id', 'required');


        $url = 'crm/payDetails?q=' . $this->input->post('hider');

        if ($this->form_validation->run() != FALSE) {
            $ccid = crmDecryptWithParameter($this->input->post('hider'))[0];
            $data = array(
                "PId" => $ccid['pid'] != null ? (int)$ccid['pid'] : 0,
                "CustomerId" => (int)$ccid['cid'],
                "ProductId" => (int)$this->input->post('prod_id'),
                "PaidAmount" => (float)$this->input->post('paid_amt'),
                "PaidDate" => $this->input->post('paid_date'),
                "FiscalYearId" => (int)$this->input->post('fiscal_id'),
                "Remarks" => $this->input->post('remarks'),
                "IsPaid" => $this->input->post('ispaid') != null ? true : false,
            );
            $poid = $this->InsertUpdateCustomerPaymentDetails($data);
            if ($poid > 0) {
                $url = 'crm/viewProfile?q=' . $this->input->post('hider');
                $this->session->set_flashdata('success', 'Success');
            } else {
                $this->session->set_flashdata('error', 'Error');
            }
        } else {
            $this->session->set_flashdata('error', 'Fields not satisfied');
        }
        redirect($url, 'refresh');
    }

    public function retCustDet($custId)
    {
        $list = $this->GetCustomerWisePaymentDetails('', $custId)->customerPayment;
        return $list;
    }

    public function ploter()
    {
        // $gList = $this->GetGoalStatus('')->GetGoalStatus;
        $proId = $this->input->post('pro');
        $salesDet = $this->GetProjectWiseSalesGoal('', $proId)->salesGoad;
        $cLead = $this->GetProjectWiseCustomerLead('', $proId)->ProjectWiseCustomerLead;

        $conDate = array();

        foreach ($cLead as $value) {
            $lc = explode('T', $value->LeadClosedDate)[0];
            $conDate[$lc] = array(
                'Conv' => array(),
                'Ach' => array(),
                'Not' => array(),
                'Set' => array()
            );
        }

        foreach ($salesDet as $value) {
            $lc = explode('T', $value->DateFrom)[0];
            $conDate[$lc] = array(
                'Conv' => array(),
                'Ach' => array(),
                'Not' => array(),
                'Set' => array()
            );
        }

        ksort($conDate);

        foreach ($cLead as $value) {
            $lc = explode('T', $value->LeadClosedDate)[0];
            if (strtolower($value->LeadStatus) == 'converted') {
                array_push($conDate[$lc]['Conv'], $value);
            }
        }

        foreach ($salesDet as $value) {
            $lc = explode('T', $value->DateFrom)[0];
            if (isset($conDate[$lc])) {
                if (strtolower($value->GoalStatus) == 'achieved') {
                    array_push($conDate[$lc]['Ach'], $value->TargetGoal);
                } elseif (strtolower($value->GoalStatus) == 'not achieved') {
                    array_push($conDate[$lc]['Not'], $value->TargetGoal);
                } else {
                    array_push($conDate[$lc]['Set'], $value->TargetGoal);
                }
            }
        }

        echo json_encode(array('sDet' => $salesDet, 'cLead' => $conDate));
        return;

        // $xData = array();
        // $yData = array();

        // foreach ($gList as $key => $value) {
        //     $xData[$value->GoalStatus] = array();
        // }

        // foreach ($salesDet as $k => $v) {
        //     array_push($xData[$v->GoalStatus], $v->TargetGoal);
        //     if(!in_array($v->TargetGoal, $yData, true)){
        //         array_push($yData, $v->TargetGoal);
        //     }
        // }
        // sort($yData);
        // echo json_encode(array('xData'=>$xData, 'yData'=>$yData));
    }

    public function ajaxBarPlot()
    {
        $pDet = $this->GetProductDetails('', 0)->productDetails;
        $xDet = array();
        foreach ($pDet as $value) {
            $xDet[$value->ProductName] = array(
                'Conv' => array(),
                'Ach' => array(),
                'Not' => array(),
                'Set' => array()
            );
        }

        $proId = $this->input->post('pro');
        $salesDet = $this->GetProjectWiseSalesGoal('', $proId)->salesGoad;
        var_dump($salesDet);
        $cLead = $this->GetProjectWiseCustomerLead('', $proId)->ProjectWiseCustomerLead;
        foreach ($cLead as $value) {
            if (strtolower($value->LeadStatus) == 'converted') {
                array_push($xDet[$value->ProjectName]['Conv'], $value);
            }
        }

        foreach ($salesDet as $value) {
            if (strtolower($value->GoalStatus) == 'achieved') {
                array_push($xDet[$value->ProjectName]['Ach'], $value->TargetGoal);
            } elseif (strtolower($value->GoalStatus) == 'not achieved') {
                array_push($xDet[$value->ProjectName]['Not'], $value->TargetGoal);
            } else {
                array_push($xDet[$value->ProjectName]['Set'], $value->TargetGoal);
            }
        }

        echo json_encode(array('xDet' => $xDet));
    }

    public function ajaxBarPlotter() {
        $proId = $this->input->post('pro');
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        
        $list = $this->GetProjectWiseCustomerProjectLeadStaus('', $proId, $from, $to)->ProjectWiseCustomerLead;
        $cLead = $this->GetProjectWiseCustomerLead('', $proId)->ProjectWiseCustomerLead;
        $cStat = $this->GetCustomerStatus('')->GetCustomerStatus;

        // $pDet = $this->GetProductDetails('', 0)->productDetails;
        $xDet = array();
        $yDet = array();
        $zDet = array();

        foreach ($cStat as $key => $value) {
            $xDet[str_replace(' ', '', $value->CustomerStatus)] = array();
        }
        
        foreach ($list as $key => $value) {
            array_push($yDet, $value->Project);
            $zDet[$value->Project] = array();
            foreach ($xDet as $k => $v) {
                // var_dump($value->ToConvert);
                array_push($xDet[$k], $value->$k);
            }
        }

        foreach ($cLead as $value) {
            if (strtolower($value->LeadStatus) == 'converted') {
                array_push($zDet[$value->ProjectName], $value);
            }
        }

        echo json_encode(array($yDet, $xDet, $zDet, $list));
        // var_dump($xDet);exit;
        // foreach ($list as $key => $value) {
        //     $xDet[$value->ProjectName] = array();
        //     $yDet[$value->Status] = array();
        //     $zDet[$value->Status] = array();
        // }

        // foreach ($list as $key => $value) {
        //     array_push($yDet[$value->Status], $value);
        // }

        // foreach ($list as $key => $value) {
        //     array_push($yDet[$value->Status], $value);
        // }

        // $yCount = [];
        // foreach ($yDet as $value) {
        //     array_push($yCount, count($value));
        // }

        // $maxLoop = max($yCount);

        // $result = array_diff($array1, $array2);

        // for ($i=0; $i < $maxLoop; $i++) { 
        //     var_dump($i);
        // }
        // var_dump($maxLoop);

        // foreach ($list as $key => $value) {
            
        // }
        // var_dump($xDet, $yDet);
        // foreach ($pDet as $value) {
        //     $xDet[$value->PId] = array(
        //         'key' => $value->ProductName,
        //         'val' => array(),
        //         'Conv' => array(),
        //     );
        // }

        // foreach ($cLead as $value) {
        //     if (strtolower($value->LeadStatus) == 'converted') {
        //         array_push($xDet[$value->ProjectId]['Conv'], $value);
        //     }
        // }

        // // var_dump($list);

        // foreach ($list as $key => $value) {
        //     $yDet[$value->Status] = array();
        //     array_push($xDet[$value->ProjectId]['val'], $value);
        // }

        // foreach ($list as $key => $value) {
        //     array_push($yDet[$value->Status], $value);
        // }

        // $yCount = [];
        // foreach ($yDet as $value) {
        //     array_push($yCount, count($value));
        // }

        // $maxLoop = max($yCount);

        // echo json_encode(array($xDet, $yDet, $maxLoop));
    }
}
