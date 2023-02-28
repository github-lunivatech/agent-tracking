<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once('CrmSettings.php');

class Util extends CrmSettings
{
    const SERVICE_INI_FILE_PATH = FCPATH . 'service.ini';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Reads service.ini file
     * @prams {ini SectionName}
     * @return array
     */
    protected function readServiceINI($serviceName = '')
    {
        $error_msg = 'Service not found.';
        if (!file_exists(self::SERVICE_INI_FILE_PATH))
            exit($error_msg);

        $service = parse_ini_file(self::SERVICE_INI_FILE_PATH, true);

        if ($service == false || ($serviceName != '' && !isset($service[$serviceName])))
            exit($error_msg);

        if ($serviceName == '') {
            return $service;
        }

        return $service[$serviceName];
    }

    /**
     * Call API
     * @param {apiName,Apidata,requestType,apiBaseUrlServiceIniVariable}
     */
    private function callApi($api, $data, $post = true, $uploadFile = false, $getApiFrom = 'middleware')
    {

        $url = $this->readServiceINI('API')[$getApiFrom];

        $curl = curl_init();

        $headers = [];
        if (!$uploadFile) {
            $data = json_encode($data);
            $headers = [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            ];
        } else {
            $headers = [
                'Content-Type: multipart/form-data'
            ];
        }

        $curl_setopt = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url . $api,
            CURLOPT_FRESH_CONNECT => TRUE
        );

        if ($post === true) {
            $curl_setopt[CURLOPT_POST] = true;
            $curl_setopt[CURLOPT_SSL_VERIFYPEER] = false;
            $curl_setopt[CURLOPT_HTTPHEADER] = $headers;
            $curl_setopt[CURLOPT_POSTFIELDS] = $data;
        }

        curl_setopt_array($curl, $curl_setopt);

        $resp = curl_exec($curl);

        curl_close($curl);

        return $resp;
    }

    /**
     * Insert update employee personal details
     * $data containing arrays see service
     */
    public function insertUpdateEmployeePersonalDetail($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateEmployeePersonalDetails', $data);
            // var_dump($stat);exit;
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Insert update education details
     * $data contaning arrays
     */
    public function InsertUpdateEducationDetails($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateEducationDetails', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Insert update employee desigantion
     * $data contaning arrays
     */
    public function InsertUpdateEmployeeDesignation($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateEmployeeDesignation', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }
 
    
    /**
 *  Get Goods In Details
 * 
 */
public function GetGoodsInDetailsById($data='',$ajax = false)
{
    try {

        $url='Api/GetGoodsInDetailsById?goodsInId='.$data;
        $stat = $this->callApi($url,'',false);
        if ($ajax)
            return $stat;
        return json_decode($stat);
    } catch (Exception $e) {
        if ($ajax)
            return $e->getMessage();
        $this->session->set_flashdata('excep', $e->getMessage());
        redirect('crmError');
    }
}

  /**
 *  Get Goods In Details
 * 
 */
public function GetGoodsOutById($data='',$ajax = false)
{
    try {

        $url='Api/GetGoodsOutById?goodsOutId='.$data;
        $stat = $this->callApi($url,'',false);
        if ($ajax)
            return $stat;
        return json_decode($stat);
    } catch (Exception $e) {
        if ($ajax)
            return $e->getMessage();
        $this->session->set_flashdata('excep', $e->getMessage());
        redirect('crmError');
    }
}
/**
 *  Get Superagent name by Designation Id
 * 
 */
public function GetEmployeeListByDesignation($data='',$ajax = false)
{
    try {

        $url='Api/GetEmployeeListByDesignation?designationId='.$data;
        $stat = $this->callApi($url,'',false);
        if ($ajax)
            return $stat;
        return json_decode($stat);
    } catch (Exception $e) {
        if ($ajax)
            return $e->getMessage();
        $this->session->set_flashdata('excep', $e->getMessage());
        redirect('crmError');
    }
}

public function GetEmployeeAddressDetailsByEmpId($data,$ajax = false)
{
    try {
        $url='Api/GetEmployeeAddressDetailsByEmpId?employeeId='.$data;
        $stat = $this->callApi($url,'',false);
        if ($ajax)
            return $stat;
        return json_decode($stat);
    } catch (Exception $e) {
        if ($ajax)
            return $e->getMessage();
        $this->session->set_flashdata('excep', $e->getMessage());
        redirect('crmError');
    }
}

public function CheckIfEmployeeCodeAlreadyExist($data,$ajax = false)
{
    try {
        $url='Api/CheckIfEmployeeCodeAlreadyExist?empCode='.$data;
        $stat = $this->callApi($url,'',false);
        if ($ajax)
            return $stat;
        return json_decode($stat);
    } catch (Exception $e) {
        if ($ajax)
            return $e->getMessage();
        $this->session->set_flashdata('excep', $e->getMessage());
        redirect('crmError');
    }
}

/**
 *  Get Employee Code by Employee Id
 * 
 */
public function GetEmployeeCodeByEmployeeId($data,$ajax = false)
{
    try {
        $url='Api/GetEmployeeCodeByEmployeeId?employeeId='.$data;
        $stat = $this->callApi($url,'',false);
        if ($ajax)
            return $stat;
        return json_decode($stat);
    } catch (Exception $e) {
        if ($ajax)
            return $e->getMessage();
        $this->session->set_flashdata('excep', $e->getMessage());
        redirect('crmError');
    }
}


public function GetSupervisorNameByEmployeeId($data='',$ajax = false)
{
    try {
        $url='Api/GetSupervisorNameByEmployeeId?employeeId='.$data;
        $stat = $this->callApi($url,'',false);
        if ($ajax)
            return $stat;
        return json_decode($stat);
    } catch (Exception $e) {
        if ($ajax)
            return $e->getMessage();
        $this->session->set_flashdata('excep', $e->getMessage());
        redirect('crmError');
    }
}


    /*
     * Insert update Experiences
     * $data contaning arrays
     */
    public function InsertUpdateExperiences($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateExperiences', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Insert update Refrence contact
     * $data contaning arrays
     */
    public function InsertUpdateReferenceContact($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateReferenceContact', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Insert update Employee Documents
     * $data contaning arrays
     */
    public function InsertUpdateEmployeeDocuments($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateEmployeeDocuments', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Get list of employee details by id
     * $data  "Id": 1, "Name": "sample string 2"
     */
    public function GetListOfEmployeeDetailsById($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfEmployeeDetailsById', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Get list of employee designation by id
     * $data ?EmpId={EmpId}
     */
    public function GetListOfEmployeeDesignationById($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfEmployeeDesignationById', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Get list of employee Document details by id
     * $data "Id": 1, "Name": "sample string 2"
     */
    public function GetListOfEmployeeDocumentDetailsById($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfEmployeeDocumentDetailsById', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Get list of employee education details by id
     * $data "Id": 1, "Name": "sample string 2"
     */
    public function GetListOfEmployeeEducationById($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfEmployeeEducationById', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Get list of employee experience details by id
     * $data "Id": 1, "Name": "sample string 2"
     */
    public function GetListOfEmployeeExperienceById($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfEmployeeExperienceById', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Get list of employee referemce contact details by id
     * $data "Id": 1, "Name": "sample string 2"
     */
    public function GetListOfEmployeeReferenceContactById($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfEmployeeReferenceContactById', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Insert update leave applcation by Employee
     * $data containing arrays
     */
    public function LeaveApplicationByEmployee($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/LeaveApplicationByEmployee', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Get Leave Details by employee Id
     * $data "Id": 1, "Name": "sample string 2"
     */
    public function GetLeaveDetailsByEmployeeId($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetLeaveDetailsByEmployeeId', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Get list of leave head
     * no parameters
     */
    public function GetlistOfLeaveHead($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetlistOfLeaveHead', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Get list of leave types
     * no parameters
     */
    public function GetListOfLeaveTypes($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfLeaveTypes', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Get list of Designation by companyid
     * $data containt "Id": 1, "Name": "sample string 2"
     */
    public function GetlistOfDesignation($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetlistOfDesignation', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Get list of Department by companyid
     * $data containt "Id": 1, "Name": "sample string 2"
     */
    public function GetDepartmentByCompanyId($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetDepartmentByCompanyId', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Get Company detials
     * no parameters
     */
    public function GetCompanyDetails($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetCompanyDetails', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Get Leave requested to be approved by approver
     * $data containitng arays "Id": 1, "Name": "sample string 2"
     */
    public function GetLeaveRequestedToBeApprovedByApprover($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetLeaveRequestedToBeApprovedByApprover', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Get Leave requested by employee id
     * $data containitng arays "Id": 1, "Name": "sample string 2"
     */
    public function GetLeaveRequestedByEmployeeId($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetLeaveRequestedByEmployeeId', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Create login of employee
     * $data containitng arays  "UId": 1,
     * "EmpId": 2,
     * "UserName": "sample string 3",
     * "UPassword": "sample string 4",
     * "RoleId": 5,
     * "UserId": 6,
     * "EntryDate": "2021-02-26T16:22:53.8049064+05:45"
     */
    public function CreateLoginOfEmployee($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/CreateLoginOfEmployee', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * get list of roles
     * $data containing arrays "Id": 1, "Name": "sample string 2"
     */
    public function GetlistOfRoles($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetlistOfRoles', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     * Check Valid User
     * $data containing arrays "UserName": "sample string 1", "Password": "sample string 2"
     */
    public function CheckValidUser($data = array(), $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/CheckValidUser', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /* upload attachment 
        form-data containing arrays of 
        'did' => $did,
        'filename' => 'only for attachements of leave and documents',
        '' => file 
    */
    public function uploadAttachment($data, $ajax = false)
    {
        try {
            $uploadRxFile = $this->callApi('Api/UploadRxFile', $data, true, true);
            if ($ajax)
                return $uploadRxFile;
            return json_decode($uploadRxFile);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /* upload employee Profile
        form-data containing arrays of 
        'empid' => $eid,
        'image' => 'new',
        '' => file 
    */
    public function uploadEmpImg($data, $ajax = false)
    {
        try {
            $uploadEmpImage = $this->callApi('Api/UploadEmpImage', $data, true, true);
            if ($ajax)
                return $uploadEmpImage;
            return json_decode($uploadEmpImage);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * Assign employee to leave group before leave can be requested
     * @param array containing data(
     * "ELId": 1,
     * "EmployeeId": 2,
     * "LeaveGroupId": 3,
     * "Periodstart": "2021-03-08T10:37:18.6382192+05:45",
     * "EndPeriod": "2021-03-08T10:37:18.6382192+05:45",
     * "IsActive": true,
     * "UserId": 6,
     * "EntryDate": "2021-03-08T10:37:18.6402199+05:45"
     *  )
     */
    public function AssignEmployeeToLeaveGroup($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/AssignEmployeeToLeaveGroup', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get list of leave groups
     * @param : empty
     */
    public function GetListOfLeaveGroupType($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfLeaveGroupType', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get list of leave froup by employee id
     * @param ?EgId={EgId} at the end of api
     */
    public function GetLeaveGroupOfEmployeeById($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetLeaveGroupOfEmployeeById?EgId=' . $data, $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get list of leave group by employee id
     * @param ?empId={empId} at the end of api
     */
    public function GetLeaveGroupByEmpId($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetLeaveGroupByEmpId?empId=' . $data, $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * insert update leave settings
     * @param 
     * "LId": 1,
     *"LeaveType": "sample string 2",
     *"LeaveCount": 3,
     *"LeaveGroupId": 4,
     *"UserId": 5,
     *"EntryDate": "2021-10-26T11:23:14.529704+05:45",
     *"LeaveHeadId": 7
     */
    public function InsertUpdateLeaveSettings($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateLeaveSettings', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get list of email details
     * @param empid
     */
    public function GetApproverSenderEmailForNotification($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetApproverSenderEmailForNotification?empId=' . $data, $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * insert update appointment details
     * @param array see service
     */
    public function InsertUpdatedAppointmentDetails($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdatedAppointmentDetails', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get appointment details
     * @param in url fromDate toDate
     */
    public function GetAppointmentDetailsByDateRange($data, $ajax = false, $fromDate, $toDate)
    {
        try {
            $stat = $this->callApi('Api/GetAppointmentDetailsByDateRange?fromDate=' . $fromDate . '&toDate=' . $toDate, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

   
    /**
     * update is seen flag by user
     * @param in url AppointmentId={AppointmentId}&userId={userId}&isSeen={isSeen}
     */
    public function UpdateIsSeenFlagByUser($data, $ajax = false, $appId, $userId, $isSeen)
    {
        try {
            $stat = $this->callApi('Api/UpdateIsSeenFlagByUser?AppointmentId=' . $appId . '&userId=' . $userId . '&isSeen=' . $isSeen, $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * update outgoing time of visitor
     * @param in url ?AppointmentId={AppointmentId}&userId={userId}&outgoingTime={outgoingTime}
     */
    public function OutgoingTimeOfVisitor($data, $ajax = false, $appId, $userId, $outtime)
    {
        try {
            $stat = $this->callApi('Api/OutgoingTimeOfVisitor?AppointmentId=' . $appId . '&userId=' . $userId . '&outgoingTime=' . $outtime, $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * update outgoing time of visitor
     * @param in url ?AppointmentId={AppointmentId}&userId={userId}&status={status}
     */
    public function UpdateStatusOfAppointment($data, $ajax = false, $appId, $userId, $status)
    {
        try {
            $stat = $this->callApi('Api/UpdateStatusOfAppointment?AppointmentId=' . $appId . '&userId=' . $userId . '&status=' . $status, $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * insert update employee bank detail
     * @param {
     * "EBId": 1,
     * "EmployeeId": 2,
     * "BankName": "sample string 3",
     * "BankLocation": "sample string 4",
     * "BankAccountNumber": "sample string 5",
     * "UserId": 6,
     * "EntryDate": "2021-08-08T12:04:08.6214613+05:45",
     * "IsActive": true
     * }
     */
    public function InsertUpdateEmployeeBankDetails($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateEmployeeBankDetails', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get bank details by employee Id
     * @param ?empId={empId}
     */
    public function GetBankDetailsByEmployeeId($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetBankDetailsByEmployeeId?empId=' . $data, $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * insert update monthly salary by employee id
     * @param {
     * "SRId": 1,
     * "EmployeeId": 2,
     * "SalaryMonth": 3,
     * "SalaryDateFrom": "2021-08-08T13:33:09.6686881+05:45",
     * "SalaryDateTo": "2021-08-08T13:33:09.6691882+05:45",
     * "BasicSalary": 6.0,
     * "Bonus": 7.0,
     * "Allowance": 8.0,
     * "DeductionAmt": 9.0,
     * "AdvanceAmt": 10.0,
     * "TDSAmt": 11.0,
     * "SalaryDispachedDate": "2021-08-08T13:33:09.6701883+05:45",
     * "UserId": 13,
     * "IsSalaryDispatched": true,
     * "Remarks": "sample string 15",
     * "TotalPayable": 16.0
     * }
     */
    public function InsertUpdateMontlySalaryByEmployeeId($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateMontlySalaryByEmployeeId', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get monthly salary by employee id and date
     * @param ?empId={empId}&from={from}&to={to}
     */
    public function GetMonthlySalaryByEmployeeIdAndDate($data, $id, $from, $to, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetMonthlySalaryByEmployeeIdAndDate?empId=' . $id . '&from=' . $from . '&to=' . $to, $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * insert update public holiday
     * @param {
     * "HId": 1,
     * "FiscalYear": "sample string 2",
     * "HolidayDate": "2021-08-08T16:05:37.6138296+05:45",
     * "HolidayRemarks": "sample string 4",
     * "UserId": 5,
     * "EntryDate": "2021-08-08T16:05:37.6138296+05:45"
     * }
     */
    public function InsertUpdatePublicHoliday($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdatePublicHoliday', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get list of public holidays by date range
     * @param ?from={from}&to={to}
     */
    public function GetlistofPublicHolidaysByDateRange($data, $from, $to, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetlistofPublicHolidaysByDateRange?from=' . $from . '&to=' . $to, $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * insert update company notice
     * @param{
     * "NId": 1,
     * "NoticeDescription": "sample string 2",
     * "NoticeTitle": "sample string 3",
     * "EntryDate": "2021-08-09T11:48:21.2491636+05:45",
     * "NoticeStartDate": "2021-08-09T11:48:21.2496637+05:45",
     * "NoticeEndDate": "2021-08-09T11:48:21.2496637+05:45",
     * "UserId": 7,
     * "IsActive": true
     * }
     * 
     */
    public function InsertUpdateCompnayNotice($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateCompnayNotice', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get list of company notice
     */
    public function GetlistOfCompanyNotice($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetlistOfCompanyNotice', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * insert update vacany details 
     * @param {
     * "VId": 1,
     * "JobTitleId": 2,
     * "Openings": 3,
     * "JobType": 4,
     * "JobHeading": "sample string 5",
     * "JobDescription": "sample string 6",
     * "JobQualification": "sample string 7",
     * "ExpectedSalary": "sample string 8",
     * "Deadline": "2021-08-09T13:55:37.5648525+05:45",
     * "UserId": 10,
     * "IsActive": true,
     * "EntryDate": "2021-08-09T13:55:37.5648525+05:45"
     * }
     */
    public function InsertUdpateVacancyDetails($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUdpateVacancyDetails', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get list of vacancy details by date
     * @param ?from={from}&to={to}
     */
    public function GetListOfVacancyDetailsByDate($data, $from, $to, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfVacancyDetailsByDate?from=' . $from . '&to=' . $to, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * insert update application for vacancy
     * @param {
     *  "ApId": 1,
     * "JobId": 2,
     * "ApplicantName": "sample string 3",
     * "ApplicantAddress": "sample string 4",
     * "ApplicantContactNumber": "sample string 5",
     * "ApplicantEmailId": "sample string 6",
     * "ApplicantQualification": "sample string 7",
     * "ApplicantImage": "sample string 8",
     * "ApplicantCv": "sample string 9",
     * "ApplicantCoverLetter": "sample string 10",
     * "ApplicantStatus": 11,
     * "EntryDate": "2021-08-09T16:11:19.6712688+05:45",
     * "UserId": 13
     * }
     */
    public function InsertUpdateApplicationForVacancy($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateApplicationForVacancy', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get list of application by job id
     * @param ?jobId={jobId}
     */
    public function GetlistOfApplicationByJobId($data, $jobId, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetlistOfApplicationByJobId?jobId=' . $jobId, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    public function InsertUdpateDutyRoasterofEmployee($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUdpateDutyRoasterofEmployee', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    public function GetDutyShiftList($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetDutyShiftList', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    public function GetDepartmentWiseEmployeeForDutyRoaster($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetDepartmentWiseEmployeeForDutyRoaster?depId=' . $data, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    public function GetDepartmentWiseDutyShiftOfEmployeeAndDate($data, $id, $from, $to, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetDepartmentWiseDutyShiftOfEmployeeAndDate?depId=' . $id . '&from=' . $from . '&to=' . $to, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * insert update review metrice look up for setttings
     * @paramas:{
     * "RId": 1,
     * "TitleMetrics": "sample string 2",
     * "MetricsDescription": "sample string 3",
     * "MaxPoint": 4,
     * "PassPoint": 5,
     * "UserId": 6,
     * "EntryDate": "2021-08-11T11:00:01.4842535+05:45",
     * "IsActive": true
     * }
     */
    public function InsertUpdateReviewMetricLookup($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateReviewMetricLookup', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get list of review title
     * no parmas
     */
    public function GetListOfReviewTitle($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfReviewTitle', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    public function InsertUpdatePerformanceReviewOfEmployee($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdatePerformanceReviewOfEmployee', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get performance review by employee id and date
     * @param ?empId={empId}&from={from}&to={to}
     */
    public function GetPerformanceReviewByEmployeeIdandDate($data, $empId, $from, $to, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetPerformanceReviewByEmployeeIdandDate?empId=' . $empId . '&from=' . $from . '&to=' . $to, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get employee assigned salary by employee id
     * @param ?empId={empId}
     */
    public function GetEmployeeAssignedSalaryByEmpId($data, $empId, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetEmployeeAssignedSalaryByEmpId?empId=' . $empId, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get employee assigned salary by employee id
     * @param ?empId={empId}&departId={departId}
     */
    public function GetEmployeeAssignedSalaryByEmpIdandDepartmentId($data, $empId, $departId, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetEmployeeAssignedSalaryByEmpIdandDepartmentId?empId=' . $empId . '&departId=' . $departId, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }


    /**
     * insert update employee salary lookup
     * @param "ESId": 1,
     * "EmployeeId": 2,
     * "Maritalstatus": 3,
     * "BasicSalary": 4.0,
     * "FestivalBonus": 5.0,
     * "Allowance": 6.0,
     * "Others": 7.0,
     * "ProvidentFund": 8.0,
     * "CitizenInvestmentTrust": 9.0,
     * "Insurane": 10.0,
     * "OtherFund": 11.0,
     * "TDS": 12.0,
     * "TotalPayable": 13.0,
     * "UserId": 14,
     * "EntryDate": "2021-08-12T12:06:04.7919363+05:45",
     * "IsActive": true
     */
    public function InsertUpdateEmployeeSalaryLookup($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateEmployeeSalaryLookup', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    //customer
    /**
     * insert update customer details
     * @param {
     * "CId": 1,
     * "CustomerName": "sample string 2",
     * "CustomerStateId": 3,
     * "CustomerDistrictId": 4,
     * "CustomerMunicipilityId": 5,
     * "CustomerWardNo": 6,
     * "CustomerAddress": "sample string 7",
     * "CustomerContactNumber": "sample string 8",
     * "CustomerEmailId": "sample string 9",
     * "CustomerWebSite": "sample string 10",
     * "CustomerTypeId": 11,
     * "UserId": 12,
     * "EntryDate": "2021-10-18T12:04:59.6118554+05:45",
     * "IsActive": true,
     * "CustomerStatus": 15,
     * "Remarks": "sample string 16"
     *}
     */
    public function InsertUpdateCustomerDetails($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateCustomerDetails', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get customer details
     * @param custId={custId} in url
     */
    public function GetCustomerDetails($data, $custId, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetCustomerDetails?custId=' . $custId, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * insert update customer social media
     * @param "CSId": 1,
     * "SocialMediaTypeId": 2,
     * "SocialMediaLink": "sample string 3",
     * "EntryDate": "2021-10-18T16:13:02.1191023+05:45",
     * "UserId": 5,
     * "CustomerId": 6
     */
    public function InsertUpdateCustomerSocailMedia($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateCustomerSocailMedia', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get social media details by customer id
     * @param ?custId={custId}
     */
    public function GetSocialMediaLinkByCustomerId($data, $custId, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetSocialMediaLinkByCustomerId?custId=' . $custId, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * insert update customer contact person
     * @param
     *  "CPId": 1,
     * "CustomerId": 2,
     * "ContactPersonName": "sample string 3",
     * "ContactPersonNumber": "sample string 4",
     * "ContactpersonEmail": "sample string 5",
     * "ContactPersonDesignation": "sample string 6",
     * "EntryDate": "2021-10-19T10:32:55.9283418+05:45",
     * "UserId": 8,
     * "IsActive": true
     */
    public function InsertUpdateCustomerContactPerson($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateCustomerContactPerson', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get customer contact person details
     * @param ?custId=custId
     */
    public function GetCustomerContactPersonDetails($data, $custId, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetCustomerContactPersonDetails?custId=' . $custId, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * insert update employee assigned to customer
     * @param
     * "CAId": 1,
     * "CustomerId": 2,
     * "UserId": 3,
     * "UsertStatus": 4,
     * "Remarks": "sample string 5",
     * "EnterBy": 6,
     * "IsActive": true,
     * "EntryDate": "2021-10-19T10:59:06.9713179+05:45"
     */
    public function InsertUpdateEmployeeAssignedToCustomer($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateEmployeeAssignedToCustomer', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get customer assigned to employee
     * @param ?custId=custId
     */
    public function GetCustomerAssignedToEmployee($data, $custId, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetCustomerAssignedToEmployee?custId=' . $custId, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * insert update customer change request
     * @param {
     * "CId": 1,
     * "ChangeNumber": "sample string 2",
     * "ProjectId": 3,
     * "RequestedBy": "sample string 4",
     * "PresentedTo": 5,
     * "RequestDate": "2021-10-19T10:29:43.2063039+05:45",
     * "RequestType": 7,
     * "CustomerId": 8,
     * "ChangeName": "sample string 9",
     * "ChangeDescription": "sample string 10",
     * "ResonForChange": "sample string 11",
     * "EffectOnOrgnization": "sample string 12",
     * "EffectOnSchedule": "sample string 13",
     * "AnalysisTime": "sample string 14",
     * "AnalysisCost": 15.0,
     * "DesignTime": "sample string 16",
     * "DesignCost": 17.0,
     * "DevelopmentTime": "sample string 18",
     * "DevelopmentCost": 19.0,
     * "TestingTime": "sample string 20",
     * "TestingCost": 21.0,
     * "TotalTentativeTime": "sample string 22",
     * "TotalTentativeCost": 23.0,
     * "TentativeDateOfSubmission": "2021-10-19T10:29:43.2083039+05:45",
     * "ProjectManger": 25,
     * "EntryDate": "2021-10-19T10:29:43.2083039+05:45",
     * "Note": "sample string 27",
     * "ChangeStatus": 28,
     * "CompletedDate": "2021-10-19T10:29:43.2083039+05:45",
     * "UserId": 30
     * }
     */
    public function InsertUpdateCustomerChangeRequest($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateCustomerChangeRequest', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get customer change request details
     * @param ?custId=custId
     */
    public function GetCustomerChangeRequestDetails($data, $custId, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetCustomerChangeRequestDetails?custId=' . $custId, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * insert update product lead
     * @param 
     * "LId": 1,
     * "CustomerId": 2,
     * "ProjectId": 3,
     * "LeadStatus": 4,
     * "Amount": 5.0,
     * "Probability": 6,
     * "LeadClosedDate": "2021-10-21T16:22:26.8754163+05:45",
     * "Remarks": "sample string 8",
     * "AttachmentsLink": "sample string 9",
     * "UserId": 10
     */
    public function InsertUpdateCustomerProductLead($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateCustomerProductLead', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get customer product lead details
     * @param ?cId={cId}
     */
    public function GetCustomerProductLeadDetails($data, $cId, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetCustomerProductLeadDetails?cId=' . $cId, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get project wise customer product lead details
     * @param ?pId={pId}
     */
    public function GetProjectWiseCustomerLead($data, $pId, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetProjectWiseCustomerLead?pId=' . $pId, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * insert update project wise sales goal
     * @param 
     * "GId": 1,
     * "DateFrom": "2021-10-21T16:23:27.3618784+05:45",
     * "DateTo": "2021-10-21T16:23:27.3618784+05:45",
     * "ProjectId": 4,
     * "TargetGoal": 5,
     * "UserId": 6,
     * "GoalStatus": 7,
     * "IsActive": true
     */
    public function InsertUpdateProjectWiseSalesGoal($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateProjectWiseSalesGoal', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get project wise sales goal
     * @param ?pId={pId}
     */
    public function GetProjectWiseSalesGoal($data, $pId, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetProjectWiseSalesGoal?pId=' . $pId, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get change request type
     */
    public function GetChangeReqeustType($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetChangeReqeustType', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get change status
     */
    public function GetChangeStaus($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetChangeStaus', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get customer status
     */
    public function GetCustomerStatus($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetCustomerStatus', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get assigned employee status
     */
    public function GetAssignedEmployeeStatus($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetAssignedEmployeeStatus', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get goal status
     */
    public function GetGoalStatus($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetGoalStatus', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get product type
     */
    public function GetProductType($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetProductType', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get social media list
     */
    public function GetSocialMediaList($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetSocialMediaList', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get customer type
     */
    public function GetCustomerType($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetCustomerType', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    //customer

    //product
    /**
     * insert update product details
     * @param
     * "PId": 1,
     * "ProductCode": "sample string 2",
     * "ProductName": "sample string 3",
     * "ProductType": 4,
     * "UserId": 5,
     * "EntryDate": "2021-10-20T10:24:28.827159+05:45",
     * "IsActive": true
     */
    public function InsertUpdateProductDetails($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateProductDetails', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * InsertUpdateEmployeeAddressDetail
     * 
     */
    public function InsertUpdateEmployeeAddressDetails($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateEmployeeAddressDetails', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get product details
     * @param ?pId={pId}
     */
    public function GetProductDetails($data, $pId, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetProductDetails?pId=' . $pId, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }
    //product

    //company states
    /**
     * get states
     */
    public function GetStates($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetStates', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get districts by state id
     * @param ?stateId={stateId}
     */
    public function GetDistrictsByStateId($data, $ajax = false)
    {
        try {
            $url='Api/GetDistrictsByStateId?stateId=' .$data;
            $stat = $stat = $this->callApi($url,'',true);
            
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * get districts by state id
     * @param ?districtId={districtId}
     */
    public function GetMunicipalitiesByDistrictId($data, $ajax = false)
    {
        try {
            $url='Api/GetMunicipalitiesByDistrictId?districtId='.$data;
            $stat = $this->callApi($url,'',true);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }
    //

    /**
     * @desc: insert update customer complaint details
     * @param {
     *"CId": 1,
     *"ComplainCode": "sample string 2",
     *"CustomerId": 3,
     *"ProductId": 4,
     *"ComplainType": 5,
     *"ComplainDetails": "sample string 6",
     *"ComplainBy": "sample string 7",
     *"ComplainDate": "2021-11-08T10:39:19.4216519+05:45",
     *"ComplainStatus": 9,
     *"UserId": 10
     *}
     */
    public function InsertUpdateCustomerComplaintDetails($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateCustomerComplaintDetails', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: get customer wise complain details
     * @param ?custId={custId}
     */
    public function GetCustomerWiseComplainDetails($data, $custId, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetCustomerWiseComplainDetails?custId=' . $custId, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: insert update complain track record
     * @param {
     * "CTId": 1,
     * "ComplainId": 2,
     * "EmployeeId": 3,
     * "ComplainStatus": 4,
     * "EmployeeRemarks": "sample string 5",
     * "EntryDate": "2021-12-17T10:35:46.6570866+05:45",
     * "EnterBy": 7
     * }
     */
    public function InsertUpdateComplainTrackRecord($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateComplainTrackRecord', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: get list of complain priority
     * @param 
     */
    public function GetListOfComplainPrority($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfComplainPrority', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: get complain status by filter
     * @param ?id={id}&filter={filter}&from={from}&to={to}
     */
    public function GetComplainStatusByFilter($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetComplainStatusByFilter?id=' . $data["id"] . '&filter=' . $data["filter"] . '&from=' . $data['from'] . '&to=' . $data['to'], $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: update complain status by complain id
     * @param ?complainId={complainId}&status={status}&userid={userid}&entrydate={entrydate}&remarks={remarks}
     */
    public function UpdateComplainStatusByComplainId($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/UpdateComplainStatusByComplainId?complainId=' . $data["complainId"] . '&status=' . $data["status"] . '&userid=' . $data["userid"] . '&entrydate=' . $data["entrydate"] . '&remarks=' . urlencode($data["remarks"]), $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: get complain type
     * @param
     */
    public function GetComplainType($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetComplainType', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: insert update customer payment details
     * @param {
     *"PId": 1,
     *"CustomerId": 2,
     *"ProductId": 3,
     *"PaidAmount": 4.0,
     *"PaidDate": "2021-11-08T12:15:29.4680414+05:45",
     *"FiscalYearId": 6,
     *"Remarks": "sample string 7",
     *"IsPaid": true
     *}
     */
    public function InsertUpdateCustomerPaymentDetails($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateCustomerPaymentDetails', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: get customer wise payment details
     * @param ?custId={custId}
     */
    public function GetCustomerWisePaymentDetails($data, $custId, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetCustomerWisePaymentDetails?custId=' . $custId, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: get project wise customer project status
     * @param ?projectId={projectId}&from={from}&to={to}
     */
    public function GetProjectWiseCustomerProjectLeadStaus($data, $projectId, $from, $to, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetProjectWiseCustomerProjectLeadStaus?projectId=' . $projectId . '&from=' . $from . '&to=' . $to, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: insert update rights for role
     * @param array(
     * "RDId": 1,
     * "RightId": 2,
     * "RoleId": 3,
     * "IsAcive": true
     * )
     */
    public function InsertUpdateRightsForRole($data, $ajax = false)
    {
        try {
            // var_dump($data);
            $stat = $this->callApi('Api/InsertUpdateRightsForRole', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: insert update rights details
     * @param array(
     * "RId": 1,
     * "UserRight": "sample string 2",
     * "RightDescription": "sample string 3"
     * )
     */
    public function InsertUpdateRightDetails($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateRightDetails', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: get right details by role id
     * @param ?role={role}
     */
    public function GetRightDetailsByRoleId($data, $role, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetRightDetailsByRoleId?role=' . $role, $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: get list of rights
     * @param 
     */
    public function GetListOfRights($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfRights', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }
 /**
     * @desc:get list of expense head
     * @param 
     */
    public function GetExpensesHeadDetails($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetExpensesHeadDetails?exId='.$data['exId'], $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc:get list of expense head
     * @param 
     */
    public function GetExpensesDetailsByExpenseId($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetExpensesDetailsByExpenseId?expenseId='.$data['expenseId'], $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }



    
    /**
     * @desc: for permission sessions
     */
    protected function updatePermissionSession()
    {
        $rights = $this->GetRightDetailsByRoleId('', $this->session->userdata('loggedInRoleId'))->GetRightDetailsByRoleId;
        $allowedRights = array();
        foreach ($rights as $rght) {
            if ($rght->IsActive)
                array_push($allowedRights, trim(strtolower($rght->Right)));
        }
        // array_unique($input)
        $this->session->set_userdata('allowedRights', $allowedRights);
    }

    function getAllowedRights() { //to get session details from other functions
        return $this->session->userdata('allowedRights');
    }

    //send email
    public function sendEmailWithAttachment($subName = 'Default Subject', $subMsg = 'Default Body', $fileHere)
    {
        $this->load->config('email');
        $this->load->library('email');

        $file_data = $this->upload_file_here($fileHere);

        $attachment = $file_data['full_path'];

        $from = $this->config->item('smtp_user');
        $to = 'anib.maharjan@lunivatech.com'; //$this->input->post('toer');

        $subject = $subName;
        $message = $subMsg;

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->attach($attachment);

        if ($this->email->send()) {
            echo 'Email Sent';
        } else {
            echo 'Email Not Sent'; //$this->email->print_debugger();
        }
        unlink($attachment);
    }

    function upload_file_here($fileHere)
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png|gif|JPG|PNG';

        $this->load->library('upload', $config);
        if ($this->upload->do_upload($fileHere)) {
            return $this->upload->data();
        } else {
            return $this->upload->display_errors();
        }
    }
    //send email

    protected function notLoginRedirect()
    {
        if (isset($_SERVER['REDIRECT_QUERY_STRING'])) {
            // $redirect_url = $_SERVER['REDIRECT_QUERY_STRING'];
            // var_dump($_SERVER);
            $redirect_url = $_SERVER['PATH_INFO'];
        } else {
            // $redirect_url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];
            // if(isset($_SERVER['SERVER_PORT']) && !empty($_SERVER['SERVER_PORT']))
            //     $redirect_url .= ':'.$_SERVER['SERVER_PORT'];
            // $redirect_url .= $_SERVER['REQUEST_URI'];
            //default here for now
            $redirect_url = $_SERVER['PATH_INFO'];
        }
        // var_dump($redirect_url);exit;
        redirect('login?redirectCpage=' . urlencode($redirect_url) . '&qs=' . $_SERVER['QUERY_STRING'], 'refresh');
    }

    //hardCoded remove when necessary services are given
    public function hardCodeStat()
    {
        return array(
            (object) array('leaveStat' => 'Pending', 'leaveId' => 0), //0
            (object) array('leaveStat' => 'Approved', 'leaveId' => 1), //1
            (object) array('leaveStat' => 'Reject', 'leaveId' => 2), //2
            (object) array('leaveStat' => 'Cancel', 'leaveId' => 3), //3
        );
    }

    public function hardCodeAppType()
    {
        return array(
            (object) array('leaveStat' => 'Current', 'leaveId' => 1), //1
            (object) array('leaveStat' => 'Pre', 'leaveId' => 2), //2
        );
    }

    public function hardCodeAppStat()
    {
        return array(
            (object) array('leaveStat' => 'Pending', 'leaveId' => 0), //1
            (object) array('leaveStat' => 'Done', 'leaveId' => 1), //1
            (object) array('leaveStat' => 'Cancel', 'leaveId' => 2), //2
        );
    }

    public function hardCodeEthnicity()
    {
        return array(
            (object) array('EthName' => 'Dalit', 'Id' => 1),
            (object) array('EthName' => 'Janajati', 'Id' => 2),
            (object) array('EthName' => 'Muslim', 'Id' => 3),
            (object) array('EthName' => 'Madeshi', 'Id' => 4),
            (object) array('EthName' => 'Brahmi/Chettri', 'Id' => 5),
            (object) array('EthName' => 'Other', 'Id' => 6),
        );
    }

    protected function hardCodedNepMonth()
    {
        return array(
            (object) array('monthName' => 'Baishakh'),
            (object) array('monthName' => 'Jestha'),
            (object) array('monthName' => 'Aasadh'),
            (object) array('monthName' => 'Shrawan'),
            (object) array('monthName' => 'Bhadra'),
            (object) array('monthName' => 'Ashwin'),
            (object) array('monthName' => 'Kartik'),
            (object) array('monthName' => 'Mangsir'),
            (object) array('monthName' => 'Paush'),
            (object) array('monthName' => 'Magh'),
            (object) array('monthName' => 'Falgun'),
            (object) array('monthName' => 'Chaitra'),
        );
    }

    protected function hardCodedJobTitle()
    {
        return array(
            (object) array('title' => 'Full Time', 'Id' => 1),
            (object) array('title' => 'Part Time', 'Id' => 2),
        );
    }

    protected function hardCodedWeekSel()
    {
        return array(
            (object) array('title' => 'This Week', 'Id' => 0),
            (object) array('title' => 'Next Week', 'Id' => 1),
            (object) array('title' => 'Third Week', 'Id' => 2),
            (object) array('title' => 'Fourth Week', 'Id' => 3),
        );
    }

    protected function hardCodedIde()
    {
        return array(
            (object) array('title' => 'Citizenship', 'Id' => 0),
            (object) array('title' => 'License', 'Id' => 1),
            (object) array('title' => 'Voting card', 'Id' => 2),
            (object) array('title' => 'National Id', 'Id' => 3),
            (object) array('title' => 'Other', 'Id' => 4),
        );
    }

    protected function hardCodedReqType()
    {
        return array(
            'reqType' => array(
                (object) array('title' => 'New Feature', 'Id' => 1),
                (object) array('title' => 'Issue', 'Id' => 2),
            ),
            'chgStat' => array(
                (object) array('title' => 'Pending', 'Id' => 1),
                (object) array('title' => 'Ongoing', 'Id' => 2),
                (object) array('title' => 'Done', 'Id' => 3),
            )
        );
    }

    protected function hardCodedUserStat()
    {
        return array(
            'uStat' => array(
                (object) array('title' => 'ToDo', 'Id' => 1),
                (object) array('title' => 'Contacted', 'Id' => 2),
                (object) array('title' => 'Vistied', 'Id' => 3),
                (object) array('title' => 'Won', 'Id' => 4),
                (object) array('title' => 'Lost', 'Id' => 5),
                (object) array('title' => 'Closed', 'Id' => 6),
            ),
            'cStat' => array(
                (object) array('title' => 'Converted', 'Id' => 1),
                (object) array('title' => 'Current', 'Id' => 2),
                (object) array('title' => 'Past', 'Id' => 3),
            )
        );
    }
    //hardCoded remove when necessary services are given

    //token generation
    /**
     * Creates a token usable in a form
     * @return string
     */
    function getToken()
    {
        $token = sha1(mt_rand());
        $sessTok = $this->session->userdata('tokens');
        if (!isset($sessTok)) {
            $this->session->set_userdata('tokens', array($token => 1));
            // $_SESSION['tokens'] = array($token => 1);
        } else {
            $arra = array(
                $token => 1
            );
            $this->session->set_userdata(array(
                'tokens' => $arra
            ), 1);
            // $_SESSION['tokens'][$token] = 1;
        }
        return $token;
    }

    /**
     * Check if a token is valid. Removes it from the valid tokens list
     * @param string $token The token
     * @return bool
     */
    function isTokenValid($token)
    {
        $sessTok = $this->session->userdata('tokens');
        if (!empty($sessTok[$token])) {
            $this->session->unset_userdata($sessTok[$token]);
            $this->getToken();
            return true;
        }
        return false;
    }

    //token generation

    /**
     * @desc: Insert Update Employee Job Year Details
     * @param: {
     *  "YId": 1,
     * "EmployeeYear": "sample string 2",
     * "UserId": 3,
     * "IsActive": true
     * }
     */
    public function InsertUpdateEmployeeJobYearDetails($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateEmployeeJobYearDetails', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    
    /**
     * Insert Update Inventory Goods In
     */
    public function InsertUdpateInventoryGoodsIn($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUdpateInventoryGoodsIn', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * Insert Update Inventory Goods In
     */
    public function InsertUpdateDailyExpenses($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateDailyExpenses', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * Insert Update Inventory Goods In
     */
    public function InsertUpdateExpensesHead($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateExpensesHead', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * Insert Update Inventory Goods Out
     */
    public function InsertUpdateGoodsOut($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateGoodsOut', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * Get Inventory Goods In
     */
    public function GetGoodsInByDateRange($data,$ajax = false,$daterange)
    {
        //  var_dump($data);
        //  var_dump($daterange);exit;
        try {
            $stat = $this->callApi('Api/GetGoodsInByDateRange?fromDate='.$daterange['from'].'&toDate=' .$daterange['to'],'' ,false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

     /**
     * get commission details
     * @param in url fromDate toDate
     */
     public function GetDateWiseCommissionOfCMOAndMO($data,$ajax = false,$daterange)
    {
        //  var_dump($data);
        //  var_dump($daterange);exit;
        try {
            $stat = $this->callApi('Api/GetDateWiseCommissionOfCMOAndMO?fromDate='.$daterange['fromDate'].'&toDate='.$daterange['toDate'].'&cmoId=' .$daterange['cmoId'].'&moId=' .$daterange['moId'],'' ,false);
            if ($ajax)
                return $stat;
                // var_dump($stat);exit;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }


     /**
     * get commission details
     * @param in url fromDate toDate
     */
     public function GetMonthlyCommissionDetailsOfAgentsByDateAndId($data,$ajax = false,$daterange)
    {
        //  var_dump($data);
        //  var_dump($daterange);exit;
        try {
            $stat = $this->callApi('Api/GetMonthlyCommissionDetailsOfAgentsByDateAndId?fromDate='.$daterange['fromDate'].'&toDate='.$daterange['toDate'].'&empId=' .$daterange['moId'],'' ,false);
            if ($ajax)
                return $stat;
                // var_dump($stat);exit;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * Get Inventory Goods In
     */
    public function GetInstallmentPaymentByDaterange($data,$ajax = false,$daterange)
    {
        //  var_dump($data);
        //  var_dump($daterange);exit;
        try {
            $stat = $this->callApi('Api/GetInstallmentPaymentByDaterange?fromDate='.$daterange['from'].'&toDate=' .$daterange['to'],'' ,false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }
    /**
     * Get Remaining Goods In and OUt
     */
    public function GetGoodsRemainingReportByDate($data,$ajax = false,$daterange)
    {
        //  var_dump($data);
        //  var_dump($daterange);exit;
        try {
            $stat = $this->callApi('Api/GetGoodsRemainingReportByDate?fromDate='.$daterange['fromDate'].'&toDate=' .$daterange['toDate'],'' ,false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }
    
    /**
     * Get Inventory Goods Out
     */
    public function GetGoodsOutByDateRange($data,$ajax = false,$daterange)
    {
        //  var_dump($data);
        //  var_dump($daterange);exit;
        try {
            $stat = $this->callApi('Api/GetGoodsOutByDateRange?fromDate='.$daterange['from'].'&toDate=' .$daterange['to'],'' ,false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * Get Inventory Goods In
     */
    // public function GetGoodsInByDateRange($data,$ajax = false,$daterange)
    // {
    //     //  var_dump($data);
    //     //  var_dump($daterange);exit;
    //     try {
    //         $stat = $this->callApi('Api/GetGoodsInByDateRange?fromDate='.$daterange['from'].'&toDate=' .$daterange['to'],'' ,false);
    //         if ($ajax)
    //             return $stat;
    //         return json_decode($stat);
    //     } catch (Exception $e) {
    //         if ($ajax)
    //             return $e->getMessage();
    //         $this->session->set_flashdata('excep', $e->getMessage());
    //         redirect('crmError');
    //     }
    // }
    /**
     * Get Inventory Goods In
     */
    public function GetExpensesDetailsByDateRange($data,$ajax = false,$daterange)
    {
        //  var_dump($data);
        //  var_dump($daterange);exit;
        try {
            $stat = $this->callApi('Api/GetExpensesDetailsByDateRange?from='.$daterange['from'].'&to=' .$daterange['to'],'' ,false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
     Insert Update Installment Payment
    */
    public function InsertUpdateMonthlyInstallment($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateMonthlyInstallment', $data);
            if ($ajax)
                return $stat;
                // var_dump($stat);exit;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: Get Employee year List
     * @param 
     */
    public function GetEmployeeyearList($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetEmployeeyearList', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: Get List Of Employee Level
     * @param 
     */
    public function GetListOfEmployeeLevel($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfEmployeeLevel', $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: InsertUpdateEmployeeLevel
     * @param 
     */
    public function InsertUpdateEmployeeLevel($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateEmployeeLevel', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: InsertUpdateEmployeeLevelYearWiseSalaryLookUp
     * @param 
     */
    public function InsertUpdateEmployeeLevelYearWiseSalaryLookUp($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/InsertUpdateEmployeeLevelYearWiseSalaryLookUp', $data);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: GetEmployeeLevelYearWiseSalaryByDepartmentLevelYear
     * @param 
     */
    public function GetEmployeeLevelYearWiseSalaryByDepartmentLevelYear($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetEmployeeLevelYearWiseSalaryByDepartmentLevelYear?departId='.$data['departId'].'&levelid='.$data['levelid'].'&yearId='.$data['yearId'].'&designation='.$data['designation'], $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * @desc: GetEmployeeLevelByDepartmentDesignationLevelAndYearId
     * @param: ?departId={departId}&designationId={designationId}&levelId={levelId}&yearId={yearId}
     */
    public function GetEmployeeLevelByDepartmentDesignationLevelAndYearId($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetEmployeeLevelByDepartmentDesignationLevelAndYearId?departId='.$data['departId'].'&designationId='.$data['designation'].'&levelId='.$data['levelid'].'&yearId='.$data['yearId'], $data, false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /*
       List of MarketingOfficer Within CMO
    */

    public function GetListOfMarketingOfficerWithinCMO($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfMarketingOfficerWithinCMO?supervisorId='.$data,'',false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }

    /**
     * List of Customer within CMO
     */
    public function GetListOfCustomerWithinCMO($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfCustomerWithinCMO?supervisorId='.$data,'',false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }
    /**
     * List of Customer within MO
     */

     public function GetListOfCustomerWithinMarketingOfficer($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetListOfCustomerWithinMarketingOfficer?reportingmanager='.$data,'',false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }
    /**
     * List of Customer within MO
     */

     public function GetInstallmentPaymentByEmpId($data, $ajax = false)
    {
        try {
            $stat = $this->callApi('Api/GetInstallmentPaymentByEmpId?employeeId='.$data,'',false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            redirect('crmError');
        }
    }
    

    

    function getNepaliDate($date){
        $ndate = NepaliCalender::getInstance()->eng_to_nep($date);
        $ndate = $ndate['nmonth_in_nepali'].' '.$ndate['date_in_nepali'].', '.$this->getNepaliNumber($ndate['year']);
        return $ndate;
    }

    function getNepaliDate1($date){
        $ndate = NepaliCalender::getInstance()->eng_to_nep($date);
        $ndate = $this->getNepaliNumber($ndate['year']).'-'.$this->getNepaliNumber($ndate['month']).'-'.$this->getNepaliNumber($ndate['num_day']);
        return $ndate;
    }

    function getNepaliDateFormat($date){
        $ndate = NepaliCalender::getInstance()->eng_to_nep($date);
        $ndate = $ndate['year'].'-'.$ndate['month'].'-'.$ndate['date'];
        return $ndate;
    }

    function getNepaliNumber($str){
        $find = array('0','1','2','3','4','5','6','7','8','9');
        $replace = array('०','१','२','३','४','५','६','७','८','९');
        return str_replace($find,$replace,$str);
    }

     function getEnglishNumber($str){
        $replace  = array('0','1','2','3','4','5','6','7','8','9');
        $find = array('०','१','२','३','४','५','६','७','८','९');
        return str_replace($find,$replace,$str);
    }

    function getEnglishDate($date){
        $year = date('Y',strtotime($date));
        $month = date('m',strtotime($date));
        $day = date('d',strtotime($date));
        $edate = NepaliCalender::getInstance()->nep_to_eng($year,$month,$day);
        $date = $edate['year'].'-'.$edate['month'].'-'.$edate['date'];
        return $date;
    }

    function getEnglishDateFromNepaliVesrion($date){
        // $year = date('Y',strtotime($date));
        // $month = date('m',strtotime($date));
        // $day = date('d',strtotime($date));
        $nepDate=explode('-',$date);
        $nepYear=$this->getEnglishNumber($nepDate[0]);
        $nepMonth=$this->getEnglishNumber($nepDate[1]);
        $nepDay=$this->getEnglishNumber($nepDate[2]);
        $edate = NepaliCalender::getInstance()->nep_to_eng($nepYear,$nepMonth,$nepDay);
        $date = $edate['year'].'-'.$edate['month'].'-'.$edate['date'];
        return $date;
    }


    private function callTestApi($api, $data, $post = true, $uploadFile = false, $getApiFrom = 'testware')
    {

        $url = $this->readServiceINI('API')[$getApiFrom];

        $curl = curl_init();

        $headers = [];
        if (!$uploadFile) {
            $data = json_encode($data);
            $headers = [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            ];
        } else {
            $headers = [
                'Content-Type: multipart/form-data'
            ];
        }

        $curl_setopt = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url . $api,
            CURLOPT_FRESH_CONNECT => TRUE
        );

        if ($post === true) {
            $curl_setopt[CURLOPT_POST] = true;
            $curl_setopt[CURLOPT_SSL_VERIFYPEER] = false;
            $curl_setopt[CURLOPT_HTTPHEADER] = $headers;
            $curl_setopt[CURLOPT_POSTFIELDS] = $data;
        }

        curl_setopt_array($curl, $curl_setopt);

        $resp = curl_exec($curl);

        curl_close($curl);

        return $resp;
    }

    /**
     * @desc: CreateCreditPartyBill
     * @param 
     */
    public function CreateCreditPartyBill($data, $ajax = false)
    {
        try {

            $stat = $this->callTestApi('Api/CreateCreditPartyBill', $data, true. false);
            if ($ajax)
                return $stat;
            return json_decode($stat);
        } catch (Exception $e) {
            if ($ajax)
                return $e->getMessage();
            $this->session->set_flashdata('excep', $e->getMessage());
            // redirect('crmError');
        }
    }

}
