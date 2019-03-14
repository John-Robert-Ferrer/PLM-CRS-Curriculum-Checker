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
  </nav> <!-- END NAVBAR -->
</head>

<body>
  <div class="container">
    <h1 class="page-title">Subject Accreditations</h1>
    <hr><br>
    <div class="input-field col s12">
      <select id="accreditation_subject">
        <option value="" disabled selected>Choose Curriculum</option>
        <?php
$query = "select curriculumid, program, curriculum from curricula1 join programs on programs.programid = curricula1.programid group by curriculumid";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_row($result)) {
    echo '<option value="' . $row[0] . '">' . $row[1] . ' [' . $row[2] . ']</option>';
}

?>
      </select>
    </div><!-- END SELECT -->

    <!-- TABLE FOR ACCREDITED SUBJCTS -->
    <div class="tbl-div">
    <div id="display_subjects">
      <table class="highlight centered">
        <thead>
          <tr>
            <th>Subject ID</th>
            <th>Subject Code</th>
            <th>Subject Title</th>
            <th>Cluster Subjects</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>1515</td>
            <td>ENG101</td>
            <td>ENGLISH PROFICIENCY INSTRUCTION I</td>
            <td>ENG 101,</td>
            <td><button class="edit btn tooltipped modal-trigger" data-target="editsubj" data-position="left" data-tooltip="Add Cluster Subject"><i class="material-icons">edit</i></button>
              <button class="del btn tooltipped modal-trigger" data-target="delsubj" data-position="right" data-tooltip="Delete Cluster Subject"><i class="material-icons">delete</i></button></td>
          </tr>
        </tbody>
      </table> <!-- END TABLE -->
    </div>
</div>
<div style="margin:50px;"></div>
    <!-- EDIT SUBJ MODAL -->
    <div id="editsubj" class="modal modal-fixed-footer">
      <div class="modal-content">
        <h4 id="edit-modal-title" class="modal-title">ENGLISH PROFICIENCY INSTRUCTION I</h4>
        <p class="modal-details">Add Cluster Subject:</p>
        <div class="row">
        <div class="input-field col s10">
          <input id="subj_code" type="text" class="validate">
          <label for="subj_code">Enter Subject Code</label>
        </div>
        <div class="col s2">
          <button style="margin-bottom:-5px;" type="submit" class="btn submit-btn" id="edit-modal-submit-button">Submit</button>
        </div>
      </div>
      <p class="modal-details">Cluster Subject(s):</p>
      <div id="edit-modal-body"></div>
      </div> <!-- END MODAL CONTENT -->
    <div class="modal-footer">
      <button class="modal-close btn close-btn">Close</button>
    </div>
  </div> <!-- END EDIT SUBJ MODAL -->


  <!-- DELETE SUBJ MODAL -->
  <div id="delsubj" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4 id="delete-modal-title" class="modal-title">ENGLISH PROFICIENCY INSTRUCTION I</h4> <!-- PHP FOR SUBJECT TITLE OUTPUT -->
      <!-- TABLE FOR DELETE SUBJECT -->
      <div id="delete-modal-body">
      </div>
    </div>
    <div class="modal-footer">
      <button class="modal-close btn close-btn">Close</button>
    </div>
  </div><!-- END DLETE SUBJ MODAL -->
</div> <!-- END CONTAINER -->

  <!-- <footer>
</footer> -->
</body>

<script src="js/jquery-latest.min.js"></script>
<script src="js/materialize.min.js"></script>
<script src="js/sweetalert2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.sidenav').sidenav();
    $('.tooltipped').tooltip();
    $('select').formSelect();
    $('.modal').modal();
    $('#display_subjects').hide();

    var global_curriculumid;

    $('#accreditation_subject').change(function(){
      global_curriculumid = $(this).val();
      $('#display_subjects').show();
      displaySubjects(global_curriculumid);
    });

    $('#edit-modal-submit-button').click(function(){
      var id = $_GET('id');
      var subject = $('#subj_code').val();
      addAccreditSubject(global_curriculumid, id, subject);
    });

  });

  function myFunction() {
    location.reload();
  }

  function $_GET(q,s) {
      s = (s) ? s : window.location.search;
      var re = new RegExp('&amp;'+q+'=([^&amp;]*)','i');
      return (s=s.replace(/^\?/,'&amp;').match(re)) ?s=s[1] :s='';
  }

  function displaySubjects(curriculumid) {
    $.ajax({
        url:"shared_functions_1.php",
        method:"POST",
        data:{
          category: "accreditation display subjects",
          curriculumid: curriculumid
        },
        success:function(data){
          $("#display_subjects").html(data);
        }
    });
  }

  function addAccreditSubject(curriculumid, id, subject)
  {
    $.ajax({
        url:"shared_functions_0.php",
        method:"POST",
        data:{
          category: "accreditation accredit a subject",
          curriculumid: curriculumid,
          id: id,
          subject: subject
        },
        success:function(data){
          if(data === 'success')
            swal('Gotcha!','Added as an accredited subject.','success').then((result) => {
              location.reload();
            })
          else
            swal('Oops!','Subject code does not exist.','error');
        }
    });
  }

</script>

</html>
