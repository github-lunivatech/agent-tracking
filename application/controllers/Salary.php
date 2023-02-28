<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

class Salary extends Util
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isUserLoggedIn')) {
            $this->notLoginRedirect();
        }
        if(!in_array("show salary", $this->session->userdata('allowedRights'))){
            redirect('crmerror/page_not_found', 'refresh');
        }
    }

    public function addSalary()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Add Salary';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'salary/addSalary';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/salary/addSalary.js',
            'assets/js/salary/calculateSalary.js'
        );

        $hardMonth = $this->hardCodedNepMonth();
        // $as = $this->GetEmployeeAssignedSalaryByEmpId('', 32);
        // var_dump($as);

        $data['content'] = $hardMonth;

        $this->load->view('base', $data);
    }

    public function viewsalary()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View Salary';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'salary/viewSalary';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/salary/viewSalary.js',
            'assets/js/salary/calBSal.js'
        );

        $this->load->view('base', $data);
    }

    public function ajaxGetMonthlySalaryByEmployeeIdAndDate() {
        // $encId = crmEncryptUrlParameter('eid='.$this->input->post('empId'));
        $saList = $this->GetMonthlySalaryByEmployeeIdAndDate('', $this->input->post('empId'), $this->input->post('from'), $this->input->post('to'));
        // var_dump($saList);
        $allParm = array(
            // 'eid' => $encId,
            'rdet'=> $saList->EmpDetail
        );

        echo json_encode($allParm);
    }

    public function ajaxBulkSal() {
        $list = $this->GetEmployeeAssignedSalaryByEmpId('', $this->input->post('empId'))->EmpDetail;
        echo json_encode($list);
    }

    public function bulksalary() {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Add Bulk Salary';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'salary/bulkSalary';

         $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
            'assets/datatable/buttons/css/buttons.dataTables.min.css'
        );
        
        $data['page']['scripts'] = array(
            // 'assets/jquery/jquery.min.js',
            'assets/datatable/js/jquery.dataTables.js',
            // 'assets/datatable/buttons/js/xls_buttons.js',
            'assets/datatables_net-buttons/js/dataTables.buttons.min.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatables_net-buttons/js/buttons.html5.min.js', 
            'assets/datatable/JSZip/jszip.min.js',
            'assets/js/salary/bulkSalary.js'
        );


        $comDet = $this->GetCompanyDetails()->CompanyName;
        $da = array(
            "Id" => $comDet[0]->CId,
            "Name" => ''
        );
        $department = $this->GetDepartmentByCompanyId($da)->DepartmentLst;
        $data['depart'] = $department;

        $nepMonth = $this->hardCodedNepMonth();
        $data['nepMonth'] = $nepMonth;

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        // $this->form_validation->set_rules('departId', 'departId', 'required');
        $this->form_validation->set_rules('emp_id', 'emp_id', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['salList'] = array();
        } else {
            $list = $this->GetEmployeeAssignedSalaryByEmpId('', $this->input->post('emp_id'))->EmpDetail;
        //    var_dump($list);exit;
            $newList = array();
            foreach ($list as $key => $value) {
                $nL = array();
                $allP = 'EmployeeId='.$value->EmployeeId.
                '&BasicSalary='.$value->BasicSalary.
                '&Bonus='.$value->FestivalBonus.
                '&Allowance='.$value->Allowance.
                '&Others='.$value->Others.
                '&ProvidentFund='.$value->ProvidentFund.
                '&CitizenInvestmentTrust='.$value->CitizenInvestmentTrust.
                '&Insurance='.$value->Insurane.
                '&OtherFunds='.$value->OtherFund.
                '&TDSAmount='.$value->TDS.
                '&TotalPayable='.$value->TotalPayable;
                // '&IsSalaryDispatched='.$value->IsSalaryDispatched.
                // '&Remarks='.$value->Remarks;
                foreach ($value as $k => $val) {
                    $nL[$k] = $val;
                }
                $nL['allP'] = crmEncryptUrlParameter($allP);
                array_push($newList, (object)$nL);
            }
            $data['salList'] = $newList;
        }
        // var_dump($list);exit;
        $this->load->view('base', $data);        
    }

    public function insertUpdateSalary()
    {
        // var_dump($_POST);
        $today = new DateTime();
        $ent_date = $today->format('c');
        $salDis = $this->input->post('salDis') != null ? true : false;
        // $salDisDate = '';
        // if($salDis == true) {
        //     $salDisDate = $today->format('c');
        // }
        $allD = $this->input->post('allD');
        $empid = $this->input->post('empId');

        $baSal = $this->input->post('basic_sal');
        $bon = $this->input->post('bonus');
        $allo = $this->input->post('allowance');
        $oth = $this->input->post('others');
        $prov = $this->input->post('prov_fund');
        $cit = $this->input->post('cit_trust');
        $ins = $this->input->post('insurance');
        $of = $this->input->post('other_fund');
        $tds = $this->input->post('tdsAmt');
        $tp = $this->input->post('totalPayable');

        if($allD != null){
            $dec = crmDecryptWithParameter($allD)[0];
            // var_dump($dec);exit;
            $empid = $dec['EmployeeId'];
            $baSal = $dec['BasicSalary'];
            $bon = $dec['Bonus'];
            $allo = $dec['Allowance'];
            $oth = $dec['Others'];
            $prov = $dec['ProvidentFund'];
            $cit = $dec['CitizenInvestmentTrust'];
            $ins = $dec['Insurance'];
            $of = $dec['OtherFunds'];
            $tds = $dec['TDSAmount'];
            $tp = $dec['TotalPayable'];
        }

        $dedAmt = (float)$this->input->post('dedAmt');

        $actPay = (float)$this->input->post('actPay');

        if($tp != null || $tp != 0 || $tp > 0 ){
            // $tp = $tp - $dedAmt;
            //coming from js
            $tp = $actPay;
        }

        $data = array(
            "SRId" => $this->input->post('srid') ?? 0,
            "EmployeeId" => (int)$empid,
            "SalaryMonth" => $this->input->post('monthName'),
            "SalaryDateFrom" => $this->input->post('from'),
            "SalaryDateTo" => $this->input->post('to'),
            "BasicSalary" => $baSal,
            "Bonus" => $bon,
            "Allowance" => $allo,
            "Others" => $oth,
            "ProvidentFund" => $prov,
            "CitizenInvestmentTrust" => $cit,
            "Insurance" => $ins,
            "OtherFunds" => $of,
            "TDSAmount" => $tds,
            "TotalPayable" => $tp,
            "IsSalaryDispatched" => $salDis,
            "Remarks" => $this->input->post('remarks')?$this->input->post('remarks'):'',
            "UserId" => $this->input->post('userid') ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
            "Entrydate" => $ent_date,
            "DeductionAmt" => $dedAmt
            // "SalaryDispachedDate" => $salDisDate,
        );

        // var_dump($data);
        $srid = $this->InsertUpdateMontlySalaryByEmployeeId($data);
        // var_dump($srid);exit;
        if($srid > 0){
            $isSalDis = $salDis ? '' : 'not';
            $fullAr = array(
                'res' => 'Salary Saved and Salary is '.$isSalDis.' Dispatched',
                'i' => $srid
            );
            echo json_encode($fullAr);
        }else{
            echo json_encode(array('res' => 'Salary not saved. please try again', 'i' => 0));
        }
        
    }
}
