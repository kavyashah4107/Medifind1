<?php

session_start();

include "config/database.php";


/* Check pharmacy login */

if (!isset($_SESSION["pharmacy_id"])) {

    echo "Please login first.";

    exit();

}


$pharmacyId = $_SESSION["pharmacy_id"];


/* Get form data */

$availabilityId = $_POST["availabilityId"];

$medicineId = $_POST["medicineId"];

$medicineName = $_POST["medicineName"];

$category = $_POST["category"];

$status = $_POST["status"];

$description = $_POST["description"];



/* Update medicine information */

$sql = "UPDATE medicines

        SET medicine_name = '$medicineName',
            category = '$category',
            description = '$description'

        WHERE id = '$medicineId'";


if (!mysqli_query($conn, $sql)) {

    echo "Medicine information could not be updated.";

    exit();

}



/* Update pharmacy availability */

$sql = "UPDATE medicine_availability

        SET status = '$status'

        WHERE id = '$availabilityId'

        AND pharmacy_id = '$pharmacyId'";


if (mysqli_query($conn, $sql)) {


    echo "<h2>Medicine updated successfully! 💊</h2>";


    echo "<p>";

    echo "Medicine: ";

    echo htmlspecialchars($medicineName);

    echo "</p>";


    echo "<p>";

    echo "Status: ";

    echo htmlspecialchars($status);

    echo "</p>";


    echo '<a href="pharmacy-dashboard.php">
            Go to Pharmacy Dashboard
          </a>';


} else {


    echo "Availability could not be updated: "
         . mysqli_error($conn);

}

?>