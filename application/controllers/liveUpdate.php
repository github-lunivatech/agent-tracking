<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('util.php');
class LiveUpdate extends Util {

    public function index() {
		// exec('php index.php liveUpdate');
        $this->load->add_package_path(FCPATH . 'vendor/takielias/codeigniter-websocket');
        $this->load->library('Codeigniter_websocket');
        $this->load->remove_package_path(FCPATH . 'vendor/takielias/codeigniter-websocket');
        
        // Run server
        $this->codeigniter_websocket->set_callback('auth', array($this, '_auth'));
		$this->codeigniter_websocket->run();
		
	}
	
	public function _auth($datas = null)
    {
        return (!empty($datas->user_id)) ? $datas->user_id : false;
	}
	
	public function ajax_livenotif() {
		$today = new DateTime();

        $fromDate = explode('T', $today->format('c'))[0];
        $toDate = explode('T', $today->format('c'))[0];
        
        $allData = $this->GetAppointmentDetailsByDateRange(array(), false, $fromDate, $toDate)->AppointmentDetails;
        $newArr = array();
        foreach ($allData as $value) {
            $nA = array();
            if ($value->AppointmentStatus == 0 && $value->IsSeenBy == false) {
                $nA['name'] = $value->VisitorName;
                $enc = crmEncryptUrlParameter(
                    'aid=' . $value->AId .
                        '&vid=' . $value->VisitorId .
                        '&vname=' . $value->VisitorName .
                        '&vaddress=' . $value->VisitorAddress .
                        '&vmob=' . $value->VisitorMobileNo .
                        '&vgen=' . $value->VisitorGender .
                        '&vorg=' . $value->VisitorOrganization .
                        '&vdes=' . $value->VisitorDesigation .
                        '&appwith=' . $value->AppointmentWith .
                        '&apprea=' . $value->AppointmentReason .
                        '&appdate=' . $value->AppointmentDate .
                        '&intime=' . $value->InTime .
                        '&outtime=' . $value->OutTime .
                        '&apptype=' . $value->AppointmentType .
                        '&userid=' . $value->UserId .
                        '&appstat=' . $value->AppointmentStatus .
                        '&isseen=' . $value->IsSeenBy .
                        '&nepdate=' . $value->NepaliDate .
                        '&novisit=' . $value->NoOfVisitors
                );
                $nA['urlPram'] = $enc;
                array_push($newArr, $nA);
            }
        }



        // for company notice
        $list = $this->GetlistOfCompanyNotice('')->Notice;
        $oneweek = date("Y-m-d", strtotime("+1 week"));
        $today = date("Y-m-d");
        $newlist = array();

        foreach ($list as $key => $value) {
            if ($value->IsActive != false) {
                $spStart = explode('T', $value->NoticeStartDate)[0];
                $spEnd = explode('T', $value->NoticeEndDate)[0];
                if ($spStart == $today && $spEnd <= $oneweek) {
                    array_push($newlist, $value);
                }
            }
        }
        // for company notice
        
        echo json_encode(array('appointment' => $newArr, 'notice' => $newlist));
	}
	
}
