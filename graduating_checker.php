<?php
ini_set('max_execution_time', 0);
$studentid = $_SESSION['studentid'];
$aysem = $_SESSION['aysem'];
$semester = substr($aysem, -1);

// CHECK IF STUDENT IS IN THE DATABASE IF NOT DO THIS AND IF YES RETURN
$query = "SELECT * FROM graduating_students where studentid = '$studentid' AND aysem = '$aysem' limit 1";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $_SESSION['graduating_status'] = 'GRADUATING';
} else {
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

    $query = "select curricula1.subjectid, year, sem, clusterid1, subject, subjecttitle from curricula1 join subjects on subjects.subjectid = curricula1.subjectid where curriculumid = '$curriculumid' order by year, sem";
    $result = mysqli_query($conn, $query);

    // GETTING SUBJECTS ON HIS/HER CURRICULUM
    while ($row = mysqli_fetch_row($result)) {
        $active = 1; // Mag 0 siya pag tapos na
        $curriculum_subjectid = $row[0];
        $curriculum_subject = $row[4];
        $curriculum_subjecttitle = $row[5];

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
                    break;
                }
            }

            if ($active == 1) {
                array_push($not_okay_subjects, $curriculum_subjectid);
            }

        } // END OF FOR LOOP
    } // END OF WHILE LOOP

    // CHECK PE
    $pe = 0;
    $query1 = "select subjects.subjectid, subject, subjecttitle from grades join subjects on subjects.subjectid = grades.subjectid where studentid = '$studentid' and grades.remarks = 'PASSED' and subject like 'PE%'";
    $result1 = mysqli_query($conn, $query1);
    if (mysqli_num_rows($result1) >= 4) {
        $pe = 1;
    }

    // CHECK NSTP
    $nstp = 0;
    $query1 = "select subjects.subjectid, subject, subjecttitle from grades join subjects on subjects.subjectid = grades.subjectid where studentid = '$studentid' and grades.remarks = 'PASSED' and subject like 'NSTP%'";
    $result1 = mysqli_query($conn, $query1);
    if (mysqli_num_rows($result1) >= 2) {
        $nstp = 1;
    }

    if ((count($not_okay_subjects) > 0) || $pe == 0 || $nstp == 0) {
        $_SESSION['graduating_status'] = 'NON GRADUATING';

        for ($i = 0; $i < count($not_okay_subjects); $i++) {
            $query1 = "SELECT subject, subjecttitle from subjects where subjectid='$not_okay_subjects[$i]'";
            $result1 = mysqli_query($conn, $query1);
            $row1 = mysqli_fetch_row($result1);
        }
    } else {
        $_SESSION['graduating_status'] = 'GRADUATING';
        $query0 = "INSERT INTO graduating_students(studentid,aysem) VALUES ('$studentid','$aysem')";
        $result0 = mysqli_query($conn, $query0);
    }
} // END OF ELSE STATEMENT
