<?php

include("./connect.php");

// mysqli_close($con);

// add in the database

// b1-2501 = AD
// b1-2502 = RED
// b1-2503 = KAREN

if (isset($_POST["submit"])) {

  $emp_no = $_POST["emp_no"];
  $id = 0;

  // Set timezone to Philippines
  date_default_timezone_set('Asia/Manila');

  $employees = [
    'b1-2501' => 'Adrian Makiling',
    'b1-2502' => 'Red Mateo',
    'b1-2503' => 'Karen Pariño'
  ];

  if (array_key_exists($emp_no, $employees)) {
    $emp_name = $employees[$emp_no];


    // $desired_date_time = '20/07/2025 10:23 AM';
    // $date_time_obj = DateTime::createFromFormat('d/m/Y h:i A', $desired_date_time);
    $now = new DateTime();
    $formatted_date_time = $now->format('Y-m-d H:i:s');
    $formatted_custom_date = $now->format('Y/j/n l');
    $formatted_time = $now->format('h:i A');
    $today_date = $now->format('Y-m-d');
    // Check if employee already clocked in today

    // Define the threshold time (9:00 AM)
    $threshold = new DateTime('09:00');

    $status = ($now > $threshold) ? 'Hala na late!' : 'Pabida ka a!';

    $stmt = $con->prepare("SELECT id, emp_no, clock_out FROM `base1-in-out` WHERE emp_no = ? AND DATE(date) = ?");
    $stmt->bind_param("ss", $emp_no, $formatted_custom_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      // Already clocked in
      $row = $result->fetch_assoc();

      if (empty($row['clock_out'])) {
        // Update existing row with clock-out time
        $update = $con->prepare("UPDATE `base1-in-out` SET clock_out = ? WHERE emp_no = ?");
        $update->bind_param("si", $formatted_time, $row['emp_no']);
        $update->execute();

        echo "<script>
          window.onload = function() {
            Swal.fire({
              icon: 'success',
              title: 'Clocked Out',
              text: 'Clock-out recorded for $emp_name at $formatted_time.',
              timer: 2500,
              showConfirmButton: false
            });
          }
        </script>";

        // echo "<script>alert('Clock-out recorded for $emp_name at $formatted_time.');</script>";
      } else {
        // echo "<script>alert('$emp_name already clocked in and out today.');</script>";
        echo "<script>
          window.onload = function() {
            Swal.fire({
              icon: 'info',
              title: 'Already Clocked Out',
              text: '$emp_name already clocked in and out today.',
              timer: 2500,
              showConfirmButton: false
            });
          }
        </script>";
      }
    } else {
      // First time today — insert clock-in
      $insert = $con->prepare("INSERT INTO `base1-in-out` (id, emp_no, emp_name, clock_in, clock_out, status, date) VALUES (?, ?, ?, ?, '', ?, ?)");
      $insert->bind_param("ssssss", $id, $emp_no, $emp_name, $formatted_time, $status, $formatted_custom_date);
      $insert->execute();

      // echo "<script>alert('Clock-in recorded for $emp_name at $formatted_time.');</script>";
      echo "<script>
          window.onload = function() {
            Swal.fire({
              icon: 'success',
              title: 'Clock-in',
              text: 'recorded for $emp_name at $formatted_time.',
              timer: 2500,
              showConfirmButton: false
            });
          }
        </script>";
    }
  } else {
    echo "Invalid employee number.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OMM CITRA CLock IN/OUT</title>

  <link href="./style.css" rel="stylesheet" />

  <!-- font-awesome  -->
  <script
    type="module"
    src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script
    nomodule
    src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <!-- sweet alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Bootstrap 5.0 -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous" />
</head>

<body style="background-color:#242424; ">

  <div class="card">
    <div class="card-body">




      <div class="image-logo mb-4">
        <img src="./image/base1 logo.png" alt="" style="width: 220px;">
      </div>
      <p class="text-center">GOOD DAY! BASE ONE EMPLOYEE'S!</p>

      <div class="text-center fw-bold" style="font-size: 20px;">
        <?php

        include("./connect.php");
        $now = new DateTime();
        $formatted_custom_date = $now->format('Y/j/n l');

        echo $formatted_custom_date;


        ?>
        <br>
        <!-- company address -->
        <span id="location-text" class="limited-lines">Detecting location...</span>
        <!-- OMM-CITRA BUILDING, SAN MIGUEL AVE PASIG CITY -->
      </div>

      <!-- form input -->
      <form method="POST" action="" class="form-floating mt-5">
        <!-- <div class="form-floating mb-3">
          <input type="text" class="form-control" id="emp_no_1" name="emp_name" placeholder="Employee #" />
          <label for="emp_name">Insert employee name</label>
        </div> -->

        <div class="form-floating mb-3" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
          <input type="text" class="form-control" id="emp_no_2" name="emp_no" placeholder="Employee #" />
          <label for="emp_no">Please input employee's ID</label>
        </div>


        <div class="btn-group mt-3">
          <button type="submit" name="submit" class="btn btn-dark me-2">Clock in</button>
          <button type="submit" name="submit" class="btn btn-dark ">Clock out</button>

        </div>


      </form>


    </div>

  </div>

  <!-- maps -->
  <script>
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(async function(position) {
          const lat = position.coords.latitude;
          const lon = position.coords.longitude;

          // Use OpenStreetMap's Nominatim API to reverse geocode
          const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`);
          const data = await response.json();

          const address = data.display_name || "Location not found";
          document.getElementById('location-text').textContent = address;
        },
        function(error) {
          document.getElementById('location-text').textContent = "Unable to detect location";
        });
    } else {
      document.getElementById('location-text').textContent = "Geolocation not supported";
    }
  </script>
  <!-- bootstrap -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>

</html>