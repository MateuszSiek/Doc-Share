var filesGrid = {
    init: function () {
        var me = this;
        $('.btn.remove-file').click(function () {
            var button = this;
            bootbox.confirm("Are you sure?", function (result) {
                if (result) {
                    me.removeFile(button);
                }
            });
        });


        $('.file-title').dblclick(function (e) {
//            e.stopPropagation();
//            me.downloadFile(this);
        });

        $('.btn.download-btn').click(function () {
            me.downloadFile(this);
        });
    },
    removeFile: function (el) {
        $('#loadingModal').modal('show');
        var file_id = $(el).attr('file_id');
        $.ajax({
            url: '/file/remove_file/' + file_id,
            type: 'POST',
            success: function (data) {
                var returnedData = jQuery.parseJSON(data);
                $('#loadingModal').modal('hide');
                if (returnedData["error"]) {

                } else {
                    location.reload();
                }
            }
        });
    },
    downloadFile: function (el) {
        var file_id = $(el).attr('file_id');
        if (file_id) {
            window.location.href = '/file/download_file/' + file_id;
        }
    },
    renameFile: function () {
        var titleLabel = $(this);

        titleLabel.toggleClass('hidden');

        var row = $(this).closest('td'),
                inputField = row.find('input');
        inputField.toggleClass('hidden');
        inputField.focus();
        inputField.blur(function () {
            inputField.addClass('hidden');
            titleLabel.removeClass('hidden');
        });
    }
};
