<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

class Visitor extends Util
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isUserLoggedIn')) {
            $this->notLoginRedirect();
        }
        
        if (!in_array("show visitor", $this->session->userdata('allowedRights'))) { 
            redirect('crmerror/page_not_found', 'refresh');
        }
    }

    public function addAppointment()
    {
        $data = array('page' => array(), 'content' => array());
        if ($this->load->get_var('settingBundle')['show_nepali']) {
            $data['page']['title'] = 'नियुक्ति थप्नुहोस';
        }else{
            $data['page']['title'] = 'Add Appointment';
        }
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'visitor/addAppointment';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/select2/select2.min.css'
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/nepalidate/nepali-date-converter.umd.js',
            'assets/select2/select2.full.min.js',
            'assets/nepalitype/preeti.js',
            'assets/js/visitor/addAppointment.js',
            'assets/js/visitor/searchByNumber.js'
        );

        $type = $this->hardCodeAppType();
        $stat = $this->hardCodeAppStat();
        $datae = array(
            "Id" => 0,
            "Name" => '',
        );
        $emBas = $this->GetListOfEmployeeDetailsById($datae)->EmpDetail;
        $data['content'] = array(
            'isView' => false,
            'appType' => $type,
            'appStat' => $stat,
            'emList' => $emBas
        );

        $this->load->view('base', $data);
    }

    public function insertUpdateAppointment()
    {
        $this->load->helper(array('form'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('visit_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('visit_address', 'Address', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if (!$this->form_validation->run()) {
            redirect('visitor/addAppointment');
        }else{
            $today = new DateTime();
            $data = array(
                "AId" => $this->input->post('aid') != null ? $this->input->post('aid') : 0,
                "VisitorId" => $this->input->post('visit_id') != null ? $this->input->post('visit_id') : ' ',
                "VisitorName" => trim(ucfirst($this->input->post('visit_name'))),
                "VisitorAddress" => $this->input->post('visit_address'),
                "VisitorMobileNo" => $this->input->post('visit_mobno'),
                "VisitorGender" => $this->input->post('visit_gender'),
                "VisitorOrganization" => $this->input->post('visit_org') != null ? $this->input->post('visit_org') : ' ',
                "VisitorDesigation" => $this->input->post('visit_desg') != null ? $this->input->post('visit_desg') : ' ',
                "AppointmentWith" => $this->input->post('appoint_with') != null ? $this->input->post('appoint_with') : ' ',
                "AppointmentReason" => $this->input->post('appoint_reason'),
                "AppointmentDate" => $this->input->post('appoint_date'),
                "InTime" => $this->input->post('intime'),
                "OutTime" => $this->input->post('outtime') != null ? $this->input->post('outtime') : '--:--:--',
                "AppointmentType" => $this->input->post('appoint_type'),
                "UserId" => $this->input->post('user_id') != null ? $this->input->post('user_id') : $this->session->userdata('loggedInEmpId'),
                "AppointmentStatus" => $this->input->post('appoint_status') != null ? $this->input->post('appoint_status') : 0,
                "IsSeenBy" => (int)$this->input->post('is_seenby') == 1 ? true : false,
                "NepaliDate" => $this->input->post('nepalidate'),
                "NoOfVisitors" => $this->input->post('noofvisitors')
            );
            // var_dump($data);exit;
            $aid = $this->InsertUpdatedAppointmentDetails($data);
            $res['aid'] = $aid;
            if ($aid > 0) {
                $session_msg = 'Success';
                $this->session->set_flashdata('success', $session_msg);
                redirect('visitor/addAppointment');
            } else {
                $session_msg = 'Error';
                $this->session->set_flashdata('error', $session_msg);
                redirect('visitor/addAppointment');
            }
        }
    }

    public function view_appointment()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View Appointment';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'visitor/viewAppointment';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
            'assets/datatable/buttons/css/buttons.dataTables.min.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/datatable/buttons/js/dataTables.buttons.min.js',
            'assets/datatable/JSZip/jszip.min.js',
			'assets/datatable/pdfmake/pdfmake.min.js',
			'assets/datatable/buttons/js/buttons.print.min.js',
			'assets/datatable/buttons/js/buttons.html5.min.js',
            'assets/js/visitor/view_appointment.js'
        );
        $this->load->helper(array('form'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('fromDate', 'from Date', 'trim|required');
        $this->form_validation->set_rules('toDate', 'to Date', 'trim|required');

        if (!$this->form_validation->run()) {
            $data['content'] = array(
                'iList' => array()
            );
        } else {
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');

            $list = $this->GetAppointmentDetailsByDateRange(array(), false, $fromDate, $toDate)->AppointmentDetails;

            $data['content'] = array(
                'iList' => $list
            );
        }

        $this->load->view('base', $data);
    }

    public function appointmentTab()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View Appointment';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'visitor/appointmentTable';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/js/visitor/appointmentTable.js'
        );
        $this->load->helper(array('form'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('fromDate', 'from Date', 'trim|required');
        $this->form_validation->set_rules('toDate', 'to Date', 'trim|required');

        if (!$this->form_validation->run()) {
            $data['content'] = array(
                'iList' => array()
            );
        } else {
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');

            $list = $this->GetAppointmentDetailsByDateRange(array(), false, $fromDate, $toDate)->AppointmentDetails;

            $data['content'] = array(
                'iList' => $list
            );
        }

        $this->load->view('base', $data);
    }

    public function editAppointment()
    {
        $urlPram = crmDecryptUrlParameter()[0];
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View Appointment';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'visitor/addAppointment';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/nepalidate/nepali-date-converter.umd.js',
            // 'assets/js/visitor/flager.js'
        );

        $type = $this->hardCodeAppType();
        $stat = $this->hardCodeAppStat();

        $data['content'] = array(
            'isView' => true,
            'allDet' => $urlPram,
            'appType' => $type,
            'appStat' => $stat
        );

        $this->load->view('base', $data);
    }

    public function updateSeenFlag()
    {
        $urlPram = crmDecryptWithParameter($this->input->post('u'))[0];
        if($urlPram != '' || $urlPram != []){
            $appId = (int)$urlPram['aid'];
            $userId = $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInEmpId');
            $isSeen = $this->input->post('isseen') != null ? $this->input->post('isseen') : 'true';
            $fid = $this->UpdateIsSeenFlagByUser(array(), false, $appId, $userId, $isSeen);
            echo json_encode(['fid' => $fid]);
        }else{
            $newAr = array(
                'id' => 'no id'
            );
            echo json_encode($newAr);
        }
    }

    public function updateOutTime()
    {
        $aid = $this->input->post('ai');
        if ($aid != 0 || $aid != '') {
            $appId = (int)crmDecryptWithParameter($aid)[0]['aid'];
            $userId = $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInEmpId');
            $outtime  = $this->input->post('outtime') != null ? $this->input->post('outtime') : '--:--:--';

            $oid = $this->OutgoingTimeOfVisitor(array(), false, $appId, $userId, $outtime);
            echo json_encode(array(
                'oid' => $oid
            ));
        } else {
            echo json_encode(array(
                'oid' => 'no id'
            ));
        }
    }

    public function updateStatus()
    {
        $aid = $this->input->post('ai');
        if ($aid != 0 || $aid != '') {
            $appId = (int)crmDecryptWithParameter($aid)[0]['aid'];
            $userId = $this->input->post('userid') != null ? $this->input->post('userid') : $this->session->userdata('loggedInEmpId');
            $status  = $this->input->post('stat') != null ? $this->input->post('stat') : 2;
            $sid = $this->UpdateStatusOfAppointment(array(), false, $appId, $userId, $status);
            echo json_encode(array(
                'sid' => $sid
            ));
        } else {
            echo json_encode(array(
                'sid' => 'no id'
            ));
        }
    }

    public function viewFromApp()
    {
        $urlPram = crmDecryptUrlParameter()[0];
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View Appointment';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'visitor/viewAppFromNot';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/nepalidate/nepali-date-converter.umd.js',
            'assets/js/visitor/flager.js'
        );

        $type = $this->hardCodeAppType();
        $stat = $this->hardCodeAppStat();

        $data['content'] = array(
            'isView' => true,
            'allDet' => $urlPram,
            'appType' => $type,
            'appStat' => $stat
        );

        $this->load->view('base', $data);
    }

    public function get_noti()
    {
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
        echo json_encode($newArr);
    }

    public function viewAppForAd() {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View Appointment';

        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'visitor/viewAppForAdmin';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/js/visitor/viewAppAdmin.js'
        );

        $this->load->helper(array('form'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('fromDate', 'from Date', 'trim|required');
        $this->form_validation->set_rules('toDate', 'to Date', 'trim|required');

        if (!$this->form_validation->run()) {
            $today = new DateTime();
            $fromDate = explode('T', $today->format('c'))[0];

            $list = $this->GetAppointmentDetailsByDateRange(array(), false, $fromDate, $fromDate)->AppointmentDetails;

            $data['content'] = array(
                'iList' => $list
            );
        } else {
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');

            $list = $this->GetAppointmentDetailsByDateRange(array(), false, $fromDate, $toDate)->AppointmentDetails;

            $data['content'] = array(
                'iList' => $list
            );
        }        

        $this->load->view('base', $data);        
    }
}
