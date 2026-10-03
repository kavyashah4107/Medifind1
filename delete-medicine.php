<?php

session_start();

include "config/database.php";


/* Check pharmacy login */

if (!isset($_SESSION["pharmacy_id"])) {

    echo "Please login first.";

    exit();

}


$pharmacyId = $_SESSION["pharmacy_id"];


/* Check availability ID */

if (!isset($_GET["id"])) {

    echo "Medicine ID is missing.";

    exit();

}


$availabilityId = $_GET["id"];


/* Delete only this pharmacy's availability */

$sql = "DELETE FROM medicine_availability

        WHERE id = '$availabilityId'

        AND pharmacy_id = '$pharmacyId'";


if (mysqli_query($conn, $sql)) {


    if (mysqli_affected_rows($conn) > 0) {

        header("Location: pharmacy-dashboard.php");

        exit();

    } else {

        echo "Medicine not found.";

    }


} else {

    echo "Medicine could not be deleted: "
         . mysqli_error($conn);

}

?>