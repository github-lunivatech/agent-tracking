<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

class Holiday extends Util
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

    public function holiday_add() {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Add Public Holiday';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'holiday/holiday_add';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/toastr/sweetalert2@10.js',
            'assets/js/holiday/holiday_add.js'
        );

        $this->load->view('base', $data);
    }

    public function insertPublicHoliday() {
        $today = new DateTime();
        $ent_date = $today->format('c');
        $data = array(
            "HId" => $this->input->post('hid') ?? 0,
            "FiscalYear" => $this->input->post('fiscal_year'),
            "HolidayDate" => $this->input->post('holiday_date'),
            "HolidayRemarks" => $this->input->post('holiday_remarks'),
            "UserId" => $this->input->post('userid') ?? $this->session->userdata('loggedInUserId'),
            "EntryDate" => $ent_date ?? $today->format('c'),
        );
        $hid = $this->InsertUpdatePublicHoliday($data);
        if($hid > 0){
            $ses_msg = 'Holiday Saved Successfully';
            $this->session->set_flashdata('success', $ses_msg);
        }else{
            $ses_msg = 'Holiday Not Saved. Please try again';
            $this->session->set_flashdata('error', $ses_msg);
        }
        redirect('holiday/holiday_add', 'refresh');

    }

    public function ajaxGetHolidayDate() {
        $data = array(
            'from' => $this->input->post('from'),
            'to' => $this->input->post('to')
        );
        $list = $this->GetlistofPublicHolidaysByDateRange('', $data['from'], $data['to']);
        echo json_encode($list->leave);
    }

}