<?php include "dbconfig.php";?>
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
    <h1 class="page-title">List of Students with Deficiencies</h1>
    <hr><br>

    <!-- SELECT WHICH COLLEGE/COURSE TO PRINT -->
    <div class="row">
      <div class="input-field col s12 m12 l6">
        <select id="college">
          <option value="" disabled selected>Select College</option>
          <?php
$query = "select studentterms.unitid, unitname from studentterms join units on units.unitid = studentterms.unitid where aysem = 20172 and academiclevel = 2 and studentterms.unitid not in (15,17) group by studentterms.unitid ORDER BY units.unit ASC";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_row($result)) {
        echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
    }

}
?>
        </select>
        <label>College:</label>
      </div>
      <div class="input-field col s12 m12 l6" id="spaceForCourses">
        <select id="course" class="classCourse">
          <option value="" disabled selected>Select Course</option>
        </select>
        <label>Course:</label>
      </div>
    </div>
    <div class="tbl-div"><div id="StudentDeficiencyTable"></div></div>
    <div class="progress" id="loader" style="background: white;">
        <div class="indeterminate" style="background: #B71C1C;"></div>
    </div>
    <br>
    <div class="row">
      <div class="col s5"></div>
      <div class="col s7 m7 l7"><button class="btn btn-large submit-btn tooltipped" data-position="right" data-tooltip="Print" id="print-button">
        <i class="material-icons">print</i></button></div>
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
    $('select').formSelect();

    // initialize
    $('.classCourse').formSelect();
    $('#loader').hide();
    $('#print-button').hide();

    if("<?php echo $_SESSION['user_type']; ?>" == "dean")
    {
      $('#college').prop("disabled", true);
      $('#college').val(11);
      college = 11;
      $('select').formSelect();
      updateCourses(college);
    }

    // setup listener for custom event to re-initialize on change
    $('.classCourse').on('contentChanged', function() {
      $(this).formSelect();
    });

    $('#college').change(function(){
      var unitid = $('#college').val();
      updateCourses(unitid);
    });

    $('#course').change(function(){
      var college = $('#college').val();
      var course = $('#course').val();

      $('#loader').show();
      showTable(college, course);
    });

    $('#print-button').click(function(){
      location = "print.php?unitid=11&programid=33";
    });
  });

  function myFunction() {
    location.reload();
  }

  function updateCourses(unitid){
    var output = '';
    $('#StudentDeficiencyTable').html('');
    $('#print-button').hide();

    // initialize
    $('.classCourse').empty();

    $.ajax({
        url:"shared_functions_0.php",
        method:"POST",
        data:{
          category: "student deficiencies filter get courses",
          unitid: unitid
        },
        success:function(data){
          var courses = data.split('|||');

          var $newCourses = $("<option>").attr("disabled",true).attr("selected",true).text("Select Course")
          $("#course").append($newCourses);

          // fire custom event anytime you've updated select
          $("#course").trigger('contentChanged');

          for(var i=0; i<(courses.length-1); i++)
          {
            var splitEachDataInCourses = courses[i].split('|');

            var $newCourses = $("<option>").attr("value",splitEachDataInCourses[0]).text(splitEachDataInCourses[1])
            $("#course").append($newCourses);

            // fire custom event anytime you've updated select
            $("#course").trigger('contentChanged');
          }
        }
    });
  }

  function showTable(college, course){
    $('#StudentDeficiencyTable').html('');
    $('#print-button').hide();
    $.ajax({
        url:"shared_functions_0.php",
        method:"POST",
        data:{
          category: "student deficiencies fetch students with deficiencies",
          unitid: college,
          programid: course
        },
        success:function(data){
          $('#loader').hide();
          $('#StudentDeficiencyTable').html(data);

          if(data != "<h5 style='text-align: center;'>Opps! No data found..</h5>")
            $('#print-button').show();
        }
    });
  }
</script>

</html>
