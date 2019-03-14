<?php
include 'dbconfig.php';

$category = $_POST['category'];
$output = '';

if ($category == "accreditation display subjects") {
    $curriculumid = $_POST['curriculumid'];
    $_SESSION['curriculumid'] = $curriculumid;
    $output = '';
    $output .= '    <table class="highlight centered">
                            <thead>
                            <tr>
                                <th>Subjectid</th>
                                <th>Subject Code</th>
                                <th>Subject Title</th>
                                <th>Cluster Subjects</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>';

    $query = "SELECT curricula1.subjectid, subject, subjecttitle, clusterid1 from curricula1 join subjects on subjects.subjectid = curricula1.subjectid where curriculumid='$curriculumid'";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_row($result)) {
        $subjectid = $row[0];
        $subject = $row[1];
        $subjecttitle = $row[2];
        $cluster = $row[3];
        $clusterid = explode(', ', $cluster);
        $cluster_subjects = '';

        for ($i = 0; $i < count($clusterid); $i++) {
            $query1 = "SELECT subject from subjects where subjectid = '$clusterid[$i]'";
            $result1 = mysqli_query($conn, $query1);
            $row1 = mysqli_fetch_row($result1);
            $cluster_subjects .= $row1[0] . ', ';
        }

        $output .= '<tr>
                            <td>' . $subjectid . '</td>
                            <td>' . $subject . '</td>
                            <td>' . $subjecttitle . '</td>
                            <td>' . $cluster_subjects . '</td>
                            <td><button class="edit edit_button btn tooltipped modal-trigger" data-target="editsubj" data-position="left" data-tooltip="Add Cluster Subject" id="add_' . $subjectid . '"><i class="material-icons">edit</i></button>
                            <button class="del delete_button btn tooltipped modal-trigger" data-target="delsubj" data-position="right" data-tooltip="Delete Cluster Subject" id="delete_' . $subjectid . '"><i class="material-icons">delete</i></button></td>
                        </tr>';
    }

    $output .= '</tbody>
      </table>';

    echo $output;
}

// TEMPLATE
// else if($category == "")
// {}
?>

<!-- NEEDED SCRIPTS -->
<script>
    $('.delete_button').click(function() {
        var id = this.id;
        id = id.split('_');

        $.ajax({
            url:"shared_functions_2.php",
            method:"POST",
            data:{
                category: "accreditation delete modal fetch",
                id:id[1]
            },
            success:function(data){
                var data = data.split('|');
                $("#delete-modal-title").html(data[0]);
                $("#delete-modal-body").html(data[1]);
            }
        });
    });

    $('.edit_button').click(function() {
        var id = this.id;
        id = id.split('_');
        window.history.replaceState(null, null, "accreditation.php?id=" + id[1]);

        $.ajax({
            url:"shared_functions_2.php",
            method:"POST",
            data:{
                category: "accreditation edit modal fetch",
                id:id[1]
            },
            success:function(data){
                var data = data.split('|');
                $("#edit-modal-title").html(data[0]);
                $("#edit-modal-body").html(data[1]);
            }
        });
    });
</script>
