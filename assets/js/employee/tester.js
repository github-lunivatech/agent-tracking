$(document).ready(function () {

    var $modal = $('#modal');

    var image = document.getElementById('sample_image');

    var cropper;

    //old
    $('#add_image_button').on('click', function (e) {
        e.preventDefault()
        $('.file-upload-input').click()
    })

    $('#remove_image_button').on('click', function (e) {
        e.preventDefault()
        removeUpload()
    })

    function removeUpload() {
        $('.file-upload-input').replaceWith($('.file-upload-input').clone());
        $('.file-upload-input').val('');
        $('.file-upload-input')[0].dataset.val = '';
        $('.file-upload-content').hide();
        $('.image-upload-wrap').show();
    }
    $('.image-upload-wrap').bind('dragover', function () {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function () {
        $('.image-upload-wrap').removeClass('image-dropping');
    });
    //old

    $('#emp_image').on('change', function(e){
        var files = event.target.files;
        var done = function (url) {
            image.src = url;
            $modal.modal('show');
        };

        if (files && files.length > 0) {
            reader = new FileReader();
            reader.onload = function (event) {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    })

    $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });

    $('#crop').click(function () {
        canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400
        });

        canvas.toBlob(function (blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function (e) {
                var base64data = reader.result;
                $modal.modal('hide');
                $('.file-upload-image').attr('src', base64data);

                $('.image-upload-wrap').hide();

                // $('.file-upload-image').attr('src', e.target.result);
                $('.file-upload-content').show();

                // $('.image-title').html(input.files[0].name);

            };
        });
    });

});