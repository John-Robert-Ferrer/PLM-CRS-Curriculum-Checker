<?php include 'dbconfig.php';?>
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
  <link rel="stylesheet" href="css/sweetalert2.min.css">

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

<body>
  <div class="container">
    <div class="fixed-action-btn">
  <a href="crossenrol-add.php" class="btn-floating btn-large">
    <i class="large material-icons tooltipped" data-position="left" data-tooltip="Add Student">mode_edit</i>
  </a>
  </div>

    <h1 class="page-title">Cross Enrollees</h1>
    <hr><br>
    <!-- TABLE FOR CROSS ENROLLEES -->
    <div class="tbl-div">
    <table class="highlight centered">
      <thead>
        <tr>
          <th>Student ID</th>
          <th>Student Name</th>
          <th>Subject</th>
          <th>Status</th>
          <th>Final Grade</th>
          <th>Completion Grade</th>
          <th>Cross-Erolled Subject Code</th>
          <th>AYSEM</th>
          <th>School</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
      <?php
$query = "select * from cross_enrolled_subjects order by studentid, aysem";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($result)) {
    $studentid = $row['studentid'];
    $query1 = "select name from students where studentid = " . $studentid . " LIMIT 1";
    $result1 = mysqli_query($conn, $query1);
    $name1 = mysqli_fetch_row($result1);
    $name = $name1[0];

    $schoolid = $row['schoolid'];
    $query1 = "select school_name from schools where school_id = '$schoolid' LIMIT 1";
    $result1 = mysqli_query($conn, $query1);
    $school1 = mysqli_fetch_row($result1);
    $school = $school1[0];

    $subjectid = $row['subjectid'];
    $query1 = "select subjecttitle from subjects where subjectid = '$subjectid' LIMIT 1";
    $result1 = mysqli_query($conn, $query1);
    $subjectid1 = mysqli_fetch_row($result1);
    $subjectid = $subjectid1[0];

    if ($row["status"] == 'P') {
        $status = "PASSED";
    } else {
        $status = "INCOMPLETE";
    }

    echo '<tr>';
    echo '<td>' . $row["studentid"] . '</td>';
    echo '<td>' . $name . '</td>';
    echo '<td>' . $subjectid . '</td>';
    echo '<td>' . $status . '</td>';
    echo '<td>' . $row["finalgrade"] . '</td>';
    echo '<td>' . $row["completiongrade"] . '</td>';
    echo '<td>' . $row["subjectcode"] . '</td>';
    echo '<td>' . $row["aysem"] . '</td>';
    echo '<td>' . $school . '</td>';
    echo '<td>';
    echo '<button class="del btn tooltipped delete" data-position="right" data-tooltip="Delete Student" id="delete_' . $row["id"] . '"><i class="material-icons">delete</i></button></td>';
    echo '</td>';
}
?>
      </tbody>
    </table> <!-- END TABLE -->
  </div>
  </div> <!-- END CONTAINER -->
  <div style="margin:50px;"></div>

  <!-- <footer>
</footer> -->
</body>

<script src="js/jquery-latest.min.js"></script>
<script src="js/sweetalert2.min.js"></script>
<script src="js/materialize.min.js"></script>
<script>
  $(document).ready(function() {
    $('.sidenav').sidenav();
    $('.tooltipped').tooltip();
    $('select').formSelect();
    $('.modal').modal();
    $('.fixed-action-btn').floatingActionButton();

    $('.delete').click(function(){
        var output = '';
        var id = this.id.split('_');
        id = id[1];

        $.ajax({
            url:"shared_functions_3.php",
            method:"POST",
            data:{
                category:"cross enrolled delete data",
                id:id
            },
            success:function(data){
                if(data === 'success')
                    swal('Successfully Deleted!','','success').then((result) => {
                      location.reload();
                    })
                else
                    swal('Database: Deleting Error','','error');
            }
        });
    });
  });
  function myFunction() {
  location.reload();
  }
</script>

</html>
