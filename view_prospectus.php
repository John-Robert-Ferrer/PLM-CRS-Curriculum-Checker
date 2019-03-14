<?php
include 'dbconfig.php';
$studentid = $_SESSION['studentid'];

$query = "SELECT name, aysem, studentterms.programid, yearlevel, studenttype, registrationcode, entryaysem, unitname, programtitle FROM studentterms join students on students.studentid = studentterms.studentid join units on units.unitid=studentterms.unitid join programs on programs.programid = studentterms.programid WHERE studentterms.studentid='$studentid' order by aysem desc limit 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$name = $row[0];
$aysem = $row[1];
$programid = $row[2];
$yearlevel = $row[3];
$studenttype = $row[4];
$registrationcode = $row[5];
$semester = substr($aysem, -1);
$entryaysem = $row[6];
$college = $row[7];
$course = $row[8];

$query = "select curriculumid from curricula_entryaysem where entryaysem = '$entryaysem' and programid = '$programid'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$curriculumid = $row[0];
?>
<!DOCTYPE html>
<html>
<head>
  <style>
    body{
      margin: 0cm;
      size: letter;
      font-family: Helvetica;
      padding: 0px;
      line-height: 1;
    }

    @page{
      size: letter;
      margin: 0.5cm 0cm;
    }

    div td{
        border:none;
        padding:3px;
        font-family: Helvetica;
      }

    .table1,th,td{
      border: 1px solid black;
      border-collapse: collapse;
      padding:3px;
      font-family: Helvetica;
    }

    .cent{
      text-align:center;
    }

    .end-year{
      page-break-after: always;
    }
  </style>
</head>


<body>
  <center><b>
  <?php
// echo '<div style="margin-bottom: 10px;">PAMANTASAN NG LUNGSOD NG MAYNILA</div>'.$college.'<br>'.$course.'<br><br>';
?>
  </b></center>
  <div>
    <table style="width:70%;" align="center">
    <tr>
      <td colspan="11">NAME:</td>
      <td colspan="6">DATE ENTERED:</td>
    </tr>
    <tr>
    <td colspan="11">STUDENT NUMBER:</td>
    <td colspan="6">TOTAL UNITS:</td>
  </tr>
</table>
</div>
<br>

<!-- Prospectus   -->
<table class="table1" style="width:70%;" align="center">
  <caption><b>First Year, First Semester</b></caption>
  <tr class="cent table1">
    <th colspan="3" width="15%">COURSE CODE</th>
    <th colspan="8" width="50%">COURSE TITLE</th>
    <th width="5%">UNITS</th>
    <th colspan="4" width="25%">PRE(CO)-REQUISITES</th>
    <th colspan="2" width="5%">GRADE</th>
  </tr>
  <!-- insert loop for data -->
  <?php
$totalunits = 0;
$query = "SELECT subject, subjecttitle, curricula1.credits, prerequisites FROM curricula1 join subjects on subjects.subjectid = curricula1.subjectid where curriculumid = '$curriculumid' and year = 1 and sem = 1";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_row($result)) {
    echo '<tr>
              <td colspan="3">' . $row[0] . '</td>
              <td colspan="8">' . $row[1] . '</td>
              <td class="cent">' . $row[2] . '</td>';
    $totalunits += $row[2];

    if ($row[3] == 'none') {
        echo '<td colspan="4"></td>';
    } else if ($row[3] == '3rd year standing') {
        echo '<td colspan="4">3RD YEAR STANDING</td>';
    } else if ($row[3] == '4th year standing') {
        echo '<td colspan="4">4TH YEAR STANDING</td>';
    } else if ($row[3] == 'incoming 3rd year') {
        echo '<td colspan="4">INCOMING 3RD YEAR</td>';
    } else {
        $cluster_subjects = $row[3];
        $cluster_subject = explode(', ', $cluster_subjects);
        $cluster_name = '';
        for ($i = 0; $i < count($cluster_subject); $i++) {
            $query1 = mysqli_query($conn, "SELECT subject from subjects where subjectid = '$cluster_subject[$i]'");
            $row1 = mysqli_fetch_row($query1);
            $cluster_name .= $row1[0] . ', ';
        }
        echo '<td class="cent" colspan="4" style="text-align: left">' . $cluster_name . '</td>';
    }

    echo '<td class="cent" colspan="2"></td>
            </tr>';
}
?>

  <tr><td colspan="3">PED 11</td><td colspan="8">Foundation of Physical Activities</td><td class="cent">(2)</td><td colspan="4"></td><td colspan="2"></td></tr>
  <tr><td colspan="3">NSTP 11</td><td colspan="8">ROTC/CWTS</td><td class="cent">(3)</td><td colspan="4"></td><td colspan="2"></td></tr>
  <tr>
    <td colspan="3"></td>
    <td colspan="8" style="text-align:right">TOTAL</td>
    <td class="cent"><?php echo $totalunits; ?></td>
    <td colspan="4"></td>
    <td class="cent" colspan="2"></td>
  </tr>
</table>

  <br>
<!-- First Year Second Semester -->
<table class="table1 end-year" style="width:70%;" align="center">
  <caption><b>First Year, Second Semester</b></caption>
  <tr class="cent table1">
    <th colspan="3" width="15%">COURSE CODE</th>
    <th colspan="8" width="50%">COURSE TITLE</th>
    <th width="5%">UNITS</th>
    <th colspan="4" width="25%">PRE(CO)-REQUISITES</th>
    <th colspan="2" width="5%">GRADE</th>
  </tr>
  <!-- insert loop for data -->
  <?php
$totalunits = 0;
$query = "SELECT subject, subjecttitle, curricula1.credits, prerequisites FROM curricula1 join subjects on subjects.subjectid = curricula1.subjectid where curriculumid = '$curriculumid' and year = 1 and sem = 2";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_row($result)) {
    echo '<tr>
              <td colspan="3">' . $row[0] . '</td>
              <td colspan="8">' . $row[1] . '</td>
              <td class="cent">' . $row[2] . '</td>';
    $totalunits += $row[2];

    if ($row[3] == 'none') {
        echo '<td colspan="4"></td>';
    } else if ($row[3] == '3rd year standing') {
        echo '<td colspan="4">3RD YEAR STANDING</td>';
    } else if ($row[3] == '4th year standing') {
        echo '<td colspan="4">4TH YEAR STANDING</td>';
    } else if ($row[3] == 'incoming 3rd year') {
        echo '<td colspan="4">INCOMING 3RD YEAR</td>';
    } else {
        $cluster_subjects = $row[3];
        $cluster_subject = explode(', ', $cluster_subjects);
        $cluster_name = '';
        for ($i = 0; $i < count($cluster_subject); $i++) {
            $query1 = mysqli_query($conn, "SELECT subject from subjects where subjectid = '$cluster_subject[$i]'");
            $row1 = mysqli_fetch_row($query1);
            $cluster_name .= $row1[0] . ', ';
        }
        echo '<td class="cent" colspan="4" style="text-align: left">' . $cluster_name . '</td>';
    }

    echo '<td class="cent" colspan="2"></td>
            </tr>';
}
?>

  <tr><td colspan="3">PED</td><td colspan="8">PE Elective (12, 13, 14)</td><td class="cent">(2)</td><td colspan="4">PED 11</td><td colspan="2"></td></tr>
  <tr><td colspan="3">NSTP 12</td><td colspan="8">ROTC/CWTS</td><td class="cent">(3)</td><td colspan="4"></td><td colspan="2"></td></tr>
  <tr>
    <td colspan="3"></td>
    <td colspan="8" style="text-align:right">TOTAL</td>
    <td class="cent"><?php echo $totalunits; ?></td>
    <td colspan="4"></td>
    <td class="cent" colspan="2"></td>
  </tr>
</table>

<br>
<table class="table1" style="width:70%;" align="center">
  <caption><b>Second Year, First Semester</b></caption>
  <tr class="cent table1">
    <th colspan="3" width="15%">COURSE CODE</th>
    <th colspan="8" width="50%">COURSE TITLE</th>
    <th width="5%">UNITS</th>
    <th colspan="4" width="25%">PRE(CO)-REQUISITES</th>
    <th colspan="2" width="5%">GRADE</th>
  </tr>
  <!-- insert loop for data -->
  <?php
$totalunits = 0;
$query = "SELECT subject, subjecttitle, curricula1.credits, prerequisites FROM curricula1 join subjects on subjects.subjectid = curricula1.subjectid where curriculumid = '$curriculumid' and year = 2 and sem = 1";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_row($result)) {
    echo '<tr>
              <td colspan="3">' . $row[0] . '</td>
              <td colspan="8">' . $row[1] . '</td>
              <td class="cent">' . $row[2] . '</td>';
    $totalunits += $row[2];

    if ($row[3] == 'none') {
        echo '<td colspan="4"></td>';
    } else if ($row[3] == '3rd year standing') {
        echo '<td colspan="4">3RD YEAR STANDING</td>';
    } else if ($row[3] == '4th year standing') {
        echo '<td colspan="4">4TH YEAR STANDING</td>';
    } else if ($row[3] == 'incoming 3rd year') {
        echo '<td colspan="4">INCOMING 3RD YEAR</td>';
    } else {
        $cluster_subjects = $row[3];
        $cluster_subject = explode(', ', $cluster_subjects);
        $cluster_name = '';
        for ($i = 0; $i < count($cluster_subject); $i++) {
            $query1 = mysqli_query($conn, "SELECT subject from subjects where subjectid = '$cluster_subject[$i]'");
            $row1 = mysqli_fetch_row($query1);
            $cluster_name .= $row1[0] . ', ';
        }
        echo '<td class="cent" colspan="4" style="text-align: left">' . $cluster_name . '</td>';
    }

    echo '<td class="cent" colspan="2"></td>
            </tr>';
}
?>
  <tr><td colspan="3">PED</td><td colspan="8">PE Elective (12, 13, 14)</td><td class="cent">(2)</td><td colspan="4">PED 11</td><td colspan="2"></td></tr>
  <tr>
    <td colspan="3"></td>
    <td colspan="8" style="text-align:right">TOTAL</td>
    <td class="cent"><?php echo $totalunits; ?></td>
    <td colspan="4"></td>
    <td class="cent" colspan="2"></td>
  </tr>
</table>

<br>
<table class="table1 end-year" style="width:70%;" align="center">
  <caption><b>Second Year, Second Semester</b></caption>
  <tr class="cent table1">
    <th colspan="3" width="15%">COURSE CODE</th>
    <th colspan="8" width="50%">COURSE TITLE</th>
    <th width="5%">UNITS</th>
    <th colspan="4" width="25%">PRE(CO)-REQUISITES</th>
    <th colspan="2" width="5%">GRADE</th>
  </tr>
  <!-- insert loop for data -->
  <?php
$totalunits = 0;
$query = "SELECT subject, subjecttitle, curricula1.credits, prerequisites FROM curricula1 join subjects on subjects.subjectid = curricula1.subjectid where curriculumid = '$curriculumid' and year = 2 and sem = 2";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_row($result)) {
    echo '<tr>
              <td colspan="3">' . $row[0] . '</td>
              <td colspan="8">' . $row[1] . '</td>
              <td class="cent">' . $row[2] . '</td>';
    $totalunits += $row[2];

    if ($row[3] == 'none') {
        echo '<td colspan="4"></td>';
    } else if ($row[3] == '3rd year standing') {
        echo '<td colspan="4">3RD YEAR STANDING</td>';
    } else if ($row[3] == '4th year standing') {
        echo '<td colspan="4">4TH YEAR STANDING</td>';
    } else if ($row[3] == 'incoming 3rd year') {
        echo '<td colspan="4">INCOMING 3RD YEAR</td>';
    } else {
        $cluster_subjects = $row[3];
        $cluster_subject = explode(', ', $cluster_subjects);
        $cluster_name = '';
        for ($i = 0; $i < count($cluster_subject); $i++) {
            $query1 = mysqli_query($conn, "SELECT subject from subjects where subjectid = '$cluster_subject[$i]'");
            $row1 = mysqli_fetch_row($query1);
            $cluster_name .= $row1[0] . ', ';
        }
        echo '<td class="cent" colspan="4" style="text-align: left">' . $cluster_name . '</td>';
    }

    echo '<td class="cent" colspan="2"></td>
            </tr>';
}
?>
  <tr><td colspan="3">PED</td><td colspan="8">PE Elective (12, 13, 14)</td><td class="cent">(2)</td><td colspan="4">PED 11</td><td colspan="2"></td></tr>
  <tr>
    <td colspan="3"></td>
    <td colspan="8" style="text-align:right">TOTAL</td>
    <td class="cent"><?php echo $totalunits; ?></td>
    <td colspan="4"></td>
    <td class="cent" colspan="2"></td>
  </tr>
</table>

<br>
<table class="table1" style="width:70%;" align="center">
  <caption><b>Third Year, First Semester</b></caption>
  <tr class="cent table1">
    <th colspan="3" width="15%">COURSE CODE</th>
    <th colspan="8" width="50%">COURSE TITLE</th>
    <th width="5%">UNITS</th>
    <th colspan="4" width="25%">PRE(CO)-REQUISITES</th>
    <th colspan="2" width="5%">GRADE</th>
  </tr>
  <!-- insert loop for data -->
  <?php
$totalunits = 0;
$query = "SELECT subject, subjecttitle, curricula1.credits, prerequisites FROM curricula1 join subjects on subjects.subjectid = curricula1.subjectid where curriculumid = '$curriculumid' and year = 3 and sem = 1";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_row($result)) {
    echo '<tr>
              <td colspan="3">' . $row[0] . '</td>
              <td colspan="8">' . $row[1] . '</td>
              <td class="cent">' . $row[2] . '</td>';
    $totalunits += $row[2];

    if ($row[3] == 'none') {
        echo '<td colspan="4"></td>';
    } else if ($row[3] == '3rd year standing') {
        echo '<td colspan="4">3RD YEAR STANDING</td>';
    } else if ($row[3] == '4th year standing') {
        echo '<td colspan="4">4TH YEAR STANDING</td>';
    } else if ($row[3] == 'incoming 3rd year') {
        echo '<td colspan="4">INCOMING 3RD YEAR</td>';
    } else {
        $cluster_subjects = $row[3];
        $cluster_subject = explode(', ', $cluster_subjects);
        $cluster_name = '';
        for ($i = 0; $i < count($cluster_subject); $i++) {
            $query1 = mysqli_query($conn, "SELECT subject from subjects where subjectid = '$cluster_subject[$i]'");
            $row1 = mysqli_fetch_row($query1);
            $cluster_name .= $row1[0] . ', ';
        }
        echo '<td class="cent" colspan="4" style="text-align: left">' . $cluster_name . '</td>';
    }

    echo '<td class="cent" colspan="2"></td>
            </tr>';
}
?>

  <tr>
    <td colspan="3"></td>
    <td colspan="8" style="text-align:right">TOTAL</td>
    <td class="cent"><?php echo $totalunits; ?></td>
    <td colspan="4"></td>
    <td class="cent" colspan="2"></td>
  </tr>
</table>

<br>
<table class="table1" style="width:70%;" align="center">
  <caption><b>Third Year, Second Semester</b></caption>
  <tr class="cent table1">
    <th colspan="3" width="15%">COURSE CODE</th>
    <th colspan="8" width="50%">COURSE TITLE</th>
    <th width="5%">UNITS</th>
    <th colspan="4" width="25%">PRE(CO)-REQUISITES</th>
    <th colspan="2" width="5%">GRADE</th>
  </tr>
  <!-- insert loop for data -->
  <?php
$totalunits = 0;
$query = "SELECT subject, subjecttitle, curricula1.credits, prerequisites FROM curricula1 join subjects on subjects.subjectid = curricula1.subjectid where curriculumid = '$curriculumid' and year = 3 and sem = 2";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_row($result)) {
    echo '<tr>
              <td colspan="3">' . $row[0] . '</td>
              <td colspan="8">' . $row[1] . '</td>
              <td class="cent">' . $row[2] . '</td>';
    $totalunits += $row[2];

    if ($row[3] == 'none') {
        echo '<td colspan="4"></td>';
    } else if ($row[3] == '3rd year standing') {
        echo '<td colspan="4">3RD YEAR STANDING</td>';
    } else if ($row[3] == '4th year standing') {
        echo '<td colspan="4">4TH YEAR STANDING</td>';
    } else if ($row[3] == 'incoming 3rd year') {
        echo '<td colspan="4">INCOMING 3RD YEAR</td>';
    } else {
        $cluster_subjects = $row[3];
        $cluster_subject = explode(', ', $cluster_subjects);
        $cluster_name = '';
        for ($i = 0; $i < count($cluster_subject); $i++) {
            $query1 = mysqli_query($conn, "SELECT subject from subjects where subjectid = '$cluster_subject[$i]'");
            $row1 = mysqli_fetch_row($query1);
            $cluster_name .= $row1[0] . ', ';
        }
        echo '<td class="cent" colspan="4" style="text-align: left">' . $cluster_name . '</td>';
    }

    echo '<td class="cent" colspan="2"></td>
            </tr>';
}
?>

  <tr>
    <td colspan="3"></td>
    <td colspan="8" style="text-align:right">TOTAL</td>
    <td class="cent"><?php echo $totalunits; ?></td>
    <td colspan="4"></td>
    <td class="cent" colspan="2"></td>
  </tr>
</table>

<br>
<table class="table1 end-year" style="width:70%;" align="center">
  <caption><b>Third Year, Summer</b></caption>
  <tr class="cent table1">
    <th colspan="3" width="15%">COURSE CODE</th>
    <th colspan="8" width="50%">COURSE TITLE</th>
    <th width="5%">UNITS</th>
    <th colspan="4" width="25%">PRE(CO)-REQUISITES</th>
    <th colspan="2" width="5%">GRADE</th>
  </tr>
  <!-- insert loop for data -->
  <?php
$totalunits = 0;
$query = "SELECT subject, subjecttitle, curricula1.credits, prerequisites FROM curricula1 join subjects on subjects.subjectid = curricula1.subjectid where curriculumid = '$curriculumid' and year = 3 and sem = 3";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_row($result)) {
    echo '<tr>
              <td colspan="3">' . $row[0] . '</td>
              <td colspan="8">' . $row[1] . '</td>
              <td class="cent">' . $row[2] . '</td>';
    $totalunits += $row[2];

    if ($row[3] == 'none') {
        echo '<td colspan="4"></td>';
    } else if ($row[3] == '3rd year standing') {
        echo '<td colspan="4">3RD YEAR STANDING</td>';
    } else if ($row[3] == '4th year standing') {
        echo '<td colspan="4">4TH YEAR STANDING</td>';
    } else if ($row[3] == 'incoming 4th year') {
        echo '<td colspan="4">INCOMING 4TH YEAR</td>';
    } else {
        $cluster_subjects = $row[3];
        $cluster_subject = explode(', ', $cluster_subjects);
        $cluster_name = '';
        for ($i = 0; $i < count($cluster_subject); $i++) {
            $query1 = mysqli_query($conn, "SELECT subject from subjects where subjectid = '$cluster_subject[$i]'");
            $row1 = mysqli_fetch_row($query1);
            $cluster_name .= $row1[0] . ', ';
        }
        echo '<td class="cent" colspan="4" style="text-align: left">' . $cluster_name . '</td>';
    }

    echo '<td class="cent" colspan="2"></td>
            </tr>';
}
?>

  <tr>
    <td colspan="3"></td>
    <td colspan="8" style="text-align:right">TOTAL</td>
    <td class="cent"><?php echo $totalunits; ?></td>
    <td colspan="4"></td>
    <td class="cent" colspan="2"></td>
  </tr>
</table>

<br>
<table class="table1" style="width:70%;" align="center">
  <caption><b>Fourth Year, First Semester</b></caption>
  <tr class="cent table1">
    <th colspan="3" width="15%">COURSE CODE</th>
    <th colspan="8" width="50%">COURSE TITLE</th>
    <th width="5%">UNITS</th>
    <th colspan="4" width="25%">PRE(CO)-REQUISITES</th>
    <th colspan="2" width="5%">GRADE</th>
  </tr>
  <!-- insert loop for data -->
  <?php
$totalunits = 0;
$query = "SELECT subject, subjecttitle, curricula1.credits, prerequisites FROM curricula1 join subjects on subjects.subjectid = curricula1.subjectid where curriculumid = '$curriculumid' and year = 4 and sem = 1";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_row($result)) {
    echo '<tr>
              <td colspan="3">' . $row[0] . '</td>
              <td colspan="8">' . $row[1] . '</td>
              <td class="cent">' . $row[2] . '</td>';
    $totalunits += $row[2];

    if ($row[3] == 'none') {
        echo '<td colspan="4"></td>';
    } else if ($row[3] == '3rd year standing') {
        echo '<td colspan="4">3RD YEAR STANDING</td>';
    } else if ($row[3] == '4th year standing') {
        echo '<td colspan="4">4TH YEAR STANDING</td>';
    } else if ($row[3] == 'incoming 3rd year') {
        echo '<td colspan="4">INCOMING 3RD YEAR</td>';
    } else {
        $cluster_subjects = $row[3];
        $cluster_subject = explode(', ', $cluster_subjects);
        $cluster_name = '';
        for ($i = 0; $i < count($cluster_subject); $i++) {
            $query1 = mysqli_query($conn, "SELECT subject from subjects where subjectid = '$cluster_subject[$i]'");
            $row1 = mysqli_fetch_row($query1);
            $cluster_name .= $row1[0] . ', ';
        }
        echo '<td class="cent" colspan="4" style="text-align: left">' . $cluster_name . '</td>';
    }

    echo '<td class="cent" colspan="2"></td>
            </tr>';
}
?>

  <tr>
    <td colspan="3"></td>
    <td colspan="8" style="text-align:right">TOTAL</td>
    <td class="cent"><?php echo $totalunits; ?></td>
    <td colspan="4"></td>
    <td class="cent" colspan="2"></td>
  </tr>
</table>

<br>
<table class="table1" style="width:70%;" align="center">
  <caption><b>Fourth Year, Second Semester</b></caption>
  <tr class="cent table1">
    <th colspan="3" width="15%">COURSE CODE</th>
    <th colspan="8" width="50%">COURSE TITLE</th>
    <th width="5%">UNITS</th>
    <th colspan="4" width="25%">PRE(CO)-REQUISITES</th>
    <th colspan="2" width="5%">GRADE</th>
  </tr>
  <!-- insert loop for data -->
  <?php
$totalunits = 0;
$query = "SELECT subject, subjecttitle, curricula1.credits, prerequisites FROM curricula1 join subjects on subjects.subjectid = curricula1.subjectid where curriculumid = '$curriculumid' and year = 4 and sem = 2";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_row($result)) {
    echo '<tr>
              <td colspan="3">' . $row[0] . '</td>
              <td colspan="8">' . $row[1] . '</td>
              <td class="cent">' . $row[2] . '</td>';
    $totalunits += $row[2];

    if ($row[3] == 'none') {
        echo '<td colspan="4"></td>';
    } else if ($row[3] == '3rd year standing') {
        echo '<td colspan="4">3RD YEAR STANDING</td>';
    } else if ($row[3] == '4th year standing') {
        echo '<td colspan="4">4TH YEAR STANDING</td>';
    } else if ($row[3] == 'incoming 3rd year') {
        echo '<td colspan="4">INCOMING 3RD YEAR</td>';
    } else {
        $cluster_subjects = $row[3];
        $cluster_subject = explode(', ', $cluster_subjects);
        $cluster_name = '';
        for ($i = 0; $i < count($cluster_subject); $i++) {
            $query1 = mysqli_query($conn, "SELECT subject from subjects where subjectid = '$cluster_subject[$i]'");
            $row1 = mysqli_fetch_row($query1);
            $cluster_name .= $row1[0] . ', ';
        }
        echo '<td class="cent" colspan="4" style="text-align: left">' . $cluster_name . '</td>';
    }

    echo '<td class="cent" colspan="2"></td>
            </tr>';
}
?>

  <tr>
    <td colspan="3"></td>
    <td colspan="8" style="text-align:right">TOTAL</td>
    <td class="cent"><?php echo $totalunits; ?></td>
    <td colspan="4"></td>
    <td class="cent" colspan="2"></td>
  </tr>
</table>

<br><br><center>
<button id="print" style="padding: 5px 15px; font-size: 20px; font-family: segoe ui;">PRINT</button>
</center><br><br>
  <script src="js/jquery-3.2.1.js"></script>
  <script>
    $('#print').click(function(){
        $(this).css("visibility", "hidden");
        print();
        $(this).css("visibility", "visible");
    });
  </script>
</body>
</html>