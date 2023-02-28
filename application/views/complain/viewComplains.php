<style>
    .inTab,
    .app-main__outer {
        width: 100%;
    }
</style>
<form action="" id="searchEmp" method="POST">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <select name="custId" id="custId" class="form-control">
                <option value="0">All</option>
                <?php foreach ($cus as $key => $value) {
                    printf('<option value="%d">%s</option>', $value->CId, $value->CustomerName);
                } ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <button class="btn btn-primary btn-sm">Search</button>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12" id="doMore">
        <div class="main-card mb-3 card">
            <div class="card-header">View Complains</div>
            <div class="card-body">
                <?php if ($content) { ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="salEmpTbl">
                            <thead>
                                <tr>
                                    <?php
                                    foreach ($content[0] as $key => $value) {
                                        $tableHead = '<th>' . $key . '</th>';
                                        echo $tableHead;
                                    }
                                    ?>
                                    <th class="all">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < sizeof($content); $i++) {
                                    echo '<tr>';
                                    $curr = $content[$i];
                                    $urlPar = '';
                                    // $url2 = 'coid='.$curr->CId;
                                    foreach ($curr as $key => $value) {
                                        $urlPar .= ($key == 'CId' ? '' : '&') . $key . '=' . $value;

                                        echo '<td>' . $value . '</td>';
                                    }
                                    $urlPar .= '&fromDate='.$curr->ComplainDate;
                                    echo '<td>
                                    <a href="' . base_url() . 'complain/complainProfile?q=' . crmEncryptUrlParameter($urlPar) . '" class="btn btn-secondary btn-sm mt-1">View Profile</a>
                                    <a href="' . base_url() . 'complain/add_complain?q=' . crmEncryptUrlParameter($urlPar) . '" class="btn btn-primary btn-sm mt-1">Edit</a>
                                    </td>';
                                    echo '</tr>';
                                } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>