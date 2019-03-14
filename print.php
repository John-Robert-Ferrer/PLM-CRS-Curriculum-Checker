<?php
include 'dbconfig.php';
$aysem = $_GET['aysem'];
$college = $_GET['college'];
$course = $_GET['course'];
$output = '';

if (substr($aysem, -1) == 1) {
    $semester = "1st Semester";
} else if (substr($aysem, -1) == 2) {
    $semester = "2nd Semester";
} else if (substr($aysem, -1) == 3) {
    $semester = "Summer";
} else {
    $semester = "NO AYSEM FOUND!";
}

$initial_year = substr($aysem, 0, 4);

// START

if ($college == "all_students") {
    $output = '
            <h1 class="print-title">List of Graduating Students</h1>
            <h2 class="print-subtitle">for S.Y. ' . $initial_year . '-' . ($initial_year + 1) . ', ' . $semester . '</h2>

            <table>
                <thead>
                <th>Student ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>College</th>
                </thead>
                <tbody>
        ';

    $query = "SELECT graduating_students.studentid, name, program, units.unit FROM graduating_students join students on graduating_students.studentid=students.studentid join studentterms on studentterms.studentid = graduating_students.studentid join programs on programs.programid = studentterms.programid join units on units.unitid = studentterms.unitid WHERE studentterms.aysem = " . $aysem . " group by studentid order by units.unit, programs.program, name";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_row($result)) {
            $output .= '<tr>';
            $output .= '<td>' . $row[0] . '</td>';
            $output .= '<td>' . $row[1] . '</td>';
            $output .= '<td>' . $row[2] . '</td>';
            $output .= '<td>' . $row[3] . '</td>';
            $output .= '</tr>';
        }
    }

    $output .= '
                </tbody>
            </table>
        ';
} else if ($course == "all_courses") {
    $query = "select unitname from units where unitid=" . $college . " limit 1";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $college_name = mysqli_fetch_row($result);
    }

    $output = '
            <h1 class="print-title">List of Graduating Students</h1>
            <h2 class="print-subtitle">for S.Y. ' . $initial_year . '-' . ($initial_year + 1) . ', ' . $semester . '</h2>
            IN THE ' . $college_name[0] . '</h2><br>

            <table>
                <thead>
                <th>Student ID</th>
                <th>Name</th>
                <th>Course</th>
                </thead>
                <tbody>
        ';

    $query = "SELECT graduating_students.studentid, name, program, units.unit, graduating_students.aysem FROM graduating_students join students on graduating_students.studentid=students.studentid join studentterms on studentterms.studentid = graduating_students.studentid join programs on programs.programid = studentterms.programid join units on units.unitid = studentterms.unitid WHERE units.unitid = " . $college . " AND studentterms.aysem = " . $aysem . " group by studentid order by units.unit, programs.program, name";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_row($result)) {
            $output .= '<tr>';
            $output .= '<td>' . $row[0] . '</td>';
            $output .= '<td>' . $row[1] . '</td>';
            $output .= '<td>' . $row[2] . '</td>';
            $output .= '</tr>';
        }
    }

    $output .= '
                </tbody>
            </table>
        ';
} else {
    $query = "select unitname from units where unitid=" . $college . " limit 1";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $college_name = mysqli_fetch_row($result);
    }

    $query = "select programtitle from programs where programid=" . $course . " limit 1";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $course_name = mysqli_fetch_row($result);
    }

    $output = '
            <h1 class="print-title">List of Graduating Students</h1>
            <h2 class="print-subtitle">for S.Y. ' . $initial_year . '-' . ($initial_year + 1) . ', ' . $semester . '</h2>
            IN THE ' . $college_name[0] . '</h2>
            <br>' . $course_name[0] . '</h2><br><br>

            <table>
                <thead>
                <th>Student ID</th>
                <th>Name</th>
                </thead>
                <tbody>
        ';

    $query = "SELECT graduating_students.studentid, name, program, units.unit, graduating_students.aysem FROM graduating_students join students on graduating_students.studentid=students.studentid join studentterms on studentterms.studentid = graduating_students.studentid join programs on programs.programid = studentterms.programid join units on units.unitid = studentterms.unitid WHERE units.unitid = " . $college . " AND programs.programid = " . $course . " AND studentterms.aysem = " . $aysem . " group by studentid order by units.unit, programs.program, name";
    $table_type = "aysem_college_course";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_row($result)) {
            $output .= '<tr>';
            $output .= '<td>' . $row[0] . '</td>';
            $output .= '<td>' . $row[1] . '</td>';
            $output .= '<td>' . $row[2] . '</td>';
            $output .= '</tr>';
        }
    }

    $output .= '
                </tbody>
            </table>
        ';
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/materialize.css" />
  <link rel="stylesheet" type="text/css" href="css/print.css" />
  <script src="js/materialize.js"></script>
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto+Condensed" rel="stylesheet">
  <link rel="icon" href="images/plmlogo.png">
</head>

<body onload="print(); location = 'viewgradlist.php'">
<div class="container center"><?php echo $output; ?></div>

    <script src="js/jquery-3.2.1.js"></script>
    <script>
        function getQueryVariable(variable)
        {
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            for (var i=0;i<vars.length;i++) {
                    var pair = vars[i].split("=");
                    if(pair[0] == variable){return pair[1];}
            }
            return(false);
        }

        function getInitialValues(){
            var aysem = getQueryVariable('aysem');
            var college = getQueryVariable('college');
            var course = getQueryVariable('course');
        }
        // getInitialValues();
    </script>
</body>
</html>
