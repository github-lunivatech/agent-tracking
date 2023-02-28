<?php
$nep = false;
$header = array();
if (isset($settingBundle['show_nepali'])) {
    $nep = $settingBundle['show_nepali'];
    if ($this->session->userdata('loggedInRole') != 'Visitor') {
        $nep = false;
    }
    if ($nep == true) {
        $header = $settingBundle['nepali_font'];
    } else {
        $header = $settingBundle['english_font'];
    }
}
$permissions = $this->session->userdata('allowedRights');
?>
<div class="app-sidebar sidebar-shadow">
    <?php include_once(VIEW_LAYOUT_DIR . 'header/components/logo.php') ?>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">

                <?php if (in_array("show dashboard", $permissions)) { ?>
                    <li>
                        <a <?= $this->uri->segment(1) == '' ? 'class="mm-active"' : '' ?> href="<?= base_url() ?>">
                            <i class="metismenu-icon pe-7s-home"></i>
                            <?= $header['dashboard'] ?>
                        </a>
                    </li>
                <?php } ?>

                <?php if (in_array("show employees", $permissions)) { ?>
                    <li <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'em_view' || $this->uri->segment(2) == 'em_register' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-users"></i>
                            <?= $header['customer'] . $header['haru'] ?>
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                <?php if (in_array("register employee", $permissions)) : ?>
                                    <a <?= $this->uri->segment(2) == 'em_register' ? 'class="mm-active"' : '' ?> href="<?= base_url('employee/em_register') ?>">
                                        <i class="metismenu-icon"></i>
                                        <?= $header['create']  ?> New
                                    </a>
                                <?php endif; ?>
                                <a <?= $this->uri->segment(2) == 'em_view' ? 'class="mm-active"' : '' ?> href="<?= base_url('employee/em_view') ?>">
                                    <i class="metismenu-icon"></i>
                                    <?php echo $nep ? $header['customer'] . $header['haru'] . ' ' . $header['see'] : $header['see'] . ' ' . $header['customer'] . $header['haru'] ?>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2)=='emp_type' || $this->uri->segment(2)=='commissionList' || $this->uri->segment(2)=='commissionsummaryList' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-users"></i>
                            <?= $header['customer'] ?> Type
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                <a <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'emp_type' ? 'class="mm-active"' : '' ?> href="<?= base_url('employee/emp_type') ?>">
                                    <i class="metismenu-icon"></i>
                                     View Customer type
                                </a>
                            </li>

                             <li>
                                <a <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'commissionList' ? 'class="mm-active"' : '' ?> href="<?= base_url('employee/commissionList') ?>">
                                    <i class="metismenu-icon"></i>
                                     View Commission List
                                </a>
                            </li>
                            <li>
                                <a <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'commissionsummaryList' ? 'class="mm-active"' : '' ?> href="<?= base_url('employee/commissionsummaryList') ?>">
                                    <i class="metismenu-icon"></i>
                                     View Commission Summary List
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'installment_payment' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-wallet"></i>
                            Installment Payment
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                <a <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'getListofMonthlyInstallmentPayment' ? 'class="mm-active"' : '' ?> href="<?= base_url('employee/viewinstallmentlist') ?>">
                                    <i class="metismenu-icon"></i>
                                     View Installment Payment
                                </a>
                            </li>

                        </ul>
                    </li>
                    
                    <li <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'expense_head' || $this->uri->segment(2) == 'expense_daily' ||$this->uri->segment(2) == 'view_expense_daily' || $this->uri->segment(2) == 'view_expense_head' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon fa-money-bill"></i>
                            Expense Head
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                 <a <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'expense_head' ? 'class="mm-active"' : '' ?> href="<?= base_url('employee/expense_head') ?>">
                                    <i class="metismenu-icon"></i>
                                    Create Expense Head
                                </a>
                            </li>

                            <li>
                                 <a <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'view_expense_head' ? 'class="mm-active"' : '' ?> href="<?= base_url('employee/view_expense_head') ?>">
                                    <i class="metismenu-icon"></i>
                                    View Expense Head
                                </a>
                            </li>

                            <li>
                                <a <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'expense_daily' ? 'class="mm-active"' : '' ?> href="<?= base_url('employee/expense_daily') ?>">
                                    <i class="metismenu-icon"></i>
                                   Create Daily Expenses
                                </a>
                               
                            </li>

                            <li>
                                <a <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'view_expense_daily' ? 'class="mm-active"' : '' ?> href="<?= base_url('employee/view_expense_daily') ?>">
                                    <i class="metismenu-icon"></i>
                                   View Daily Expenses
                                </a>
                               
                            </li>
                        </ul>
                    </li>

                    

                    <li <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'generalInventoryGoodsIn' || $this->uri->segment(2) == 'goodsInList' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-portfolio"></i>
                            <?//= $header['customer'] ?> General Inventory Goods In
                            <i class="metismenu-state-icon caret-left"></i>
                        </a>
                        
                        <ul>
                            <li>
                                <a <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'generalInventoryGoodsIn'? 'class="mm-active"' : '' ?> href="<?= base_url('employee/generalInventoryGoodsIn') ?>">
                                    <i class="metismenu-icon"></i>
                                     Create Goods In
                                </a>
                            </li>
                            <li>
                                <a <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'goodsInList' ? 'class="mm-active"' : '' ?> href="<?= base_url('employee/goodsInList') ?>">
                                    <i class="metismenu-icon"></i>
                                    View Goods In
                                </a>
                            </li>
                        </ul>
                    </li>

                    

                    <li <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'generalInventoryGoodsout' || $this->uri->segment(2) == 'goodsOutList'? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-portfolio"></i>
                            <?//= $header['customer'] ?> General Inventory Goods Out
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        
                        <ul>
                            <li>
                                <a <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'generalInventoryGoodsout' ? 'class="mm-active"' : '' ?> href="<?= base_url('employee/generalInventoryGoodsout') ?>">
                                    <i class="metismenu-icon"></i>
                                     Create Goods Out
                                </a>
                            </li>
                            <li>
                                <a <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'goodsOutList' ? 'class="mm-active"' : '' ?> href="<?= base_url('employee/goodsOutList') ?>">
                                    <i class="metismenu-icon"></i>
                                    View Goods Out
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'generalInventoryGoodsIn' || $this->uri->segment(2) == 'goodsInList' ||$this->uri->segment(2) == 'remainingGoodsInOut'? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-shopbag"></i>
                            <?//= $header['customer'] ?> Remaining Goods Report
                            <i class="metismenu-state-icon caret-left"></i>
                        </a>
                        
                        <ul>
                            <li>
                                <a <?= $this->uri->segment(1) == 'employee' && $this->uri->segment(2) == 'remainingGoodsInOut' ? 'class="mm-active"' : '' ?> href="<?= base_url('employee/remainingGoodsInOut') ?>">
                                    <i class="metismenu-icon"></i>
                                    View Remaining Goods Report
                                </a>
                            </li>
                        </ul>
                    </li>

                     
                    <!-- <li <?= $this->uri->segment(1) == 'salary' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-piggy"></i>
                            Salary
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>  -->
                            <!-- <li>
                            <a <?= $this->uri->segment(2) == 'addsalary' ? 'class="mm-active"' : '' ?> href="<?= base_url('salary/addsalary') ?>">
                                <i class="metismenu-icon"></i>
                                Add Salary
                            </a>
                        </li> -->
                            <!-- <li>
                                <a <?= $this->uri->segment(2) == 'viewsalary' ? 'class="mm-active"' : '' ?> href="<?= base_url('salary/viewsalary') . $showOwn ?>">
                                    <i class="metismenu-icon"></i>
                                    View Salary
                                </a>
                            </li> -->
                            <!-- <?php if (in_array("add/edit", $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'bulksalary' ? 'class="mm-active"' : '' ?> href="<?= base_url('salary/bulksalary') ?>">
                                        <i class="metismenu-icon"></i>
                                        Bulk Add Salary
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li> -->


                    <li <?= $this->uri->segment(1) == 'product' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-box1"></i>
                            Product
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if (in_array("add/edit product", $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'add_product' ? 'class="mm-active"' : '' ?> href="<?= base_url('product/add_product') ?>">
                                        <i class="metismenu-icon"></i>
                                        Add Product Details
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a <?= $this->uri->segment(2) == 'viewProducts' ? 'class="mm-active"' : '' ?> href="<?= base_url('product/viewProducts') ?>">
                                    <i class="metismenu-icon"></i>
                                    View Product Details
                                </a>
                            </li>
                        </ul>
                    </li>
   
                <?php } ?>

                <?php if (in_array("show leave", $permissions)) { ?>
                    <!-- <li <?= $this->uri->segment(1) == 'leave' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-note2"></i>
                            <?= $header['leave'] ?>
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if (in_array("leave management", $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'leaveManage' ? 'class="mm-active"' : '' ?> href="<?= base_url('leave/leaveManage') ?>">
                                        <i class="metismenu-icon"></i>
                                        <?= $header['leave'] . ' ' . $header['management'] ?>
                                    </a>
                                </li>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'leaveManage' ? 'class="mm-active"' : '' ?> href="<?= base_url('leave/leaveManage/?filt=filt') ?>">
                                        <i class="metismenu-icon"></i>
                                        Assigned Leaves
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("leave settings", $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'leaveSettings' ? 'class="mm-active"' : '' ?> href="<?= base_url('leave/leaveSettings') ?>">
                                        <i class="metismenu-icon"></i>
                                        <?= $header['leave'] . ' Settings' ?>
                                    </a>
                                </li>
                                <?php if ($this->session->userdata('loggedInRole') != 'Employee') : ?>
                                    <li>
                                        <a <?= $this->uri->segment(2) == 'leaveGroup' ? 'class="mm-active"' : '' ?> href="<?= base_url('leave/leaveGroup') ?>">
                                            <i class="metismenu-icon"></i>
                                            <?= $header['leave'] . ' ' . $header['group'] . ' ' . $header['settings'] ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (in_array("add holiday", $permissions)) { ?>
                                    <li>
                                        <a <?= $this->uri->segment(2) == 'holiday_add' ? 'class="mm-active"' : '' ?> href="<?= base_url('holiday/holiday_add') ?>">
                                            <i class="metismenu-icon"></i>
                                            Add Holidays
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </li> -->
                <?php } ?>

                <?php if (in_array("show visitor", $permissions)) { ?>
                    <!-- <li <?= $this->uri->segment(1) == 'visitor' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-display1"></i>
                            <?= $header['visitor'] ?>
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                <a <?= $this->uri->segment(2) == 'addAppointment' ? 'class="mm-active"' : '' ?> href="<?= base_url('visitor/addAppointment') ?>">
                                    <i class="metismenu-icon"></i>
                                    <?php echo $nep ? $header['visitor'] . ' ' . $header['add'] : $header['add'] . ' ' . $header['visitor']  ?>
                                </a>
                                <a <?= $this->uri->segment(2) == 'appointmentTab' ? 'class="mm-active"' : '' ?> href="<?= base_url('visitor/appointmentTab') ?>">
                                    <i class="metismenu-icon"></i>
                                    <?php echo $nep ? $header['visitor'] . ' ' . $header['see'] : $header['see'] . ' ' . $header['visitor'] ?>
                                </a>
                                <a <?= $this->uri->segment(2) == 'view_appointment' ? 'class="mm-active"' : '' ?> href="<?= base_url('visitor/view_appointment') ?>">
                                    <i class="metismenu-icon"></i>
                                    <?php echo $header['visitor'] . ' ' . $header['report'] ?>
                                </a>
                                <a <?= $this->uri->segment(2) == 'viewAppForAd' ? 'class="mm-active"' : '' ?> href="<?= base_url('visitor/viewAppForAd') ?>">
                                    <i class="metismenu-icon"></i>
                                    <?php echo $nep ? $header['all'] . ' ' . $header['visitor'] . ' ' . $header['see'] : $header['see'] . ' ' . $header['all'] . ' ' . $header['appointment'] ?>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                <?php } ?>

                <?php if (in_array("show salary", $permissions)) {
                    $showOwn = in_array('show own salary', $permissions) ? '?q=' . crmEncryptUrlParameter('logEmpId=' . $this->session->userdata('loggedInEmpId')) : '';
                ?>
                     <li <?= $this->uri->segment(1) == 'salary' ? 'class="mm-active"' : '' ?>>
                        <!-- <a href="#">
                            <i class="metismenu-icon pe-7s-piggy"></i>
                            Salary
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>  -->
                            <!-- <li>
                            <a <?= $this->uri->segment(2) == 'addsalary' ? 'class="mm-active"' : '' ?> href="<?= base_url('salary/addsalary') ?>">
                                <i class="metismenu-icon"></i>
                                Add Salary
                            </a>
                        </li> -->
                            <!-- <li>
                                <a <?= $this->uri->segment(2) == 'viewsalary' ? 'class="mm-active"' : '' ?> href="<?= base_url('salary/viewsalary') . $showOwn ?>">
                                    <i class="metismenu-icon"></i>
                                    View Salary
                                </a>
                            </li> -->
                            <?php if (in_array("add/edit", $permissions)) { ?>
                                <!-- <li>
                                    <a <?= $this->uri->segment(2) == 'bulksalary' ? 'class="mm-active"' : '' ?> href="<?= base_url('salary/bulksalary') ?>">
                                        <i class="metismenu-icon"></i>
                                        Bulk Add Salary
                                    </a>
                                </li> -->
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if (in_array("show notice", $permissions)) { ?>
                    <!-- <li <?= $this->uri->segment(1) == 'notice' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-news-paper"></i>
                            Notice
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if (in_array("add/edit", $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(1) == 'notice' && $this->uri->segment(2) == 'index' ? 'class="mm-active"' : '' ?> href="<?= base_url('notice/index') ?>">
                                        <i class="metismenu-icon"></i>
                                        Add notice
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a <?= $this->uri->segment(2) == 'viewnotice' ? 'class="mm-active"' : '' ?> href="<?= base_url('notice/viewnotice') ?>">
                                    <i class="metismenu-icon"></i>
                                    View notice
                                </a>
                            </li>
                        </ul>
                    </li> -->
                <?php } ?>

                <?php if (in_array("show vacancy", $permissions)) { ?>
                    <!-- <li <?= $this->uri->segment(1) == 'vacancy' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-network"></i>
                            Recruitment
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if (in_array("add/edit", $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(1) == 'vacancy' && $this->uri->segment(2) == 'index' ? 'class="mm-active"' : '' ?> href="<?= base_url('vacancy/index') ?>">
                                        <i class="metismenu-icon"></i>
                                        Add Vacancy
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a <?= $this->uri->segment(2) == 'viewvacancy' ? 'class="mm-active"' : '' ?> href="<?= base_url('vacancy/viewvacancy') ?>">
                                    <i class="metismenu-icon"></i>
                                    View Vacancy
                                </a>
                            </li>
                            <li>
                                <a <?= $this->uri->segment(2) == 'online_vacancy' ? 'class="mm-active"' : '' ?> href="<?= base_url('vacancy/online_vacancy') ?>">
                                    <i class="metismenu-icon"></i>
                                    Online Vacancy Form
                                </a>
                            </li>
                            <li>
                                <a <?= $this->uri->segment(2) == 'application_view' ? 'class="mm-active"' : '' ?> href="<?= base_url('vacancy/application_view') ?>">
                                    <i class="metismenu-icon"></i>
                                    View Vacancy Application
                                </a>
                            </li>
                        </ul>
                    </li> -->
                <?php } ?>

                <?php if (in_array("show roster", $permissions)) { ?>
                    <!-- <li <?= $this->uri->segment(1) == 'roster' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-users"></i>
                            Roster
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                <a <?= $this->uri->segment(2) == 'roster_add' ? 'class="mm-active"' : '' ?> href="<?= base_url('roster/roster_add') ?>">
                                    <i class="metismenu-icon"></i>
                                    Create Duty Roster
                                </a>
                            </li>
                            <li>
                                <a <?= $this->uri->segment(2) == 'roster_view' ? 'class="mm-active"' : '' ?> href="<?= base_url('roster/roster_view') ?>">
                                    <i class="metismenu-icon"></i>
                                    View Duty Roster
                                </a>
                            </li>
                        </ul>
                    </li> -->
                <?php } ?>

                <?php if (in_array("show performance", $permissions)) { ?>
                    <!-- <li <?= $this->uri->segment(1) == 'performance' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-graph2"></i>
                            Performance
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if (in_array("add/edit", $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'create_lookup' ? 'class="mm-active"' : '' ?> href="<?= base_url('performance/create_lookup') ?>">
                                        <i class="metismenu-icon"></i>
                                        Create Lookup Metric
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array('give performance rev', $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'create_performance' ? 'class="mm-active"' : '' ?> href="<?= base_url('performance/create_performance') ?>">
                                        <i class="metismenu-icon"></i>
                                        Give Performance Reviews
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a <?= $this->uri->segment(2) == 'viewPerformance' ? 'class="mm-active"' : '' ?> href="<?= base_url('performance/viewPerformance') ?>">
                                    <i class="metismenu-icon"></i>
                                    View Performance Reviews
                                </a>
                            </li>
                            <li>
                                <a <?= $this->uri->segment(2) == 'viewPerformanceGraph' ? 'class="mm-active"' : '' ?> href="<?= base_url('performance/viewPerformanceGraph') ?>">
                                    <i class="metismenu-icon"></i>
                                    View Performance Graph
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <?php if (in_array("show attendance", $permissions)) { ?>
                    <li <?= $this->uri->segment(1) == 'attendance' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-bookmarks"></i>
                            Attendance
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if (in_array("add/edit", $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'attend' ? 'class="mm-active"' : '' ?> href="<?= base_url('attendance/attend') ?>">
                                        <i class="metismenu-icon"></i>
                                        Add Attendance
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a <?= $this->uri->segment(2) == 'upload_attendance' ? 'class="mm-active"' : '' ?> href="<?= base_url('attendance/upload_attendance') ?>">
                                    <i class="metismenu-icon"></i>
                                    Upload Attendance
                                </a>
                            </li>
                        </ul>
                    </li> -->
                <?php } ?>

                <?php if (in_array("show crm", $permissions)) { ?>
                    <!-- <li <?= $this->uri->segment(1) == 'crm' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-plugin"></i>
                            CRM
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if (in_array("add/edit customer", $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'add_det' ? 'class="mm-active"' : '' ?> href="<?= base_url('crm/add_det') ?>">
                                        <i class="metismenu-icon"></i>
                                        Add Customer Details
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("show customer", $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'view_det' ? 'class="mm-active"' : '' ?> href="<?= base_url('crm/view_det') ?>">
                                        <i class="metismenu-icon"></i>
                                        View Customer Details
                                    </a>
                                </li>-->
                            <?php } ?>
                            <?php if (in_array("show product", $permissions)) { ?>
                                <!-- <li>
                                    <a <?= $this->uri->segment(2) == 'viewprolead' ? 'class="mm-active"' : '' ?> href="<?= base_url('crm/viewprolead') ?>">
                                        <i class="metismenu-icon"></i>
                                        View Product Lead
                                    </a>
                                </li> -->
                            <?php } ?>
                            <?php if (in_array("add/edit sales", $permissions)) { ?>
                                <!-- <li>
                                    <a <?= $this->uri->segment(2) == 'addsalesgoal' ? 'class="mm-active"' : '' ?> href="<?= base_url('crm/addsalesgoal') ?>">
                                        <i class="metismenu-icon"></i>
                                        Add Sales Goal
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("show sales", $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'viewsalesgoal' ? 'class="mm-active"' : '' ?> href="<?= base_url('crm/viewsalesgoal') ?>">
                                        <i class="metismenu-icon"></i>
                                        View Sales Goal
                                    </a>
                                </li>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'viewsalesgraph' ? 'class="mm-active"' : '' ?> href="<?= base_url('crm/viewsalesgraph') ?>">
                                        <i class="metismenu-icon"></i>
                                        View Sales Graph
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>  -->
                <?php } ?>

                <?php if (in_array("show product", $permissions)) { ?>
                    <!-- <li <?= $this->uri->segment(1) == 'product' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-box1"></i>
                            Product
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if (in_array("add/edit product", $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'add_product' ? 'class="mm-active"' : '' ?> href="<?= base_url('product/add_product') ?>">
                                        <i class="metismenu-icon"></i>
                                        Add Product Details
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a <?= $this->uri->segment(2) == 'viewProducts' ? 'class="mm-active"' : '' ?> href="<?= base_url('product/viewProducts') ?>">
                                    <i class="metismenu-icon"></i>
                                    View Product Details
                                </a>
                            </li>
                        </ul>
                    </li> -->
                <?php } ?>

                <?php if (in_array("show complain", $permissions)) { ?>
                    <!-- <li <?= $this->uri->segment(1) == 'complain' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-box1"></i>
                            Complain Management
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if (in_array("add complain", $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'add_complain' ? 'class="mm-active"' : '' ?> href="<?= base_url('complain/add_complain') ?>">
                                        <i class="metismenu-icon"></i>
                                        Add Complain
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a <?= $this->uri->segment(2) == 'viewComplains' ? 'class="mm-active"' : '' ?> href="<?= base_url('complain/viewComplains') ?>">
                                    <i class="metismenu-icon"></i>
                                    View Complain Details
                                </a>
                            </li>
                            <?php if (in_array("view complain tracks", $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'viewTracks' ? 'class="mm-active"' : '' ?> href="<?= base_url('complain/viewTracks') ?>">
                                        <i class="metismenu-icon"></i>
                                        View Complain Tracks
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li> -->
                <?php } ?>

                <?php if (in_array("show roles", $permissions)) { ?>
                    <!-- <li <?= $this->uri->segment(1) == 'user' ? 'class="mm-active"' : '' ?>>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-box1"></i>
                            User Management
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if (in_array("add new rights", $permissions)) { ?>
                                <li>
                                    <a <?= $this->uri->segment(2) == 'add_user_details' ? 'class="mm-active"' : '' ?> href="<?= base_url('user/add_user_details') ?>">
                                        <i class="metismenu-icon"></i>
                                        Add Rights
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a <?= $this->uri->segment(2) == 'viewUserRoles' ? 'class="mm-active"' : '' ?> href="<?= base_url('user/viewUserRoles') ?>">
                                    <i class="metismenu-icon"></i>
                                    View Roles
                                </a>
                            </li>
                        </ul>
                    </li> -->
                <?php } ?>

            </ul>
        </div>
    </div>
</div>