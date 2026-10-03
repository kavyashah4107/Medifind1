<?php

session_start();

include "config/database.php";

if (!isset($_SESSION["pharmacy_id"])) {
    echo "Please login first.";
    exit();
}

$pharmacyId = $_SESSION["pharmacy_id"];

$medicineName = $_POST["medicineName"];
$category = $_POST["category"];
$status = $_POST["status"];
$description = $_POST["description"];


/* Step 1: Check whether medicine already exists */

$sql = "SELECT * FROM medicines
        WHERE medicine_name = '$medicineName'";

$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {

    $medicine = mysqli_fetch_array($result);

    $medicineId = $medicine["id"];

} else {

    /* Step 2: Add new medicine */

    $sql = "INSERT INTO medicines
            (medicine_name, category, description)
            VALUES
            ('$medicineName', '$category', '$description')";

    if (mysqli_query($conn, $sql)) {

        $medicineId = mysqli_insert_id($conn);

    } else {

        echo "Medicine could not be added.";
        exit();
    }
}


/* Step 3: Check whether this pharmacy
   already has this medicine */

$checkSql = "SELECT id
             FROM medicine_availability
             WHERE medicine_id = '$medicineId'
             AND pharmacy_id = '$pharmacyId'";

$checkResult = mysqli_query($conn, $checkSql);


if (!$checkResult) {

    echo "Database error: " . mysqli_error($conn);
    exit();

}


/* Medicine already exists for this pharmacy */

if (mysqli_num_rows($checkResult) > 0) {

    $existing = mysqli_fetch_assoc($checkResult);

    $availabilityId = $existing["id"];


    /* Update existing availability */

    $sql = "UPDATE medicine_availability
            SET status = '$status'
            WHERE id = '$availabilityId'
            AND pharmacy_id = '$pharmacyId'";


    if (mysqli_query($conn, $sql)) {

        echo "<h2>Medicine availability updated! 💊</h2>";

        echo "<p>Medicine: "
             . htmlspecialchars($medicineName)
             . "</p>";

        echo "<p>Status: "
             . htmlspecialchars($status)
             . "</p>";

        echo '<a href="pharmacy-dashboard.php">
                Go to Pharmacy Dashboard
              </a>';

    } else {

        echo "Availability could not be updated: "
             . mysqli_error($conn);

    }


} else {


    /* Add new availability */

    $sql = "INSERT INTO medicine_availability
            (medicine_id, pharmacy_id, status)
            VALUES
            ('$medicineId', '$pharmacyId', '$status')";


    if (mysqli_query($conn, $sql)) {

        echo "<h2>Medicine added successfully! 💊</h2>";

        echo "<p>Medicine: "
             . htmlspecialchars($medicineName)
             . "</p>";

        echo "<p>Status: "
             . htmlspecialchars($status)
             . "</p>";

        echo '<a href="pharmacy-dashboard.php">
                Go to Pharmacy Dashboard
              </a>';

    } else {

        echo "Availability could not be saved: "
             . mysqli_error($conn);

    }

}


if (mysqli_query($conn, $sql)) {

    echo "<h2>Medicine added successfully! 💊</h2>";

    echo "<p>Medicine: " . htmlspecialchars($medicineName) . "</p>";

    echo "<p>Status: " . htmlspecialchars($status) . "</p>";

    echo '<a href="pharmacy-dashboard.php">
            Go to Pharmacy Dashboard
          </a>';

} else {

    echo "Availability could not be saved: "
         . mysqli_error($conn);
}

?>