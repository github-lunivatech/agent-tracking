<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CrmSettings extends CI_Controller{
    private $_parentConstructed = true;
    private $_instanceCaller = 'getPrivateInstance';

    function __construct($parentConstruct = true){
        if($parentConstruct)
            parent::__construct();
        else{
            $this->_parentConstructed = false;
            $this->_instanceCaller = 'getCIInstance';
        }
        $this->setSettingsForCrm();
    }

    final private function setSettingsForCrm(){
        $settings = array();
        
        $settings['new_setting'] = true;
        $settings['shownepfromto'] = true;
        $settings['show_nepali'] = true;
        $settings['nepali_font'] = $this->getNepali();
        $settings['english_font'] = $this->getEnglish();

        $settings['disclose_review'] = true;
        $settings['punch_more'] = false;

        $this->load->vars( array('settingBundle' => $settings) );
        
    }

    final private function getPrivateInstance(){
        return $this;
    }

    final private function getCIInstance(){
        return $CI = & get_instance();
    }

    final public function getSetting($settingName){
        $instance = $this->_instanceCaller;
        return $this->$instance()->load->get_var('settingBundle')[$settingName];
    }

    final public function getNepali() {
        return array(
            'create'=>'create',
            'dashboard' => 'ड्यासबोर्ड',
            'employee' => 'कर्मचारी',
            'customer' => 'ग्राहक',
            'haru' => 'हरु',
            'register' => 'रेजिस्टर',
            'leave' => 'बिदा',
            'management' => 'व्यवस्थापन',
            'group' => 'समूह',
            'settings' => 'सेटिंग्स',
            'visitor' => 'आगन्तुक',
            'see' => 'हेर्नुहोस',
            'add' => 'थप्नुहोस',
            'appointment' => 'भेट',//नियुक्ति
            'report' => 'रिपोर्ट',
            'total' => 'कुल',
            'action' => 'कार्य',
            'active' => 'सक्रिय',
            'inactive' => 'निष्क्रिय',
            'name' => 'नाम',
            'is' => 'छ',
            'id' => 'आईडी',
            'all' => 'सबै',
            'code' => 'कोड',
            'first' => 'पहिलो',
            'middle' => 'मध्य',
            'last' => 'अन्तिम',
            'birth' => 'जन्म',
            'date' => 'मिति',
            'nationality' => 'राष्ट्रियता',
            'ethinicity' => 'जातीयता',
            'identification' => 'पहिचान',
            'no' => 'नं',
            'type' => 'प्रकार',
            'mobile' => 'मोबाइल',
            'contact' => 'सम्पर्क',
            'address' => 'ठेगाना',
            'email' => 'ईमेल',
            'photo' => 'फोटो',
            'save' => 'सेभ',
            'edit' => 'सम्पादन',
            'today' => 'आज',
            'for' => 'को लागि',
            'pending' => 'पेन्डि',
            'gender' => 'लिङ्ग',
            'organization' => 'संगठन',
            'designation' => 'पदनाम',
            'with' => 'संग',
            'reason' => 'कारण',
            'time' => 'समय',
            'in' => 'भित्र',
            'out' => 'बाहिर',
            'of' => 'को',
            'number' => 'संख्या',
            'male' => 'पुरुष',
            'female' => 'महिला',
            'other' => 'अन्य',
            'from' => 'देखि',
            'to' => 'सम्म',
            'list' => 'सूची',
            'load' => 'लोड',
            'sn' => 'क्र.सं',
            'status' => 'स्थिति',
            'done' => 'सकियो',
            'cancel' => 'रद्द',
            'apply' => 'निवेदन',
            'day' => 'दिन',
            'start' => 'सुरु',
            'end' => 'अन्त्य',
            'my' => 'मेरो',
            'approve' => 'स्वीकृत',
            'period' => 'अवधि',
            'available' => 'उपलब्ध',
            'taken' => 'लिएको',
            'head' => 'प्रमुख',
            'remarks' => 'टिप्पणी',
            'option' => 'विकल्प',
            'details' => 'विवरण',
            'subject' => 'विषय',
            'introduce' => 'परिचय',
            'close' => 'बन्द',
            'accept' => 'स्वीकार्नु',
            'yes' => 'हो',
            'nope' => 'होईन',
            'isleft' => 'बाँकी',
            'isfin' => 'सकिएको',
            'isdone' => 'भएको'
        );
    }

    final public function getEnglish() {
        return array(
            'create'=>'Create',
            'dashboard' => 'Dashboard',
            'employee' => 'Employee',
            'customer' => 'Customer',
            'haru' => 's',
            'register' => 'Register',
            'leave' => 'Leave',
            'management' => 'Management',
            'group' => 'Group',
            'settings' => 'Settings',
            'visitor' => 'Visitor',
            'see' => 'View',
            'add' => 'Add',
            'appointment' => 'Appointment',
            'report' => 'Report',
            'total' => 'Total',
            'action' => 'Action',
            'active' => 'Active',
            'inactive' => 'Inactive',
            'name' => 'Name',
            'is' => 'Is',
            'id' => 'Id',
            'all' => 'All',
            'code' => 'Code',
            'first' => 'First',
            'middle' => 'Middle',
            'last' => 'Last',
            'birth' => 'Birth',
            'date' => 'Date',
            'nationality' => 'Nationality',
            'ethinicity' => 'Ethinicity',
            'identification' => 'Identification',
            'no' => 'no',
            'type' => 'Type',
            'mobile' => 'Mobile',
            'contact' => 'Contact',
            'address' => 'Address',
            'email' => 'Email',
            'photo' => 'Photo',
            'save' => 'Save',
            'edit' => 'Edit',
            'today' => 'Today',
            'for' => 'For',
            'pending' => 'Pending',
            'gender' => 'Gender',
            'organization' => 'Organization',
            'designation' => 'Designation',
            'with' => 'With',
            'reason' => 'Reason',
            'time' => 'Time',
            'in' => 'In',
            'out' => 'Out',
            'of' => 'Of',
            'number' => 'No',
            'male' => 'Male',
            'female' => 'Female',
            'other' => 'Other',
            'from' => 'From',
            'to' => 'To',
            'list' => 'List',
            'load' => 'Load',
            'sn' => 'S.N',
            'status' => 'Status',
            'done' => 'Done',
            'cancel' => 'Cancel',
            'apply' => 'Apply',
            'day' => 'Day',
            'start' => 'Start',
            'end' => 'End',
            'my' => 'My',
            'approve' => 'Approve',
            'period' => 'Period',
            'available' => 'Available',
            'taken' => 'Taken',
            'head' => 'Head',
            'remarks' => 'Remarks',
            'option' => 'Option',
            'details' => 'Details',
            'subject' => 'Reason',
            'introduce' => 'Profile',
            'close' => 'Close',
            'accept' => 'Accept',
            'yes' => 'Yes',
            'nope' => 'No',
            'isleft' => 'Left',
            'isfin' => 'Finished',
            'isdone' => 'Done'
        );
    }
}

?>