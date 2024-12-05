<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/displayInfo.css">
    <title>Display Students-Class</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Coustard|Lato&display=swap" rel="stylesheet">

    <style>
        body {
            background-image: url(../style/images/back_img1.jpg);
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>
<!-- Code adapted from Yassein, 2020 -->
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="../home.php">
                <h1 class="text-center navtitle">Tuition Management</h1>
            </a>

            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="navbar-toggler-icon" id="navbardrop" data-toggle="dropdown"></a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="../insert_data/main_insert.php">Add Data</a>
                        <a class="dropdown-item" href="../display_data/main_search.php">Search Data</a>
                        <a class="dropdown-item" href="../reset_pwd.php">Change Password</a>
                        <a class="dropdown-item" href="../logout.php">Logout</a>
                    </div>

                </li>
            </ul>
        </div>
    </nav>

    <div class="container-box mt-2">

        <?php

        session_start();

        // Code adapted from Yani, 2017
        // Make sure the user is logged in to the account
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            echo "<br/>"."Please Login"."<br/>";
            exit;
        }
        // End of adapted code

        include("../dbconf.php");

        // Retrieve the classID
        $classID = isset($_GET['studentGroupsID']) && is_numeric($_GET['studentGroupsID']) ? (int)$_GET['studentGroupsID'] : 0;

        if ($classID === 0) {
            die('<p class="alert alert-danger text-center">Error: ClassID is missing or invalid.</p>');
        }

        // Fetch the student details for the classID
        $fetchQuery = "
            SELECT sg.studentGroupsID, s.studentID, s.fullName
            FROM studentgroups sg
            JOIN students s ON sg.studentID = s.studentID
            WHERE sg.classID = {$classID}
              AND sg.tuitionID = {$_SESSION['tuitionID']}
        ";
        $resultData = mysqli_query($link, $fetchQuery);

        // Display the student table
        echo '<table class="table table-bordered table-striped table-light">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Student</th>';
        echo '<th>Delete</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Check if the query returned any rows
        if ($resultData && mysqli_num_rows($resultData) > 0) {
            while ($row = mysqli_fetch_assoc($resultData)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['studentID']) . "</td>";
                echo "<td>" . htmlspecialchars($row['fullName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date_of_birth']) . "</td>";
                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                echo "<td><a href=\"../delete_data/delete_students_class.php?studentID=" . $row['studentID'] . "\" class='btn'>Delete</a></td>";
                echo "</tr>";
            }
        } 

        echo '</tbody>';
        echo '</table>';

        mysqli_close($link);

        ?>

    </div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>
