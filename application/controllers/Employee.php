<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

class Employee extends Util
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isUserLoggedIn')) {
            $this->notLoginRedirect();
        }
        if (!in_array("show profile", $this->getAllowedRights())) {
            if (!in_array("show employees", $this->getAllowedRights())) {
                redirect('crmerror/page_not_found', 'refresh');
            }
        }
        $this->load->helper('NepaliCalender');
    }

    public function em_register()
    {
        if (!in_array("register employee", $this->getAllowedRights())) {
            redirect('crmerror/page_not_found', 'redirect');
            return;
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/employee_register';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/css/fileUpload.css',
            'assets/timepickerNepali/nepaliDatePicker.min.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/js/employee/employee_register.js',
            'assets/js/employee/employee_profile_withimage.js',
            'assets/timepickerNepali/nepaliDatePicker.min.js',
            'assets/js/englishNepaliDatePicker.js',
            'assets/js/jquery/jquery.validation.js',
            
        );

        $eth = $this->hardCodeEthnicity();
        $ide = $this->hardCodedIde();
        $states=$this->GetStates(array('Id'=>0));
        $data['states'] = $states;
        $data['ethinic'] = $eth;
        $data['ide'] = $ide;

        $this->load->view('base', $data);
    }

    public function em_edit()
    {
        $hasPer = in_array("register employee", $this->getAllowedRights());
        $isSameId = false;
        $empVal = [];
        $newArr = array();
        if (isset($_GET['q'])) {
            $urlParam = crmDecryptUrlParameter()[0];
            $eid = $urlParam['eid'];
            // 1 != 1 = false
            // 1 == 1 = true
            $isSameId = ($this->session->userdata('loggedInEmpId') == $eid);
            $empDet = $this->GetListOfEmployeeDetailsById(array("Id" => $eid, "Name" => ''));
            $empVal = $empDet->EmpDetail;
            foreach ($empVal as $value) {
                $newAr = (array) $value;
                if ($value->EmpImage != '') {
                    $newAr['EmpImage2'] = $this->readServiceINI('API')['middleware'] . $value->EmpImage;
                }
                array_push($newArr, (object)$newAr);
            }
            $data = array(
                "Id" => $eid,
                "Name" => '',
            );
            $emAddr = $this->GetEmployeeAddressDetailsByEmpId($eid)->EmpAddress;
            $emRef = $this->GetListOfEmployeeReferenceContactById($data)->EmpDetail;
            // var_dump($emRef);exit;
            $newAddr = array();
        //     if($emAddr){
        //     foreach ($emAddr as $value) {
        //         $newad = array();

        //         $eP = 'eid=' . $value->EmpId .'&aId=' . $value->AId;
        //         foreach ($value as $val) {
        //             array_push($newad, $val);
        //         }
        //         $newEx['allP'] = crmEncryptUrlParameter($eP);
        //         array_push($newAddr, $newad);

        //     }
        // }
            // var_dump($emAddr);exit;
            //permission added for now update if wrong id enters
            if (!$hasPer && $isSameId == false) {
                redirect('crmerror/page_not_found', 'redirect');
                return;
            }
        } else {
            redirect('crmerror/page_not_found', 'redirect');
            return;
        }

        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Edit';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/employee_register';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/css/fileUpload.css',
            'assets/timepickerNepali/nepaliDatePicker.min.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/js/employee/employee_register.js',
            'assets/js/employee/employee_profile_withimage.js',
            'assets/timepickerNepali/nepaliDatePicker.min.js',
            'assets/js/englishNepaliDatePicker.js',
        );

        $eth = $this->hardCodeEthnicity();
        $ide = $this->hardCodedIde();
        $states=$this->GetStates(array('Id'=>0))->GetStates;
        // var_dump($states);exit;
        $data['states'] = $states;
        $data['content'] = $newArr;
        $data['address1'] = $emAddr;
        $data['nominee'] = $emRef;
        $data['ethinic'] = $eth;
        $data['ide'] = $ide;

        $this->load->view('base', $data);
    }

    public function em_view()
    {
        if (!in_array("show employees", $this->getAllowedRights())) {
            redirect('crmerror/page_not_found', 'refresh');
            return;
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View All';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/employee_viewall';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/js/employee/employee_viewall.js',
        );

        //this service needs to be changed when date comes
        $datae = array(
            'Id' => 0, // for now all 
            'Name' => 1
        );
        $emDet = $this->GetListOfEmployeeDetailsById($datae)->EmpDetail;
        //this service needs to be changed when date comes
        $newDet = array();
        foreach ($emDet as $value) {
            $newDe = array();
            $newDe = (array) $value;
            if ($value->EmpImage != null) {
                $newDe['EmpImage'] = $this->readServiceINI('API')['middleware'] . $value->EmpImage;
            }
            array_push($newDet, (object) $newDe);
        }

        $data['content'] = $newDet;

        $this->load->view('base', $data);
    }

    public function emprofile2()
    {
        $allArray = array(
            'bas' => [],
            'edu' => [],
            'exp' => [],
            'des' => [],
            'ref' => [],
            'doc' => []
        );
        $eid = '';
        if (isset($_GET['q'])) {
            $urlParam = crmDecryptUrlParameter()[0];
            $eid = $urlParam['eid'];
        }
        if ($eid != '' && $eid != 0) {
            $data = array(
                "Id" => $eid,
                "Name" => '',
            );
            $emBas = $this->GetListOfEmployeeDetailsById($data)->EmpDetail;
            $emEdu = $this->GetListOfEmployeeEducationById($data)->EmpDetail;
            $emExp = $this->GetListOfEmployeeExperienceById($data)->EmpDetail;
            $emDes = $this->GetListOfEmployeeDesignationById($data)->EmpDetail;
            $emRef = $this->GetListOfEmployeeReferenceContactById($data)->EmpDetail;
            $emDoc = $this->GetListOfEmployeeDocumentDetailsById($data)->EmpDetail;
            $emaddr = $this->GetListOfEmployeeDocumentDetailsById($data)->EmpDetail;

            $allArray = array(
                'bas' => $emBas,
                'edu' => $emEdu,
                'exp' => $emExp,
                'des' => $emDes,
                'ref' => $emRef,
                'doc' => $emDoc,
                'emaddr'=>$emaddr
            );
        }

        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Profile';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/employee_profile';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/css/fileUpload.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/employee/employee_profile.js',
        );

        $comDet = $this->GetCompanyDetails()->CompanyName;
        $da = array(
            "Id" => $comDet[0]->CId,
            "Name" => ''
        );
        $depDet = $this->GetDepartmentByCompanyId($da)->DepartmentLst;
        $desDet = $this->GetlistOfDesignation($da)->DesignationDetails;

        $datae = array(
            'Id' => 0,
            'Name' => ''
        );
        $emDet = $this->GetListOfEmployeeDetailsById($datae)->EmpDetail;

        $allData = array(
            'allDet' => $allArray,
            'comDet' => $comDet,
            'depDet' => $depDet,
            'desDet' => $desDet,
            'spDet' => $emDet
        );
        
        $data['content'] = $allData;

        $this->load->view('base', $data);
    }

    public function emprofile()
    {
        $allArray = array(
            'bas' => [],
            'edu' => [],
            'exp' => [],
            'des' => [],
            'ref' => [],
            'doc' => [],
            'bank' => [],
            'sal' => []
        );
        $eid = '';
        if (isset($_GET['q'])) {
            $urlParam = crmDecryptUrlParameter()[0];
            $eid = $urlParam['eid'];
            
        }
        if ($eid != '' && $eid != 0) {
            $data = array(
                "Id" => $eid,
                "Name" => '',
            );
            $emBas = $this->GetListOfEmployeeDetailsById($data)->EmpDetail;
            // var_dump($emBas);exit;
            $newBas = array();
            foreach ($emBas as $value) {
                $newBa = array();
                $newBa = (array) $value;
                if ($value->EmpImage != '') {
                    $newBa['EmpImage'] = $this->readServiceINI('API')['middleware'] . $value->EmpImage;
                }
                array_push($newBas, (object)$newBa);
            }

            $emEdu = $this->GetListOfEmployeeEducationById($data)->EmpDetail;
            $emEduDe = array();
            foreach ($emEdu as $value) {
                $emArr = array();

                $eP = 'eid=' . $value->EId . '&ent_date=' . $value->EntryDate . '&edid=' . $value->EdId;

                foreach ($value as $val) {
                    array_push($emArr, $val);
                }
                $emArr['allP'] = crmEncryptUrlParameter($eP);
                array_push($emEduDe, $emArr);
            }

            $emExp = $this->GetListOfEmployeeExperienceById($data)->EmpDetail;
            $newExp = array();
            foreach ($emExp as $value) {
                $newEx = array();

                $eP = 'eid=' . $value->EId . '&ent_date=' . $value->EntryDate . '&expId=' . $value->ExpId;

                foreach ($value as $val) {
                    array_push($newEx, $val);
                }
                $newEx['allP'] = crmEncryptUrlParameter($eP);
                array_push($newExp, $newEx);
            }

            //for details remove when service
            $emDes = $this->GetListOfEmployeeDesignationById($data)->EmpDetail;
            $newDes = array();
            // var_dump($emDes);exit;
            foreach ($emDes as $value) {
                $f = $this->returnDepartmentName($value->DepartmentId, $value->DesignationId, $value->SupervisorId, $value->ReportingManager);

                $eP = 'eid=' . $value->EId . '&ent_date=' . $value->EntryDate . '&edid=' . $value->EdId;

                $newDess = array();
                foreach ($value as $val) {
                    array_push($newDess, $val);
                }
                $newDess['allP'] = crmEncryptUrlParameter($eP);
                $newDess['dep_name'] = $f['dep_name'];
                $newDess['des_name'] = $f['des_name']? $f['des_name'][0]:0 ;
                $newDess['sup_name'] = $f['sup_name']? $f['sup_name'][0]:0;
                $newDess['rep_name'] = $f['rep_name']? $f['rep_name'][0]:0;
                array_push($newDes, $newDess);
            }
            //for details remove when service

            $emRef = $this->GetListOfEmployeeReferenceContactById($data)->EmpDetail;
            $newRef = array();
            foreach ($emRef as $value) {
                $newR = array();
                $eP = 'eid=' . $value->EId . '&ent_date=' . $value->EntryDate . '&refId=' . $value->RId;
                foreach ($value as $val) {
                    array_push($newR, $val);
                }
                $newR['allP'] = crmEncryptUrlParameter($eP);
                array_push($newRef, $newR);
            }

            $emDoc = $this->GetListOfEmployeeDocumentDetailsById($data)->EmpDetail;
            $newDoc = array();
            foreach ($emDoc as  $value) {
                $newD = array();
                $newD = (array) $value;
                if ($value->DocumentPath != '' && $value->DocumentPath != null) {
                    $newD['DocumentPath'] = $this->readServiceINI('API')['middleware'] . $value->DocumentPath;
                }
                array_push($newDoc, (object) $newD);
            }

            $emBank = $this->GetBankDetailsByEmployeeId($eid)->EmpDetail;

            $newBank = array();
            foreach ($emBank as $value) {
                $newEx = array();

                $eP = 'eid=' . $value->EmployeeId . '&ent_date=' . $value->EntryDate . '&ebId=' . $value->EBId;
                foreach ($value as $val) {
                    array_push($newEx, $val);
                }
                $newEx['allP'] = crmEncryptUrlParameter($eP);
                array_push($newBank, $newEx);
            }
            //Address
            $emAddr = $this->GetEmployeeAddressDetailsByEmpId($eid)->EmpAddress;
            // var_dump($eid);exit;
            $newAddr = array();
            foreach ($emAddr as $value) {
                $newad = array();
                $eP = 'eid=' . $value->EmpId .'&aId=' . $value->AId;
                foreach ($value as $val) {
                    array_push($newad, $val);
                }
                $newEx['allP'] = crmEncryptUrlParameter($eP);
                array_push($newAddr, $newad);

            }
            // var_dump($newBank);exit;
            //address close

            $emSal = $this->GetEmployeeAssignedSalaryByEmpId('', $eid)->EmpDetail;
            $newSal = array();
            foreach ($emSal as $value) {
                $newS = array();

                $eP = 'eid=' . $value->EmployeeId . '&ent_date=' . $value->EntryDate . '&esId=' . $value->ESId;

                foreach ($value as $val) {
                    array_push($newS, $val);
                }
                $newS['allP'] = crmEncryptUrlParameter($eP);
                array_push($newSal, $newS);
            }

            $allArray = array(
                'bas' => $newBas,
                'edu' => $emEduDe,
                'exp' => $newExp,
                'des' => $newDes,
                'ref' => $newRef,
                'doc' => $newDoc,
                'bank' => $newBank,
                'sal' => $newSal,
                'add' => $newAddr
            );
        }

        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Profile';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/employee_profiles';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/select2/select2_3.5.4.css',
            'assets/css/fileUpload.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/select2/select2_3.5.4.js',
            'assets/js/employee/employee_profile.js',
            'assets/js/table_page.js',
            'assets/js/employee/employee_sal_cal.js',
        );

        $comDet = $this->GetCompanyDetails()->CompanyName;
        $da = array(
            "Id" => $comDet[0]->CId,
            "Name" => ''
        );

        $depDet = $this->GetDepartmentByCompanyId($da)->DepartmentLst;
        $desDet = $this->GetlistOfDesignation($da)->DesignationDetails;
        // var_dump($desDet);exit;

        $datae = array(
            'Id' => 0,
            'Name' => ''
        );
        $emDet = $this->GetListOfEmployeeDetailsById($datae)->EmpDetail;
        // $empAddressList = $this->GetEmployeeAddressDetailsByEmpId()->EmpLevel;
        // var_dump($emDet);exit;
        $empYearList = $this->GetEmployeeyearList([])->EmpYear;
        $empLevelList = $this->GetListOfEmployeeLevel([])->EmpLevel;

        $allData = array(
            'allDet' => $allArray,
            'comDet' => $comDet,
            'depDet' => $depDet,
            'desDet' => $desDet,
            'spDet' => $emDet,
            'emYL' => $empYearList,
            'emLL' => $empLevelList
        );

        $empCodeByEmpId=$this->GetEmployeeCodeByEmployeeId($eid)->EmpCode;
        // var_dump($empCodeByEmpId);exit;

        $data['empCodeByEmpId'] = $empCodeByEmpId;
        $data['content'] = $allData;
        // var_dump($data);exit;
        $states=$this->GetStates(array('Id'=>0));
        $data['states']=$states;
        $data['content'] = $allData;

        $this->load->view('base', $data);
    }

    public function InsertUpdatePersonalEmployeeAddressDetails(){
        // var_dump($_POST);
        // $eid =$this->input->post('eid');
            $today = new DateTime();
            $eid = (int) crmDecryptWithParameter($this->input->post('ee'))[0]['eid'];
    
            if ($eid != 0 && $eid != '') :
                $edidd = 0;
                $ent_date = $today->format('c');
                // if ($this->input->post('ef') != null) {
                //     $aData = crmDecryptWithParameter($this->input->post('ef'))[0];
                //     $edidd = $aData['edid'];
                //     $ent_date = $aData['ent_date'];
                // }
                $data = array(
                    "AId" =>$this->input->post('ef') ? $this->input->post('ef') : 0,
                    "EmpId" => $eid,
                    "AddressType" => $this->input->post('AddressType'),
                    "CountryId" => $this->input->post('CountryId'),
                    "StateId" => $this->input->post('StateId'),
                    "DistrictId" => $this->input->post('DistrictId'),
                    "VDCMunId" => $this->input->post('VDCMunId'),
                    "LocalAddress" => $this->input->post('LocalAddress'),
                    "PostalCode" => $this->input->post('postalCode')?$this->input->post('postalCode'):'',
                    "IsActive" => $this->input->post('isactive')? false:true ,
                    "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') :  $this->session->userdata('loggedInUserId'),
                    "EntryDate" =>  $ent_date
                );
                // var_dump($data);exit;
                $url = 'employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $eid);
                $edid = $this-> InsertUpdateEmployeeAddressDetails($data);
                if ($edid > 0) {
                    $session_msg = 'Customer Address Saved';
                    $this->session->set_flashdata('success', $session_msg);
                    //  echo json_encode($data);
                     redirect($url, 'refresh');
                    
                } else {
                    $session_msg = 'Customer Address Not Saved. Something went wrong. Please try again';
                    $this->session->set_flashdata('error', $session_msg);
                }
                // var_dump($url);exit;
                  redirect($url, 'refresh');
            else :
                echo 'id missing';
            endif;
    }

     public function InsertUpdatePersonalEmployeeAddressDetailscustomerreg(){
        // var_dump($_POST);exit;
        $eid =$this->input->post('eid');
        $today = new DateTime();
            $sD = new DateTime($this->input->post('eduStartDate'));
            $cD = new DateTime($this->input->post('eduCompleteDate'));
            $ent_date = $today->format('c');
                $data = array(
                    "AId" => $this->input->post('aid0') ? $this->input->post('aid0') : 0,
                    "EmpId" => $eid,
                    "AddressType" => $this->input->post('AddressType'),
                    "CountryId" => $this->input->post('CountryId'),
                    "StateId" => $this->input->post('StateId'),
                    "DistrictId" => $this->input->post('DistrictId'),
                    "VDCMunId" => $this->input->post('VDCMunId'),
                    "LocalAddress" => $this->input->post('LocalAddress'),
                    "PostalCode" => $this->input->post('postalCode')?$this->input->post('postalCode'):'',
                    "IsActive" => $this->input->post('isactive')? false:true ,
                    "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                    "EntryDate" =>  $ent_date
                );
                $url = 'employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $eid);
                $edid = $this-> InsertUpdateEmployeeAddressDetails($data);
               
                 $data1 = array(
                    "AId" => $this->input->post('aid1') ? $this->input->post('aid1') : 0,
                    "EmpId" => $eid,
                    "AddressType" => $this->input->post('AddressType1'),
                    "CountryId" => $this->input->post('CountryId1'),
                    "StateId" => $this->input->post('StateId1'),
                    "DistrictId" => $this->input->post('DistrictId1'),
                    "VDCMunId" => $this->input->post('VDCMunId1'),
                    "LocalAddress" => $this->input->post('LocalAddress1'),
                    "PostalCode" => $this->input->post('postalCode1')?$this->input->post('postalCode1'):'',
                    "IsActive" => $this->input->post('isactive')? true:false ,
                    "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                    "EntryDate" =>  $ent_date
                );
                $edid1=$this-> InsertUpdateEmployeeAddressDetails($data1);
                $data['success']='success';
                $data['edid']=$edid;
                // var_dump($edid);exit;
                if ($edid > 0 && $edid1 >0) {
                    $session_msg = 'Customer Address Saved';
                    $this->session->set_flashdata('success', $session_msg);
                     echo json_encode($data);
                } else {
                    $session_msg = 'Customer Address Not Saved. Something went wrong. Please try again';
                    $this->session->set_flashdata('error', $session_msg);
                }
    }

    public function ajaxGetInstallment($id){
        $installment =$this->GetInstallmentPaymentByEmpId($id)->EmployeeInstallment;
        echo json_encode($installment);

    }

    public function getClientdetailsByEmployeeId(){
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Type';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/client_list';

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
            'assets/js/employee/client_list.js', 
        );
        $eid='';
        $eId=$_GET['q'];
        if(isset($_GET['q'])){
            $urlparam=crmDecryptUrlParameter()[0];
            $url=crmEncryptUrlParameter('eid='.$urlparam['eid']);
            $eid=$urlparam['eid'];

        }
        if(isset($_GET['desid'])){
            $desId=$_GET['desid'];
        }
        if(isset($_GET['name'])){
            $name=$_GET['name'];
        }

        $data['name']=$name;
        $data['desId']=$desId;
        $AgentListWithinCMO=$this->GetListOfMarketingOfficerWithinCMO($eid)->EmployeeDetails;

        $CustomerListWithinCMO=$this->GetListOfCustomerWithinCMO($eid)->EmployeeDetails;
        $CustomerListWithinMO=$this->GetListOfCustomerWithinMarketingOfficer($eid)->EmployeeDetails;
        $newDet = array();
        foreach ($AgentListWithinCMO as $value) {
            $newDe = array();
            $newDe = (array) $value;
            
            array_push($newDet, $newDe);
        }

        $newCustomerlistFromCMO = array();
        foreach ($CustomerListWithinCMO as $value) {
            $newCustomer = array();
            $newCustomer = (array) $value;
            
            array_push($newCustomerlistFromCMO, $newCustomer);
        }

        $newCustomerlistFromMO = array();
        foreach ($CustomerListWithinMO as $value) {
            $newCustomers = array();
            $newCustomers = (array) $value;
            $newcustomers['eid']=crmEncryptUrlParameter('eid='.$value->EId);
            
            array_push($newCustomerlistFromMO, $newCustomers);
        }

        // $list=json_encode($MOlist);

        $data['Lists']=$newDet;
        $data['customerLists']=$newCustomerlistFromCMO;
        $data['customerListsFromMO']=$newCustomerlistFromMO;
        $data['eId']=$url;
        
        $this->load->view('base', $data);

    }

    public function customerInstallmentPrint(){
        $urlparam=crmDecryptUrlParameter();
        $url=$urlparam[0]['eid'];
        $data['url']=$url;
       
         $this->load->view('employee/print_customer_installment', $data);

    }
    // getcustomerListByMOId
    public function getcustomerListByMOId(){
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Type';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/customer_list';


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
           'assets/js/employee/customer_list.js',
        );

        $eid='';
        $eId=$_GET['q'];
        if(isset($_GET['q'])){
            $urlparam=crmDecryptUrlParameter()[0];
            $url=crmEncryptUrlParameter('eid='.$urlparam['eid']);
            $eid=$urlparam['eid'];
        }
        // if(isset($_GET['desid'])){
        //     $desId=$_GET['desid'];
        //     // echo $desId;die;
        // }
        
        // $data['desId']=$desId;
        $AgentListWithinCMO=$this->GetListOfMarketingOfficerWithinCMO($eid)->EmployeeDetails;
        $CustomerListWithinCMO=$this->GetListOfCustomerWithinCMO($eid)->EmployeeDetails;
        $CustomerListWithinMO=$this->GetListOfCustomerWithinMarketingOfficer($eid)->EmployeeDetails;
        //  var_dump($CustomerListWithinMO);exit;
        $newDet = array();
        foreach ($AgentListWithinCMO as $value) {
            $newDe = array();
            $newDe = (array) $value;
            
            array_push($newDet, $newDe);
        }

        $newCustomerlistFromCMO = array();
        foreach ($CustomerListWithinCMO as $value) {
            $newCustomer = array();
            $newCustomer = (array) $value;
            
            array_push($newCustomerlistFromCMO, $newCustomer);
        }

        $newCustomerlistFromMO = array();
        foreach ($CustomerListWithinMO as $value) {
            $newCustomers = array();
            $newCustomers = (array) $value;
            $newCustomers['urlpram']=crmEncryptUrlParameter('eid='.$value->EId);
            array_push($newCustomerlistFromMO, $newCustomers);
        }

        // $list=json_encode($MOlist);

        $data['Lists']=$newDet;
        $data['customerLists']=$newCustomerlistFromCMO;
        $data['customerListsFromMO']=$newCustomerlistFromMO;
        // var_dump($MOlist);exit;
        
        $data['eId']=$url;
        
        $this->load->view('base', $data);

    }

    public function emp_type(){
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Type';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/emp_type';

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
            'assets/js/employee/emp_type.js', 
        );
        // 
        // var_dump($desDet);exit;
        $comDet = $this->GetCompanyDetails()->CompanyName;
        $da = array(
            "Id" => $comDet[0]->CId,
            "Name" => ''
        );
        $desDet = $this->GetlistOfDesignation($da)->DesignationDetails;
        $data['desDet']=$desDet;
        $this->load->view('base', $data);
    }
    public function ajaxLoadEmployeeType($x){
        $super_agent_name=json_decode($this->GetEmployeeListByDesignation($x,true));
        // var_dump($x);exit;
        $id=array();
        foreach( $super_agent_name->EmpDetail as $empdetail){
            $agent_data=(array)$empdetail;
            $agent_data['urlpram']=crmEncryptUrlParameter('eid='.$empdetail->EId);
            array_push($id,$agent_data);
        }
        // var_dump($id);exit;
        if($super_agent_name){
        echo json_encode($id);
        }
        else{
            echo json_encode($super_agent_name);
        }
       
    }

// public function InsertUpdatePersonalEmployeeAddressDetails(){
//     // var_dump($_POST);exit;
//     $today = new DateTime();
//         $sD = new DateTime($this->input->post('eduStartDate'));
//         $cD = new DateTime($this->input->post('eduCompleteDate'));
//         $eid = (int) crmDecryptWithParameter($this->input->post('ee'))[0]['eid'];

//         if ($eid != 0 && $eid != '') :
//             $edidd = 0;
//             $ent_date = $today->format('c');
//             if ($this->input->post('ef') != null) {
//                 $aData = crmDecryptWithParameter($this->input->post('ef'))[0];
//                 $edidd = $aData['edid'];
//                 $ent_date = $aData['ent_date'];
//             }
//             $data = array(
//                 "AId" => $edidd != null ? (int) $edidd : 0,
//                 "EId" => $eid,
//                 "AddressType" => $this->input->post('AddressType'),
//                 "CountryId" => $this->input->post('CountryId'),
//                 "StateId" => $this->input->post('StateId'),
//                 "DistrictId" => $this->input->post('DistrictId'),
//                 "LocalAddress" => $this->input->post('LocalAddress'),
//                 "PostalCode" => $this->input->post('postalCode')?$this->input->post('postalCode'):'',
//                 "IsActive" => $this->input->post('isactive')? false:true ,
//                 "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
//                 "EntryDate" => $ent_date != null ? $ent_date : $today->format('c'),
//             );
//             // var_dump($data);exit;
//             $url = 'employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $eid);
//             $edid = $this-> InsertUpdateEmployeeAddressDetails($data);
//             // var_dump($edid);exit;
//             if ($edid > 0) {
//                 $session_msg = 'Customer Address Saved';
//                 $this->session->set_flashdata('success', $session_msg);
//                 redirect($url, 'refresh');
//             } else {
//                 $session_msg = 'Customer Address Not Saved. Something went wrong. Please try again';
//                 $this->session->set_flashdata('error', $session_msg);
//             }
//             redirect($url, 'refresh');
//         else :
//             echo 'id missing';
//         endif;
// }

    public function generalInventoryGoodsIn(){ 
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Type';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/general_inventory_goods_in';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );
        
        $data['page']['scripts'] = array(
            // 'assets/jquery/jquery.min.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/employee/general_inventory_goods_in.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            
        );
         $proDet = $this->GetProductDetails('', 0)->productDetails;
        // var_dump($proDet);exit;
        $data['products']=$proDet;
        $this->load->view('base', $data);
    }

    public function generalInventoryGoodsOut(){ 
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Type';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/general_inventory_goods_Out';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );
        
        $data['page']['scripts'] = array(
            // 'assets/jquery/jquery.min.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/daterangepicker-master/daterangepicker.js', 
            'assets/datatable-responsive/js/dataTables.responsive.js',
             'assets/js/employee/general_inventory_goods_Out.js',
            
        );
        $proDet = $this->GetProductDetails('', 0)->productDetails;
        // var_dump($proDet);exit;
        $data['products']=$proDet;
        $this->load->view('base', $data);
    }
    
    public function editGoodsOut(){ 
        if(isset($_GET['q'])){

            $urlParam=crmDecryptUrlParameter()[0]['eid'];
            // var_dump($urlParam);exit;
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Type';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/general_inventory_goods_Out';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );
        
        $data['page']['scripts'] = array(
            // 'assets/jquery/jquery.min.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/employee/general_inventory_goods_out.js',
            
            'assets/datatable-responsive/js/dataTables.responsive.js',
            
        );
        $goodsDet= $this->GetGoodsOutById($urlParam)->GoodsOutDetails;
        $proDet = $this->GetProductDetails('', 0)->productDetails;
        $data['products']=$proDet;
        $data['goodsDet']=$goodsDet;
        //  var_dump($goodsDet);exit;
        $this->load->view('base', $data);
    }


     public function editGoodsIn(){ 

        if(isset($_GET['q'])){

            $urlParam=crmDecryptUrlParameter()[0]['eid'];
            // var_dump($urlParam);exit;
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Type';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/general_inventory_goods_In';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );
        
        $data['page']['scripts'] = array(
            // 'assets/jquery/jquery.min.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/employee/general_inventory_goods_in.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            
        );
        $proDet = $this->GetProductDetails('', 0)->productDetails;
        $goodsDet= $this->GetGoodsInDetailsById($urlParam)->GoodsOutDetails;
        $data['products']=$proDet;
        $data['goodsDet']=$goodsDet;
        //
        $this->load->view('base', $data);
    }

    
    public function InsertUpdateGoodsIn(){
        
        $today = new DateTime();
        // $giDate = new DateTime($this->input->post('GoodsInDate'));
        //  $today->format('c')
        $data = array(
                "GId" =>$this->input->post('GId')?$this->input->post('GId'):0,
                "ProductId" =>$this->input->post('ProductId'),
                "Quantity" => $this->input->post('Quantity'),
                "GoodsInDate" => $this->input->post('GoodsInDate'),
                "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') :   
                            $this->session->userdata('loggedInUserId'),
                "VerifiedBy" => $this->input->post('VerifiedBy'),
                "IsActive" =>$this->input->post('isactive') == 1 ? true : false,
                "Remarks" => $this->input->post('Remarks')  
            );
            //  var_dump($data);
            $edid = $this->InsertUdpateInventoryGoodsIn($data);
            // var_dump($edid);exit;
            $url = 'employee/goodsInListDetails?q=' . crmEncryptUrlParameter('eid=' . $edid);
            // var_dump($edid);exit;
            if ($edid > 0) {
                $session_msg = 'Inventory Goods In Saved';
                $this->session->set_flashdata('success', $session_msg);
                redirect($url, 'refresh');
            } else {
                $session_msg = 'Inventory Goods In Not Saved. Something went wrong. Please try again';
                $this->session->set_flashdata('error', $session_msg);
            }
            redirect($url, 'refresh');
        

    }

    public function InventoryInsertUpdateGoodsOut(){
        
        $today = new DateTime();
        $data = array(
                "OId" =>$this->input->post('OId')?$this->input->post('OId'):0,
                "ProductId" =>$this->input->post('ProductId'),
                "GoodsOutQuantity" => $this->input->post('GoodsOutQuantity'),
                "GoodsOutDate" => $this->input->post('GoodsOutDate'),
                "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') :   
                            $this->session->userdata('loggedInUserId'),
                "ReceivedBy" => $this->input->post('ReceivedBy'),
                "IsActive" =>$this->input->post('isactive') == 1 ? true : false,
                "Remarks" => $this->input->post('Remarks')  
            );
            // var_dump($data);
            $edid = $this->InsertUpdateGoodsOut($data);
            // var_dump($edid);exit;
            $url = 'employee/goodsOutListDetails?q=' . crmEncryptUrlParameter('eid=' . $edid);
            if ($edid > 0) {
                $session_msg = 'Inventory Goods Out Saved';
                $this->session->set_flashdata('success', $session_msg);
                redirect($url, 'refresh');
            } else {
                $session_msg = 'Inventory Goods Out Not Saved. Something went wrong. Please try again';
                $this->session->set_flashdata('error', $session_msg);
            }
            redirect($url, 'refresh');
        

    }

    public function goodsOutListDetails(){
        
        $empid='';
        $emBas='';

        if(isset($_GET['q'])){
            $urlParam=crmDecryptUrlParameter()[0];
            $empid=$urlParam['eid'];
            // var_dump($empid);exit;         
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/inventory_goods_out_list_details';

      $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );
        
        $data['page']['scripts'] = array(
            // 'assets/jquery/jquery.min.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/js/employee/inventory_goods_out_list_details.js',
            
        );
        $goodsDet= $this->GetGoodsOutById($empid)->GoodsOutDetails;
        $data['goodsDet']=$goodsDet;
        $this->load->view('base', $data);
    }

     public function goodsInListDetails(){
        
        $empid='';
        $emBas='';

        if(isset($_GET['q'])){
            $urlParam=crmDecryptUrlParameter()[0];
            $empid=$urlParam['eid'];
            // var_dump($empid);exit;         
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/inventory_goods_in_list_details';

      $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );
        
        $data['page']['scripts'] = array(
            // 'assets/jquery/jquery.min.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/js/employee/inventory_goods_in_list_details.js',
            
        );
        $goodsDet= $this->GetGoodsInDetailsById($empid)->GoodsOutDetails;
        $data['goodsDet']=$goodsDet;
        $this->load->view('base', $data);
    }

    public function goodsInList(){
        
        $empid='';
        $emBas='';

        if(isset($_GET['q'])){
            $urlParam=crmDecryptUrlParameter()[0];
            $empid=$urlParam['eid'];
            // var_dump($empid);exit;         
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/inventory_goods_in_list';

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
              'assets/js/employee/inventory_goods_in_list.js',
        );
        
        $this->load->view('base', $data);
    }

public function viewinstallmentlist(){
        $empid='';
        $emBas='';

        // if(isset($_GET['q'])){
        //     $urlParam=crmDecryptUrlParameter()[0];
        //     $empid=$urlParam['eid'];
        //             
        // }
    //    var_dump('a');exit; 
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/installmentlist';

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
            'assets/js/employee/installmentlist.js', 
        );
      
        $this->load->view('base', $data);
}

public function ajaxGetInstallmentPaymentByDaterange(){
     $daterange=array(
            'from'=>$this->input->post('fromdate'),
            'to'=> $this->input->post('toDate')
        );
    $installmentlist=$this->GetInstallmentPaymentByDaterange('',false,$daterange)->EmployeeInstallment;
    if($installmentlist){
    echo json_encode($installmentlist);
    }
    else{
        echo json_encode($installmentlist);
    }
}
     public function goodsOutList(){
        
        $empid='';
        $emBas='';

        if(isset($_GET['q'])){
            $urlParam=crmDecryptUrlParameter()[0];
            $empid=$urlParam['eid'];
            // var_dump($empid);exit;         
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/inventory_goods_out_list';

      $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );
        
        $data['page']['scripts'] = array(
            // 'assets/jquery/jquery.min.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/employee/inventory_goods_out_list.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            
        );
        $this->load->view('base', $data);
    }

    public function ajaxGetInventoryGoodsInbyDaterange(){
      
        $daterange=array(
            'from'=>$this->input->post('fromdate'),
            'to'=> $this->input->post('toDate')
        );
            // $fromDate = $this->input->post('fromDate');
        $list =$this->GetGoodsInByDateRange('', false,$daterange);
        $list1=array();
        foreach($list->GoodsInDetails as $goodsIn){
            $details=array();
            $details=(array)$goodsIn;
            $details['urlparam']=crmEncryptUrlParameter('eid='.$goodsIn->GId);
            array_push($list1,$details);
        }

        if($list){
            echo json_encode($list1);
        }
        else{
            echo json_encode($list1);
        }
        // echo json_encode($list);
    }

    public function ajaxGetInventoryGoodsOutbyDaterange(){
      
        $daterange=array(
            'from'=>$this->input->post('fromdate'),
            'to'=> $this->input->post('toDate')
        );
            // $fromDate = $this->input->post('fromDate');
        $list =$this->GetGoodsOutByDateRange ('', false,$daterange);
        $list1=array();
        foreach($list->GoodsOutDetails as $goodsIn){
            $details=array();
            $details=(array)$goodsIn;
            $details['urlparam']=crmEncryptUrlParameter('eid='.$goodsIn->OId);
            array_push($list1,$details);
        }

        if($list){
            echo json_encode($list1);
        }
        else{
            echo json_encode($list1);
        }
        // echo json_encode($list);
    }


    public function ajaxGetDistrictsByStateId($id){
        $districtid=$this->GetDistrictsByStateId($id);
        if($districtid){
            echo json_encode($districtid);
        }
        else{
            echo json_encode($districtid);
        }
        
    }

public function ajaxGetMunicipalitiesByDistrictId($id){
    $districtid=$this->GetMunicipalitiesByDistrictId($id);
    if($districtid){
        echo json_encode($districtid);
    }
    else{
        echo json_encode($districtid);
    }
    
}

public function ajaxCheckIfEmployeeCodeAlreadyExist($code){
    $empcode = $this->CheckIfEmployeeCodeAlreadyExist($code)->EmpCode;
    echo json_encode($empcode);
}

    // public function emprofile()
    // {
    //     $allArray = array(
    //         'bas' => [],
    //         'edu' => [],
    //         'exp' => [],
    //         'des' => [],
    //         'ref' => [],
    //         'doc' => [],
    //         'bank' => [],
    //         'sal' => []
    //     );
    //     $eid = '';
    //     if (isset($_GET['q'])) {
    //         $urlParam = crmDecryptUrlParameter()[0];
    //         $eid = $urlParam['eid'];
    //     }
    //     // if ($this->session->userdata('loggedInEmpId') != $eid) {
    //     //     redirect('crmerror/page_not_found', 'refresh');
    //     //     return;
    //     // }
    //     if ($eid != '' && $eid != 0) {
    //         $data = array(
    //             "Id" => $eid,
    //             "Name" => '',
    //         );
    //         $emBas = $this->GetListOfEmployeeDetailsById($data)->EmpDetail;
    //         $newBas = array();
    //         foreach ($emBas as $value) {
    //             $newBa = array();
    //             $newBa = (array) $value;
    //             if ($value->EmpImage != '') {
    //                 $newBa['EmpImage'] = $this->readServiceINI('API')['middleware'] . $value->EmpImage;
    //             }
    //             array_push($newBas, (object)$newBa);
    //         }

    //         $emEdu = $this->GetListOfEmployeeEducationById($data)->EmpDetail;
    //         $emEduDe = array();
    //         foreach ($emEdu as $value) {
    //             $emArr = array();

    //             $eP = 'eid=' . $value->EId . '&ent_date=' . $value->EntryDate . '&edid=' . $value->EdId;

    //             foreach ($value as $val) {
    //                 array_push($emArr, $val);
    //             }
    //             $emArr['allP'] = crmEncryptUrlParameter($eP);
    //             array_push($emEduDe, $emArr);
    //         }

    //         $emExp = $this->GetListOfEmployeeExperienceById($data)->EmpDetail;
    //         $newExp = array();
    //         foreach ($emExp as $value) {
    //             $newEx = array();

    //             $eP = 'eid=' . $value->EId . '&ent_date=' . $value->EntryDate . '&expId=' . $value->ExpId;

    //             foreach ($value as $val) {
    //                 array_push($newEx, $val);
    //             }
    //             $newEx['allP'] = crmEncryptUrlParameter($eP);
    //             array_push($newExp, $newEx);
    //         }

    //         //for details remove when service
    //         $emDes = $this->GetListOfEmployeeDesignationById($data)->EmpDetail;
    //         $newDes = array();
    //         // var_dump($emDes);exit;
    //         foreach ($emDes as $value) {
    //             $f = $this->returnDepartmentName($value->DepartmentId, $value->DesignationId, $value->SupervisorId, $value->ReportingManager);

    //             $eP = 'eid=' . $value->EId . '&ent_date=' . $value->EntryDate . '&edid=' . $value->EdId;

    //             $newDess = array();
    //             foreach ($value as $val) {
    //                 array_push($newDess, $val);
    //             }
    //             $newDess['allP'] = crmEncryptUrlParameter($eP);
    //             $newDess['dep_name'] = $f['dep_name'][0];
    //             $newDess['des_name'] = $f['des_name'][0];
    //             $newDess['sup_name'] = $f['sup_name'][0];
    //             $newDess['rep_name'] = $f['rep_name'][0];
    //             array_push($newDes, $newDess);
    //         }
    //         //for details remove when service

    //         $emRef = $this->GetListOfEmployeeReferenceContactById($data)->EmpDetail;
    //         $newRef = array();
    //         foreach ($emRef as $value) {
    //             $newR = array();
    //             $eP = 'eid=' . $value->EId . '&ent_date=' . $value->EntryDate . '&refId=' . $value->RId;
    //             foreach ($value as $val) {
    //                 array_push($newR, $val);
    //             }
    //             $newR['allP'] = crmEncryptUrlParameter($eP);
    //             array_push($newRef, $newR);
    //         }

    //         $emDoc = $this->GetListOfEmployeeDocumentDetailsById($data)->EmpDetail;
    //         $newDoc = array();
    //         foreach ($emDoc as  $value) {
    //             $newD = array();
    //             $newD = (array) $value;
    //             if ($value->DocumentPath != '' && $value->DocumentPath != null) {
    //                 $newD['DocumentPath'] = $this->readServiceINI('API')['middleware'] . $value->DocumentPath;
    //             }
    //             array_push($newDoc, (object) $newD);
    //         }

    //         $emBank = $this->GetBankDetailsByEmployeeId($eid)->EmpDetail;
    //         $newBank = array();
    //         foreach ($emBank as $value) {
    //             $newEx = array();

    //             $eP = 'eid=' . $value->EmployeeId . '&ent_date=' . $value->EntryDate . '&ebId=' . $value->EBId;
    //             foreach ($value as $val) {
    //                 array_push($newEx, $val);
    //             }
    //             $newEx['allP'] = crmEncryptUrlParameter($eP);
    //             array_push($newBank, $newEx);
    //         }

    //         $emSal = $this->GetEmployeeAssignedSalaryByEmpId('', $eid)->EmpDetail;
    //         $newSal = array();
    //         foreach ($emSal as $value) {
    //             $newS = array();

    //             $eP = 'eid=' . $value->EmployeeId . '&ent_date=' . $value->EntryDate . '&esId=' . $value->ESId;

    //             foreach ($value as $val) {
    //                 array_push($newS, $val);
    //             }
    //             $newS['allP'] = crmEncryptUrlParameter($eP);
    //             array_push($newSal, $newS);
    //         }

    //         $allArray = array(
    //             'bas' => $newBas,
    //             'edu' => $emEduDe,
    //             'exp' => $newExp,
    //             'des' => $newDes,
    //             'ref' => $newRef,
    //             'doc' => $newDoc,
    //             'bank' => $newBank,
    //             'sal' => $newSal
    //         );
    //     }

    //     $data = array('page' => array(), 'content' => array());
    //     $data['page']['title'] = 'Profile';
    //     $data['page']['description'] = '';
    //     $data['page']['headerIcon'] = '';
    //     $data['page']['template'] = 'employee/employee_profiles';

    //     $data['page']['styles'] = array(
    //         'assets/daterangepicker-master/daterangepicker.css',
    //         'assets/select2/select2_3.5.4.css',
    //         'assets/css/fileUpload.css',
    //     );

    //     $data['page']['scripts'] = array(
    //         'assets/daterangepicker-master/daterangepicker.js',
    //         'assets/select2/select2_3.5.4.js',
    //         'assets/js/employee/employee_profile.js',
    //         'assets/js/table_page.js',
    //         'assets/js/employee/employee_sal_cal.js',
    //     );

    //     $comDet = $this->GetCompanyDetails()->CompanyName;
    //     $da = array(
    //         "Id" => $comDet[0]->CId,
    //         "Name" => ''
    //     );
    //     $depDet = $this->GetDepartmentByCompanyId($da)->DepartmentLst;
    //     $desDet = $this->GetlistOfDesignation($da)->DesignationDetails;

    //     $datae = array(
    //         'Id' => 0,
    //         'Name' => ''
    //     );
    //     $emDet = $this->GetListOfEmployeeDetailsById($datae)->EmpDetail;

    //     $empYearList = $this->GetEmployeeyearList([])->EmpYear;
    //     $empLevelList = $this->GetListOfEmployeeLevel([])->EmpLevel;

    //     $allData = array(
    //         'allDet' => $allArray,
    //         'comDet' => $comDet,
    //         'depDet' => $depDet,
    //         'desDet' => $desDet,
    //         'spDet' => $emDet,
    //         'emYL' => $empYearList,
    //         'emLL' => $empLevelList
    //     );

    //     $data['content'] = $allData;

    //     $this->load->view('base', $data);
    // }

        public function ajaxLoadSuperAgentNameById($x){
            
            $super_agent_name=$this->GetEmployeeListByDesignation($x);
            // var_dump($super_agent_name);exit;
            if($super_agent_name){
            echo json_encode($super_agent_name);
        }
        else{
            echo json_encode(array('res'=>'error','result'=>$super_agent_name));
        }
    }

    public function ajaxLoadSuperAgentNameByAgentId($x){
       
        $agent_name=$this->GetSupervisorNameByEmployeeId($x);
        if($agent_name){
            echo json_encode($agent_name);
        }
        else{
            echo json_encode(array('res'=>'error','result'=>$agent_name));
        }
        // var_dump($agent_name);
    }

    public function ajaxLoadEmployeeName($x){
            $emp_name=json_decode($this->GetEmployeeListByDesignation($x,true));

            echo json_encode($emp_name);
    }
    public function insertUpdateExpenseHead(){
        // var_dump($_POST);
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('ExpenseHead', 'Expense Head', 'required');
        $this->form_validation->set_rules('ExpensesDescription', 'Expenses Description', 'required');
        $this->form_validation->set_rules('isactive', 'Employee Isactive', 'required');
        $today = new DateTime();
        if ($this->form_validation->run() == FALSE) {
            redirect('employee/expense_head', 'refresh');
        }else {
      
            $ExId = 0;
            if ($this->input->post('ExId') != null) {
                $ExId = (int)$this->input->post('ExId');
            }
        $data = array(
            "ExId" => $ExId != null ? $ExId : 0,
            "ExpenseHead" => $this->input->post('ExpenseHead') ,
            "ExpensesDescription" => $this->input->post('ExpensesDescription'),
            "IsActive" => $this->input->post('isactive') == 1 ? true : false,
            "UserId" => $this->input->post('userid') ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
            "EntryDate" => $this->input->post('registerdate') != null ? $this->input->post('emp_registerdate') : $today->format('c'),

            // EntryDate
        );
        // var_dump($data);
        $eid = $this-> InsertUpdateExpensesHead($data, true);
        // var_dump($eid);exit;
            $retData['e'] = $eid;
            if ($eid > 0) {
                $session_msg = 'Expense Head Details Saved';
                $this->session->set_flashdata('error', $session_msg);
                if ((int)$this->input->post('ExId') != 0) {
                    $session_msg = 'Expense Head Details Edited';
                    $this->session->set_flashdata('error', $session_msg);
                }
            }
            else{
                $session_msg = 'Expense Head Details Saved';
                $this->session->set_flashdata('error', $session_msg);
            }
         redirect('employee/view_expense_head', 'refresh');
    }
}


 public function expense_head(){
        // var_dump($_POST);exit;
        $empid='';
        $emBas='';

        if(isset($_GET['q'])){
            $urlParam=crmDecryptUrlParameter()[0];
            $empid=$urlParam['eid'];
            // var_dump($empid);exit;         
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/expense_head';

      $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );
        
        $data['page']['scripts'] = array(
            // 'assets/jquery/jquery.min.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/daterangepicker-master/daterangepicker.js',
            // 'assets/js/employee/inventory_goods_in_list.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            
        );
        $this->load->view('base', $data);
        
}


  public function expense_daily(){
        // var_dump($_POST);exit;
        $empid='';
        $emBas='';

        if(isset($_GET['q'])){
            $urlParam=crmDecryptUrlParameter()[0];
            $empid=$urlParam['eid'];
            // var_dump($empid);exit;         
        }
        
        // var_dump($expenseHeadDetails);exit;
        // $data['expenseHeadDetails']=$expenseHeadDetails;
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/expense_daily';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );
        
        $data['page']['scripts'] = array(
            // 'assets/jquery/jquery.min.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/employee/expense_daily.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            
        );
         $data1=array(
            'exId'=>0
        );
        $expenseHeadDetails=$this->GetExpensesHeadDetails($data1)->GetExpensesHead;
        $data['expenseHeadDetails']=$expenseHeadDetails;
       
        $this->load->view('base', $data);
        
}

 public function insertUpdateDailyExpense(){
    //    var_dump($_POST);exit;
       $today=new DateTime();
       $data=array(
                    "TId"=> $this->input->post('TId')? $this->input->post('TId'):0,
                    "ExpensesHead"=> $this->input->post('ExpensesHead'),
                    "ExpensesDesc"=> $this->input->post('ExpensesDesc'),
                    "ExpensesAmount"=> $this->input->post('ExpensesAmount'),
                    "DiscountAmount"=> $this->input->post('DiscountAmount'),
                    "TotalExpenses"=>$this->input->post('TotalExpenses'),
                    "UserId" => $this->input->post('userid') ? $this->input->post('userid') :  
                                $this->session->userdata('loggedInUserId'),
                    "EntryDate"=> $this->input->post('EntryDate') != null ? $this->input->post
                                ('emp_registerdate') : $today->format('c'),
                    "Remarks"=> $this->input->post('Remarks'),
                    "IsActive"=>$this->input->post('isactive') == 1 ? false : true,
                    "ReferenceId"=> $this->input->post('ReferenceId')
       );
        // var_dump($data);exit;
       $dexp= $this->InsertUpdateDailyExpenses($data,true);
         if ($dexp > 0) {
                $session_msg = 'Daily Expense Details Saved';
                $this->session->set_flashdata('error', $session_msg);
                if ((int)$this->input->post('TId') != 0) {
                    $session_msg = 'Daily Expense Details Edited';
                    $this->session->set_flashdata('error', $session_msg);
                }
            }
            else{
                $session_msg = 'Expense Head Details Not Saved';
                $this->session->set_flashdata('error', $session_msg);
            }
         redirect('employee/expense_daily', 'refresh');

       
}

    public function view_expense_head()
        {
        
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Type';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/view_expense_details';

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
            'assets/js/employee/view_expense_details.js', 
        );
        $data1=array(
            'exId'=>0
        );
        $expenseHeadDetails=$this->GetExpensesHeadDetails($data1)->GetExpensesHead;
        // var_dump($expenseHeadDetails);exit;
        $data['expenseHeadDetails']=$expenseHeadDetails;    

        $this->load->view('base', $data);
        }

    public function edit_expense_head()
    {
        $empid='';
        $emBas='';

        if(isset($_GET['q'])){
            $urlParam=crmDecryptUrlParameter()[0];
            $empid=$urlParam['ExId'];
            // var_dump($empid);exit;         
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/expense_head';

      $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );
        
        $data['page']['scripts'] = array(
            // 'assets/jquery/jquery.min.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/daterangepicker-master/daterangepicker.js',
            // 'assets/js/employee/inventory_goods_in_list.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            
        );

        $data1=array(
            'exId'=>$empid
        );
        $expenseHeadDetails=$this->GetExpensesHeadDetails($data1)->GetExpensesHead;
        // var_dump($expenseHeadDetails);exit;
        $data['expenseHeadDetails']=$expenseHeadDetails;  

        $this->load->view('base', $data);
    }

    public function edit_daily_expenses()
    {
        $empid='';
        $emBas='';

        if(isset($_GET['q'])){
            $urlParam=crmDecryptUrlParameter()[0];
            $empid=$urlParam['eid'];
            // var_dump($empid);exit;         
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/expense_daily';

      $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );
        
        $data['page']['scripts'] = array(
            // 'assets/jquery/jquery.min.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/daterangepicker-master/daterangepicker.js',
            // 'assets/js/employee/inventory_goods_in_list.js',
            'assets/js/employee/expense_daily.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            
        );
        $data1=array(
            'exId'=>0
        );
        $expenseHeadDetails=$this->GetExpensesHeadDetails($data1)->GetExpensesHead;
        $data['expenseHeadDetails']=$expenseHeadDetails;
        // var_dump($expenseHeadDetails);
        $data2=array(
            'expenseId'=>$empid
        );
        $expensedailyDetails=$this->GetExpensesDetailsByExpenseId($data2)->GetExpensesHead;
        // var_dump($expensedailyDetails);exit;
        $data['expensedailyDetails']=$expensedailyDetails;  

        $this->load->view('base', $data);
    }

    public function view_expense_daily()
        {
        
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Type';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/view_daily_expense_details';

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
            'assets/js/employee/view_daily_expense_details.js', 
        );
        $data1=array(
            'exId'=>0
        );
        $expenseHeadDetails=$this->GetExpensesHeadDetails($data1)->GetExpensesHead;
        $data['expenseHeadDetails']=$expenseHeadDetails;    

        $this->load->view('base', $data);
     }


     
    public function ajaxGetExpensesDetailsByDateRange()
    {
        $daterange=array(
            'from'=>$this->input->post('fromDate'),
            'to'=>$this->input->post('toDate'),
        );
        $list =$this->GetExpensesDetailsByDateRange ('', false,$daterange);
        // var_dump($list);exit;
        $list1=array();
        foreach($list->GetExpenseDetails as $ExpenseDetails){
            $details=array();
            $details=(array)$ExpenseDetails;
            $details['urlparam']=crmEncryptUrlParameter('eid='.$ExpenseDetails->TId);
            array_push($list1,$details);
        }

        if($list){
            echo json_encode($list1);
        }
        else{
            echo json_encode($list1);
        }
    }
    public function insertUpdateEmployeePersonalDetails()
    {
        // var_dump($_POST);
        $eid=$this->input->post('eid');
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        // $this->form_validation->set_rules('emp_code', 'Employee Code', 'required');
        // $this->form_validation->set_rules('emp_dob', 'Employee Birth', 'required');
        $this->form_validation->set_rules('emp_gender', 'Employee Gender', 'required');
        $this->form_validation->set_rules('emp_nationality', 'Employee Nationality', 'required');
        // $this->form_validation->set_rules('emp_ethinicity', 'Employee Ethinicity', 'required');
        $this->form_validation->set_rules('emp_idno', 'Employee Id', 'required');
        $this->form_validation->set_rules('emp_idtype', 'Employee Id Type', 'required');
        $this->form_validation->set_rules('isactive', 'Employee Isactive', 'required');
        $this->form_validation->set_rules('emp_mobileno', 'Employee Mobile No', 'required');

        $today = new DateTime();
        // var_dump($today);exit;
        $full_name = $this->input->post('emp_full_name');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode('sdfsd');
            redirect('employee/em_register', 'refresh');
        } else {
           // var_dump($eid);exit;
            $englishDob= $this->input->post('emp_dob');
            $date=date('Y-m-d');
            $ent_date=$today->format('c');
            $data = array(
                "EId" => $this->input->post('eid')?$this->input->post('eid'):0,
                "EmpCode" => $this->input->post('emp_code')?$this->input->post('emp_code'):'0',
                "EmployeeName" => $full_name,
                "EmployeeAddress" => $this->input->post('emp_address')? $this->input->post('emp_address'):'0',
                "EmployeeNationality" => $this->input->post('emp_nationality'),
                "EmployeeDOB" =>$date,
                "EmployeeGender" => $this->input->post('emp_gender'),
                "EmployeeEthinicity" => $this->input->post('emp_ethinicity'),
                "EmployeeMobileNumber" => $this->input->post('emp_mobileno'),
                "EmployeeContactNumber" => $this->input->post('emp_contactno'),
                "EmployeeEmailId" => $this->input->post('emp_email'),
                "EmployeeIdentificationNumber" => $this->input->post('emp_idno'),
                "EmployeeIdentificationType" => $this->input->post('emp_idtype'),
                "RegisterDate" => $this->input->post('emp_registerdate') != null ? $this->input->post('emp_registerdate') : $today->format('c'),
                "UserId" => $this->input->post('userid') ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                "IsActive" => $this->input->post('isactive') == 1 ? true : false,
                "NepaliDOB" =>$englishDob,
                "EntryNepaliDate" => $englishDob,
                "EmpImage" => $this->input->post('emp_image') != null ? $this->input->post('emp_image') : '',
            );
            
            //   var_dump($data);exit;
            $eid = $this->insertUpdateEmployeePersonalDetail($data, true);
           // var_dump($data);
            //var_dump($eid);exit;
            // $sD = new DateTime($this->input->post('eduStartDate'));
            // $cD = new DateTime($this->input->post('eduCompleteDate'));
            // $eid = (int) crmDecryptWithParameter($this->input->post('ee'))[0]['eid'];
    
                // $data = array(
                //     "AId" => $this->input->post('ef') ? $this->input->post('ef') : 0,
                //     "EmpId" => $eid,
                //     "AddressType" => $this->input->post('AddressType'),
                //     "CountryId" => $this->input->post('CountryId'),
                //     "StateId" => $this->input->post('StateId'),
                //     "DistrictId" => $this->input->post('DistrictId'),
                //     "VDCMunId" => $this->input->post('VDCMunId'),
                //     "LocalAddress" => $this->input->post('LocalAddress'),
                //     "PostalCode" => $this->input->post('postalCode')?$this->input->post('postalCode'):'',
                //     "IsActive" => $this->input->post('isactive')? true:false ,
                //     "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                //     "EntryDate" =>  $ent_date
                // );
                // var_dump($data);exit;
                // $url = 'employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $eid);
                // $edid = $this-> InsertUpdateEmployeeAddressDetails($data);

                // $data = array(
                //     "AId" => $this->input->post('ef') ? $this->input->post('ef') : 0,
                //     "EmpId" => $eid,
                //     "AddressType" => $this->input->post('AddressType1'),
                //     "CountryId" => $this->input->post('CountryId1'),
                //     "StateId" => $this->input->post('StateId1'),
                //     "DistrictId" => $this->input->post('DistrictId1'),
                //     "VDCMunId" => $this->input->post('VDCMunId1'),
                //     "LocalAddress" => $this->input->post('LocalAddress1'),
                //     "PostalCode" => $this->input->post('postalCode1')?$this->input->post('postalCode1'):'',
                //     "IsActive" => $this->input->post('isactive')? true:false ,
                //     "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                //     "EntryDate" =>  $ent_date
                //     // InsertUpdateEmployeeAddressDetails
                // );
                // var_dump($data);exit;
                // $url = 'employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $eid);
                // $edid = $this-> InsertUpdateEmployeeAddressDetails($data);


                //For Nominee
                
                // $data = array(
                //     "RId" => $this->input->post('ef')? $this->input->post('ef'): 0,
                //     "EId" => $eid,
                //     "RName" => $this->input->post('rname'),
                //     "RelationShip" => $this->input->post('relation'),
                //     "HomePhone" => $this->input->post('homePhone'),
                //     "MobilePhone" => $this->input->post('mobilePhone'),
                //     "OfficePhone" => $this->input->post('officePhone'),
                //     "Designation" => $this->input->post('Designation'),
                //     "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                //     "EntryDate" => $ent_date != null ? $ent_date : $today->format('c'),
                // );
    
                // $url = 'employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $eid);
    
            $rid = $this->InsertUpdateReferenceContact($data);
            $retData['e'] = $eid;

            if ($eid > 0) {
                $session_msg = 'Employee Details Saved';
                if ((int)$this->input->post('eid') != 0) {
                    $session_msg = 'Employee Details Edited';
                }
                $this->session->set_flashdata('success', $session_msg);
                $retData['uP'] = crmEncryptUrlParameter('eid=' . $eid);
                $retData['rs'] = $session_msg;
                $retData['empcode'] = $eid;
                $retData['success']="Success";
                echo json_encode($retData);
            } else {
                $session_msg = 'Employee Details Not Saved. Something went wrong. Please try again';
                $this->session->set_flashdata('error', $session_msg);
                echo json_encode($retData);
            }
        }
    }

    public function installment_payment(){
        

        $comDet = $this->GetCompanyDetails()->CompanyName;
        $da = array(
            "Id" => $comDet[0]->CId,
            "Name" => ''
        );
        $empid='';
        $emBas='';
        if(isset($_GET['q'])){
            $urlParam=crmDecryptUrlParameter()[0];
            $empid=$urlParam['eid'];
            // var_dump($empid);exit; 
        
        }
        
             $data = array(
                "Id" => $empid,
                "Name" => '',
            );
         $emBas = $this->GetListOfEmployeeDetailsById($data)->EmpDetail;
        //  var_dump($emBas);exit; 
        $desDet = $this->GetlistOfDesignation($da)->DesignationDetails;
        // var_dump($desDet);exit;
      
        // $data['employeeDetails']=$emBas;

        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/installment_payment';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/select2/select2.min.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/js/employee/installment_payment.js',
            'assets/select2/select2.full.min.js'
        );
        $data['desDet']=$desDet;
        $eth = $this->hardCodeEthnicity();
        $ide = $this->hardCodedIde();
        $states=$this->GetStates(array('Id'=>0));
        $data['states'] = $states;
        $data['ethinic'] = $eth;
        $data['ide'] = $ide;
        $data['employeeDetails'] = $emBas;

        $this->load->view('base', $data);

    }

    public function remainingGoodsInOut(){
         $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/remaining_goodsinout';

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
            'assets/js/employee/remaining_goodsinout.js'
        );
        
        $this->load->view('base', $data);

    }

    public function ajaxGetRemainingGoodsInOut(){
        // var_dump($_POST);exit;
        $data=array(
            'fromDate'=>$this->input->post('fromdate'),
            'toDate'=>$this->input->post('toDate')
        );
        $remainingGoodsInOut=$this->GetGoodsRemainingReportByDate('',false,$data)->GoodsRemaining;
        echo json_encode($remainingGoodsInOut);
    }
    public function insertUpdateInstallmentPayment(){
        // var_dump($_POST);
        $today=new DateTime;
        $ent_date = $today->format('c');

        $employeeId=$this->input->post('eid');
        $empId=(int) crmDecryptWithParameter($this->input->post('eid'))[0]['eid'];
       $eid=$empId;
            // crmDecryptUrlParameter

        $data=array(

            "MId"=>$this->input->post('MId')? $this->input->post('MId'):0 ,
            "EmpId"=> $this->input->post('EmpId')? $this->input->post('EmpId'):$empId,
            "InstallmentType"=> $this->input->post('InstallmentType'),
            "PaidAmount"=>$this->input->post('PaidAmount'),
            "UserId"=> $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
            "EntryDate"=> $ent_date ,
            "IsActive"=> $this->input->post('IsActive')? false:true,
            "Remarks"=> $this->input->post('Remarks'),
        );
       
        $inid=$this->InsertUpdateMonthlyInstallment($data);
        //   var_dump($inid);exit;  
        $empDet = $this->GetListOfEmployeeDetailsById(array("Id" => $eid, "Name" => ''));
        $empVal = $empDet->EmpDetail; 
        // var_dump($empVal);exit;
        $url = 'employee/getListofMonthlyInstallmentPayment?q=' . crmEncryptUrlParameter('eid=' . $empId).'&name='.$empVal[0]->EmployeeName;
        if ($inid > 0){
            // var_dump($installment_payment);exit;
            $session_msg = 'Payment Installment Saved';
            $session_data=$this->session->set_flashdata('success', $session_msg);
        } else {
            $session_msg = 'Payment Installment Not Saved. Something went wrong. Please try again';
            $session_data=$this->session->set_flashdata('error', $session_msg);
        }

        redirect($url,$session_data,'refresh');
    }


    public function commissionList(){
         $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/commissionList';

         $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
            'assets/datatable/buttons/css/buttons.dataTables.min.css'
        );
        
        $data['page']['scripts'] = array(
            // 'assets/jquery/jquery.min.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatables_net-buttons/js/buttons.html5.min.js', 
            'assets/datatable/JSZip/jszip.min.js',
            'assets/datatable/buttons/js/buttons.print.min.js',
             'assets/datatable/buttons/js/dataTables.buttons.min.js',
            'assets/js/employee/commissionList.js', 
        );

        $this->load->view('base', $data);

}    

public function commissionsummaryList(){
         $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/commissionsummarylist';

         $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
            'assets/datatable/buttons/css/buttons.dataTables.min.css'
        );
        
        $data['page']['scripts'] = array(
            // 'assets/jquery/jquery.min.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatables_net-buttons/js/buttons.html5.min.js', 
            'assets/datatable/JSZip/jszip.min.js',
            'assets/datatable/buttons/js/buttons.print.min.js',
             'assets/datatable/buttons/js/dataTables.buttons.min.js',
            'assets/js/employee/commissionsummaryList.js', 
        );

        $this->load->view('base', $data);

} 

public function getcommissionlist(){
        // var_dump($_POST);exit;
        $data1=array(
            'fromDate'=>$this->input->post('fromDate'),
            'toDate'=>$this->input->post('fromDate'),
            'cmoId'=>$this->input->post('empTypeId'),
            'moId'=>$this->input->post('empId'),
        );
        $commissionList=$this->GetMonthlyCommissionDetailsOfAgentsByDateAndId('',false,$data1)->CommissionDetails;
        // var_dump($commissionList);exit;
        echo json_encode($commissionList);
}

public function getcommissionsummarylist(){
        // var_dump($_POST);exit;
        $data1=array(
            'fromDate'=>$this->input->post('fromDate'),
            'toDate'=>$this->input->post('toDate'),
            'cmoId'=>$this->input->post('empTypeId'),
            'moId'=>$this->input->post('empId'),
        );
        $commissionList=$this->
        GetDateWiseCommissionOfCMOAndMO('',false,$data1)->GetDateWiseCommissionOfCMOAndMO;
        // var_dump($commissionList);exit;
        echo json_encode($commissionList);
}


public function getListofMonthlyInstallmentPayment(){

        if(isset($_GET['q'])){
            $urlParam=crmDecryptUrlParameter()[0];
            $empId=$urlParam['eid'];
            // var_dump($empId);exit;
        }
        if(isset($_GET['name'])){
          
            $name=$_GET['name'];
            //  var_dump($name);exit;
        }
        
        $installment =$this->GetInstallmentPaymentByEmpId($empId)->EmployeeInstallment;
        // var_dump($installment);exit;
         $data = array(
                "Id" => $empId,
                "Name" => '',
            );
            $emBas = $this->GetListOfEmployeeDetailsById($data)->EmpDetail;
            $emName=$emBas[0]->EmployeeName;
            // var_dump($emBas);exit;
            $newInstallment = array();
            foreach ($installment as $value) {
                $newBa = array();
                $newBa = (array) $value;
                $newBa['EmployeeName']= $emName;
                array_push($newInstallment, (object)$newBa);
            }
        // var_dump($newInstallment);exit;

        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Customer';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/installment_payment_list';
        
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
               'assets/datatable/buttons/js/buttons.print.min.js', 
            'assets/datatable/pdfmake/pdfmake.min.js',
            'assets/datatable/JSZip/jszip.min.js',
             'assets/js/employee/installment_payment_list.js' 
        );
        $comDet = $this->GetCompanyDetails()->CompanyName;
        $da = array(
            "Id" => $comDet[0]->CId,
            "Name" => ''
        );
        $desDet = $this->GetlistOfDesignation($da)->DesignationDetails;
        // var_dump($desDet);exit;
           
        $data['name']=$name;
        $data['desDet']=$desDet;
        $eth = $this->hardCodeEthnicity();
        $ide = $this->hardCodedIde();
        $states=$this->GetStates(array('Id'=>0));
        $data['states'] = $states;
        $data['ethinic'] = $eth;
        $data['ide'] = $ide;
        $data['installmentlist'] = $newInstallment;
        $this->load->view('base', $data);
    }

    public function insertUpdateAddressDetail()
    {
        $today = new DateTime();
        $sD = new DateTime($this->input->post('eduStartDate'));
        $cD = new DateTime($this->input->post('eduCompleteDate'));
        $eid = (int) crmDecryptWithParameter($this->input->post('ee'))[0]['eid'];

        if ($eid != 0 && $eid != '') :
            $edidd = 0;
            $ent_date = $today->format('c');
            if ($this->input->post('ef') != null) {
                $aData = crmDecryptWithParameter($this->input->post('ef'))[0];
                $edidd = $aData['edid'];
                $ent_date = $aData['ent_date'];
            }
            $data = array(
                "EdId" => $edidd != null ? (int) $edidd : 0,
                "EId" => $eid,
                "Qualification" => $this->input->post('qualification'),
                "Institution" => $this->input->post('institution'),
                "StartDate" => $sD->format('c'),
                "CompletionDate" => $cD->format('c'),
                "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                "EntryDate" => $ent_date != null ? $ent_date : $today->format('c'),
            );

            $url = 'employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $eid);
            $edid = $this->InsertUpdateEducationDetails($data);
            if ($edid > 0) {
                $session_msg = 'Employee Education Saved';
                $this->session->set_flashdata('success', $session_msg);
                redirect($url, 'refresh');
            } else {
                $session_msg = 'Employee Education Not Saved. Something went wrong. Please try again';
                $this->session->set_flashdata('error', $session_msg);
            }
            redirect($url, 'refresh');
        else :
            echo 'id missing';
        endif;
    }

    public function insertUpdateEducationDetail()
    {
        $today = new DateTime();
        $sD = new DateTime($this->input->post('eduStartDate'));
        $cD = new DateTime($this->input->post('eduCompleteDate'));
        $eid = (int) crmDecryptWithParameter($this->input->post('ee'))[0]['eid'];

        if ($eid != 0 && $eid != '') :
            $edidd = 0;
            $ent_date = $today->format('c');
            if ($this->input->post('ef') != null) {
                $aData = crmDecryptWithParameter($this->input->post('ef'))[0];
                $edidd = $aData['edid'];
                $ent_date = $aData['ent_date'];
            }
            $data = array(
                "EdId" => $edidd != null ? (int) $edidd : 0,
                "EId" => $eid,
                "Qualification" => $this->input->post('qualification'),
                "Institution" => $this->input->post('institution'),
                "StartDate" => $sD->format('c'),
                "CompletionDate" => $cD->format('c'),
                "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                "EntryDate" => $ent_date != null ? $ent_date : $today->format('c'),
            );

            $url = 'employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $eid);
            $edid = $this->InsertUpdateEducationDetails($data);
            if ($edid > 0) {
                $session_msg = 'Employee Education Saved';
                $this->session->set_flashdata('success', $session_msg);
                redirect($url, 'refresh');
            } else {
                $session_msg = 'Employee Education Not Saved. Something went wrong. Please try again';
                $this->session->set_flashdata('error', $session_msg);
            }
            redirect($url, 'refresh');
        else :
            echo 'id missing';
        endif;
    }

    public function insertUpdateEmployeeDes()
    {
        // var_dump($_POST);
        $today = new DateTime();
        $eid = (int) crmDecryptWithParameter($this->input->post('eje'))[0]['eid'];
        $supervisorId=$this->input->post('supervisorId');
        $reportingManager=$this->input->post('reportingManager');
       
        $Designation_id=$this->input->post('designationId');
        if($Designation_id ==3){ 
           
            $position='Marketing Officer';
        }
        elseif($Designation_id ==2){
          
             $position='Chief Marketing Officer';
        }
        else{
            $position='Customer';
        }

        if ($eid != 0 && $eid != '') :
            $edidd = 0;
            $ent_date = $today->format('c');
            if ($this->input->post('ejf') != null) {
                $aData = crmDecryptWithParameter($this->input->post('ejf'))[0];
                $edidd = $aData['edid'];
                $ent_date = $aData['ent_date'];
            }

            $data = array(
                "EdId" => $edidd != null ? $edidd : 0,
                "EId" => $eid,
                "CompanyId" => $this->input->post('companyId')? $this->input->post('companyId'):'1',
                "DepartmentId" => $this->input->post('departmentId')? $this->input->post('departmentId'):'1',
                "DesignationId" => $this->input->post('designationId'),
                "Position" => $this->input->post('position')?$this->input->post('position'):'0',
                "SupervisorId" => $this->input->post('supervisorId') ? $this->input->post('supervisorId'):'0',
                "ReportingManager" => $reportingManager,
                "BasicSalary" => $this->input->post('basicSalary') != null ? $this->input->post('basicSalary') : '0',
                "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                "IsActive" => (int)$this->input->post('isactive') == 1 ? true : false,
                "EntryDate" => $ent_date != null ? $ent_date : $today->format('c'),
                "YearId" => $this->input->post('yearDetails')?$this->input->post('yearDetails'):'1',
                "LevelId" => $this->input->post('levelDetails')?$this->input->post('levelDetails'):'1',
            );
            // var_dump($data);exit;
            $url = 'employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $eid);


            $edid = $this->InsertUpdateEmployeeDesignation($data);
            // var_dump($edid);exit;
            if ($edid > 0) {
                $session_msg = 'Employee Designation Saved';
                $this->session->set_flashdata('success', $session_msg);
                // echo $edid;
            } else {
                $session_msg = 'Employee Designation Not Saved. Something went wrong. Please try again';
                $this->session->set_flashdata('error', $session_msg);
                // echo $edid;
            }
            redirect($url, 'refresh');
        else :
            echo 'id missing';
        endif;
    }

    public function insertUpdateExperience()
    {
        $today = new DateTime();
        $eid = (int) crmDecryptWithParameter($this->input->post('exe'))[0]['eid'];

        if ($eid != 0 && $eid != '') :
            $expidd = 0;
            $ent_date = $today->format('c');
            if ($this->input->post('exf') != null) {
                $aData = crmDecryptWithParameter($this->input->post('exf'))[0];
                $expidd = (int)$aData['expId'];
                $ent_date = $aData['ent_date'];
            }
            $data = array(
                "ExpId" => $expidd != null ? $expidd : 0,
                "EId" => $eid,
                "Skills" => $this->input->post('skills'),
                "Experiences" => $this->input->post('experiences'),
                "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                "EntryDate" => $ent_date != null ? $ent_date : $today->format('c'),
            );

            $url = 'employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $eid);

            $exid = $this->InsertUpdateExperiences($data);
            if ($exid > 0) {
                $session_msg = 'Employee Experiences Saved';
                $this->session->set_flashdata('success', $session_msg);
                // echo $exid;
            } else {
                $session_msg = 'Employee Experiences Not Saved. Something went wrong. Please try again';
                $this->session->set_flashdata('error', $session_msg);
                // echo $exid;
            }
            redirect($url, 'refresh');
        else :
            echo 'id missing';
        endif;
    }

    public function insertUpdateReferenceCon()
    {
        // var_dump($_POST);exit;
        $today = new DateTime();
        $eid=$this->input->post('eid');
        $conidd=$this->input->post('rid');
        if($eid==''){
             $eid = (int) crmDecryptWithParameter($this->input->post('ece'))[0]['eid'];
        }
        if ($eid != 0 && $eid != '') :
            // $conidd = 0;
            $ent_date = $today->format('c');

            if ($this->input->post('ecf') != null) {
                $aData = crmDecryptWithParameter($this->input->post('ecf'))[0];
                $conidd = (int)$aData['refId'];
                $ent_date = $aData['ent_date'];
            }
            // var_dump($conidd);exit;
            $data = array(
                "RId" => $conidd != null ? $conidd : 0,
                "EId" => $eid,
                "RName" => $this->input->post('rname'),
                "RelationShip" => $this->input->post('relation'),
                "HomePhone" => $this->input->post('homePhone'),
                "MobilePhone" => $this->input->post('mobilePhone'),
                "OfficePhone" => $this->input->post('officePhone'),
                "Designation" => $this->input->post('Designation'),
                "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                "EntryDate" => $ent_date != null ? $ent_date : $today->format('c'),
            );

            $url = 'employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $eid);

            $rid = $this->InsertUpdateReferenceContact($data);
            $data['rid']=$rid;
            $data['success']='success';
            $data['url']=$url;
            if ($rid > 0) {
                $session_msg = 'Employee Reference Saved';
                $this->session->set_flashdata('success', $session_msg);
                // echo $rid;
                echo json_encode($data);
            } else {
                $session_msg = 'Employee Reference Not Saved. Something went wrong. Please try again';
                $this->session->set_flashdata('error', $session_msg);
                // echo $rid;
            }
            // redirect($url, 'refresh');
        else :
            echo 'id missing';
        endif;
    }

    public function insertUpdateEmployeeDocument()
    {
        $today = new DateTime();
        $eid = (int) crmDecryptWithParameter($this->input->post('edo'))[0]['eid'];
        $ddid = $this->input->post('did');
        if ($ddid != null) {
            $ddid = (int)crmDecryptWithParameter($ddid)[0]['did'];
            // var_dump($ddid);exit;
        }
        if ($eid != 0 && $eid != '') :
            $data = array(
                "DId" => $ddid != null ? $ddid : 0,
                "DocumentType" => $this->input->post('doc_type'),
                "DocumentName" => $this->input->post('doc_name'),
                "DocumentPath" => $this->input->post('document_attachment'),
                "UserId" => $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
                "EntryDate" => $this->input->post('ent_date') != null ? $this->input->post('ent_date') : $today->format('c'),
                "EmpId" => $eid,
            );

            // $did = 1;
            $did = $this->InsertUpdateEmployeeDocuments($data);
            if ($did > 0) {
                $session_msg = 'Employee Documents Saved';
                $this->session->set_flashdata('success', $session_msg);
                // $url = 'employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $eid);
                // redirect($url, 'refresh');
                $encData = crmEncryptUrlParameter('did=' . $did);
                echo json_encode(['did' => $encData, 'e' => $did]);
            } else {
                $session_msg = 'Employee Documents Not Saved. Something went wrong. Please try again';
                $this->session->set_flashdata('error', $session_msg);
                // $url = 'employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $eid);
                // redirect($url, 'refresh');
                echo json_encode(['did' => 0, 'e' => 0]);
            }
        else :
            echo 'id missing';
        endif;
    }

    public function insertUpdateBankDetails()
    {
        $today = new DateTime();
        $eid = (int) crmDecryptWithParameter($this->input->post('ebi'))[0]['eid'];
        $bbi = $this->input->post('bbi');

        $ebbid = null;
        $ent_date = null;

        if ($bbi != null) {
            $fullData = crmDecryptWithParameter($bbi)[0];
            $eid = $fullData['eid'];
            $ebbid = $fullData['ebId'];
            $ent_date = $fullData['ent_date'];
        }

        if ($eid != 0 && $eid != '') :
            $data = array(
                "EBId" => $ebbid ?? 0,
                "EmployeeId" => $eid,
                "BankName" => $this->input->post('bank_name'),
                "BankLocation" => $this->input->post('bank_branch'),
                "BankAccountNumber" => $this->input->post('bank_account_no'),
                "UserId" => $this->input->post('userid') ?? $this->session->userdata('loggedInUserId'),
                "EntryDate" => $ent_date ?? $today->format('c'),
                "IsActive" => $this->input->post('bank_isactive') != null ? true : false,
            );

            $ebid = $this->InsertUpdateEmployeeBankDetails($data);
            if ($ebid > 0) {
                $session_msg = 'Employee Bank Details Saved Successfull';
                $this->session->set_flashdata('success', $session_msg);
            } else {
                $session_msg = 'Employee Bank Details Not Saved. Something went wrong. Please try again';
                $this->session->set_flashdata('error', $session_msg);
            }
            $url = 'employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $eid);
            redirect($url, 'refresh');

        endif;
    }

    public function getBankDetailsByEmpId()
    {
        $empId = '';
        $empList = $this->GetBankDetailsByEmployeeId($empId);
        return $empList;
    }

    // public function crystal() {
    //     $this->load->view('employee/cry2');
    // }

    public function returnDepartmentName($depId, $desId, $supId, $repId)
    {
        $colData = array(
            'com_name' => array(),
            'dep_name' => array(),
            'des_name' => array(),
            'sup_name' => array(),
            'rep_name' => array()
        );
        $comDet = $this->GetCompanyDetails()->CompanyName;
        $da = array(
            "Id" => $comDet[0]->CId,
            "Name" => ''
        );
        array_push($colData['com_name'], $comDet[0]->CompanyName);
        $depDet = $this->GetDepartmentByCompanyId($da)->DepartmentLst;
        $desDet = $this->GetlistOfDesignation($da)->DesignationDetails;
        foreach ($depDet as $value) {
            if ($value->DId == $depId) {
                array_push($colData['dep_name'], $value->DepartmentName);
            }
        }
        foreach ($desDet as $value) {
            if ($value->DId == $desId) {
                array_push($colData['des_name'], $value->Designation);
            }
        }
        $spDet = $this->GetListOfEmployeeDetailsById(array('Id' => 0, 'Name' => ''))->EmpDetail;
        foreach ($spDet as $value) {
            if ($value->EId == $supId) {
                array_push($colData['sup_name'], $value->EmployeeName);
            }

            if ($value->EId == $repId) {
                array_push($colData['rep_name'], $value->EmployeeName);
            }
        }
        return $colData;
    }

    public function AjaxUploadEmpImage()
    {
        $attachFile = $_FILES['emp_image'];
        $eid = 0;
        if ($_POST['eid'] != null) {
            $eid = (int) crmDecryptWithParameter($_POST['eid'])[0]['eid'];
        }
        // var_dump($eid);exit;
        // if(empty($attachFile)){

        if ($_FILES['emp_image']['name'] == '') {
            echo json_encode(['error' => 'No files are available']);
            return;
        }
        if ($eid != 0 && $eid != '') {
            $data = array(
                'empid' => $eid,
                'image' => 'Employee Image',
                '' => new cURLFile(
                    $attachFile['tmp_name'],
                    $attachFile['type'],
                    $attachFile['name']
                ),
            );
            // var_dump($data);exit;
            // echo '{"filename":"/UploadeFiles/1/1_02032021162759.png"}';
            // exit;
            $upFile = $this->uploadEmpImg($data, true);
            echo $upFile;
        } else {
            echo json_encode(['error' => 'No Id Available']);
        }
    }

    //for document use rx 
    public function AjaxUploadDocument()
    {
        $attachFile = $_FILES['document_attachment'];
        $did = crmDecryptWithParameter($_POST['did'])[0]['did'];

        // if(empty($attachFile)){
        if ($_FILES['document_attachment']['name'] == '') {
            echo json_encode(['error' => 'No files are available']);
            return;
        }
        if ($did != 0 && $did != '') {

            $data = array(
                'did' => $did,
                'filename' => 'Employee Document',
                '' => new cURLFile(
                    $attachFile['tmp_name'],
                    $attachFile['type'],
                    $attachFile['name']
                ),
            );
            // echo '{"filename":"/UploadeFiles/1/1_02032021162759.png"}';
            // exit;
            $upFile = json_decode($this->uploadAttachment($data, true));
            // $upFile->type = $attachFile['type'];
            echo json_encode($upFile);
        } else {
            echo json_encode(['error' => 'No Document Id']);
        }
    }

    public function copper()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Employee Register';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'employee/image_with';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/css/fileUpload.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/js/employee/tester2.js',
            // 'assets/js/employee/employee_profile_withimage.js',
        );

        $this->load->view('base', $data);
    }

    public function insertUpdateSalaryLookup()
    {
        $today = new DateTime();
        $ent_date = $today->format('c');
        $eid = (int) crmDecryptWithParameter($this->input->post('sbi'))[0]['eid'];
        $allP = $this->input->post('ssbi');
        $easid = null;
        if ($allP != null) {
            $dec = crmDecryptWithParameter($allP);
            $easid = (int)$dec[0]['esId'];
            $ent_date = $dec[0]['ent_date'];
        }
        $data = array(
            "ESId" => $easid ?? 0,
            "EmployeeId" => $eid,
            "Maritalstatus" => (int)$this->input->post('marital_stat'),
            "BasicSalary" => (float) $this->input->post('basic_salary') ?? 0,
            "FestivalBonus" => (float) $this->input->post('festival_bonus') ?? 0,
            "Allowance" => (float) $this->input->post('allowance') ?? 0,
            "Others" => (float) $this->input->post('others') ?? 0,
            "ProvidentFund" => (float) $this->input->post('provident_fund') ?? 0,
            "CitizenInvestmentTrust" => (float) $this->input->post('citizen_investment') ?? 0,
            "Insurane" => (float) $this->input->post('insurance') ?? 0,
            "OtherFund" => (float) $this->input->post('other_fund') ?? 0,
            "TDS" => (float) $this->input->post('tds') ?? 0,
            "TotalPayable" => (float) $this->input->post('total_payable') ?? 0,
            "UserId" => $this->input->post('userid') ?? $this->session->userdata('loggedInUserId'),
            "EntryDate" => $ent_date ?? $today->format('c'),
            "IsActive" => $this->input->post('sal_isactive') != null ? true : false,
        );
        $esid = $this->InsertUpdateEmployeeSalaryLookup($data);
        if ($esid > 0) {
            $this->session->set_flashdata('success', 'Employee Salary Added');
        } else {
            $this->session->set_flashdata('error', 'Employee Not Salary Added');
        }
        $url = 'employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $eid);
        redirect($url, 'refresh');
    }    

    public function ajaxAutoLoadSalary() {
        $levelListData = array(
            'departId' => $this->input->post('dep') != '' ? $this->input->post('dep') : 0,
            'designation' => $this->input->post('des') != '' ? $this->input->post('des') : 0,
            'levelid' => $this->input->post('lev') != '' ? $this->input->post('lev') : 0, //3
            'yearId' => $this->input->post('yea') != '' ? $this->input->post('yea') : 0, //4
        );
        $levelListDataAll = $this->GetEmployeeLevelByDepartmentDesignationLevelAndYearId($levelListData)->EmpDetail;
        echo json_encode($levelListDataAll);
    }

}
