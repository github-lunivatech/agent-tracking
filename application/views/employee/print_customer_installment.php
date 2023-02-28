<!DOCTYPE html>
<html>
<head>
    <title>Installment Payment</title>
    
    <script type="text/javascript" src="<?= base_url('assets/js/jquery/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url();?>assets/js/employee/print_customer_installment.js"></script>
    
    <style>
        /* styles for the invoice */
        body{
             font-size: 12px;
        }
        .invoice {
               width: 84%;
    margin: 28px auto;
    border: 1px solid #ccc;
    padding: 18px;
        }

        /* styles for the company logo */
        .logo {
            text-align: center;
        }

        .logo img {
            width: 150px;
        }

        /* styles for the company name and address */
        .company-info {
            text-align: center;
        }

        /* styles for the invoice details */
        .invoice-details {
            margin-top: 50px;
        }

        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-details th, .invoice-details td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        /* styles for the invoice total */
        .invoice-total {
            text-align: right;
            margin-top: 50px;
        }
        .signature-date {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-top: 20px;
            font-size: 12px;
        }

        /* styles for the amount in words */
        .amount-words {
            text-align: left;
            margin-top: 20px;
            font-size: 12px;
        }
        @media print {
    /* styles for the print media */
    html, body {
      /* height:100vh;  */
      margin: 0 !important; 
      padding: 0 !important;
      font-size: 12px;
      overflow: hidden;
       /* width: 100%; */
    }
    
    /* body {
         
    } */
    .invoice {
               width: 84%;
    margin: 28px auto;
    border: 1px solid #ccc;
    padding: 18px;
    }
    .logo img {
        width: 50px;
    }
    @page {
   size: auto;   /* auto is the initial value */
   /* margin: ;  this affects the margin in the printer settings */
    margin: 3mm 5mm 5mm 3mm;
   transform: scale(0.10%);
    
}
}
    </style>
</head>
<body>
    <div class="invoice">
        <div class="logo">
            <img src="path/to/logo.png" alt="Company Logo">
        </div>
        <div class="company-info">
            <h2>Company Name</h2>
            <p>Address Line 1</p>
            <p>Address Line 2</p>
            <p>City, State ZIP</p>
            <p>Phone: 555-555-5555</p>
            <p>Email: info@company.com</p>
        </div>
        <div class="invoice-details">
            <table>
                <tr>
                    <th>Id</th>
                    <th>Installment Type</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>Product 1</td>
                    <td>2</td>
                    <td>$10</td>
                    <td>$20</td>
                </tr>
                <tr>
                    <td>Product 2</td>
                    <td>1</td>
                    <td>$15</td>
                    <td>$15</td>
                </tr>
                <tr>
                    <td colspan="3">Subtotal</td>
                    <td>$35</td>
                </tr>
                <tr>
                    <td colspan="3">Tax</td>
                <td>$5</td>
                </tr>
                <tr>
                    <td colspan="3">Total</td>
                    <td>$40</td>
                </tr>
            </table>
        </div>
         <div class="signature-date">
            <div>Date: <?php echo date("d-m-Y"); ?></div>
            <div>Printed by: John Doe</div>
        </div>
        <div class="amount-words">
            <p>Amount in words: forty dollars</p>
        </div>
    </div>
</body>
</html>