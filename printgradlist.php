<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/materialize.css" />
  <link rel="stylesheet" type="text/css" href="css/print.css" />
  <script src="js/materialize.js"></script>
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto+Condensed" rel="stylesheet">
  <link rel="icon" href="images/plmlogo.png">
</head>

<body>
<div class="container center">
  <!-- If aysem, college = all/null, course = all/null -->
  <h1 class="print-title">List of Graduating Students</h1>
    <h2 class="print-subtitle">for S.Y. 2018-2019, 1st or 2nd Semester <!-- fetch what aysem --></h2>

    <table>
      <thead>
        <th>Student ID</th>
        <th>Name</th>
        <th>Course</th>
        <th>College</th>
      </thead>
      <tbody>
        <!-- fetch data -->
        <tr>
        <td>201502417</td>
        <td>Gregorio del Pilar</td>
        <td>BSCS-IT</td>
        <td>CET</td>
      </tr>
      </tbody>
    </table>
    <!-- end first condtion -->


    <!-- If aysem, college = a college, course = all/null -->
    <h1 class="print-title">List of Graduating Students</h1>
      <h2 class="print-subtitle">for S.Y. 2018-2019, 1st or 2nd Semester <!-- fetch what aysem -->
      <br>In the College of Engineering and Technology <!-- fetch what college --></h2>

      <table>
        <thead>
          <th>Student ID</th>
          <th>Name</th>
          <th>Course</th>
        </thead>
        <tbody>
          <!-- fetch data -->
          <tr>
          <td>201502417</td>
          <td>Gregorio del Pilar</td>
          <td>BSCS-IT</td>
        </tr>
        </tbody>
      </table>
      <!-- end second condtion -->


      <!-- If aysem, college = a college, course = a course -->
      <h1 class="print-title">List of Graduating Students</h1>
      <h2 class="print-subtitle">for S.Y. 2018-2019, 1st or 2nd Semester <!-- fetch what aysem -->
        <br>In the College of Engineering and Technology <!-- fetch what college -->
        <br>Bachelor of Science in Computer Studies Major in Information and Technology <!-- fetch what course --></h2>

        <table>
          <thead>
            <th>Student ID</th>
            <th>Name</th>
          </thead>
          <tbody>
            <!-- fetch data -->
            <tr>
            <td>201502417</td>
            <td>Gregorio del Pilar</td>
          </tr>
          </tbody>
        </table>
        <!-- end third condtion -->
  </div>
</body>
</html>
