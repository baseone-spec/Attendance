<?php


include("./connect.php");

// Check if the "deleteid" parameter is present in the URL
if (isset($_GET['deleteid'])) {
    // Get the id to be deleted from the URL
    $delete_id = $_GET['deleteid'];

    // Create the DELETE query
    $delete_query = "DELETE FROM `base1-in-out` WHERE id = '$delete_id'";

    // Execute the query
    if ($con->query($delete_query) === TRUE) {


        header("Location: ./admin.php");
    } else {

        // echo "Error: " . $conn->error;
    }

    $con->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="">
    <title>Base One Industrial</title>

    <!-- css -->
    <link rel="stylesheet" href="./admin-style.css" />

    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Boxicons css -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!-- Bootstrap 5.0 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="./image/b1.png" alt="logo" />
                </span>

                <div class="text header-text">
                    <span class="name">Base One</span>
                    <span class="profession">Industrial Supply</span>
                </div>
            </div>

            <i class="bx bx-chevron-right toggle"></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <li class="nav-links">
                    <a href="">
                        <i class="bx bx-home-alt icon"></i>
                        <span class="text nav-text">Attendance</span>
                    </a>
                </li>
                <!-- <ul class="menu-links">
                    <li class="nav-links">
                        <a href="">
                            <i class="bx bxs-report icon"></i>
                            <span class="text nav-text"> QPS </span>
                        </a>
                    </li>

                    <li class="nav-links">
                        <a href="">
                            <i class="bx bx-package icon"></i>
                            <span class="text nav-text"> Suppliers </span>
                        </a>
                    </li>

                    <li class="nav-links">
                        <a href="">
                            <i class="bx bxs-bar-chart-alt-2 icon"></i>
                            <span class="text nav-text"> Analytics </span>
                        </a>
                    </li>

                    <li class="nav-links">
                        <a href="">
                            <i class="bx bxl-product-hunt icon"></i>
                            <span class="text nav-text">Products</span>
                        </a>
                    </li>
                </ul> -->
            </div>

            <div class="bottom-content">
                <p class="bottom-text">Options</p>
                <!-- <li class="">
                    <a href="">
                        <i class="bx bx-cog icon"></i>
                        <span class="text nav-text">Settings</span>
                    </a>
                </li> -->
                <li class="">
                    <a href="">
                        <i class="bx bx-log-out icon"></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>

    <section class="home" style="padding: 10px;">
        <div class="text">Welcome Gerardine!</div>

        <!-- table -->
        <div class="container">
            <div class="card" style="border-radius: 20px;">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Employee ID</th>
                            <th scope="col">Employee Name</th>
                            <th scope="col">Clock in</th>
                            <th scope="col">Clock out</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                              <th scope="col">Location</th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        include("./connect.php");


                        $result = mysqli_query($con, "SELECT * FROM `base1-in-out` ORDER BY ID DESC");

                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $emp_no = $row['emp_no'];
                            $emp_name = $row['emp_name'];
                            $clock_in = $row['clock_in'];
                            $clock_out = $row['clock_out'];
                            $status = $row['status'];
                            $date = $row['date'];

                            echo '
              
                  <tr class="centered-row">
                    <th scope ="row">' . $emp_no . '</td>
                    <td> ' . $emp_name .  '</td>
                    <td> ' . $clock_in .  '</td>
                    <td> ' . $clock_out . '</td>
                    <td> ' . $date . '</td>
                    <td> ' . $status . '</td>
                  
                    <td> <a href="./admin.php? deleteid=' . $id . '"><button class="btn"><i class="fa-solid fa-trash" style="color:black;"></i></button></a>
          ';
                        }

                        $con->close();


                        ?>
                        <!-- <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td colspan="2">Larry the Bird</td>
                            <td>@twitter</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>

    </section>


    <!-- javascript -->
    <script src="./script.js"></script>

    <!-- bootstrap -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>