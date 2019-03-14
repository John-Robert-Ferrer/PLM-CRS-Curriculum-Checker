<?php
include 'dbconfig.php';
ini_set('max_execution_time', 0);

$category = $_POST['category'];
$output = '';

if ($category == 'login validation') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE login='$username' AND password='$password'");

    if ($username == 'admin' && $password == 'admin') {
        $_SESSION['signed_in'] = true;
        $_SESSION['user_type'] = "admin";
        $output = 'admin';
    } else {
        if (mysqli_num_rows($query) > 0) {
            $result = mysqli_fetch_row($query);
            $_SESSION['signed_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;

            if ($result[4] == 5) {
                $_SESSION['user_type'] = "student";
                $query = mysqli_query($conn, "select registrationcode from studentterms where studentid = '$result[1]' order by aysem desc limit 1");
                $result = mysqli_fetch_row($query);

                if ($result[0] == 'I') {
                    $_SESSION['user_type'] = "irregular student";
                    $output = 'student';
                } else {
                    $_SESSION['user_type'] = "regular student";
                    $output = 'student';
                }
            } else if ($result[4] == 1) {
                $output = 'faculty';

                $query1 = "select title from faculty_designation join designation on designation.designation_id = faculty_designation.designation_id where faculty_id = " . $result[2] . " limit 1";
                $result1 = mysqli_query($conn, $query1);

                if (mysqli_num_rows($result1) > 0) {
                    $user_type = mysqli_fetch_row($result1);
                    $_SESSION['user_type'] = $user_type[0];
                } else {
                    $_SESSION['user_type'] = "faculty";
                }

            } else {
                $output = 'error';
            }

        } else {
            $output = 'error';
        }

    }

    echo $output;
} else if ($category == "accreditation accredit a subject") {
    $subjectid = $_POST['id'];
    $curriculumid = $_POST['curriculumid'];
    $subject = $_POST['subject'];

    $query = "SELECT clusterid1 FROM curricula1 WHERE subjectid = '$subjectid' AND curriculumid = '$curriculumid'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $cluster = explode(', ', $row[0]);

    $query = "SELECT subjectid FROM subjects WHERE subject = '$subject' AND subjectid NOT IN ($row[0])";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_row($result);
        array_push($cluster, $row[0]);
        $clusters = '';

        for ($i = 0; $i < count($cluster); $i++) {
            $clusters .= $cluster[$i];

            if ($i == count($cluster) - 1) {
                break;
            } else {
                ;
            }

            $clusters .= ', ';
        }

        $query = "UPDATE curricula1 SET clusterid1 = '$clusters' WHERE subjectid = '$subjectid' AND curriculumid = '$curriculumid'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo 'success';
        } else {
            echo 'error';
        }

    } else {
        echo 'not found';
    }

} else if ($category == "cross enrollee insert data") {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $grade_status = $_POST['grade_status'];
    $subject_code = $_POST['subject_code'];
    $aysem = $_POST['aysem'];
    $school = $_POST['school'];
    $final_grade = $_POST['final_grade'];
    $completion_grade = $_POST['final_grade'];

    $query = "SELECT subjectid FROM subjects WHERE subject = '$subject_id'";
    $result = mysqli_query($conn, $query);
    $subject_id = mysqli_fetch_row($result);
    $subject_id = $subject_id[0];

    if ($grade_status == 'P') {
        $query = "INSERT INTO cross_enrolled_subjects(studentid, subjectid, finalgrade, status, subjectcode, aysem, schoolid) VALUES ('$student_id', '$subject_id', '$final_grade', '$grade_status', '$subject_code', '$aysem', '$school')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo 'SUCCESS!';
        }

    } else if ($grade_status == 'I') {
        $query = "INSERT INTO cross_enrolled_subjects(studentid, subjectid, completiongrade, status, subjectcode, aysem, schoolid) VALUES ('$student_id', '$subject_id', '$completion_grade', '$grade_status', '$subject_code', '$aysem', '$school')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo 'SUCCESS!';
        }

    }
} else if ($category == "student deficiencies filter get courses") {
    $unitid = $_POST['unitid'];
    $query = "select programs.programid, programs.programtitle from studentterms join programs on programs.programid = studentterms.programid where aysem = 20172 and studentterms.unitid = '" . $unitid . "'group by studentterms.programid";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $output = '';
        while ($row = mysqli_fetch_row($result)) {
            $output .= $row[0] . '|' . $row[1] . '|||';
        }

        echo $output;
    }
} else if ($category == "student deficiencies fetch students with deficiencies") {
    $unitid = $_POST['unitid'];
    $programid = $_POST['programid'];
    $output = '';

    $query = "  SELECT student_with_deficiency.studentid, name, program, unit, yearlevel
                    FROM student_with_deficiency
                    JOIN students ON student_with_deficiency.studentid = students.studentid
                    JOIN studentterms ON studentterms.studentid = student_with_deficiency.studentid
                    JOIN programs ON programs.programid = studentterms.programid
                    JOIN units ON units.unitid = studentterms.unitid
                    WHERE programs.programid = " . $programid . " AND units.unitid = " . $unitid . "
                    GROUP BY student_with_deficiency.studentid
                    ORDER BY units.unit, programs.program, studentterms.aysem DESC, name ASC";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result)) {
        $output = ' <table class="highlight centered">
                            <thead>
                                <tr>
                                <th>Subject ID</th>
                                <th>Name</th>
                                <th>Course</th>
                                <th>College</th>
                                <th>Year</th>
                                <th>Deficiencies</th>
                                </tr>
                            </thead>

                            <tbody>';

        while ($row = mysqli_fetch_row($result)) {
            $output .= '<tr>';
            $output .= '<td>';
            $output .= $row[0];
            $output .= '</td>';
            $output .= '<td>';
            $output .= $row[1];
            $output .= '</td>';
            $output .= '<td>';
            $output .= $row[2];
            $output .= '</td>';
            $output .= '<td>';
            $output .= $row[3];
            $output .= '</td>';
            $output .= '<td>';
            $output .= $row[4];
            $output .= '</td>';
            $query1 = "select subject from student_with_deficiency join subjects on subjects.subjectid = student_with_deficiency.deficiency where studentid = '$row[0]'";
            $result1 = mysqli_query($conn, $query1);
            $output .= '<td>';
            $ctr_deficiency = 0;
            if (mysqli_num_rows($result1) > 0) {
                while ($row1 = mysqli_fetch_row($result1)) {
                    $ctr_deficiency++;
                    if ($ctr_deficiency < 100) {
                        $output .= $row1[0] . ', ';
                    } else {
                        break;
                    }

                }
            } else {
                $output .= "PE/NSTP ";
            }

            $output .= '</td>';
            $output .= '</tr>';
        }

        $output .= '</tbody></table>';
    } else {
        $output = "<h5 style='text-align: center;'>Opps! No data found..</h5>";
    }

    echo $output;
} else if ($category == "generate graduating students get all students") {
    $aysem = $_POST['aysem'];
    $programid = $_POST['programid'];
    $_SESSION['counter_limit'] = 0; // TO REINITIALIZE THE VALUE OF SESSION
    $students_id = array();

    if ($programid == 999999) {
        $query = "select programid from curricula1 group by curriculumid";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_row($result)) {
            $programid = $row[0];
            $query0 = "SELECT studentterms.studentid FROM studentterms join students on students.studentid = studentterms.studentid join programs on programs.programid = studentterms.programid where aysem = '$aysem' and studentterms.programid = '$programid' and yearlevel >= programs.numyears group by studentterms.studentid order by students.name asc";
            $result0 = mysqli_query($conn, $query0);

            while ($row0 = mysqli_fetch_row($result0)) {
                array_push($students_id, $row0[0]);
            }

        }

        print json_encode($students_id);
    } else {
        $query0 = "SELECT studentterms.studentid FROM studentterms join students on students.studentid = studentterms.studentid join programs on programs.programid = studentterms.programid where aysem = '$aysem' and studentterms.programid = '$programid' and yearlevel >= programs.numyears group by studentterms.studentid order by students.name asc";
        $result0 = mysqli_query($conn, $query0);

        while ($row0 = mysqli_fetch_row($result0)) {
            array_push($students_id, $row0[0]);
        }

        print json_encode($students_id);
    }
} else if ($category == "generate graduating students generate this student") {
    ini_set('max_execution_time', 600000);

    $limit = $_POST['limit'];
    $studentid = $_POST['student_id'];
    // echo '<li>'.$studentid.'</li>';
    $aysem = $_POST['aysem'];
    $counter_limit = $_SESSION['counter_limit'];

    // echo $counter_limit . "/" . $limit;
    // START

    if ($counter_limit != $limit) {
        $query0 = "SELECT studentterms.studentid, name, yearlevel FROM studentterms join students on students.studentid = studentterms.studentid where aysem = '$aysem' and studentterms.studentid = '$studentid' limit 1";
        $result0 = mysqli_query($conn, $query0);
        $row0 = mysqli_fetch_row($result0);

        // check if nasa db na, if yes then exit
        $query = "SELECT * FROM graduating_students WHERE studentid='$studentid' and aysem='$aysem'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            echo '<li>' . $row0[0] . ' | ' . $row0[1] . ' | YEAR: ' . $row0[2] . '</li>';
            $_SESSION['counter_limit'] = $_SESSION['counter_limit'] + 1;
        } else {
            $query = "SELECT name, aysem, programid, yearlevel, entryaysem, registrationcode FROM studentterms join students on students.studentid = studentterms.studentid WHERE studentterms.studentid='$studentid' order by aysem desc limit 1";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($result);
            $name = $row[0];
            $aysem = $row[1];
            $programid = $row[2];
            $yearlevel = $row[3];
            $entryaysem = $row[4];
            $registrationcode = $row[5];
            $enter = '<br>';
            $line = '<hr>';
            $not_okay_subjects = array();

            // CHECK IF THE STUDENT IS IRREGULAR, IF YES, PROCEED
            if ($registrationcode == 'I') {
                // CHECK IF THERE'S EXISTING DATA IN THE DATABASE, DELETE IF THERE'S EXISTING DATA
                $query1 = "SELECT * FROM student_with_deficiency WHERE studentid = '$studentid' AND aysem = '$aysem'";
                $result1 = mysqli_query($conn, $query1);
                if (mysqli_num_rows($result1) > 0) {
                    $query1 = "DELETE FROM student_with_deficiency WHERE studentid = '$studentid' AND aysem = '$aysem'";
                    $result1 = mysqli_query($conn, $query1);
                }

                // DISPLAY STUDENT'S INFORMATION
                $query = "select curriculumid from curricula_entryaysem where entryaysem = '$entryaysem' and programid = '$programid' limit 1";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_row($result);
                $curriculumid = $row[0];

                $query = "select subjectid, clusterid1 from curricula1 where curriculumid = '$curriculumid' and curricula1.subjectid not in (select subjectid from grades where studentid = '$studentid' and gradestatus = 'P')
                    and curricula1.subjectid not in (select subjectid from classes join classlists on classes.classid = classlists.classid where classlists.studentid = '$studentid' and classes.classid like '" . $aysem . "%')";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_row($result)) {
                    $check = 1;
                    $cluster_subject = explode(', ', $row[1]);

                    // INCOMPLETE AND FAILED
                    // FAILED KASI CHINECHECK NI SYSTEM LAHAT NG BAGSAK NIYA SA ACCREDITTED SUBJECTS AND HINAHANAP NIYA IF PASSED
                    for ($i = 1; $i < count($cluster_subject); $i++) {
                        $query1 = "SELECT gradestatus, completiongrade FROM GRADES WHERE subjectid = '$cluster_subject[$i]' AND studentid = '$studentid' limit 1";
                        $result1 = mysqli_query($conn, $query1);
                        $row1 = mysqli_fetch_row($result1);
                        // GRADESTATUS
                        if (($row1[0] == 'I' && $row1[1] >= 1.00 && $row1[1] <= 3.00) || ($row1[0] == 'P')) {
                            $check = 0;
                            break;
                        }
                    }

                    // CROSS-ENROLLED
                    if ($check == 1) {
                        for ($i = 0; $i < count($cluster_subject); $i++) // Lahat ng subject sa cluster need dito
                        {
                            $query1 = "select subjectid from cross_enrolled_subjects where studentid = '$studentid' and subjectid='$cluster_subject[$i]' limit 1";
                            $result1 = mysqli_query($conn, $query1);
                            if (mysqli_num_rows($result1) > 0) {
                                $row1 = mysqli_fetch_row($result1);
                                // if($row1[4] == 'P')
                                // {
                                //     $check = 0;
                                //     break;
                                // }
                                // else if($row1[4] == 'I')
                                // {
                                //     // KULANG PA, DAPAT MAY ADD PA NG CHECKING IF PASADO BA YUNG COMPLETION GRADE NYA
                                //     $check = 0;
                                //     break;
                                // }
                            }
                        }
                    }

                    if ($check == 1) {
                        array_push($not_okay_subjects, $row[0]);
                    }

                }

                // CHECK PE
                $pe = 0;
                $query1 = "select distinct(subject) from grades join subjects on subjects.subjectid = grades.subjectid where studentid = '$studentid' and grades.remarks = 'PASSED' and subject like 'PE%'";
                $result1 = mysqli_query($conn, $query1);
                if (mysqli_num_rows($result1) >= 4) {
                    $pe = 1;
                } else {
                    array_push($not_okay_subjects, 'PE');
                }

                // CHECK NSTP
                $nstp = 0;
                $query1 = "select distinct(subject) from grades join subjects on subjects.subjectid = grades.subjectid where studentid = '$studentid' and grades.remarks = 'PASSED' and subject like 'NSTP%'";
                $result1 = mysqli_query($conn, $query1);
                if (mysqli_num_rows($result1) >= 2) {
                    $nstp = 1;
                } else {
                    array_push($not_okay_subjects, 'NSTP');
                }

                if ((count($not_okay_subjects) > 0) || $pe == 0 || $nstp == 0) {
                    // $_SESSION['graduating_status']='NON GRADUATING';
                    // echo 'NON GRADUATING <br>';
                    // echo '<li>'.$row0[0].' - '.$row0[1].'</li>';

                    for ($i = 0; $i < count($not_okay_subjects); $i++) {
                        // $query1 = "SELECT subject, subjecttitle from subjects where subjectid='$not_okay_subjects[$i]' limit 1";
                        // $result1 = mysqli_query($conn, $query1);
                        // $row1 = mysqli_fetch_row($result1);
                        $query2 = "INSERT INTO student_with_deficiency(studentid,aysem,deficiency) VALUES ('$studentid', '$aysem', '$not_okay_subjects[$i]')";
                        $result2 = mysqli_query($conn, $query2);
                    }
                } else {
                    // echo $row0[0].' - '.$row0[1].' - GRADUATING <br>';
                    $_SESSION['counter_limit'] = $_SESSION['counter_limit'] + 1;
                    echo '<li>' . $row0[0] . ' | ' . $row0[1] . ' | YEAR: ' . $row0[2] . '</li>';
                    // $_SESSION['graduating_status']='GRADUATING';

                    $query9 = "INSERT INTO graduating_students(studentid,aysem) VALUES ('$studentid','$aysem')";
                    $result9 = mysqli_query($conn, $query9);
                }
            } // END OF, IF THE STUDENT IS IRREGULAR
            else if ($registrationcode == 'R') {
                $_SESSION['counter_limit'] = $_SESSION['counter_limit'] + 1;
                echo '<li>' . $row0[0] . ' | ' . $row0[1] . ' | YEAR: ' . $row0[2] . '</li>';
                $query9 = "INSERT INTO graduating_students(studentid,aysem) VALUES ('$studentid','$aysem')";
                $result9 = mysqli_query($conn, $query9);
            }
        } // END OF ELSE STATEMENT IN CHECKING SA DATABASE KUNG NASA LIST NA SIYA
    }
} else if ($category == "view list of graduating students show table") {
    $unitid = $_POST['unitid'];
    $programid = $_POST['programid'];
    $aysem = $_POST['aysem'];
    $output = '';
    $table_type;

    if ($unitid == 1111 && $programid == 1111) {
        $query = "SELECT graduating_students.studentid, name, program, units.unit, graduating_students.aysem FROM graduating_students join students on graduating_students.studentid=students.studentid join studentterms on studentterms.studentid = graduating_students.studentid join programs on programs.programid = studentterms.programid join units on units.unitid = studentterms.unitid WHERE studentterms.aysem = " . $aysem . " group by studentid order by units.unit, programs.program, name";
        $table_type = "aysem";
    } else if ($programid == "all_courses") {
        $query = "SELECT graduating_students.studentid, name, program, units.unit, graduating_students.aysem FROM graduating_students join students on graduating_students.studentid=students.studentid join studentterms on studentterms.studentid = graduating_students.studentid join programs on programs.programid = studentterms.programid join units on units.unitid = studentterms.unitid WHERE units.unitid = " . $unitid . " AND studentterms.aysem = " . $aysem . " group by studentid order by units.unit, programs.program, name";
        $table_type = "aysem_college";
    } else {
        $query = "SELECT graduating_students.studentid, name, program, units.unit, graduating_students.aysem FROM graduating_students join students on graduating_students.studentid=students.studentid join studentterms on studentterms.studentid = graduating_students.studentid join programs on programs.programid = studentterms.programid join units on units.unitid = studentterms.unitid WHERE units.unitid = " . $unitid . " AND programs.programid = " . $programid . " AND studentterms.aysem = " . $aysem . " group by studentid order by units.unit, programs.program, name";
        $table_type = "aysem_college_course";
    }

    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        if ($table_type == "aysem") {
            $output = '     <table class="highlight centered">
                                <thead>
                                    <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Course</th>
                                    <th>College</th>
                                    </tr>
                                </thead>

                                <tbody>';

            while ($row = mysqli_fetch_row($result)) {
                $output .= '<tr>';
                $output .= '<td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>' . $row[2] . '</td><td>' . $row[3] . '</td>';
                $output .= '</tr>';
            }
        } else if ($table_type == "aysem_college") {
            $output = ' <table class="highlight centered">
                                <thead>
                                    <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Course</th>
                                    </tr>
                                </thead>

                                <tbody>';

            while ($row = mysqli_fetch_row($result)) {
                $output .= '<tr>';
                $output .= '<td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>' . $row[2] . '</td>';
                $output .= '</tr>';
            }
        } else if ($table_type == "aysem_college_course") {
            $output = ' <table class="highlight centered">
                                <thead>
                                    <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    </tr>
                                </thead>

                                <tbody>';

            while ($row = mysqli_fetch_row($result)) {
                $output .= '<tr>';
                $output .= '<td>' . $row[0] . '</td><td>' . $row[1] . '</td>';
                $output .= '</tr>';
            }
        }
        $output .= '</tbody></table>';
    } else {
        $output = "<h5 style='text-align: center;'>Opps! No data found..</h5>";
    }

    echo $output;
}
