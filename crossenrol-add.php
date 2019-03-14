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
    <h1 class="page-title">Add Cross-Enrollee</h1>
    <hr><br>
    <div class="row">
    <div class="input-field col s12">
      <input placeholder="Please Enter Student ID/No. of Cross-Enrollee" id="std-id" type="text" class="validate">
      <label for="std-id">Student ID:</label>
    </div>
  </div>

    <div class="row">
      <div class="input-field col s12 m12 l6">
        <input placeholder="Enter Subject Code" id="esubj-id" type="text" class="validate">
        <label for="std-id">Equivalent Subject (PLM):</label>
      </div>
      <div class="input-field col s12 m12 l6">
        <input placeholder="Enter Subject Code" id="osubj-id" type="text" class="validate">
        <label for="std-id">Subject Code (From other School):</label>
      </div>
    </div>

    <div class="row">
      <div class="input-field col s12 m12 l6">
        <select id="grade-status">
          <option value="" disabled selected>Select Status of Grade</option>
          <option value="P">Passed</option>
          <option value="I">Incomplete</option>
        </select>
        <label>Grade Status:</label>
      </div>
      <div class="input-field col s12 m12 l6" id="div-final-grade">
        <select id="final-grade">
          <option value="" disabled selected>Select Final Grade</option>
          <option value="1">1.00</option>
          <option value="2">1.25</option>
          <option value="3">1.50</option>
          <option value="4">1.75</option>
          <option value="5">2.00</option>
          <option value="6">2.25</option>
          <option value="7">2.50</option>
          <option value="8">2.75</option>
          <option value="9">3.00</option>
        </select>
        <label>Final Grade:</label>
      </div>
    </div>

    <div class="row">
      <div class="input-field col s12 m12 l6">
        <select id="aysem">
          <option value="" disabled selected>Select AYSEM</option>
          <option value="20183">20183</option>
          <option value="20181">20182</option>
          <option value="20181">20181</option>
          <option value="20173">20173</option>
          <option value="20172">20172</option>
          <option value="20171">20171</option>
          <option value="20163">20163</option>
          <option value="20162">20162</option>
          <option value="20161">20161</option>
          <option value="20153">20153</option>
          <option value="20152">20152</option>
          <option value="20151">20151</option>
        </select>
        <label>AYSEM:</label>
      </div>
      <div class="input-field col s12 m12 l6">
        <input placeholder="Enter Name of School/University" id="school-name" type="text" class="validate">
        <label for="std-id">School where Subject Taken:</label>
      </div>
    </div>

    <div class="row"><button class="btn submit-btn btn-large col s12 m12 l12" id="add_button">Add Cross-Enrollee</button></div>

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

    $('#add_button').click(function(){
      addCrossEnrollee();
    });

    $('#grade-status').change(function(){
      if(this.value == "I")
        $('#div-final-grade').hide();
      else
        $('#div-final-grade').show();
    });
  });

  function addCrossEnrollee(){
    var student_id = $('#std-id').val();
    var subject_id = $('#esubj-id').val();
    var grade_status = $('#grade-status').val();
    var final_grade = $('#final-grade').val();
    var subject_code = $('#osubj-id').val();
    var aysem = $('#aysem').val();
    var school = $('#school-name').val();

    if(student_id == '' || subject_id == '' || grade_status == null || subject_code == '' || aysem == null || school == null || (final_grade == null && completion_grade == null))
        swal('Please complete all the details','','warning');
    else
    {
        $.ajax({
            url:"shared_functions_0.php",
            method:"POST",
            data:{
                category: "cross enrollee insert data",
                student_id:student_id,
                subject_id:subject_id,
                grade_status:grade_status,
                subject_code:subject_code,
                aysem:aysem,
                school:school,
                final_grade:final_grade
            },
            success:function(data){
                if(data == 'SUCCESS!')
                {
                  swal('Successfully Added!','','success').then((result) => {
                  location = "crossenrol.php";
                  })
                }
                else
                  swal('Database: Inserting Error','','error');
            }
        });
    }
  }
</script>

</html>
