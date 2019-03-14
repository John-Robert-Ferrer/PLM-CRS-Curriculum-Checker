<?php
include 'dbconfig.php';

$username = $_SESSION['username'];
$password = $_SESSION['password'];
$query = "SELECT studentid FROM users WHERE login='$username' AND password='$password'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$studentid = $row[0];

$query = "select students.lastname, students.firstname, students.middlename, gender, studenttype, registrationcode, label, yearlevel, programtitle, program, aysem, entryaysem, programs.programid, filename from studentterms join students on students.studentid = studentterms.studentid join programs on programs.programid = studentterms.programid join scholasticstatus on scholasticstatus.scholasticid = scholastic_status join profile_picture on profile_picture.accountid = studentterms.studentid WHERE studentterms.studentid = '$studentid' order by aysem desc limit 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);

$lastname = $row[0];
$firstname = $row[1];
$middlename = $row[2];
$gender = $row[3];
$studenttype = $row[4];
$registrationcode = $row[5];
$label = $row[6];
$yearlevel = $row[7];
$programtitle = $row[8];
$course = $row[9];
$aysem = $row[10];
$entryaysem = $row[11];
$programid = $row[12];
$semester = substr($aysem, -1);
$_SESSION['aysem'] = $aysem;
$_SESSION['studentid'] = $studentid;
$_SESSION['programid'] = $programid;
$_SESSION['entryaysem'] = $entryaysem;

$query = "select * from graduating_students where studentid = '$studentid'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $graduating = 'YES';
} else {
    $graduating = 'NO';
}

if (($yearlevel == 4 and $semester >= 2) || ($yearlevel > 4)) {
    include 'graduating_checker.php';
    $graduating = $_SESSION['graduating_status'];
} else {
    $graduating = 'NON GRADUATING';
}

if ($gender == 'M') {
    $gender = 'MALE';
} else {
    $gender = 'FEMALE';
}

if ($registrationcode == 'R') {
    $registrationcode = "REGULAR";
} else {
    $registrationcode = "IRREGULAR";
}

if ($studenttype == 'O') {
    $studenttype = "OLD";
} else if ($studenttype == 'N') {
    $studenttype = 'NEW';
} else {
    $studenttype = "TRANSFEREE";
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PLM CRS - HOME</title>
  <link rel="icon" href="images/plmlogo.png">
  <link rel="stylesheet" type="text/css" href="css/materialize.css" />
  <link rel="stylesheet" type="text/css" href="css/generalcss.css" />
  <link rel="stylesheet" type="text/css" href="css/stdcss.css" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto+Condensed" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- NAVBAR -->
  <nav>
    <div class="nav-wrapper">
      <a href="student/std-1.html" class="brand-logo center"><img src="images/plmlogo.png"></a>
      <!-- SIDENAV -->
      <?php include 'displayusertypesidemenu.php';?>
      <ul>
        <li><a href="#" data-target="slide-out" class="sidenav-trigger tooltipped" data-position="right" data-tooltip="Open Menu"><i class="material-icons">menu</i></a></li>
      </ul>
    </div>
  </nav>
  <!-- END NAVBAR -->
</head>

<body>
  <div class="container">
    <div class="row spctop">

      <div class="col s12 m12 l4 center">
        <img class="std-img img-raised rounded-circle" src="images/user2.png">
      </div>

      <!-- STUDENT'S INFORMATION -->
      <div class="col s12 m12 l8">
        <div class="card-panel std-profile ">
          <div class="card-panel std-profile-title center">
            <h2 class="std-title">Student's Information</h2>
          </div>

          <!-- FETCH DETAILS -->
          <table>
            <tbody>
              <tr>
                <td class="data-title">Name:</td>
                <td class="data"><?php echo $firstname . ' ' . $lastname; ?></td>
              </tr>
              <tr>
                <td class="data-title">Student ID:</td>
                <td class="data"><?php echo $studentid; ?></td>
              </tr>
              <tr>
                <td class="data-title">Gender:</td>
                <td class="data"><?php echo $gender; ?></td>
              </tr>
              <tr>
                <td class="data-title">Student Type:</td>
                <td class="data"><?php echo $studenttype; ?></td>
              </tr>
              <tr>
                <td class="data-title">Registration Code:</td>
                <td class="data"><?php echo $registrationcode; ?></td>
              </tr>
              <tr>
                <td class="data-title">Graduating Status:</td>
                <td class="data"><?php echo $graduating; ?></td>
              </tr>
              <tr>
                <td class="data-title">Course Code:</td>
                <td class="data"><?php echo $course; ?></td>
              </tr>
              <tr>
                <td class="data-title">Year Level:</td>
                <td class="data"><?php echo $yearlevel; ?></td>
              </tr>
            </tbody>
          </table>

        </div> <!-- END CARD-PANEL -->
      </div> <!-- END STUDENT INFO -->
    </div> <!-- END ROW -->

    <div class="row">
      <!-- ANNOUNCEMENTS -->
      <div class="col s12 m12 l6">
        <div class="card-panel announce">
          <h2 class="sub-title">Announcements</h2><hr>
        </div>
      </div>

      <!-- ANNOUNCEMENTS -->
      <div class="col s12 m12 l6">
        <div class="card-panel events">
          <h2 class="sub-title">Events</h2><hr>
        </div>
      </div>
    </div>
  </div> <!-- END CONTAINER -->

  <!-- <footer>
</footer> -->
</body>

<script src="js/jquery-latest.min.js"></script>
<script src="js/materialize.min.js"></script>
<script>
  $(document).ready(function() {
    $('.sidenav').sidenav();
    $('.tooltipped').tooltip();
  });

  function myFunction() {
  location.reload();
  }
</script>

</html>
