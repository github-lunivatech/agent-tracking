<?php

use Psr\Log\Test\DummyTest;

defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

class Home extends Util
{

	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('isUserLoggedIn')) {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data = array('page' => array(), 'content' => array());
		$data['page']['title'] = 'Dashboard';
		$data['page']['description'] = '';
		$data['page']['headerIcon'] = '';
		$data['page']['template'] = 'dashboard';

		$data['page']['styles'] = array(
			'assets/chart.js/dist/Chart.min.css'
		);
		$data['page']['scripts'] = array(
			'assets/chart.js/dist/Chart.min.js',
			// 'assets/js/test_push_notification.js'
		);

		$data['content'] = $this->getDataForDash();

		$this->load->view('base', $data);
	}

	function getDataForDash()
	{
		$today = new DateTime();
		$fromDate = explode('T', $today->format('c'))[0];
		$toDate = explode('T', $today->format('c'))[0];

		$datae = array(
			'Id' => 0, // for now all 
			'Name' => 1
		);

		$emDet = $this->GetListOfEmployeeDetailsById($datae)->EmpDetail;

		$allData = $this->GetAppointmentDetailsByDateRange(array(), false, $fromDate, $toDate)->AppointmentDetails;
		$va = 0;
		foreach ($allData as $value) {
			if ($value->AppointmentStatus == 0) {
				$va ++;
			}
		}

		$data = array(
            'Id' => $this->session->userdata('loggedInEmpId'),
            'Name' => ''
        );
        $retNot = $this->ajaxLeaveApproveForThis($data)['Pending'];
		return array(
			'todayAppointment' => count($allData),
			'pending_appointment' => $va,
			'pending_leave' => count($retNot),
			'total_employee' => count($emDet)
		);
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
}
