<!doctype html>
<html lang="en">
<head>
    <title> SMS OTP </title>
    <style>
        div.ringcaptcha.widget.no-brand {
            border: 0px !important;
        }

        button.btn.btn-submit.btn-block.btn-verify.js-send-code {
            color: white !important;
            background-color: green !important;
        }
    </style>
</head>
<body>
    <div id="xyz" data-widget data-app="vu9upu5inu5isugody9o" data-local="en" data-mode="verification" data-type="sms"></div>

</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        var appKey = "vu9upu5inu5isugody9o";
        var widget = new ringCaptcha.Widget("#xyz", {
            app: appKey,
            events: {
                ready: function(event) {},
                verified: function(event) {
                    const dataString = localStorage.getItem("ringcaptcha.widget" + appKey);
                    const data = dataString ? JSON.parse(dataString) : null;
                    const phone = data.phoneNumber;
                    alert("Phone number verified" + phone);

                    $("div.ringcaptcha.widget.no-brand").hide();
                }
            }
        }).setup();
    });
</script>





</html>