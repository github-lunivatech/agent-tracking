<?php
header('Access-Control-Allow-Origin: *');
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// use PhpOffice\PhpSpreadsheet\Shared\Date;

defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

class Login extends Util
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // echo 'a';
        $this->load->view('login');
    }

    public function auth()
    {

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login');
        } else {
            $data = array(
                "UserName" => $this->input->post('username'),
                "Password" => $this->input->post('password'),
            );

            $check = $this->CheckValidUser($data);
            if ($check && $check != null && isset($check->ValidUser) && $check->ValidUser != []) {

                $check = $check->ValidUser;

                $rolerId = $check[0]->RoleId;

                $roleName = $this->setRole($rolerId);
                $fullName = $this->returnDetails($check[0]->EmpId)['full_name'];
                $photo = $this->returnDetails($check[0]->EmpId)['photo'];

                //now full name and others
                $this->session->set_userdata('loggedInUserId', $check[0]->UId);
                $this->session->set_userdata('loggedInEmpId', $check[0]->EmpId);
                $this->session->set_userdata('loggedInUsername', $check[0]->UserName);
                $this->session->set_userdata('loggedInRoleId', $rolerId);
                $this->session->set_userdata('loggedInRole', $roleName);
                $this->session->set_userdata('loggedInFullname', $fullName);
                $this->session->set_userdata('loggedInDepId', $check[0]->DepartmentId);

                $this->updatePermissionSession();

                if ($photo != '') {
                    $this->session->set_userdata('loggedInPhoto', $photo);
                }
                $this->session->set_userdata('isUserLoggedIn', true);
                $this->session->set_flashdata('show_notice', true);

                if ($this->input->post('redirectCpage') != null) {
                    $qs = '';
                    if ($this->input->post('qs') != null)
                        $qs = '?' . $this->input->post('qs');
                    redirect(urldecode($this->input->post('redirectCpage')) . $qs, 'refresh');
                } else {
                    if ($roleName != 'Visitor') {
                        redirect('home', 'refresh');
                    } else {
                        redirect('visitor/viewAppForAd', 'refresh');
                    }
                }
            } else {
                $this->session->set_flashdata('error', 'Incorrect username or password!');
                redirect('login/', 'refresh');
            }
        }
    }

    public function create_login()
    {
        if (!$this->session->userdata('isUserLoggedIn')) {
            $this->notLoginRedirect();
            return;
        }
        if ($this->session->userdata('loggedInRole') != 'Admin') {
            redirect('crmerror/page_not_found', 'refresh');
            return;
        }
        $eid = 0;
        if (isset($_GET['q'])) {
            $eid = crmDecryptUrlParameter()[0]['eid'];
        }
        $data = array(
            'Id' => 1, // company id
            'Name' => ''
        );
        $role = $this->GetlistOfRoles($data)->ROleList;

        $datae = array(
            'Id' => $eid,
            'Name' => ''
        );
        $emDet = $this->GetListOfEmployeeDetailsById($datae)->EmpDetail;
        $iscreated = false;
        foreach ($emDet as $value) {
            if ($value->LoginId != null) {
                $iscreated = true;
            }
        }

        $this->load->view('login/createLogin', array(
            'ro' => $role,
            'iscreated' => $iscreated
        ));
    }


    public function createEmployeeLogin()
    {

        $eeid = $this->input->post('cl');
        if ($eeid == null) {
            $this->session->set_flashdata('error', 'No Proper Employee Selected');
            redirect('employee/em_view', 'refresh');
            return;
        }

        $eid = crmDecryptWithParameter($eeid)[0]['eid'];

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules(
            'username',
            'Username',
            'trim|required',
            array(
                'required'      => 'Username is required'
            )
        );
        $this->form_validation->set_rules(
            'password',
            'Password',
            'required|min_length[3]|max_length[100]',
            array(
                'required'      => 'Password is required',
                'min_length'     => 'Password should atleast have 3 characters',
                'max_length'     => 'Password should not exceed 100 characters'
            )
        );
        $this->form_validation->set_rules(
            'rep_password',
            'Retyped Password',
            'required|matches[password]',
            array(
                'required'      => 'Password is required',
                'matches'     => 'Password should match'
            )
        );
        $this->form_validation->set_rules(
            'roles',
            'Role',
            'required',
            array(
                'required'      => 'Role is required'
            )
        );
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Fields are not satisfied');
            $resId = crmEncryptUrlParameter('eid='.$eid);
            redirect('login/create_login?q=' . $resId, 'refresh');
        } else {
            $today = new DateTime();
            $data = array(
                "UId" => $this->input->post('uid') !=  null ? $this->input->post('uid') : 0,
                "EmpId" => $eid,
                "UserName" => $this->input->post('username'),
                "UPassword" => $this->input->post('password'),
                "RoleId" => (int)$this->input->post('roles'),
                "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                "EntryDate" => $this->input->post('ent_date') != null ? $this->input->post('ent_date') : $today->format('c'),
                "IsActive" => true
            );
            $uid = $this->CreateLoginOfEmployee($data);
            if ($uid > 0) {
                $session_msg = 'Login created successfully';
                $this->session->set_flashdata('success', $session_msg);
                redirect('employee/em_view', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Unsuccessfull. Please try again.');
                redirect('employee/create_login?q=' . $eeid, 'refresh');
            }
        }
    }

    public function registerLogin()
    {

        // $uid = $this->CreateLoginOfEmployee($data);
        // echo $uid;
    }

    public function logout()
    {
        $this->session->sess_destroy();
        // $redirectto = $this->session->userdata('userType')?$this->session->userdata('userType'):'';
        redirect('login/', 'refresh');
    }

    public function setRole($roleId)
    {
        $data = array(
            'Id' => 1,
            'Name' => ''
        );
        $roleList = $this->GetlistOfRoles($data)->ROleList;
        foreach ($roleList as $key => $value) {
            if ($value->RId == $roleId) {
                return $value->RightName;
            }
        }
    }

    private function returnDetails($eid)
    {
        $datae = array(
            'Id' => $eid,
            'Name' => ''
        );
        $emDet = $this->GetListOfEmployeeDetailsById($datae);
        $fullDet['full_name'] = $emDet->EmpDetail[0]->EmployeeName;
        $fullDet['photo'] = '';
        if ($emDet->EmpDetail[0]->EmpImage != '') {
            $fullDet['photo'] = $this->readServiceINI('API')['middleware'] . $emDet->EmpDetail[0]->EmpImage;
        }
        return $fullDet;
    }

    public function testCallSer() {
        $listItems = json_decode($this->input->post('_lstBillItems'));
        $itemArray = array();
        if($listItems != '' && $listItems != null){
            foreach ($listItems as $value) {
                array_push($itemArray, array(
                    "ID" => $value->ID,
                    "BillID" =>  $value->BillID,
                    "BillNo" =>  $value->BillNo,
                    "TestID" =>  $value->TestID,
                    "billDGid" =>  $value->billDGid,
                    "billTestName" =>  $value->billTestName,
                    "billPrice" =>  $value->billPrice,
                    "billOutGoing" =>  $value->billOutGoing,
                    "billDiscount" =>  $value->billDiscount,
                    "billDiscountAmt" =>  $value->billDiscountAmt,
                    "billPriceFinal" =>  $value->billPriceFinal,
                    "IsSync" =>  $value->IsSync,
                    "RoundAmt" =>  $value->RoundAmt,
                    "Remarks" =>  $value->Remarks,
                    "OutgoingLabId" =>  $value->OutgoingLabId,
                ));
            }
            $data = array(
                "_lstBillItems" => json_encode($itemArray),
                "Id" => $this->input->post('Id'),
                "PatId" => $this->input->post('PatId'),
                "Nrl_Reg_No" => $this->input->post('Nrl_Reg_No'),
                "TestId" => $this->input->post('TestId'),
                "Price" => $this->input->post('Price'),
                "TotalPrice" => $this->input->post('TotalPrice'),
                "DiscountPrice" => $this->input->post('DiscountPrice'),
                "HSTPrice" => $this->input->post('HSTPrice'),
                "IsPaid" => $this->input->post('IsPaid'),
                "IsDone" => $this->input->post('IsDone'),
                "BillDate" => $this->input->post('BillDate'),
                "BillLastModifiedDate" => $this->input->post('BillLastModifiedDate'),
                "BillNo" => $this->input->post('BillNo'),
                "BillDiscount" => $this->input->post('BillDiscount'),
                "BillDiscountAmt" => $this->input->post('BillDiscountAmt'),
                "BillHst" => $this->input->post('BillHst'),
                "BillHstAmt" => $this->input->post('BillHstAmt'),
                "BillAmtPaid" => $this->input->post('BillAmtPaid'),
                "BillRemainingAmt" => $this->input->post('BillRemainingAmt'),
                "BillPaymentType" => $this->input->post('BillPaymentType'),
                "BillOutGngAmt" => $this->input->post('BillOutGngAmt'),
                "BillOutGngDiscountAmt" => $this->input->post('BillOutGngDiscountAmt'),
                "BillOutGngAmtPc" => $this->input->post('BillOutGngAmtPc'),
                "UserId" => $this->input->post('UserId'),
                "BillIsVoid" => $this->input->post('BillIsVoid'),
                "BillLastModifiedUser" => $this->input->post('BillLastModifiedUser'),
                "BillAdvanceAmt" => $this->input->post('BillAdvanceAmt'),
                "BillCollectionAmt" => $this->input->post('BillCollectionAmt'),
                "BillNepaliDate" => $this->input->post('BillNepaliDate'),
                "BillLastModifiedNepaliDate" => $this->input->post('BillLastModifiedNepaliDate'),
                "BillRoundedAmt" => $this->input->post('BillRoundedAmt'),
                "BillWithoutRound" => $this->input->post('BillWithoutRound'),
                "BillCreditPartyCode" => $this->input->post('BillCreditPartyCode'),
                "BillPassword" => $this->input->post('BillPassword'),
                "IsSync" => $this->input->post('IsSync'),
                "PaymentMode" => $this->input->post('PaymentMode'),
                "Remarks" => $this->input->post('Remarks'),
                "PaymentCode" => $this->input->post('PaymentCode'),
                "SampleId" => $this->input->post('SampleId'),
                "FiscalYearId" => $this->input->post('FiscalYearId'),
            );
            $response = $this->CreateCreditPartyBill($data);
            echo json_encode($response);
        }else{
            echo json_encode(0);
        }
    }
}
