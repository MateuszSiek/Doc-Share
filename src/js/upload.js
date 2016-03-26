$(document).ready(init());
function init() {
    $('.file-upload-modal .modal-content form').submit(function (e) {
        upload(e);
    });
}
function upload(e) {
    e.preventDefault();
    var fileName = $('.file-upload-modal .modal-content form').find("input[type=file], textarea").val();
    var formData = new FormData($('.file-upload-modal .modal-content form')[0]);

    if (fileName === "") {
        bootbox.alert("No file choosen");
        return;
    }
    $('#loadingModal').modal('show');
    $('#fileUploadModal > div').addClass('hidden');
    $.ajax({
        url: '/file/do_upload',
        type: 'POST',
        data: formData,
//        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            var returnedData = jQuery.parseJSON(data);
            $('#loadingModal').modal('hide');
            
            if (returnedData["error"]) {
                bootbox.alert(returnedData["error_msg"], function(){
                    $('#fileUploadModal > div').removeClass('hidden');
                });
            } else {
                location.reload();
            }
        },
        error: function(){
            $('#fileUploadModal > div').removeClass('hidden');
            bootbox.alert('Something went wrong! Please try again');
        }
    });
    return false;
}
