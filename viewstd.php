<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PLM CRS - HOME</title>
  <link rel="icon" href="images/plmlogo.png">
  <link rel="stylesheet" type="text/css" href="css/materialize.css" />
  <link rel="stylesheet" type="text/css" href="css/generalcss.css" />
  <link rel="stylesheet" type="text/css" href="css/admincss.css" />
  <link href="https://fonts.googleapis.com/css?family=Hind|Roboto+Condensed" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="css/animate.css">

  <!-- NAVBAR -->
  <nav>
    <div class="nav-wrapper">
      <a href="student/admin-1.html" class="brand-logo center"><img src="images/plmlogo.png"></a>
      <!-- SIDENAV -->
      <?php include 'displayusertypesidemenu.php';?>
      <ul>
        <li><a href="#" data-target="slide-out" class="sidenav-trigger tooltipped" data-position="right" data-tooltip="Open Menu"><i class="material-icons">menu</i></a></li>
      </ul>
    </div>
  </nav>
  <!-- END NAVBAR -->
</head>

<body style="background-color:rgb(214, 214, 214);">
  <div class="container">
    <!-- VIEW CARD -->
    <div class="row">
      <div class="col s3"></div>
      <div class="card-panel view-card center col s12 m12 l6" id="add_shake_effect">
        <div class="card-panel view-card-title center">
          <h2 class="view-title">View Student Information</h2>
          <div class="input-field col s12 view-content">
            <i class="material-icons prefix">search</i>
            <input placeholder="Enter Student Number" type="number" id="student_number" class="validate">
            <label for="first_name">Student Number:</label>
          </div>

          <button class="btn btn-large submit-btn" id="submit_button">Submit</button>
        </div>
      </div> <!-- END CARD-PANEL -->
    </div>
  </div> <!-- END CONTAINER -->

  <!-- <footer>
</footer> -->
</body>

<script src="js/jquery-latest.min.js"></script>
<script src="js/materialize.min.js"></script>

<script>
$(document).ready(function() {
  M.updateTextFields();

  $('#login_button').click(function(){
      $.ajax({
        url:"shared_functions_0.php",
        method:"POST",
        data: {
          category: 'login validation',
          username: $('#uname').val(),
          password: $('#psword').val()
        },
        success:function(data){
          console.log(data);
          if(data === 'admin')
          {
            swal(
              'Hi Admin!',
              'Welcome to Curriculum Checker',
              'success'
            ).then((result) => {
              location = 'admin.php';
            })
            setTimeout(function(){ location = 'admin.php'; }, 3000);
          }
          else if(data === 'faculty')
          {
            swal(
              "Hi Ma'am/Sir!",
              'Welcome to Curriculum Checker',
              'success'
            ).then((result) => {
              location = 'faculty.php';
            })
            setTimeout(function(){ location = 'faculty.php'; }, 3000);
          }
          else if(data === 'student')
          {
            swal(
              "Hey Student!",
              'Welcome to Curriculum Checker',
              'success'
            ).then((result) => {
              location = 'std-1.php';
            })
            setTimeout(function(){ location = 'std-1.php'; }, 3000);
          }
          else
          {
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
<script>
  $(document).ready(function() {
    $('.sidenav').sidenav();
    $('.tooltipped').tooltip();
    $('#student_number').focus();

    $("#student_number").keydown(function (e) {
      var keyCode = (event.keyCode ? event.keyCode : event.which);
      if (keyCode == 13) {
        var student_number = $('#student_number').val();
        validateStudentNumber(student_number);
      }
    });

    $('#submit_button').click(function(){
      var student_number = $('#student_number').val();
      // alert(student_number);
      // window.history.replaceState(null, null, "view_checklist.php?student_number=" + student_number);

      if(student_number > 100000000)
        location = "view_checklist.php?student_number=" + student_number;
      else
      {
        setTimeout(function(){
          $('#add_shake_effect').addClass('animated shake');
        }, 0);
        $('#add_shake_effect').removeClass('animated shake');
      }
    });

    function validateStudentNumber(student_number) {
      if(student_number > 100000000)
          $('#submit_button').trigger('click');
      else
      {
        setTimeout(function(){
          $('#add_shake_effect').addClass('animated shake');
        }, 0);
        $('#add_shake_effect').removeClass('animated shake');
      }
    }
  });

  function myFunction() {
    location.reload();
  }
</script>

</html>
