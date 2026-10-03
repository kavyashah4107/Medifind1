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

$pharmacyName = trim($_POST["pharmacyName"] ?? "");

$ownerName = trim($_POST["ownerName"] ?? "");

$email = trim($_POST["email"] ?? "");

$phone = trim($_POST["phone"] ?? "");

$address = trim($_POST["address"] ?? "");


/* Check required fields */

if ($pharmacyName === "" || $address === "") {

    echo "Pharmacy name and address are required.";
    exit();

}


/* Update pharmacy */

$sql = "UPDATE pharmacies

        SET pharmacy_name = '$pharmacyName',
            owner_name = '$ownerName',
            email = '$email',
            phone = '$phone',
            address = '$address'

        WHERE id = '$pharmacyId'";


if (mysqli_query($conn, $sql)) {


    /* Update session pharmacy name */

    $_SESSION["pharmacy_name"] = $pharmacyName;


    echo "<h2>Pharmacy profile updated successfully! ✅</h2>";

    echo "<p>";

    echo "Pharmacy Name: "
         . htmlspecialchars($pharmacyName);

    echo "</p>";


    echo "<p>";

    echo "Address: "
         . htmlspecialchars($address);

    echo "</p>";


    echo '<br>';

    echo '<a href="pharmacy-profile.php">
            View Profile
          </a>';


    echo '<br><br>';

    echo '<a href="pharmacy-dashboard.php">
            Go to Dashboard
          </a>';


} else {


    echo "Profile could not be updated: "
         . mysqli_error($conn);

}

?>