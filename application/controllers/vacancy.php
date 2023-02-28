<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

class Vacancy extends Util
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
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Add Vacany Post';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'vacancy/vacancy_add';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/vacancy/vacancy_add.js'
        );

        $comDet = $this->GetCompanyDetails()->CompanyName;
        $da = array(
            "Id" => $comDet[0]->CId,
            "Name" => ''
        );
        $data['job_title'] = $this->GetlistOfDesignation($da)->DesignationDetails;
        $data['job_type'] = $this->hardCodedJobTitle();

        $this->load->view('base', $data);
    }

    public function insertVacancy()
    {
        $today = new DateTime();
        $ent_date = $today->format('c');

        $deadline = new DateTime($this->input->post('deadline'));

        $data = array(
            "VId" => $this->input->post('vid') ?? 0,
            "JobTitleId" => (int)$this->input->post('job_titleid'),
            "Openings" => (int)$this->input->post('openings'),
            "JobType" => (int)$this->input->post('job_type'),
            "JobHeading" => $this->input->post('job_heading'),
            "JobDescription" => $this->input->post('job_description'),
            "JobQualification" => $this->input->post('job_qualification'),
            "ExpectedSalary" => $this->input->post('expect_salary'),
            "Deadline" => $deadline->format('c'),
            "UserId" => $this->input->post('userid') ?? $this->session->userdata('loggedInUserId'),
            "IsActive" => $this->input->post('is_active') ? true : false,
            "EntryDate" => $ent_date ?? $today->format('c'),
        );

        $vid = $this->InsertUdpateVacancyDetails($data);
        if ($vid > 0) {
            $this->session->set_flashdata('success', 'Vacancy posted successfull');
        } else {
            $this->session->set_flashdata('error', 'Vacancy posting error. Please try again');
        }
        redirect('vacancy/index', 'refresh');
    }

    public function viewvacancy()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View Vacany Post';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'vacancy/vacancy_view';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/vacancy/vacancy_view.js',
        );

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('from', 'From Date', 'required');
        $this->form_validation->set_rules('to', 'To Date', 'required');

        if ($this->form_validation->run() == FALSE) {
        } else {
            $from = $this->input->post('from');
            $to = $this->input->post('to');
            $list = $this->GetListOfVacancyDetailsByDate('', $from, $to)->VacancyDetails;
            $data['content'] = $list;
        }

        $this->load->view('base', $data);
    }

    public function online_vacancy()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Vacany Application';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'vacancy/online_vacancy';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/vacancy/online_vacancy.js'
        );

        $comDet = $this->GetCompanyDetails()->CompanyName;
        $da = array(
            "Id" => $comDet[0]->CId,
            "Name" => ''
        );
        $data['job_title'] = $this->GetlistOfDesignation($da)->DesignationDetails;

        $this->load->view('base', $data);
    }

    public function applyVacancy()
    {
        $today = new DateTime();
        $ent_date = $today->format('c');

        $upImage = $this->uploadImage();
        $upCV = $this->uploadCV();
        $upCover = $this->uploadCover();

        $data = array(
            "ApId" => $this->input->post('apid') ?? 0,
            "JobId" => $this->input->post('job_id'),
            "ApplicantName" => $this->input->post('applicant_name'),
            "ApplicantAddress" => $this->input->post('app_address'),
            "ApplicantContactNumber" => $this->input->post('app_conno'),
            "ApplicantEmailId" => $this->input->post('app_email'),
            "ApplicantQualification" => $this->input->post('app_qualification'),
            "ApplicantImage" => $upImage,
            "ApplicantCv" => $upCV,
            "ApplicantCoverLetter" => $upCover,
            "ApplicantStatus" => $this->input->post('app_stat') ?? 1,
            "EntryDate" => $ent_date ?? $today->format('c'),
            "UserId" => $this->input->post('userid') ?? $this->session->userdata('loggedInUserId'),
        );

        $vid = $this->InsertUpdateApplicationForVacancy($data);
        if($vid > 0) {
            $this->session->set_flashdata('success', 'Applied');
        }else{
            $this->session->set_flashdata('error', 'Not Applied. Please try again');
        }

        redirect('vacancy/online_vacancy', 'refresh');
    }

    public function uploadImage() {
        $app_file = $this->input->post('applicant_image') ?? ' ';
        return $app_file;
    }

    public function uploadCV() {
        $app_file = $this->input->post('applicant_cv') ?? ' ';
        return $app_file;
    }

    public function uploadCover() {
        $app_file = $this->input->post('applicant_cover') ?? ' ';
        return $app_file;
    }

    public function application_view() {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View Vacany Application';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'vacancy/application_view';

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
        $data['job_title'] = $this->GetlistOfDesignation($da)->DesignationDetails;

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('jobId', 'Job Id', 'required');

        if ($this->form_validation->run() == FALSE) {

        }else{
            $jobId = $this->input->post('jobId');
            $list = $this->GetlistOfApplicationByJobId('', $jobId)->ApplicantDetails;
            $data['content'] = $list;
        }

        $this->load->view('base', $data);        
    }
}
