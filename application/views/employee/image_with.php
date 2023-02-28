<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.11/cropper.css" integrity="sha512-jO9KUHlvIF4MH/OTiio0aaueQrD38zlvFde9JoEA+AQaCNxIJoX4Kjse3sO2kqly84wc6aCtdm9BIUpYdvFYoA==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.11/cropper.min.js"></script>
<style>
    .preview {
        overflow: hidden;
        width: 160px;
        height: 160px;
        margin: 10px;
        border: 1px solid red;
    }
</style>

<div class="form-row form-inline">
    <div class="col-md-12 form-group mb-3">
        <label for="emp_image" class="col-md-3 col-sm-3 col-xs-12">Photo</label>
        <div class="file-upload col-md-6 col-sm-6 col-xs-12">
            <div class="image-upload-wrap">
                <input type="file" name="image" class="file-upload-input image" id="upload_image" onchange="readDataAs(this)" accept="image/jpeg, image/x-png, image/gif" />
                <div class="drag-text">
                    <h3>
                        Drag or Select to upload Image<br />
                        <i class="pe-7s-cloud-upload"></i>
                    </h3>
                </div>
            </div>
            <div class="file-upload-content">
                <img src="" id="uploaded_image" class="file-upload-image" />
                <div class="image-title-wrap">
                    <button type="button" id="remove_image_button" class="btn btn-danger mt-3">Remove Image</span></button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="https://meet.jit.si/libs/lib-jitsi-meet.min.js"></script> -->