<?php
include 'dbconfig.php';

$category = $_POST['category'];
$output = '';

if ($category == "accreditation delete modal delete") {
    $cluster_subjectid = $_POST['id'];
    $subjectid = $_POST['subjectid'];
    $curriculumid = $_SESSION['curriculumid'];

    $query = "SELECT clusterid1 FROM curricula1 WHERE subjectid = '$subjectid' AND curriculumid = '$curriculumid'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $cluster_subject = explode(', ', $row[0]);
    $new_clusterid1 = '';

    for ($i = 0; $i < count($cluster_subject); $i++) {
        if ($cluster_subject[$i] == $cluster_subjectid) {
            $new_clusterid1 = str_replace(", " . $cluster_subject[$i], "", $row[0]);
        }

    }

    $query = "UPDATE curricula1 SET clusterid1 = '$new_clusterid1' WHERE subjectid = '$subjectid'";
    $result = mysqli_query($conn, $query);

    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }

} else if ($category == "cross enrolled delete data") {
    $id = $_POST['id'];
    $query = "DELETE FROM cross_enrolled_subjects WHERE id = '$id'";
    if ($result = mysqli_query($conn, $query)) {
        echo "success";
    }

}
