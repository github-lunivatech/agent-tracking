<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Util.php');

class CrmError extends Util{

    public function __construct(){
        parent::__construct();
        if(!$this->session->userdata('isUserLoggedIn')){
			$this->notLoginRedirect();
        }
    }

    public function index() {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = '500';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'common/error';

        $data['page']['styles'] = array();

        $data['page']['scripts'] = array();

        $this->load->view('base', $data);
    }

    public function page_not_found() {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Page Not Found';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'common/page_not_found';

        $data['page']['styles'] = array();

        $data['page']['scripts'] = array();

        $this->load->view('base', $data);
    }

    public function no_permission() {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'No Permission';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'common/no_permission';

        $data['page']['styles'] = array();

        $data['page']['scripts'] = array();

        $this->load->view('base', $data);
    }

    public function test_card() {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Card';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'common/test_card';

        $data['page']['styles'] = array();

        $data['page']['scripts'] = array();

        $this->load->view('base', $data);
    }
}
?>