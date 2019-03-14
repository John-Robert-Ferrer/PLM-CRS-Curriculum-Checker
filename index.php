<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/materialize.css" />
    <link rel="stylesheet" type="text/css" href="css/logincss.css" />
    <script src="js/materialize.js"></script>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto+Condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" href="images/plmlogo.png">
    <link rel="stylesheet" href="css/sweetalert2.min.css">

    <title>PLM Curriculum Checker</title>

    <style>
        body {
            background-image: url("images/bg4.jpg");
        }
    </style>
</head>

<body>
    <div class="valign-wrapper">
        <div class="card1 card-panel hoverable center">
            <img src="images/plmlogo.png" class="avatar plmlogo img-raised rounded-circle" />
            <b><h2>PAMANTASAN NG LUNGSOD NG MAYNILA</h2></b>
            <h3>Curriculum Checker</h3>
            <div class="log-in card-panel white">

                <!-- LOG-IN FORM -->
                <form method="POST">
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="uname" type="text" class="validate" placeholder="Username/User ID">
                    </div>

                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">lock</i>
                        <input id="psword" type="password" class="validate" placeholder="Password">
                    </div>
                </form>
                <button class="btn" type="submit" id="login_button">LOG-IN</button>
            </div>

            <!-- FORGOT PASSWORD -->
            <p style="color:white;line-height:1.0;font-size:12px;">Need Access? Lost or Forgotten Password? Kindly visit the Information and Communications Technology Office (ICTO) or call 643-2557.</p>
            <!-- SOCIAL MEDIA ICONS -->
            <div id="social">
                <a class="facebookBtn smGlobalBtn" href="https://web.facebook.com/PLM.Haribon/"></a>
                <a class="twitterBtn smGlobalBtn" href="https://twitter.com/PLM_Manila"></a>
            </div>
        </div>
    </div>
    <div style="margin-bottom:3rem;">
        <p class="center" style="color:white;">Copyright © 2018.
            <br>Pamantasan ng Lungsod ng Maynila
            <br>Information and Communications Technology Office
            <br>Team SQUADCORE Batch 2019</p>
    </div>
</body>

<script src="js/jquery-3.2.1.js"></script>
<script src="js/sweetalert2.min.js"></script>
<script>
    $(document).ready(function() {

        M.updateTextFields();

        $('#uname').focus();

        $("#uname").keydown(function(e) {
            var keyCode = (event.keyCode ? event.keyCode : event.which);
            if (keyCode == 13) {
                $('#login_button').trigger('click');
            }
        });

        $("#psword").keydown(function(e) {
            var keyCode = (event.keyCode ? event.keyCode : event.which);
            if (keyCode == 13) {
                $('#login_button').trigger('click');
            }
        });

        $('#login_button').click(function() {
            $.ajax({
                url: "shared_functions_0.php",
                method: "POST",
                data: {
                    category: 'login validation',
                    username: $('#uname').val(),
                    password: $('#psword').val()
                },
                success: function(data) {
                    console.log(data);
                    if (data === 'admin') {
                        swal(
                            'Hi Admin!',
                            'Welcome to Curriculum Checker',
                            'success'
                        ).then((result) => {
                            location = 'admin.php';
                        })
                        setTimeout(function() {
                            location = 'admin.php';
                        }, 3000);
                    } else if (data === 'faculty') {
                        swal(
                            "Hi Ma'am/Sir!",
                            'Welcome to Curriculum Checker',
                            'success'
                        ).then((result) => {
                            location = 'faculty.php';
                        })
                        setTimeout(function() {
                            location = 'faculty.php';
                        }, 3000);
                    } else if (data === 'student') {
                        swal(
                            "Hey Student!",
                            'Welcome to Curriculum Checker',
                            'success'
                        ).then((result) => {
                            location = 'std-1.php';
                        })
                        setTimeout(function() {
                            location = 'std-1.php';
                        }, 3000);
                    } else {
                        swal(
                            'Invalid',
                            'Sorry, username or password not found!',
                            'error'
                        );
                    }
                }
            });
        });
    });
</script>

</html>