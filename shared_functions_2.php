<?php
include 'dbconfig.php';

$category = $_POST['category'];
$output = '';

if ($category == "accreditation delete modal fetch") {
    $subjectid = $_POST['id'];
    $_SESSION['delete-id'] = $subjectid;
    $curriculumid = $_SESSION['curriculumid'];

    $query0 = "SELECT subject, subjecttitle, clusterid1 FROM curricula1 JOIN subjects on subjects.subjectid = curricula1.subjectid where curricula1.subjectid = '$subjectid' and curriculumid = '$curriculumid' limit 1";
    $result0 = mysqli_query($conn, $query0);
    $row0 = mysqli_fetch_row($result0);
    $cluster = $row0[2];
    $clusterid = explode(', ', $cluster);

    $output .= '    <table class="highlight centered">
                        <thead>
                            <tr>
                            <th>Subject ID</th>
                            <th>Subject Code</th>
                            <th>Subject Title</th>
                            <th>Cluster Credits</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';

    for ($i = 0; $i < count($clusterid); $i++) {
        $query = "SELECT subjectid, subject, subjecttitle, credits from subjects where subjectid = '$clusterid[$i]'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($result);
        $cluster_subjectid = $row[0];
        $cluster_subject = $row[1];
        $cluster_subjecttitle = $row[2];
        $cluster_credits = $row[3];

        $output .= '<tr><td>' . $cluster_subjectid . '</td><td>' . $cluster_subject . '</td><td>' . $cluster_subjecttitle . '</td><td>' . $cluster_credits . '</td><td>';
        if ($subjectid != $cluster_subjectid) {
            $output .= '<button class="del btn tooltipped modal-trigger remove_button" data-target="delsubj" data-position="right" data-tooltip="Delete Cluster Subject" id="remove_' . $cluster_subjectid . '">
                <i class="material-icons">delete</i></button>';
        }

        $output .= '</td></tr>';
    }

    $output .= '</tbody></table>';

    echo $row0[1] . '|' . $output;
} else if ($category == "accreditation delete modal delete") {
    echo 'success';
} else if ($category == "accreditation edit modal fetch") {
    $subjectid = $_POST['id'];
    $_SESSION['edit-id'] = $subjectid;
    $curriculumid = $_SESSION['curriculumid'];

    $query0 = "SELECT subject, subjecttitle, clusterid1 FROM curricula1 JOIN subjects on subjects.subjectid = curricula1.subjectid where curricula1.subjectid = '$subjectid' and curriculumid = '$curriculumid' limit 1";
    $result0 = mysqli_query($conn, $query0);
    $row0 = mysqli_fetch_row($result0);
    $cluster = $row0[2];
    $clusterid = explode(', ', $cluster);

    $output .= '    <table class="highlight centered">
                        <thead>
                            <tr>
                            <th>Subject ID</th>
                            <th>Subject Code</th>
                            <th>Subject Title</th>
                            <th>Cluster Credits</th>
                            </tr>
                        </thead>
                        <tbody>';

    for ($i = 0; $i < count($clusterid); $i++) {
        $query = "SELECT subjectid, subject, subjecttitle, credits from subjects where subjectid = '$clusterid[$i]'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($result);
        $cluster_subjectid = $row[0];
        $cluster_subject = $row[1];
        $cluster_subjecttitle = $row[2];
        $cluster_credits = $row[3];

        $output .= '<tr><td>' . $cluster_subjectid . '</td><td>' . $cluster_subject . '</td><td>' . $cluster_subjecttitle . '</td><td>' . $cluster_credits . '</td>';
        $output .= '</tr>';
    }

    $output .= '</tbody></table>';

    echo $row0[1] . '|' . $output;
}

?>

<script>
    $('.remove_button').click(function() {
        var id = this.id;
        id = id.split('_');
        $.ajax({
            url:"shared_functions_3.php",
            method:"POST",
            data:{
                category: "accreditation delete modal delete",
                id:id[1],
                subjectid:<?php if (isset($_SESSION['delete-id'])) {
    echo $_SESSION['delete-id'];
} else {
    echo '1';
}
?>
            },
            success:function(data){
                if(data == 'success')
                    location.reload();
                else
                    alert(data);
            }
        });
    });
</script>