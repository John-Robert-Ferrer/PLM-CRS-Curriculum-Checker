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
    <h1 class="greet"> Hi Admin!<!-- INSERT ADMIN'S NAME --> </h1>
    <div class="divider"></div><br>
    <div class="row">
      <div class="col s12 m12 l4">
        <div class="card-panel admin-cards hoverable fac-card">
          <h2 class="sub-title">Faculty</h2><hr>
        </div>
      </div>

      <div class="col s12 m12 l4">
        <div class="card-panel admin-cards hoverable std-card">
          <h2 class="sub-title">Students</h2><hr>
        </div>
      </div>

      <div class="col s12 m12 l4">
        <div class="card-panel admin-cards hoverable total-card">
          <h2 class="sub-title">Total Population</h2><hr>
        </div>
      </div>

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
  });
  function myFunction() {
  location.reload();
  }
</script>

</html>
