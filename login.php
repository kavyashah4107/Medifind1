<?php

session_start();

include "config/database.php";

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";
$accountType = $_POST["accountType"] ?? "";


/* =========================
   CUSTOMER LOGIN
   ========================= */

if ($accountType == "customer") {

    $sql = "SELECT * FROM customers
            WHERE email = '$email'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {

        $customer = mysqli_fetch_array($result);

        if (password_verify($password, $customer["password"])) {

            // Store customer information in session
            $_SESSION["customer_id"] = $customer["id"];
            $_SESSION["customer_name"] = $customer["full_name"];

            // Customer goes to home page
            header("Location: index.html");
            exit();

        } else {

            echo "Incorrect customer password.";

        }

    } else {

        echo "Customer email not found.";

    }
}


/* =========================
   PHARMACY LOGIN
   ========================= */

else if ($accountType == "pharmacy") {

    $sql = "SELECT * FROM pharmacies
            WHERE email = '$email'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {

        $pharmacy = mysqli_fetch_array($result);

        if (password_verify($password, $pharmacy["password"])) {

            // Store pharmacy information in session
            $_SESSION["pharmacy_id"] = $pharmacy["id"];
            $_SESSION["pharmacy_name"] = $pharmacy["pharmacy_name"];

            // Pharmacy goes to dashboard
            header("Location: pharmacy-dashboard.php");
            exit();

        } else {

            echo "Incorrect pharmacy password.";

        }

    } else {

        echo "Pharmacy email not found.";

    }
}


/* =========================
   NO ACCOUNT TYPE
   ========================= */

else {

    echo "Please select Customer or Pharmacy.";

}

?>