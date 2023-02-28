<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Change</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/base.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/images/clinic_favicon.png') ?>" type="image/x-icon">
    <style>
        @media screen {
            body {
                margin: 10px;
            }
        }

        @media print {
            table {
                break-inside: avoid;
            }
        }

        .head-img {
            width: 8%;
            position: absolute;
        }

        .her_bor {
            border: 1px solid #e9ecef;
        }
    </style>
</head>

<body>

    <div class="">

        <div class="header text-center">
            <div class="text-left">
                <img class="head-img" src="<?= base_url('assets/images/nepa.png') ?>" alt="" srcset="">
            </div>
            <div>
                <h5 for=""><?= $cDet->CompanyName ?></h5>
                <label for=""><?= $cDet->CompanyAddress . ', ' . $cDet->CompanyCountry ?></label> <br />
                <label for=""><?= $cDet->CompanyPhone ?></label>
            </div>
            <h3>Customer Change Request Details</h3>
        </div>

        <div class="all_tables">
            <table class="table table-bordered">
                <tr>
                    <th>Change Name</th>
                    <td><?= $customerChange->ChangeName ?></td>
                    <th>Change Number</th>
                    <td><?= $customerChange->ChangeNumber ?></td>
                </tr>
                <tr>
                    <th>Requested By</th>
                    <td><?= $rMan ?></td>
                    <th>Request Date</th>
                    <td><?= explode('T', $customerChange->RequestDate)[0] ?></td>
                </tr>
                <tr>
                    <th>Presented To</th>
                    <td><?= $ppMan ?></td>
                    <th>Tentative Date</th>
                    <td><?= explode('T', $customerChange->TentativeDateOfSubmission)[0] ?></td>
                    <!-- <th>Completed Date</th>
                    <td><?= explode('T', $customerChange->CompletedDate)[0] ?></td> -->
                </tr>
                <!-- ChangeStatus -->
            </table>

            <table class="table table-bordered">
                <tr>
                    <th>Change Description</th>
                </tr>
                <tr>
                    <td><?= $customerChange->ChangeDescription ?></td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <th>Reason For Change</th>
                </tr>
                <tr>
                    <td><?= $customerChange->ResonForChange ?></td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <th>Effect On Orgnization</th>
                </tr>
                <tr>
                    <td><?= $customerChange->EffectOnOrgnization ?></td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <th>Effect On Schedule</th>
                </tr>
                <tr>
                    <td><?= $customerChange->EffectOnSchedule ?></td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <th colspan="3">Time and Cost</th>
                </tr>
                <tr>
                    <th>Heading</th>
                    <th>Time</th>
                    <th>Cost</th>
                </tr>
                <tr>
                    <th>Analysis</th>
                    <td><?= $customerChange->AnalysisTime ?></td>
                    <td><?= $customerChange->AnalysisCost ?></td>
                </tr>
                <tr>
                    <th>Design</th>
                    <td><?= $customerChange->DesignTime ?></td>
                    <td><?= $customerChange->DesignCost ?></td>
                </tr>
                <tr>
                    <th>Development</th>
                    <td><?= $customerChange->DevelopmentTime ?></td>
                    <td><?= $customerChange->DevelopmentCost ?></td>
                </tr>
                <tr>
                    <th>Testing</th>
                    <td><?= $customerChange->TestingTime ?></td>
                    <td><?= $customerChange->TestingCost ?></td>
                </tr>
                <tr>
                    <th>Total Tentative</th>
                    <td><?= $customerChange->TotalTentativeTime ?></td>
                    <td><?= $customerChange->TotalTentativeCost ?></td>
                </tr>
            </table>

            <table class="table">
                <tr>
                    <th class="her_bor">Note</th>
                    <td class="her_bor" colspan="2"><?= $customerChange->Note ?></td>
                </tr>
                <tr>
                    <td colspan="3">

                        <div class="footer">
                            <div>
                                <label for="">Project Manager :- </label>
                                <label for=""><?= $pMan ?></label>
                            </div>

                            <div>
                                <label for="">Created By :- </label>
                                <label for=""><?= $uMan ?></label>
                            </div>
                        </div>

                    </td>
                </tr>
            </table>
        </div>

    </div>

    <script>
        setTimeout(() => {
            window.print();
            window.close();
        }, 1000);
    </script>
</body>

</html>