<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('Util.php');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class Attendance extends Util
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isUserLoggedIn')) {
            $this->notLoginRedirect();
        }
        if (!in_array("show attendance", $this->session->userdata('allowedRights'))) {
            redirect('crmerror/page_not_found', 'refresh');
        }
    }

    public function attend()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Attendance';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'attendance/attend';

        $data['page']['styles'] = array(
            'assets/daterangepicker-master/daterangepicker.css',
            'assets/css/inout.css'
        );

        $data['page']['scripts'] = array(
            'assets/daterangepicker-master/daterangepicker.js',
            'assets/js/attendance/attend.js'
        );

        $this->load->view('base', $data);
    }

    public function upload_attendance()
    {
        $data = array('page' => array(), 'content' => array());
        $data['page']['title'] = 'Attendance';
        $data['page']['description'] = '';
        $data['page']['headerIcon'] = '';
        $data['page']['template'] = 'attendance/uploadattend';

        $data['page']['styles'] = array(
            // 'assets/daterangepicker-master/daterangepicker.css',
        );

        $data['page']['scripts'] = array(
            'assets/read-excel-file.min.js',
            'assets/js/attendance/showAttendance.js'
        );

        $this->load->view('base', $data);
    }

    public function uploadAtt()
    {
        $reportName = $_FILES['file']['name'];
        if ($reportName != '') {

            $allowedFileType = [
                'application/vnd.ms-excel',
                'text/xls',
                'text/xlsx',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];
            
            if (in_array($_FILES["file"]["type"], $allowedFileType)) {

                $targetPath = 'uploads/' . $reportName;
                move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

                $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                
                if($_FILES["file"]["type"] == 'application/vnd.ms-excel' || $_FILES["file"]["type"] == 'text/xls'){
                    $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();                    
                }

                $spreadSheet = $Reader->load($targetPath);
                $excelSheet = $spreadSheet->getActiveSheet();
                // $spreadSheetAry = $excelSheet->toArray(); needs to be emtpy
                $spreadSheetAry = $excelSheet->toArray(null, false, true, true);
                $sheetCount = count($spreadSheetAry);
                for ($i = 2; $i < $sheetCount; $i++) {
                    if (isset($spreadSheetAry[$i])) {
                        $arVal = array_values($spreadSheetAry[$i]);
                        // var_dump($arVal);
                    }
                }
                if ('uploaded') {
                    $this->session->set_flashdata('success', 'Successfully uploaded');
                } else {
                    $this->session->set_flashdata('error', 'Not uploaded. Please try again');
                }
            }else{
                $this->session->set_flashdata('error', 'Not uploaded. File type doesn\'t match. Please try with valid excel file');
            }
        } else {
            $this->session->set_flashdata('error', 'No file selected. Please try again');
        }
        redirect('attendance/upload_attendance', 'refresh');
    }
}
