var userList = {
    init: function () {
        $(".remove-user").on('click', function () {
            var userId = this.getAttribute('data-user-id');
            bootbox.confirm("Are you sure?", function (result) {
                if (result) {
                    userList.removeUser(userId);
                }
            });
        });

        $(".add-user-form").on('submit', function (e) {
            e.preventDefault();
            userList.addUser(this);
        });
    },
    removeUser: function (userId) {
        $.ajax({
            url: '/user/remove/' + userId,
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
    addUser: function (form) {
        var formData = new FormData($(form)[0]);
        $.ajax({
            type: "POST",
            url: "user/add_user",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (msg) {
                var returnedData = jQuery.parseJSON(msg);
                if (returnedData.error) {
                    bootbox.alert(returnedData["msg"]);
                } else {
                    $(form)[0].reset();
                    location.reload();
                }
            },
            error: function () {
                bootbox.alert('Something went wrong. Please try again');
            }
        });
    }
}


