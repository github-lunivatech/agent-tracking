<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

class Product extends Util
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

    public function add_product()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Add Product';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'product/add_product';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
        );

        $getProd = $this->GetProductType('')->GetProductType;
        $data['gProd'] = $getProd;

        if(isset($_GET['q'])){
            $pid = crmDecryptUrlParameter()[0]['pid'];
            $pDet = $this->GetProductDetails('', $pid)->productDetails;
            $data['content'] = $pDet[0];
        }

        $custId = $this->input->post('customerId') ?? 0;
        $pDet = $this->GetProductDetails('', $custId)->productDetails;

        $data['productDetails'] = $pDet;

        $this->load->view('base', $data);
    }

    public function productAdd()
    {
        $today = new DateTime();

        $ppid = 0;
        $ent_date = $today->format('c');
        $hider = $this->input->post('hider');

        if($hider != null){
            $desc = crmDecryptWithParameter($hider)[0];
            $ppid = $desc['pid'];
            $ent_date = $desc['ent_date'];
        }
        $data = array(
            "PId" => $ppid,
            "ProductCode" => $this->input->post('product_code'),
            "ProductName" => $this->input->post('product_name'),
            "ProductType" => $this->input->post('product_type'),
            "UserId" => $this->input->post('userid') ? $this->input->post('userid') : $this->session->userdata('loggedInUserId'),
            "EntryDate" => $ent_date,
            "IsActive" => $this->input->post('is_active') != null ? true : false,
        );
        // var_dump($data);
        $pid = $this->InsertUpdateProductDetails($data);
    //    var_dump($pid); exit;
        if ($pid > 0) {
            $this->session->set_flashdata('success', 'Product Details Saved');
            $url = 'product/add_product';
            redirect($url, 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Product Details Not Saved');
            $url = 'product/add_product';
            redirect($url, 'refresh');
        }
    }

    public function viewProducts()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'View Product';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'product/view_product';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/datatable/css/jquery.dataTables.css',
            'assets/datatable-responsive/css/responsive.dataTables.css',
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/datatable/js/jquery.dataTables.js',
            'assets/datatable-responsive/js/dataTables.responsive.js',
            'assets/js/crm/crmdatatable.js'
        );

        // $this->load->helper(array('form'));
        // $this->load->library('form_validation');

        // $this->form_validation->set_rules('customerId', 'Customer Id', 'required');

        // if ($this->form_validation->run() != FALSE) {
            $custId = $this->input->post('customerId') ?? 0;
            $pDet = $this->GetProductDetails('', $custId)->productDetails;

            $data['content'] = $pDet;
        // }

        $this->load->view('base', $data);
    }
}
