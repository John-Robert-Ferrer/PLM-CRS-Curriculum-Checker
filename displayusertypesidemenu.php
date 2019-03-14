<?php
$output = '';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_type = $_SESSION['user_type'];

if ($user_type == 'admin') {
    $output = ' <ul id="slide-out" class="sidenav">
                        <li>
                        <div class="user-view">
                            <p class="user-type">Admin</p>
                        </div>
                        </li>
                        <li><a href="admin.php"><i class="material-icons">home</i>Home</a></li>
                        <li><a href="accreditation.php"><i class="material-icons">edit</i>Accreditations</a></li>
                        <li><a href="crossenrol.php"><i class="material-icons">edit</i>Cross Enrollees</a></li>
                        <li><a class="olapmenu" href="viewstd.php"><i class="material-icons">search</i>View Student Information</a></li>
                        <li><a class="olapmenu" href="stddefi.php"><i class="material-icons">list</i>Students with Deficiencies</a></li>
                        <li><a class="olapmenu" href="gengrad.php"><i class="material-icons">list</i>Generate Graduating List</a></li>
                        <li><a href="viewgradlist.php"><i class="material-icons">list</i>View Graduating List</a></li>
                        <li><a href="logs.php"><i class="material-icons">list</i>Logs</a></li>
                        <li><a href="logout.php"><i class="material-icons">exit_to_app</i>Log-Out</a></li>
                    </ul>';
} else if ($user_type == "Dean" || $user_type == "Faculty") {
    $output = ' <ul id="slide-out" class="sidenav">
                          <li>
                          <div class="user-view">
                              <p class="user-type">Dean</p>
                          </div>
                          </li>
                          <li><a href="faculty.php"><i class="material-icons">home</i>Home</a></li>
                          <li><a class="olapmenu" href="viewstd.php"><i class="material-icons">search</i>View Student Information</a></li>
                          <li><a class="olapmenu" href="stddefi.php"><i class="material-icons">list</i>Students with Deficiencies</a></li>
                          <li><a href="viewgradlist.php"><i class="material-icons">list</i>Graduating List</a></li>
                          <li><a href="logout.php"><i class="material-icons">exit_to_app</i>Log-Out</a></li>
                      </ul>
                      <ul>';
} else if ($user_type == "faculty") {
    $output = ' <ul id="slide-out" class="sidenav">
                        <li>
                        <div class="user-view">
                            <p class="user-type">Faculty</p>
                        </div>
                        </li>
                        <li><a href="faculty.php"><i class="material-icons">home</i>Home</a></li>
                        <li><a class="olapmenu" href="viewstd.php"><i class="material-icons">search</i>View Student Information</a></li>
                        <li><a class="olapmenu" href="stddefi.php"><i class="material-icons">list</i>Students with Deficiencies</a></li>
                        <li><a href="viewgradlist.php"><i class="material-icons">list</i>Graduating List</a></li>
                        <li><a href="logout.php"><i class="material-icons">exit_to_app</i>Log-Out</a></li>
                    </ul>
                    <ul>';
} else if ($user_type == "regular student") {
    $output = ' <ul id="slide-out" class="sidenav">
                        <li>
                        <div class="user-view">
                            <p class="user-type">Student</p>
                        </div>
                        </li>
                        <li><a href="std-1.php"><i class="material-icons">home</i>Home</a></li>
                        <li><a href="view_checklist.php"><i class="material-icons">insert_drive_file</i>View Checklist</a></li>

                        <li><a href="logout.php"><i class="material-icons">exit_to_app</i>Log-Out</a></li>
                    </ul>';
} else if ($user_type == "irregular student") {
    $output = ' <ul id="slide-out" class="sidenav">
                        <li>
                        <div class="user-view">
                            <p class="user-type">Student</p>
                        </div>
                        </li>
                        <li><a href="std-1.php"><i class="material-icons">home</i>Home</a></li>
                        <li><a href="view_checklist.php"><i class="material-icons">insert_drive_file</i>View Checklist</a></li>
                        <li><a href="viewlistofdef.php"><i class="material-icons">list</i>List of Deficiencies</a></li>
                        <li><a href="logout.php"><i class="material-icons">exit_to_app</i>Log-Out</a></li>
                    </ul>';
}

echo $output;
