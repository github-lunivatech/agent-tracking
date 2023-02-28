<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    if( !function_exists('crmEncryptUrlParameter')){
        function crmEncryptUrlParameter($getParameter){
            $CI = get_instance();

            return str_replace('+','%2B',$CI->encryption->encrypt($getParameter));
        }
    }

    if( !function_exists('crmDecryptUrlParameter')){
        function crmDecryptUrlParameter(){
            $CI = get_instance();
            if(!isset($_GET['q'])){
                $CI->session->set_flashdata('excep','Could not get URL parameter');
                redirect('crmError');
            }
            
            $urlPram = $CI->encryption->decrypt( str_replace('%2B','+',$_GET['q']) );
            
            if($urlPram == false) {
                $CI->session->set_flashdata('excep','Could not decode URL parameter');
                redirect('crmError');
            }
    
            $urlPrams = explode('&',$urlPram);
            $urlPramData = array();
            $currentData = array();
            foreach($urlPrams as $urlPram_){
                $urlPramKeyData = explode('=',$urlPram_);
                $currentData[$urlPramKeyData[0]] = $urlPramKeyData[1];
            }
            array_push($urlPramData,$currentData);
    
            return $urlPramData;
        }
    }

    if( !function_exists('crmDecryptWithParameter')){
        function crmDecryptWithParameter($da){
            $CI = get_instance();
            if(!isset($da)){
                $CI->session->set_flashdata('excep','Could not get parameter');
                redirect('crmError');
            }
            
            $urlPram = $CI->encryption->decrypt( str_replace('%2B','+',$da) );
            
            if($urlPram == false) {
                $CI->session->set_flashdata('excep','Could not decode parameter');
                redirect('crmError');
            }
    
            $urlPrams = explode('&',$urlPram);
            $urlPramData = array();
            $currentData = array();
            foreach($urlPrams as $urlPram_){
                $urlPramKeyData = explode('=',$urlPram_);
                $currentData[$urlPramKeyData[0]] = $urlPramKeyData[1];
            }
            array_push($urlPramData,$currentData);
    
            return $urlPramData;
        }
    }
