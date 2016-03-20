var login = {
    init: function () {
        $(".form-signin").on('submit', function (e) {
            e.preventDefault();
            login.signIn();
        });
    },
    signIn: function () {
        if (!this.validate_form()) {
            bootbox.alert('Invalid email or password');
        } else {
            var password = $(".form-signin input[type=password]").val(),
                    email = $(".form-signin input[type=email]").val();
            $.ajax({
                type: "POST",
                url: "login",
                data: {
                    password: password,
                    email: email
                },
                success: function (msg) {
                    var returnedValue = jQuery.parseJSON(msg);
                    if (returnedValue.error) {
                        bootbox.alert('Invalid email or password');
                    } else {
                        window.location.replace("application_main");
                    }
                }
            });
        }
        return false;

    },
    validate_form: function () {
        var password = $(".form-signin input[type=password]").val(),
                email = $(".form-signin input[type=email]").val();
        if (password.length < 5 || !this.isEmail(email)) {
            return false;
        } else {
            return true;
        }
    },
    isEmail: function (email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
}