<?php
include 'dbconfig.php';
ini_set('max_execution_time', 60000);
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$query = "SELECT studentid FROM users WHERE login='$username' AND password='$password'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$studentid = $row[0];

$_SESSION['studentid'] = $studentid;
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PLM CRS - SUBJECT WITH DEFICIENCIES</title>
  <link rel="icon" href="images/plmlogo.png">
  <link rel="stylesheet" type="text/css" href="css/materialize.css" />
  <link rel="stylesheet" type="text/css" href="css/generalcss.css" />
  <link rel="stylesheet" type="text/css" href="css/table.css" />
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
    <h1 class="page-title">List of Deficiencies</h1><hr><br>
    <div class="tbl-div">
    <table class="highlight centered">
      <thead>
          <th>Course Code</th>
          <th>Course Title</th>
          <th>Units</th>
          <th>Status</th>
        <thead>
          <tbody>
            <?php
$query = "SELECT name, aysem, programid, yearlevel, entryaysem FROM studentterms join students on students.studentid = studentterms.studentid WHERE studentterms.studentid='$studentid' order by aysem desc limit 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$name = $row[0];
$aysem = $row[1];
$programid = $row[2];
$yearlevel = $row[3];
$entryaysem = $row[4];
$enter = '<br>';
$line = '<hr>';
$not_okay_subjects = array();

// DISPLAY STUDENT'S INFORMATION
$query = "select curriculumid from curricula_entryaysem where entryaysem = '$entryaysem' and programid = '$programid' limit 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$curriculumid = $row[0];

$query = "select curricula1.subjectid, year, sem, clusterid1, subject, subjecttitle, curricula1.credits from curricula1 join subjects on subjects.subjectid = curricula1.subjectid where curriculumid = '$curriculumid' order by year, sem";
$result = mysqli_query($conn, $query);

// GETTING SUBJECTS ON HIS/HER CURRICULUM
while ($row = mysqli_fetch_row($result)) {
    $active = 1; // Mag 0 siya pag tapos na
    $curriculum_subjectid = $row[0];
    $curriculum_subject = $row[4];
    $curriculum_subjecttitle = $row[5];
    $curriculum_units = $row[6];

    for ($i = 0; $i < 1; $i++) {
        // CHECK GRADES
        $query1 = "select * from grades where subjectid = '$curriculum_subjectid' and studentid = '$studentid' and remarks = 'PASSED' limit 1";
        $result1 = mysqli_query($conn, $query1);

        if (mysqli_num_rows($result1) > 0) {
            $row1 = mysqli_fetch_row($result1);
            $grades = $row1[4];
            $active = 0;
            break;
        }

        // CHECK CLUSTER SUBJECTS
        if ($active == 1) {
            $query1 = "select clusterid1 from curricula1 where subjectid = '$curriculum_subjectid' and curriculumid = '$curriculumid' limit 1";
            $result1 = mysqli_query($conn, $query1);
            $row1 = mysqli_fetch_row($result1);
            $cluster_subjects = $row1[0];

            $cluster_subject = explode(', ', $cluster_subjects);
            for ($i = 1; $i < count($cluster_subject); $i++) // Naka 1 siya dahil hindi na isasama si index 0 which is yung same ng subject niya, bale yung ka-cluster subject niya lang yung ichecheck.
            {
                $query1 = "select * from grades where subjectid = '$cluster_subject[$i]' and studentid = '$studentid' and remarks = 'PASSED' limit 1";
                $result1 = mysqli_query($conn, $query1);

                if (mysqli_num_rows($result1) > 0) {
                    $row1 = mysqli_fetch_row($result1);
                    $grades = $row1[4];
                    $active = 0;
                    break;
                }
            }
        }

        // CHECK INCOMPLETE SUBJECT BUT HAS A COMPLETION GRADE
        if ($active == 1) {
            $query1 = "select completiongrade from grades where subjectid = '$curriculum_subjectid' and studentid = '$studentid' and finalgrade = 'INC' limit 1";
            $result1 = mysqli_query($conn, $query1);
            if (mysqli_num_rows($result1) > 0) {
                $row1 = mysqli_fetch_row($result1);
                $inc_grade = $row1[0];

                if ($inc_grade > 0) {
                    $active = 0;
                    break;
                }
            }
        }

        // FAILED SUBJECT
        if ($active == 1) {
            $query1 = "select * from grades where gradestatus = 'F' and studentid = '$studentid' and subjectid = '$curriculum_subjectid' limit 1";
            $result1 = mysqli_query($conn, $query1);
            if (mysqli_num_rows($result1) > 0) {
                $query2 = "select clusterid1 from curricula1 where subjectid='$curriculum_subjectid' and curriculumid = '$curriculumid' limit 1";
                $result2 = mysqli_query($conn, $query2);
                $row2 = mysqli_fetch_row($result2);
                $cluster_subjects2 = $row2[0];
                $cluster_subject2 = explode(', ', $cluster_subjects2);

                for ($i = 1; $i < count($cluster_subject2); $i++) // Naka 1 siya dahil hindi na isasama si index 0 which is yung same ng subject niya, bale yung ka-cluster subject niya lang yung ichecheck.
                {
                    $query3 = "select * from grades where subjectid = '$cluster_subject2[$i]' and studentid = '$studentid' and remarks = 'PASSED' limit 1";
                    $result3 = mysqli_query($conn, $query3);

                    if (mysqli_num_rows($result3) > 0) {
                        $row3 = mysqli_fetch_row($result3);
                        $grades = $row3[4];
                        $active = 0;
                        break;
                    }
                }
            }
        }

        // CROSS ENROLLED
        if ($active == 1) {
            // GETTING FIRST THE CLUSTER SUBJECTS
            $query1 = "select clusterid1 from curricula1 where subjectid='$curriculum_subjectid' and curriculumid = '$curriculumid' limit 1";
            $result1 = mysqli_query($conn, $query1);
            $row1 = mysqli_fetch_row($result1);
            $cluster_subjects1 = $row1[0];
            $cluster_subject1 = explode(', ', $cluster_subjects1);

            for ($i = 0; $i < count($cluster_subject1); $i++) // Lahat ng subject sa cluster need dito
            {
                $query1 = "select * from cross_enrolled_subjects where studentid = '$studentid' and subjectid='$cluster_subject1[$i]' limit 1";
                $result1 = mysqli_query($conn, $query1);
                if (mysqli_num_rows($result1) > 0) {
                    $row1 = mysqli_fetch_row($result1);
                    if ($row1[4] == 'P') {
                        $active = 0;
                        break;
                    } else if ($row1[4] == 'I') {
                        $active = 0;
                        break;
                    }
                }
            }
        }

        // CURRENTLY ENROLLED
        if ($active == 1) {
            $query1 = "select studentid, classlists.classid, class from classlists join classes on classes.classid = classlists.classid where studentid = '$studentid' and subjectid = '$curriculum_subjectid' and classlists.classid like '$aysem%' limit 1";
            $result1 = mysqli_query($conn, $query1);
            if (mysqli_num_rows($result1) > 0) {
                $active = 0;
                // echo $curriculum_subjectid . " - Currently Enrolled <br>";
                echo "<tr>";
                echo "<td>" . $curriculum_subject . "</td>";
                echo "<td>" . $curriculum_subjecttitle . "</td>";
                echo "<td>" . $curriculum_units . "</td>";

                echo "<td> Currently Enrolled </td>";
                echo "</tr>";
                break;
            }
        }

        // WITH DEFICIENCY, FIND WHAT IS THE CAUSE

        if ($active == 1) {
            // CHECK FAILED GRADE
            $query1 = "select * from grades where subjectid = '$curriculum_subjectid' and studentid = '$studentid' and gradevalue = '5' limit 1";
            $result1 = mysqli_query($conn, $query1);

            if (mysqli_num_rows($result1) > 0) {
                $row1 = mysqli_fetch_row($result1);
                $grades = $row1[4];
                // echo $curriculum_subjectid . " - Failed <br>";
                echo "<tr>";
                echo "<td>" . $curriculum_subject . "</td>";
                echo "<td>" . $curriculum_subjecttitle . "</td>";
                echo "<td>" . $curriculum_units . "</td>";

                echo "<td> Failed </td>";
                echo "</tr>";
                $active = 0;
                break;
            }

            // CHECK INCOMPLETE GRADE
            $query1 = "select * from grades where subjectid = '$curriculum_subjectid' and studentid = '$studentid' and gradevalue = '4' limit 1";
            $result1 = mysqli_query($conn, $query1);

            if (mysqli_num_rows($result1) > 0) {
                $row1 = mysqli_fetch_row($result1);
                $grades = $row1[4];
                // echo $curriculum_subjectid . " - Incomplete <br>";
                echo "<tr>";
                echo "<td>" . $curriculum_subject . "</td>";
                echo "<td>" . $curriculum_subjecttitle . "</td>";
                echo "<td>" . $curriculum_units . "</td>";

                echo "<td> Incomplete </td>";
                echo "</tr>";
                $active = 0;
                break;
            }

            // echo $curriculum_subjectid . " - Not Taken <br>";
            echo "<tr>";
            echo "<td>" . $curriculum_subject . "</td>";
            echo "<td>" . $curriculum_subjecttitle . "</td>";
            echo "<td>" . $curriculum_units . "</td>";

            echo "<td> Not Taken </td>";
            echo "</tr>";
        }

    } // END OF FOR LOOP
} // END OF WHILE LOOP
?>
          </tbody>
    </table>
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
