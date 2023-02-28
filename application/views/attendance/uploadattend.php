<?php 
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-primary col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<form action="<?= base_url('attendance/uploadAtt') ?>" enctype="multipart/form-data" method="POST">
    <div class="row">
    <div class="col-md-12 col-xs-12 form-group">
        <input type="file" name="file" id="input" />
    </div>
    <div class="col-md-12 col-xs-12 form-group">
        <input type="submit" name="submit_file" value="Upload Sheet" class="btn btn-primary" />
    </div>
    </div>
</form>

<div class="main-card mt-3 mb-3 card">
    <div class="card-body">
        <h2 class="card-title">Attendance Sheet</h2>

        <table id="attendanceTbl" class="table table-bordered table-hover">
            <thead></thead>
            <tbody></tbody>
        </table>

    </div>
</div>