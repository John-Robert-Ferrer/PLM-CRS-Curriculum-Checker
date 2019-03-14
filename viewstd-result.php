<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PLM CRS - STUDENT INFORMATION</title>
  <link rel="icon" href="images/plmlogo.png">
  <link rel="stylesheet" type="text/css" href="css/materialize.css" />
  <link rel="stylesheet" type="text/css" href="css/generalcss.css" />
  <link rel="stylesheet" type="text/css" href="css/admincss.css" />
  <link href="https://fonts.googleapis.com/css?family=Hind|Roboto+Condensed" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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

  <style>
  h5,h6{
    font-family: 'Hind', sans-serif!important;
  }
  </style>
</head>


<body>
  <div class="fixed-action-btn">
    <a  class="btn-floating btn-large" onclick="printDiv('printableArea')">
      <i class="large material-icons tooltipped" data-position="left" data-tooltip="Print">print</i>
    </a>
  </div>

<div id="printableArea">
  <div class="container center-align">
    <h5>Student Information</h5>
    <!-- STUDENT INFO TABLE -->
    <table class="highlight centered">
      <thead>
        <th>Student ID</th>
        <th>Name</th>
        <th>Year</th>
        <th>Student Type</th>
        <th>Regitration Code</th>
        <th>Entry AYSEM</th>
        <th>Course</th>
        <th>College</th>
      </thead>

      <tbody>
        <tr>
          <td>201502417</td>
          <td>JOHN DOE</td>
          <td>3</td>
          <td>OLD</td>
          <td>REGULAR</td>
          <td>20151</td>
          <td>BSCS-IT</td>
          <td>CET</td>
          <tr>
      </tbody>
    </table> <!-- END STUDENT INFO TABLE -->
    <br>

    <!-- GRADES TABLE -->
    <h6>First Year, First Semester</h6>
    <table class="highlight centered">
      <thead>
        <th>Course Code</th>
        <th>Course Title</th>
        <th>Units</th>
        <th>Pre(Co)-Requisites</th>
        <th>Grade</th>
      </thead>

      <tbody>
        <tr>
          <td>CHEM 11.1A</td>
          <td>GENERAL CHEMISTRY (LABORATORY)</td>
          <td>1</td>
          <td></td>
          <td>1.50</td>
          <tr>
      </tbody>
    </table> <!-- END TABLE -->

    <!-- GRADES TABLE -->
    <h6>First Year, Second Semester</h6>
    <table class="highlight centered">
      <thead>
        <th>Course Code</th>
        <th>Course Title</th>
        <th>Units</th>
        <th>Pre(Co)-Requisites</th>
        <th>Grade</th>
      </thead>

      <tbody>
        <tr>
          <td>CHEM 11.1A</td>
          <td>GENERAL CHEMISTRY (LABORATORY)</td>
          <td>1</td>
          <td></td>
          <td>1.50</td>
          <tr>
      </tbody>
    </table> <!-- END TABLE -->
    <br>

    <!-- GRADES TABLE -->
    <h6>Second Year, First Semester</h6>
    <table class="highlight centered">
      <thead>
        <th>Course Code</th>
        <th>Course Title</th>
        <th>Units</th>
        <th>Pre(Co)-Requisites</th>
        <th>Grade</th>
      </thead>

      <tbody>
        <tr>
          <td>CHEM 11.1A</td>
          <td>GENERAL CHEMISTRY (LABORATORY)</td>
          <td>1</td>
          <td></td>
          <td>1.50</td>
          <tr>
      </tbody>
    </table> <!-- END TABLE -->

    <!-- GRADES TABLE -->
    <h6>Second Year, Second Semester</h6>
    <table class="highlight centered">
      <thead>
        <th>Course Code</th>
        <th>Course Title</th>
        <th>Units</th>
        <th>Pre(Co)-Requisites</th>
        <th>Grade</th>
      </thead>

      <tbody>
        <tr>
          <td>CHEM 11.1A</td>
          <td>GENERAL CHEMISTRY (LABORATORY)</td>
          <td>1</td>
          <td></td>
          <td>1.50</td>
          <tr>
      </tbody>
    </table> <!-- END TABLE -->
    <br>

    <!-- GRADES TABLE -->
    <h6>Third Year, First Semester</h6>
    <table class="highlight centered">
      <thead>
        <th>Course Code</th>
        <th>Course Title</th>
        <th>Units</th>
        <th>Pre(Co)-Requisites</th>
        <th>Grade</th>
      </thead>

      <tbody>
        <tr>
          <td>CHEM 11.1A</td>
          <td>GENERAL CHEMISTRY (LABORATORY)</td>
          <td>1</td>
          <td></td>
          <td>1.50</td>
          <tr>
      </tbody>
    </table> <!-- END TABLE -->

    <!-- GRADES TABLE -->
    <h6>Third Year, Second Semester</h6>
    <table class="highlight centered">
      <thead>
        <th>Course Code</th>
        <th>Course Title</th>
        <th>Units</th>
        <th>Pre(Co)-Requisites</th>
        <th>Grade</th>
      </thead>

      <tbody>
        <tr>
          <td>CHEM 11.1A</td>
          <td>GENERAL CHEMISTRY (LABORATORY)</td>
          <td>1</td>
          <td></td>
          <td>1.50</td>
          <tr>
      </tbody>
    </table> <!-- END TABLE -->
    <br>

    <!-- GRADES TABLE -->
    <h6>Fourth Year, First Semester</h6>
    <table class="highlight centered">
      <thead>
        <th>Course Code</th>
        <th>Course Title</th>
        <th>Units</th>
        <th>Pre(Co)-Requisites</th>
        <th>Grade</th>
      </thead>

      <tbody>
        <tr>
          <td>CHEM 11.1A</td>
          <td>GENERAL CHEMISTRY (LABORATORY)</td>
          <td>1</td>
          <td></td>
          <td>1.50</td>
          <tr>
      </tbody>
    </table> <!-- END TABLE -->

    <!-- GRADES TABLE -->
    <h6>Fourth Year, Second Semester</h6>
    <table class="highlight centered">
      <thead>
        <th>Course Code</th>
        <th>Course Title</th>
        <th>Units</th>
        <th>Pre(Co)-Requisites</th>
        <th>Grade</th>
      </thead>

      <tbody>
        <tr>
          <td>CHEM 11.1A</td>
          <td>GENERAL CHEMISTRY (LABORATORY)</td>
          <td>1</td>
          <td></td>
          <td>1.50</td>
          <tr>
      </tbody>
    </table> <!-- END TABLE -->

    <br><br>
    <!-- TABLE SUMMARY -->
    <table class="highlight centered">
      <thead>
        <th>Total Units Taken</th>
        <th>Overall GWA</th>
        <th>Status</th>
        <th>Running for Latin Honor</th>
      </thead>

      <tbody>
        <tr>
          <td>123</td>
          <td>1.75</td>
          <td>GRADUATING/NON</td>
          <td>YES/NO</td>
          <tr>
      </tbody>
    </table> <!-- END STUDENT INFO TABLE -->

  </div> <!-- END CONTAINER -->
</div> <!-- END PRINTABLE AREA -->
  <!-- <footer>
</footer> -->
<div style="margin:50px;"></div>
</body>

<script src="js/jquery-latest.min.js"></script>
<script src="js/materialize.min.js"></script>


<script>
  $(document).ready(function() {
    $('.sidenav').sidenav();
    $('.tooltipped').tooltip();
    $('.fixed-action-btn').floatingActionButton();

    $('#submit_button').click(function(){
      var student_number = $('#student_number').val();
      window.history.replaceState(null, null, "viewstd.php?student_number=" + student_number);
    });
  });

  function myFunction() {
    location.reload();
  }

  function printDiv(divName) {
       var printContents = document.getElementById(divName).innerHTML;
       var originalContents = document.body.innerHTML;

       document.body.innerHTML = printContents;
       window.print();
       document.body.innerHTML = originalContents;
  }

</script>

</html>
