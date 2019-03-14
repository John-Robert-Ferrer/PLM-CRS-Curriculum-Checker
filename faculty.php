<?php
include 'dbconfig.php';

$username = $_SESSION['username'];
$password = $_SESSION['password'];
$query = "SELECT employeeid FROM users WHERE login='$username' AND password='$password'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$employeeid = $row[0];

$query = "select lastname, firstname, middlename, gender, birthdate, civilstatus, citizenshipcid, rank_name from employees join rank on rank.rankid = employees.rank where employeeid = '$employeeid' limit 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);

$lastname = $row[0];
$firstname = $row[1];
$middlename = $row[2];
$gender = $row[3];
$birthdate = $row[4];
$civilstatus = $row[5];
$citizenship = $row[6];
$rank = $row[7];

if ($gender == 'M') {
    $gender = 'MALE';
} else {
    $gender = 'FEMALE';
}

if ($citizenship == 'PH') {
    $citizenship = "PHILIPPINES";
} else {
    $citizenship = "FOREIGN COUNTRY";
}

if ($civilstatus == 'S') {
    $civilstatus = "SINGLE";
} else if ($civilstatus == 'M') {
    $civilstatus = 'MARRIED';
} else {
    $civilstatus = "SINGLE";
}

$_SESSION['employeeid'] = $employeeid;
$_SESSION['lastname'] = $lastname;
$_SESSION['firstname'] = $firstname;
$_SESSION['middlename'] = $middlename;
$_SESSION['gender'] = $gender;
$_SESSION['birthdate'] = $gender;
$_SESSION['civistatus'] = $gender;
$_SESSION['citizenship'] = $gender;
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
  <link rel="stylesheet" type="text/css" href="css/facultycss.css" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto+Condensed" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- NAVBAR -->
  <nav>
    <div class="nav-wrapper">
      <a href="student/fac-1.html" class="brand-logo center"><img src="images/plmlogo.png"></a>
      <!-- SIDENAV -->
      <?php include 'displayusertypesidemenu.php';?>
        <li>
          <a href="#" data-target="slide-out" class="sidenav-trigger tooltipped" data-position="right" data-tooltip="Open Menu">
            <i class="material-icons">menu</i>
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- END NAVBAR -->
</head>

<body>
  <div class="container">
    <div class="row spctop">

      <div class="col s12 m12 l4 center">
        <img class="fac-img img-raised rounded-circle" src="images/user.png">
      </div>

      <!-- EMPLOYEE'S INFORMATION -->
      <div class="col s12 m12 l8">
        <div class="card-panel fac-profile ">
          <div class="card-panel fac-profile-title center">
            <h2 class="fac-title">Employee Information</h2>
          </div>

          <!-- FETCH DETAILS -->
          <table>
            <tbody>
              <tr>
                <td class="data-title">Name:</td>
                <td class="data"><?php echo $firstname . ' ' . $lastname; ?></td>
              </tr>
              <tr>
                <td class="data-title">Employee ID:</td>
                <td class="data"><?php echo $employeeid; ?></td>
              </tr>
              <tr>
                <td class="data-title">Gender:</td>
                <td class="data"><?php echo $gender; ?></td>
              </tr>
              <tr>
                <td class="data-title">Civil Status:</td>
                <td class="data"><?php echo $civilstatus; ?></td>
              </tr>
              <tr>
                <td class="data-title">Citizenship:</td>
                <td class="data"><?php echo $citizenship; ?></td>
              </tr>
              <tr>
                <td class="data-title">Birthdate:</td>
                <td class="data"><?php echo $birthdate; ?></td>
              </tr>
              <tr>
                <td class="data-title">Rank Title:</td>
                <td class="data"><?php echo $rank; ?></td>
              </tr>
            </tbody>
          </table>

        </div> <!-- END CARD-PANEL -->
      </div> <!-- END EMPLOYEE INFO -->
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
