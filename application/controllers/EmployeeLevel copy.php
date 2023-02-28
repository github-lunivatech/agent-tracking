<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

class EmployeeLevel extends Util
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isUserLoggedIn')) {
            $this->notLoginRedirect();
        }
    }

    public function empYearList()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Job Year List';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employeelevel/employeeJobYearDetailsList';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
        );

        $data['empList'] = $this->getEmployeeyearLists(false);

        $this->load->view('base', $data);
    }

    public function empYearListAdd()
    {
        $isEdit = false;
        $yid = 0;
        if(isset($_GET['q'])){
            $isEdit = true;
            $yid = crmDecryptUrlParameter()[0]['yid'];
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Job Year';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employeelevel/employeeJobYearDetails';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css'
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/employeelevel/formValidation.js'
        );

        $empDet = [];
        if($isEdit == true){
            $empList = $this->getEmployeeyearLists(false);
            foreach ($empList as $value) {
                if($value->YId == $yid)
                    $empDet = $value;
            }
        }

        $data['allData'] = array('yid' => $yid, 'isEdit' => $isEdit, 'empDet' => $empDet);

        $this->load->view('base', $data);
    }

    public function insertUpdateEmployeeJobYearDetail() {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('empYear', 'Employee Year', 'required');
        if ($this->form_validation->run() != FALSE) {
            $data = array(
                "YId" => $this->input->post('yid') ?? 0,
                "EmployeeYear" => $this->input->post('empYear'),
                "UserId" => $this->input->post('userid') ?? $this->session->userdata('loggedInUserId'),
                "IsActive" => $this->input->post('isactive') != null ? true : false
            );
            $response = $this->InsertUpdateEmployeeJobYearDetails($data);
            if($response > 0){
                $this->session->set_flashdata('success', 'Year Saved');
            }else{
                $this->session->set_flashdata('error', 'Year Not Saved');
            }
            $url = 'employeelevel/empYearList';
            redirect($url, 'refresh');
        }else{
            $url = 'employeelevel/empYearListAdd';
            redirect($url, 'refresh');
        }
    }

    public function getEmployeeyearLists($ajax=true) {
        $response = $this->GetEmployeeyearList([])->EmpYear;
        if($ajax)
            echo json_encode($response);
        else
            return $response;
    }

    public function getListOfEmployeeLevels($ajax=true) {
        $response = $this->GetListOfEmployeeLevel([])->EmpLevel;
        if($ajax)
            echo json_encode($response);
        else
            return $response;
    }

    public function getEmployeeLevelYearWiseSalaryByDepartmentLevelYears($postData = [], $ajax=true) {
        $data = array(
            'departId' => $postData['departId'],
            'levelid' =>  $postData['levelid'],
            'yearId' =>  $postData['yearId'],
            'designation' =>  $postData['designation'],
        );
        $response = $this->GetEmployeeLevelYearWiseSalaryByDepartmentLevelYear($data)->EmpLevelSalary;
        if($ajax)
            echo json_encode($response);
        else
            return $response;
    }

    public function insertUpdateEmployeeLevels() {
        $data = array(
            "LId" => $this->input->post('lid') ?? 0,
            "LevelCode" => $this->input->post('levelCode'),
            "EmployeeLevel" => $this->input->post('employeeLevel'),
            "UserId" => $this->input->post('userid') ?? $this->session->userdata('loggedInUserId'),
            "IsActive" => $this->input->post('isactive') != null ? true : false
        );
        $response = $this->InsertUpdateEmployeeLevel($data);
        if($response > 0){
            $this->session->set_flashdata('success', 'Level Saved');
        }else{
            $this->session->set_flashdata('error', 'Level Not Saved');
        }
        $url = 'employeelevel/empLevelList';
        redirect($url, 'refresh');
    }

    public function insertUpdateEmployeeLevelYearWiseSalaryLookUps() {
        $today = new DateTime();
        //AD to BS Conversion
        // $english_date = date('Y-m-d');
        $nepali_date = $this->getNepaliDateFormat($today->format('c'));

        $data = array(
            "LId" => (int) $this->input->post('lid') ?? 0,
            "DepartmentId" => (int) $this->input->post('departmentid'),
            "DesignationId" => (int) $this->input->post('designationid'),
            "LevelId" => (int) $this->input->post('levelid'),
            "YearId" => (int) $this->input->post('yearid'),
            "BasicSalary" => (float) $this->input->post('basicsalary'),
            "FestivalBonus" => (float) $this->input->post('festivalbonus'),
            "Allowance" => (float) $this->input->post('allowance'),
            "Others" => (float) $this->input->post('others'),
            "ProvidentFund" => (float) $this->input->post('providentfund'),
            "CitizenInvestmentTrust" => (float) $this->input->post('citizeninvestment'),
            "Insurane" => (float) $this->input->post('insurance'),
            "SSF" => (float) $this->input->post('ssf'),
            "OtherFund" => (float) $this->input->post('otherfund'),
            "NightOverTime" => (float) $this->input->post('nightovertime'),
            "NormalOverTime" => (float) $this->input->post('normalovertime'),
            "TDS" => (float) $this->input->post('tds'),
            "TotalPayable" => (float) $this->input->post('totalPayable'),
            "UserId" => $this->input->post('userid') ?? $this->session->userdata('loggedInUserId'),
            "EntryDate" => $this->input->post('ent_date') ?? $today->format('c'),
            "IsActive" => $this->input->post('isactive') != null ? true : false,
            "NepaliDate" => $nepali_date,
        );
        $response = $this->InsertUpdateEmployeeLevelYearWiseSalaryLookUp($data);
        if($response > 0){
            $this->session->set_flashdata('success', 'Level Salary Saved');
        }else{
            $this->session->set_flashdata('error', 'Level Salary Not Saved');
        }
        $url = 'employeelevel/empLevelSalaryList';
        redirect($url, 'refresh');
    }

    public function empLevelList()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Level List';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employeelevel/employeeLevelDetailsList';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
        );

        $data['empList'] = $this->getListOfEmployeeLevels(false);

        $this->load->view('base', $data);
    }

    public function empLevelSalaryList()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Level Salary List';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employeelevel/employeeLevelSalaryList';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
        );

        $comDet = $this->GetCompanyDetails()->CompanyName;
        $da = array(
            "Id" => $comDet[0]->CId,
            "Name" => ''
        );
        $department = $this->GetDepartmentByCompanyId($da)->DepartmentLst;
        $desDet = $this->GetlistOfDesignation($da)->DesignationDetails;
        $empYList = $this->getEmployeeyearLists(false);
        $empLList = $this->getListOfEmployeeLevels(false);

        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('departId', 'Department Id', 'required');
        $this->form_validation->set_rules('levelid', 'Level Id', 'required');
        $this->form_validation->set_rules('yearId', 'Year Id', 'required');
        $this->form_validation->set_rules('designation', 'Designation', 'required');

        $dataList = array();
        if ($this->form_validation->run() == FALSE) {

        }else{
            $postData = array(
                'departId' => $this->input->post('departId'),
                'levelid' => $this->input->post('levelid'),
                'yearId' => $this->input->post('yearId'),
                'designation' => $this->input->post('designation'),
            );
            $dataList = $this->getEmployeeLevelYearWiseSalaryByDepartmentLevelYears($postData, false);
        }

        $data['allData'] = array(
            'depar' => $department,
            'desDet' => $desDet,
            'empYList' => $empYList,
            'empLList' => $empLList,
            'dataList' => $dataList
        );

        $this->load->view('base', $data);
    }

    public function empLevelListAdd() {
        $isEdit = false;
        $yid = 0;
        if(isset($_GET['q'])){
            $isEdit = true;
            $yid = crmDecryptUrlParameter()[0]['yid'];
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Job Year';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employeelevel/employeeLevelDetails';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
        );

        $empDet = [];
        if($isEdit == true){
            $empList = $this->getListOfEmployeeLevels(false);
            foreach ($empList as $value) {
                if($value->LId == $yid)
                    $empDet = $value;
            }
        }
        $data['allData'] = array('yid' => $yid, 'isEdit' => $isEdit, 'empDet' => $empDet);

        $this->load->view('base', $data);        
    }

    

    public function empLevelSalaryListAdd() {
        $isEdit = false;
        $yid = 0;
        $dataList = [];
        if(isset($_GET['q'])){
            $isEdit = true;
            $depParam = crmDecryptUrlParameter()[0]; 
            $yid = $depParam['lid'];
            $postData = array(
                'departId' => $depParam['DepartmentId'],
                'levelid' => $depParam['LevelId'],
                'yearId' => $depParam['YearId'],
                'designation' => $depParam['DesignationId'],
            );
            $dataList = $this->getEmployeeLevelYearWiseSalaryByDepartmentLevelYears($postData, false);
            foreach ($dataList as $value) {
                if($value->LId == $yid)
                    $dataList = $value;
            }
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Job Year';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employeelevel/employeeLevelSalary';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
        );

        $empDet = [];

        $comDet = $this->GetCompanyDetails()->CompanyName;
        $da = array(
            "Id" => $comDet[0]->CId,
            "Name" => ''
        );
        $depDet = $this->GetDepartmentByCompanyId($da)->DepartmentLst;
        $desDet = $this->GetlistOfDesignation($da)->DesignationDetails;
        $empYList = $this->getEmployeeyearLists(false);
        $empLList = $this->getListOfEmployeeLevels(false);
        
        $data['allData'] = array(
            'yid' => $yid, 
            'isEdit' => $isEdit, 
            'empDet' => $empDet,
            'comDet' => $comDet,
            'depDet' => $depDet,
            'desDet' => $desDet,
            'empYList' => $empYList,
            'empLList' => $empLList,
            'dataList' => $dataList
        );

        $this->load->view('base', $data);        
    }

}
