<?php

include "config/database.php";

$name = $_POST["fullName"];
$email = $_POST["registerEmail"];
$mobile = $_POST["mobile"];
$password = $_POST["registerPassword"];
$account = $_POST["accountType"];


/* ==============================
   PHARMACY REGISTRATION
   ============================== */

if ($account == "pharmacy") {

    $pharmacyName = $_POST["pharmacyName"];
    $address = $_POST["address"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO pharmacies
            (pharmacy_name, address, phone, owner_name, email, password)
            VALUES
            ('$pharmacyName',
             '$address',
             '$mobile',
             '$name',
             '$email',
             '$hashedPassword')";

    if (mysqli_query($conn, $sql)) {

        $message = "Pharmacy registration successful!";

    } else {

        $message = "Registration failed: " . mysqli_error($conn);
    }


/* ==============================
   CUSTOMER REGISTRATION
   ============================== */

} else if ($account == "customer") {

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO customers
            (full_name, email, mobile, password)
            VALUES
            ('$name',
             '$email',
             '$mobile',
             '$hashedPassword')";

    if (mysqli_query($conn, $sql)) {

        $message = "Customer registration successful!";

    } else {

        $message = "Customer registration failed: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Registration - MediFind</title>

    <style>

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f7f7;

            display: flex;
            justify-content: center;
            align-items: center;

            min-height: 100vh;
        }

        .success-box {

            background-color: white;

            width: 400px;

            padding: 40px;

            text-align: center;

            border-radius: 15px;

            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .success-icon {

            font-size: 55px;

            margin-bottom: 15px;
        }

        .success-box h1 {

            color: #0f4c45;

            margin-bottom: 10px;
        }

        .success-box p {

            color: #666;

            font-size: 16px;
        }

        .loading {

            margin-top: 20px;

            color: #0f4c45;

            font-size: 14px;
        }

    </style>

</head>

<body>

    <div class="success-box">

        <div class="success-icon">✅</div>

        <h1>
            <?php echo htmlspecialchars($message); ?>
        </h1>

        <p>
            Your account has been created successfully.
        </p>

        <p class="loading">
            Redirecting to login page...
        </p>

    </div>


    <script>

        setTimeout(function() {

            window.location.href = "login.html";

        }, 2000);

    </script>

</body>

</html>