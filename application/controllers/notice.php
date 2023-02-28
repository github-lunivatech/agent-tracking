<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

class Notice extends Util
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

    public function index()
    {
        $urlPram = array();
        if(isset($_GET['q'])){
            $urlPram = crmDecryptUrlParameter()[0];
        }
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Add Notice';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'notice/notice_add';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            // 'assets/toastr/sweetalert2@10.js',
            'assets/js/notice/notice_add.js'
        );

        $data['content'] = $urlPram;

        $this->load->view('base', $data);
    }

    public function insertNotice()
    {
        $today = new DateTime();
        $exD = $this->input->post('exD');

        $neid = null;
        $ent_date = $today->format('c');

        if($exD != null){
            $smD = crmDecryptWithParameter($exD)[0];
            $neid = $smD['nid'];
            $ent_date = $smD['EntryDate'];
        }

        $data = array(
            "NId" => $neid ?? 0,
            "NoticeDescription" => $this->input->post('notice_description'),
            "NoticeTitle" => $this->input->post('notice_title'),
            "EntryDate" => $ent_date ?? $today->format('c'),
            "NoticeStartDate" => $this->input->post('notice_startdate'),
            "NoticeEndDate" => $this->input->post('notice_enddate'),
            "UserId" => $this->input->post('userid') ?? $this->session->userdata('loggedInUserId'),
            "IsActive" => $this->input->post('is_active') != null ? true : false,
        );

        $nid = $this->InsertUpdateCompnayNotice($data);
        if ($nid > 0) {
            $ses_msg = 'Notice Saved Successfully';
            $this->session->set_flashdata('success', $ses_msg);
        } else {
            $ses_msg = 'Notice Not Saved. Please try again';
            $this->session->set_flashdata('error', $ses_msg);
        }
        if($neid != null){
            redirect('notice/viewnotice', 'refresh');
        }else{
            redirect('notice', 'refresh');
        }
    }

    public function ajaxNotice()
    {
        $list = $this->GetlistOfCompanyNotice('')->GetlistOfCompanyNotice;
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

        echo json_encode($newlist);
    }

    public function viewnotice()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View All Notice';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'notice/notice_view';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/js/notice/notice_add.js'
        );

        $list = $this->GetlistOfCompanyNotice('')->GetlistOfCompanyNotice;
        $newlist = array();
        foreach ($list as $key => $value) {
            $ol = $value;
            $allP = crmEncryptUrlParameter(
                "NId=" . $value->NId .
                    "&NoticeDescription=" . $value->NoticeDescription .
                    "&NoticeTitle=" . $value->NoticeTitle .
                    "&EntryDate=" . $value->EntryDate .
                    "&NoticeStartDate=" . $value->NoticeStartDate .
                    "&NoticeEndDate=" . $value->NoticeEndDate .
                    "&UserId=" . $value->UserId .
                    "&IsActive=" . $value->IsActive
            );
            $ol->urlPram = $allP;
            array_push($newlist, $ol);
        }
        $data['content'] = $newlist;
        $this->load->view('base', $data);
    }
}
