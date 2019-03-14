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
    <h1 class="page-title">Generate Graduating List</h1>
    <hr><br>

    <!-- SELECT WHICH COLLEGE/COURSE TO PRINT -->
    <div class="row" id="menu">
      <div class="input-field col s12 m12 l6">
        <select id="college">
          <option value="" disabled selected>Select College</option>
          <?php
$query = "select studentterms.unitid, unitname from studentterms join units on units.unitid = studentterms.unitid where academiclevel = 2 group by studentterms.unitid";
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
      <div class="input-field col s12 m12 l6">
        <select id="aysem">
          <option value="" disabled selected>Select Aysem</option>
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
        <label>Aysem:</label>
      </div>
      <div class="input-field col s12 m12 l12" id="spaceForCourses">
        <select id="course" class="classCourse">
          <option value="" disabled selected>Select Course</option>
        </select>
        <label>Course:</label>
      </div>
      <div class="input-field col s12 m12 l12">
        <center>
        <button class="btn btn-large submit-btn tooltipped" data-position="right" data-tooltip="Generate Graduating List" id="generate-button">
          <i class="material-icons">send</i>
        </button>
        </center>
      </div>
    </div>

    <div id="StudentDeficiencyTable" style="height: 20vh; overflow: auto;"></div>

    <div class="progress loader" id="loader" style="background: white;">
        <div class="indeterminate" style="background: #B71C1C;"></div>
    </div>
    <h5 id="loading_value" class="loader" style="text-align: center; color: #B71C1C;">0.00%</h5>

    <br>
    <div class="row">
      <div class="col s5"></div>
      <div class="col s7 m7 l7"><button class="btn btn-large submit-btn tooltipped" data-position="right" data-tooltip="View Graduating List" id="print-button">
        <i class="material-icons">view_list</i></button></div>
    </div>

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

    // initialize
    $('.classCourse').formSelect();
    $('.loader').hide();
    $('#print-button').hide();

    // setup listener for custom event to re-initialize on change
    $('.classCourse').on('contentChanged', function() {
      $(this).formSelect();
    });

    $('#college').change(function(){
      var unitid = $('#college').val();
      updateCourses(unitid);
    });

    $('#generate-button').click(function(){
      var college = $('#college').val();
      var course = $('#course').val();
      var aysem = $('#aysem').val();

      if(aysem == null || course == null || college == null)
        swal('Please complete all the details','','warning');
      else
      {
        $('#menu').hide();
        $('#StudentDeficiencyTable').css("height","52vh");
        $('#loader').css("margin-top", "5vh");
        $('.loader').show();
        showTable(college, course, aysem);
      }
    });

    $('#print-button').click(function(){
      var college = $('#college').val();
      var course = $('#course').val();
      var aysem = $('#aysem').val();
      location = "viewgradlist.php?initialvalues="+college+","+course+","+aysem;
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

  function showTable(college, course, aysem){
    $('#StudentDeficiencyTable').html('');
    $('#print-button').hide();

    var limit = 999999;

    $.ajax({
        url:"shared_functions_0.php",
        method:"POST",
        data:{
          category: "generate graduating students get all students",
          unitid: college,
          programid: course,
          aysem: aysem
        },
        dataType:"json",
        success:function(data){
          var students_id = data;
          var counter = 0;
          console.log(students_id.length);
          console.log(students_id);

          if(students_id.length != 0)
          {
            for(var i=0; i<students_id.length; i++)
            {
                $.ajax({
                    url:"shared_functions_0.php",
                    type:"POST",
                    async: true,
                    data: {
                        category: "generate graduating students generate this student",
                        student_id:students_id[i],
                        limit:limit,
                        aysem:aysem
                    },
                    success:function(data){
                        var div = document.getElementById('StudentDeficiencyTable');
                        div.innerHTML += data;
                        div.scrollTop = div.scrollHeight;

                        // console.log(counter++);
                        $('#loading_value').html((( ( ++counter / students_id.length ) * 100).toFixed(2) + '%'));
                    }
                });

                $(document).ajaxStop(function() {
                  $('.loader').hide();
                  $('#print-button').show();
                });
            } // end of for loop
          }//end of if statement
          else
          {
            $('.loader').hide();
            $('#StudentDeficiencyTable').html('No enrolled students found on that particular AYSEM..');
          }
        } // end of ajax
    }); // end of showtable function
  }
</script>

</html>
