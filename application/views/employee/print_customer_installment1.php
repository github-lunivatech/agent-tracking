<?php
//CmpPhone
//exit();
$iNoForBill = '';
$billDate = null;
$billNepDate = null; //var_dump( $patientBill );exit();
if (isset($patientBill) && $patientBill != null) {
  $patientId = $patientBill[0]->PatientID;
  $billId = $patientBill[0]->BillId;
  $billNo = $patientBill[0]->BillNo;
  $gtotal = $patientBill[0]->TotalPrice;
  $discountPer = $patientBill[0]->DiscountPercent;
  $discountPrice = $patientBill[0]->DiscountPrice;
  $hst_amount = $patientBill[0]->HSTPrice;
  $net_total = $patientBill[0]->Price - $discountPrice;
  //if bill collected amount is set and greater than 0 advance is set to bill collected amounnt, this is used for displaying proper paid amount only
  $advance = $patientBill[0]->AdvanceAmount;
  $receivedAmount = $patientBill[0]->AmtPaid;
  $remaining =  $patientBill[0]->AmtRemaining;
  $docSelected = $patientBill[0]->DoctorName;
  $rounded_amount = round($patientBill[0]->RoundOffAmt, 2);
  $PaymentType = $patientBill[0]->PaymentType;
  //var_dump($PaymentType);
  $selectedDoc = $patientBill[0]->DocId;
  $collectedAmt = $patientBill[0]->BillCollectedAmnt;
  $isPrinted = $patientBill[0]->IsPrinted;
  $printCount = $patientBill[0]->PrintCount;
  $return = $patientBill[0]->BillAmntReturn;
  $ActualTotalPrice = $patientBill[0]->ActualTotalPrice;

  $patient_pan_no = $patientBill[0]->CustomerPan;
  $RequestorName = $patientBill[0]->Requestor;
  if ($PaymentType == 'Credit Collection' || $PaymentType == 'Credit Collection') {
    $billDate = $patientBill[0]->BillCollectedDate;
    $billNepDate = $patientBill[0]->NBillCollectedDate;
  } else {
    $billDate = $patientBill[0]->BillDate;
    $billNepDate = $patientBill[0]->NepaliBillDate;
  }
  $drValuePrint = " <div class='pull-right capitalize'><strong>Ref Doctor:</strong> $docSelected</div> ";
  if (isset($RequestorName)) {
  }
  if ($patientBill[0]->InsuranceNo != '' && $patientBill[0]->InsuranceNo != null) {
    $iNo = $patientBill[0]->InsuranceNo;
    $iNoForBill = $iNo;
  }
  if ($patientBill[0]->InsuranceClaimCode != '' && $patientBill[0]->InsuranceClaimCode != null) {
    $iCC = $patientBill[0]->InsuranceClaimCode;
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?php echo base_url('assests/images/clinic_favicon.png'); ?>">

  <title>LunivaCare - Clinic</title>
  <?php //if ($settingBundle['print_header_on_bill_mat'] == false) { ?>
    <link rel="stylesheet" href=<?= base_url('assests/css/headerPrintBill.css') ?> />
  <?php //} ?>

  <!-- <script src="<?php echo base_url(); ?>assests/jquery/jquery.js"></script> -->
    <script type="text/javascript" src="<?= base_url('assets/js/jquery/jquery.min.js') ?>"></script>
  <script src="<?php echo base_url();?>assets/js/employee/print_customer_installment.js"></script>

  <style type="text/css">
    @page {
      size: auto;
      /* size: A5 landscape; */
      /* size: A4 landscape; */
    }
/* .page-header, .page-header-space {
    height: 85px;
}
  
  .page-footer, .page-footer-space {
    height: 20px;
  
  }
  
  .page-footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    background-color: #ffffff;
  }
  
  .page-header {
    position: fixed;
    top: 0mm;
    width: 100%;
    background-color: #ffffff;
  }
  
  .page {
    page-break-after: always;
  }
  
  @page {
    margin: 15mm 5mm 5mm 5mm;
  }
  
  @media print {
     thead {display: table-header-group;} 
     tfoot {display: table-footer-group;}
     
     button {display: none;}
     
     body {margin: 0;}
  } */
    @media print {
      #print_row_org_copy {
        page-break-before: always;
        page-break-after: none;
      }

      body {
        margin: 0;
      }

      #print_row_org_copy {
        margin-top: 0px;
      }
      .print_row {
      padding:0px 12px 0px 75px;
      min-width: 5in;
    }
    }

    /*-------------------------------------*/
    body {
      font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
      line-height: 20px;
      /* font-size: 14px; */
      font-size: 12px;
      /* for rotation and middle */
      /* transform: rotate(-90deg);
      position: absolute;
      top: 10%;
      left: 10%; */
      /* for rotation and middle */
    }

    #content_invoice {
      margin: 0px 0px;
    }

    .print_row {
      padding:0px 12px 0px 75px;
      min-width: 5in;
    }

    #print_row_org_copy {
      margin-top: 1px;
    }

    #invoice-name {
      line-height: 10px;
      padding: 5px 0px;
    }

    #tbl_customer,
    #tbl_customerL {
      border-top: 1px solid #ccc;
    }

    /* #tbl_customer tr td {
      width: 50%;
    } */

    #tblSummary tbody td,
    #tblSummary tbody th {
      padding: 3px !important;
    }

    #tblSummary {
      border: none !important;
    }

    .money {
      text-align: right;
    }

    .other-details {
      line-height: 1.42857143;
      text-align: right;
    }

    #tbl_bill tbody tr td {
      padding: 0px 9px !important;
    }

    #tbl_bill thead tr th,
    #tbl_bill tfoot tr th {
      padding: 5px 9px !important;
    }

    .printed_by {
      font-size: 10px;
    }

    .printed_by span:last-child {
      float: right;
      text-align: right;
    }

    .extra-small-text {
      font-size: 10px;
    }

    .center-text {
      text-align: center;
    }

    .performed_dr {
      font-size: 12px;
      margin-bottom: 0px;
    }

    #tbl_bill {
      border: 1px solid #ccc;
      border-collapse: collapse;
    }

    #tbl_bill td,
    #tbl_bill th {
      border: 1px solid #ccc;
    }

    #tbl_bill th {
      padding: 3px;
    }

    #tbl_bill td span {
      line-height: 20px;
    }

    th {
      text-align: left;
    }

    tr td:last-child {
      text-align: right;
    }

    #patientName,
    #patientAddress,
    .capitalize {
      text-transform: capitalize;
    }

    <?php //if ($settingBundle['is_mat']) : ?>

    /* only for matri sishu */
    body {
      width: 36%;
    }

    .bill_hider {
      display: none;
    }

    #print_box {
      width: 95%;
    }

    /* only for matri sishu */
    <?php //endif; ?>.tblLand {
      display: none;
    }

    @media print and (orientation:portrait) {
      /* .tblPot {
        display: revert;
      }

      .tblLand {
        display: none;
      } */

    }

    @media print and (orientation:landscape) {
      /* .tblPot {
        display: none;
      } */
    }

    <?php if ($giveMarTop == true) : ?>
    /* #content_invoice {
      margin-top: 120px;
    }

    .smallDate div {
      font-size: 12px !important;
    } */

    <?php endif; ?><?php //if ($settingBundle['print_header_on_bill_mat'] == false) { ?>.page-header,
    .page-header-space {
      height: 40px;
    }

    @page {
      margin: 3mm 5mm 5mm 3mm;
    }

    <?php //} ?>

    /* .showTPINHeader { */
    /* position: absolute;
      right: 10%; */
    /* } */
    .barcode {
      position: absolute;
      right: 15px;
      top: 0px;
    }

    <?php //if ($settingBundle['print_header_on_bill_mat']) { ?>
    /* @page {
      margin: 3mm;
    } */
    <?php //} ?>
  </style>

</head>

<body>

  <?php //if ($settingBundle['print_header_on_bill_mat'] == false) { ?>
    <div class="page-header">
      <div class="showTPINHeader">
        <!-- TPIN No. <?php //echo  $companyInfo[0]->CmpTPIN ?> -->
        <?php //if ($settingBundle['print_bar_code_on_bill']) { ?>
          <!-- new barcode -->
          <div class="barcode">
            <img src="<?//= base_url('qrGenerator/printBarcodeForBill?q=' . clinicEncryptUrlParameter('billNo=' . $billId . '&insNo=' . $iNoForBill)) ?>">
          </div>
          <!-- new barcode -->
        <?php //} ?>
      </div>
    </div>

    <div class="page-footer">
      <!-- <span style="border-top: 1px dotted;"><?php //echo $this->session->userdata('userFullname'); ?></span> -->
    </div>


    <table style="width: 100%;">
      <thead>
        <tr>
          <td>
            <div class="page-header-space"></div>
          </td>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td>
            <!--*** CONTENT GOES HERE ***-->
            <div class="page">
            <?php // } ?>
            <?php
            //(isset($printCount) && $printCount > 0) ? $noOfLoop = 1 : $noOfLoop = 2;
            //$noOfLoop=1;
           // for ($currentPrintCountNo = 0; $currentPrintCountNo < $noOfLoop; $currentPrintCountNo++) {
            ?>


              <div class="row print_row" id="<?php //echo $currentPrintCountNo == 0 ? 'print_row_cust_copy' : 'print_row_org_copy'; ?>">
                <div class="" id="print_box" class="print_box">

                  <div id="content_invoice">


                    <div class="invoice-header">
                      <table style="width: 100%; text-align:center;">
                        <tr>
                          <td>
                            <?php //if ($comName == true && isset($companyInfo)) {
                             // if ($showComLogo == true) { ?>
                                <style>
                                  .logo {
                                    float: left;
                                    height: 90px;
                                  }

                                  .logo img {
                                    height: 70px;
                                    width: auto;
                                    position: absolute;
                                  }

                                  /* .banner_info {
                                    padding-left: 95px;
                                  } */
                                </style>
                                <div class="logo">
                                  <img src="<?//= base_url($companyInfo[0]->CmpLogo) ?>" alt="">
                                </div>
                              <?php //}
                              echo "<div class='banner_info'>";
                             // if($settingBundle['is_madhu'] == true) {
                                echo "<div>Smart Abhiyan </div>";
                                echo "<divGo Smart Digitally</div>";
                             // }
                              echo "<div></div>";
                              echo "<div style='font-size:22px'></div>";
                              echo "<div></div>";
                               echo "<div>TPIN No. </div>";
                              echo "<div>Phone no. </div>";
                              echo "</div>";
                              ?>
                            <?php //} ?>
                          </td>
                          <td class="smallDate">
                          </td>
                        </tr>
                      </table>

                      <div id="invoice-name">
                        <div style="text-align: center; margin-bottom:5px"><span style="font-size:18px"> <?php //echo (isset($isPrinted) && $isPrinted == true) ? '<span></span>' : ''; ?> INVOICE</span> <?php //echo (isset($isPrinted) && $isPrinted == true) ? '<span></span>' : ''; ?></div>
                        <?php
                        //echo (isset($isPrinted) && $isPrinted == true) ? "<div style='text-align: center; margin-bottom:0px' class='extra-small-text center-text'><strong>Customer Copy No.: </strong>.$printCount</div>" : "";
                        //echo '<div class="extra-small-text center-text">';
                        //echo $currentPrintCountNo > 0 ? "" : '<span>(Customer Copy)</span>';
                        //if (isset($patientBill[0]->TokenNo)) { ?>
                          <span style="float:right;font-size: 1rem;font-weight: bold;"><?php //echo $patientBill[0]->TokenNo ?></span>
                        <?php //}
                        echo '</div>';
                        ?>
                        <div class="ln_solid"></div>
                      </div>
                    </div>

                    <?php
                    // if (isset($patientDetail[0]->DOB)) {
                    //   $ag4 = date('Y-m-d', strtotime($patientDetail[0]->DOB));
                    //   $newAge = getAge($ag4, true);
                    //   if ($newAge->y > 0)
                    //     $newAge = $newAge->y . ' y';
                    //   elseif ($newAge->m > 0)
                    //     $newAge = $newAge->m . ' m';
                    //   else
                    //     $newAge = $newAge->d . ' d';
                    // }
                    // $age = isset($newAge) ? $newAge : ((isset($patientDetail[0]->Age)) ? $patientDetail[0]->Age : getAge($ag4));
                    // $sex = isset($patientDetail[0]->Gender) ? $patientDetail[0]->Gender : '';
                    ?>

                    <table id="tbl_customerL" class="tblLand" style="width:100%">
                      <tr>
                        <td style="width: 45%;">

                          <div>
                            <strong>Name:
                              <span id="patientName">
                                <?php //echo isset($patientDetail[0]->Designation) ? $patientDetail[0]->Designation . ' ' : '';
                                //echo isset($patientDetail[0]->PatientName) ? $patientDetail[0]->PatientName : ''; ?>
                                <?php //$memType = $patientDetail[0]->IsMember == true ? ($patientDetail[0]->MembershipType == 1 ? '[L' : '[G') . ' ' . $patientDetail[0]->MemberCode . ']' : '';
                               // echo $memType; ?>
                              </span>
                            </strong>
                          </div>

                          <div>Age/Sex: <span id="patientAgeSex"><?php //echo $age . "/" . $sex; ?></span></div>

                          <div>PAN no.: <span id="panNo"><?//= $patient_pan_no ?></span></div>

                          <div>Address: <span id="patientAddress"><?php //echo isset($patientDetail[0]->CurrentAddress) ? $patientDetail[0]->CurrentAddress : ''; ?></span> <?php //echo isset($patientDetail[0]->WardNo) ? '- <span>' . $patientDetail[0]->WardNo . '</span>' : '' ?></div>

                        </td>

                        <td>
                          <div class=""><strong>Patient Id: <?php //echo isset($patientId) ? $patientId : ''; ?></strong></div>

                          <div>Mobile No.: <span id="patientPhone"><?php //echo isset($patientDetail[0]->MobileNo) ? $patientDetail[0]->MobileNo : ''; ?></span></div>

                          <div>Department: <span><?php //echo (isset($patientBill[0]->Department)) ? $patientBill[0]->Department : ''; ?></span></div>

                          <?php //if ($patientBill[0]->ClientType != null) : ?>
                            <div><strong>Patient Type: <?php //echo $patientBill[0]->ClientType; ?></strong></div>
                          <?php //endif; ?>

                        </td>

                        <td>

                          <!-- <div class=""><strong>Invoice Issued Date:</strong> <?php //echo (isset($billDate) && !is_null($billDate)) ? $billDate . ' A.D.' : ''; ?></div> -->
                          <div class=""><strong>Transaction Date:</strong> <?php //echo (isset($billDate) && !is_null($billDate)) ? $billDate . ' A.D.' : ''; ?></div>

                          <div class=""><strong>Bill No: <?php //echo isset($billNo) ? $billNo : ''; ?></strong></div>

                          <?php //!empty($fileId) ? printf('<div><strong>IPD Id: %s </strong></div>', $fileId) : '' ?>

                          <?php //echo $drValuePrint; ?>

                          <!-- insurace code and no -->
                          <?php //if ($settingBundle['show_insurance_no'] == true && isset($iNo) && isset($iCC)) : ?>
                            <div><span>Insurance No: <?php //echo $iNo; ?></span></div>
                            <div><span>Insurance Claim Code: <?php //echo $iCC; ?></span></div>
                          <?php //endif; ?>

                        </td>
                      </tr>
                    </table>
<?php //var_dump($patientBill[0]);exit;?>
                    <table id="tbl_customer" class="tblPot" style="width:100%;">
                      <tr>
                        <td>
                          <?php
                          // if (isset($patientDetail[0]->DOB)) {
                          //   $ag4 = date('Y-m-d', strtotime($patientDetail[0]->DOB));
                          //   $newAge = getAge($ag4, true);
                          //   if ($newAge->y > 0)
                          //     $newAge = $newAge->y . ' y';
                          //   elseif ($newAge->m > 0)
                          //     $newAge = $newAge->m . ' m';
                          //   else
                          //     $newAge = $newAge->d . ' d';
                          // }
                          // $age = (isset($patientDetail[0]->Age)) ? $patientDetail[0]->Age : getAge($ag4); //  isset($patientDetail[0]->DOB)?(date_diff(date_create(date('Y-m-d',strtotime($patientDetail[0]->DOB))), date_create('today'))->y):'0';
                          //$age = isset($newAge) ? $newAge : ((isset($patientDetail[0]->Age)) ? $patientDetail[0]->Age : getAge($ag4));
                          //$sex = isset($patientDetail[0]->Gender) ? $patientDetail[0]->Gender : '';
                          ?>


                          <div><strong>Name: <span id="patientName">
                                <?php //echo isset($patientDetail[0]->Designation) ? $patientDetail[0]->Designation . ' ' : '';
                               // echo isset($patientDetail[0]->PatientName) ? $patientDetail[0]->PatientName : ''; ?>
                                <?php //$memType = $patientDetail[0]->IsMember == true ? ($patientDetail[0]->MembershipType == 1 ? '[L' : '[G') . ' ' . $patientDetail[0]->MemberCode . ']' : '';
                                //echo $memType; ?>
                              </span></strong></div>

                          <div>PAN no.: <span id="panNo"><?php //echo $patient_pan_no; ?></span></div>

                          <div>Age/Sex: <span id="patientAgeSex"><?php //echo $age . "/" . $sex; ?></span></div>

                          <div>Address: <span id="patientAddress"><?php //echo isset($patientDetail[0]->CurrentAddress) ? $patientDetail[0]->CurrentAddress : ''; ?></span> <?php //echo isset($patientDetail[0]->WardNo) ? '- <span>' . $patientDetail[0]->WardNo . '</span>' : '' ?></div>

                          <div>Mobile No.: <span id="patientPhone"><?php //echo isset($patientDetail[0]->MobileNo) ? $patientDetail[0]->MobileNo : ''; ?></span></div>

                          <div>Department: <span><?php //echo (isset($patientBill[0]->Department)) ? $patientBill[0]->Department : ''; ?></span></div>

                          <?php //if ($patientBill[0]->ClientType != null) : ?>
                            <div><strong>Patient Type: <?php //echo $patientBill[0]->ClientType; ?></strong></div>
                          <?php //endif; ?>

                          <!-- insurace code and no -->
                          <?php //if ($settingBundle['show_insurance_no'] == true && isset($iNo) && isset($iCC)) : ?>
                            <div><span>Insurance No: <?php //echo $iNo; ?></span></div>
                            <div><span>Insurance Claim Code: <?php //echo $iCC; ?></span></div>
                          <?php //endif; ?>
                        </td>
                        <td>
                          <div class=""><strong>Invoice Issued Date:</strong> <?php //echo (isset($billDate) && !is_null($billDate)) ? $billDate . ' A.D.' : ''; ?></div>
                          <div class=""><strong>Transaction Date:</strong> <?php //echo (isset($billDate) && !is_null($billDate)) ? $billDate . ' A.D.' : ''; ?></div>
                          <div class=""><strong>Bill No: <?php //echo isset($billNo) ? $billNo : ''; ?></strong></div>
                          <div class=""><strong>Patient Id: <?php //echo isset($patientId) ? $patientId : ''; ?></strong></div>
                          <?php //!empty($fileId) ? printf('<div><strong>IPD Id: %s </strong></div>', $fileId) : '' ?>
                          <div class=""><strong>Payment Type: <?php //echo $patientBill[0]->PaymentType.'-'.$patientBill[0]->PaymentCode; ?></strong></div>

                          <?php //echo $drValuePrint; ?>

                          <?php //if (isset($patientBill[0]->PaymentMode) && $patientBill[0]->PaymentMode != '') : ?>
                          <?php //endif; ?>
                        </td>
                      </tr>
                    </table>



                    <table id="tbl_bill" class="table table-bordered tableBill" style="width:100%">

                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th><?php //echo $settingBundle['test_procedure_text_setting']; ?> Name</th>
                          <?php
                          $colspan = '';
                          // if ($settingBundle['bill_test_quantity_and_rate_setting'] && $settingBundle['bill_test_quantity_rate_setting_']) :
                          //   $colspan = 3; ?>
                            <th class="money">Rate</th>
                            <th>Quantity</th>
                          <?php // endif; ?>
                          <?php //if ($showDiscountOnBill == true) :
                            $colspan = 4; ?>
                            <th class="money">Discount Amount</th>
                          <?php //endif; ?>
                          <th class="money">Price (Rs.)</th>
                        </tr>
                      </thead>

                      <!-- <tr>
                        <th>S.No</th>
                        <th><?php //echo $settingBundle['test_procedure_text_setting']; ?> Name</th>
                        <?php
                        $colspan = '';
                        // if ($settingBundle['bill_test_quantity_and_rate_setting'] && $settingBundle['bill_test_quantity_rate_setting_']) :
                        //   $colspan = 3; ?>
                          <th class="money">Rate</th>
                          <th>Quantity</th>
                        <?php //endif; ?>
                        <?php //if ($showDiscountOnBill == true) :
                          $colspan = 4; ?>
                          <th class="money">Discount Amount</th>
                        <?php //endif; ?>
                        <th class="money">Price (Rs.)</th>
                      </tr> -->

                      <?php

                      // $i = 0;
                      // $total = 0;
                      // foreach ($testDetails as $test) {
                      ?>
                        <tr>
                          <td>
                            <?php //echo $i + 1; ?>
                          </td>
                          <td>
                            <div><?php //echo $test->BillTestName; ?></div>
                            <?php
                            //if (isset($packageTestList['package-' . $test->BillTestId])) {
                              echo '<ul>';
                              //foreach ($packageTestList['package-' . $test->BillTestId] as $packageList) {
                                printf('<li></li>'); //$packageList->TestName);
                             // }
                              echo '</ul>';
                            //}
                            //if (!$settingBundle['bill_hide_test_performer_on_print']) :
                             // if ($test->TestType == 1) {
                            ?>
                                <div class="performed_dr">Performed By: <?php //echo $test->PerformedBy; ?></div>
                              <?php
                             // } else if ($test->TestType == 6) {
                              ?>
                                <div class="performed_dr">Performed By: <?php //echo $test->PerformedBy; ?> and Team</div>
                            <?php
                             // }
                            //endif;
                            ?>
                          </td>

                          <?php //if ($settingBundle['bill_test_quantity_and_rate_setting'] && $settingBundle['bill_test_quantity_rate_setting_']) : ?>

                            <td class="money">
                              <?php //echo $test->Rate;
                              ?>
                            </td>

                            <td><?php //echo $test->Quantity; ?></td>
                          <?php //endif; ?>

                          <?php //if ($showDiscountOnBill == true) : ?>
                            
                          <?php //endif; ?>

                          <td class="money"><?php //echo $test->Rate * $test->Quantity; ?></td>

                        </tr>


                      <?php
                       // $total += $test->Rate * $test->Quantity;
                       // $i++;
                     // }
                      ?>


                      <tr>
                        <th>Total</th>
                        <th></th>
                        <th class="money grandTotalAmount" colspan="<?php //echo $colspan; ?>">
                          <?php //echo isset($total) ? $total : $this->session->userdata('docChargePrice'); ?>
                        </th>
                      </tr>
                      <tr>
                        <th></th>
                        <th>
                          <span class="bill_hider"><?php //echo (isset($discountPer) && $discountPer > 0) ? "Discount(%):<br>" : " " ?></span>
                          <span class="bill_hider"><?php //echo (isset($discountPrice) && $discountPrice > 0) ? "Discount Amount:<br>" : " " ?></span>
                          <!-- <span class="">Net Total:<br></span> -->
                          <span class="bill_hider"><?php //echo ((int)$this->session->userdata('msHSTPercent') > 0 || isset($hst_amount) && $hst_amount > 0) ? 'HST:<br>' : ''; ?></span>
                          <!-- <span class="bill_hider">Actual Grand Total:<br></span>
                          <span class="bill_hider">Rounded Amount:<br></span> -->
                          <span class="bill_hider">Grand Total:<br></span>
                          <span class="bill_hider"><?php //echo (isset($patientBill[0]->PaymentType) && $patientBill[0]->PaymentType == "Due Collection") ? "Advance:<br>" : "" ?></span>
                          <span class="bill_hider">Paid Amount:<br></span>

                          <span class="bill_hider">Return: <br></span>
                          <span class="bill_hider">Remaining:<br></span>
                        </th>
                        <td class="money" colspan="<?php //echo $colspan; ?>">
                          <span class="bill_hider"><?php //echo (isset($discountPer) && $discountPer > 0) ? $discountPer . '<br>' : ''; ?></span>
                          <span class="bill_hider"><?php //echo (isset($discountPrice) && $discountPrice > 0) ? $discountPrice . '<br>' : ''; ?></span>
                          <!-- <span class=""><?php //echo isset($net_total) ? $net_total : '0'; ?><br></span> -->
                          <span class="bill_hider"><?php //if ((int)$this->session->userdata('msHSTPercent') > 0 || isset($hst_amount) && $hst_amount > 0) echo $hst_amount . '<br>'; ?></span>
                          <!-- <span class="bill_hider"><?php //echo (isset($ActualTotalPrice)) ? $ActualTotalPrice : '0'; ?><br></span>
                          <span class="bill_hider"><?php //echo isset($rounded_amount) ? $rounded_amount : '0'; ?><br></span> -->
                          <span class="bill_hider"><?php //echo isset($gtotal) ? '<span class="gtotal__">' . $gtotal . '</span>' : '<span class="gtotal__">0</span>'; ?><br></span>
                          <span class="bill_hider"><?php //echo (isset($patientBill[0]->PaymentType) && $patientBill[0]->PaymentType == "Due Collection" && isset($advance)) ? $advance . "<br>" : ''; ?></span>
                          <span class="bill_hider"><?php //echo (isset($receivedAmount)) ? $receivedAmount : 0; ?><br></span>

                          <span class="bill_hider"><?php //echo (isset($return)) ? $return : 0; ?><br></span>
                          <span class="bill_hider"><?php //echo (isset($remaining)) ? $remaining : 0; ?><br></span>
                        </td>
                      </tr>
                    </table>


                    <div class='printed_by'>
                      <span><strong>Bill By: </strong><?php //echo $billUser[0]->FullName; ?></span> <br />
                      <span><strong> Printed On: </strong><?php //echo (isset($billNepDate) && !is_null($billNepDate)) ? $billNepDate . ' B.S.' : ''; ?> <?php //echo date('h:i:s a'); ?></span>
                      <span><strong> Printed By: </strong><?php //echo $this->session->userdata('userFullname'); ?></span>
                    </div>
                  </div>


                </div>
              </div>
           
            </div>
          </td>
          <td></td>
        </tr>

      </tbody>

      <tfoot>
        <tr>
          <td>
            <div class="page-footer-space"></div>
          </td>
        </tr>
      </tfoot>

    </table>
  <?php //} ?>
</body>

</html>