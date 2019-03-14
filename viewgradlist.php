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
  <link rel="stylesheet" href="css/print.css">

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
  <h1 class="page-title">List of Graduating Students</h1>
    <hr><br>


    <!-- SELECT WHICH COLLEGE/COURSE TO PRINT -->
    <div class="row">
      <div class="input-field col s12 m12 l4" id="spaceForAysem">
        <select id="aysem" class="classAysem">
          <option value="" disabled selected>Select Aysem</option>
          <option value="20182">20182</option>
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

      <div class="input-field col s12 m12 l4 college">
        <select id="college">
          <option value="" disabled selected>Select College</option>
          <?php
$query = "select studentterms.unitid, unitname from studentterms join units on units.unitid = studentterms.unitid where aysem = 20172 and academiclevel = 2 and studentterms.unitid not in (15,17) group by studentterms.unitid ORDER BY units.unit ASC";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<option value='all_students'>ALL COLLEGE</option>";
    while ($row = mysqli_fetch_row($result)) {
        echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
    }

}
?>
        </select>
        <label>College:</label>
      </div>

      <div class="input-field col s12 m12 l4 course" id="spaceForCourses">
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
<script src="js/sweetalert2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.sidenav').sidenav();
    $('.tooltipped').tooltip();
    $('select').formSelect();

    // initialize
    $('.classCourse').formSelect();
    $('#loader').hide();
    $('#print-button').hide();

    // GET INITIAL VALUES
    getInitialValues();

    // setup listener for custom event to re-initialize on change
    $('.classCourse').on('contentChanged', function() {
      $(this).formSelect();
    });

    $('#aysem').change(function(){
      $('#course').prop("disabled", false);
      $('select').formSelect();
    });

    $('#college').change(function(){
      var unitid = $('#college').val();
      var aysem = $('#aysem').val();

      if(aysem == null)
      {
        $('.course').hide();
        swal(
          'Oops',
          'Seems like AYSEM has no value. Please select first the AYSEM.',
          'error'
        ).then((result) => {
          location.reload();
        })
      }
      else
      {
        if(unitid == "all_students")
        {
          $('.course').hide();
          showTable(1111,1111,aysem);
        }
        else
        {
          $('.course').show();
          updateCourses(unitid);
        }
      }
    });

    $('#course').change(function(){
      var college = $('#college').val();
      var course = $('#course').val();
      var aysem = $('#aysem').val();

      $('#loader').show();
      showTable(college, course, aysem);
    });

    $('#print-button').click(function(){
      var college = $('#college').val();
      var course = $('#course').val();
      var aysem = $('#aysem').val();
      location = "print.php?aysem=" + aysem + "&college=" + college + "&course=" + course;
    });
  });

  function myFunction() {
    location.reload();
  }

  function getInitialValues(){
    var initialid = $_GET('initialvalues');
    initialid = initialid.split(',');
    var college = initialid[0];
    var course = initialid[1];
    var aysem = initialid[2];

    if(college != null && course != null && aysem != null)
      setThisInitialValues(college, course, aysem);
    if("<?php echo $_SESSION['user_type']; ?>" == "Dean" || "<?php echo $_SESSION['user_type']; ?>" == "Chairperson")
    {
      $('#college').prop("disabled", true);
      $('#course').prop("disabled", true);
      $('#college').val(11);
      college = 11;
      $('select').formSelect();
      updateCourses(college);
    }
  }

  function setThisInitialValues(college, course, aysem){
    $('#college').val(college);
    updateCourses(college);
    $('#course').val(course);
    $('#aysem').val(aysem);

    $('#loader').show();
    showTable(college, course, aysem);
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
            if(i==0)
            {
              var $newCourses = $("<option>").attr("value","all_courses").text("ALL STUDENTS IN COLLEGE");
              $("#course").append($newCourses);
            }

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
    $.ajax({
        url:"shared_functions_0.php",
        method:"POST",
        data:{
          category: "view list of graduating students show table",
          unitid: college,
          programid: course,
          aysem: aysem
        },
        success:function(data){
          $('#loader').hide();
          $('#StudentDeficiencyTable').html(data);

          if(data != "<h5 style='text-align: center;'>Opps! No data found..</h5>")
            $('#print-button').show();
        }
    });
  }

  function $_GET(q,s) {
      s = (s) ? s : window.location.search;
      var re = new RegExp('&amp;'+q+'=([^&amp;]*)','i');
      return (s=s.replace(/^\?/,'&amp;').match(re)) ?s=s[1] :s='';
  }
</script>

</html>
